<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background: #f3f4f6;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #6e8efb; /* Viền cho toàn bộ form */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px; /* Giới hạn chiều rộng */
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 15px;
            color: #6e8efb;
            font-weight: bold;
            font-size: 22px;
        }
        .btn-primary {
            background: #6e8efb;
            border: none;
        }
        .btn-primary:hover {
            background: #5a7be8;
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid #6e8efb;
            font-size: 14px;
            padding: 6px;
        }
        .form-label {
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Đăng ký tài khoản</h2>
    <form action="index.php?task=formdangki" method="post">


        <div class="mb-2">
            <label class="form-label">Tài khoản</label>
            <input type="text" name="taikhoan1" class="form-control" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Mật khẩu</label>
            <input type="password" name="matkhau" class="form-control" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Nhập lại mật khẩu</label>
            <input type="password" name="repassword" class="form-control" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Địa chỉ</label>
            <input type="text" name="diachi" class="form-control" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Giới tính</label>
            <select name="gioitinh" class="form-select" required>

                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
                <option value="Khác">Khác</option>
            </select>
        </div>
    <div class="mb-2">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
        <button type="submit" name="dangki" class="btn btn-primary w-100">Đăng ký</button>
    </form>
</div>
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const pass = document.querySelector('[name="matkhau"]').value;
    const repass = document.querySelector('[name="repassword"]').value;
    if (pass !== repass) {
        e.preventDefault();
        alert("Mật khẩu không khớp!");
    }
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
