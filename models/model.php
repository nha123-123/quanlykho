
<?php

// require_once dirname(__FILE__) ."/libs/PHPExcel/PHPExcel.php";
// Đảm bảo đường dẫn đúng, ví dụ nếu thư mục libs nằm ở gốc dự án:
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require 'vendor/autoload.php';
require_once "configs/connect.php";
require_once "models/model.php";
require_once "views/view.php";
class model
{
    private $db;
    public function __construct()
    {
        $connection = new connect();
        $this->db = $connection->getConnection();
    }












    public function layTatCaNhatKy()
    {
        $sql = "SELECT 
                    nk.id, tk.taikhoan1 AS ten_taikhoan, nk.thoigian_dangnhap, nk.thoigian_dangxuat,
                    TIMEDIFF(nk.thoigian_dangxuat, nk.thoigian_dangnhap) AS thoigian_hoatdong
                FROM nhatky_dangnhap nk
                JOIN taikhoan tk ON nk.id_taikhoan = tk.id
                ORDER BY nk.id DESC";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            throw new Exception("Lỗi chuẩn bị SQL: " . $this->db->error);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function themNhatKyDangNhap($id_taikhoan)
    {
        $thoigian_dangnhap = date('Y-m-d H:i:s'); // Lấy thời gian hiện tại


        $sql = "INSERT INTO nhatky_dangnhap (id_taikhoan, thoigian_dangnhap) 
                VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            throw new Exception("Lỗi chuẩn bị SQL: " . $this->db->error);
        }
        $stmt->bind_param("is", $id_taikhoan, $thoigian_dangnhap);
        if (!$stmt->execute()) {
            throw new Exception("Lỗi thực thi SQL: " . $stmt->error);
        }
    }

    public function capNhatThoigianDangXuat($id_taikhoan)
    {
        $sql = "UPDATE nhatky_dangnhap 
            SET thoigian_dangxuat = NOW() 
            WHERE id_taikhoan = ? 
            ORDER BY id DESC 
            LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_taikhoan);
        $stmt->execute();
    }


    public function xoaLichSu($id)
    {
        $sql = "DELETE FROM nhatky_dangnhap WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            throw new Exception("Lỗi chuẩn bị SQL: " . $this->db->error);
        }
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            throw new Exception("Lỗi thực thi SQL: " . $stmt->error);
        }
        return true;
    }
















    public function dangki($taikhoan1, $matkhau, $diachi, $gioitinh, $cap, $email)
    {
        $querykttk = "SELECT * FROM taikhoan WHERE taikhoan1 = ? OR email = ?";
        $stmt = mysqli_prepare($this->db, $querykttk);
        mysqli_stmt_bind_param($stmt, "ss", $taikhoan1, $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            return 'Tài khoản hoặc email đã tồn tại, vui lòng chọn tài khoản hoặc email khác';
        } else {
            $hashed_password = password_hash($matkhau, PASSWORD_DEFAULT);

            // Gán giá trị mặc định nếu $cap bị null
            if ($cap === null) {
                $cap = 2;
            }

            // Ép kiểu để đảm bảo đúng định dạng
            $cap = (int)$cap;

            $query = "INSERT INTO taikhoan (taikhoan1, matkhau, diachi, gioitinh, cap, email) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($this->db, $query);
            mysqli_stmt_bind_param($stmt, "ssssss", $taikhoan1, $hashed_password, $diachi, $gioitinh, $cap, $email);

            if (!mysqli_stmt_execute($stmt)) {
                return 'Lỗi khi thêm tài khoản: ' . mysqli_stmt_error($stmt);
            }

            return 'Đăng ký tài khoản thành công';
        }
    }


    // public function dangnhap($taikhoan1, $matkhau)
    // {
    //     $query = "SELECT * FROM taikhoan WHERE taikhoan1 = ?";
    //     $stmt = mysqli_prepare($this->db, $query);
    //     mysqli_stmt_bind_param($stmt, "s", $taikhoan1);
    //     mysqli_stmt_execute($stmt);
    //     $result = mysqli_stmt_get_result($stmt);

    //     if ($row = mysqli_fetch_assoc($result)) {
    //         // Kiểm tra mật khẩu với password_verify()
    //         if (password_verify($matkhau, $row['matkhau'])) {
    //             return $row; // Đăng nhập thành công
    //         }
    //     }
    //     return false; // Sai tài khoản hoặc mật khẩu
    // }
public function dangnhap($taikhoan1, $matkhau)
{
    $query = "SELECT * FROM taikhoan WHERE taikhoan1 = ? AND duyet = 1";
    $stmt = mysqli_prepare($this->db, $query);
    mysqli_stmt_bind_param($stmt, "s", $taikhoan1);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($matkhau, $row['matkhau'])) {
            return $row;
        }
    }
    return false;
}



    public function duyetTaiKhoan($id)
{
    $query = "UPDATE taikhoan SET duyet = 1 WHERE id = ?";
    $stmt = mysqli_prepare($this->db, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    return mysqli_stmt_execute($stmt);
}


    public function tatcanguoidung()
    {

        $query = "SELECT * FROM taikhoan";
        $result = mysqli_query($this->db, $query);
        return $result;
    }







    public function doiMatKhau($userId, $oldPassword, $newPassword)
    {
        // Lấy thông tin tài khoản theo id
        $stmt = $this->db->prepare("SELECT matkhau FROM taikhoan WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($hashedPassword);
        if (!$stmt->fetch()) {
            $stmt->close();
            return ['success' => false, 'message' => 'Tài khoản không tồn tại.'];
        }
        $stmt->close();

        // Kiểm tra mật khẩu cũ
        if (!password_verify($oldPassword, $hashedPassword)) {
            return ['success' => false, 'message' => 'Mật khẩu cũ không đúng.'];
        }

        // Hash mật khẩu mới
        $newHashed = password_hash($newPassword, PASSWORD_DEFAULT);

        // Cập nhật mật khẩu mới
        $stmt = $this->db->prepare("UPDATE taikhoan SET matkhau = ? WHERE id = ?");
        $stmt->bind_param("si", $newHashed, $userId);
        if ($stmt->execute()) {
            $stmt->close();
            return ['success' => true, 'message' => 'Đổi mật khẩu thành công!'];
        } else {
            $stmt->close();
            return ['success' => false, 'message' => 'Lỗi khi cập nhật mật khẩu.'];
        }
    }



















    public function tatcanguoidung1()
    {
        // Truy vấn lấy tất cả người dùng có cap = 2
        $query = "SELECT * FROM taikhoan WHERE cap = 2";
        $result = mysqli_query($this->db, $query);

        // Kiểm tra kết quả truy vấn
        if ($result) {
            $users = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $users[] = $row; // Thêm từng dòng vào mảng
            }
            return $users; // Trả về mảng kết quả
        }
        return []; // Trả về mảng rỗng nếu có lỗi hoặc không có dữ liệu
    }



    public function thongKeDonXuat()
    {
        $sql = "
            SELECT COUNT(dh.id) as so_luong, 
                   SUM(dhc.soluong * sp.giaxuat) as tong_tien 
            FROM donhang dh
            JOIN donhangchitiet dhc ON dh.id = dhc.id_donhang
            JOIN sanpham sp ON dhc.masp = sp.masp
            WHERE dh.trangthai = 'Đã xuất'
        ";

        $stmt = $this->db->prepare($sql);

        if ($stmt === false) {
            die('Error preparing the SQL query: ' . $this->db->error);
        }

        $stmt->execute();
        $result = mysqli_stmt_get_result($stmt);  // Fetch the result set
        $result = mysqli_fetch_assoc($result);   // Fetch data as an associative array

        // Kiểm tra nếu có dữ liệu
        if ($result) {
            return $result;
        } else {
            return [
                'so_luong' => 0,
                'tong_tien' => 0
            ];
        }
    }


    public function thongKePhieuNhap()
    {
        // Câu lệnh SQL để lấy tổng số lượng phiếu nhập và tổng giá trị nhập từ chi tiết phiếu nhập
        $sql = "
            SELECT COUNT(pn.maphieunhap) AS so_luong, 
                   SUM(ct.soluongnhap * sp.gianhap) AS tong_tien
            FROM phieunhap pn
            JOIN chitietphieunhap ct ON pn.maphieunhap = ct.maphieunhap
            JOIN sanpham sp ON ct.masp = sp.masp
            WHERE pn.ngaynhap IS NOT NULL
        ";

        // Chuẩn bị câu lệnh SQL
        $stmt = $this->db->prepare($sql);

        if ($stmt === false) {
            die('Error preparing the SQL query: ' . $this->db->error);
        }

        // Thực thi câu lệnh SQL
        $stmt->execute();
        $result = mysqli_stmt_get_result($stmt);  // Lấy kết quả
        $result = mysqli_fetch_assoc($result);   // Chuyển kết quả thành mảng kết hợp

        // Kiểm tra nếu có dữ liệu
        if ($result) {
            return $result;
        } else {
            return [
                'so_luong' => 0,
                'tong_tien' => 0
            ];
        }
    }












    public function layTatCaChiTietPhieuNhap()
    {
        $stmt = $this->db->prepare("
            SELECT pn.maphieunhap, ctpn.masp, sp.tensp, ctpn.soluongnhap, ctpn.gianhap,
                   (ctpn.soluongnhap * ctpn.gianhap) AS thanhtien
            FROM chitietphieunhap ctpn
            JOIN sanpham sp ON ctpn.masp = sp.masp
            JOIN phieunhap pn ON ctpn.maphieunhap = pn.maphieunhap
            ORDER BY pn.maphieunhap DESC
        ");
        $stmt->execute();
        $result = $stmt->get_result();

        $groupedData = [];

        while ($row = $result->fetch_assoc()) {
            $maphieunhap = $row['maphieunhap'];
            if (!isset($groupedData[$maphieunhap])) {
                $groupedData[$maphieunhap] = [
                    'maphieunhap' => $maphieunhap,
                    'chitiet' => []
                ];
            }
            $groupedData[$maphieunhap]['chitiet'][] = [
                'masp' => $row['masp'],
                'tensp' => $row['tensp'],
                'soluongnhap' => $row['soluongnhap'],
                'gianhap' => $row['gianhap'],
                'thanhtien' => $row['thanhtien']
            ];
        }

        // Chuyển từ dạng associative array sang indexed array
        $data = array_values($groupedData);

        header('Content-Type: application/json');
        echo json_encode($data);
    }







    public function layTatCaChiTietDonHangXuat()
    {
        $stmt = $this->db->prepare("
            SELECT dh.id AS id_donhang, dh.ngayxuat, dhct.masp, sp.tensp, dhct.soluong, sp.giaxuat,
                   (dhct.soluong * sp.giaxuat) AS thanhtien
            FROM donhangchitiet dhct
            JOIN sanpham sp ON dhct.masp = sp.masp
            JOIN donhang dh ON dhct.id_donhang = dh.id
            WHERE dh.trangthai = 'Đã xuất'
            ORDER BY dh.id DESC
        ");

        if (!$stmt) {
            die('Lỗi prepare SQL: ' . $this->db->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $groupedData = [];

        while ($row = $result->fetch_assoc()) {
            $id_donhang = $row['id_donhang'];
            if (!isset($groupedData[$id_donhang])) {
                $groupedData[$id_donhang] = [
                    'id_donhang' => $id_donhang,
                    'ngayxuat' => $row['ngayxuat'],
                    'chitiet' => []
                ];
            }
            $groupedData[$id_donhang]['chitiet'][] = [
                'masp' => $row['masp'],
                'tensp' => $row['tensp'],
                'soluong' => $row['soluong'],
                'giaxuat' => $row['giaxuat'],
                'thanhtien' => $row['thanhtien']
            ];
        }

        $data = array_values($groupedData);

        header('Content-Type: application/json');
        echo json_encode($data);
    }












    // public function layTatCaTonKho() {
    //     $sql = "SELECT masp, tensp, soluongton FROM sanpham";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->execute();

    //     $result = mysqli_stmt_get_result($stmt);
    //     $data = [];
    //     while ($row = mysqli_fetch_assoc($result)) {
    //         $data[] = $row;
    //     }
    //     return $data;
    // }



    public function layTatCaTonKho()
    {
        $sql = "
            SELECT 
                sp.masp,
                sp.tensp,
                IFNULL(tongnhap.soluongnhap, 0) AS tongnhap,
                IFNULL(tongxuat.soluongxuat, 0) AS tongxuat,
                sp.soluongton
            FROM sanpham sp
            LEFT JOIN (
                SELECT masp, SUM(soluongnhap) AS soluongnhap
                FROM chitietphieunhap
                GROUP BY masp
            ) AS tongnhap ON sp.masp = tongnhap.masp
            LEFT JOIN (
                SELECT masp, SUM(soluong) AS soluongxuat
                FROM donhangchitiet
                GROUP BY masp
            ) AS tongxuat ON sp.masp = tongxuat.masp
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = mysqli_stmt_get_result($stmt);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }








    ///////////////////////////////////////////////////



    public function getTonKho()
    {
        $sql = "SELECT masp, tensp, donvitinh, soluongton, giaxuat FROM sanpham";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = mysqli_stmt_get_result($stmt);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    // Báo cáo doanh thu
    public function getDoanhThu()
    {
        $sql = "
            SELECT 
                dhct.masp,
                sp.tensp,
                SUM(dhct.soluong) AS tong_ban,
                sp.giaxuat,
                SUM(dhct.soluong * sp.giaxuat) AS doanhthu
            FROM donhangchitiet dhct
            JOIN sanpham sp ON dhct.masp = sp.masp
            GROUP BY dhct.masp, sp.tensp, sp.giaxuat
        ";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            die('Lỗi chuẩn bị SQL: ' . $this->db->error);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }













    public function deleteDonHang($id)
    {
        // Bắt đầu transaction để đảm bảo toàn vẹn dữ liệu
        $this->db->begin_transaction();
        try {
            // Xóa chi tiết đơn hàng trước
            $stmt1 = $this->db->prepare("DELETE FROM donhangchitiet WHERE id_donhang = ?");
            $stmt1->bind_param("i", $id);
            if (!$stmt1->execute()) {
                throw new Exception("Lỗi khi xóa chi tiết đơn hàng!");
            }

            // Xóa đơn hàng
            $stmt2 = $this->db->prepare("DELETE FROM donhang WHERE id = ?");
            $stmt2->bind_param("i", $id);
            if (!$stmt2->execute()) {
                throw new Exception("Lỗi khi xóa đơn hàng!");
            }

            $this->db->commit();
            return ['success' => true];
        } catch (Exception $e) {
            $this->db->rollback();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
















    public function tatcasanpham()
    {

        $query = "SELECT * FROM sanpham";
        $result = mysqli_query($this->db, $query);
        return $result;
    }


    public function tatcasanpham1()
    {
        $query = "SELECT * FROM sanpham";
        $result = mysqli_query($this->db, $query);

        $sanphamList = []; // Tạo mảng lưu sản phẩm
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $sanphamList[] = $row;
            }
        }
        return $sanphamList;
    }





    public function xoataikhoan($id)
    {
        $query = "DELETE FROM taikhoan WHERE id = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }


    // public function xoasanpham($masp)
    // {
    //     $query = "DELETE FROM sanpham WHERE masp = ?";
    //     $stmt = $this->db->prepare($query);
    //     $stmt->bind_param("s", $masp);
    //     return $stmt->execute();
    // }



    public function xoachitietphieunhap_theo_masp($masp)
    {
        $query = "DELETE FROM chitietphieunhap WHERE masp = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $masp);
        return $stmt->execute();
    }

    public function xoasanpham($masp)
    {
        // Xóa chi tiết phiếu nhập trước
        $this->xoachitietphieunhap_theo_masp($masp);

        // Xóa sản phẩm
        $query = "DELETE FROM sanpham WHERE masp = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $masp);
        return $stmt->execute();
    }








    //tututuutut
    public function laySanPhamTheoMa($masp)
    {
        $query = "SELECT masp, tensp, donvitinh, soluongton, gianhap, giaxuat, mota, ngaytao, ngaycapnhat
                  FROM sanpham
                  WHERE masp = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "s", $masp);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }
    public function capNhatSanPham($masp, $tensp, $donvitinh, $soluongton, $gianhap, $giaxuat, $mota, $hinhanhPath, $ngaytao, $ngaycapnhat)
    {
        $query = "UPDATE sanpham 
                  SET tensp = ?, donvitinh = ?, soluongton = ?, gianhap = ?, giaxuat = ?, mota = ?, hinhanh = ?, ngaytao = ?, ngaycapnhat = ?
                  WHERE masp = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "ssssssssss", $tensp, $donvitinh, $soluongton, $gianhap, $giaxuat, $mota, $hinhanhPath, $ngaytao, $ngaycapnhat, $masp);
        return mysqli_stmt_execute($stmt);
    }




    public function suataikhoan()
    {
        $query = "SELECT *
                  FROM taikhoan
                  WHERE id = '{$_GET['id']}'";
        $result = mysqli_query($this->db, $query);
        return $result->fetch_assoc();
    }








    public function suataikhoan1($id, $taikhoan1, $matkhau, $diachi, $gioitinh, $cap)
    {
        $query = "UPDATE taikhoan SET 
                taikhoan1 = '$taikhoan1', 
                matkhau = '$matkhau', 
                diachi = '$diachi', 
                gioitinh = '$gioitinh', 
                cap = '$cap' 
              WHERE id = '$id'";
        $result = mysqli_query($this->db, $query);
        return $result;
    }




    public function themsanpham($masp, $tensp, $donvitinh, $soluongton, $gianhap, $giaxuat, $mota, $hinhanh)
    {
        $query_ktmasp = "SELECT * FROM sanpham WHERE masp = '$masp'";
        $ktmasp = mysqli_query($this->db, $query_ktmasp);
        if (mysqli_num_rows($ktmasp) > 0) {
            return 'Mã sản phẩm đã tồn tại, vui lòng chọn mã khác';
        } else {
            $query = "INSERT INTO sanpham 
                  (masp, tensp, donvitinh, soluongton, gianhap, giaxuat, mota, hinhanh, ngaytao, ngaycapnhat) 
                  VALUES 
                  ('$masp', '$tensp', '$donvitinh', '$soluongton', '$gianhap', '$giaxuat', '$mota', '$hinhanh', NOW(), NOW())";
            mysqli_query($this->db, $query);
            return 'Thêm sản phẩm thành công';
        }
    }





    public function themtaikhoan($taikhoan1, $matkhau, $diachi, $gioitinh, $cap)
    {
        $queryktemail = "SELECT * FROM taikhoan WHERE taikhoan1 = '$taikhoan1'";
        $ktemail = mysqli_query($this->db, $queryktemail);
        if (mysqli_num_rows($ktemail) > 0) {
            return 'Tài khoản đã tồn tại, vui lòng sử dụng tên khác';
        } else {
            $query = "INSERT INTO taikhoan 
                  (taikhoan1, matkhau, diachi, gioitinh, cap) 
                  VALUES 
                  ('$taikhoan1', '$matkhau', '$diachi', '$gioitinh', '$cap')";
            mysqli_query($this->db, $query);
            return 'Thêm người dùng thành công';
        }
    }























    public function getInterestRates()
    {
        $query = "SELECT ngaytao AS date, giaxuat AS interest_rate FROM sanpham WHERE giaxuat IS NOT NULL";
        $result = $this->db->query($query);
        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }



    // public function getDonHangData()
    // {
    //     $currentMonth = date('m');
    //     $currentYear = date('Y');
    //     $query = "SELECT id, ngaylap, trangthai FROM donhang WHERE MONTH(ngaylap) = $currentMonth AND YEAR(ngaylap) = $currentYear";

    //     $result = $this->db->query($query);

    //     if (!$result) {
    //         throw new Exception("Lỗi khi lấy dữ liệu đơn hàng: " . $this->db->error);
    //     }

    //     $data = [];
    //     while ($row = $result->fetch_assoc()) {
    //         $data[] = $row;
    //     }

    //     if (empty($data)) {
    //         throw new Exception("Không có đơn hàng nào trong tháng này.");
    //     }

    //     return $data;
    // }
public function getDonHangData($id_nhanvien)
{
    $query = "SELECT id, ngaylap, trangthai, id_nhanvien, diachi 
              FROM donhang 
              WHERE id_nhanvien = " . intval($id_nhanvien);

    $result = $this->db->query($query);

    if (!$result) {
        throw new Exception("Lỗi khi lấy dữ liệu đơn hàng: " . $this->db->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    if (empty($data)) {
        throw new Exception("Không có đơn hàng nào cho nhân viên này.");
    }

    return $data;
}






    // Thêm đơn hàng mới
    // Thêm đơn hàng mới

    public function themDonHang($id_nhanvien, $diachi)
    {
        $stmt = $this->db->prepare("INSERT INTO donhang (id_nhanvien, diachi) VALUES (?, ?)");
        $stmt->bind_param("is", $id_nhanvien, $diachi);
        if ($stmt->execute()) {
            return $this->db->insert_id;
        }
        return false;
    }

    // Thêm chi tiết đơn hàng
    public function themChiTietDonHang($id_donhang, $masp, $soluong)
    {
        $stmt = $this->db->prepare("INSERT INTO donhangchitiet (id_donhang, masp, soluong) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $id_donhang, $masp, $soluong);
        return $stmt->execute();
    }

    // Lấy số lượng tồn kho của sản phẩm
    public function laySoLuongTon($masp)
    {
        $soluongton = null; // Declare the variable before binding
        $stmt = $this->db->prepare("SELECT soluongton FROM sanpham WHERE masp = ?");
        $stmt->bind_param("s", $masp);
        $stmt->execute();
        $stmt->bind_result($soluongton);
        $stmt->fetch();
        return $soluongton;
    }

    // Cập nhật số lượng tồn khi xuất kho
    public function giamSoLuongTon($masp, $soluong)
    {
        $stmt = $this->db->prepare("UPDATE sanpham SET soluongton = soluongton - ? WHERE masp = ?");
        $stmt->bind_param("is", $soluong, $masp);
        return $stmt->execute();
    }



    public function getAllDonHang()
    {
        $sql = "SELECT * FROM donhang ORDER BY id DESC";
        $result = $this->db->query($sql);
        $donhangs = [];

        while ($row = $result->fetch_assoc()) {
            $donhangs[] = $row;
        }

        return $donhangs;
    }

    // public function updateTrangThai($id, $trangthai)
    // {
    //     $query = "UPDATE donhang SET trangthai = ? WHERE id = ?";
    //     $stmt = $this->db->prepare($query);
    //     $stmt->bind_param("si", $trangthai, $id);
    //     return $stmt->execute();
    // }


    public function updateTrangThai($id, $trangthai, $ngayxuat = null)
    {
        if ($trangthai === 'Đã xuất') {
            $query = "UPDATE donhang SET trangthai = ?, ngayxuat = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ssi", $trangthai, $ngayxuat, $id);
        } else {
            $query = "UPDATE donhang SET trangthai = ?, ngayxuat = NULL WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("si", $trangthai, $id);
        }

        return $stmt->execute();
    }




    public function getDonHangChiTiet($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            echo json_encode(['error' => 'ID không hợp lệ']);
            exit;
        }

        $query = "
            SELECT 
                c.id_donhang,
                c.masp,
                c.soluong,
                s.tensp,
                s.giaxuat,
                s.hinhanh
            FROM donhangchitiet c
            JOIN sanpham s ON c.masp = s.masp
            WHERE c.id_donhang = ?";

        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            echo json_encode(['error' => 'Lỗi chuẩn bị truy vấn: ' . $this->db->error]);
            exit;
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $details = [];

        while ($row = $result->fetch_assoc()) {
            $details[] = $row;
        }

        $stmt->close();

        if (empty($details)) {
            echo json_encode(['error' => 'Không tìm thấy chi tiết đơn hàng']);
            exit;
        }

        header('Content-Type: application/json');
        echo json_encode($details);
        exit;
    }



















    public function xuatExcelPhieuNhap()
    {
        if (ob_get_length()) {
            ob_end_clean();
        }

        $query = "
        SELECT pn.maphieunhap, pn.ngaynhap, tk.taikhoan1
        FROM phieunhap pn
        LEFT JOIN taikhoan tk ON pn.id_nguoinhap = tk.id
        ORDER BY pn.maphieunhap
    ";
        $result = mysqli_query($this->db, $query);

        if (!$result) {
            die('Lỗi truy vấn SQL: ' . mysqli_error($this->db));
        }

        $danhsach = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $danhsach[] = $row;
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // --- PHIẾU NHẬP ---
        $sheet->setCellValue('A1', 'Mã phiếu nhập')
            ->setCellValue('B1', 'Ngày nhập')
            ->setCellValue('C1', 'Người nhập')
            ->setCellValue('D1', 'Mã SP')
            ->setCellValue('E1', 'Số lượng nhập')
            ->setCellValue('F1', 'Giá nhập')
            ->setCellValue('G1', 'Nguồn nhập');

        $row_num = 2;

        foreach ($danhsach as $pn) {
            $maphieunhap = $pn['maphieunhap'];
            $query_ct = "
            SELECT masp, soluongnhap, gianhap, nguonnhap
            FROM chitietphieunhap
            WHERE maphieunhap = '$maphieunhap'
        ";
            $result_ct = mysqli_query($this->db, $query_ct);

            if ($result_ct && mysqli_num_rows($result_ct) > 0) {
                while ($ct = mysqli_fetch_assoc($result_ct)) {
                    $sheet->setCellValue('A' . $row_num, $maphieunhap)
                        ->setCellValue('B' . $row_num, $pn['ngaynhap'])
                        ->setCellValue('C' . $row_num, $pn['taikhoan1'])
                        ->setCellValue('D' . $row_num, $ct['masp'])
                        ->setCellValue('E' . $row_num, $ct['soluongnhap'])
                        ->setCellValue('F' . $row_num, $ct['gianhap'])
                        ->setCellValue('G' . $row_num, $ct['nguonnhap']);
                    $row_num++;
                }
            } else {
                $sheet->setCellValue('A' . $row_num, $maphieunhap)
                    ->setCellValue('B' . $row_num, $pn['ngaynhap'])
                    ->setCellValue('C' . $row_num, $pn['taikhoan1']);
                $row_num++;
            }
        }

        // --- DÒNG CÁCH ---
        $row_num += 2;

        // --- ĐƠN HÀNG ---
        $sheet->setCellValue('A' . $row_num, 'Mã đơn hàng')
            ->setCellValue('B' . $row_num, 'Nhân viên lập')
            ->setCellValue('C' . $row_num, 'Ngày lập')
            ->setCellValue('D' . $row_num, 'Địa chỉ')
            ->setCellValue('E' . $row_num, 'Trạng thái')
            ->setCellValue('F' . $row_num, 'Ngày xuất')
            ->setCellValue('G' . $row_num, 'Mã SP')
            ->setCellValue('H' . $row_num, 'Số lượng');

        $row_num++;

        $query_donhang = "
        SELECT dh.id AS madonhang, dh.id_nhanvien, dh.ngaylap, dh.diachi, dh.trangthai, dh.ngayxuat, tk.taikhoan1
        FROM donhang dh
        LEFT JOIN taikhoan tk ON dh.id_nhanvien = tk.id
        ORDER BY dh.id
    ";
        $result_dh = mysqli_query($this->db, $query_donhang);

        if ($result_dh && mysqli_num_rows($result_dh) > 0) {
            while ($dh = mysqli_fetch_assoc($result_dh)) {
                $madonhang = $dh['madonhang'];
                $query_ctdh = "
                SELECT masp, soluong
                FROM donhangchitiet
                WHERE id_donhang = '$madonhang'
            ";
                $result_ctdh = mysqli_query($this->db, $query_ctdh);

                if ($result_ctdh && mysqli_num_rows($result_ctdh) > 0) {
                    while ($ct = mysqli_fetch_assoc($result_ctdh)) {
                        $sheet->setCellValue('A' . $row_num, $madonhang)
                            ->setCellValue('B' . $row_num, $dh['taikhoan1'])
                            ->setCellValue('C' . $row_num, $dh['ngaylap'])
                            ->setCellValue('D' . $row_num, $dh['diachi'])
                            ->setCellValue('E' . $row_num, $dh['trangthai'])
                            ->setCellValue('F' . $row_num, $dh['ngayxuat'])
                            ->setCellValue('G' . $row_num, $ct['masp'])
                            ->setCellValue('H' . $row_num, $ct['soluong']);
                        $row_num++;
                    }
                } else {
                    $sheet->setCellValue('A' . $row_num, $madonhang)
                        ->setCellValue('B' . $row_num, $dh['taikhoan1'])
                        ->setCellValue('C' . $row_num, $dh['ngaylap'])
                        ->setCellValue('D' . $row_num, $dh['diachi'])
                        ->setCellValue('E' . $row_num, $dh['trangthai'])
                        ->setCellValue('F' . $row_num, $dh['ngayxuat']);
                    $row_num++;
                }
            }
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="phieunhap_donhang.xlsx"');
        header('Cache-Control: max-age=0');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }




    // Cập nhật số lượng sản phẩm khi nhập kho












    public function importExcelSanPham()
    {
        if (!isset($_FILES['fileExcel']) || $_FILES['fileExcel']['error'] !== UPLOAD_ERR_OK) {
            die("Vui lòng chọn file Excel hợp lệ.");
        }



        $filePath = $_FILES['fileExcel']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $conn = $this->db; // Kết nối CSDL

        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];

            if (empty($row[0])) continue; // Bỏ qua dòng rỗng

            // Gán từng cột một cách an toàn
            $masp        = isset($row[0]) ? mysqli_real_escape_string($conn, $row[0]) : '';
            $tensp       = isset($row[1]) ? mysqli_real_escape_string($conn, $row[1]) : '';
            $donvitinh   = isset($row[2]) ? mysqli_real_escape_string($conn, $row[2]) : '';
            $soluongton  = isset($row[3]) ? (int)$row[3] : 0;
            $gianhap     = isset($row[4]) ? (float)$row[4] : 0;
            $giaxuat     = isset($row[5]) ? (float)$row[5] : 0;
            $mota        = isset($row[6]) ? mysqli_real_escape_string($conn, $row[6]) : '';
            $hinhanh     = isset($row[7]) ? mysqli_real_escape_string($conn, $row[7]) : '';

            // Ngày tạo & cập nhật
            $ngaytao_raw     = isset($row[8]) ? $row[8] : '';
            $ngaycapnhat_raw = isset($row[9]) ? $row[9] : '';

            $ngaytao = (!empty($ngaytao_raw) && strtotime($ngaytao_raw)) ? date('Y-m-d H:i:s', strtotime($ngaytao_raw)) : null;
            $ngaycapnhat = (!empty($ngaycapnhat_raw) && strtotime($ngaycapnhat_raw)) ? date('Y-m-d H:i:s', strtotime($ngaycapnhat_raw)) : null;

            // Xây dựng câu SQL
            $sql = "
            INSERT INTO sanpham (masp, tensp, donvitinh, soluongton, gianhap, giaxuat, mota, hinhanh, ngaytao, ngaycapnhat)
            VALUES ('$masp', '$tensp', '$donvitinh', $soluongton, $gianhap, $giaxuat, '$mota', '$hinhanh',
                " . ($ngaytao ? "'$ngaytao'" : "NULL") . ", " . ($ngaycapnhat ? "'$ngaycapnhat'" : "NULL") . ")
            ON DUPLICATE KEY UPDATE
                tensp = VALUES(tensp),
                donvitinh = VALUES(donvitinh),
                soluongton = VALUES(soluongton),
                gianhap = VALUES(gianhap),
                giaxuat = VALUES(giaxuat),
                mota = VALUES(mota),
                hinhanh = VALUES(hinhanh),
                ngaytao = VALUES(ngaytao),
                ngaycapnhat = VALUES(ngaycapnhat)
        ";

            if (!mysqli_query($conn, $sql)) {
                echo "❌ Lỗi dòng $i: " . mysqli_error($conn) . "<br>";
            }
        }

        echo "<div class='alert alert-success'>✅ Nhập dữ liệu thành công!</div>";
    }


public function importExcelPhieuNhap()
{
    if (!isset($_FILES['fileExcel']) || $_FILES['fileExcel']['error'] !== UPLOAD_ERR_OK) {
        die("Vui lòng chọn file Excel hợp lệ.");
    }

    $filePath = $_FILES['fileExcel']['tmp_name'];
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    if (count($rows) < 2) {
        die("File Excel không có dữ liệu");
    }

    $conn = $this->db;

    $nguoinhap = $_SESSION['taikhoan1'] ?? null;
    if (!$nguoinhap) {
        die("Bạn chưa đăng nhập hoặc không xác định được người nhập.");
    }

    $dsPhieuThanhCong = [];

    for ($i = 1; $i < count($rows); $i++) {
        $row = $rows[$i];

        $ngaynhap_raw = $row[0] ?? null;
        $ngaynhap = $ngaynhap_raw ? date('Y-m-d H:i:s', strtotime($ngaynhap_raw)) : date('Y-m-d H:i:s');

        $mahang = isset($row[1]) ? mysqli_real_escape_string($conn, $row[1]) : '';
        $soluongnhap = isset($row[2]) ? (int)$row[2] : 0;
        $gianhap = isset($row[3]) ? (float)$row[3] : 0;
        $nguonnhap = isset($row[4]) ? mysqli_real_escape_string($conn, $row[4]) : '';

        if (empty($mahang) || $soluongnhap <= 0) continue;

        try {
            $maphieunhap = $this->themPhieuNhap($ngaynhap, $nguoinhap);
            $dsPhieuThanhCong[] = $maphieunhap;
        } catch (Exception $e) {
            echo "❌ Lỗi tạo phiếu nhập dòng $i: " . $e->getMessage() . "<br>";
            continue;
        }

        $sqlGet = "SELECT soluongton FROM sanpham WHERE masp = '$mahang' LIMIT 1";
        $resGet = mysqli_query($conn, $sqlGet);

        if ($resGet && mysqli_num_rows($resGet) > 0) {
            $rowGet = mysqli_fetch_assoc($resGet);
            $soluongton_moi = $rowGet['soluongton'] + $soluongnhap;
            $sqlUpdate = "UPDATE sanpham SET soluongton = $soluongton_moi WHERE masp = '$mahang'";
            mysqli_query($conn, $sqlUpdate);
        } else {
            echo "⚠️ Mã hàng <b>$mahang</b> không tồn tại trong danh sách sản phẩm (dòng $i).<br>";
            continue;
        }

        $sqlInsertCT = "INSERT INTO chitietphieunhap (maphieunhap, masp, soluongnhap, gianhap, nguonnhap)
                        VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sqlInsertCT);
        if ($stmt) {
            $stmt->bind_param("isids", $maphieunhap, $mahang, $soluongnhap, $gianhap, $nguonnhap);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "❌ Lỗi chuẩn bị chi tiết phiếu nhập dòng $i: " . $this->db->error . "<br>";
        }
    }

    if (count($dsPhieuThanhCong) > 0) {
        echo "<div class='alert alert-success'>";
        echo "✅ Đã nhập thành công các phiếu nhập sau:<br>";
        foreach ($dsPhieuThanhCong as $mpn) {
            echo "- Mã phiếu nhập: <b>$mpn</b><br>";
        }
        echo "</div>";
    } else {
        echo "<div class='alert alert-danger'>Không có phiếu nhập nào được tạo.</div>";
    }
}




// public function importExcelPhieuNhap()
// {
//     if (!isset($_FILES['fileExcel']) || $_FILES['fileExcel']['error'] !== UPLOAD_ERR_OK) {
//         die("Vui lòng chọn file Excel hợp lệ.");
//     }

//     $filePath = $_FILES['fileExcel']['tmp_name'];
//     $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
//     $sheet = $spreadsheet->getActiveSheet();
//     $rows = $sheet->toArray();

//     if (count($rows) < 2) {
//         die("File Excel không có dữ liệu");
//     }

//     $conn = $this->db;

//     // Lấy người nhập từ session
//     $nguoinhap = $_SESSION['taikhoan1'] ?? null;
//     if (!$nguoinhap) {
//         die("Bạn chưa đăng nhập hoặc không xác định được người nhập.");
//     }

//     // Lấy ngày nhập từ dòng 2 cột 0 nếu có, nếu không lấy thời gian hiện tại
//     $ngaynhap_raw = $rows[1][0] ?? null;
//     $ngaynhap = $ngaynhap_raw ? date('Y-m-d H:i:s', strtotime($ngaynhap_raw)) : date('Y-m-d H:i:s');

//     // Tạo phiếu nhập và lấy mã phiếu nhập trả về
//     try {
//         $maphieunhap = $this->themPhieuNhap($ngaynhap, $nguoinhap);
//     } catch (Exception $e) {
//         die("Lỗi tạo phiếu nhập: " . $e->getMessage());
//     }

//     // Bắt đầu đọc dữ liệu từ dòng 2 trở đi
//     for ($i = 1; $i < count($rows); $i++) {
//         $row = $rows[$i];

//         $mahang = isset($row[1]) ? mysqli_real_escape_string($conn, $row[1]) : '';
//         $soluongnhap = isset($row[2]) ? (int)$row[2] : 0;
//         $gianhap = isset($row[3]) ? (float)$row[3] : 0;
//         $nguonnhap = isset($row[4]) ? mysqli_real_escape_string($conn, $row[4]) : '';

//         if (empty($mahang) || $soluongnhap <= 0) continue;

//         // Kiểm tra sản phẩm có tồn tại hay không
//         $sqlGet = "SELECT soluongton FROM sanpham WHERE masp = '$mahang' LIMIT 1";
//         $resGet = mysqli_query($conn, $sqlGet);

//         if ($resGet && mysqli_num_rows($resGet) > 0) {
//             $rowGet = mysqli_fetch_assoc($resGet);
//             $soluongton_moi = $rowGet['soluongton'] + $soluongnhap;

//             // Cập nhật tồn kho
//             $sqlUpdate = "UPDATE sanpham SET soluongton = $soluongton_moi WHERE masp = '$mahang'";
//             mysqli_query($conn, $sqlUpdate);
//         } else {
//             echo "Mã hàng <b>$mahang</b> không tồn tại trong danh sách sản phẩm.<br>";
//             continue;
//         }

//         // Thêm chi tiết phiếu nhập bao gồm nhà cung cấp (nguonnhap)
//         $sqlInsertCT = "INSERT INTO chitietphieunhap (maphieunhap, masp, soluongnhap, gianhap, nguonnhap)
//                         VALUES (?, ?, ?, ?, ?)";
//         $stmt = $this->db->prepare($sqlInsertCT);
//         if ($stmt) {
//             $stmt->bind_param("isids", $maphieunhap, $mahang, $soluongnhap, $gianhap, $nguonnhap);
//             $stmt->execute();
//             $stmt->close();
//         } else {
//             echo "Lỗi chuẩn bị câu lệnh chi tiết phiếu nhập: " . $this->db->error . "<br>";
//         }
//     }

//     echo "<div class='alert alert-success'>✅ Nhập phiếu nhập thành công! Mã phiếu nhập: <b>$maphieunhap</b></div>";
// }




// public function importExcelXuatKho()
// {
//     if (!isset($_FILES['fileExcel']) || $_FILES['fileExcel']['error'] !== UPLOAD_ERR_OK) {
//         die("Vui lòng chọn file Excel hợp lệ.");
//     }

//     $filePath = $_FILES['fileExcel']['tmp_name'];
//     $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
//     $sheet = $spreadsheet->getActiveSheet();
//     $rows = $sheet->toArray();

//     if (count($rows) < 2) {
//         die("File Excel không có dữ liệu");
//     }

//     $conn = $this->db;
//     $dsDonHangThanhCong = [];
//     $currentDonHangId = null;
//     $currentNhanVienId = null;
//     $currentDiaChi = null;

//     for ($i = 1; $i < count($rows); $i++) {
//         $row = $rows[$i];

//         // Cột 0: Nhân viên, Cột 1: Mã hàng, Cột 2: Số lượng, Cột 3: Gửi đến địa chỉ
//         $ma_nhanvien = isset($row[0]) ? trim($row[0]) : '';
//         $masp = isset($row[1]) ? mysqli_real_escape_string($conn, $row[1]) : '';
//         $soluong = isset($row[2]) ? (int)$row[2] : 0;
//         $diachi = isset($row[3]) ? trim($row[3]) : '';

//         if (empty($ma_nhanvien) || empty($masp) || $soluong <= 0 || empty($diachi)) continue;

//         // Lấy id nhân viên từ mã nhân viên (có thể là username hoặc id)
//         $stmtNV = $this->db->prepare("SELECT id FROM taikhoan WHERE taikhoan1 = ? OR id = ?");
//         $stmtNV->bind_param("si", $ma_nhanvien, $ma_nhanvien);
//         $stmtNV->execute();
//         $stmtNV->bind_result($id_nhanvien);
//         if (!$stmtNV->fetch()) {
//             echo "⚠️ Nhân viên <b>$ma_nhanvien</b> không tồn tại (dòng $i).<br>";
//             $stmtNV->close();
//             continue;
//         }
//         $stmtNV->close();

//         // Kiểm tra tồn kho
//         $sqlGet = "SELECT soluongton FROM sanpham WHERE masp = '$masp' LIMIT 1";
//         $resGet = mysqli_query($conn, $sqlGet);

//         if ($resGet && mysqli_num_rows($resGet) > 0) {
//             $rowGet = mysqli_fetch_assoc($resGet);
//             if ($rowGet['soluongton'] < $soluong) {
//                 echo "⚠️ Không đủ tồn kho cho mã sản phẩm <b>$masp</b> (dòng $i).<br>";
//                 continue;
//             }
//         } else {
//             echo "⚠️ Mã sản phẩm <b>$masp</b> không tồn tại (dòng $i).<br>";
//             continue;
//         }

//         // Nếu nhân viên hoặc địa chỉ thay đổi thì tạo đơn hàng mới
//         if ($currentNhanVienId !== $id_nhanvien || $currentDiaChi !== $diachi) {
//             $stmt = $this->db->prepare("INSERT INTO donhang (id_nhanvien, diachi, trangthai, ngayxuat) VALUES (?, ?, 'Đã xuất', NOW())");
//             $stmt->bind_param("is", $id_nhanvien, $diachi);
//             if ($stmt->execute()) {
//                 $currentDonHangId = $this->db->insert_id;
//                 $dsDonHangThanhCong[] = $currentDonHangId;
//                 $currentNhanVienId = $id_nhanvien;
//                 $currentDiaChi = $diachi;
//             } else {
//                 echo "❌ Lỗi tạo đơn hàng dòng $i: " . $stmt->error . "<br>";
//                 continue;
//             }
//         }

//         // Thêm chi tiết đơn hàng
//         $stmtCT = $this->db->prepare("INSERT INTO donhangchitiet (id_donhang, masp, soluong) VALUES (?, ?, ?)");
//         $stmtCT->bind_param("isi", $currentDonHangId, $masp, $soluong);
//         if (!$stmtCT->execute()) {
//             echo "❌ Lỗi thêm chi tiết đơn hàng dòng $i: " . $stmtCT->error . "<br>";
//             continue;
//         }

//         // Trừ tồn kho
//         $sqlUpdate = "UPDATE sanpham SET soluongton = soluongton - $soluong WHERE masp = '$masp'";
//         mysqli_query($conn, $sqlUpdate);
//     }

//     if (count($dsDonHangThanhCong) > 0) {
//         echo "<div class='alert alert-success'>";
//         echo "✅ Đã xuất kho thành công các đơn hàng sau:<br>";
//         foreach ($dsDonHangThanhCong as $dhid) {
//             echo "- Mã đơn hàng: <b>$dhid</b><br>";
//         }
//         echo "</div>";
//     } else {
//         echo "<div class='alert alert-danger'>Không có đơn hàng nào được tạo.</div>";
//     }
// }












































public function getDonHangDaXuat() {
    $sql = "SELECT dh.*, ct.masp, ct.soluong, tk.taikhoan1 AS ten_nhanvien
            FROM donhang dh 
            JOIN donhangchitiet ct ON dh.id = ct.id_donhang
            JOIN taikhoan tk ON dh.id_nhanvien = tk.id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}














    // // Thêm phiếu nhập mới
    public function tatca_phieunhap()
    {
        $query = "SELECT p.maphieunhap, p.ngaynhap, t.taikhoan1, c.nguonnhap
                  FROM phieunhap p
                  JOIN taikhoan t ON p.id_nguoinhap = t.id
                  JOIN chitietphieunhap c ON p.maphieunhap = c.maphieunhap";
        return mysqli_query($this->db, $query);
    }





    public function chitiet_phieunhap($maphieunhap)
    {
        $query = "SELECT c.masp, s.tensp, c.soluongnhap, c.gianhap 
                  FROM chitietphieunhap c
                  JOIN sanpham s ON c.masp = s.masp
                  WHERE c.maphieunhap = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $maphieunhap);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // ✅ Trả về mảng, KHÔNG echo
    }





    public function getAllSanPham()
    {
        try {
            $query = "SELECT masp, tensp FROM sanpham";
            $stmt = $this->db->prepare($query);

            if (!$stmt) {
                throw new Exception("Lỗi chuẩn bị SQL: " . $this->db->error);
            }

            if (!$stmt->execute()) {
                throw new Exception("Lỗi thực thi SQL: " . $stmt->error);
            }

            $sanphamList = [];



            $stmt->close();

            // Debug xem có dữ liệu không
            error_log("Dữ liệu sản phẩm lấy được: " . print_r($sanphamList, true));

            return $sanphamList;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }



    public function getPhieuNhapById($id)
    {
        // Kiểm tra nếu id không phải là null và truy vấn
        if ($id !== null) {
            $stmt = $this->db->prepare("SELECT * FROM phieunhap WHERE maphieunhap = ?");

            // Kiểm tra việc binding và thực thi câu lệnh
            if ($stmt === false) {
                // Nếu chuẩn bị câu lệnh không thành công
                return null;
            }

            $stmt->bind_param("i", $id); // Bind id vào câu lệnh

            if (!$stmt->execute()) {
                // Nếu câu lệnh không thực thi được
                return null;
            }

            // Lấy kết quả và trả về bản ghi đầu tiên
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return $result->fetch_assoc(); // Trả về bản ghi phiếu nhập
            }
        }

        return null; // Nếu không có id hoặc không có kết quả, trả về null
    }



    public function insertPhieuNhap($maphieunhap, $ngaynhap, $id_nguoinhap, $masp, $soluongnhap, $gianhap)
    {
        $stmt = $this->db->prepare("INSERT INTO phieunhap (maphieunhap, ngaynhap, id_nguoinhap, masp, soluongnhap, gianhap) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssii", $maphieunhap, $ngaynhap, $id_nguoinhap, $masp, $soluongnhap, $gianhap);
        $stmt->execute();
    }

    public function getAllPhieuNhap()
    {
        $stmt = $this->db->prepare("SELECT * FROM phieunhap");
        $stmt->execute();
        $result = [];
        $queryResult = $stmt->get_result();
        while ($row = $queryResult->fetch_assoc()) {
            $result[] = $row;
        }
        return $result;
    }










    public function getLichSuNhapKho()
    {
        $query = "
            SELECT 
                pn.maphieunhap,
                pn.ngaynhap,
                pn.id_nguoinhap,
                ct.masp,
                sp.tensp,
                ct.soluongnhap,
                ct.gianhap,
                (ct.soluongnhap * ct.gianhap) AS thanhtien
            FROM phieunhap pn
            JOIN chitietphieunhap ct ON pn.maphieunhap = ct.maphieunhap
            JOIN sanpham sp ON ct.masp = sp.masp
            ORDER BY pn.ngaynhap DESC
        ";
        $result = $this->db->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function getLichSuXuatKho()
    {
        $query = "
            SELECT 
                dh.id AS maphieuxuat,
                dh.ngayxuat,
                dh.id_nhanvien AS id_nguoixuat,
                ct.masp,
                sp.tensp,
                ct.soluong AS soluongxuat,
                sp.giaxuat,
                (ct.soluong * sp.giaxuat) AS thanhtien
            FROM donhang dh
            JOIN donhangchitiet ct ON dh.id = ct.id_donhang
            JOIN sanpham sp ON ct.masp = sp.masp
            WHERE dh.trangthai = 'Đã xuất'
            ORDER BY dh.ngayxuat DESC
        ";

        $result = $this->db->query($query);

        if (!$result) {
            die("Lỗi truy vấn SQL: " . $this->db->error);
        }

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }







    public function getLichSuNhapKho1($startDate, $endDate)
    {
        $query = "
            SELECT 
                pn.maphieunhap,
                pn.ngaynhap,
                pn.id_nguoinhap,
                ct.masp,
                sp.tensp,
                ct.soluongnhap,
                ct.gianhap,
                (ct.soluongnhap * ct.gianhap) AS thanhtien
            FROM phieunhap pn
            JOIN chitietphieunhap ct ON pn.maphieunhap = ct.maphieunhap
            JOIN sanpham sp ON ct.masp = sp.masp
            WHERE pn.ngaynhap BETWEEN ? AND ?
            ORDER BY pn.ngaynhap DESC
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function getLichSuXuatKho1($startDate, $endDate)
    {
        $query = "
            SELECT 
                dh.id AS maphieuxuat,
                dh.ngayxuat,
                dh.id_nhanvien AS id_nguoixuat,
                ct.masp,
                sp.tensp,
                ct.soluong AS soluongxuat,
                sp.giaxuat,
                (ct.soluong * sp.giaxuat) AS thanhtien
            FROM donhang dh
            JOIN donhangchitiet ct ON dh.id = ct.id_donhang
            JOIN sanpham sp ON ct.masp = sp.masp
            WHERE dh.trangthai = 'Đã xuất'
            AND dh.ngayxuat BETWEEN ? AND ?
            ORDER BY dh.ngayxuat DESC
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }











    public function findByIdAndUsername($id, $username)
    {
        $stmt = $this->db->prepare("SELECT * FROM taikhoan WHERE id = ? AND taikhoan1 = ?");
        $stmt->bind_param("is", $id, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }

    public function updatePassword($id, $username, $hashedPassword)
    {
        $stmt = $this->db->prepare("UPDATE taikhoan SET matkhau = ? WHERE id = ? AND taikhoan1 = ?");
        $stmt->bind_param("sis", $hashedPassword, $id, $username);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }


































    public function getDashboardData()
    {
        $revenueQuery = "
            SELECT SUM(dhct.soluong * sp.giaxuat) AS revenue
            FROM donhangchitiet dhct
            JOIN sanpham sp ON dhct.masp = sp.masp
            JOIN donhang dh ON dhct.id_donhang = dh.id
            WHERE dh.trangthai = 'Đã xuất'
        ";

        $expenseQuery = "
            SELECT SUM(ctpn.soluongnhap * ctpn.gianhap) AS expense
            FROM chitietphieunhap ctpn
            JOIN phieunhap pn ON ctpn.maphieunhap = pn.maphieunhap
        ";

        $chartQuery = "
            SELECT DATE(dh.ngayxuat) AS date, 
                   SUM(dhct.soluong * sp.giaxuat) AS revenue, 
                   (SELECT SUM(ctpn.soluongnhap * ctpn.gianhap) 
                    FROM chitietphieunhap ctpn 
                    JOIN phieunhap pn ON ctpn.maphieunhap = pn.maphieunhap 
                    WHERE DATE(pn.ngaynhap) = DATE(dh.ngayxuat)) AS expense
            FROM donhang dh
            JOIN donhangchitiet dhct ON dh.id = dhct.id_donhang
            JOIN sanpham sp ON dhct.masp = sp.masp
            WHERE dh.trangthai = 'Đã xuất'
            GROUP BY DATE(dh.ngayxuat)
            ORDER BY DATE(dh.ngayxuat)
        ";

        $revenueResult = $this->db->query($revenueQuery)->fetch_assoc();
        $expenseResult = $this->db->query($expenseQuery)->fetch_assoc();
        $chartResult = $this->db->query($chartQuery);

        $chartData = ['labels' => [], 'revenue' => [], 'expense' => []];
        while ($row = $chartResult->fetch_assoc()) {
            $chartData['labels'][] = $row['date'];
            $chartData['revenue'][] = $row['revenue'];
            $chartData['expense'][] = $row['expense'] ?? 0;
        }

        return [
            'success' => true,
            'revenue' => $revenueResult['revenue'] ?? 0,
            'expense' => $expenseResult['expense'] ?? 0,
            'profit' => ($revenueResult['revenue'] ?? 0) - ($expenseResult['expense'] ?? 0),
            'chart' => $chartData
        ];
    }

    public function getDashboardComparison()
    {
        $query = "
            SELECT 
                DATE_FORMAT(dh.ngayxuat, '%Y-%m') AS period,
                SUM(dhct.soluong * sp.giaxuat) AS revenue,
                (SELECT SUM(ctpn.soluongnhap * ctpn.gianhap) 
                 FROM chitietphieunhap ctpn 
                 JOIN phieunhap pn ON ctpn.maphieunhap = pn.maphieunhap 
                 WHERE DATE_FORMAT(pn.ngaynhap, '%Y-%m') = DATE_FORMAT(dh.ngayxuat, '%Y-%m')) AS expense,
                (SUM(dhct.soluong * sp.giaxuat) - 
                 (SELECT SUM(ctpn.soluongnhap * ctpn.gianhap) 
                  FROM chitietphieunhap ctpn 
                  JOIN phieunhap pn ON ctpn.maphieunhap = pn.maphieunhap 
                  WHERE DATE_FORMAT(pn.ngaynhap, '%Y-%m') = DATE_FORMAT(dh.ngayxuat, '%Y-%m'))) AS profit
            FROM donhang dh
            JOIN donhangchitiet dhct ON dh.id = dhct.id_donhang
            JOIN sanpham sp ON dhct.masp = sp.masp
            WHERE dh.trangthai = 'Đã xuất'
            GROUP BY DATE_FORMAT(dh.ngayxuat, '%Y-%m')
            ORDER BY DATE_FORMAT(dh.ngayxuat, '%Y-%m') DESC
        ";

        $result = $this->db->query($query);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                'period' => $row['period'],
                'revenue' => $row['revenue'] ?? 0,
                'expense' => $row['expense'] ?? 0,
                'profit' => $row['profit'] ?? 0
            ];
        }

        return [
            'success' => true,
            'data' => $data
        ];
    }















































    public function themPhieuNhap($ngaynhap, $taikhoan1)
    {
        try {
            $ngaynhap = str_replace('T', ' ', $ngaynhap) . ':00';
            $taikhoan1 = trim($taikhoan1);

            // Lấy id của tài khoản theo tên tài khoản
            $stmtCheckUser = $this->db->prepare("SELECT id FROM taikhoan WHERE taikhoan1 = ?");
            $stmtCheckUser->bind_param("s", $taikhoan1); // 's' cho chuỗi
            $stmtCheckUser->execute();
            $stmtCheckUser->store_result();

            if ($stmtCheckUser->num_rows === 0) {
                throw new Exception("Tài khoản không tồn tại!");
            }

            $stmtCheckUser->bind_result($id_nguoinhap);
            $stmtCheckUser->fetch();

            $sql = "INSERT INTO phieunhap (ngaynhap, id_nguoinhap) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }

            $stmt->bind_param('si', $ngaynhap, $id_nguoinhap);
            if ($stmt->execute()) {
                $maphieunhap = $stmt->insert_id;
                return $maphieunhap;
            } else {
                throw new Exception("Không thể thêm phiếu nhập, lỗi SQL: " . $stmt->error);
            }
        } catch (Exception $e) {
            throw new Exception("Lỗi SQL khi thêm phiếu nhập: " . $e->getMessage());
        }
    }


    public function themChiTietPhieuNhap($maphieunhap, $masp, $soluongnhap, $gianhap, $nguonnhap)
    {
        try {
            // Kiểm tra mã sản phẩm có tồn tại trong bảng sanpham hay không
            $stmtCheckProduct = $this->db->prepare("SELECT masp FROM sanpham WHERE masp = ?");
            $stmtCheckProduct->bind_param("s", $masp);
            $stmtCheckProduct->execute();
            $stmtCheckProduct->store_result();
            if ($stmtCheckProduct->num_rows === 0) {
                throw new Exception("Mã sản phẩm không tồn tại trong bảng sanpham!");
            }

            $sql = "INSERT INTO chitietphieunhap (maphieunhap, masp, soluongnhap, gianhap, nguonnhap) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }

            $stmt->bind_param('ssdds', $maphieunhap, $masp, $soluongnhap, $gianhap, $nguonnhap);
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Không thể thêm chi tiết phiếu nhập: " . $stmt->error);
            }
        } catch (Exception $e) {
            throw new Exception("Lỗi SQL khi thêm chi tiết phiếu nhập: " . $e->getMessage());
        }
    }

    public function capNhatSoLuongTon($masp, $soluong)
    {
        try {
            // Kiểm tra mã sản phẩm có tồn tại trong bảng sanpham hay không
            $stmtCheckProduct = $this->db->prepare("SELECT masp FROM sanpham WHERE masp = ?");
            $stmtCheckProduct->bind_param("s", $masp);
            $stmtCheckProduct->execute();
            $stmtCheckProduct->store_result();
            if ($stmtCheckProduct->num_rows === 0) {
                throw new Exception("Mã sản phẩm không tồn tại trong bảng sanpham!");
            }

            $stmt = $this->db->prepare("UPDATE sanpham SET soluongton = soluongton + ? WHERE masp = ?");
            $stmt->bind_param("is", $soluong, $masp);
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Không thể cập nhật số lượng tồn: " . $stmt->error);
            }
        } catch (Exception $e) {
            throw new Exception("Lỗi SQL khi cập nhật số lượng tồn: " . $e->getMessage());
        }
    }

    public function layGiaNhapSanPham($masp)
    {
        try {
            $stmt = $this->db->prepare("SELECT gianhap FROM sanpham WHERE masp = ?");
            $stmt->bind_param("s", $masp);
            $stmt->execute();
            $stmt->bind_result($gianhap);
            if ($stmt->fetch()) {
                return $gianhap;
            } else {
                throw new Exception("Mã sản phẩm không tồn tại trong bảng sanpham!");
            }
        } catch (Exception $e) {
            throw new Exception("Lỗi SQL khi lấy giá nhập sản phẩm: " . $e->getMessage());
        }
    }




















    public function xoa_phieunhap($maphieunhap)
    {
        // Xóa chi tiết phiếu nhập trước (nếu có), rồi xóa phiếu nhập
        $this->db->begin_transaction();

        try {
            // Xóa chi tiết phiếu nhập
            $query1 = "DELETE FROM chitietphieunhap WHERE maphieunhap = ?";
            $stmt1 = $this->db->prepare($query1);
            $stmt1->bind_param("s", $maphieunhap);
            if (!$stmt1->execute()) {
                throw new Exception("Lỗi khi xóa chi tiết phiếu nhập!");
            }

            // Xóa phiếu nhập
            $query2 = "DELETE FROM phieunhap WHERE maphieunhap = ?";
            $stmt2 = $this->db->prepare($query2);
            $stmt2->bind_param("s", $maphieunhap);
            if (!$stmt2->execute()) {
                throw new Exception("Lỗi khi xóa phiếu nhập!");
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }
}
