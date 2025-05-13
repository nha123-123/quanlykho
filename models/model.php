
<?php
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


    public function dangnhap($taikhoan1, $matkhau)
    {
        $query = "SELECT * FROM taikhoan WHERE taikhoan1 = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "s", $taikhoan1);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Kiểm tra mật khẩu với password_verify()
            if (password_verify($matkhau, $row['matkhau'])) {
                return $row; // Đăng nhập thành công
            }
        }
        return false; // Sai tài khoản hoặc mật khẩu
    }



    public function tatcanguoidung()
    {

        $query = "SELECT * FROM taikhoan";
        $result = mysqli_query($this->db, $query);
        return $result;
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



public function xoachitietphieunhap_theo_masp($masp) {
    $query = "DELETE FROM chitietphieunhap WHERE masp = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param("s", $masp);
    return $stmt->execute();
}

public function xoasanpham($masp) {
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























    public function getInterestRates() {
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
    


    public function getDonHangData()
    {
        $currentMonth = date('m');
        $currentYear = date('Y');
        $query = "SELECT id, ngaylap, trangthai FROM donhang WHERE MONTH(ngaylap) = $currentMonth AND YEAR(ngaylap) = $currentYear";
        
        $result = $this->db->query($query);
    
        if (!$result) {
            throw new Exception("Lỗi khi lấy dữ liệu đơn hàng: " . $this->db->error);
        }
    
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    
        if (empty($data)) {
            throw new Exception("Không có đơn hàng nào trong tháng này.");
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





























    public function xuatExcelPhiNhap()
    {
        // Kết nối với database và lấy dữ liệu
        $result = $this->tatca_phieunhap(); // Lấy dữ liệu từ hàm model (có thể bạn phải viết thêm phương thức này)
        $danhsach4 = [];

        // Lấy dữ liệu từ kết quả trả về
        while ($row = mysqli_fetch_assoc($result)) {
            $danhsach4[] = $row;
        }

        // Bao gồm file PHPExcel
        require_once 'libs/PHPExcel/PHPExcel.php';


        // Tạo đối tượng PHPExcel mới
        $objPHPExcel = new PHPExcel();

        // Cài đặt các thuộc tính cho file Excel
        $objPHPExcel->getProperties()->setCreator("Your Name")
            ->setLastModifiedBy("Your Name")
            ->setTitle("Danh sách Phiếu Nhập")
            ->setSubject("Phiếu Nhập")
            ->setDescription("Danh sách phiếu nhập được xuất từ hệ thống.")
            ->setKeywords("excel php phieu nhap")
            ->setCategory("Export");

        // Thêm dữ liệu vào Excel
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Mã Phiếu Nhập')
            ->setCellValue('B1', 'Ngày Nhập')
            ->setCellValue('C1', 'Số Lượng')
            ->setCellValue('D1', 'Tên Nhà Cung Cấp');

        // Duyệt qua danh sách phiếu nhập và thêm vào Excel
        $row_num = 2;
        foreach ($danhsach4 as $row) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $row_num, $row['maphieunhap'])
                ->setCellValue('B' . $row_num, $row['ngaynhap'])
                ->setCellValue('C' . $row_num, $row['soluong'])
                ->setCellValue('D' . $row_num, $row['nhacungcap']);
            $row_num++;
        }

        // Đặt tên cho sheet Excel
        $objPHPExcel->getActiveSheet()->setTitle('Danh sách Phiếu Nhập');

        // Đảm bảo rằng sheet đầu tiên được hiển thị khi mở file Excel
        $objPHPExcel->setActiveSheetIndex(0);

        // Xuất file Excel dưới dạng file .xlsx
        // Đặt các header cho Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="danh_sach_phieu_nhap.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0


        // Tạo file Excel và xuất ra browser
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2021');
        $objWriter->save('php://output');
        exit;
    }












    // Cập nhật số lượng sản phẩm khi nhập kho








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











    public function findByIdAndUsername($id, $username) {
        $stmt = $this->db->prepare("SELECT * FROM taikhoan WHERE id = ? AND taikhoan1 = ?");
        $stmt->bind_param("is", $id, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }
    
    public function updatePassword($id, $username, $hashedPassword) {
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
