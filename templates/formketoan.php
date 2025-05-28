<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Kế Toán</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #e0f7fa, #fff3e0);
      height: 100vh;
    }

    .sidebar {
      width: 250px;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      background-color: #ffffff;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
      padding: 20px 15px;
      display: flex;
      flex-direction: column;
      z-index: 1000;
      transition: all 0.3s ease;
    }

    .sidebar h3 {
      text-align: center;
      font-size: 20px;
      margin-bottom: 25px;
      color: #2c3e50;
    }

    .menu-item {
      display: flex;
      align-items: center;
      padding: 12px 0px;
      border-radius: 10px;
      color: #34495e;
      text-decoration: none;
      margin-bottom: 60px;
      transition: 0.3s ease;
      background-color: #f9f9f9;
    }

    .menu-item:hover {
      background: linear-gradient(135deg, #74ebd5, #acb6e5);
      color: white;
      transform: translateX(5px);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .menu-item span {
      margin-left: 12px;
      font-size: 16px;
    }

    .menu-icon {
      font-size: 18px;
      transition: 0.3s;
    }

    .menu-item:hover .menu-icon {
      transform: scale(1.2) rotate(5deg);
    }

    /* Nội dung bên phải */
    .main-content {
      margin-left: 250px;
      padding: 30px;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
        padding: 10px;
      }

      .sidebar h3 {
        width: 100%;
        text-align: center;
        margin-bottom: 15px;
      }

      .menu-item {
        flex: 1 1 45%;
        margin: 5px;
        justify-content: center;
      }

      .main-content {
        margin-left: 0;
        padding: 20px;
      }
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


  <div class="sidebar">
    <h3>👩‍💻 👨‍💻 Kế Toán</h3>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link text-white menu-item" href="#dashboard" onclick="changeContent('Dashboard')">
          <span class="menu-icon">📊</span> <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white menu-item" href="#baocao" onclick="showTableBC('Báo cáo tài chính')">
          <span class="menu-icon">📈</span> <span>Báo cáo tài chính</span>
        </a>
      </li>


      <li class="nav-item">
        <a class="nav-link text-white menu-item" href="#lichsuNK" onclick="showTableLSNK('Lịch sử nhập kho')">
          <span class="menu-icon">📥</span> <span>Lịch sử nhập kho</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white menu-item" href="#lichsuXK" onclick="showTableLSXK('Lịch sử xuất kho')">
          <span class="menu-icon">📤</span> <span>Lịch sử xuất kho</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white menu-item" href="#tonkho" onclick="showTableCHECK('Kiểm tra tồn kho')">
          <span class="menu-icon">📦</span> <span>Kiểm tra tồn kho</span>
        </a>
      </li>
    </ul>
  </div>


  <div class="main-content">
    <h2>Chào mừng đến với hệ thống kế toán!</h2>
    <p>Chọn một mục từ menu để bắt đầu.</p>


  </div>











  <script>
    window.onload = function() {
      const hash = window.location.hash.replace('#', '');

      // Xử lý sự kiện khi URL thay đổi (sử dụng hash để thay đổi nội dung)
      switch (hash) {
        case 'dashboard':
          changeContent('Dashboard');
          break;
        case 'baocao':
          showTableBC('Báo cáo tài chính');
          break;
        case 'lichsuNK':
          showTableLSNK('Lịch sử nhập kho');
          break;
        case 'lichsuXK':
          showTableLSXK('Lịch sử xuất kho');
          break;
        case 'tonkho':
          showTableCHECK('Kiểm tra tồn kho');
          break;
        default:
          changeContent('Dashboard');
      }
    };



    // // Hàm thay đổi nội dung khi người dùng chọn một mục
    // function changeContent(title) {
    //   // const mainContent = document.querySelector('.main-content');
    //   // mainContent.innerHTML = `<h2>${title}</h2><p>Chọn một mục từ menu để bắt đầu.</p>`;
    // }

    function changeContent(title) {
      const mainContent = document.querySelector('.main-content');

      if (title === 'Dashboard') {
        showDashboard(); // gọi hàm để hiển thị Dashboard
      } else {
        mainContent.innerHTML = `<h2>${title}</h2><p>Chọn một mục từ menu để bắt đầu.</p>`;
      }
    }


    function showDashboard() {
      const mainContent = document.querySelector('.main-content');
      mainContent.innerHTML = `<h2>Dashboard</h2><p>Đang tải dữ liệu...</p>`;

      const style = `
      <style>
        .dashboard-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
        }

        .dashboard-card {
        flex: 1;
        min-width: 300px;
        background: linear-gradient(145deg, #6a11cb, #2575fc);
        color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease;
        }

        .dashboard-card:hover {
        transform: scale(1.05);
        }

        .chart-container {
        margin-top: 30px;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        }

        .comparison-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .comparison-table th, .comparison-table td {
        padding: 10px 15px;
        text-align: center;
        border-bottom: 1px solid #ddd;
        }

        .comparison-table th {
        background-color: #4CAF50;
        color: white;
        }

        .comparison-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
        }
      </style>
      `;

      mainContent.innerHTML = `
      ${style}
      <div class="dashboard-container">
        <div class="dashboard-card" id="total-revenue">Tổng doanh thu: Đang tải...</div>
        <div class="dashboard-card" id="total-expense">Tổng chi phí: Đang tải...</div>
        <div class="dashboard-card" id="total-profit">Lợi nhuận: Đang tải...</div>
      </div>
      <div class="chart-container">
        <canvas id="revenue-expense-chart" width="400" height="200"></canvas>
      </div>
      <table class="comparison-table">
        <thead>
        <tr>
          <th>Kỳ</th>
          <th>Doanh thu</th>
          <th>Chi phí</th>
          <th>Lợi nhuận</th>
        </tr>
        </thead>
        <tbody id="comparison-data">
        <tr><td colspan="4">Đang tải dữ liệu...</td></tr>
        </tbody>
      </table>
      `;

      Promise.all([
          fetch('index.php?task=getDashboardData').then(res => res.json()),
          fetch('index.php?task=getDashboardComparison').then(res => res.json())
        ])
        .then(([dashboardData, comparisonData]) => {
          if (dashboardData.success) {
            document.getElementById('total-revenue').textContent = `Tổng doanh thu: ${Number(dashboardData.revenue).toLocaleString()} VNĐ`;
            document.getElementById('total-expense').textContent = `Tổng chi phí: ${Number(dashboardData.expense).toLocaleString()} VNĐ`;
            document.getElementById('total-profit').textContent = `Lợi nhuận: ${Number(dashboardData.profit).toLocaleString()} VNĐ`;

            const ctx = document.getElementById('revenue-expense-chart').getContext('2d');
            new Chart(ctx, {
              type: 'bar', // Đổi thành biểu đồ cột
              data: {
                labels: dashboardData.chart.labels,
                datasets: [{
                    label: 'Doanh thu',
                    data: dashboardData.chart.revenue,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                  },
                  {
                    label: 'Chi phí',
                    data: dashboardData.chart.expense,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                  }
                ]
              },
              options: {
                responsive: true,
                plugins: {
                  legend: {
                    position: 'top'
                  },
                  title: {
                    display: true,
                    text: 'Biểu đồ thu chi theo thời gian'
                  }
                },
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              }
            });
          }

          if (comparisonData.success) {
            const comparisonTable = document.getElementById('comparison-data');
            comparisonTable.innerHTML = comparisonData.data.map(row => `
          <tr>
          <td>${row.period}</td>
          <td>${Number(row.revenue).toLocaleString()} VNĐ</td>
          <td>${Number(row.expense).toLocaleString()} VNĐ</td>
          <td>${Number(row.profit).toLocaleString()} VNĐ</td>
          </tr>
        `).join('');
          }
        })
        .catch(error => {
          console.error('Lỗi:', error);
          mainContent.innerHTML += `<p>Lỗi khi tải dữ liệu: ${error.message}</p>`;
        });
    }


























    // Hàm hiển thị bảng Báo cáo tài chính
    function showTableBC(title) {
      const mainContent = document.querySelector('.main-content');

      // Tạo kiểu CSS trực tiếp trong script
      const style = `
        <style>
            /* Background Gradient */
            .report-container {
                background: linear-gradient(145deg, #6a11cb, #2575fc);
                padding: 30px;
                border-radius: 15px;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
                margin-top: 20px;
                transition: all 0.3s ease-in-out;
            }
            .report-container:hover {
                transform: scale(1.02);
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            }
            
            /* Tiêu đề */
            .report-container h2 {
                font-size: 28px;
                color: #fff;
                margin-bottom: 20px;
                font-weight: 700;
                text-align: center;
            }
            
            /* Đoạn văn */
            .report-container p {
                font-size: 20px;
                color: #f5f5f5;
                text-align: center;
                font-weight: 500;
            }
            
            /* Thông tin báo cáo */
            .report-data {
                font-size: 20px;
                color: #fff;
                margin-top: 20px;
                padding: 20px;
                background-color: rgba(0, 0, 0, 0.3);
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            
            /* Hiệu ứng Loading */
            .loading-message {
                font-size: 22px;
                color: #ffeb3b;
                font-weight: bold;
                animation: loading 2s infinite;
            }

            /* Hiệu ứng loading chớp */
            @keyframes loading {
                0% { color: #ffeb3b; }
                50% { color: #ffc107; }
                100% { color: #ffeb3b; }
            }
            
            /* Thông báo lỗi */
            .error-message {
                font-size: 20px;
                color: #f44336;
                font-weight: bold;
                text-align: center;
            }

            /* Thông báo không có dữ liệu */
            .no-data-message {
                font-size: 20px;
                color: #f44336;
                font-weight: bold;
                text-align: center;
            }

            /* Button Back to Top */
            .back-to-top {
                margin-top: 20px;
                padding: 10px 20px;
                background-color: #28a745;
                color: white;
                border: none;
                border-radius: 50px;
                font-size: 18px;
                cursor: pointer;
                transition: background-color 0.3s;
                display: inline-block;
                text-align: center;
            }

            .back-to-top:hover {
                background-color: #218838;
                transform: scale(1.05);
            }

            /* Shadow effect for each item */
            .report-data p {
                transition: all 0.3s ease;
            }

            .report-data p:hover {
                transform: scale(1.05);
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);

            }
                .report-wrapper {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 20px;
}

.report-data {
    flex: 1;
    min-width: 300px;
    max-width: 45%;
}

        </style>
    `;

      // Hiển thị phần báo cáo và cập nhật tiêu đề
      mainContent.innerHTML = `
        ${style}
        <div class="report-container">
            <h2>${title}</h2>
            <p class="loading-message">Đang tải dữ liệu báo cáo tài chính...</p>
        </div>
    `;

      Promise.all([
          fetch("index.php?task=thongke").then(res => res.json()),
          fetch("index.php?task=phieunhap").then(res => res.json())
        ])
        .then(([dataXuat, dataNhap]) => {
          if (dataXuat.success && dataNhap.success) {
            mainContent.innerHTML = `
                ${style}
                <div class="report-container">
                   <h2>${title}</h2>
    <div class="report-wrapper">
      <div class="report-data">
        <h3>Thông tin nhập</h3>
        <p><strong>Số lượng đơn nhập:</strong> ${dataNhap.so_luong}</p>
        <p><strong>Tổng tiền nhập:</strong> ${Number(dataNhap.tong_tien).toLocaleString()} VNĐ</p>
      </div>
      <div class="report-data">
        <h3>Thông tin xuất</h3>
        <p><strong>Số lượng đơn đã xuất:</strong> ${dataXuat.so_luong_don_xuat}</p>
        <p><strong>Tổng doanh thu:</strong> ${Number(dataXuat.tong_tien).toLocaleString()} VNĐ</p>
      </div>
    </div>
    <div style="text-align: center;">
 <button class="back-to-top" onclick="location.reload()">Tải lại trang</button>

                    </div>
                </div > 
                 <form method="post" action="index.php?task=xuatexcel" class="mt-4" style="display:flex; padding-top: 7px; justify-content: end;" >
               <button type="submit" class="btn btn-success"
    style="
        padding: 12px 28px;
        font-size: 17px;
        font-weight: bold;
        border-radius: 8px;
        background-color: #28a745;
        color: white;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.4);
        transition: all 0.3s ease;
    "
    onmouseover="this.style.backgroundColor='#218838'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 14px rgba(40, 167, 69, 0.6)'"
    onmouseout="this.style.backgroundColor='#28a745'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(40, 167, 69, 0.4)'"
    onmousedown="this.style.transform='scale(0.97)'"
    onmouseup="this.style.transform='translateY(-2px)'"
>
    <i class="bi bi-file-earmark-excel"></i> Xuất Excel
</button>

            </form>
            `;
          } else {
            const message = (!dataXuat.success ? dataXuat.message : '') + ' ' + (!dataNhap.success ? dataNhap.message : '');
            mainContent.innerHTML = `
                ${style}
                <div class="report-container">
                    <h2>${title}</h2>
                    <p class="no-data-message">${message.trim() || "Không có dữ liệu."}</p>
                </div>
            `;
          }
        })
        .catch(error => {
          console.error("Lỗi:", error);
          mainContent.innerHTML = `
            ${style}
            <div class="report-container">
                <h2>${title}</h2>
                <p class="error-message">Lỗi khi lấy dữ liệu.</p>
            </div>
        `;
        });
    }




    function showTableLSXK(title = 'Lịch sử xuất kho', id_donhang = null) {
      const mainContent = document.querySelector('.main-content');
      mainContent.innerHTML = `<h2>${title}</h2>`;

      const style = document.createElement('style');
      style.innerHTML = `
  /* CSS giữ nguyên như cũ */
  .styled-table {
      width: 100%;
      border-collapse: collapse;
      margin: 25px 0;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
  }
  .styled-table th, .styled-table td {
      padding: 10px 15px;
      text-align: center;
  }
  .styled-table th {
      background-color: #4CAF50;
      color: white;
  }
  .styled-table tbody tr:nth-child(even) {
      background-color: #f2f2f2;
  }
  .styled-table tbody tr:hover {
      background-color: #ddd;
  }
  .styled-table tbody tr td {
      border-bottom: 1px solid #ddd;
  }

  .btn {
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 14px;
      margin: 5px;
      transition: background-color 0.3s ease;
  }
  .btn:hover {
      background-color: #45a049;
  }
  .back-btn {
      background-color: #f44336;
  }
  .back-btn:hover {
      background-color: #e53935;
  }

  .phieu-xuat {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-bottom: 15px;
  }

  .phieu-xuat button {
      margin-right: 10px;
  }

  .phieu-xuat strong {
      color: #333;
  }
  `;
      document.head.appendChild(style);

      fetch(`index.php?task=getchitietdonhangxuat`)
        .then(response => {
          if (!response.ok) throw new Error(`Lỗi HTTP: ${response.status}`);
          return response.text();
        })
        .then(text => {
          try {
            if (text.includes('<html') || text.includes('<body') || text.includes('<br')) {
              throw new Error("Phản hồi không phải JSON hợp lệ.");
            }

            const jsonString = text.trim().replace(/null$/, '');
            const data = JSON.parse(jsonString);

            if (!id_donhang) {
              data.forEach(donhang => {
                const tongTien = donhang.chitiet.reduce((sum, item) => sum + parseFloat(item.thanhtien), 0);
                mainContent.innerHTML += `
              <div class="phieu-xuat">
                <strong>Mã đơn hàng:</strong> ${donhang.id_donhang} <br>
                <strong>Tổng tiền:</strong> ${tongTien.toLocaleString()} đ <br>
                <button class="btn" onclick="showTableLSXK('Chi tiết đơn hàng', ${donhang.id_donhang})">Xem chi tiết</button>
              </div>
            `;
              });
              return;
            }

            const record = data.find(item => item.id_donhang == id_donhang);
            if (!record) {
              mainContent.innerHTML += `<p>Không tìm thấy chi tiết cho đơn hàng ${id_donhang}.</p>`;
              return;
            }

            const chitiet = record.chitiet;
            if (!Array.isArray(chitiet) || chitiet.length === 0) {
              mainContent.innerHTML += `<p>Đơn hàng ${id_donhang} không có dữ liệu chi tiết.</p>`;
              return;
            }

            let tableHTML = `
            <h3>Chi tiết - Đơn hàng ${id_donhang}</h3>
            <button class="btn back-btn" onclick="showTableLSXK('Lịch sử xuất kho')">Quay lại</button>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Mã SP</th>
                        <th>Tên SP</th>
                        <th>Số lượng</th>
                        <th>Giá xuất</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
        `;

            chitiet.forEach(item => {
              tableHTML += `
                <tr>
                    <td>${item.masp}</td>
                    <td>${item.tensp}</td>
                    <td>${item.soluong}</td>
                    <td>${Number(item.giaxuat).toLocaleString()} đ</td>
                    <td>${Number(item.thanhtien).toLocaleString()} đ</td>
                </tr>
              `;
            });

            tableHTML += `</tbody></table>`;
            mainContent.innerHTML += tableHTML;

          } catch (e) {
            console.error("Lỗi parse JSON:", e);
            mainContent.innerHTML += `<p>Lỗi dữ liệu trả về từ server. Vui lòng kiểm tra lại.</p>`;
          }
        })
        .catch(error => {
          console.error("Lỗi fetch:", error);
          mainContent.innerHTML += `<p>Lỗi khi tải dữ liệu: ${error.message}</p>`;
        });
    }




    ///////////////////////////////////////////////////////////////////////
    function showTableLSNK(title = 'Lịch sử nhập kho', maphieunhap = null) {
      const mainContent = document.querySelector('.main-content');
      mainContent.innerHTML = `<h2>${title}</h2>`;

      // Thêm CSS vào trong trang
      const style = document.createElement('style');
      style.innerHTML = `
    /* CSS cho bảng */
    .styled-table {
      width: 100%;
      border-collapse: collapse;
      margin: 25px 0;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
    }
    .styled-table th, .styled-table td {
      padding: 10px 15px;
      text-align: center;
    }
    .styled-table th {
      background-color: #4CAF50;
      color: white;
    }
    .styled-table tbody tr:nth-child(even) {
      background-color: #f2f2f2;
    }
    .styled-table tbody tr:hover {
      background-color: #ddd;
    }
    .styled-table tbody tr td {
      border-bottom: 1px solid #ddd;
    }

    /* CSS cho nút */
    .btn {
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 14px;
      margin: 5px;
      transition: background-color 0.3s ease;
    }
    .btn:hover {
      background-color: #45a049;
    }
    .back-btn {
      background-color: #f44336;
    }
    .back-btn:hover {
      background-color: #e53935;
    }

    /* CSS cho phần phiếu nhập */
    .phieu-nhap {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-bottom: 15px;
    }

    .phieu-nhap button {
      margin-right: 10px;
    }

    .phieu-nhap strong {
      color: #333;
    }
  `;
      document.head.appendChild(style);

      fetch(`index.php?task=getchitietphieunhap`)
        .then(response => {
          if (!response.ok) throw new Error(`Lỗi HTTP: ${response.status}`);
          return response.text();
        })
        .then(text => {
          try {
            const jsonString = text.trim().replace(/null$/, '');
            const data = JSON.parse(jsonString);

            // Nếu chưa truyền maphieunhap → hiển thị danh sách các phiếu
            if (!maphieunhap) {
              data.forEach(phieu => {
                const tongTien = phieu.chitiet.reduce((sum, item) => sum + parseFloat(item.thanhtien), 0);

                mainContent.innerHTML += `
              <div class="phieu-nhap">
                <strong>Mã phiếu:</strong> ${phieu.maphieunhap} <br>
                <strong>Tổng tiền:</strong> ${tongTien.toLocaleString()} đ <br>
                <button class="btn" onclick="showTableLSNK('Chi tiết phiếu', ${phieu.maphieunhap})">Xem chi tiết</button>
              </div>
            `;
              });
              return;
            }

            // Nếu có maphieunhap → hiển thị chi tiết phiếu đó
            const record = data.find(item => item.maphieunhap == maphieunhap);
            if (!record) {
              mainContent.innerHTML += `<p>Không tìm thấy chi tiết cho phiếu ${maphieunhap}.</p>`;
              return;
            }

            const chitiet = record.chitiet;
            if (!Array.isArray(chitiet) || chitiet.length === 0) {
              mainContent.innerHTML += `<p>Phiếu ${maphieunhap} không có dữ liệu chi tiết.</p>`;
              return;
            }

            let tableHTML = `
          <h3>Chi tiết - Phiếu ${maphieunhap}</h3>
          <button class="btn back-btn" onclick="showTableLSNK('Lịch sử nhập kho')">Quay lại</button>
          <table class="styled-table">
            <thead>
              <tr>
                <th>Mã SP</th>
                <th>Tên SP</th>
                <th>Số lượng</th>
                <th>Giá nhập</th>
                <th>Thành tiền</th>
              </tr>
            </thead>
            <tbody>
        `;

            chitiet.forEach(item => {
              tableHTML += `
            <tr>
              <td>${item.masp}</td>
              <td>${item.tensp}</td>
              <td>${item.soluongnhap}</td>
              <td>${Number(item.gianhap).toLocaleString()} đ</td>
              <td>${Number(item.thanhtien).toLocaleString()} đ</td>
            </tr>
          `;
            });

            tableHTML += `</tbody></table>`;
            mainContent.innerHTML += tableHTML;
          } catch (e) {
            console.error("Lỗi parse JSON:", e);
            mainContent.innerHTML += `<p>Lỗi dữ liệu trả về từ server. Vui lòng kiểm tra lại.</p>`;
          }
        })
        .catch(error => {
          console.error("Lỗi fetch:", error);
          mainContent.innerHTML += `<p>Lỗi khi tải dữ liệu: ${error.message}</p>`;
        });
    }








    // Hàm kiểm tra tồn kho
    function showTableCHECK(title = 'Kiểm tra tồn kho') {
      const mainContent = document.querySelector('.main-content');
      mainContent.innerHTML = `<h2>${title}</h2><p>Đang tải dữ liệu kiểm tra tồn kho...</p>`;

      const style = document.createElement('style');
      style.innerHTML = `
    .styled-table {
      width: 100%;
      border-collapse: collapse;
      margin: 25px 0;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      animation: fadeInSlideUp 0.8s ease-out;
    }

    .styled-table th, .styled-table td {
      padding: 12px 18px;
      text-align: center;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }

    .styled-table th {
      background: linear-gradient(145deg, #6a11cb, #2575fc);
      color: white;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .styled-table tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .styled-table tbody tr:hover {
      background-color: #e0f7e9;
      transform: scale(1.01);
      transition: all 0.2s ease-in-out;
    }

    .styled-table tbody tr td {
      border-bottom: 1px solid #ddd;
    }

    @keyframes fadeInSlideUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  `;

      document.head.appendChild(style);

      fetch('index.php?task=kiemtratonkho')
        .then(response => {
          if (!response.ok) throw new Error(`Lỗi HTTP: ${response.status}`);
          return response.text();
        })
        .then(text => {
          try {
            if (text.includes('<html') || text.includes('<body') || text.includes('<br')) {
              throw new Error("Phản hồi không phải JSON hợp lệ.");
            }

            const jsonString = text.trim().replace(/null$/, '');
            const data = JSON.parse(jsonString);

            if (!Array.isArray(data) || data.length === 0) {
              mainContent.innerHTML += `<p>Không có dữ liệu tồn kho.</p>`;
              return;
            }

            let tableHTML = `
          <table class="styled-table">
            <thead>
              <tr>
                <th>Mã SP</th>
                <th>Tên SP</th>
                <th>Tổng nhập</th>
                <th>Tổng xuất</th>
                <th>Tồn kho</th>
              </tr>
            </thead>
            <tbody>
        `;

            data.forEach(item => {
              tableHTML += `
    <tr>
      <td>${item.masp}</td>
      <td>${item.tensp}</td>
      <td>${item.tongnhap}</td>
      <td>${item.tongxuat}</td>
      <td>${item.soluongton}</td>
    </tr>
  `;
            });


            tableHTML += '</tbody></table>';
            mainContent.innerHTML = `<h2>${title}</h2>` + tableHTML;
          } catch (e) {
            console.error("Lỗi parse JSON:", e);
            mainContent.innerHTML += `<p>Lỗi dữ liệu trả về từ server. Vui lòng kiểm tra lại.</p>`;
          }
        })
        .catch(error => {
          console.error("Lỗi fetch:", error);
          mainContent.innerHTML += `<p>Lỗi khi tải dữ liệu: ${error.message}</p>`;
        });
    }
  </script>










  <style>
    .top-right-menu {
      position: absolute;
      top: 0;
      right: 0;
      z-index: 999;
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 0 0 0 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .top-right-menu a.nav-link {
      text-decoration: none;
    }

    .top-right-menu span {
      font-size: 20px;
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

  <script>
    window.onload = function() {
      const hash = window.location.hash.replace('#', '');
      let matched = false;

      // Duyệt từng thẻ menu và so sánh với hash
      document.querySelectorAll('.menu-item').forEach(link => {
        // Xóa class active cũ
        link.classList.remove('active');

        // Lấy href của thẻ (vd: #baocao, #lichsu...)
        const href = link.getAttribute('href').replace('#', '');

        // Nếu href trùng với hash => set active
        if (href === hash) {
          link.classList.add('active');
          matched = true;

          // Gọi hàm tương ứng với onclick trong thẻ
          link.click();
        }
      });

      // Nếu không khớp hash nào thì mặc định chọn Dashboard
      if (!matched) {
        const defaultLink = document.querySelector('.menu-item[href="#dashboard"]');
        if (defaultLink) {
          defaultLink.classList.add('active');
          defaultLink.click();
        }
      }
    };

    // Gán sự kiện click để thêm class active
    document.querySelectorAll('.menu-item').forEach(item => {
      item.addEventListener('click', () => {
        document.querySelectorAll('.menu-item').forEach(i => i.classList.remove('active'));
        item.classList.add('active');
      });
    });
  </script>



  <!-- <script>
    function showTableBC(title) {
      // Hiển thị phần báo cáo
      document.getElementById("baocao-container").style.display = "block"; // Đảm bảo có phần tử với id này trong HTML

      // Cập nhật tiêu đề báo cáo
      document.getElementById("baocao-title").innerText = title;

      // Tải dữ liệu báo cáo tài chính (có thể là thông tin động từ API)
      document.getElementById("doanhthu").innerHTML = "Đang tải dữ liệu...";

      fetch("index.php?task=thongke")
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            document.getElementById("doanhthu").innerHTML = `
          <p><strong>Số lượng đơn đã xuất:</strong> ${data.so_luong_don_xuat}</p>
          <p><strong>Tổng doanh thu:</strong> ${Number(data.tong_tien).toLocaleString()} VNĐ</p>
        `;
          } else {
            document.getElementById("doanhthu").innerText = data.message || "Không có dữ liệu.";
          }
        })
        .catch(error => {
          console.error("Lỗi:", error);
          document.getElementById("doanhthu").innerText = "Lỗi khi lấy dữ liệu.";
        });
    }
  </script>

  <div id="baocao-container" style="display: none;">
    <h3 id="baocao-title">Báo cáo tài chính</h3>
    <div id="doanhthu">Đang tải dữ liệu...</div>
  </div> -->

























































</body>

</html>