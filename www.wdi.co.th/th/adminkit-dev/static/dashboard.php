<?php
$current_page = basename($_SERVER['PHP_SELF']); // ดึงชื่อไฟล์หน้าปัจจุบัน
?>

<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.php">
            <span class="align-middle">Admin-manu</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pages
            </li>

            <li class="sidebar-item <?= ($current_page == 'index.php') ? 'active' : '' ?>">
                <a class="sidebar-link" href="index.php">
                    <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">News</span>
                </a>
            </li>

            <li class="sidebar-item <?= ($current_page == 'pages-profile.php') ? 'active' : '' ?>">
                <a class="sidebar-link" href="pages-profile.php">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Profile</span>
                </a>
            </li>

            <li class="sidebar-item <?= ($current_page == 'pages-orders.php') ? 'active' : '' ?>">
                <a class="sidebar-link" href="pages-orders.php">
                    <i class="align-middle" data-feather="book"></i> <span class="align-middle">Products</span>
                </a>
            </li>

            <li class="sidebar-item <?= ($current_page == 'ui-history.php') ? 'active' : '' ?>">
                <a class="sidebar-link" href="ui-history.php">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">History Orders</span>
                </a>
            </li>

            <li class="sidebar-item <?= ($current_page == 'ui-addproduct.php') ? 'active' : '' ?>">
                <a class="sidebar-link" href="ui-addproduct.php">
                    <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Add ProdUct</span>
                </a>
            </li>

            <li class="sidebar-item <?= ($current_page == 'ui-cards.html') ? 'active' : '' ?>">
                <a class="sidebar-link" href="ui-cards.html">
                    <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Cards</span>
                </a>
            </li>

            <li class="sidebar-item <?= ($current_page == 'ui-typography.html') ? 'active' : '' ?>">
                <a class="sidebar-link" href="ui-typography.html">
                    <i class="align-middle" data-feather="align-left"></i> <span class="align-middle">Typography</span>
                </a>
            </li>

            <li class="sidebar-item <?= ($current_page == 'icons-feather.html') ? 'active' : '' ?>">
                <a class="sidebar-link" href="icons-feather.html">
                    <i class="align-middle" data-feather="coffee"></i> <span class="align-middle">Icons</span>
                </a>
            </li>

            <li class="sidebar-header">
                Plugins & Addons
            </li>

            <li class="sidebar-item <?= ($current_page == 'charts-chartjs.html') ? 'active' : '' ?>">
                <a class="sidebar-link" href="charts-chartjs.html">
                    <i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">Charts</span>
                </a>
            </li>

            <li class="sidebar-item <?= ($current_page == 'maps-google.html') ? 'active' : '' ?>">
                <a class="sidebar-link" href="maps-google.html">
                    <i class="align-middle" data-feather="map"></i> <span class="align-middle">Maps</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
