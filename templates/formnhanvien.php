<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="title">Nhân Viên Kho</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

@media (min-width: 768px) {
    .col-md-6 {
        width: 43%;
    }
}
        

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            border: none;
            border-radius: 8px;
            transition: background 0.3s, transform 0.3s;
        }
    </style>

</head>

<body>

    <!-- Display logged-in user's info and logout button -->
    <div class="top-right-menu d-flex justify-content-end align-items-center p-3">
        <?php if (isset($_SESSION['taikhoan1'])): ?>
            <div class="user-dropdown">
                <div class="user-icon" id="userMenuToggle">
                    👤
                </div>
                <div id="userDropdownMenu" class="dropdown-menu-custom">
                    <div class="dropdown-header-custom">
                        Chào , <strong><?php echo $_SESSION['taikhoan1']; ?></strong>
                    </div>
                    <a href="#" class="dropdown-item-custom" onclick="showChangePasswordForm(event)">Đổi mật khẩu</a>
                    <style>
                        /* Modal overlay */
                        #changePasswordModal {
                            position: fixed;
                            top: 0;
                            left: 0;
                            width: 100vw;
                            height: 100vh;
                            background: rgba(0, 0, 0, 0.45);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            z-index: 99999;
                            animation: fadeInModal 0.25s;
                        }

                        @keyframes fadeInModal {
                            from {
                                opacity: 0;
                            }

                            to {
                                opacity: 1;
                            }
                        }

                        /* Modal content */
                        #changePasswordModal .modal-content-custom {
                            background: #fff;
                            border-radius: 14px;
                            padding: 32px 28px 24px 28px;
                            min-width: 340px;
                            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
                            position: relative;
                            max-width: 95vw;
                            animation: slideDownModal 0.3s;
                        }

                        @keyframes slideDownModal {
                            from {
                                transform: translateY(-30px);
                                opacity: 0;
                            }

                            to {
                                transform: translateY(0);
                                opacity: 1;
                            }
                        }

                        #changePasswordModal h4 {
                            font-weight: 700;
                            color: #2563eb;
                            margin-bottom: 22px;
                            letter-spacing: 0.5px;
                        }

                        #changePasswordModal label.form-label {
                            font-weight: 500;
                            color: #333;
                        }

                        #changePasswordModal input.form-control {
                            border-radius: 8px;
                            border: 1px solid #d1d5db;
                            font-size: 15px;
                            padding: 10px 12px;
                            transition: border-color 0.2s;
                        }

                        #changePasswordModal input.form-control:focus {
                            border-color: #2563eb;
                            box-shadow: 0 0 0 2px #2563eb22;
                        }

                        #changePasswordMsg {
                            min-height: 22px;
                            font-size: 15px;
                            transition: color 0.2s;
                        }

                        #changePasswordModal .btn-primary {
                            background: linear-gradient(90deg, #2563eb 60%, #1e40af 100%);
                            border: none;
                            border-radius: 7px;
                            font-weight: 600;
                            padding: 8px 22px;
                            transition: background 0.2s, box-shadow 0.2s;
                            box-shadow: 0 2px 8px #2563eb22;
                        }

                        #changePasswordModal .btn-primary:hover {
                            background: linear-gradient(90deg, #1e40af 60%, #2563eb 100%);
                        }

                        #changePasswordModal .btn-secondary {
                            border-radius: 7px;
                            font-weight: 500;
                            padding: 8px 22px;
                            background: #f3f4f6;
                            color: #333;
                            border: 1px solid #d1d5db;
                            transition: background 0.2s, color 0.2s;
                        }

                        #changePasswordModal .btn-secondary:hover {
                            background: #e5e7eb;
                            color: #111;
                        }

                        @media (max-width: 480px) {
                            #changePasswordModal .modal-content-custom {
                                padding: 18px 8px 14px 8px;
                                min-width: 0;
                            }
                        }
                    </style>
                    <script>
                        function showChangePasswordForm(e) {
                            e.preventDefault();
                            // Tạo modal đổi mật khẩu
                            if (document.getElementById('changePasswordModal')) return;
                            const modal = document.createElement('div');
                            modal.id = 'changePasswordModal';
                            modal.innerHTML = `
                        <div class="modal-content-custom">
                            <h4 class="mb-3 text-center">Đổi mật khẩu</h4>
                            <form id="changePasswordForm" autocomplete="off">
                                <div class="mb-3">
                                    <label class="form-label">Mật khẩu cũ</label>
                                    <input type="password" class="form-control" name="old_password" required autocomplete="current-password">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mật khẩu mới</label>
                                    <input type="password" class="form-control" name="new_password" required autocomplete="new-password">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nhập lại mật khẩu mới</label>
                                    <input type="password" class="form-control" name="confirm_password" required autocomplete="new-password">
                                </div>
                                <div id="changePasswordMsg" class="mb-2 text-danger"></div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                                    <button type="button" class="btn btn-secondary" onclick="closeChangePasswordModal()">Hủy</button>
                                </div>
                            </form>
                        </div>
                    `;
                            document.body.appendChild(modal);

                            document.getElementById('changePasswordForm').onsubmit = function(ev) {
                                ev.preventDefault();
                                const oldPass = this.old_password.value.trim();
                                const newPass = this.new_password.value.trim();
                                const confirmPass = this.confirm_password.value.trim();
                                const msg = document.getElementById('changePasswordMsg');
                                msg.textContent = '';
                                msg.classList.remove('text-success');
                                msg.classList.add('text-danger');
                                if (!oldPass || !newPass || !confirmPass) {
                                    msg.textContent = 'Vui lòng nhập đầy đủ thông tin.';
                                    return;
                                }
                                if (newPass.length < 6) {
                                    msg.textContent = 'Mật khẩu mới phải từ 6 ký tự trở lên.';
                                    return;
                                }
                                if (newPass !== confirmPass) {
                                    msg.textContent = 'Mật khẩu mới và nhập lại không khớp.';
                                    return;
                                }
                                // Gửi AJAX đổi mật khẩu
                                fetch('index.php?task=doiMatKhau', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({
                                            old_password: oldPass,
                                            new_password: newPass
                                        })
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            msg.classList.remove('text-danger');
                                            msg.classList.add('text-success');
                                            msg.textContent = 'Đổi mật khẩu thành công!';
                                            setTimeout(closeChangePasswordModal, 1200);
                                        } else {
                                            msg.classList.remove('text-success');
                                            msg.classList.add('text-danger');
                                            msg.textContent = data.message || 'Đổi mật khẩu thất bại.';
                                        }
                                    })
                                    .catch(() => {
                                        msg.classList.remove('text-success');
                                        msg.classList.add('text-danger');
                                        msg.textContent = 'Có lỗi xảy ra, vui lòng thử lại.';
                                    });
                            };
                            // Đóng modal khi click ngoài vùng modal-content
                            modal.addEventListener('mousedown', function(ev) {
                                if (ev.target === modal) closeChangePasswordModal();
                            });
                            // Đóng bằng phím ESC
                            document.addEventListener('keydown', escCloseModal);
                        }

                        function closeChangePasswordModal() {
                            const modal = document.getElementById('changePasswordModal');
                            if (modal) modal.remove();
                            document.removeEventListener('keydown', escCloseModal);
                        }

                        function escCloseModal(e) {
                            if (e.key === 'Escape') closeChangePasswordModal();
                        }
                    </script>



                    <a href="index.php?task=dangxuat" class="dropdown-item-custom text-danger">Đăng xuất</a>
                </div>
            </div>
        <?php else: ?>
            <li class="nav-item list-unstyled">
                <a href="index.php?task=formdangnhap" class="nav-link text-white btn btn-primary">Đăng nhập</a>
            </li>
        <?php endif; ?>
    </div>

    <div class="row">
        <!-- Sidebar -->
        <!-- <nav class="sidebar col-md-3 col-lg-2 d-md-block text-white">
                <h4 data-i18n="sidebarTitle">🧑 Nhân viên kho</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#dashboard" onclick="changeContent('Dashboard')" data-i18n="dashboard">📊 Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#sanpham" onclick="showTableSP('Danh sách sản phẩm')" data-i18n="productList">
                            📦 <span data-i18n="productList">Danh sách sản phẩm</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#nhapkho" onclick="showTable('Nhập kho')">➕ Nhập kho</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#xuatkho" onclick="showXuatKhoForm()">📤 Xuất kho</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#baocao" onclick="showTableTK('Báo cáo & Thống kê')">📊 Báo cáo & Thống kê</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#lichsu" onclick="showTableLS('Lịch sử giao dịch')">📜 Lịch sử nhập/xuất kho</a>
                    </li>
                    <li class="nav-item">
                        <a id="menu-cauhinh" class="nav-link text-white" href="#cauhinh" onclick="showCauHinh()">⚙️ Cấu hình hệ thống</a>
                    </li>

                </ul>
            </nav> -->
        <nav class="sidebar col-md-3 col-lg-2 d-md-block bg-dark text-white">
  <div class="sidebar-header text-center p-3">
    <h4 data-i18n="🧑 Nhân viên kho">🧑 Nhân viên kho</h4>
  </div>
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center" href="#dashboard" onclick="changeContent(i18next.t('dashboard'))">
        <span class="menu-icon">📊</span> <span data-i18n="dashboard">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center" href="#sanpham" onclick="showTableSP(i18next.t('productList'))">
        <span class="menu-icon">📦</span> <span data-i18n="productList">Danh sách sản phẩm</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center" href="#nhapkho" onclick="showTable(i18next.t('importWarehouse'))">
        <span class="menu-icon">➕</span> <span data-i18n="importWarehouse">Nhập kho</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center" href="#xuatkho" onclick="showXuatKhoForm()">
        <span class="menu-icon">📤</span> <span data-i18n="exportWarehouse">Xuất kho</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center" href="#baocao" onclick="showTableTK(i18next.t('report'))">
        <span class="menu-icon">📊</span> <span data-i18n="report">Báo cáo & Thống kê</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center" href="#lichsu" onclick="showTableLS(i18next.t('history'))">
        <span class="menu-icon">📜</span> <span data-i18n="history">Lịch sử nhập/xuất kho</span>
      </a>
    </li>
    <li class="nav-item">
      <a id="menu-cauhinh" class="nav-link text-white d-flex align-items-center" href="#cauhinh" onclick="showCauHinh()">
        <span class="menu-icon">⚙️</span> <span data-i18n="config">Cấu hình hệ thống</span>
      </a>
    </li>
  </ul>
</nav>

<!-- Navbar cho mobile -->
<nav class="navbar navbar-dark bg-dark d-md-none">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-brand text-center flex-grow-1">
      <h4 data-i18n="🧑 Nhân viên kho" class="mb-0">🧑 Nhân viên kho</h4>
    </div>
  </div>
</nav>

<!-- 
<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="mobileMenuLabel">🧑 Nhân viên kho</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="#dashboard" onclick="changeContent(i18next.t('dashboard')); closeOffcanvas()">
          <span class="menu-icon">📊</span> <span data-i18n="dashboard">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="#sanpham" onclick="showTableSP(i18next.t('productList')); closeOffcanvas()">
          <span class="menu-icon">📦</span> <span data-i18n="productList">Danh sách sản phẩm</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="#nhapkho" onclick="showTable(i18next.t('importWarehouse')); closeOffcanvas()">
          <span class="menu-icon">➕</span> <span data-i18n="importWarehouse">Nhập kho</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="#xuatkho" onclick="showXuatKhoForm(); closeOffcanvas()">
          <span class="menu-icon">📤</span> <span data-i18n="exportWarehouse">Xuất kho</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="#baocao" onclick="showTableTK(i18next.t('report')); closeOffcanvas()">
          <span class="menu-icon">📊</span> <span data-i18n="report">Báo cáo & Thống kê</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="#lichsu" onclick="showTableLS(i18next.t('history')); closeOffcanvas()">
          <span class="menu-icon">📜</span> <span data-i18n="history">Lịch sử nhập/xuất kho</span>
        </a>
      </li>
      <li class="nav-item">
        <a id="menu-cauhinh" class="nav-link text-white d-flex align-items-center" href="#cauhinh" onclick="showCauHinh(); closeOffcanvas()">
          <span class="menu-icon">⚙️</span> <span data-i18n="config">Cấu hình hệ thống</span>
        </a>
      </li>
    </ul>
  </div>
</div> -->
<!-- Offcanvas menu cho mobile -->
<div class="offcanvas offcanvas-start text-white" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="mobileMenuLabel">🧑 Nhân viên kho</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="#dashboard" data-bs-dismiss="offcanvas" onclick="changeContent(i18next.t('dashboard')); setActiveMenu(this)">
          <span class="menu-icon">📊</span> <span data-i18n="dashboard">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="#sanpham" data-bs-dismiss="offcanvas" onclick="showTableSP(i18next.t('productList')); setActiveMenu(this)">
          <span class="menu-icon">📦</span> <span data-i18n="productList">Danh sách sản phẩm</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="#nhapkho" data-bs-dismiss="offcanvas" onclick="showTable(i18next.t('importWarehouse')); setActiveMenu(this)">
          <span class="menu-icon">➕</span> <span data-i18n="importWarehouse">Nhập kho</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="#xuatkho" data-bs-dismiss="offcanvas" onclick="showXuatKhoForm(); setActiveMenu(this)">
          <span class="menu-icon">📤</span> <span data-i18n="exportWarehouse">Xuất kho</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="#baocao" data-bs-dismiss="offcanvas" onclick="showTableTK(i18next.t('report')); setActiveMenu(this)">
          <span class="menu-icon">📊</span> <span data-i18n="report">Báo cáo & Thống kê</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="#lichsu" data-bs-dismiss="offcanvas" onclick="showTableLS(i18next.t('history')); setActiveMenu(this)">
          <span class="menu-icon">📜</span> <span data-i18n="history">Lịch sử nhập/xuất kho</span>
        </a>
      </li>
      <li class="nav-item">
        <a id="menu-cauhinh" class="nav-link text-white d-flex align-items-center" href="#cauhinh" data-bs-dismiss="offcanvas" onclick="showCauHinh(); setActiveMenu(this)">
          <span class="menu-icon">⚙️</span> <span data-i18n="config">Cấu hình hệ thống</span>
        </a>
      </li>
    </ul>
  </div>
</div>
        <main class="col-md-9 col-lg-10 content">
            <h2>Dashboard</h2>
            <p>Chào mừng đến với hệ thống quản lý kho.</p>
        </main>
    </div>
    </div>


    <style>
        /* Sidebar cho desktop */
        .sidebar {
            height: 727px;
            background: #343a40;
            padding: 20px;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 19px;
            margin-bottom: 19px;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background: #495057;
        }
.sidebar {
  background: linear-gradient(135deg, #2c3e50, #3498db); /* Gradient hiện đại */
  height: 100vh;
  padding: 1.5rem;
  position: fixed;
  top: 0;
  left: 0;
  width: 250px;
  overflow-y: auto;
  transition: all 0.3s ease;
  box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
}

.sidebar-header h4 {
  font-size: 1.2rem;
  font-weight: 600;
  color: #ffffff;
  margin-bottom: 1.5rem;
  text-align: center;
}

.nav-link {
  padding: 10px 15px;
  font-size: 1rem;
  color: #ffffff;
  border-radius: 8px;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  text-decoration: none;
}

.nav-link:hover,
.nav-link:focus {
  background-color: rgba(255, 255, 255, 0.2);
  color: #ffffff;
  transform: translateX(5px);
}

.menu-icon {
  margin-right: 10px;
  font-size: 1.1rem;
}

/* Navbar và Offcanvas cho mobile */
.navbar {
  padding: 0.5rem 1rem;
}

.offcanvas {
  background: linear-gradient(135deg, #2c3e50, #3498db);
  max-width: 250px;
}

.offcanvas-header h5 {
  font-size: 1.2rem;
  font-weight: 600;
  color: #ffffff;
}

.offcanvas .nav-link {
  padding: 12px 15px;
  font-size: 1rem;
}

/* Content container */
.content-container {
  margin-left: 0;
  padding: 20px;
  transition: margin-left 0.3s ease;
}

@media (min-width: 768px) {
  .content-container {
    margin-left: 250px; /* Phù hợp với chiều rộng sidebar */
  }
}

/* Responsive */
@media (max-width: 767px) {
  .sidebar {
    display: none; /* Ẩn sidebar trên mobile */
  }

  .navbar-brand {
    font-size: 1.1rem;
  }

  .offcanvas .nav-link {
    font-size: 0.95rem;
    padding: 10px 12px;
  }

  .offcanvas .menu-icon {
    font-size: 1rem;
  }
}

/* Hiệu ứng khi hover */
.nav-link.active {
  background-color: rgba(255, 255, 255, 0.3);
  font-weight: 500;
}

        .top-right-menu {
            position: absolute;
            top: 0;
            right: 0;
            z-index: 999;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 0 0 0 58px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .top-right-menu a.nav-link {
            text-decoration: none;
        }

        .top-right-menu span {
            font-size: 14px;
        }

        /* Dropdown CSS */
        .user-dropdown {
            position: relative;
        }

        .user-icon {
            font-size: 25px;
            background-color: #e9ecef;
            padding: 2px;
            border-radius: 52%;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
            width: 51px;
            height: 40px;
        }

        .user-icon:hover {
            background-color: #dee2e6;
        }

        .dropdown-menu-custom {
            display: none;
            position: absolute;
            top: 110%;
            right: 0;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            padding: 10px 0;
            z-index: 1050;
            animation: dropdownFade 0.3s ease-out;
        }

        .dropdown-header-custom {
            padding: 10px 20px;
            font-weight: 500;
            color: #333;
            border-bottom: 1px solid #f1f1f1;
        }

        .dropdown-item-custom {
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            color: #212529;
            font-size: 15px;
            transition: all 0.25s ease;
        }

        .dropdown-item-custom:hover {
            background-color: #f8f9fa;
            color: #dc3545;
        }

        @keyframes dropdownFade {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <script>
        const userIcon = document.getElementById('userMenuToggle');
        const dropdown = document.getElementById('userDropdownMenu');

        userIcon.addEventListener('mouseenter', () => {
            dropdown.style.display = 'block';
        });

        userIcon.addEventListener('mouseleave', () => {
            setTimeout(() => {
                if (!dropdown.matches(':hover')) {
                    dropdown.style.display = 'none';
                }
            }, 200);
        });

        dropdown.addEventListener('mouseleave', () => {
            dropdown.style.display = 'none';
        });

        dropdown.addEventListener('mouseenter', () => {
            dropdown.style.display = 'block';
        });
    </script>














    <?php
    $sanpham_array = [];
    if (isset($_SESSION['danhsach1']) && $_SESSION['danhsach1'] instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($_SESSION['danhsach1'])) {
            $sanpham_array[] = $row;
        }
    }
    ?>
    <script>
        const products = <?= json_encode($sanpham_array, JSON_UNESCAPED_UNICODE) ?>;
    </script>


    <style>
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.8rem;
            margin-top: 30px;
            padding: 0 10px;
        }

        .product-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            border: 1px solid #e3e3e3;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: linear-gradient(to bottom, #ffffff, #f9f9f9);
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }

        .product-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 15px;
        }

        .product-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c3e50;
            line-height: 1.3;
            min-height: 48px;
        }

        .product-desc {
            font-size: 0.95rem;
            color: #555;
            flex-grow: 1;
            overflow: hidden;
            line-height: 1.4;
            margin-bottom: 12px;
            max-height: 42px;
        }

        .product-price {
            font-weight: 700;
            color: #e74c3c;
            font-size: 1rem;
            margin-bottom: 8px;
        }

        .product-price:last-of-type {
            color: #2980b9;
        }

        .product-extra {
            font-size: 0.85rem;
            color: #888;
            margin-bottom: 4px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            }

            .product-image {
                height: 150px;
            }

            .product-title {
                font-size: 1.05rem;
            }

            .product-desc {
                font-size: 0.88rem;
            }

            .product-price {
                font-size: 0.95rem;
            }

            .product-extra {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 576px) {
            .product-grid {
                grid-template-columns: 1fr;
            }

            .product-image {
                height: 130px;
            }

            .product-body {
                padding: 12px;
            }

            .product-title {
                font-size: 1rem;
            }

            .product-desc {
                font-size: 0.85rem;
            }

            .product-price {
                font-size: 0.9rem;
            }

            .product-extra {
                font-size: 0.75rem;
            }
        }
    </style>







    <script>
        // --- Chatbot UI ---
        function renderChatbotUI() {
            // Tránh tạo trùng icon/chatbox
            if (document.getElementById('chatbox') || document.getElementById('chatbotIcon')) return;

            // Tạo icon thu nhỏ ở góc phải dưới
            const iconHTML = `
            <div id="chatbotIcon" style="position: fixed; bottom: 30px; right: 30px; z-index: 99999; cursor: pointer;">
                <div style="width:60px;height:60px;background:#2563eb;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 16px rgba(0,0,0,0.15);">
                    <span style="font-size:32px;color:#fff;">🤖</span>
                </div>
            </div>
        `;
            document.body.insertAdjacentHTML('beforeend', iconHTML);

            // Khi nhấn icon thì hiện chatbox và ẩn icon
            document.getElementById('chatbotIcon').onclick = function() {
                showChatbox();
                this.style.display = 'none';
            };
        }

        function showChatbox() {
            // Nếu đã có chatbox thì không tạo lại
            if (document.getElementById('chatbox')) return;
            const chatbotHTML = `
        <div id="chatbox" style="width: 400px; border: 1px solid #ccc; padding: 10px; position: fixed; bottom: 30px; right: 30px; background: #fff; z-index: 99999; border-radius: 10px; box-shadow: 0 4px 16px rgba(0,0,0,0.15);">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <strong>🤖 Chatbot hỗ trợ</strong>
                <button id="closeChatboxBtn" style="border:none;background:none;font-size:18px;cursor:pointer;">&times;</button>
            </div>
            <div id="chatlog" style="height: 200px; overflow-y: auto; background: #f8f9fa; margin: 10px 0; padding: 8px; border-radius: 6px; font-size: 15px;"></div>
            <div style="display: flex; gap: 5px;">
                <input type="text" id="chatInput" placeholder="Nhập câu hỏi..." style="flex:1; padding: 6px 10px; border-radius: 5px; border: 1px solid #ccc;">
                <button onclick="sendChat()" style="padding: 6px 18px; border-radius: 5px; border: none; background: #2563eb; color: #fff;">Gửi</button>
            </div>
        </div>
        `;
            document.body.insertAdjacentHTML('beforeend', chatbotHTML);

            // Đóng chatbox sẽ hiện lại icon
            document.getElementById('closeChatboxBtn').onclick = function() {
                document.getElementById('chatbox').remove();
                const icon = document.getElementById('chatbotIcon');
                if (icon) icon.style.display = 'block';
            };
        }

        // Khởi tạo icon khi vào trang
        renderChatbotUI();

        // Hàm gửi chat giữ nguyên
        function sendChat() {
            const message = document.getElementById('chatInput').value;
            const chatlog = document.getElementById('chatlog');
            if (!message.trim()) return;
            chatlog.innerHTML += "<div><b>Bạn:</b> " + message + "</div>";
            chatlog.scrollTop = chatlog.scrollHeight;

            fetch("templates/chatbot.php", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: "message=" + encodeURIComponent(message)
                })
                .then(res => res.json())
                .then(data => {
                    chatlog.innerHTML += "<div><b>Bot:</b> " + (data.reply || "Không có phản hồi.") + "</div>";
                    chatlog.scrollTop = chatlog.scrollHeight;
                    document.getElementById('chatInput').value = '';
                })
                .catch(() => {
                    chatlog.innerHTML += "<div><b>Bot:</b> Lỗi kết nối đến máy chủ.</div>";
                    chatlog.scrollTop = chatlog.scrollHeight;
                });
        }
        // --- End Chatbot UI ---

        function changeContent(title) {
            document.querySelector('.content').innerHTML = `
    <h2>${title}</h2>
    <div class="row">
        <div class="col-md-6">
        <h4 class="text-primary text-center">📊 Biểu đồ trạng thái đơn hàng</h4>
        <canvas id="orderStatusChart" height="200"></canvas>
        </div>
        <div class="col-md-6">
        <h4 class="text-success text-center">📈 Tổng số đơn đã làm</h4>
        <p id="completedOrders" class="text-center display-4 text-success"></p>
        <h4 class="text-danger text-center mt-4">📋 Công việc chưa làm</h4>
        <p id="pendingOrders" class="text-center display-4 text-danger"></p>
        </div>
    </div>
    `;

            fetchOrderData();
        }

        function fetchOrderData() {
            fetch('index.php?task=getDonHangData')
                .then(response => response.json())
                .then(data => {
                    console.log(data); // kiểm tra dữ liệu

                    // Bỏ lọc theo tháng, dùng toàn bộ dữ liệu
                    const completedOrders = data.filter(order => order.trangthai === 'Đã xuất').length;
                    const pendingOrders = data.filter(order => order.trangthai === 'Chờ xử lý' || order.trangthai === 'Đang chờ xử lý').length;

                    document.getElementById('completedOrders').innerText = completedOrders;
                    document.getElementById('pendingOrders').innerText = pendingOrders;

                    const statusCounts = data.reduce((acc, order) => {
                        const status = (order.trangthai === 'Đã xuất') ? 'Đã làm' : 'Chưa làm';
                        acc[status] = (acc[status] || 0) + 1;
                        return acc;
                    }, {});

                    renderOrderStatusChart(statusCounts);
                })
                .catch(error => console.error('Lỗi khi lấy dữ liệu:', error));
        }

        function renderOrderStatusChart(statusCounts) {
            const ctx = document.getElementById('orderStatusChart').getContext('2d');
            if (Object.keys(statusCounts).length === 0) {
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Không có đơn hàng'],
                        datasets: [{
                            data: [1],
                            backgroundColor: ['#CCCCCC']
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top'
                            }
                        }
                    }
                });
                return;
            }

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: Object.keys(statusCounts),
                    datasets: [{
                        data: Object.values(statusCounts),
                        backgroundColor: ['#28a745', '#dc3545']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    }
                }
            });
        }
    </script>

<style>#chatbotIcon {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 99999;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        #chatbotIcon:hover {
            transform: scale(1.1);
        }

        #chatbotIcon div {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color), #4f46e5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--box-shadow);
        }

        /* Chatbox */
        #chatbox {
            width: 90%;
            max-width: 400px;
            position: fixed;
            bottom: 80px;
            right: 30px;
            background: #fff;
            z-index: 99999;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { transform: translateY(100px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        #chatbox .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background: linear-gradient(135deg, var(--primary-color), #4f46e5);
            color: #fff;
            border-top-left-radius: var(--border-radius);
            border-top-right-radius: var(--border-radius);
        }

        #chatbox .header button {
            border: none;
            background: none;
            font-size: 18px;
            color: #fff;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        #chatbox .header button:hover {
            color: #ddd;
        }

        #chatlog {
            height: 300px;
            overflow-y: auto;
            background: #f8f9fa;
            margin: 10px;
            padding: 10px;
            border-radius: 6px;
            font-size: 15px;
        }

        #chatlog .message {
            margin: 8px 0;
            padding: 8px 12px;
            border-radius: 8px;
            max-width: 80%;
        }

        #chatlog .user {
            background: var(--primary-color);
            color: #fff;
            margin-left: auto;
            text-align: right;
        }

        #chatlog .bot {
            background: #e9ecef;
            color: var(--text-color);
        }

        #chatInput {
            flex: 1;
            padding: 8px 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 15px;
        }

        #chatInput:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 5px rgba(37, 99, 235, 0.3);
        }

        #chatbox button.send-btn {
            padding: 8px 20px;
            border-radius: 5px;
            border: none;
            background: var(--primary-color);
            color: #fff;
            transition: background 0.3s ease;
        }

        #chatbox button.send-btn:hover {
            background: #1e40af;
        }

        /* Dashboard */
        .content .row {
            margin-top: 20px;
        }

        .content h4 {
            font-weight: 600;
            margin-bottom: 15px;
        }

        .content .display-4 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        @media (max-width: 576px) {
            #chatbox {
                width: 100%;
                bottom: 0;
                right: 0;
                border-radius: 0;
            }
  .content {
            margin-left: 0px;
          
        }
            #chatbotIcon {
                bottom: 20px;
                right: 20px;
            }
        }</style>














    <script>
        function showTable(section) {
            // section có thể là tên hiển thị, ví dụ: "Nhập kho"
            
            document.querySelector('.content').innerHTML = `
            
        <h2 class="text-primary">${section}</h2>
        
        <div id="nhapkho-table" class="mt-4" style="max-height: 420px; overflow-y: auto;">
            <table class="table table-striped table-bordered mb-0">
                <thead class="table-dark" style="position: sticky; top: 0; z-index: 2;">
                    <tr>
                        <th>Mã phiếu nhập</th>
                        <th>Ngày nhập</th>
                        <th>Người nhập</th>
                        <th>Nhà Cung Cấp</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <?php
                $danhsachPhieuNhap = $_SESSION['danhsachPhieuNhap'] ?? [];
                ?>
                <tbody>
                    <?php if (!empty($danhsachPhieuNhap)) : ?>
                        <?php foreach ($danhsachPhieuNhap as $row) : ?>
                            <tr>
                                <td><?= htmlspecialchars($row['maphieunhap']) ?></td>
                                <td><?= htmlspecialchars($row['ngaynhap']) ?></td>
                                <td><?= htmlspecialchars($row['taikhoan1']) ?></td>
                                <td><?= htmlspecialchars($row['nguonnhap']) ?></td>
                                <td>
                                    <button class="btn btn-info btn-sm" onclick="xemChiTietPhieuNhap(this, '<?= htmlspecialchars($row['maphieunhap']) ?>')" title="Xem chi tiết">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deletePhieuNhap('<?= htmlspecialchars($row['maphieunhap']) ?>')" title="Xóa">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="alert alert-danger text-center">Không có phiếu nhập nào!</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
             </div>

            <div class="d-flex align-items-center gap-3 mb-3">
                <a href="index.php?task=danhsach_phieunhap_nhanvien" class="btn btn-primary">
                    Tải phiếu nhập
                </a>
                <button class="btn btn-primary" id="add-phieunhap-btn" onclick="toggleAddPhieuNhapForm()">
                    <i class="bi bi-plus-circle"></i> Thêm phiếu nhập
                </button>
            </div>

           <form method="post" enctype="multipart/form-data" action="index.php?task=importExcel" class="upload-area" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);">
  <div class="upload-box">
    <i class="bi bi-cloud-arrow-up upload-icon"></i>
    <p class="upload-text">Drag and drop your files here</p>
    <p class="upload-subtext">Files supported: XLSX, XLS</p>
    <label class="custom-file-upload">
      Browse files
      <input type="file" name="fileExcel" accept=".xlsx,.xls" required>
    </label>
    <small class="upload-note">Maximum size: 20MB</small>
    <button type="submit" class="btn btn-success mt-3">Tải lên & Nhập dữ liệu</button>
  </div>
</form>
<style>.upload-area {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 300px;
  padding: 20px;
  border: 2px dashed #0d6efd;
  border-radius: 12px;
  background-color: #f8f9fa;
  text-align: center;
  margin-top: 20px;
  transition: background-color 0.3s;
}

.upload-area.dragover {
  background-color: #e3f2fd;
}

.upload-box {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.upload-icon {
  font-size: 50px;
  color: #0d6efd;
  margin-bottom: 10px;
}

.upload-text {
  font-size: 18px;
  font-weight: 600;
}

.upload-subtext {
  font-size: 14px;
  color: #6c757d;
  margin-bottom: 10px;
}

.custom-file-upload {
  background-color: #0d6efd;
  color: white;
  padding: 8px 18px;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
  display: inline-block;
  margin-top: 10px;
  transition: background-color 0.3s;
}

.custom-file-upload:hover {
  background-color: #0b5ed7;
}

.custom-file-upload input[type="file"] {
  display: none;
}

.upload-note {
  font-size: 12px;
  color: #6c757d;
  margin-top: 5px;
}
</style>

            


            <div id="add-phieunhap-form" class="mt-4" style="display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050; background: white; padding: 20px; border-radius: 10px; border: 1px solid #ccc; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); width: 600px;">
                <h3 class="text-center mb-4">Thêm Phiếu Nhập</h3>
                <form id="form-add-phieunhap" method="post" action="index.php?task=themPhieuNhap">
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="ngaynhap" class="form-label">Ngày Nhập</label>
                            <input type="datetime-local" class="form-control" id="ngaynhap" name="ngaynhap"
                                value="<?= date('Y-m-d\TH:i') ?>" required>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="id_nguoinhap" class="form-label">Người Nhập</label>
                            <input type="text" class="form-control" id="id_nguoinhap" name="id_nguoinhap" value="<?= htmlspecialchars($_SESSION['taikhoan1'] ?? '') ?>" readonly>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="nguonnhap" class="form-label">Nguồn Nhập</label>
                            <input type="text" class="form-control" id="nguonnhap" name="nguonnhap" required>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="mahang" class="form-label">Mã Hàng</label>
                            <select class="form-control" id="mahang" name="mahang" required>
                                <option value="">-- Chọn mã hàng --</option>
                                <?php
                                $hanghoaList = $_SESSION['hanghoaList'] ?? [];
                                if (!empty($hanghoaList)) {
                                    foreach ($hanghoaList as $hanghoa) {
                                        echo '<option value="' . htmlspecialchars($hanghoa['masp']) . '">'
                                            . htmlspecialchars($hanghoa['tensp']) . ' (Mã: ' . htmlspecialchars($hanghoa['masp']) . ')</option>';
                                    }
                                } else {
                                    echo '<option value="">Không có hàng hóa nào</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="soluongnhap" class="form-label">Số Lượng Nhập</label>
                            <input type="number" class="form-control" id="soluongnhap" name="soluongnhap" required min="1">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100 mt-3">Thêm Phiếu Nhập</button>
                </form>
                <button class="btn btn-secondary mt-3 w-100" onclick="toggleAddPhieuNhapForm()">Đóng</button>
            </div>
        </div>
        `;

            // Gắn lại các sự kiện cho form và nút sau khi render lại nội dung
            setTimeout(() => {
                if (document.getElementById('form-add-phieunhap')) {
                    document.getElementById('form-add-phieunhap').addEventListener('submit', function(event) {
                        event.preventDefault();
                        var formData = new FormData(this);
                        fetch('index.php?task=themPhieuNhap', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    alert(data.message);
                                    toggleAddPhieuNhapForm();
                                    location.reload();
                                } else {
                                    alert("Lỗi: " + data.message);
                                }
                            })
                            .catch(error => {
                                alert('Có lỗi xảy ra trong quá trình xử lý!');
                            });
                    });
                }
            }, 100);
        }

        function toggleAddPhieuNhapForm() {
            const form = document.getElementById('add-phieunhap-form');
            if (form.style.display === "none" || form.style.display === "") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        }

        function deletePhieuNhap(maphieunhap) {
            if (confirm("Bạn có chắc chắn muốn xóa phiếu nhập này không?")) {
                fetch('index.php?task=xoaPhieuNhap', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'maphieunhap=' + encodeURIComponent(maphieunhap)
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        if (data.status === 'success') {
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        alert('Có lỗi xảy ra khi xóa!');
                    });
            }
        }

        function xemChiTietPhieuNhap(button, maphieunhap) {
            const currentRow = button.closest('tr');
            const nextRow = currentRow.nextElementSibling;
            // Nếu đã có dòng chi tiết thì ẩn đi
            if (nextRow && nextRow.classList.contains('chi-tiet-row')) {
                nextRow.remove();
                return;
            }
            // Xóa các dòng chi tiết khác
            document.querySelectorAll('.chi-tiet-row').forEach(e => e.remove());
            fetch(`index.php?action=xemchitiet&maphieunhap=${encodeURIComponent(maphieunhap)}`)
                .then(response => response.json())
                .then(data => {
                    const newRow = document.createElement('tr');
                    newRow.classList.add('chi-tiet-row');
                    let html = `<td colspan="5"><strong>Chi tiết phiếu nhập:</strong><br>`;
                    if (data.length === 0) {
                        html += `<span class="text-danger">Không có chi tiết nào!</span>`;
                    } else {
                        html += `<table class="table table-sm table-bordered mt-2">
                        <thead class="table-light">
                            <tr>
                                <th>Mã SP</th>
                                <th>Tên SP</th>
                                <th>Số lượng</th>
                                <th>Giá nhập</th>
                            </tr>
                        </thead>
                        <tbody>`;
                        data.forEach(row => {
                            html += `<tr>
                            <td>${row.masp}</td>
                            <td>${row.tensp}</td>
                            <td>${row.soluongnhap}</td>
                            <td>${row.gianhap}</td>
                        </tr>`;
                        });
                        html += `</tbody></table>`;
                    }
                    html += `</td>`;
                    newRow.innerHTML = html;
                    currentRow.parentNode.insertBefore(newRow, currentRow.nextSibling);
                })
                .catch(error => {
                    alert('Không thể tải chi tiết!');
                });
        }
    </script>

<style> 
#add-phieunhap-form {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1050;
            background: #fff;
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            width: 90%;
            max-width: 600px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { transform: translate(-50%, -60%); opacity: 0; }
            to { transform: translate(-50%, -50%); opacity: 1; }
        }

        #add-phieunhap-form h3 {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        #add-phieunhap-form .form-control {
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 8px;
            font-size: 15px;
        }

        #add-phieunhap-form .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 5px rgba(37, 99, 235, 0.3);
            outline: none;
        }

        /* #add-phieunhap-form .btn-success {
            background: var(--success-color);
            border: none;
            padding: 10px;
            font-size: 16px;
            font-weight: 500;
            transition: background 0.3s ease;
        } */

        #add-phieunhap-form .btn-success:hover {
            background: #218838;
        }

        #add-phieunhap-form .btn-secondary {
            background: #6c757d;
            border: none;
            padding: 10px;
            font-size: 16px;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        #add-phieunhap-form .btn-secondary:hover {
            background: #5a6268;
        }

        #form-add-phieunhap .invalid-feedback {
            font-size: 14px;
            color: var(--danger-color);
        }

        @media (max-width: 576px) {
            #add-phieunhap-form {
                width: 100%;
                max-width: 100%;
                border-radius: 0;
                top: 0;
                transform: translate(-50%, 0);
                height: 100%;
                overflow-y: auto;
            }

            #add-phieunhap-form .row {
                flex-direction: column;
            }

            #add-phieunhap-form .col-6 {
                width: 100%;
            }
        }</style>














































































































    <!-- 
    <script>
        // function changeContent(title) {
        //     document.querySelector('.content').innerHTML = `<h2>${title}</h2><p>Nội dung đang cập nhật...</p>`;
        // }

        let productsFiltered = []; // Danh sách sản phẩm sau khi lọc

        function showTableSP(section) {
            productsFiltered = products; // reset dữ liệu gốc

            let contentHTML = `
        <h2 class="text-primary">${section}</h2>
        <div class="search-bar" style="margin-bottom: 20px; text-align: center;">
            <input
                type="text"
                id="searchInput"
                placeholder="🔍 Tìm kiếm sản phẩm theo tên..."
                oninput="filterProducts()"
                style="
                    width: 60%;
                    padding: 10px 15px;
                    border: 1px solid #ccc;
                    border-radius: 25px;
                    font-size: 16px;
                    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
                "
            />
        </div>
        <div class="product-grid">
    `;

            if (Array.isArray(productsFiltered) && productsFiltered.length > 0) {
                productsFiltered.forEach(row => {
                    contentHTML += `
                <div class="product-card">
                    <img class="product-image" src="${row.hinhanh || 'no-image.jpg'}" alt="${row.tensp}">
                    <div class="product-body">
                        <div class="product-title">Tên sản phẩm: ${row.tensp}</div>
                        <div class="product-desc">Mô tả chi tiết: ${row.mota || 'Không có mô tả'}</div>
                        <div class="product-price">Giá nhập: ${row.gianhap}₫</div>
                        <div class="product-price">Giá xuất: ${row.giaxuat}₫</div>
                        <div class="product-extra">Mã SP: ${row.masp}</div>
                        <div class="product-extra">Tồn: ${row.soluongton} - Đơn vị: ${row.donvitinh}</div>
                        <div class="product-extra">Ngày tạo: ${row.ngaytao}</div>
                        <div class="product-extra">Cập nhật: ${row.ngaycapnhat}</div>
                    </div>
                </div>`;
                });
            } else {
                contentHTML += `<div class="alert alert-danger text-center">Không có sản phẩm nào!</div>`;
            }

            contentHTML += `</div>`;

            const contentDiv = document.querySelector('.content');
            if (contentDiv) {
                contentDiv.innerHTML = contentHTML;
            } else {
                console.error("Không tìm thấy .content để hiển thị dữ liệu.");
            }
        }

        function filterProducts() {
            const keyword = document.getElementById("searchInput").value.toLowerCase().trim();
            productsFiltered = products.filter(row => row.tensp.toLowerCase().includes(keyword));
            showFilteredProducts();
        }

        function showFilteredProducts() {
            let html = `<div class="product-grid">`;

            if (productsFiltered.length > 0) {
                productsFiltered.forEach(row => {
                    html += `
                <div class="product-card">
                    <img class="product-image" src="${row.hinhanh || 'no-image.jpg'}" alt="${row.tensp}">
                    <div class="product-body">
                        <div class="product-title">Tên sản phẩm: ${row.tensp}</div>
                        <div class="product-desc">Mô tả chi tiết: ${row.mota || 'Không có mô tả'}</div>
                        <div class="product-price">Giá nhập: ${row.gianhap}₫</div>
                        <div class="product-price">Giá xuất: ${row.giaxuat}₫</div>
                        <div class="product-extra">Mã SP: ${row.masp}</div>
                        <div class="product-extra">Tồn: ${row.soluongton} - Đơn vị: ${row.donvitinh}</div>
                        <div class="product-extra">Ngày tạo: ${row.ngaytao}</div>
                        <div class="product-extra">Cập nhật: ${row.ngaycapnhat}</div>
                    </div>
                </div>`;
                });
            } else {
                html += `<div class="alert alert-warning text-center">Không tìm thấy sản phẩm phù hợp!</div>`;
            }

            html += `</div>`;
            document.querySelector('.product-grid').outerHTML = html;
        } -->




    <script>
        const inputStyle = `
    width: 60%;
    padding: 10px 15px;
    border: 1px solid #ccc;
    border-radius: 25px;
    font-size: 16px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
`;

        const gridStyle = `
    max-height: 600px;
    overflow-y: auto;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    padding: 10px;
`;

        const cardStyle = `
    border: 1px solid #ddd;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    background: #fff;
`;

        const imageStyle = `width: 100%; height: 200px; object-fit: cover;`;
        const bodyStyle = `padding: 10px;`;

        function showTableSP(section) {
            productsFiltered = products;

            let contentHTML = `
        <h2 class="text-primary">${section}</h2>
        <div class="search-bar" style="margin-bottom: 20px; text-align: center;">
            <input
                type="text"
                id="searchInput"
                placeholder="🔍 Tìm kiếm sản phẩm theo tên..."
                oninput="filterProducts()"
                style="${inputStyle}"
            />
        </div>
        <div class="product-grid" style="${gridStyle}">
    `;

            if (Array.isArray(productsFiltered) && productsFiltered.length > 0) {
                productsFiltered.forEach(row => {
                    contentHTML += `
                <div class="product-card" style="${cardStyle}">
                    <img class="product-image" src="${row.hinhanh || 'no-image.jpg'}" alt="${row.tensp}" style="${imageStyle}">
                    <div class="product-body" style="${bodyStyle}">
                        <div><strong>Tên sản phẩm:</strong> ${row.tensp}</div>
                        <div><strong>Mô tả chi tiết:</strong> ${row.mota || 'Không có mô tả'}</div>
                        <div><strong>Giá nhập:</strong> ${row.gianhap}₫</div>
                        <div><strong>Giá xuất:</strong> ${row.giaxuat}₫</div>
                        <div><strong>Mã SP:</strong> ${row.masp}</div>
                        <div><strong>Tồn:</strong> ${row.soluongton} - <strong>Đơn vị:</strong> ${row.donvitinh}</div>
                        <div><strong>Ngày tạo:</strong> ${row.ngaytao}</div>
                        <div><strong>Cập nhật:</strong> ${row.ngaycapnhat}</div>
                    </div>
                </div>`;
                });
            } else {
                contentHTML += `<div class="alert alert-danger text-center" style="grid-column: 1 / -1;">Không có sản phẩm nào!</div>`;
            }

            contentHTML += `</div>`;
            const contentDiv = document.querySelector('.content');
            contentDiv ? contentDiv.innerHTML = contentHTML : console.error("Không tìm thấy .content");
        }

        function filterProducts() {
            const keyword = document.getElementById("searchInput").value.toLowerCase().trim();
            productsFiltered = products.filter(row => row.tensp.toLowerCase().includes(keyword));
            showFilteredProducts();
        }

        function showFilteredProducts() {
            let html = `<div class="product-grid" style="${gridStyle}">`;

            if (productsFiltered.length > 0) {
                productsFiltered.forEach(row => {
                    html += `
                <div class="product-card" style="${cardStyle}">
                    <img class="product-image" src="${row.hinhanh || 'no-image.jpg'}" alt="${row.tensp}" style="${imageStyle}">
                    <div class="product-body" style="${bodyStyle}">
                        <div><strong>Tên sản phẩm:</strong> ${row.tensp}</div>
                        <div><strong>Mô tả chi tiết:</strong> ${row.mota || 'Không có mô tả'}</div>
                        <div><strong>Giá nhập:</strong> ${row.gianhap}₫</div>
                        <div><strong>Giá xuất:</strong> ${row.giaxuat}₫</div>
                        <div><strong>Mã SP:</strong> ${row.masp}</div>
                        <div><strong>Tồn:</strong> ${row.soluongton} - <strong>Đơn vị:</strong> ${row.donvitinh}</div>
                        <div><strong>Ngày tạo:</strong> ${row.ngaytao}</div>
                        <div><strong>Cập nhật:</strong> ${row.ngaycapnhat}</div>
                    </div>
                </div>`;
                });
            } else {
                html += `<div class="alert alert-warning text-center" style="grid-column: 1 / -1;">Không tìm thấy sản phẩm phù hợp!</div>`;
            }

            html += `</div>`;
            document.querySelector('.product-grid').outerHTML = html;
        }






























        function showXuatKhoForm() {
            document.querySelector('.content').innerHTML = `
        <h2>Xuất kho</h2>
        <p>Chọn sản phẩm để xuất kho.</p>
        <table class="table table-bordered" id="donhangTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Nhân viên</th>
                    <th>Ngày lập</th>
                    <th>Khách hàng</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="donhangData">
                <!-- Dữ liệu sẽ được thêm bằng JavaScript -->
            </tbody>
        </table>
        <div id="paginationDonHang" class="d-flex justify-content-center mt-3 flex-wrap gap-2"></div>

    `;
            loadDonHangData(); // Gọi hàm để tải dữ liệu đơn hàng
        }


        let donHangData = []; // Dữ liệu toàn bộ đơn hàng
        let currentPage = 1;
        const ITEMS_PER_PAGE = 5;

        function renderDonHangTable(page) {
            const tableBody = document.getElementById('donhangData');
            tableBody.innerHTML = ''; // Xóa dữ liệu cũ

            const start = (page - 1) * ITEMS_PER_PAGE;
            const end = start + ITEMS_PER_PAGE;
            const pageData = donHangData.slice(start, end);

            pageData.forEach(donhang => {
                const row = document.createElement('tr');
                const buttonHtml = donhang.trangthai === 'Đã xuất' ?
                    `<button class="btn btn-danger" onclick="huyXuatDonHang(${donhang.id}, this)">Done</button>` :
                    `<button class="btn btn-info" onclick="xuatDonHang(${donhang.id}, this)">Xuất</button>`;

                // Nút xóa đơn hàng
                const deleteBtn = document.createElement('button');
                deleteBtn.className = 'btn btn-danger btn-sm ms-2';
                deleteBtn.innerHTML = '<i class="bi bi-trash"></i> Xóa';
                deleteBtn.onclick = function() {
                    if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')) {
                        fetch('index.php?task=deleteDonHang', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: 'id=' + encodeURIComponent(donhang.id)
                            })
                            .then(res => res.json())
                            .then(data => {
                                alert(data.message || 'Đã xóa!');
                                if (data.success) {
                                    loadDonHangData();
                                }
                            })
                            .catch(() => alert('Lỗi khi xóa đơn hàng!'));
                    }
                };
                // Thêm nút xóa vào cột hành động
                setTimeout(() => {
                    const actionCell = row.querySelector('td:last-child');
                    if (actionCell) actionCell.appendChild(deleteBtn);
                }, 0);
                row.innerHTML = `
            <td>${donhang.id}</td>
            <td>${donhang.id_nhanvien}</td>
            <td>${donhang.ngaylap}</td>
            <td>${donhang.diachi}</td>
            <td class="trangthai">${donhang.trangthai}</td>
            <td>
                ${buttonHtml}
                <button class="btn btn-detail" onclick="xemChiTietDonHang(${donhang.id})">
                    <i class="bi bi-info-circle"></i> Chi tiết
                </button>
            </td>
        `;
                tableBody.appendChild(row);
            });

            renderDonHangPagination();
        }

        function renderDonHangPagination() {
            const pagination = document.getElementById('paginationDonHang');
            if (!pagination) return; // Không có div thì bỏ qua

            pagination.innerHTML = '';
            const totalPages = Math.ceil(donHangData.length / ITEMS_PER_PAGE);

            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.className = `btn btn-outline-primary btn-sm ${i === currentPage ? 'active' : ''}`;
                btn.textContent = i;
                btn.addEventListener('click', () => {
                    currentPage = i;
                    renderDonHangTable(currentPage);
                });
                pagination.appendChild(btn);
            }
        }

        // Hàm lấy dữ liệu đơn hàng từ server
        function loadDonHangData() {
            fetch('index.php?task=getDonHangData')
                .then(response => response.json())
                .then(data => {
                    donHangData = data;
                    currentPage = 1;
                    renderDonHangTable(currentPage);
                })
                .catch(error => console.error('Lỗi:', error));
        }


        function xuatDonHang(id, button) {
            // Hiển thị hộp thoại xác nhận
            if (confirm("Bạn có chắc chắn muốn xuất đơn hàng này?")) {
                // Nếu người dùng nhấn "OK"
                fetch(`index.php?task=updateTrangThai&id=${id}&trangthai=Đã xuất`, {
                        method: 'GET',
                    })
                    .then(response => response.text()) // Dùng text() để kiểm tra phản hồi thô
                    .then(responseText => {
                        console.log(responseText); // Ghi lại phản hồi thô
                        try {
                            const data = JSON.parse(responseText); // Thử phân tích nó như JSON
                            if (data.success) {
                                console.log("Cập nhật trạng thái thành công");
                                // Sau khi cập nhật thành công, reload lại trang
                                window.location.reload(); // Tải lại trang ngay lập tức
                            } else {
                                alert('Lỗi khi cập nhật trạng thái');
                            }
                        } catch (error) {
                            console.error('Lỗi khi phân tích cú pháp JSON:', error);
                        }
                    })
                    .catch(error => console.error('Lỗi:', error));
            } else {
                // Nếu người dùng nhấn "Cancel", không làm gì cả
                console.log("Người dùng đã hủy thao tác");
            }
        }

        // Hàm hủy xuất đơn hàng
        function huyXuatDonHang(id, button) {
            // Hiển thị hộp thoại xác nhận
            if (confirm("Bạn có chắc chắn muốn huỷ xuất đơn hàng này?")) {
                // Nếu người dùng nhấn "OK"
                fetch(`index.php?task=updateTrangThai&id=${id}&trangthai=Đang chờ xử lý`, {
                        method: 'GET',
                    })
                    .then(response => response.text()) // Dùng text() để kiểm tra phản hồi thô
                    .then(responseText => {
                        console.log(responseText); // Ghi lại phản hồi thô
                        try {
                            const data = JSON.parse(responseText); // Thử phân tích nó như JSON
                            if (data.success) {
                                console.log("Hủy xuất thành công");
                                // Sau khi hủy xuất thành công, reload lại trang
                                window.location.reload(); // Tải lại trang ngay lập tức
                            } else {
                                alert('Lỗi khi hủy xuất trạng thái');
                            }
                        } catch (error) {
                            console.error('Lỗi khi phân tích cú pháp JSON:', error);
                        }
                    })
                    .catch(error => console.error('Lỗi:', error));
            } else {
                // Nếu người dùng nhấn "Cancel", không làm gì cả
                console.log("Người dùng đã hủy thao tác");
            }
        }

        function xemChiTietDonHang(id) {
            fetch(`index.php?task=getDonHangChiTiet&id=${id}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.text();
                })
                .then(data => {
                    console.log('Dữ liệu nhận được:', data);
                    try {
                        let jsonData = JSON.parse(data);
                        if (jsonData && jsonData.length > 0) {
                            let modalContent = `
                        <h2>Chi tiết đơn hàng ${jsonData[0].id_donhang}</h2>
                        <p><strong>ID Đơn hàng:</strong> ${jsonData[0].id_donhang}</p>
                        <h3>Sản phẩm</h3>
                        <ul>
                    `;

                            let tongTien = 0;

                            jsonData.forEach(item => {
                                let thanhTien = item.soluong * item.giaxuat;
                                tongTien += thanhTien;

                                modalContent += `
                            <li style="margin-bottom: 10px;">
                                <img src="${item.hinhanh}" alt="${item.tensp}" style="width: 50px; height: 50px; object-fit: cover; vertical-align: middle; margin-right: 10px;">
                                <strong>${item.tensp}</strong> (${item.masp})<br>
                                Số lượng: ${item.soluong}<br>
                                Giá xuất: ${item.giaxuat.toLocaleString()}đ<br>
                                Thành tiền: ${thanhTien.toLocaleString()}đ
                            </li>
                        `;
                            });

                            modalContent += `</ul>
                        <p><strong>Tổng tiền:</strong> ${tongTien.toLocaleString()}đ</p>
                        <button onclick="closeModal()">Đóng</button>
                    `;

                            const modal = document.createElement('div');
                            modal.id = 'modalDetail';
                            modal.style = `
                        position: fixed;
                        top: 0; left: 0;
                        width: 100%; height: 100%;
                        background-color: rgba(0, 0, 0, 0.7);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    `;
                            modal.innerHTML = `
                        <div style="background: white; padding: 20px; max-width: 600px; width: 100%; overflow-y: auto; max-height: 80vh;">
                            ${modalContent}
                        </div>
                    `;
                            document.body.appendChild(modal);
                        } else {
                            alert("Không tìm thấy chi tiết đơn hàng");
                        }
                    } catch (error) {
                        console.error('Lỗi JSON:', error);
                        alert("Có lỗi xảy ra. Dữ liệu trả về không hợp lệ.");
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    alert("Có lỗi xảy ra. Vui lòng thử lại.");
                });
        }


        function closeModal() {
            const modal = document.getElementById('modalDetail');
            if (modal) {
                modal.remove();
            }
        }










        window.onload = function() {
            const hash = window.location.hash.replace('#', '');
            switch (hash) {
                case 'sanpham':
                    showTableSP('Danh sách sản phẩm');
                    break;
                case 'nhapkho':
                    showTable('Nhập kho');
                    break;
                case 'xuatkho':
                    showXuatKhoForm();
                    break;
                case 'baocao':
                    showTableTK('Báo cáo & Thống kê');
                    break;
                case 'lichsu':
                    showTableLS('Lịch sử giao dịch');
                    break;
                case 'cauhinh':
                    showCauHinh('Cấu hình hệ thống');
                    break;
                default:
                    changeContent('Dashboard');
            }
        };
    </script>
    <style>
        /* Định nghĩa kiểu cho modal */
        #modalDetail {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            animation: fadeIn 0.3s ease-in-out;
        }

        /* Tạo hiệu ứng mờ cho phần nền modal */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        /* Định dạng cho hộp nội dung modal */
        #modalDetail>div {
            background-color: white;
            padding: 20px;
            max-width: 600px;
            width: 90%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        /* Tiêu đề của modal */
        #modalDetail h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
            font-weight: 600;
        }

        /* Các đoạn văn bản trong modal */
        #modalDetail p {
            font-size: 16px;
            margin: 8px 0;
            color: #555;
        }

        /* Danh sách sản phẩm */
        #modalDetail ul {
            list-style: none;
            padding: 0;
            margin-top: 10px;
        }

        #modalDetail ul li {
            font-size: 16px;
            color: #555;
            margin-bottom: 8px;
            padding-left: 20px;
            position: relative;
        }

        #modalDetail ul li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #3498db;
            font-size: 18px;
            top: 0;
        }

        /* Nút đóng modal */
        #modalDetail button {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        #modalDetail button:hover {
            background-color: #2980b9;
        }

        /* Hiệu ứng cho nút khi hover */
        #modalDetail button:focus {
            outline: none;
        }
    </style>







    <style>
        .content {
            padding: 30px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f7f9fc;
        }

        h2 {
            margin-top: 40px;
            color: #2c3e50;
            font-weight: bold;
            /* text-transform: uppercase; */
            border-left: 6px solid #3498db;
            padding-left: 10px;
        }

        table.table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-radius: 6px;
            overflow: hidden;
        }

        table.table th,
        table.table td {
            text-align: center;
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }

        table.table th {
            background-color: #3498db;
            color: white;
            font-weight: 600;
        }

        table.table tbody tr:nth-child(even) {
            background-color: #f2f6f9;
        }

        table.table tbody tr:hover {
            background-color: #e6f7ff;
            cursor: pointer;
            transition: 0.2s;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        td[colspan="8"] {
            font-style: italic;
            color: #999;
        }

        @media screen and (max-width: 768px) {

            table.table,
            table.table thead,
            table.table tbody,
            table.table th,
            table.table td,
            table.table tr {
                display: block;
            }

            table.table thead {
                display: none;
            }

            table.table td {
                position: relative;
                padding-left: 50%;
                text-align: left;
            }

            table.table td::before {
                position: absolute;
                top: 12px;
                left: 12px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                font-weight: bold;
                color: #666;
            }

            table.table td:nth-child(1)::before {
                content: "Mã phiếu";
            }

            table.table td:nth-child(2)::before {
                content: "Ngày";
            }

            table.table td:nth-child(3)::before {
                content: "ID người";
            }

            table.table td:nth-child(4)::before {
                content: "Mã SP";
            }

            table.table td:nth-child(5)::before {
                content: "Tên SP";
            }

            table.table td:nth-child(6)::before {
                content: "Số lượng";
            }

            table.table td:nth-child(7)::before {
                content: "Đơn giá";
            }

            table.table td:nth-child(8)::before {
                content: "Thành tiền";
            }
        }
    </style>



    <script>
        function showTableLS() {
            const startDate = document.getElementById('startDate')?.value ?? '';
            const endDate = document.getElementById('endDate')?.value ?? '';

            document.querySelector('.content').innerHTML = `
        <div class="row mb-4">
            <div class="col">
            <label class="form-label">Ngày bắt đầu:</label>
            <input type="date" id="startDate" class="form-control shadow-sm" value="${startDate}">
            </div>
            <div class="col">
            <label class="form-label">Ngày kết thúc:</label>
            <input type="date" id="endDate" class="form-control shadow-sm" value="${endDate}">
            </div>
            <div class="col-auto d-flex align-items-end">
            <button class="btn btn-primary shadow-sm" onclick="showTableLS()">🔍 Lọc dữ liệu</button>
            </div>
        </div>

        <h2 class="text-primary text-center mb-4">📥 Lịch sử Nhập Kho</h2>
        <table class="table table-bordered table-hover shadow-sm">
            <thead class="table-primary">
            <tr>
                <th>Mã phiếu</th>
                <th>Ngày nhập</th>
                <th>ID Người nhập</th>
                <th>Mã SP</th>
                <th>Tên SP</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
            </thead>
            <tbody id="nhapKhoData">
            <tr><td colspan="8" class="text-center text-muted">Đang tải...</td></tr>
            </tbody>
        </table>

        <h2 class="text-danger text-center mt-5 mb-4">📤 Lịch sử Xuất Kho</h2>
        <table class="table table-bordered table-hover shadow-sm">
            <thead class="table-danger">
            <tr>
                <th>Mã phiếu</th>
                <th>Ngày xuất</th>
                <th>ID Người xuất</th>
                <th>Mã SP</th>
                <th>Tên SP</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
            </thead>
            <tbody id="xuatKhoData">
            <tr><td colspan="8" class="text-center text-muted">Đang tải...</td></tr>
            </tbody>
        </table>
        `;

            const nhapURL = startDate && endDate ?
                `index.php?task=getLichSuNhapKho1&start=${startDate}&end=${endDate}` :
                `index.php?task=getLichSuNhapKho`;

            const xuatURL = startDate && endDate ?
                `index.php?task=getLichSuXuatKho1&start=${startDate}&end=${endDate}` :
                `index.php?task=getLichSuXuatKho`;

            fetch(nhapURL)
                .then(res => res.json())
                .then(data => {
                    const tbody = document.getElementById('nhapKhoData');
                    tbody.innerHTML = '';
                    if (data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted">Không có dữ liệu</td></tr>';
                        return;
                    }
                    data.forEach(item => {
                        const row = `
                <tr class="table-light">
                <td>${item.maphieunhap}</td>
                <td>${item.ngaynhap}</td>
                <td>${item.id_nguoinhap}</td>
                <td>${item.masp}</td>
                <td>${item.tensp}</td>
                <td>${item.soluongnhap}</td>
                <td>${parseInt(item.gianhap).toLocaleString()}đ</td>
                <td>${parseInt(item.thanhtien).toLocaleString()}đ</td>
                </tr>
            `;
                        tbody.innerHTML += row;
                    });
                });

            fetch(xuatURL)
                .then(res => res.json())
                .then(data => {
                    const tbody = document.getElementById('xuatKhoData');
                    tbody.innerHTML = '';
                    if (data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted">Không có dữ liệu</td></tr>';
                        return;
                    }
                    data.forEach(item => {
                        const row = `
                <tr class="table-light">
                <td>${item.maphieuxuat}</td>
                <td>${item.ngayxuat}</td>
                <td>${item.id_nguoixuat}</td>
                <td>${item.masp}</td>
                <td>${item.tensp}</td>
                <td>${item.soluongxuat}</td>
                <td>${parseInt(item.giaxuat).toLocaleString()}đ</td>
                <td>${parseInt(item.thanhtien).toLocaleString()}đ</td>
                </tr>
            `;
                        tbody.innerHTML += row;
                    });
                });
        }
    </script>



















    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let chartTK;

        function showTableTK(title) {
            const today = new Date().toISOString().split('T')[0];

            document.querySelector('.content').innerHTML = `
        <div class="container">
            <h2 class="mb-4 text-center text-primary">${title}</h2>
            <div class="row mb-4">
            <div class="col-md-4">
                <label class="form-label fw-bold">Ngày bắt đầu:</label>
                <input type="date" id="startDate" class="form-control shadow-sm" value="${today}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Ngày kết thúc:</label>
                <input type="date" id="endDate" class="form-control shadow-sm" value="${today}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-primary w-100 shadow-sm" onclick="filterData()">🔍 Lọc dữ liệu</button>
            </div>
            </div>

            <div class="row">
            <div class="col-md-12">
                <h4 class="text-center text-success">📊 Biểu đồ Thống Kê Nhập/Xuất Kho</h4>
                <div class="chart-container" style="position: relative; height: 400px;">
                <canvas id="chartTK"></canvas>
                </div>
            </div>
            </div>
        </div>
        `;

            filterData();
        }

        function filterData() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;

            // Lấy dữ liệu từ API
            Promise.all([
                fetch(`index.php?task=getLichSuNhapKho1&start=${startDate}&end=${endDate}`).then(res => res.json()),
                fetch(`index.php?task=getLichSuXuatKho1&start=${startDate}&end=${endDate}`).then(res => res.json())
            ]).then(([dataNhap, dataXuat]) => {
                const nhapMap = {},
                    xuatMap = {};

                // Tính số đơn theo ngày
                dataNhap.forEach(item => {
                    const date = item.ngaynhap.split(' ')[0];
                    nhapMap[date] = (nhapMap[date] || 0) + 1;
                });
                dataXuat.forEach(item => {
                    const date = item.ngayxuat.split(' ')[0];
                    xuatMap[date] = (xuatMap[date] || 0) + 1;
                });

                const allDates = Array.from(new Set([...Object.keys(nhapMap), ...Object.keys(xuatMap)])).sort();
                const nhapData = allDates.map(date => nhapMap[date] || 0);
                const xuatData = allDates.map(date => xuatMap[date] || 0);

                if (chartTK) chartTK.destroy();

                // Biểu đồ gộp
                const ctxTK = document.getElementById('chartTK').getContext('2d');
                chartTK = new Chart(ctxTK, {
                    type: 'bar',
                    data: {
                        labels: allDates,
                        datasets: [{
                                label: 'Số đơn nhập',
                                data: nhapData,
                                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                                type: 'line'
                            },
                            {
                                label: 'Số đơn xuất',
                                data: xuatData,
                                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Số đơn',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    }
                                },
                                grid: {
                                    color: '#e9ecef'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Ngày',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    }
                                },
                                grid: {
                                    color: '#e9ecef'
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleFont: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 12
                                }
                            },
                            legend: {
                                labels: {
                                    font: {
                                        size: 12,
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    }
                });
            }).catch(error => {
                console.error('Lỗi khi lấy dữ liệu:', error);
            });
        }
    </script>


































































    <!-- NHÚNG i18next TRƯỚC -->
    <script src="https://unpkg.com/i18next@latest/i18next.min.js"></script>

    <!-- Sau đó nhúng file chứa object `translations` -->
    <script src="http://localhost/quanlykho/templates/lang.js"></script>

    <!-- Cuối cùng là script xử lý -->
    <script>
        const savedLang = localStorage.getItem('lang') || 'vi';

        i18next.init({
            lng: savedLang,
            resources: {
                vi: {
                    translation: translations.vi
                },
                en: {
                    translation: translations.en
                }
            }
        }, function(err, t) {
            updateContent();
        });



        function updateContent() {
            document.querySelectorAll('[data-i18n]').forEach(function(el) {
                el.innerHTML = i18next.t(el.getAttribute('data-i18n'));
            });
        }

        function showCauHinh() {
            const contentDiv = document.querySelector('.content');
            if (!contentDiv) return;

            contentDiv.innerHTML = `
        <div class="text-center p-4 shadow rounded bg-light">
            <h2 class="text-primary mb-3">
                <i class="fas fa-globe me-2"></i>
                <span data-i18n="title"></span>
            </h2>
            <p class="lead mb-4" data-i18n="chooseLang"></p>
            <div class="d-flex justify-content-center gap-3 mb-4">
                <div onclick="setLanguage('vi')" class="lang-option" title="Tiếng Việt">
                    <img src="https://flagcdn.com/w80/vn.png" width="60" height="40" alt="Vietnam Flag">
                    <p class="mt-2 mb-0" data-i18n="btnVi"></p>
                </div>
                <div onclick="setLanguage('en')" class="lang-option" title="English">
                    <img src="https://flagcdn.com/w80/us.png" width="60" height="40" alt="US Flag">
                    <p class="mt-2 mb-0" data-i18n="btnEn"></p>
                </div>
            </div>
            <div>
                <button class="btn btn-dark px-4" onclick="showHome()">
                    <i class="fas fa-arrow-left me-2"></i>
                    <span data-i18n="back"></span>
                </button>
            </div>
        </div>
    `;

            updateContent(); // Cập nhật ngôn ngữ sau khi DOM đã được gán xong
        }


        function setLanguage(lang) {
            i18next.changeLanguage(lang, () => {
                localStorage.setItem('lang', lang);
                updateContent();
                showCauHinh();
            });
        }

        function showHome() {
            location.reload();
        }
    </script>




    <style>
        .lang-option {
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            text-align: center;
        }

        .lang-option:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .lang-option img {
            border-radius: 8px;
            border: 2px solid #ccc;
        }
    </style>





























    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>

</html>