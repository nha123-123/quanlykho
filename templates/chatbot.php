<?php
header('Content-Type: application/json');

// Kiểm tra message từ người dùng
if (!isset($_POST['message']) || empty(trim($_POST['message']))) {
    echo json_encode(['reply' => 'Vui lòng nhập câu hỏi.']);
    exit;
}

$message = trim($_POST['message']);
$apiKey = 'AIzaSyDk-uPeZQ5z6rgUFwA06iuKDRuvH1X0VwE';
$model = 'gemini-2.0-flash';

// Prompt yêu cầu GPT xác định intent (bổ sung ví dụ JSON để API trả về đúng định dạng)
$prompt = "Câu hỏi người dùng: \"$message\". Nếu đây là một trong các yêu cầu sau, hãy trả lời JSON với các trường 'intent', 'reply' và nếu có thì thêm 'product':\n"
    . "- Tồn kho sản phẩm\n- Đơn nhập gần nhất\n- Đơn xuất gần nhất\n- Sản phẩm sắp hết hàng\n"
    . "Nếu không liên quan, hãy trả lời với intent là 'general' và thêm phản hồi tự nhiên của bạn trong 'reply'.\n"
    . "Ví dụ trả về: {\"intent\": \"get_stock\", \"product\": \"Sữa tươi\", \"reply\": \"Tồn kho sản phẩm Sữa tươi là 50\"}";

// Gọi API Google Gemini
$apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=$apiKey";
$options = [
    'http' => [
        'header' => "Content-Type: application/json\r\n",
        'method' => 'POST',
        'content' => json_encode([
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ])
    ]
];
$context = stream_context_create($options);
$response = @file_get_contents($apiUrl, false, $context);

if (!$response) {
    echo json_encode(['reply' => 'Lỗi khi gọi API Google Gemini.']);
    exit;
}

$data = json_decode($response, true);

// Trích xuất và xử lý nội dung JSON từ phản hồi
if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
    $textContent = $data['candidates'][0]['content']['parts'][0]['text'];
    // Loại bỏ ```json và ``` để lấy nội dung JSON thuần túy
    if (preg_match('/```json\s*([\s\S]*?)\s*```/', $textContent, $matches)) {
        $jsonContent = trim($matches[1]);
        $parsedData = json_decode($jsonContent, true);
        if (is_array($parsedData)) {
            $data = $parsedData;
        }
    }
}

// Nếu không phải mảng hoặc không có trường reply/intent, trả về lỗi rõ ràng kèm nội dung API trả về để dễ debug
if (!is_array($data) || (!isset($data['reply']) && !isset($data['intent']))) {
    echo json_encode(['reply' => 'Bot không trả về dữ liệu hợp lệ. Phản hồi API: ' . $response]);
    exit;
}

// ...phần còn lại giữ nguyên...

$intent = $data['intent'] ?? 'general';
$product = $data['product'] ?? null;
$aiReply = $data['reply'] ?? '';

// Nếu không phải intent liên quan hàng hóa → trả lời AI
if (!in_array($intent, ['get_stock', 'get_last_import', 'get_last_export', 'low_stock'])) {
    echo json_encode(['reply' => $aiReply ?: 'Bot không có phản hồi.']);
    exit;
}

// Nếu là intent liên quan đến hàng hóa → xử lý CSDL
try {
    $pdo = new PDO('mysql:host=localhost;dbname=quanlykho;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    switch ($intent) {
        case 'get_stock':
            if ($product) {
                $stmt = $pdo->prepare("SELECT soluongton FROM sanpham WHERE tensp LIKE ?");
                $stmt->execute(["%$product%"]);
                $row = $stmt->fetch();
                if ($row) {
                    $soLuong = $row['soluongton'];
                    $reply = "Tồn kho hiện tại của sản phẩm \"$product\" là $soLuong.";
                } else {
                    $reply = "Không tìm thấy sản phẩm \"$product\".";
                }
            } else {
                $reply = "Vui lòng cung cấp tên sản phẩm để kiểm tra tồn kho.";
            }
            break;

        case 'get_last_import':
            $stmt = $pdo->query("SELECT pn.maphieunhap, pn.ngaynhap, tk.taikhoan1 AS nguoinhap
                                 FROM phieunhap pn
                                 JOIN taikhoan tk ON tk.id = pn.id_nguoinhap
                                 ORDER BY pn.ngaynhap DESC LIMIT 1");
            $row = $stmt->fetch();
            if ($row) {
                $stmt2 = $pdo->prepare("SELECT SUM(soluongnhap) as tongsl FROM chitietphieunhap WHERE maphieunhap = ?");
                $stmt2->execute([$row['maphieunhap']]);
                $row2 = $stmt2->fetch();
                $tongsl = $row2 ? $row2['tongsl'] : 0;
                $reply = "Đơn nhập gần nhất: Mã: {$row['maphieunhap']}, Ngày: {$row['ngaynhap']}, Người nhập: {$row['nguoinhap']}, Tổng SL: $tongsl.";
            } else {
                $reply = "Không có đơn nhập nào.";
            }
            break;

        case 'get_last_export':
            $stmt = $pdo->query("SELECT dh.id, dh.ngayxuat, tk.taikhoan1 AS nhanvien
                                 FROM donhang dh
                                 JOIN taikhoan tk ON tk.id = dh.id_nhanvien
                                 ORDER BY dh.ngayxuat DESC LIMIT 1");
            $row = $stmt->fetch();
            if ($row) {
                $stmt2 = $pdo->prepare("SELECT SUM(soluong) as tongsl FROM donhangchitiet WHERE id_donhang = ?");
                $stmt2->execute([$row['id']]);
                $row2 = $stmt2->fetch();
                $tongsl = $row2 ? $row2['tongsl'] : 0;
                $reply = "Đơn xuất gần nhất: Mã: {$row['id']}, Ngày: {$row['ngayxuat']}, Nhân viên: {$row['nhanvien']}, Tổng SL: $tongsl.";
            } else {
                $reply = "Không có đơn xuất nào.";
            }
            break;

        case 'low_stock':
            $stmt = $pdo->query("SELECT tensp, soluongton FROM sanpham WHERE soluongton < 10 ORDER BY soluongton ASC");
            $rows = $stmt->fetchAll();
            if ($rows) {
                $reply = "Sản phẩm sắp hết hàng:\n";
                foreach ($rows as $row) {
                    $reply .= "- {$row['tensp']}: {$row['soluongton']} cái\n";
                }
            } else {
                $reply = "Hiện tại không có sản phẩm nào sắp hết hàng.";
            }
            break;
        default:
            $reply = "Xin lỗi, tôi không hiểu yêu cầu.";
    }
    // Trả về thêm dữ liệu bảng nếu có yêu cầu
    if (isset($_POST['table_data']) && $_POST['table_data'] === '1') {
        $tableData = [];
        switch ($intent) {
            case 'get_stock':
                if ($product) {
                    $stmt = $pdo->prepare("SELECT * FROM sanpham WHERE tensp LIKE ?");
                    $stmt->execute(["%$product%"]);
                    $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                break;
            case 'get_last_import':
                if (isset($row['maphieunhap'])) {
                    $stmt = $pdo->prepare("SELECT * FROM chitietphieunhap WHERE maphieunhap = ?");
                    $stmt->execute([$row['maphieunhap']]);
                    $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                break;
            case 'get_last_export':
                if (isset($row['id'])) {
                    $stmt = $pdo->prepare("SELECT * FROM donhangchitiet WHERE id_donhang = ?");
                    $stmt->execute([$row['id']]);
                    $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                break;
            case 'low_stock':
                $stmt = $pdo->query("SELECT * FROM sanpham WHERE soluongton < 10 ORDER BY soluongton ASC");
                $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                break;
                case 'get_all_products':
                    $stmt = $pdo->query("SELECT * FROM sanpham ORDER BY tensp ASC");
                    $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    break;
                case 'get_all_imports':
                    $stmt = $pdo->query("SELECT * FROM phieunhap ORDER BY ngaynhap DESC");
                    $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    break;
                case 'get_all_exports':
                    $stmt = $pdo->query("SELECT * FROM donhang ORDER BY ngayxuat DESC");
                    $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    break;
                case 'get_product_detail':
                    if ($product) {
                        $stmt = $pdo->prepare("SELECT * FROM sanpham WHERE tensp LIKE ?");
                        $stmt->execute(["%$product%"]);
                        $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    break;
                case 'get_import_detail':
                    if (isset($row['maphieunhap'])) {
                        $stmt = $pdo->prepare("SELECT * FROM chitietphieunhap WHERE maphieunhap = ?");
                        $stmt->execute([$row['maphieunhap']]);
                        $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    break;
                case 'get_export_detail':
                    if (isset($row['id'])) {
                        $stmt = $pdo->prepare("SELECT * FROM donhangchitiet WHERE id_donhang = ?");
                        $stmt->execute([$row['id']]);
                        $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    break;
                    
        }
        echo json_encode(['reply' => $reply, 'table_data' => $tableData]);
        exit;
    }

    
    echo json_encode(['reply' => $reply]);

} catch (PDOException $e) {
    echo json_encode(['reply' => 'Lỗi cơ sở dữ liệu: ' . $e->getMessage()]);
}