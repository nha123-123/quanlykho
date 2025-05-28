<!-- Form sửa sản phẩm -->
<div id="edit-product-form-<?= $row['masp'] ?>" class="mt-4 hidden edit-product-form">
    <h3 class="text-center mb-4">Sửa Sản Phẩm</h3>
    <form action="index.php?task=suasanpham1" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="masp" value="<?= $row['masp'] ?>">
        <div class="row g-3">
            <div class="col-md-12">
                <label for="tensp-<?= $row['masp'] ?>" class="form-label">Tên Sản Phẩm</label>
                <input type="text" class="form-control" id="tensp-<?= $row['masp'] ?>" name="tensp" value="<?= $row['tensp'] ?>" required>
            </div>
            <div class="col-md-6">
                <label for="donvitinh-<?= $row['masp'] ?>" class="form-label">Đơn Vị Tính</label>
                <input type="text" class="form-control" id="donvitinh-<?= $row['masp'] ?>" name="donvitinh" value="<?= $row['donvitinh'] ?>">
            </div>
            <div class="col-md-6">
                <label for="soluongton-<?= $row['masp'] ?>" class="form-label">Số Lượng Tồn</label>
                <input type="number" class="form-control" id="soluongton-<?= $row['masp'] ?>" name="soluongton" value="<?= $row['soluongton'] ?>">
            </div>
            <div class="col-md-6">
                <label for="gianhap-<?= $row['masp'] ?>" class="form-label">Giá Nhập</label>
                <input type="number" step="0.01" class="form-control" id="gianhap-<?= $row['masp'] ?>" name="gianhap" value="<?= $row['gianhap'] ?>">
            </div>
            <div class="col-md-6">
                <label for="giaxuat-<?= $row['masp'] ?>" class="form-label">Giá Xuất</label>
                <input type="number" step="0.01" class="form-control" id="giaxuat-<?= $row['masp'] ?>" name="giaxuat" value="<?= $row['giaxuat'] ?>">
            </div>
            <div class="col-md-12">
                <label for="mota-<?= $row['masp'] ?>" class="form-label">Mô Tả</label>
                <textarea class="form-control" id="mota-<?= $row['masp'] ?>" name="mota" rows="2"><?= $row['mota'] ?></textarea>
            </div>
            <div class="col-md-12">
                <label for="hinhanh-<?= $row['masp'] ?>" class="form-label">Hình Ảnh</label>
                <input type="file" class="form-control" id="hinhanh-<?= $row['masp'] ?>" name="hinhanh" accept="image/*" onchange="previewEditImage(event, 'preview-<?= $row['masp'] ?>')">
                <img id="preview-<?= $row['masp'] ?>" src="<?= $row['hinhanh'] ?>" alt="Hình ảnh xem trước" class="preview-image">
            </div>
            <div class="col-md-6">
                <label for="ngaytao-<?= $row['masp'] ?>" class="form-label">Ngày Tạo</label>
                <input type="datetime-local" class="form-control" id="ngaytao-<?= $row['masp'] ?>" name="ngaytao" value="<?= date('Y-m-d\TH:i', strtotime($row['ngaytao'])) ?>">
            </div>
            <div class="col-md-6">
                <label for="ngaycapnhat-<?= $row['masp'] ?>" class="form-label">Ngày Cập Nhật</label>
                <input type="datetime-local" class="form-control" id="ngaycapnhat-<?= $row['masp'] ?>" name="ngaycapnhat" value="<?= date('Y-m-d\TH:i', strtotime($row['ngaycapnhat'])) ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-success w-100 mt-3" name="suasanpham">Lưu Thay Đổi</button>
    </form>
    <button class="btn btn-secondary mt-3 w-100" onclick="toggleEditProductForm('<?= $row['masp'] ?>')">Đóng</button>
</div>

<style>
    .edit-product-form {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1050;
        background: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        border: 1px solid #ddd;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        width: 400px;
        max-width: 90%;
    }

    .edit-product-form h3 {
        font-size: 1.5rem;
        color: #333;
    }

    .edit-product-form .form-label {
        font-weight: bold;
        color: #555;
    }

    .edit-product-form .form-control {
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .edit-product-form .btn {
        border-radius: 5px;
    }

    .edit-product-form .preview-image {
        display: block;
        margin-top: 10px;
        max-width: 100%;
        height: auto;
        border: 1px solid #ccc;
        padding: 5px;
    }
</style>