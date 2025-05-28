<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Tài Khoản</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-weight: bold;
            color: #343a40;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="form-container">
            <h2 class="text-center mb-4 form-title">Sửa Tài Khoản</h2>
            <form action="index.php?task=suataikhoan1" method="POST">
                <div class="mb-3">
                    <label for="id" class="form-label">ID Chính</label>
                    <input type="text" class="form-control" id="id" name="id" value="<?= $user['id'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="taikhoan1" class="form-label">Tài Khoản</label>
                    <input type="text" class="form-control" id="taikhoan1" name="taikhoan1" value="<?= $user['taikhoan1'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="matkhau" class="form-label">Mật Khẩu</label>
                    <input type="password" class="form-control" id="matkhau" name="matkhau" value="<?= $user['matkhau'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="diachi" class="form-label">Địa Chỉ</label>
                    <input type="text" class="form-control" id="diachi" name="diachi" value="<?= $user['diachi'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="gioitinh" class="form-label">Giới Tính</label>
                    <select class="form-select" id="gioitinh" name="gioitinh" required>
                        <option value="Nam" <?= $user['gioitinh'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
                        <option value="Nữ" <?= $user['gioitinh'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                        <option value="Khác" <?= $user['gioitinh'] == 'Khác' ? 'selected' : '' ?>>Khác</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="cap" class="form-label">Cấp</label>
                    <input type="number" class="form-control" id="cap" name="cap" value="<?= $user['cap'] ?>" required>
                </div>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" id="showPassword" onclick="togglePassword()">
                    <label class="form-check-label" for="showPassword">
                        Hiện mật khẩu
                    </label>
                </div>

                <script>
                    function togglePassword() {
                        const passwordInput = document.getElementById('matkhau');
                        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
                    }
                </script>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary" name="suataikhoan" href="index.php?task=formquanli#nhanvien">Lưu Thay Đổi</button>

                    <a href="index.php?task=formquanli#nhanvien" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>