<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quản Lý Kho</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


  <style>
    body,
    html {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
    }

    .sidebar {
      height: 100vh;
      width: 250px;
      position: fixed;
      top: 0;
      left: 0;
      background: linear-gradient(180deg, #0d6efd 0%, #0a58ca 100%);
      padding-top: 8rem;
      box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      z-index: 1000;
    }

    .sidebar .nav-link {
      display: block;
      padding: 15px 25px;
      font-size: 16px;
      color: white;
      text-decoration: none;
      position: relative;
      transition: all 0.2s ease-in-out;
      border-radius: 8px;
      margin: 8px 16px;
    }

    .sidebar .nav-link:hover {
      background: rgba(255, 255, 255, 0.15);
      color: #fff;
      transform: translateX(5px);
      box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.05);
    }

    .sidebar .nav-link::before {
      content: '•';
      position: absolute;
      left: -10px;
      font-size: 20px;
      color: #ffc107;
      opacity: 0;
      transition: 0.3s;
    }

    .sidebar .nav-link:hover::before {
      opacity: 1;
    }

    .main-content {
      margin-left: 250px;
      padding: 2rem;
      min-height: 100vh;
      background-color: #f1f4f9;
      transition: margin-left 0.3s ease;
    }

    .hidden {
      display: none;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        padding-top: 1rem;
      }

      .main-content {
        margin-left: 0;
        padding: 1rem;
      }
    }







    .logo-container {
      position: absolute;
      top: 0;
      left: 40%;
      transform: translateX(-50%);
      width: 50%;
      padding-top: 10px;
      /* Optional: space from the top */
      text-align: center;
    }

    .logo-container img {
      max-width: 100%;
      height: auto;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .logo-container img {
        max-width: 80%;
        /* You can reduce the max-width on smaller screens */
      }
    }
  </style>
</head>

<body>
  <!-- header.php -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <div class="top-right-menu d-flex justify-content-end align-items-center p-3">
    <?php if (isset($_SESSION['taikhoan1'])): ?>
      <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle fw-bold" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          👋 Chào, <?php echo $_SESSION['taikhoan1']; ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
          <li><a class="dropdown-item" href="index.php?task=dangxuat">🚪 Đăng xuất</a></li>
          <li><a class="dropdown-item" href="index.php?task=formnhanvien">👨‍💼 Form Nhân viên</a></li>
          <li><a class="dropdown-item" href="index.php?task=formketoan">📊 Form Kế toán</a></li>
        </ul>
      </div>
    <?php else: ?>
      <a href="index.php?task=formdangnhap" class="btn btn-primary">🔐 Đăng nhập</a>
    <?php endif; ?>
  </div>



 <!-- Sidebar cho desktop -->
<nav class="sidebar col-md-3 col-lg-2 d-md-block text-white">

  <ul class="nav flex-column">
    <li class="nav-item text-center">
      <img src="/quanlykho/img/ce444940-26cd-48f4-b120-00dc6e4f6037.png" alt="Logo" class="img-fluid mx-auto d-block" style="max-width: 50%;">
    </li>

    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center" href="#dashboard" onclick="changeContent('Dashboard')">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center" href="#sanpham" onclick="showTable('sanpham')">
        <i class="bi bi-box-seam me-2"></i> Quản lý sản phẩm
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center" href="#nhapkho" onclick="showTable('nhapkho')">
        <i class="bi bi-arrow-down-circle me-2"></i> Nhập kho
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center" href="#xuatkho" onclick="showTable('xuatkho')">
        <i class="bi bi-arrow-up-circle me-2"></i> Xuất kho
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center" href="#baocao" onclick="showTable('baocao')">
        <i class="bi bi-bar-chart-line me-2"></i> Báo cáo & Thống kê
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center" href="#nhanvien" onclick="showTable('nhanvien')">
        <i class="bi bi-people me-2"></i> Quản lý nhân viên
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white d-flex align-items-center" href="#cauhinh" onclick="changeContent('Cấu hình hệ thống')">
        <i class="bi bi-gear me-2"></i> Cấu hình hệ thống
      </a>
    </li>
  </ul>
</nav>

<!-- Nút hamburger và menu cho mobile -->
<nav class="navbar navbar-dark bg-dark d-md-none">
  <div class="container-fluid">
    <!-- Nút hamburger -->
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu"
      onclick="removeAllOffcanvasBackdrop()">
      <span class="navbar-toggler-icon"></span>
    </button>
    <script>
      // Xóa tất cả các backdrop offcanvas
      function removeAllOffcanvasBackdrop() {
      setTimeout(function() {
        document.querySelectorAll('.offcanvas-backdrop').forEach(el => el.remove());
      }, 300); // Đợi Bootstrap thêm backdrop rồi xóa hết
      }
    </script>
    <!-- Logo -->
    <a class="navbar-brand" href="#">
      <img src="/quanlykho/img/ce444940-26cd-48f4-b120-00dc6e4f6037.png" alt="Logo" height="40" class="d-inline-block align-text-top">
    </a>
  </div>
</nav>

<!-- Offcanvas menu cho mobile -->
<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="mobileMenuLabel">
      <img src="/quanlykho/img/ce444940-26cd-48f4-b120-00dc6e4f6037.png" alt="Logo" height="40">
    </h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="#dashboard" onclick="changeContent('Dashboard');" data-bs-dismiss="offcanvas">
          <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="#sanpham" onclick="showTable('sanpham');" data-bs-dismiss="offcanvas">
          <i class="bi bi-box-seam me-2"></i> Quản lý sản phẩm
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="#nhapkho" onclick="showTable('nhapkho');" data-bs-dismiss="offcanvas">
          <i class="bi bi-arrow-down-circle me-2"></i> Nhập kho
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="#xuatkho" onclick="showTable('xuatkho');" data-bs-dismiss="offcanvas">
          <i class="bi bi-arrow-up-circle me-2"></i> Xuất kho
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="#baocao" onclick="showTable('baocao');" data-bs-dismiss="offcanvas">
          <i class="bi bi-bar-chart-line me-2"></i> Báo cáo & Thống kê
        </a>
      </li>
    <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="#nhanvien" onclick="showTable('nhanvien'); closeOffcanvas()">
          <i class="bi bi-people me-2"></i> Quản lý nhân viên
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="#cauhinh" onclick="changeContent('cauhinh'); closeOffcanvas()">
          <i class="bi bi-gear me-2"></i> Cấu hình hệ thống
        </a>
      </li>
    </ul>
  </div>
</div>

<script>function closeOffcanvas() {
  const offcanvas = document.getElementById('mobileMenu');
  const offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvas);
  if (offcanvasInstance) {
    offcanvasInstance.hide();
  }
}</script>

  <style>
   /* Sidebar cho desktop */
.sidebar {
  background-color: #343a40;
  height: 100vh;
  padding: 1rem;
  position: fixed;
  top: 0;
  left: 0;
  width: 250px;
  overflow-y: auto;
}

.sidebar .logo-container img {
  max-width: 80%;
}

.sidebar .nav-link {
  padding: 10px;
  font-size: 16px;
  transition: background-color 0.3s;
}



/* Điều chỉnh nội dung chính để tránh bị che bởi sidebar trên desktop */
@media (min-width: 768px) {
  .container-fluid {
    margin-left: 250px; /* Phù hợp với chiều rộng sidebar */
  }
}

/* Tùy chỉnh cho mobile menu */
@media (max-width: 767px) {
  .sidebar {
    display: none; /* Ẩn sidebar trên mobile */
  }

  .navbar .navbar-brand {
    margin-left: auto;
    margin-right: auto;
  }
}

/* Tùy chỉnh offcanvas trên mobile */
.offcanvas {
  max-width: 250px; /* Giới hạn chiều rộng menu mobile */
}
  </style>
  <script>
    window.onload = function() {
      const hash = window.location.hash.replace('#', '');

      // Sửa lại đoạn này vì bạn đang gọi biến chưa định nghĩa (sanpham, nhanvien)
      switch (hash) {
        case 'sanpham':
          showTable('sanpham');
          break;
        case 'nhapkho':
          showTable('nhapkho');
          break;
        case 'xuatkho':
          showTable('xuatkho');
          break;
        case 'baocao':
          showTable('Báo cáo & Thống kê');
          break;
        case 'nhanvien':
          showTable('nhanvien');
          break;
          // case 'lichsu':
          //   changeContent('Lịch sử giao dịch');
          //   break;
        case 'cauhinh':
          changeContent('Cấu hình hệ thống');
          break;
        default:
          changeContent('Dashboard');
      }

    };
  </script>


  <!-- Main Content -->
  <div class="main-content">
    <h1 class="text-center" id="main-title">Dashboard</h1>
    <div class="alert alert-info text-center mt-4" id="main-description">
      Chọn một mục từ menu để bắt đầu quản lý kho.
    </div>














    <!-- Nhật Ký Đăng Nhập -->
    <div id="dashboard-table" class="mt-4 hidden">
      <h2 class="text-center text-primary">📋 Nhật Ký </h2>

      <div class="dashboard-columns">
        <!-- Biểu Đồ Lãi Suất -->
        <div id="interest-chart">
          <h2 class="text-center text-success">📈 Biểu Đồ Lợi Nhuận</h2>
          <canvas id="interestRateChart"></canvas>
        </div>

        <!-- Bảng Nhật Ký -->
        <div class="log-table" style="max-height: 400px; overflow-y: auto;">
          <h3 class="text-center text-primary">📝 Nhật Ký Đăng Nhập</h3>
          <table class="table table-bordered table-hover table-striped shadow">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Tài Khoản</th>
                <th>Thời Gian Đăng Nhập</th>
                <th>Thời Gian Đăng Xuất</th>
                <th>Thời Gian Hoạt Động</th>
                <th>Hành Động</th>
              </tr>
            </thead>
            <tbody id="log-table-body">
              <!-- Dữ liệu sẽ được thêm vào đây qua AJAX -->
            </tbody>
          </table>
        </div>
      </div>
    </div>


    <button id="btnNhatKy" class="btn btn-info mt-3 shadow-sm" style="float: left; margin-right: 2%;">
      <i class="bi bi-clock-history"></i> Hiển thị Nhật Ký Đăng Nhập
    </button>

    <!-- Biểu đồ Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
      // function fetchInterestData() {
      //   fetch('index.php?task=getInterestRates')
      //     .then(response => response.json())
      //     .then(data => {
      //       if (!data || data.length === 0 || data.status === 'error') {
      //         alert(data.message || 'Không có dữ liệu lãi suất để hiển thị.');
      //         return;
      //       }

      //       const labels = data.map(item => item.date);
      //       const interestRates = data.map(item => item.interest_rate);

      //       const ctx = document.getElementById('interestRateChart').getContext('2d');
      //       new Chart(ctx, {
      //         type: 'line',
      //         data: {
      //           labels: labels,
      //           datasets: [{
      //             label: 'Lãi Suất (%)',
      //             data: interestRates,
      //             borderColor: 'rgba(75, 192, 192, 1)',
      //             backgroundColor: 'rgba(75, 192, 192, 0.2)',
      //             borderWidth: 2,
      //             tension: 0.4
      //           }]
      //         },
      //         options: {
      //           responsive: true,
      //           plugins: {
      //             legend: { position: 'top' },
      //             tooltip: {
      //               callbacks: {
      //                 label: function(context) {
      //                   return context.raw + '%';
      //                 }
      //               }
      //             }
      //           },
      //           scales: {
      //             x: { title: { display: true, text: 'Ngày' } },
      //             y: { title: { display: true, text: 'Lãi Suất (%)' }, beginAtZero: true }
      //           }
      //         }
      //       });

      //       document.getElementById('interest-chart').classList.remove('hidden');
      //     })
      //     .catch(error => {
      //       console.error('Lỗi khi tải dữ liệu lãi suất:', error);
      //       alert('Có lỗi xảy ra khi tải dữ liệu lãi suất.');
      //     });
      // }

      function fetchInterestData() {
        fetch('index.php?task=getInterestRates')
          .then(response => response.json())
          .then(data => {
            console.log('Dữ liệu nhận được:', data); // In ra dữ liệu trả về

            // Loại bỏ các mục có ngày không hợp lệ
            data = data.filter(item => item.date !== '0000-00-00 00:00:00');

            // Kiểm tra dữ liệu sau khi lọc
            if (!data || data.length === 0 || data.status === 'error') {
              alert(data.message || 'Không có dữ liệu lãi suất để hiển thị.');
              return;
            }

            // Chuyển interest_rate thành kiểu số
            const labels = data.map(item => item.date);
            const interestRates = data.map(item => parseFloat(item.interest_rate));

            // Vẽ biểu đồ
            const ctx = document.getElementById('interestRateChart').getContext('2d');
            new Chart(ctx, {
              type: 'line',
              data: {
                labels: labels,
                datasets: [{
                  label: 'Lãi Suất (%)',
                  data: interestRates,
                  borderColor: 'rgba(75, 192, 192, 1)',
                  backgroundColor: 'rgba(75, 192, 192, 0.2)',
                  borderWidth: 2,
                  tension: 0.4
                }]
              },
              options: {
                responsive: true,
                plugins: {
                  legend: {
                    position: 'top'
                  },
                  tooltip: {
                    callbacks: {
                      label: function(context) {
                        return context.raw + '%';
                      }
                    }
                  }
                },
                scales: {
                  x: {
                    title: {
                      display: true,
                      text: 'Ngày'
                    }
                  },
                  y: {
                    title: {
                      display: true,
                      text: 'Lãi Suất (%)'
                    },
                    beginAtZero: true
                  }
                }
              }
            });

            document.getElementById('interest-chart').classList.remove('hidden');
          })
          .catch(error => {
            console.error('Lỗi khi tải dữ liệu lãi suất:', error);
            // alert('Có lỗi xảy ra khi tải dữ liệu lãi suất.');
          });
      }

      // Gọi khi trang vừa load xong
      window.addEventListener('DOMContentLoaded', fetchInterestData);

      function fetchNhatKy() {
        fetch('index.php?task=layTatCaNhatKy')
          .then(response => response.json())
          .then(data => {
            const tableBody = document.getElementById('log-table-body');
            tableBody.innerHTML = '';

            if (!data || data.length === 0) {
              tableBody.innerHTML = '<tr><td colspan="6" class="text-center text-danger">Không có dữ liệu</td></tr>';
              return;
            }

            data.forEach(row => {
              const tr = document.createElement('tr');
              tr.innerHTML = `
            <td>${row.id}</td>
            <td>${row.ten_taikhoan}</td>
            <td>${row.thoigian_dangnhap}</td>
            <td>${row.thoigian_dangxuat || '<span class="text-success">Đang hoạt động</span>'}</td>
            <td>${row.thoigian_hoatdong || '<span class="text-success">Đang hoạt động</span>'}</td>
            <td>
              <button class="btn btn-danger btn-sm" onclick="deleteLog(${row.id})" title="Xóa">
                <i class="bi bi-trash-fill"></i>
              </button>
            </td>
          `;
              tableBody.appendChild(tr);
            });

            document.getElementById('dashboard-table').classList.remove('hidden');
          })
          .catch(error => {
            console.error('Lỗi khi fetch dữ liệu nhật ký:', error);
          });
      }

      function deleteLog(id) {
        if (confirm('Bạn có chắc chắn muốn xóa nhật ký này không?')) {
          fetch(`index.php?task=xoaLichSu&id=${id}`, {
              method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
              if (data.status === 'success') {
                alert('Xóa nhật ký thành công!');
                fetchNhatKy();
              } else {
                alert('Xóa nhật ký thất bại!');
              }
            })
            .catch(error => {
              console.error('Lỗi khi xóa nhật ký:', error);
            });
        }
      }

      document.getElementById('btnNhatKy').addEventListener('click', function(event) {
        event.preventDefault();
        fetchInterestData();
        fetchNhatKy();
      });
    </script>

    <style>
      #dashboard-table {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
        max-height: 100%;
        overflow-y: auto;
      }

      #dashboard-table:hover {
        transform: translateY(-5px);
      }

      .dashboard-columns {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-top: 20px;
      }

      /* Cột biểu đồ */
      #interest-chart {
        flex: 1;
        min-width: 300px;
        max-width: 50%;
      }

      #interestRateChart {
        width: 100%;
        height: 300px;
      }

      /* Cột bảng nhật ký */
      .log-table {
        flex: 1;
        min-width: 300px;
        max-width: 50%;
        overflow-x: auto;
      }

      table {
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
      }

      table th,
      table td {
        vertical-align: middle;
        text-align: center;
        transition: background-color 0.2s ease;
      }

      table tbody tr:hover {
        background-color: #f0f0f0;
        cursor: pointer;
      }

      h2 {
        font-weight: bold;
        color: #2c3e50;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
      }

      #btnNhatKy {
        font-size: 16px;
        font-weight: bold;
        padding: 10px 20px;
        border-radius: 8px;
        transition: background-color 0.3s ease, transform 0.2s ease;
      }

      #btnNhatKy:hover {
        background-color: #17a2b8;
        color: #fff;
        transform: scale(1.05);
      }
    </style>
















    <!-- Table: Quản lý nhân viên -->
    <div id="employee-table" class="mt-4 <?php echo (isset($danhsach) && count($danhsach) > 0) ? '' : 'hidden'; ?>">

      <?php
      $danhsach = $_SESSION['danhsach'] ?? [];
      ?>
      <h4 class="mt-5">Tài khoản đã duyệt</h4>
     <table class="table table-striped table-bordered">
  <thead class="table-success">
    <tr>
      <th>Mã</th>
      <th>Tài Khoản</th>
      <th>Địa Chỉ</th>
      <th>Giới Tính</th>
      <th>Chức Vụ</th>
      <th>Hành Động</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $danhsach = $_SESSION['danhsach'] ?? [];
    if ($danhsach && mysqli_num_rows($danhsach) > 0):
      mysqli_data_seek($danhsach, 0);
      while ($row = mysqli_fetch_assoc($danhsach)):
        if ($row['duyet'] == 1):
    ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['taikhoan1'] ?></td>
        <td><?= $row['diachi'] ?></td>
        <td><?= $row['gioitinh'] ?></td>
        <td><?= $row['cap'] ?></td>
        <td>
          <button class="btn btn-warning btn-sm" onclick="editEmployee(<?= $row['id'] ?>)">Sửa</button>
          <button class="btn btn-danger btn-sm" onclick="deleteEmployee(<?= $row['id'] ?>)">Xóa</button>
        </td>
      </tr>
    <?php endif; endwhile; else: ?>
      <tr><td colspan="6" class="text-center text-danger">Không có tài khoản đã duyệt</td></tr>
    <?php endif; ?>
  </tbody>
</table>
      <!-- CHƯA DUYET -->
      <h4 class="mt-5">Tài khoản chưa duyệt</h4>
      <table class="table table-striped table-bordered">
        <thead class="table-warning">
          <tr>
            <th>Mã</th>
            <th>Tài Khoản</th>
            <th>Địa Chỉ</th>
            <th>Giới Tính</th>
            <th>Chức Vụ</th>
            <th>Duyệt</th>
            <th>Hành Động</th>
          </tr>
        </thead>
        <tbody>
          <?php
          mysqli_data_seek($danhsach, 0);
          while ($row = mysqli_fetch_assoc($danhsach)):
            if ($row['duyet'] == 0):
          ?>
              <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['taikhoan1'] ?></td>
                <td><?= $row['diachi'] ?></td>
                <td><?= $row['gioitinh'] ?></td>
                <td><?= $row['cap'] ?></td>
                <td>
                  <form method="post" action="index.php?task=duyettaikhoan">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit" name="duyet" class="btn btn-success btn-sm">Duyệt</button>
                  </form>
                </td>
                <td>
                  <button class="btn btn-warning btn-sm" onclick="editEmployee(<?= $row['id'] ?>)">Sửa</button>
                  <button class="btn btn-danger btn-sm" onclick="deleteEmployee(<?= $row['id'] ?>)">Xóa</button>
                </td>
              </tr>
          <?php endif;
          endwhile; ?>
        </tbody>
      </table>

      <!-- Nút thêm nhân viên -->
      <button class="btn btn-primary mt-4" id="add-employee-btn" onclick="toggleAddEmployeeForm()">
        <i class="bi bi-plus-circle"></i> Thêm nhân viên
      </button>

      <!-- Form: Thêm nhân viên -->
      <div id="add-employee-form" class="mt-4 hidden" style="position: fixed; top: 45%; left: 44%; transform: translate(-50%, -50%); z-index: 1050; background: white; padding: 30px; border-radius: 10px; border: 1px solid #ccc; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); width: 400px;">
        <?php include 'formthemtaikhoan.php'; ?>
        <button class="btn btn-secondary mt-3 w-100" onclick="toggleAddEmployeeForm()">Đóng</button>
      </div>

      <script>
        function toggleAddEmployeeForm() {
          const form = document.getElementById('add-employee-form');
          form.classList.toggle('hidden');
        }
      </script>

      <script>
        function editEmployee(id) {
          window.location.href = 'index.php?task=suataikhoan&id=' + id;
        }

        function deleteEmployee(id) {
          if (confirm('Bạn có chắc chắn muốn xóa người dùng này không?')) {
            window.location.href = 'index.php?task=xoataikhoan&id=' + id;
          }
        }
      </script>
    </div>



    <div id="product-table" class="mt-4 hidden">
      <?php
      $danhsach1 = $_SESSION['danhsach1'] ?? [];


      ?>
      <table class="table table-striped table-bordered">
        <thead class="table-dark">
          <tr>
            <th>Mã SP</th>
            <th>Tên SP</th>
            <th>Đơn vị tính</th>
            <th>Số lượng tồn</th>
            <th>Giá nhập</th>
            <th>Giá xuất</th>
            <th>Mô tả</th>
            <th>Hình ảnh</th>
            <th>Ngày tạo </th>
            <th>Ngày update</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($danhsach1 instanceof mysqli_result && mysqli_num_rows($danhsach1) > 0): ?>


            <?php while ($row = mysqli_fetch_assoc($danhsach1)) : ?>
              <tr>
                <td><?= $row['masp'] ?></td>
                <td><?= $row['tensp'] ?></td>
                <td><?= $row['donvitinh'] ?></td>
                <td><?= $row['soluongton'] ?></td>
                <td><?= $row['gianhap'] ?></td>
                <td><?= $row['giaxuat'] ?></td>
                <td><?= $row['mota'] ?></td>
                <td>
                  <?php if (!empty($row['hinhanh'])): ?>
                    <img src="<?= $row['hinhanh'] ?>" alt="Hình ảnh" style="width: 60px; height: auto;">
                  <?php else: ?>
                    Không có ảnh
                  <?php endif; ?>
                </td>
                <td><?= $row['ngaytao'] ?></td>
                <td><?= $row['ngaycapnhat'] ?></td>
                <td>

                  <button class="btn btn-warning btn-sm" onclick="editProduct('<?= $row['masp'] ?>')" title="Sửa">
                    <i class="bi bi-wrench"></i>
                  </button>

                  <div id="formContainer">
                    <form id="formEditProduct">
                      <div class="form-group">
                        <label for="masp">Mã sản phẩm</label>
                        <input type="text" id="masp" name="masp" placeholder="Mã sản phẩm" readonly class="form-control mb-2">
                      </div>

                      <div class="form-group">
                        <label for="tensp">Tên sản phẩm</label>
                        <input type="text" id="tensp" name="tensp" placeholder="Tên sản phẩm" class="form-control mb-2">
                      </div>

                      <div class="form-group">
                        <label for="donvitinh">Đơn vị tính</label>
                        <input type="text" id="donvitinh" name="donvitinh" placeholder="Đơn vị tính" class="form-control mb-2">
                      </div>

                      <div class="form-group">
                        <label for="soluongton">Số lượng tồn</label>
                        <input type="number" id="soluongton" name="soluongton" placeholder="Số lượng tồn" class="form-control mb-2">
                      </div>

                      <div class="form-group">
                        <label for="gianhap">Giá nhập</label>
                        <input type="text" id="gianhap" name="gianhap" placeholder="Giá nhập" class="form-control mb-2">
                      </div>

                      <div class="form-group">
                        <label for="giaxuat">Giá xuất</label>
                        <input type="text" id="giaxuat" name="giaxuat" placeholder="Giá xuất" class="form-control mb-2">
                      </div>

                      <div class="form-group">
                        <label for="mota">Mô tả</label>
                        <textarea id="mota" name="mota" placeholder="Mô tả" class="form-control mb-2"></textarea>
                      </div>

                      <div class="col-md-12">
                        <label for="hinhanh" class="form-label">Hình Ảnh</label>
                        <input type="file" class="form-control" id="hinhanh" name="hinhanh" accept="image/*" onchange="previewImage1(event)" required>
                      </div>



                      <div class="col-md-6">
                        <label for="ngaytao" class="form-label">Ngày Tạo</label>
                        <input type="datetime-local" class="form-control" id="ngaytao" name="ngaytao" required>
                      </div>

                      <div class="col-md-6">
                        <label for="ngaycapnhat" class="form-label">Ngày Cập Nhật</label>
                        <input type="text" class="form-control" id="ngaycapnhat" name="ngaycapnhat" value="<?= date('d/m/Y') ?>" required>
                      </div>

                      <button type="button" onclick="capNhatSanPham()" class="btn btn-success">Cập nhật</button>
                      <button type="button" onclick="closeEditForm()" class="btn btn-secondary">Đóng</button>
                    </form>
                  </div>






                  <button class="btn btn-danger btn-sm" onclick="deleteProduct('<?= $row['masp'] ?>')" title="Xóa">
                    <i class="bi bi-trash-fill"></i>
                  </button>

                  <script>
                    function deleteProduct(masp) {
                      if (confirm("Bạn có chắc muốn xoá sản phẩm này không?")) {
                        window.location.href = "index.php?task=xoasanpham&masp=" + encodeURIComponent(masp);
                      }
                    }
                  </script>

                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="9" class="alert alert-danger text-center">Không có sản phẩm nào!</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>

      <!-- Nút thêm sản phẩm -->
      <button class="btn btn-primary mt-4" id="add-product-btn" onclick="toggleAddProductForm()">
        <i class="bi bi-plus-circle"></i> Thêm sản phẩm
      </button>
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
      <style>
        .upload-area {
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


      <!-- Form: Thêm sản phẩm -->
      <div id="add-product-form" class="mt-4 hidden" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050; background: white; padding: 20px; border-radius: 10px; border: 1px solid #ccc; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); width: 400px;">
        <h3 class="text-center mb-4">Thêm Sản Phẩm</h3>
        <form action="index.php?task=themsanpham" method="POST" enctype="multipart/form-data">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="masp" class="form-label">Mã Sản Phẩm</label>
              <input type="text" class="form-control" id="masp" name="masp" required>
            </div>
            <div class="col-md-6">
              <label for="tensp" class="form-label">Tên Sản Phẩm</label>
              <input type="text" class="form-control" id="tensp" name="tensp" required>
            </div>
            <div class="col-md-6">
              <label for="donvitinh" class="form-label">Đơn Vị Tính</label>
              <input type="text" class="form-control" id="donvitinh" name="donvitinh" required>
            </div>
            <div class="col-md-6">
              <label for="soluongton" class="form-label">Số Lượng Tồn</label>
              <input type="number" class="form-control" id="soluongton" name="soluongton" required>
            </div>
            <div class="col-md-6">
              <label for="gianhap" class="form-label">Giá Nhập</label>
              <input type="number" step="0.01" class="form-control" id="gianhap" name="gianhap" required>
            </div>
            <div class="col-md-6">
              <label for="giaxuat" class="form-label">Giá Xuất</label>
              <input type="number" step="0.01" class="form-control" id="giaxuat" name="giaxuat" required>
            </div>
            <div class="col-md-12">
              <label for="mota" class="form-label">Mô Tả</label>
              <textarea class="form-control" id="mota" name="mota" rows="2" required></textarea>
            </div>
            <div class="col-md-12">
              <label for="hinhanh" class="form-label">Hình Ảnh</label>
              <input type="file" class="form-control" id="hinhanh" name="hinhanh" accept="image/*" onchange="previewImage(event)" required>

              <!-- Ảnh xem trước -->
              <?php if (!empty($hinhanh)) : ?>
                <img id="preview" src="<?= $hinhanh ?>" alt="Hình ảnh xem trước" style="display: block; margin-top: 10px; max-width: 100%; height: auto; border: 1px solid #ccc; padding: 5px;">
              <?php else : ?>
                <img id="preview" src="#" alt="Hình ảnh xem trước" style="display: none; margin-top: 10px; max-width: 100%; height: auto; border: 1px solid #ccc; padding: 5px;">
              <?php endif; ?>
            </div>

            <!-- Script hiển thị ảnh chọn trước khi upload -->
            <script>
              function previewImage(event) {
                const preview = document.getElementById('preview');
                const file = event.target.files[0];
                if (file) {
                  const reader = new FileReader();
                  reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                  };
                  reader.readAsDataURL(file);
                } else {
                  preview.src = '#';
                  preview.style.display = 'none';
                }
              }
            </script>

            <div class="col-md-6">
              <label for="ngaytao" class="form-label">Ngày Tạo</label>
              <input type="datetime-local" class="form-control" id="ngaytao" name="ngaytao" required>
            </div>
            <div class="col-md-6">
              <label for="ngaycapnhat" class="form-label">Ngày Cập Nhật</label>
              <input type="text" class="form-control" id="ngaycapnhat" name="ngaycapnhat" value="<?= date('d/m/Y') ?>" required>
            </div>
          </div>
          <button type="submit" class="btn btn-success w-100 mt-3" name="themsanpham">Thêm Sản Phẩm</button>
        </form>
        <button class="btn btn-secondary mt-3 w-100" onclick="toggleAddProductForm()">Đóng</button>
      </div>



      <!-- <div class="alert alert-warning text-center">Chức năng Quản lý sản phẩm đang phát triển.</div> -->
      <button class="btn-close position-absolute top-0 end-0 m-2" onclick="toggleAddEmployeeForm()"></button>










    </div>

    <script>
      function toggleAddProductForm() {
        const form = document.getElementById('add-product-form');
        form.classList.toggle('hidden');
      }

      function closeEditForm() {
        document.getElementById("formContainer").style.display = "none";
      }

      function editProduct(masp) {
        // Hiển thị form chỉnh sửa
        document.getElementById("formContainer").style.display = "block"; // Hiển thị form

        // Gọi API hoặc lấy dữ liệu sản phẩm (nếu cần) để điền vào form
        fetch('index.php?task=editProduct&masp=' + encodeURIComponent(masp))
          .then(response => response.json())
          .then(data => {
            if (data.status === 'success') {
              const product = data.product;
              document.getElementById('masp').value = product.masp;
              document.getElementById('tensp').value = product.tensp;
              document.getElementById('donvitinh').value = product.donvitinh;
              document.getElementById('soluongton').value = product.soluongton;
              document.getElementById('gianhap').value = product.gianhap;
              document.getElementById('giaxuat').value = product.giaxuat;
              document.getElementById('mota').value = product.mota;

              document.getElementById('ngaytao').value = product.ngaytao;
              document.getElementById('ngaycapnhat').value = product.ngaycapnhat;
            } else {
              alert('Không tìm thấy thông tin sản phẩm!');
            }
          })
          .catch(error => {
            console.error('Lỗi fetch:', error);
            alert('Có lỗi xảy ra khi lấy thông tin sản phẩm!');
          });
      }

      function capNhatSanPham() {
        const masp = document.getElementById('masp').value;
        const tensp = document.getElementById('tensp').value;
        const donvitinh = document.getElementById('donvitinh').value;
        const soluongton = document.getElementById('soluongton').value;
        const gianhap = document.getElementById('gianhap').value;
        const giaxuat = document.getElementById('giaxuat').value;
        const mota = document.getElementById('mota').value;
        const ngaytao = document.getElementById('ngaytao').value;
        const ngaycapnhat = document.getElementById('ngaycapnhat').value;
        const hinhanh = document.getElementById('hinhanh').files[0]; // Lấy ảnh đã chọn từ input

        // Đảm bảo ảnh mới đã được chọn
        if (!hinhanh) {
          alert("Vui lòng chọn ảnh mới!");
          return;
        }

        // Tạo FormData để gửi file ảnh và các dữ liệu khác
        const formData = new FormData();
        formData.append('masp', masp);
        formData.append('tensp', tensp);
        formData.append('donvitinh', donvitinh);
        formData.append('soluongton', soluongton);
        formData.append('gianhap', gianhap);
        formData.append('giaxuat', giaxuat);
        formData.append('mota', mota);
        formData.append('hinhanh', hinhanh); // Thêm ảnh vào FormData
        formData.append('ngaytao', ngaytao);
        formData.append('ngaycapnhat', ngaycapnhat);

        // Gửi dữ liệu qua AJAX
        fetch('index.php?task=capNhatSanPham', {
            method: 'POST',
            body: formData,
          })
          .then(response => response.json())
          .then(data => {
            if (data.status === 'success') {
              alert('Cập nhật sản phẩm thành công!');
              location.reload();
              // Đóng form hoặc làm gì đó sau khi cập nhật thành công
              closeEditForm();
            } else {
              alert('Cập nhật sản phẩm thất bại!');
            }
          })
          .catch(error => {
            console.error('Lỗi:', error);
            alert('Có lỗi xảy ra khi cập nhật sản phẩm!');
          });
      }


      function toggleForm() {
        const formContainer = document.getElementById("formContainer");
        if (formContainer.style.display === "none") {
          formContainer.style.display = "block"; // Hiển thị form
        } else {
          formContainer.style.display = "none"; // Ẩn form
        }
      }
    </script>
    <style>
      #formContainer {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90%;
        max-width: 600px;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 1000;
      }

      #formEditProduct {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
      }

      #formEditProduct input,
      #formEditProduct textarea,
      #formEditProduct button {
        font-size: 14px;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
      }

      #formEditProduct input[type="text"],
      #formEditProduct input[type="number"],
      #formEditProduct input[type="date"],
      #formEditProduct textarea {
        width: 100%;
      }

      #formEditProduct textarea {
        grid-column: span 2;
      }

      #formEditProduct button {
        width: auto;
        max-width: 100px;
        margin: 8px 0;
      }

      #formEditProduct button:hover {
        cursor: pointer;
        opacity: 0.9;
      }

      #formEditProduct button.btn-secondary {
        background-color: #6c757d;
        color: #fff;
      }

      #formEditProduct button.btn-success {
        background-color: #28a745;
        color: #fff;
      }

      #formEditProduct button:focus {
        outline: none;
      }

      /* Responsive adjustments */
      @media (max-width: 768px) {
        #formContainer {
          width: 95%;
          max-width: 350px;
          padding: 15px;
        }

        #formEditProduct {
          grid-template-columns: 1fr;
        }

        #formEditProduct input,
        #formEditProduct textarea,
        #formEditProduct button {
          font-size: 12px;
          padding: 6px;
        }

        #formEditProduct button {
          max-width: 90px;
        }
      }
    </style>





    <div id="nhapkho-table" class="mt-4 hidden">
      <!-- Bộ lọc phiếu nhập -->
      <div class="mb-3 d-flex flex-wrap align-items-center gap-2">
        <input type="text" class="form-control" id="filter-maphieunhap" placeholder="Mã phiếu nhập" style="max-width: 180px;">
        <input type="date" class="form-control" id="filter-ngaynhap" placeholder="Ngày nhập" style="max-width: 180px;">
        <input type="text" class="form-control" id="filter-nguoinhap" placeholder="Người nhập" style="max-width: 180px;">
        <input type="text" class="form-control" id="filter-nhacungcap" placeholder="Nhà cung cấp" style="max-width: 180px;">
        <button class="btn btn-outline-primary" id="btn-filter-phieunhap"><i class="bi bi-funnel"></i> Lọc</button>
        <button class="btn btn-outline-secondary" id="btn-reset-filter-phieunhap"><i class="bi bi-x-circle"></i> Xóa lọc</button>
      </div>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const filterInputs = [
            document.getElementById('filter-maphieunhap'),
            document.getElementById('filter-ngaynhap'),
            document.getElementById('filter-nguoinhap'),
            document.getElementById('filter-nhacungcap')
          ];
          const btnFilter = document.getElementById('btn-filter-phieunhap');
          const btnReset = document.getElementById('btn-reset-filter-phieunhap');
          const table = document.querySelector('#nhapkho-table table');
          if (!table) return;
          const tbody = table.querySelector('tbody');
          if (!tbody) return;

          function normalize(str) {
            return (str || '').toString().toLowerCase().trim();
          }

          function filterRows() {
            const maphieunhap = normalize(filterInputs[0].value);
            const ngaynhap = filterInputs[1].value;
            const nguoinhap = normalize(filterInputs[2].value);
            const nhacungcap = normalize(filterInputs[3].value);

            Array.from(tbody.querySelectorAll('tr')).forEach(tr => {
              // Bỏ qua dòng thông báo không có phiếu nhập
              if (tr.querySelector('.alert-danger')) return;
              const tds = tr.querySelectorAll('td');
              if (tds.length < 4) return;
              let show = true;
              if (maphieunhap && !normalize(tds[0].textContent).includes(maphieunhap)) show = false;
              if (ngaynhap && !tds[1].textContent.includes(ngaynhap)) show = false;
              if (nguoinhap && !normalize(tds[2].textContent).includes(nguoinhap)) show = false;
              if (nhacungcap && !normalize(tds[3].textContent).includes(nhacungcap)) show = false;
              tr.style.display = show ? '' : 'none';
            });
          }

          btnFilter.addEventListener('click', filterRows);
          filterInputs.forEach(input => input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') filterRows();
          }));

          btnReset.addEventListener('click', function() {
            filterInputs.forEach(input => input.value = '');
            Array.from(tbody.querySelectorAll('tr')).forEach(tr => {
              if (!tr.querySelector('.alert-danger')) tr.style.display = '';
            });
          });
        });
      </script>
      <table class="table table-striped table-bordered">
        <thead class="table-dark">
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
                <td><?= $row['maphieunhap'] ?></td>
                <td><?= $row['ngaynhap'] ?></td>
                <td><?= $row['taikhoan1'] ?></td>
                <td><?= $row['nguonnhap'] ?></td>
                <td>
                  <button class="btn btn-info btn-sm" onclick="xemChiTietPhieuNhap(this, '<?= $row['maphieunhap'] ?>')" title="Xem chi tiết">
                    <i class="bi bi-eye"></i>
                  </button>




                  <button class="btn btn-danger btn-sm" onclick="deletePhieuNhap('<?= $row['maphieunhap'] ?>')" title="Xóa">
                    <i class="bi bi-trash-fill"></i>
                  </button>

                  <script>
                    function deletePhieuNhap(maphieunhap) {
                      if (confirm("Bạn có chắc chắn muốn xóa phiếu nhập này không?")) {
                        fetch('index.php?task=xoaPhieuNhap', {
                            method: 'POST',
                            headers: {
                              'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: 'maphieunhap=' + encodeURIComponent(maphieunhap)
                          })
                          .then(response => {
                            console.log('Trạng thái response:', response.status); // Thêm dòng này
                            return response.json();
                          })
                          .then(data => {
                            console.log('Dữ liệu server trả về:', data); // Thêm dòng này
                            alert(data.message);
                            if (data.status === 'success') {
                              window.location.reload();
                            }
                          })
                          .catch(error => {
                            console.error('Lỗi fetch:', error); // Thêm dòng này
                            alert('Có lỗi xảy ra khi xóa!');
                          });
                      }
                    }
                  </script>














                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="4" class="alert alert-danger text-center">Không có phiếu nhập nào!</td>
            </tr>
          <?php endif; ?>
        </tbody>

      </table>

      <!-- Phân trang cho phiếu nhập -->
      <nav>
        <ul id="phieunhap-pagination" class="pagination justify-content-center mt-3"></ul>
      </nav>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const table = document.querySelector('#nhapkho-table table');
          if (!table) return;
          const tbody = table.querySelector('tbody');
          if (!tbody) return;

          // Lấy tất cả các dòng phiếu nhập (trừ dòng thông báo không có phiếu nhập)
          const rows = Array.from(tbody.querySelectorAll('tr')).filter(tr => !tr.querySelector('.alert-danger'));
          const rowsPerPage = 5;
          let currentPage = 1;

          function showPage(page) {
            rows.forEach((row, idx) => {
              row.style.display = (idx >= (page - 1) * rowsPerPage && idx < page * rowsPerPage) ? '' : 'none';
            });
          }

          function setupPagination() {
            const pageCount = Math.ceil(rows.length / rowsPerPage);
            const pagination = document.getElementById('phieunhap-pagination');
            if (!pagination) return;
            pagination.innerHTML = '';
            if (pageCount <= 1) return;

            for (let i = 1; i <= pageCount; i++) {
              const li = document.createElement('li');
              li.className = `page-item${i === currentPage ? ' active' : ''}`;
              li.innerHTML = `<button class="page-link">${i}</button>`;
              li.addEventListener('click', function() {
                currentPage = i;
                showPage(currentPage);
                setupPagination();
              });
              pagination.appendChild(li);
            }
          }

          showPage(currentPage);
          setupPagination();
        });
      </script>




      <div class="d-flex align-items-center gap-2 mb-3" style="justify-content: flex-start;">
        <a href="index.php?task=danhsach_phieunhap" class="btn btn-primary">
          Tải danh sách phiếu nhập
        </a>
        <!-- Nút thêm phiếu nhập -->
        <button class="btn btn-primary ms-2" id="add-phieunhap-btn" onclick="toggleAddPhieuNhapForm()">
          <i class="bi bi-plus-circle"></i> Thêm phiếu nhập
        </button>
      </div>
      <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script> -->

      <form method="post" enctype="multipart/form-data" action="index.php?task=importExcelPhieuNhap" class="upload-area" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);">
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




      <!-- hiden -->
      <div id="add-phieunhap-form" class="mt-4 " style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050; background: white; padding: 20px; border-radius: 10px; border: 1px solid #ccc; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); width: 600px;">
        <h3 class="text-center mb-4">Thêm Phiếu Nhập</h3>
        <form id="form-add-phieunhap" method="post" action="index.php?task=themPhieuNhap">

          <div class="row">
            <div class="mb-3 col-6">
              <label for="ngaynhap" class="form-label">Ngày Nhập</label>
              <input type="datetime-local" class="form-control" id="ngaynhap" name="ngaynhap"
                value="<?= isset($phieunhap['ngaynhap']) ? date('Y-m-d\TH:i', strtotime($phieunhap['ngaynhap'])) : date('Y-m-d\TH:i') ?>" required>
            </div>
            <div class="mb-3 col-6">
              <label for="id_nguoinhap" class="form-label">Người Nhập</label>
              <input type="text" class="form-control" id="id_nguoinhap" name="id_nguoinhap" value="<?= $_SESSION['taikhoan1'] ?>" readonly>
            </div>
            <div class="mb-3 col-6">
              <label for="nguonnhap" class="form-label">Nguồn Nhập</label>
              <input type="text" class="form-control" id="nguonnhap" name="nguonnhap" value="<?= $phieunhap['nguonnhap'] ?? '' ?>" required>
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
              <input type="number" class="form-control" id="soluongnhap" name="soluongnhap" value="<?= $phieunhap ? $phieunhap['soluongnhap'] : '' ?>" required min="1">
            </div>


          </div>

          <button type="submit" class="btn btn-success w-100 mt-3">Thêm Phiếu Nhập</button>
        </form>
        <button class="btn btn-secondary mt-3 w-100" onclick="toggleAddPhieuNhapForm()">Đóng</button>
      </div>
      <script>
        document.getElementById('form-add-phieunhap').addEventListener('submit', function(event) {
          event.preventDefault(); // Chặn hành động submit mặc định

          var formData = new FormData(this);

          fetch('index.php?task=themPhieuNhap', {
              method: 'POST',
              body: formData
            })
            .then(response => response.json())
            .then(data => {
              if (data.status === 'success') {
                alert(data.message);
                toggleAddPhieuNhapForm(); // Ẩn form thêm
                location.reload(); // Reload lại trang chính
              } else {
                alert("Lỗi: " + data.message);
              }
            })
            .catch(error => {
              console.error('Error:', error);
              alert('Có lỗi xảy ra trong quá trình xử lý!');
            });

        });
      </script>


      <style>
        #add-phieunhap-form {
          background: #fff;
          padding: 30px;
          border-radius: 12px;
          border: 1px solid #ddd;
          box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
          width: 600px;
          max-width: 90%;
          transition: all 0.3s ease;
        }

        #add-phieunhap-form h3 {
          font-weight: bold;
          color: #333;
        }

        #add-phieunhap-form .form-label {
          font-weight: 600;
          color: #555;
        }

        #add-phieunhap-form .form-control {
          border-radius: 8px;
          border: 1px solid #ccc;
        }

        #add-phieunhap-form .btn-success {
          background-color: #28a745;
          border: none;
          font-weight: bold;
        }

        #add-phieunhap-form .btn-success:hover {
          background-color: #218838;
        }

        #add-phieunhap-form .btn-secondary {
          background-color: #6c757d;
          border: none;
        }

        #add-phieunhap-form .btn-secondary:hover {
          background-color: #5a6268;
        }
      </style>

      <script>
        function toggleAddPhieuNhapForm() {
          const form = document.getElementById('add-phieunhap-form');
          if (form.style.display === "none" || form.style.display === "") {
            form.style.display = "block";
          } else {
            form.style.display = "none";
          }
        }
      </script>

      <style>
        /* Lớp hidden để ẩn form */
        .hidden {
          display: none !important;
        }
      </style>


      <script>
        function xemChiTietPhieuNhap(button, maphieunhap) {
          const currentRow = button.closest('tr');
          const nextRow = currentRow.nextElementSibling;

          // Nếu dòng chi tiết đang hiển thị → xóa đi (ẩn)
          if (nextRow && nextRow.classList.contains('chi-tiet-row')) {
            nextRow.remove();
            return;
          }

          // Xóa các dòng chi tiết khác (nếu có)
          document.querySelectorAll('.chi-tiet-row').forEach(e => e.remove());

          fetch(`http://localhost/quanlykho/index.php?action=xemchitiet&maphieunhap=${maphieunhap}`)



            .then(response => {
              if (!response.ok) throw new Error("Lỗi tải dữ liệu");
              return response.json();
            })
            .then(data => {
              const newRow = document.createElement('tr');
              newRow.classList.add('chi-tiet-row');

              let html = `<td colspan="4"><strong>Chi tiết phiếu nhập:</strong><br>`;
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
              <td>${row.tensp}
              </td>
            
              
              <td>${row.soluongnhap}</td>
              <td>${row.gianhap}</td>
            </tr>`;
                });
                html += `</tbody></table>`;
              }
              html += `</td>`;
              newRow.innerHTML = html;

              // Thêm dòng chi tiết ngay sau dòng hiện tại
              currentRow.parentNode.insertBefore(newRow, currentRow.nextSibling);
            })
            .catch(error => {
              console.error('Lỗi khi tải chi tiết phiếu nhập:', error);
              alert('Không thể tải chi tiết!');
            });
        }
      </script>





      <script>
        fetch(`index.php?action=chitiet_phieunhap&maphieunhap=${maphieunhap}`)
          .then(response => response.json())
          .then(data => {
            console.log(data); // Kiểm tra dữ liệu trả về
            let html = '';
            data.forEach(row => {
              html += `<tr>
                <td>${row.masp}</td>
                <td>${row.tensp}</td>
                <td>${row.soluongnhap}</td>
                <td>${row.gianhap}</td>
              </tr>`;
            });
            document.getElementById('chiTietBody').innerHTML = html;
            const modal = new bootstrap.Modal(document.getElementById('chiTietModal'));
            modal.show();
          })
      </script>
      <script>
        document.querySelectorAll('.chiTietBody').forEach((bodyElement) => {
          bodyElement.innerHTML = html;
        });
      </script>


    </div>








    <!-- Đay là xuat kho cua t --------
     -->

    <div id="xuatkho-table" class="mt-4 hidden">
      <!-- Nút chọn nhân viên -->
      <button class="btn btn-primary mt-4" id="select-employee-btn" onclick="toggleSelectEmployeeForm()">
        <i class="bi bi-person-check"></i> Chọn nhân viên
      </button>






      <!-- Form: Chọn nhân viên và hàng hóa -->
      <div id="select-employee-form" class="mt-4 hidden" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050; background: white; padding: 20px; border-radius: 10px; border: 1px solid #ccc; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); width: 400px;">
        <h3 class="text-center mb-4">Chọn Nhân Viên và Hàng Hóa</h3>
        <form method="post" action="index.php?task=xuatkho">



          <div class="mb-3">
            <label for="nhanvien" class="form-label">Nhân Viên</label>
            <select class="form-control" id="nhanvien" name="nhanvien" required>
              <option value="">-- Chọn nhân viên --</option>
              <?php
              $nhanvienList = $model->tatcanguoidung1(); // Giả sử $model là đối tượng của lớp chứa phương thức

              if (!empty($nhanvienList)) {
                foreach ($nhanvienList as $nhanvien) {
                  // Hiển thị danh sách nhân viên cấp 2
                  echo '<option value="' . htmlspecialchars($nhanvien['id']) . '">' . htmlspecialchars($nhanvien['taikhoan1']) . '</option>';
                }
              } else {
                echo '<option value="">Không có nhân viên nào</option>';
              }
              ?>
            </select>
          </div>
          <div class="mb-3">
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
          <div class="mb-3">
            <label for="soluong" class="form-label">Số Lượng</label>
            <input type="number" class="form-control" id="soluong" name="soluong" required min="1">
          </div>
          <div class="mb-3">
            <label for="diachi" class="form-label">Gửi Đến Địa Chỉ</label>
            <input type="text" class="form-control" id="diachi" name="diachi" required>
          </div>
          <!-- <button type="submit" class="btn btn-success w-100 mt-3" name="xuatkho" onclick="event.preventDefault(); this.closest('form').submit(); window.location.reload();">Yêu Cầu Xuất</button> -->
          <button type="submit" class="btn btn-success w-100 mt-3" name="xuatkho">Yêu Cầu Xuất</button>
        </form>
        <button class="btn btn-secondary mt-3 w-100" onclick="toggleSelectEmployeeForm()">Đóng</button>
      </div>




      <h3 class="mt-5 mb-3 text-center">Danh Sách Đơn Xuất</h3>
      <!-- Bộ lọc đơn xuất -->
      <div class="mb-3 d-flex flex-wrap align-items-center gap-2">
        <input type="text" class="form-control" id="filter-id" placeholder="ID Đơn" style="max-width: 120px;">
        <input type="text" class="form-control" id="filter-nhanvien" placeholder="Nhân Viên" style="max-width: 150px;">
        <input type="date" class="form-control" id="filter-ngaylap" placeholder="Ngày Lập" style="max-width: 150px;">
        <input type="text" class="form-control" id="filter-diachi" placeholder="Địa Chỉ" style="max-width: 150px;">
        <input type="text" class="form-control" id="filter-trangthai" placeholder="Trạng Thái" style="max-width: 120px;">
        <input type="date" class="form-control" id="filter-ngayxuat" placeholder="Ngày Xuất" style="max-width: 150px;">
        <input type="text" class="form-control" id="filter-masp" placeholder="Mã SP" style="max-width: 120px;">
        <button class="btn btn-outline-primary" id="btn-filter-donxuat"><i class="bi bi-funnel"></i> Lọc</button>
        <button class="btn btn-outline-secondary" id="btn-reset-filter-donxuat"><i class="bi bi-x-circle"></i> Xóa lọc</button>
      </div>
      <script>
        let donxuatData = []; // Lưu dữ liệu toàn bộ đơn xuất
        let filteredData = []; // Dữ liệu sau khi lọc
        let rowsPerPage = 4;
        let currentPage = 1;

        function normalize(str) {
          return (str || '').toString().toLowerCase().trim();
        }

        function renderDonXuatTable(data, page = 1) {
          const tbody = document.getElementById("donhang-body");
          const pagination = document.getElementById("pagination");
          tbody.innerHTML = "";
          const start = (page - 1) * rowsPerPage;
          const end = start + rowsPerPage;
          const pageData = data.slice(start, end);

          if (pageData.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center">Chưa có đơn nào được xuất.</td></tr>';
            pagination.innerHTML = "";
            return;
          }

          pageData.forEach(row => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
      <td>${row.id}</td>
      <td>${row.ten_nhanvien}</td>
      <td>${row.ngaylap}</td>
      <td>${row.diachi}</td>
      <td>${row.trangthai}</td>
      <td>${row.ngayxuat}</td>
      <td>${row.masp}</td>
      <td>${row.soluong}</td>
    `;
            tbody.appendChild(tr);
          });

          // Phân trang
          const pageCount = Math.ceil(data.length / rowsPerPage);
          pagination.innerHTML = "";
          for (let i = 1; i <= pageCount; i++) {
            const li = document.createElement("li");
            li.className = `page-item ${i === page ? 'active' : ''}`;
            li.innerHTML = `<button class="page-link">${i}</button>`;
            li.addEventListener("click", () => {
              currentPage = i;
              renderDonXuatTable(filteredData, currentPage);
            });
            pagination.appendChild(li);
          }
        }

        function filterDonXuatRows() {
          const id = normalize(document.getElementById('filter-id').value);
          const nhanvien = normalize(document.getElementById('filter-nhanvien').value);
          const ngaylap = document.getElementById('filter-ngaylap').value;
          const diachi = normalize(document.getElementById('filter-diachi').value);
          const trangthai = normalize(document.getElementById('filter-trangthai').value);
          const ngayxuat = document.getElementById('filter-ngayxuat').value;
          const masp = normalize(document.getElementById('filter-masp').value);

          filteredData = donxuatData.filter(row => {
            let show = true;
            if (id && !normalize(row.id).includes(id)) show = false;
            if (nhanvien && !normalize(row.ten_nhanvien).includes(nhanvien)) show = false;
            if (ngaylap && !(row.ngaylap && row.ngaylap.includes(ngaylap))) show = false;
            if (diachi && !normalize(row.diachi).includes(diachi)) show = false;
            if (trangthai && !normalize(row.trangthai).includes(trangthai)) show = false;
            if (ngayxuat && !(row.ngayxuat && row.ngayxuat.includes(ngayxuat))) show = false;
            if (masp && !normalize(row.masp).includes(masp)) show = false;
            return show;
          });
          currentPage = 1;
          renderDonXuatTable(filteredData, currentPage);
        }

        function resetDonXuatFilter() {
          document.getElementById('filter-id').value = '';
          document.getElementById('filter-nhanvien').value = '';
          document.getElementById('filter-ngaylap').value = '';
          document.getElementById('filter-diachi').value = '';
          document.getElementById('filter-trangthai').value = '';
          document.getElementById('filter-ngayxuat').value = '';
          document.getElementById('filter-masp').value = '';
          filteredData = donxuatData.slice();
          currentPage = 1;
          renderDonXuatTable(filteredData, currentPage);
        }

        document.addEventListener('DOMContentLoaded', function() {
          fetch("index.php?task=getDonHangDaXuat")
            .then(res => res.json())
            .then(data => {
              donxuatData = data;
              filteredData = data.slice();
              renderDonXuatTable(filteredData, currentPage);

              document.getElementById('btn-filter-donxuat').addEventListener('click', filterDonXuatRows);
              [
                'filter-id', 'filter-nhanvien', 'filter-ngaylap', 'filter-diachi', 'filter-trangthai', 'filter-ngayxuat', 'filter-masp'
              ].forEach(id => {
                document.getElementById(id).addEventListener('keydown', function(e) {
                  if (e.key === 'Enter') filterDonXuatRows();
                });
              });
              document.getElementById('btn-reset-filter-donxuat').addEventListener('click', resetDonXuatFilter);
            })
            .catch(error => {
              document.getElementById("donhang-body").innerHTML = '<tr><td colspan="8" class="text-center text-danger">Lỗi tải dữ liệu.</td></tr>';
              console.error('Lỗi khi lấy dữ liệu:', error);
            });
        });
      </script>
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead class="table-dark text-center">
            <tr>
              <th>ID Đơn</th>
              <th>Nhân Viên</th>
              <th>Ngày Lập</th>
              <th>Địa Chỉ</th>
              <th>Trạng Thái</th>
              <th>Ngày Xuất</th>
              <th>Mã SP</th>
              <th>Số Lượng</th>
            </tr>
          </thead>
          <tbody id="donhang-body">
            <tr>
              <td colspan="8" class="text-center">Đang tải dữ liệu...</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Phân trang -->
      <nav>
        <ul id="pagination" class="pagination justify-content-center mt-3"></ul>
        <!-- <form method="post" enctype="multipart/form-data" action="index.php?task=importExcelXuatKho" class="upload-area" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);">
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
</form> -->
      </nav>

      <!-- <script>
fetch("index.php?task=getDonHangDaXuat")
    .then(res => res.json())
    .then(data => {
        const tbody = document.getElementById("donhang-body");
        const pagination = document.getElementById("pagination");
        const rowsPerPage = 4;
        let currentPage = 1;

        function displayPage(page) {
            tbody.innerHTML = "";
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const pageData = data.slice(start, end);

            if (pageData.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" class="text-center">Chưa có đơn nào được xuất.</td></tr>';
                return;
            }

            pageData.forEach(row => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${row.id}</td>
                    <td>${row.ten_nhanvien}</td>
                    <td>${row.ngaylap}</td>
                    <td>${row.diachi}</td>
                    <td>${row.trangthai}</td>
                    <td>${row.ngayxuat}</td>
                    <td>${row.masp}</td>
                    <td>${row.soluong}</td>
                `;
                tbody.appendChild(tr);
            });
        }

        function setupPagination() {
            const pageCount = Math.ceil(data.length / rowsPerPage);
            pagination.innerHTML = "";
            for (let i = 1; i <= pageCount; i++) {
                const li = document.createElement("li");
                li.className = `page-item ${i === currentPage ? 'active' : ''}`;
                li.innerHTML = `<button class="page-link">${i}</button>`;
                li.addEventListener("click", () => {
                    currentPage = i;
                    displayPage(currentPage);
                    setupPagination();
                });
                pagination.appendChild(li);
            }
        }

        displayPage(currentPage);
        setupPagination();
    })
    .catch(error => {
        document.getElementById("donhang-body").innerHTML = '<tr><td colspan="8" class="text-center text-danger">Lỗi tải dữ liệu.</td></tr>';
        console.error('Lỗi khi lấy dữ liệu:', error);
    });
</script> -->








      <script>
        function toggleSelectEmployeeForm() {
          const form = document.getElementById('select-employee-form');
          form.classList.toggle('hidden');
        }
      </script>
    </div>

























    <!-- Báo cáo & Thống kê dạng biểu đồ -->
    <div id="baocao-table" class="container mt-5 hidden">
      <div class="row">
        <!-- Biểu đồ tồn kho -->
        <div class="col-md-6 mb-4">
          <div class="report-section">
            <h3 class="text-center mb-4">📦 Biểu Đồ Tồn Kho</h3>
            <canvas id="tonkhoChart" height="320"></canvas>
          </div>
        </div>
        <!-- Biểu đồ doanh thu -->
        <div class="col-md-6 mb-4">
          <div class="report-section">
            <h3 class="text-center mb-4">💰 Biểu Đồ Doanh Thu</h3>
            <canvas id="doanhthuChart" height="320"></canvas>
          </div>
        </div>
      </div>
      <div class="row">
        <!-- Biểu đồ tròn tỷ lệ tồn kho -->
        <div class="col-md-6 mb-4">
          <div class="report-section">
            <h3 class="text-center mb-4">📊 Tỷ Lệ Tồn Kho</h3>
            <canvas id="tyletonkhoChart" height="320"></canvas>
          </div>
        </div>
        <!-- Biểu đồ tròn tỷ lệ doanh thu -->
        <div class="col-md-6 mb-4">
          <div class="report-section">
            <h3 class="text-center mb-4">🧮 Tỷ Lệ Doanh Thu</h3>
            <canvas id="tyledoanhthuChart" height="320"></canvas>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      function injectBaoCaoStyles() {
        const css = `
        #baocao-table {
          font-family: 'Segoe UI', sans-serif;
          animation: fadeIn 1s ease-in-out;
        }
        .report-section {
          background: linear-gradient(135deg, #ffffff, #f1f4f9);
          padding: 20px;
          border-radius: 15px;
          box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
          transition: transform 0.3s, box-shadow 0.3s;
          height: 100%;
        }
        .report-section:hover {
          transform: translateY(-10px);
          box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }
        h3 {
          font-weight: bold;
          color: #2c3e50;
          text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        @keyframes fadeIn {
          from { opacity: 0; transform: translateY(20px);}
          to { opacity: 1; transform: translateY(0);}
        }
        @media (max-width: 768px) {
          .report-section { margin-bottom: 20px; }
        }
      `;
        const style = document.createElement('style');
        style.textContent = css;
        document.head.appendChild(style);
      }

      let tonkhoChart, doanhthuChart, tyletonkhoChart, tyledoanhthuChart;

      function fetchBaoCaoData() {
        // Lấy dữ liệu tồn kho
        return fetch('index.php?task=tonkho')
          .then(res => res.json())
          .then(tonkhoData => {
            // Lấy dữ liệu doanh thu
            return fetch('index.php?task=doanhthu')
              .then(res => res.json())
              .then(doanhthuData => ({
                tonkhoData,
                doanhthuData
              }));
          });
      }

      function renderBaoCaoCharts(tonkhoData, doanhthuData) {
        // Chuẩn hóa dữ liệu
        const labels = tonkhoData.map(item => item.tensp);
        const tonkhoValues = tonkhoData.map(item => Number(item.soluongton));
        const doanhthuLabels = doanhthuData.map(item => item.tensp);
        const doanhthuValues = doanhthuData.map(item => Number(item.doanhthu));

        // Biểu đồ cột tồn kho
        if (tonkhoChart) tonkhoChart.destroy();
        tonkhoChart = new Chart(document.getElementById('tonkhoChart').getContext('2d'), {
          type: 'bar',
          data: {
            labels: labels,
            datasets: [{
              label: 'Số lượng tồn',
              data: tonkhoValues,
              backgroundColor: 'rgba(54, 162, 235, 0.7)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 2
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              x: {
                title: {
                  display: true,
                  text: 'Sản phẩm'
                }
              },
              y: {
                title: {
                  display: true,
                  text: 'Số lượng tồn'
                },
                beginAtZero: true
              }
            }
          }
        });

        // Biểu đồ cột doanh thu
        if (doanhthuChart) doanhthuChart.destroy();
        doanhthuChart = new Chart(document.getElementById('doanhthuChart').getContext('2d'), {
          type: 'bar',
          data: {
            labels: doanhthuLabels,
            datasets: [{
              label: 'Doanh thu (VNĐ)',
              data: doanhthuValues,
              backgroundColor: 'rgba(255, 206, 86, 0.7)',
              borderColor: 'rgba(255, 206, 86, 1)',
              borderWidth: 2
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              x: {
                title: {
                  display: true,
                  text: 'Sản phẩm'
                }
              },
              y: {
                title: {
                  display: true,
                  text: 'Doanh thu (VNĐ)'
                },
                beginAtZero: true
              }
            }
          }
        });

        // Biểu đồ tròn tỷ lệ tồn kho
        if (tyletonkhoChart) tyletonkhoChart.destroy();
        tyletonkhoChart = new Chart(document.getElementById('tyletonkhoChart').getContext('2d'), {
          type: 'pie',
          data: {
            labels: labels,
            datasets: [{
              label: 'Tỷ lệ tồn kho',
              data: tonkhoValues,
              backgroundColor: labels.map((_, i) =>
                `hsl(${i * 360 / labels.length}, 70%, 60%)`
              ),
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: 'bottom'
              },
              tooltip: {
                callbacks: {
                  label: function(context) {
                    const total = tonkhoValues.reduce((a, b) => a + b, 0);
                    const value = context.raw;
                    const percent = total ? ((value / total) * 100).toFixed(1) : 0;
                    return `${context.label}: ${value} (${percent}%)`;
                  }
                }
              }
            }
          }
        });

        // Biểu đồ tròn tỷ lệ doanh thu
        if (tyledoanhthuChart) tyledoanhthuChart.destroy();
        tyledoanhthuChart = new Chart(document.getElementById('tyledoanhthuChart').getContext('2d'), {
          type: 'pie',
          data: {
            labels: doanhthuLabels,
            datasets: [{
              label: 'Tỷ lệ doanh thu',
              data: doanhthuValues,
              backgroundColor: doanhthuLabels.map((_, i) =>
                `hsl(${i * 360 / doanhthuLabels.length}, 80%, 70%)`
              ),
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: 'bottom'
              },
              tooltip: {
                callbacks: {
                  label: function(context) {
                    const total = doanhthuValues.reduce((a, b) => a + b, 0);
                    const value = context.raw;
                    const percent = total ? ((value / total) * 100).toFixed(1) : 0;
                    return `${context.label}: ${Number(value).toLocaleString()} đ (${percent}%)`;
                  }
                }
              }
            }
          }
        });
      }

      function showBaoCao() {
        fetchBaoCaoData().then(({
          tonkhoData,
          doanhthuData
        }) => {
          renderBaoCaoCharts(tonkhoData, doanhthuData);
          const target = document.getElementById("baocao-table");
          if (target) target.scrollIntoView({
            behavior: 'smooth'
          });
        });
      }

      window.addEventListener('DOMContentLoaded', () => {
        injectBaoCaoStyles();
        // Nếu muốn hiển thị ngay thì bỏ ẩn
        // document.getElementById('baocao-table').classList.remove('hidden');
      });

      window.addEventListener('hashchange', function() {
        if (window.location.hash === "#baocao") {
          showBaoCao();
        }
      });

      window.onload = function() {
        injectBaoCaoStyles();
        if (window.location.hash === "#baocao") {
          showBaoCao();
        }
      };
    </script>







    <div id="cauhinh" class="mt-4">
      <!-- Color Picker and Font Selector -->
      <div class="color-picker-container mt-4 p-4 rounded shadow-sm" style="background: #ffffff; border: 1px solid #ddd;">
        <h5 class="text-center mb-4" style="font-weight: bold; color: #333;">🎨 Tùy Chọn Màu và Phông Chữ</h5>
        <div class="d-flex justify-content-between align-items-center gap-4 flex-wrap">
          <div class="text-center">
            <label for="sidebar-color" class="form-label" style="font-weight: 600; color: #555;">Màu Sidebar</label>
            <input type="color" id="sidebar-color" class="form-control form-control-color" value="#0d6efd" title="Chọn màu Sidebar" style="width: 100%; max-width: 150px; margin: 0 auto;">
          </div>
          <div class="text-center">
            <label for="main-content-color" class="form-label" style="font-weight: 600; color: #555;">Màu Main Content</label>
            <input type="color" id="main-content-color" class="form-control form-control-color" value="#f1f4f9" title="Chọn màu Main Content" style="width: 100%; max-width: 150px; margin: 0 auto;">
          </div>
        </div>
        <div class="d-flex justify-content-between align-items-center gap-4 mt-4 flex-wrap">
          <div class="text-center">
            <label for="text-center-font" class="form-label" style="font-weight: 600; color: #555;">Phông chữ Text Center</label>
            <select id="text-center-font" class="form-select" style="width: 100%; max-width: 200px; margin: 0 auto;">
              <option value="'Segoe UI', sans-serif" selected>Segoe UI</option>
              <option value="Arial, sans-serif">Arial</option>
              <option value="'Courier New', monospace">Courier New</option>
              <option value="'Times New Roman', serif">Times New Roman</option>
            </select>
          </div>
          <div class="text-center">
            <label for="nav-link-font" class="form-label" style="font-weight: 600; color: #555;">Phông chữ Nav Link</label>
            <select id="nav-link-font" class="form-select" style="width: 100%; max-width: 200px; margin: 0 auto;">
              <option value="'Segoe UI', sans-serif" selected>Segoe UI</option>
              <option value="Arial, sans-serif">Arial</option>
              <option value="'Courier New', monospace">Courier New</option>
              <option value="'Times New Roman', serif">Times New Roman</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <script>
      // Lấy các phần tử cần thay đổi màu và phông chữ
      const sidebar = document.querySelector('.sidebar');
      const mainContent = document.querySelector('.main-content');
      const textCenterElements = document.querySelectorAll('.text-center');
      const navLinkElements = document.querySelectorAll('.nav-link.text-white.d-flex.align-items-center');

      // Lắng nghe sự kiện thay đổi màu của Sidebar
      document.getElementById('sidebar-color').addEventListener('input', function(event) {
        const color = event.target.value;
        sidebar.style.background = color;
      });

      // Lắng nghe sự kiện thay đổi màu của Main Content
      document.getElementById('main-content-color').addEventListener('input', function(event) {
        const color = event.target.value;
        mainContent.style.backgroundColor = color;
      });

      // Lắng nghe sự kiện thay đổi phông chữ của Text Center
      document.getElementById('text-center-font').addEventListener('change', function(event) {
        const font = event.target.value;
        textCenterElements.forEach(element => {
          element.style.fontFamily = font;
        });
      });

      // Lắng nghe sự kiện thay đổi phông chữ của Nav Link
      document.getElementById('nav-link-font').addEventListener('change', function(event) {
        const font = event.target.value;
        navLinkElements.forEach(element => {
          element.style.fontFamily = font;
        });
      });



      // Tự động tải lại phần cấu hình khi chọn mục "Cấu hình hệ thống"
      document.querySelector('.nav-link[href="#cauhinh"]').addEventListener('click', function() {
        setTimeout(() => {
          location.reload();
        }, 500); // Đợi 500ms để đảm bảo giao diện đã chuyển đổi trước khi tải lại
      });
    </script>












    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      function changeContent(title) {
        // Định nghĩa tiêu đề và bảng tương ứng
        const titles = {
          Dashboard: 'Dashboard',
          nhanvien: 'Quản lý nhân viên',
          sanpham: 'Quản lý sản phẩm',
          nhapkho: 'Nhập Kho',
          xuatkho: 'Xuất Kho',
          baocao: 'Báo cáo & Thống kê',
          cauhinh: 'Cấu hình hệ thống'
        };

        const tableIds = {
          Dashboard: 'dashboard-table',
          nhanvien: 'employee-table',
          sanpham: 'product-table',
          nhapkho: 'nhapkho-table',
          xuatkho: 'xuatkho-table',
          baocao: 'baocao-table',
          cauhinh: 'cauhinh'
        };

        // Cập nhật tiêu đề và mô tả
        document.getElementById('main-title').textContent = titles[title] || title;
        document.getElementById('main-description').textContent = `Bạn đang xem: ${titles[title] || title}`;

        // Ẩn tất cả các bảng
        Object.values(tableIds).forEach(id => {
          const el = document.getElementById(id);
          if (el) el.classList.add('hidden');
        });

        // Hiện bảng tương ứng
        const targetTableId = tableIds[title];
        if (targetTableId) {
          const el = document.getElementById(targetTableId);
          if (el) el.classList.remove('hidden');
        }

        // Hiện/ẩn nút Nhật ký
        const btnNhatKy = document.getElementById('btnNhatKy');
        if (btnNhatKy) {
          btnNhatKy.style.display = (title === 'Dashboard') ? 'inline-block' : 'none';
        }

        // Hiện/ẩn mục cấu hình hệ thống
        const cauhinhElement = document.getElementById('cauhinh');
        if (cauhinhElement) {
          cauhinhElement.style.display = (title === 'cauhinh') ? 'block' : 'none';
        }

        // Nếu là báo cáo thì gọi hàm hiển thị báo cáo
        if (title === 'baocao') {
          if (typeof showBaoCao === 'function') showBaoCao();
        }

        // Cập nhật hash trên URL
        window.location.hash = title;
      }

      function showTable(table) {
        changeContent(table);
      }

      // Khi trang load, hiển thị đúng bảng theo hash
      window.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash.replace('#', '');
        if (hash) {
          changeContent(hash);
        } else {
          changeContent('Dashboard');
        }
      });





      // function changeContent(title) {
      // const titles = {
      //   Dashboard: '',
      //   nhanvien: 'Quản lý nhân viên',
      //   sanpham: 'Quản lý sản phẩm',
      //   nhapkho: 'Nhập Kho',
      //   xuatkho: 'Xuất Kho',
      //     baocao: 'Báo cáo & Thống kê'
      //   };

      //   const tableIds = {
      //     Dashboard: 'dashboard-table',
      //     nhanvien: 'employee-table',
      //     sanpham: 'product-table',
      //     nhapkho: 'nhapkho-table',
      //     xuatkho: 'xuatkho-table',
      //     baocao: 'baocao-table'
      //   };

      //   document.getElementById('main-title').textContent = titles[title] || title;
      //   document.getElementById('main-description').textContent = `Bạn đang xem: ${titles[title] || title}`;

      //   // Ẩn tất cả bảng
      //   Object.values(tableIds).forEach(id => {
      //     const el = document.getElementById(id);
      //     if (el) el.classList.add('hidden');
      //   });

      //   const targetTableId = tableIds[title];
      //   if (targetTableId) {
      //     document.getElementById(targetTableId).classList.remove('hidden');

      //     // Nếu là bảng báo cáo thì tải dữ liệu
      //     if (title === 'baocao' && !window.baocaoLoaded) {
      //       fetchTonKho();
      //       fetchDoanhThu();
      //       window.baocaoLoaded = true;
      //       document.getElementById("baocao-table").scrollIntoView({
      //         behavior: 'smooth'
      //       });
      //     }
      //   }

      //   // Hiện/Ẩn nút "Hiển thị Nhật Ký Đăng Nhập"
      //   document.getElementById('btnNhatKy').style.display = (title === 'Dashboard') ? 'inline-block' : 'none';

      //   window.location.hash = title;
      // }

      // function showTable(table) {
      //   changeContent(table);
      // }

      // window.onload = function() {
      //   const hash = window.location.hash.replace('#', '');
      //   if (hash) {
      //     changeContent(hash);
      //   }
      // };



























      // function changeContent(title) {
      //   document.getElementById('main-title').textContent = title;
      //   document.getElementById('main-description').textContent = `Bạn đang xem: ${title}`;
      //   document.getElementById('employee-table').classList.add('hidden');
      // }

      // function showTable(table) {
      //   const titles = {
      //     nhanvien: 'Quản lý nhân viên',
      //     sanpham: 'Quản lý sản phẩm',
      //     nhapkho: 'Nhập Kho',
      //     xuatkho: 'Xuất Kho',
      //     baocao: 'Báo cáo & Thống kê'
      //   };

      //   document.getElementById('main-title').textContent = titles[table] || '';
      //   document.getElementById('main-description').textContent = '';

      //   ['employee-table', 'product-table', 'nhapkho-table', 'xuatkho-table', 'baocao-table'].forEach(id =>
      //     document.getElementById(id).classList.add('hidden')
      //   );

      //   if (table === 'nhanvien') {
      //     document.getElementById('employee-table').classList.remove('hidden');
      //   } else if (table === 'sanpham') {
      //     document.getElementById('product-table').classList.remove('hidden');
      //   } else if (table === 'nhapkho') {
      //     document.getElementById('nhapkho-table').classList.remove('hidden');
      //   } else if (table === 'xuatkho') {
      //     document.getElementById('xuatkho-table').classList.remove('hidden');
      //   } else if (table === 'baocao') {
      //     document.getElementById('baocao-table').classList.remove('hidden');
      //   }
      // }
    </script>

    <!-- <script>
  console.log('Kiểm tra DOM:', document.getElementById('nhapkho-table'));
  console.log('Nội dung:', document.getElementById('nhapkho-table')?.innerHTML);
</script> -->




</body>

</html>