<?php
require_once "models/model.php";
require_once "views/view.php";
require_once "configs/connect.php";
require_once __DIR__ . '/../PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/../PHPMailer-master/src/PHPMailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Controller
{

    private $model;
    private $view;
    public function __construct()
    {
        $this->model = new model();
        $this->view = new view();
    }
































    public function dangki($taikhoan1, $matkhau, $diachi, $gioitinh, $cap, $email)
    {
        $result = $this->model->dangki($taikhoan1, $matkhau, $diachi, $gioitinh, $cap, $email);
        if ($result === 'Đăng ký tài khoản thành công') {
            return true;
        } else {
            echo "<script>alert('$result');</script>";
            return false;
        }
    }


    // public function dangky1()
    // {
    //     $tatcadanhmuc = $this->model->pageQuanLyDM();
    //     $this->view->dangky1($tatcadanhmuc);
    // }

    // public function dangnhap1()
    // {
    //     $tatcadanhmuc = $this->model->pageQuanLyDM();
    //     $this->view->dangnhap1($tatcadanhmuc);
    // }

    public function layTatCaNhatKy()
    {
        try {
            $data = $this->model->layTatCaNhatKy();
            header('Content-Type: application/json');
            echo json_encode($data);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }


    public function capNhatThoigianDangXuat()
    {
        if (isset($_SESSION['id'])) {
            try {
                $this->model->capNhatThoigianDangXuat($_SESSION['id']);
            } catch (Exception $e) {
                echo "<script>alert('Lỗi: " . $e->getMessage() . "');</script>";
            }
        }
    }











    // public function dangnhap()
    // {
    //     if (isset($_POST['dangnhap'])) {
    //         $taikhoan1 = $_POST['taikhoan1'];
    //         $matkhau = $_POST['matkhau'];

    //         $result = $this->model->dangnhap($taikhoan1, $matkhau);

    //         if ($result) {
    //             $_SESSION['id'] = $result['id'];
    //             $_SESSION['taikhoan1'] = $result['taikhoan1'];
    //             $_SESSION['matkhau'] = $result['matkhau'];
    //             $_SESSION['diachi'] = $result['diachi'];
    //             $_SESSION['gioitinh'] = $result['gioitinh'];
    //             $_SESSION['cap'] = $result['cap'];

    //             // // Lấy thời gian hiện tại khi người dùng nhấn nút "Đăng nhập"
    //             // $thoigianDangNhap = date("Y-m-d H:i:s");

    //             // // Thêm nhật ký đăng nhập vào bảng nhatky_dangnhap

    //             // $this->model->themNhatKyDangNhap($_SESSION['id'], $thoigianDangNhap);
    //             $this->model->themNhatKyDangNhap($_SESSION['id']);


    //             if ($result['cap'] == 1) {
    //                 header("Location: index.php?task=formquanli");
    //                 exit;
    //             } elseif ($result['cap'] == 2) {
    //                 header("Location: index.php?task=formnhanvien");
    //                 exit;
    //             } elseif ($result['cap'] == 3) {
    //                 header("Location: index.php?task=formketoan");
    //                 exit;
    //             } else {
    //                 echo "<script>
    //                         alert('Tài khoản không hợp lệ!');
    //                         window.location.href = 'index.php?task=formdangnhap';
    //                       </script>";
    //                 exit;
    //             }
    //         } else {
    //             $message = "Tài khoản hoặc mật khẩu không đúng. Vui lòng nhập lại!";
    //             echo "<script type='text/javascript'> 
    //                     alert('$message');
    //                     window.location.href = 'index.php?task=formdangnhap';
    //                   </script>";
    //             exit;
    //         }
    //     }
    // }

    public function dangnhap()
{
    if (isset($_POST['dangnhap'])) {
        $taikhoan1 = isset($_POST['taikhoan1']) ? trim($_POST['taikhoan1']) : '';
        $matkhau = isset($_POST['matkhau']) ? trim($_POST['matkhau']) : '';

        if (empty($taikhoan1) || empty($matkhau)) {
            echo "<script>
                    alert('Vui lòng nhập đầy đủ tài khoản và mật khẩu.');
                    window.location.href = 'index.php?task=formdangnhap';
                  </script>";
            exit;
        }

        $result = $this->model->dangnhap($taikhoan1, $matkhau);

        if ($result) {
            $_SESSION['id'] = $result['id'];
            $_SESSION['taikhoan1'] = $result['taikhoan1'];
            $_SESSION['diachi'] = $result['diachi'];
            $_SESSION['gioitinh'] = $result['gioitinh'];
            $_SESSION['cap'] = $result['cap'];

            // Ghi nhật ký đăng nhập
            $this->model->themNhatKyDangNhap($_SESSION['id']);

            switch ($result['cap']) {
                case 1:
                    header("Location: index.php?task=formquanli");
                    break;
                case 2:
                    header("Location: index.php?task=formnhanvien");
                    break;
                case 3:
                    header("Location: index.php?task=formketoan");
                    break;
                default:
                    echo "<script>
                            alert('Tài khoản không hợp lệ!');
                            window.location.href = 'index.php?task=formdangnhap';
                          </script>";
                    break;
            }
            exit;
        } else {
            echo "<script>
                    alert('Tài khoản hoặc mật khẩu không đúng. Vui lòng nhập lại!');
                    window.location.href = 'index.php?task=formdangnhap';
                  </script>";
            exit;
        }
    }
}


public function duyettaikhoan()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $id = $_POST['id'];
        $this->model->duyetTaiKhoan($id);
        echo "<script>alert('Duyệt tài khoản thành công!'); window.location.href = 'index.php?task=formquanli';</script>";
    } else {
        echo "<script>alert('Duyệt tài khoản thất bại!'); window.location.href = 'index.php?task=formquanli#nhanvien';</script>";
    }
}





    public function xoaLichSu($id)
    {
        try {
            $this->model->xoaLichSu($id);
            echo json_encode(["status" => "success", "message" => "Xóa lịch sử thành công!"]);
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    // public function dangnhap()
    // {
    //     if (isset($_POST['dangnhap'])) {
    //         $taikhoan1 = $_POST['taikhoan1'];
    //         $matkhau = $_POST['matkhau'];

    //         $result = $this->model->dangnhap($taikhoan1, $matkhau);

    //         if ($result) {
    //             $_SESSION['id'] = $result['id'];
    //             $_SESSION['taikhoan1'] = $result['taikhoan1'];
    //             $_SESSION['matkhau'] = $result['matkhau'];
    //             $_SESSION['diachi'] = $result['diachi'];
    //             $_SESSION['gioitinh'] = $result['gioitinh'];
    //             $_SESSION['cap'] = $result['cap'];

    //             if ($result['cap'] == 1) {
    //                 header("Location: index.php?task=formquanli");
    //                 exit;
    //             } elseif ($result['cap'] == 2) {
    //                 header("Location: index.php?task=formnhanvien");
    //                 exit;
    //             } elseif ($result['cap'] == 3) {
    //                 header("Location: index.php?task=formketoan");
    //                 exit;
    //             } else {
    //                 echo "<script>
    //                         alert('Tài khoản không hợp lệ!');
    //                         window.location.href = 'index.php?task=formdangnhap';
    //                       </script>";
    //                 exit;
    //             }
    //         } else {
    //             $message = "Tài khoản hoặc mật khẩu không đúng. Vui lòng nhập lại!";
    //             echo "<script type='text/javascript'> 
    //                     alert('$message');
    //                     window.location.href = 'index.php?task=formdangnhap';
    //                   </script>";
    //             exit;
    //         }
    //     }
    // }



























    public function tatcanguoidung()
    {
        if (!isset($_SESSION['cap']) || $_SESSION['cap'] != 1) {
            header("Location: index.php?task=formdangnhap");
            exit;
        }

        $danhsach = $this->model->tatcanguoidung();
        $this->view->hienthitatcanguoidung($danhsach);
    }


    public function tatcasanpham()
    {
        // Kiểm tra quyền truy cập: chỉ admin (cap == 1) mới được xem danh sách
        // if (!isset($_SESSION['cap']) || $_SESSION['cap'] != 1) {
        //     header("Location: index.php?task=formdangnhap");
        //     exit;
        // }

        // Gọi model để lấy dữ liệu sản phẩm
        $danhsach1 = $this->model->tatcasanpham();

        // Gửi dữ liệu đến view để hiển thị
        $this->view->hienthitatcasanpham($danhsach1);
    }








    public function xoataikhoan($id)
    {
        $this->model->xoataikhoan($id);
        header("Location: index.php?task=formquanli#nhanvien");
        exit;
    }


    // Lấy dữ liệu để hiển thị form sửa
    public function suataikhoan($id)
    {
        $user = $this->model->suataikhoan($id); // dùng model->suataikhoan($id) thay vì getUserById()
        $this->view->formsuataikhoan($user);
    }

    // Xử lý khi submit form sửa
    public function suataikhoan1($id, $taikhoan1, $matkhau, $diachi, $gioitinh, $cap)
    {
        $this->model->suataikhoan1($id, $taikhoan1, $matkhau, $diachi, $gioitinh, $cap);

        // Redirect về lại trang hiện tại (ví dụ danh sách người dùng)
        header("Location: index.php?task=formquanli#nhanvien");
        exit;
    }





    public function editProduct()
    {
        $masp = $_GET['masp'] ?? '';
        if (empty($masp)) {
            echo json_encode(["status" => "error", "message" => "Thiếu mã sản phẩm"]);
            return;
        }

        $model = new model();
        $product = $model->laySanPhamTheoMa($masp);
        if ($product) {
            echo json_encode(["status" => "success", "product" => $product]);
        } else {
            echo json_encode(["status" => "error", "message" => "Không tìm thấy sản phẩm"]);
        }
    }

    public function capNhatSanPham()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(["status" => "error", "message" => "Sai phương thức gửi dữ liệu!"]);
            return;
        }

        $masp = $_POST['masp'] ?? '';
        $tensp = $_POST['tensp'] ?? '';
        $donvitinh = $_POST['donvitinh'] ?? '';
        $soluongton = $_POST['soluongton'] ?? '';
        $gianhap = $_POST['gianhap'] ?? '';
        $giaxuat = $_POST['giaxuat'] ?? '';
        $mota = $_POST['mota'] ?? '';
        $ngaytao = $_POST['ngaytao'] ?? '';
        $ngaycapnhat = $_POST['ngaycapnhat'] ?? '';

        if (empty($masp) || empty($tensp) || empty($donvitinh) || empty($soluongton) || empty($gianhap) || empty($giaxuat)) {
            echo json_encode(["status" => "error", "message" => "Thiếu dữ liệu đầu vào!"]);
            return;
        }

        $hinhanhPath = $_POST['hinhanh_cu'] ?? null; // Ảnh cũ nếu không upload mới

        // Nếu upload ảnh mới
        if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] == 0) {
            $hinhanhTmp = $_FILES['hinhanh']['tmp_name'];
            $hinhanhName = time() . '_' . $_FILES['hinhanh']['name'];
            $hinhanhPath = 'img/' . basename($hinhanhName);

            move_uploaded_file($hinhanhTmp, $hinhanhPath);
        }

        try {
            $result = $this->model->capNhatSanPham($masp, $tensp, $donvitinh, $soluongton, $gianhap, $giaxuat, $mota, $hinhanhPath, $ngaytao, $ngaycapnhat);
            if ($result) {
                echo json_encode(["status" => "success", "message" => "Cập nhật sản phẩm thành công!"]);
            } else {
                throw new Exception("Lỗi khi cập nhật sản phẩm!");
            }
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }













    public function formthemtaikhoan()
    {
        $this->view->formthemtaikhoan(); // include form từ templates
    }

    public function themtaikhoan($taikhoan1, $matkhau, $diachi, $gioitinh, $cap)
    {
        $this->model->themtaikhoan($taikhoan1, $matkhau, $diachi, $gioitinh, $cap);
        header("Location: index.php?task=formquanli#nhanvien"); // quay lại danh sách
        exit;
    }










    public function xoasanpham($masp)
    {
        if ($this->model->xoasanpham($masp)) {
            // Xóa thành công
            header("Location: index.php?task=formquanli#sanpham");
        } else {
            // Xóa thất bại
            echo "<script>
                    alert('Không thể xóa sản phẩm này!');
                    window.location.href = 'index.php?task=formquanli#sanpham';
                  </script>";
        }
        exit;
    }



    // public function xoasanpham($masp)
    // {
    //     $this->model->xoasanpham($masp);
    //     header("Location: index.php?task=formquanli#sanpham");
    //     exit;
    // }


    public function formthemsanpham()
    {
        $this->view->formthemsanpham(); // Gọi view để hiển thị form thêm sản phẩm
    }

    public function themsanpham($masp, $tensp, $donvitinh, $soluongton, $gianhap, $giaxuat, $mota, $hinhanh)
    {
        $this->model->themsanpham($masp, $tensp, $donvitinh, $soluongton, $gianhap, $giaxuat, $mota, $hinhanh);
        header("Location: index.php?task=formquanli#sanpham"); // Quay lại danh sách sản phẩm
        exit;
    }










    public function getThongKeDonXuat()
    {
        // Gọi hàm thongKeDonXuat từ Model để lấy dữ liệu
        $data = $this->model->thongKeDonXuat();

        // Kiểm tra dữ liệu nếu có, nếu không có sẽ trả về thông báo lỗi
        if ($data) {
            echo json_encode([
                'success' => true,
                'so_luong_don_xuat' => $data['so_luong'],
                'tong_tien' => $data['tong_tien']
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Không có dữ liệu'
            ]);
        }
    }


    public function getThongKePhieuNhap()
    {
        // Gọi hàm thongKePhieuNhap từ Model để lấy dữ liệu
        $data = $this->model->thongKePhieuNhap();

        // Kiểm tra dữ liệu nếu có, nếu không có sẽ trả về thông báo lỗi
        if ($data) {
            echo json_encode([
                'success' => true,
                'so_luong' => $data['so_luong'],
                'tong_tien' => $data['tong_tien']
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Không có dữ liệu'
            ]);
        }
    }
















    public function getChiTiet($maphieunhap)
    {
        $data = $this->model->layTatCaChiTietPhieuNhap($maphieunhap);

        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }


    public function getChiTietDonHangXuat($id_donhang)
    {
        $data = $this->model->layTatCaChiTietDonHangXuat($id_donhang);

        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }



    public function kiemTraTonKho()
    {
        $data = $this->model->layTatCaTonKho();
        echo json_encode($data);
    }





    public function getDonHangDaXuat()
    {
        try {
            $data = $this->model->getDonHangDaXuat();
            header('Content-Type: application/json');
            echo json_encode($data);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }




















    public function handleForm()
    {
        $id = $_POST['id'] ?? null;
        $username = $_POST['taikhoan1'] ?? null;
        $email = $_POST['email'] ?? null;

        if (!$id || !$username || !$email) {
            echo "❌ Vui lòng nhập đầy đủ thông tin.";
            return;
        }

        // Giả sử $this->model->findByIdAndUsername() tìm kiếm thông tin người dùng từ cơ sở dữ liệu
        $user = $this->model->findByIdAndUsername($id, $username);

        if ($user) {
            // So sánh email trong DB với email nhập vào
            if (strtolower(trim($user['email'])) !== strtolower(trim($email))) {
                echo "❌ Email không trùng khớp với tài khoản.";
                return;
            }

            // Tạo mật khẩu mới
            $newPass = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 10);
            $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);

            // Giả sử $this->model->updatePassword() cập nhật mật khẩu mới vào cơ sở dữ liệu
            if ($this->model->updatePassword($id, $username, $hashedPass)) {
                $subject = "Cấp lại mật khẩu hệ thống";
                $message = "Xin chào $username,\n\nMật khẩu mới của bạn là: $newPass\n\nVui lòng đăng nhập và đổi lại mật khẩu.";

                // Sử dụng PHPMailer để gửi email
                $mail = new PHPMailer(true);

                try {
                    // Cấu hình SMTP
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'phamducnha2003@gmail.com';
                    $mail->Password = 'bzjvoitnmuorczal';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Cài đặt người gửi và người nhận
                    $mail->setFrom('phamducnha2003@gmail.com', 'phamnha');
                    $mail->addAddress($email);  // Địa chỉ email người nhận
                    $mail->Subject = $subject;
                    $mail->Body    = $message;
                    $mail->SMTPDebug = 2; // hoặc 3 để chi tiết hơn
                    $mail->Debugoutput = 'html';


                    // Gửi email
                    if ($mail->send()) {
                        echo "✅ Mật khẩu mới đã gửi về email.";
                    } else {
                        echo "⚠️ Mật khẩu cập nhật thành công, nhưng không gửi được email: " . $mail->ErrorInfo;
                    }
                } catch (Exception $e) {
                    echo "⚠️ Không thể gửi email. Lỗi: {$mail->ErrorInfo}";
                }
            } else {
                echo "❌ Cập nhật mật khẩu thất bại.";
            }
        } else {
            echo "❌ Sai ID hoặc tên tài khoản.";
        }
    }






public function doiMatKhau()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        
        $userId = $_SESSION['id'] ?? null;
        $oldPassword = $data['old_password'] ?? '';
        $newPassword = $data['new_password'] ?? '';
        $confirmPassword = $data['confirm_password'] ?? ''; // nếu bạn gửi luôn confirm

        if (!$userId || !$oldPassword || !$newPassword) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin.']);
            return;
        }

        $result = $this->model->doiMatKhau($userId, $oldPassword, $newPassword);
        echo json_encode($result);
    }
}
























    public function getDashboardData()
    {
        try {
            $data = $this->model->getDashboardData();
            header('Content-Type: application/json');
            echo json_encode($data);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi server: ' . $e->getMessage()
            ]);
        }
    }


    public function getDashboardComparison()
    {
        try {
            $data = $this->model->getDashboardComparison();
            header('Content-Type: application/json');
            echo json_encode($data);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi server: ' . $e->getMessage()
            ]);
        }
    }


























    public function getInterestRates()
    {
        try {
            $data = $this->model->getInterestRates();
            if (empty($data)) {
                echo json_encode(['status' => 'error', 'message' => 'Không có dữ liệu']);
            } else {
                echo json_encode($data);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    public function getDonHangData()
    {
        // Lấy id_nhanvien từ request (POST hoặc GET)
        $id_nhanvien = $_GET['id_nhanvien'] ?? $_POST['id_nhanvien'] ?? ($_SESSION['id'] ?? null);

        if (!$id_nhanvien) {
            echo json_encode(['error' => 'Thiếu id_nhanvien']);
            return;
        }

        try {
            $data = $this->model->getDonHangData($id_nhanvien);
            header('Content-Type: application/json');
            echo json_encode($data);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Lỗi khi lấy dữ liệu: ' . $e->getMessage()]);
        }
    }






















    public function deleteDonHang()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Sai phương thức gửi dữ liệu!']);
            return;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'Thiếu ID đơn hàng!']);
            return;
        }

        $result = $this->model->deleteDonHang($id);
        echo json_encode($result);
    }












    //////////////////////////////////////////////////////////////
    public function apiTonKho()
    {
        $tonkho = $this->model->getTonKho();
        header('Content-Type: application/json');
        echo json_encode($tonkho);
    }

    // API Báo cáo doanh thu
    public function apiDoanhThu()
    {
        $doanhthu = $this->model->getDoanhThu();
        header('Content-Type: application/json');
        echo json_encode($doanhthu);
    }
















    // Hiển thị trang nhập kho cho quản lý
    public function danhsach_phieunhap()
    {
        $result = $this->model->tatca_phieunhap();
        $danhsach4 = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $danhsach4[] = $row;
        }
        $_SESSION['danhsachPhieuNhap'] = $danhsach4;

        // Quay về giao diện chính cho quản lý
        header("Location: index.php?task=formquanli#nhapkho");
        exit();
    }




    
    // Hiển thị trang nhập kho cho nhân viên
    public function danhsach_phieunhap_nhanvien()
    {
        $result = $this->model->tatca_phieunhap();
        $danhsach4 = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $danhsach4[] = $row;
        }
        $_SESSION['danhsachPhieuNhap'] = $danhsach4;

        // Quay về giao diện chính cho nhân viên
        header("Location: index.php?task=formnhanvien#nhapkho");
        exit();
    }









    public function themPhieuNhap()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(["status" => "error", "message" => "Sai phương thức gửi dữ liệu!"]);
            return;
        }

        $ngaynhap = $_POST['ngaynhap'] ?? '';
        $id_nguoinhap = $_POST['id_nguoinhap'] ?? '';
        $masp = $_POST['mahang'] ?? '';
        $soluongnhap = $_POST['soluongnhap'] ?? '';
        $nguonnhap = $_POST['nguonnhap'] ?? '';

        if (empty($ngaynhap) || empty($id_nguoinhap) || empty($masp) || empty($soluongnhap) || empty($nguonnhap)) {
            echo json_encode(["status" => "error", "message" => "Thiếu dữ liệu đầu vào!"]);
            return;
        }

        $model = new model();

        try {
            $maphieunhap = $model->themPhieuNhap($ngaynhap, $id_nguoinhap);
            if (!$maphieunhap) {
                throw new Exception("Lỗi khi thêm phiếu nhập vào CSDL!");
            }

            $gianhap = $model->layGiaNhapSanPham($masp);
            if ($gianhap === null) {
                throw new Exception("Không tìm thấy giá nhập của sản phẩm: " . $masp);
            }

            if (!$model->themChiTietPhieuNhap($maphieunhap, $masp, $soluongnhap, $gianhap, $nguonnhap)) {
                throw new Exception("Lỗi khi thêm chi tiết phiếu nhập!");
            }

            if (!$model->capNhatSoLuongTon($masp, $soluongnhap)) {
                throw new Exception("Lỗi khi cập nhật số lượng tồn kho!");
            }

            // ✅ Cập nhật lại session sau khi thêm thành công
            $result = $model->tatca_phieunhap();
            $danhsach4 = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $danhsach4[] = $row;
            }
            $_SESSION['danhsachPhieuNhap'] = $danhsach4;

            echo json_encode(["status" => "success", "message" => "Thêm phiếu nhập thành công!"]);
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }













    public function xoaPhieuNhap()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(["status" => "error", "message" => "Sai phương thức gửi dữ liệu!"]);
            return;
        }

        $maphieunhap = $_POST['maphieunhap'] ?? '';

        if (empty($maphieunhap)) {
            echo json_encode(["status" => "error", "message" => "Thiếu mã phiếu nhập!"]);
            return;
        }

        $model = new model();

        try {
            // Xóa phiếu nhập
            if (!$model->xoa_phieunhap($maphieunhap)) {
                throw new Exception("Không thể xóa phiếu nhập!");
            }

            // Cập nhật lại session
            $result = $model->tatca_phieunhap();
            $danhsach4 = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $danhsach4[] = $row;
            }
            $_SESSION['danhsachPhieuNhap'] = $danhsach4;

            echo json_encode(["status" => "success", "message" => "Xóa phiếu nhập thành công!"]);
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }














    public function xemChiTietPhieuNhap()
    {
        if (isset($_GET['maphieunhap'])) {
            $mapn = intval($_GET['maphieunhap']);
            $data = $this->model->chitiet_phieunhap($mapn);

            header('Content-Type: application/json'); // 👈 thêm dòng này cho chuẩn JSON
            echo json_encode($data);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Thiếu mã phiếu nhập!']);
        }
    }






















    public function xuatkho()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_nhanvien = $_POST['nhanvien'];
            $masp = $_POST['mahang'];
            $soluong = $_POST['soluong'];
            $diachi = $_POST['diachi'];

            // Kiểm tra số lượng tồn kho
            $tonkho = $this->model->laySoLuongTon($masp);
            if ($tonkho < $soluong) {
                echo "<script>alert('Số lượng tồn không đủ!'); window.history.back();</script>";
                return;
            }

            // Thêm đơn hàng
            $id_donhang = $this->model->themDonHang($id_nhanvien, $diachi);
            if ($id_donhang) {
                // Thêm chi tiết đơn hàng
                $this->model->themChiTietDonHang($id_donhang, $masp, $soluong);
                // Cập nhật tồn kho
                $this->model->giamSoLuongTon($masp, $soluong);
                echo "<script>alert('Yêu cầu xuất hàng thành công!'); window.location.href='index.php?action=xuatkho';</script>";
            } else {
                echo "<script>alert('Thêm đơn hàng thất bại!');</script>";
            }
        }
    }


    public function getAllDonHang()
    {
        return $this->model->getAllDonHang();
    }





    // public function updateTrangThai($id, $trangthai) {
    //     if ($this->model->updateTrangThai($id, $trangthai)) {
    //         echo json_encode(['success' => true]);
    //     } else {
    //         echo json_encode(['success' => false]);
    //     }
    // }
    public function updateTrangThai($id, $trangthai)
    {
        $ngayxuat = null;

        if ($trangthai === 'Đã xuất') {
            $ngayxuat = date("Y-m-d H:i:s"); // Lấy thời gian hiện tại
        }

        if ($this->model->updateTrangThai($id, $trangthai, $ngayxuat)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }





    public function getDonHangChiTiet($id)
    {
        // Gọi phương thức model để lấy chi tiết đơn hàng
        $details = $this->model->getDonHangChiTiet($id);

        // Kiểm tra xem có dữ liệu hay không
        if (isset($details['error'])) {
            // Nếu có lỗi, trả về lỗi dưới dạng JSON
            echo json_encode($details);
        } else {
            // Trả về chi tiết đơn hàng dưới dạng JSON
            echo json_encode($details);
        }
    }







    public function getFilteredLichSu()
    {
        $startDate = $_GET['start'] ?? '';
        $endDate = $_GET['end'] ?? '';

        if (!$startDate || !$endDate) {
            echo json_encode([]);
            return;
        }

        $model = new model();
        $data = $model->getLichSuNhapKho1($startDate, $endDate); // dùng đúng hàm trong model
        echo json_encode($data);
    }

    public function getFilteredLichSu1()
    {
        $startDate = $_GET['start'] ?? '';
        $endDate = $_GET['end'] ?? '';

        if (!$startDate || !$endDate) {
            echo json_encode([]);
            return;
        }

        $model = new model();
        $data = $model->getLichSuXuatKho1($startDate, $endDate); // dùng đúng hàm trong model
        echo json_encode($data);
    }









    public function hienThiFormThemPhieuNhap()
    {
        // Lấy danh sách sản phẩm từ Model
        $sanphamList2 = $this->model->getAllSanPham();

        // Debug để kiểm tra dữ liệu sản phẩm
        var_dump($sanphamList2);  // Kiểm tra kết quả trả về

        // Tạo mảng viewData chứa dữ liệu để truyền vào view
        $viewData = ['sanphamList2' => $sanphamList2];

        // Truyền dữ liệu vào view
        require __DIR__ . '/../templates/formquanli.php';
    }


    // public function themPhieuNhap()
    // {
    //     // Xử lý khi form gửi dữ liệu
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         // Lấy dữ liệu từ form
    //         $maphieunhap = $_POST['maphieunhap'];
    //         $ngaynhap = $_POST['ngaynhap'];
    //         $id_nguoinhap = $_POST['id_nguoinhap'];
    //         $masp = $_POST['masp'];
    //         $soluongnhap = $_POST['soluongnhap'];
    //         $gianhap = $_POST['gianhap'];

    //         // Lưu phiếu nhập mới vào cơ sở dữ liệu
    //         $this->model->insertPhieuNhap($maphieunhap, $ngaynhap, $id_nguoinhap, $masp, $soluongnhap, $gianhap);

    //         // Sau khi lưu thành công, chuyển hướng đến trang danh sách phiếu nhập hoặc hiển thị thông báo
    //         header('Location: index.php?controller=phieunhap&action=danhSachPhieuNhap');
    //         exit();
    //     }
    // }






    // // Hiển thị form (thêm hoặc cập nhật phiếu nhập)
    // public function showForm($masp = null) {
    //     // Lấy danh sách sản phẩm
    //     $sanphamList = $this->model->getSanPhamList();
    //     $phieunhap = null;

    //     // Kiểm tra nếu có mã sản phẩm (masp), lấy thông tin phiếu nhập để cập nhật
    //     if ($masp) {
    //         $phieunhap = $this->model->getPhieuNhapByMasp($masp);
    //     }

    //     // Truyền các dữ liệu cần thiết vào form (sanphamList và phieunhap)
    //     include 'templates/formquanli.php';
    // }

    // // Cập nhật hoặc thêm phiếu nhập
    // public function updatePhieuNhap() {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         // Nhận dữ liệu từ form
    //         $maphieunhap = $_POST['maphieunhap'];
    //         $ngaynhap = $_POST['ngaynhap'];
    //         $id_nguoinhap = $_POST['id_nguoinhap'];
    //         $masp = $_POST['masp'];
    //         $soluongnhap = $_POST['soluongnhap'];
    //         $gianhap = $_POST['gianhap'];

    //         // Xử lý thêm hoặc cập nhật phiếu nhập
    //         if ($this->model->checkPhieuNhapExists($maphieunhap)) {
    //             // Nếu phiếu nhập đã tồn tại, thực hiện cập nhật
    //             $this->model->updatePhieuNhap($maphieunhap, $ngaynhap, $id_nguoinhap, $masp, $soluongnhap, $gianhap);
    //         } else {
    //             // Nếu phiếu nhập chưa tồn tại, thực hiện thêm mới
    //             $this->model->addPhieuNhap($maphieunhap, $ngaynhap, $id_nguoinhap, $masp, $soluongnhap, $gianhap);
    //         }

    //         // Sau khi thêm/cập nhật, chuyển hướng hoặc thông báo thành công
    //         header('Location: index.php?controller=phieunhap&action=list'); // Chuyển hướng đến danh sách phiếu nhập
    //         exit(); // Đảm bảo dừng chương trình sau khi chuyển hướng
    //     }
    // }




    // public function doLogout()
    // {
    //     session_destroy();
    //     header('Location: index.php');
    // }
}
