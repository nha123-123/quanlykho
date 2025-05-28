<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Tài Khoản</title>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes buttonHover {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            animation: fadeIn 1s ease-in-out;
        }

        .form-container {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            animation: fadeIn 1.5s ease-in-out;
            box-sizing: border-box;
        }

        .form-container h2 {
            margin-bottom: 20px;
            font-size: 26px;
            color: #333;
            text-align: center;
            animation: fadeIn 2s ease-in-out;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        .form-group input:focus {
            border-color: #74ebd5;
            outline: none;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
        }

        .form-actions button {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-update {
            background-color: #007bff;
            color: #fff;
            box-shadow: 0 4px 6px rgba(0, 123, 255, 0.4);
        }

        .btn-update:hover {
            background-color: #0056b3;
            box-shadow: 0 6px 8px rgba(0, 86, 179, 0.6);
            animation: buttonHover 0.5s ease-in-out;
        }

        .btn-close {
            background-color: #6c757d;
            color: #fff;
            box-shadow: 0 4px 6px rgba(108, 117, 125, 0.4);
        }

        .btn-close:hover {
            background-color: #5a6268;
            box-shadow: 0 6px 8px rgba(90, 98, 104, 0.6);
            animation: buttonHover 0.5s ease-in-out;
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
                max-width: 90%;
            }

            .form-container h2 {
                font-size: 22px;
            }

            .form-group input {
                padding: 10px;
                font-size: 13px;
            }

            .form-actions button {
                padding: 10px 20px;
                font-size: 13px;
            }
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 15px;
            }

            .form-container h2 {
                font-size: 20px;
            }

            .form-actions {
                flex-direction: column;
                gap: 10px;
            }

            .form-actions button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
<div class="form-container">
    <h2>Update Tài Khoản</h2>
    <!-- Đường dẫn tuyệt đối để tránh lỗi "Not Found" -->
    <form action="index.php?task=handleForm" method="post">

        <div class="form-group">
            <label for="taikhoan1">Tên Tài Khoản</label>
            <input type="text" id="taikhoan1" name="taikhoan1" required>
        </div>
        <div class="form-group">
            <label for="id">Mã Tài Khoản </label>
            <input type="text" id="id" name="id" required>
        </div>
        <div class="form-group">
            <label for="email">Email Gửi về </label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-update" name="capnhat"href="index.php?task=formdangnhap">Cập Nhật</button>
            <button type="button" class="btn-close" onclick="window.location.href='http://localhost/quanlykho/index.php?task=formdangnhap#!'">Đóng</button>
        </div>
    </form>
</div>

</body>

</html>
</div>