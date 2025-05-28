<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Tài Khoản</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            font-family: 'Arial', sans-serif;
        }
        .form-container {
            max-width: 400px;
            /* margin: 50px auto; */
            padding: 20px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.3);
        }
        .form-container h2 {
            margin-bottom: 20px;
            font-size: 26px;
            font-weight: bold;
            color: #333;
            text-align: center;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .form-control:focus {
            border-color: #74ebd5;
            box-shadow: 0 0 8px rgba(116, 235, 213, 0.5);
        }
        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            border: none;
            border-radius: 8px;
            transition: background 0.3s, transform 0.3s;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #acb6e5, #74ebd5);
            transform: scale(1.05);
        }
        .btn-primary:active {
            transform: scale(0.95);
        }
        @media (max-width: 768px) {
            .form-container {
                margin: 20px auto;
                padding: 15px;
            }
            .form-container h2 {
                font-size: 22px;
            }
            .btn-primary {
                font-size: 14px;
            }
        }
        @media (max-width: 576px) {
            .form-container {
                margin: 10px auto;
                padding: 10px;
            }
            .form-container h2 {
                font-size: 18px;
            }
            .btn-primary {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center">Thêm Tài Khoản</h2>
            <form action="index.php?task=formthemtaikhoan" method="POST">

                <div class="mb-3">
                    <label for="taikhoan1" class="form-label">Tài Khoản</label>
                    <input type="text" class="form-control" id="taikhoan1" name="taikhoan1" required>
                </div>
                <div class="mb-3">
                    <label for="matkhau" class="form-label">Mật Khẩu</label>
                    <input type="password" class="form-control" id="matkhau" name="matkhau" required>
                </div>
                <div class="mb-3">
                    <label for="diachi" class="form-label">Địa Chỉ</label>
                    <input type="text" class="form-control" id="diachi" name="diachi" required>
                </div>
                <div class="mb-3">
                    <label for="gioitinh" class="form-label">Giới Tính</label>
                    <select class="form-select" id="gioitinh" name="gioitinh" required>
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                        <option value="Khác">Khác</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="cap" class="form-label">Cấp</label>
                    <select class="form-select" id="cap" name="cap" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <button type="submit" class="btn btn-primary" name="themtaikhoan"href="index.php?task=formquanli#nhanvien">Thêm Tài Khoản</button>
               
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>