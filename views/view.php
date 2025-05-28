<?php

class View
{
    public $tatcadanhmuchoatoancuc;

    public function getHomePage($tatcadanhmuc, $tatcahoa)
    {
        include_once "Templates/Home.php";
    }

    public function dangky($tatcadanhmuc)
    {
        include_once "Templates/formdangki.php";
    }

    public function dangnhap($tatcadanhmuc)
    {
        include_once "Templates/formdangnhap.php";
    }
 
    public function formquanli($tatcadanhmuc)
    {
        include_once "Templates/formquanli.php";
    }
    public function hienthitatcanguoidung($danhsach) {
        // Lưu danh sách vào biến session hoặc property
        $_SESSION['danhsach'] = $danhsach;
    }
    


    public function formsuataikhoan($user) {
        include 'templates/formsuataikhoan.php';
    }
    

    public function formthemsanpham() {
        include 'templates/formthemsanpham.php';
    }
    public function hienThiFormThemPhieuNhap() {
        include 'templates/formquanli.php';
    }


    // public function hienthi_nhapkho()
    // {
    //     include_once 'templates/formquali.php';
    // }
    

    
    
    public function formthemtaikhoan() {
        include 'templates/formthemtaikhoan.php';
    }
    public function getAllSanPham() {
        include 'templates/getAllSanPham.php';
    }
    
    public function chitiet_phieunhap() {
        include 'templates/chitiet_phieunhap.php';
    }
    // public function formthemtaikhoan() {
    //     include 'templates/formthemtaikhoan.php';
    // }
    
    public function formsuasanpham() {
            include 'templates/formsuasanpham.php';
        }

    public function hienthitatcasanpham($danhsach1) {
        // Lưu danh sách vào biến session hoặc property
        $_SESSION['danhsach1'] = $danhsach1;
    }
    


    
    public function pageQuanLyNguoiDung($result, $tatcadanhmuc)
    {
        include_once "Templates/PageQuanLyNguoiDung.php";
    }

    public function editUser($result, $tatcadanhmuc)
    {
        include_once "Templates/FormEditUser.php";
    }

    public function formAddUser($tatcadanhmuc)
    {
        include_once "Templates/FormAddUser.php";
    }

    public function pageQuanLyDM($result, $tatcadanhmuc)
    {
        include_once "Templates/PageQuanLyDM.php";
    }

    public function editDM($result, $tatcadanhmuc)
    {
        include_once "Templates/FormEditDM.php";
    }

    public function formAddDM($tatcadanhmuc)
    {
        include_once "Templates/FormAddDM.php";
    }

    public function pageQuanLySP($result, $tatcadanhmuc)
    {
        include_once "Templates/PageQuanLySP.php";
    }

    public function editFormEditSP($result, $tatcadanhmuc, $tatcadanhmuc1)
    {
        include_once "Templates/FormEditSP.php";
    }

    public function formAddSP($tatcadanhmuc, $result)
    {
        include_once "Templates/FormAddSP.php";
    }

    public function pageThongTinSP($tatcadanhmuc, $result)
    {
        include_once "Templates/ThongTinSP.php";
    }

    public function xemGioHang($tatcadanhmuc, $data)
    {
        include_once "Templates/GioHang.php";
    }

    public function getPagePayment($tatcadanhmuc)
    {
        include_once "Templates/ThanhToan.php";
    }

    public function getPageQLDH($tatcadanhmuc, $tatcadonhang)
    {
        include_once "Templates/PageQLDH.php";
    }

    public function getPageSPTheoDanhMuc($tatcadanhmuc, $sptheodanhmuc)
    {
        include_once "Templates/SPTheoDanhMuc.php";
    }

    public function getPageDonHangNguoiDung($tatcadanhmuc, $donhangnguoidung)
    {
        include_once "Templates/DonHangNguoiDung.php";
    }

    // ✅ Thêm hàm showResult để xử lý alert hoặc thông báo
    public function showResult($result)
    {
        if (is_bool($result)) {
            if ($result) {
                echo "<script>alert('Thành công!');</script>";
            } else {
                echo "<script>alert('Thất bại!');</script>";
            }
        } else {
            echo "<script>alert('$result');</script>";
        }
    }
}
