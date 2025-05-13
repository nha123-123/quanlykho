<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="title">Nhân Viên Kho</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            height:727px;
            background: #343a40;
            padding: 20px;
            color: white;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background: #495057;
        }

        .content {
            padding: 20px;
        }
    </style>

</head>

<body>

    <div class="container-fluid">
        <!-- Display logged-in user's info and logout button -->
        <div class="top-right-menu d-flex justify-content-end align-items-center p-3">
            <?php if (isset($_SESSION['taikhoan1'])): ?>
                <div class="user-dropdown text-end">
                    <span class="text-dark fw-bold" id="userMenuToggle" style="cursor: pointer;">
                        Chào nhân viên kho, <?php echo $_SESSION['taikhoan1']; ?> ▼
                    </span>
                    <div id="userDropdownMenu" class="dropdown-menu-custom">
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
            <nav class="sidebar col-md-3 col-lg-2 d-md-block text-white">
                <h4 data-i18n="🧑 Nhân viên kho">🧑 Nhân viên kho</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#dashboard" onclick="changeContent(i18next.t('dashboard'))">
                            📊 <span data-i18n="dashboard">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#sanpham" onclick="showTableSP(i18next.t('productList'))">
                            📦 <span data-i18n="productList">Danh sách sản phẩm</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#nhapkho" onclick="showTable(i18next.t('importWarehouse'))">
                            ➕ <span data-i18n="importWarehouse">Nhập kho</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#xuatkho" onclick="showXuatKhoForm()">
                            📤 <span data-i18n="exportWarehouse">Xuất kho</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#baocao" onclick="showTableTK(i18next.t('report'))">
                            📊 <span data-i18n="report">Báo cáo & Thống kê</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#lichsu" onclick="showTableLS(i18next.t('history'))">
                            📜 <span data-i18n="history">Lịch sử nhập/xuất kho</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="menu-cauhinh" class="nav-link text-white" href="#cauhinh" onclick="showCauHinh()">
                            ⚙️ <span data-i18n="config">Cấu hình hệ thống</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <main class="col-md-9 col-lg-10 content">
                <h2>Dashboard</h2>
                <p>Chào mừng đến với hệ thống quản lý kho.</p>
            </main>
        </div>
    </div>


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
            font-size: 14px;
        }

        /* Dropdown CSS */
        .user-dropdown {
            position: relative;
        }

        .dropdown-menu-custom {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            min-width: 150px;
            padding: 5px 0;
            z-index: 1001;
        }

        .dropdown-item-custom {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
        }

        .dropdown-item-custom:hover {
            background-color: #f2f2f2;
            color: red;
        }
    </style>
    <script>
        document.getElementById('userMenuToggle').addEventListener('click', function() {
            const menu = document.getElementById('userDropdownMenu');
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
        });

        document.addEventListener('click', function(e) {
            const toggle = document.getElementById('userMenuToggle');
            const menu = document.getElementById('userDropdownMenu');
            if (!toggle.contains(e.target) && !menu.contains(e.target)) {
                menu.style.display = 'none';
            }
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
                    <th>Địa chỉ</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="donhangData">
                <!-- Dữ liệu sẽ được thêm bằng JavaScript -->
            </tbody>
        </table>
    `;
            loadDonHangData(); // Gọi hàm để tải dữ liệu đơn hàng
        }

        // Hàm lấy dữ liệu đơn hàng từ server
        function loadDonHangData() {
            fetch('index.php?task=getDonHangData') // API trả về danh sách đơn hàng
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('donhangData');
                    tableBody.innerHTML = ''; // Xóa dữ liệu cũ trước khi thêm dữ liệu mới

                    // Duyệt qua danh sách đơn hàng và tạo các dòng trong bảng
                    data.forEach(donhang => {
                        const row = document.createElement('tr');
                        const buttonHtml = donhang.trangthai === 'Đã xuất' ?
                            `<button class="btn btn-danger" onclick="huyXuatDonHang(${donhang.id}, this)">Huỷ</button>` :
                            `<button class="btn btn-info" onclick="xuatDonHang(${donhang.id}, this)">Xuất</button>`;

                        row.innerHTML = `
                    <td>${donhang.id}</td>
                    <td>${donhang.id_nhanvien}</td>
                    <td>${donhang.ngaylap}</td>
                    <td>${donhang.diachi}</td>
                    <td class="trangthai">${donhang.trangthai}</td>
                    <td>
                        ${buttonHtml}
                        <button class="btn btn-primary" onclick="xemChiTietDonHang(${donhang.id})">Chi tiết</button>
                    </td>
                `;
                        tableBody.appendChild(row);
                    });
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
            text-transform: uppercase;
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
            const nhapMap = {}, xuatMap = {};

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
                datasets: [
                    {
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