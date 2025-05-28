<?php
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
ini_set('session.gc_maxlifetime', 3600); // 3600 giây = 60 phút
session_set_cookie_params(3600);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once "controllers/controller.php";
require_once "configs/connect.php";
require_once "models/model.php";
require_once "views/view.php";
date_default_timezone_set('Asia/Ho_Chi_Minh');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require 'vendor/autoload.php';



// Khởi tạo Controller

$Controller = new Controller();


//fix như c
// $danhsach1 = $Controller->tatcasanpham();

// $Controller1 = new Controller();
// $danhsach1 = $Controller1->tatcasanpham();

$Controller->tatcasanpham();



$task = isset($_GET['task']) ? $_GET['task'] : null;
//ko baat cai nay len
// $Controller->tatcanguoidung();


// Dữ liệu từ form
$taikhoan1 = isset($_POST['taikhoan1']) ? $_POST['taikhoan1'] : null;
$matkhau = isset($_POST['matkhau']) ? $_POST['matkhau'] : null;
$repassword = isset($_POST['repassword']) ? $_POST['repassword'] : null;
$diachi = isset($_POST['diachi']) ? $_POST['diachi'] : null;
$gioitinh = isset($_POST['gioitinh']) ? $_POST['gioitinh'] : null;
$cap = isset($_POST['cap']) ? $_POST['cap'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;




//dulieusanpham
$masp = isset($_POST['masp']) ? $_POST['masp'] : null; // ID sản phẩm
$tensp = isset($_POST['tensp']) ? $_POST['tensp'] : null;
$donvitinh = isset($_POST['donvitinh']) ? $_POST['donvitinh'] : null;
$soluongton = isset($_POST['soluongton']) ? $_POST['soluongton'] : null;
$gianhap = isset($_POST['gianhap']) ? $_POST['gianhap'] : null;
$giaxuat = isset($_POST['giaxuat']) ? $_POST['giaxuat'] : null;
$mota = isset($_POST['mota']) ? $_POST['mota'] : null;
$hinhanh = isset($_POST['hinhanh']) ? $_POST['hinhanh'] : null;
$ngaytao = isset($_POST['ngaytao']) ? $_POST['ngaytao'] : null;
$ngaycapnhat = isset($_POST['ngaycapnhat']) ? $_POST['ngaycapnhat'] : null;













if (isset($_GET['task']) && $_GET['task'] == 'thongke') {
    // Gọi phương thức getThongKeDonXuat từ controller

    $Controller->getThongKeDonXuat(); // Gọi phương thức
    exit;
}

if (isset($_GET['task']) && $_GET['task'] == 'phieunhap') {
    // Gọi phương thức getThongKeDonXuat từ controller

    $Controller->getThongKePhieuNhap(); // Gọi phương thức trong controller để xử lý
    exit;
}





if (isset($_GET['task']) && $_GET['task'] == 'getDonHangData') {
    $Controller->getDonHangData();
    exit;
}

// index.php

// // Kiểm tra nếu yêu cầu là "updateTrangThai"
// if ($task == 'updateTrangThai') {
//     $id = $_GET['id']; // Lấy ID đơn hàng từ URL
//     $trangthai = $_GET['trangthai']; // Lấy trạng thái mới (Đã xuất)

//     // Gọi phương thức updateTrangThai trong Controller
//     $Controller->updateTrangThai($id, $trangthai);
// }

if ($task == 'updateTrangThai') {
    $id = $_GET['id'];
    $trangthai = $_GET['trangthai'];
    $Controller->updateTrangThai($id, $trangthai);
    exit;
}












$hinhanh = null;
if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] == 0) {
    $upload_dir = "img/"; // Đổi từ uploads/ thành img/
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    $file_name = basename($_FILES['hinhanh']['name']);
    $target_file = $upload_dir . time() . "_" . $file_name;

    if (move_uploaded_file($_FILES['hinhanh']['tmp_name'], $target_file)) {
        $hinhanh = $target_file;
    } else {
        $hinhanh = null; // Nếu lỗi khi upload
    }
}
$controller = $_GET['controller'] ?? null;
$action = $_GET['action'] ?? null;


if (isset($_POST['dangki'])) {
    if (empty($taikhoan1) || empty($matkhau) || empty($repassword) || empty($diachi) || empty($gioitinh) || empty($_POST['email'])) {
        echo "<script>alert('Vui lòng nhập đầy đủ thông tin!');</script>";
    } elseif ($matkhau !== $repassword) {
        echo "<script>alert('Mật khẩu và nhập lại mật khẩu phải giống nhau!');</script>";
    } else {
        $email = $_POST['email'];
        if ($Controller->dangki($taikhoan1, $matkhau, $diachi, $gioitinh, $cap, $email)) {
            echo "<script>alert('Đăng ký thành công!');</script>";
        } else {
            echo "<script>alert('Đăng ký thất bại! Vui lòng thử lại.');</script>";
        }
    }
}



if (isset($_POST['dangnhap'])) {
    if (empty($taikhoan1) || empty($matkhau)) {
        echo "<script>alert('Vui lòng nhập đầy đủ thông tin!');</script>";
    } else {
        $Controller->dangnhap();
    }
}




// Tạo một đối tượng từ lớp Model THẲNG MODEL
$model = new Model();  // Giả sử bạn có một lớp Model

if (isset($_GET['task']) && $_GET['task'] == 'xuatexcel') {
    // Gọi hàm xuatExcelPhiNhap() từ đối tượng Model
    $model->xuatExcelPhieuNhap();
}

// if (isset($_GET['task']) && $_GET['task'] == 'importExcelXuatKho') {
//     // Gọi hàm xuatExcelPhiNhap() từ đối tượng Model
//     $model->importExcelXuatKho();
//      header("Location: index.php?task=formquanli#xuatkho");
//      exit();
// }
if (isset($_GET['task']) && $_GET['task'] == 'importExcel') {
    $model->importExcelSanPham(); 
    header("Location: index.php?task=formquanli#sanpham");
exit();

}
if (isset($_GET['task']) && $_GET['task'] == 'importExcelPhieuNhap') {
    $model->importExcelPhieuNhap(); 
    header("Location: index.php?task=formquanli#nhapkho");
exit();

}




$_SESSION['hanghoaList'] = $model->tatcasanpham();
// // Xử lý các request
// if ($controller == 'phieunhap') {
//     if ($action == 'showForm') {
//         $masp = isset($_GET['masp']) ? $_GET['masp'] : null;

//         if ($masp) {
//             // Gọi phương thức showForm với tham số masp
//             $Controller->showForm($masp);
//         } else {
//             // Chuyển hướng về trang danh sách phiếu nhập (hoặc một trang nào đó) nếu không có mã sản phẩm
//             echo "<script>alert('Mã sản phẩm không hợp lệ!'); window.location.href = 'index.php?controller=phieunhap&action=list';</script>";
//         }
//     } elseif ($action == 'updatePhieuNhap') {
//         // Gọi phương thức cập nhật phiếu nhập
//         $Controller->updatePhieuNhap();
//     }
// }


// if (isset($_POST['suataikhoan'])) {
//     $taikhoan1 = $_POST['taikhoan1'] ?? '';
//     $diachi = $_POST['diachi'] ?? '';
//     $gioitinh = $_POST['gioitinh'] ?? '';
//     $cap = $_POST['cap'] ?? '';

//     if (empty($taikhoan1) || empty($diachi) || empty($gioitinh) || $cap === '') {
//         echo "<script>alert('Vui lòng nhập đầy đủ thông tin !!!');</script>";
//     } else {
//         $Controller->suataikhoan1($taikhoan1, $diachi, $gioitinh, $cap);
//     }
// }









// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $masp = $_POST['masp'] ?? null;
//     $soluongnhap = $_POST['soluongnhap'] ?? null;
//     $gianhap = $_POST['gianhap'] ?? null;

//     // Thực hiện thêm phiếu nhập (chưa hoàn thiện ở đây, bạn cần viết thêm xử lý lưu vào DB)
//     $this->model->themPhieuNhap($masp, $soluongnhap, $gianhap);

//     // Quay lại giao diện danh sách phiếu nhập
//     header("Location: index.php?task=formquanli#nhapkho");
//     exit();
// }







// if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["capnhat"])) {
//     $Controller->handleForm();
// }
























if (isset($_POST['themtaikhoan'])) {
    $taikhoan1 = $_POST['taikhoan1'] ?? '';
    $matkhau = $_POST['matkhau'] ?? '';
    $diachi = $_POST['diachi'] ?? '';
    $gioitinh = $_POST['gioitinh'] ?? '';
    $cap = $_POST['cap'] ?? '';
    $email = $_POST['email'] ?? '';

    if (empty($taikhoan1) || empty($matkhau) || empty($diachi) || empty($gioitinh) || $cap === '' || empty($email)) {
        echo "<script>alert('Vui lòng nhập đầy đủ thông tin !!!');</script>";
    } else {
        $Controller->dangki($taikhoan1, $matkhau, $diachi, $gioitinh, (int)$cap, $email);
    }
}





if (isset($_GET['action']) && $_GET['action'] === 'xemchitiet') {
    $Controller->xemChiTietPhieuNhap();
    exit();
}
$action = isset($_GET['action']) ? $_GET['action'] : 'danhSachPhieuNhap';





switch ($task) {
    case 'formdangki':
        include 'templates/formdangki.php';
        break;


    case 'formuptaikhoan':
        include 'templates/formuptaikhoan.php';
        break;





    case 'tatcasanpham':
        if (!isset($_SESSION['cap']) || $_SESSION['cap'] != 1) {
            echo "Không có quyền truy cập!"; // debug
            header("Location: index.php?task=formdangnhap");
        }
        include 'templates/formquanli.php'; //kjijij
        break;

    case 'formdangnhap':
        include 'templates/formdangnhap.php';
        break;

    case 'formnhanvien':
        include 'templates/formnhanvien.php';
        break;
    case 'formketoan':
        include 'templates/formketoan.php';
        break;

    case 'formquanli':
        if (isset($_SESSION['cap']) && $_SESSION['cap'] == 1) {
            $Controller->tatcanguoidung(); // chỉ lấy dữ liệu
            include 'templates/formquanli.php'; // render tại 

        } else {
            header("Location: index.php?task=formdangnhap");
            exit;
        }
        break;
    case 'xoataikhoan':
        if (isset($_SESSION['cap']) && $_SESSION['cap'] == 1) {
            $Controller->xoataikhoan($_GET['id']);
        } else {
            header("Location: index.php?task=formdangnhap");
            exit;
        }
        break;


    case 'suataikhoan':
        if (isset($_GET['id'])) {
            $Controller->suataikhoan($_GET['id']);
            exit;
        }
        break;

    case 'suataikhoan1':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $taikhoan1 = $_POST['taikhoan1'] ?? '';
            $matkhau = $_POST['matkhau'] ?? '';
            $diachi = $_POST['diachi'] ?? '';
            $gioitinh = $_POST['gioitinh'] ?? '';
            $cap = $_POST['cap'] ?? '';

            if (empty($id) || empty($taikhoan1) || empty($matkhau) || empty($diachi) || empty($gioitinh) || $cap === '') {
                echo "<script>alert('Vui lòng nhập đầy đủ thông tin !!!');</script>";
            } else {
                $Controller->suataikhoan1($id, $taikhoan1, $matkhau, $diachi, $gioitinh, $cap);
                header("Location: index.php?task=formquanli"); // quay lại danh sách sau khi sửa
                exit();
            }
        }
        break;
    case 'formthemsanpham':
        if (isset($_SESSION['cap']) && $_SESSION['cap'] == 1) {
            $Controller->formthemsanpham(); // gọi view templates/formthemsanpham.php
        } else {
            header("Location: index.php?task=formquanli");
            exit;
        }
        break;





    // case 'xoasanpham':
    //     if (isset($_SESSION['cap']) && $_SESSION['cap'] == 1) {
    //         $Controller->xoasanpham($_GET['masp']);
    //     } else {
    //         header("Location: index.php?task=formdangnhap");
    //         exit;
    //     }
    //     break;

    case 'xoasanpham':
        if (isset($_SESSION['cap']) && $_SESSION['cap'] == 1 && isset($_GET['masp'])) {
            $Controller->xoasanpham($_GET['masp']);
        } else {
            header("Location: index.php?task=formdangnhap");
            exit;
        }
        break;

    // case 'suasanpham':
    //     if (isset($_GET['masp'])) {
    //         $Controller->suasanpham($_GET['masp']);
    //     }
    //     break;

    // case 'suasanpham1':
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $masp = $_POST['masp'] ?? '';
    //         $tensp = $_POST['tensp'] ?? '';
    //         $donvitinh = $_POST['donvitinh'] ?? '';
    //         $soluongton = $_POST['soluongton'] ?? '';
    //         $gianhap = $_POST['gianhap'] ?? '';
    //         $giaxuat = $_POST['giaxuat'] ?? '';
    //         $mota = $_POST['mota'] ?? '';
    //         $hinhanh = $_POST['hinhanh'] ?? '';

    //         if (empty($masp) || empty($tensp) || empty($donvitinh) || empty($soluongton) || empty($gianhap) || empty($giaxuat) || empty($mota) || empty($hinhanh)) {
    //             echo "<script>alert('Vui lòng nhập đầy đủ thông tin !!!');</script>";
    //         } else {
    //             // Thêm ngày cập nhật vào mảng dữ liệu
    //             $ngaycapnhat = date('Y-m-d H:i:s'); // Tạo giá trị ngày giờ hiện tại

    //             $Controller->suasanpham1($masp, $tensp, $donvitinh, $soluongton, $gianhap, $giaxuat, $mota, $hinhanh, $ngaycapnhat);
    //             header("Location: index.php?task=formquanli#sanpham"); // quay lại danh sách sau khi sửa
    //             exit();
    //         }
    //     }
    //     break;







    case 'editProduct':
        $Controller->editProduct();
        exit;
        break;



    case 'capNhatSanPham':
        $Controller->capNhatSanPham();
        exit;
        break;








    case 'themsanpham':
        if (isset($_SESSION['cap']) && $_SESSION['cap'] == 1) {
            $Controller->themsanpham($masp, $tensp, $donvitinh, $soluongton, $gianhap, $giaxuat, $mota, $hinhanh, $ngaytao, $ngaycapnhat);
            header("Location: index.php?task=formquanli#sanpham");
            exit;
        } else {
            header("Location: index.php?task=formquanli#");
        }
        break;






    // case 'formnhapkho':
    //     if (isset($_SESSION['cap']) && $_SESSION['cap'] == 1) {
    //         $danhsachsanpham = $Controller->tatcasanpham(); // Lấy tất cả sản phẩm để hiển thị chọn
    //         include 'templates/formnhapkho.php';
    //     } else {
    //         header("Location: index.php?task=formdangnhap");
    //         exit;
    //     }
    //     break;

    // case 'xulynhapkho':
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $masp = $_POST['masp'] ?? null;
    //         $soluongnhap = $_POST['soluongnhap'] ?? null;
    //         $ngaynhap = $_POST['ngaynhap'] ?? date('Y-m-d');

    //         if (empty($masp) || empty($soluongnhap)) {
    //             echo "<script>alert('Vui lòng nhập đầy đủ thông tin!'); window.location='index.php?task=formnhapkho';</script>";
    //         } else {
    //             if ($Controller->nhapkho($masp, $soluongnhap, $ngaynhap)) {
    //                 echo "<script>alert('Nhập kho thành công!'); window.location='index.php?task=formnhapkho';</script>";
    //             } else {
    //                 echo "<script>alert('Nhập kho thất bại!'); window.location='index.php?task=formnhapkho';</script>";
    //             }
    //         }
    //     }
    //     break;


    case 'hienThiFormThemPhieuNhap':
        $masp = isset($_GET['masp']) ? $_GET['masp'] : null;

        $Controller->hienThiFormThemPhieuNhap();

        break;

    // case 'themPhieuNhap':
    //     $controller->themPhieuNhap();
    //     break;


    case 'danhsach_phieunhap':
        if (isset($_SESSION['cap']) && $_SESSION['cap'] == 1) {
            $Controller->danhsach_phieunhap();
        }
        exit;
        break;

        
 case 'danhsach_phieunhap_nhanvien':
        if (isset($_SESSION['cap']) && $_SESSION['cap'] == 2) {
            $Controller->danhsach_phieunhap_nhanvien();
        }
        exit;
        break;

    case 'xuatkho':


        $Controller->xuatkho();
        exit;
        break;


    case 'getDonHangChiTiet':
        if (isset($_GET['id'])) {
            // Tạo instance của Controller và gọi hàm tương ứng
            $Controller->getDonHangChiTiet($_GET['id']);
        } else {
            echo json_encode(['error' => 'ID không hợp lệ']);
        }


        break;



        case 'doiMatKhau':
            $Controller->doiMatKhau();
            exit;
            break;





            case 'deleteDonHang':
                $Controller->deleteDonHang();
                exit;
                break;


    case 'getInterestRates':
        $Controller->getInterestRates();
        exit;
        break;









    case 'getDonHangData':
        $Controller->getDonHangData();
        exit;
        break;








    case 'handleForm':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Controller->handleForm();
        }
        break;











    case 'getchitietphieunhap':
        $maphieunhap = $_GET['maphieunhap'] ?? '';
        error_log("MAPHIEUNHAP: " . $maphieunhap); // Ghi log
        $Controller->getChiTiet($maphieunhap);
        break;




    case 'getchitietdonhangxuat':
        $id_donhang = $_GET['id_donhang'] ?? '';
        error_log("ID_DONHANG: " . $id_donhang); // Ghi log để debug
        $Controller->getChiTietDonHangXuat($id_donhang);
        break;




    case 'kiemtratonkho':

        $Controller->kiemTraTonKho();

        break;




        case 'getDonHangDaXuat':
            $Controller->getDonHangDaXuat();
            exit;
            break;






    case 'getDashboardData':
        $Controller->getDashboardData();
        exit;
        break;

    case 'getDashboardComparison':
        $Controller->getDashboardComparison();
        exit;
        break;










    case 'doanhthu':
        // Gọi phương thức lấy báo cáo doanh thu
        $Controller->apiDoanhThu();
        exit;
        break;

    case 'tonkho':
        // Gọi phương thức lấy báo cáo tồn kho
        $Controller->apiTonKho();
        exit;
        break;




    case 'layTatCaNhatKy':
        try {
            $Controller->layTatCaNhatKy();
        } catch (Exception $e) {
            echo "<script>alert('Lỗi: " . $e->getMessage() . "');</script>";
        }
        exit;
        break;

    case 'capNhatThoigianDangXuat':
        try {
            $Controller->capNhatThoigianDangXuat();
        } catch (Exception $e) {
            echo "<script>alert('Lỗi: " . $e->getMessage() . "');</script>";
        }
        exit;
        break;


    case 'dangxuat':
        try {
            if (isset($_SESSION['id'])) {
                $Controller->capNhatThoigianDangXuat(); // Cập nhật thời gian đăng xuất
            }
            session_unset();
            session_destroy();
            header("Location: index.php?task=formdangnhap");
            exit;
        } catch (Exception $e) {
            echo "<script>alert('Lỗi: " . $e->getMessage() . "');</script>";
        }
        break;










    case 'themPhieuNhap':
        $Controller->themPhieuNhap(); // Xử lý thêm phiếu nhập

        break;



    case 'xoaPhieuNhap':
        $Controller->xoaPhieuNhap();
        break;








    case 'xoaLichSu':
        if (isset($_GET['id'])) {
            $Controller->xoaLichSu($_GET['id']);
        } else {
            echo json_encode(["status" => "error", "message" => "ID không hợp lệ"]);
        }
        break;



        case 'duyettaikhoan':
            $Controller->duyettaikhoan();
            break;








    case 'getLichSuNhapKho':
        echo json_encode($model->getLichSuNhapKho());
        break;

    case 'getLichSuXuatKho':
        echo json_encode($model->getLichSuXuatKho());
        break;


    case 'getLichSuNhapKho1':


        $Controller->getFilteredLichSu();
        break;

    case 'getLichSuXuatKho1':

        $Controller->getFilteredLichSu1();
        break;

    default:
        include 'templates/formdangnhap.php';
        break;
}

// if (!isset($_GET['task'])) {
//     include __DIR__ . '/templates/formdangnhap.php';
// }
