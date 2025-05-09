<style>
    .login-button-container {
        margin-left: 15px;
        display: inline-block;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 4px;
        border: none;
        font-size: 14px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .menu li.active > a {
    color: #dc3545 !important;
    font-weight: bold;
    border-radius: 4px;
}

</style>
<nav class="topnav navbar navbar-inverse navbar-static-top" role="navigation">
    <div class="container hidden-xs">

        <div class="navbar-collapse collapse" id="navbar">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <form class="navbar-form navbar-left" method="get" action="https://www.wdi.co.th/th/" autocomplete="off">
                        <div class="form-group">
                            <input name="s" id="s" type="text" class="form-control" placeholder="Site Search" value="" />
                        </div>
                    </form>
                </li>
                <li class="login-button-container">
                    <a href="/wdi/www.wdi.co.th/th/login.php" class="btn btn-primary" style="color:rgb(255, 255, 255);">Login</a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Language <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="https://www.wdi.co.th/en/" hreflang="en" title="English (en)">
                                <img src="https://www.wdi.co.th/wp-content/plugins/qtranslate-x/flags/gb.png" alt="English (en)" /> English</a>
                        </li>
                        <li><a href="https://www.wdi.co.th/th/" hreflang="th" title="Thai (th)">
                                <img src="https://www.wdi.co.th/wp-content/plugins/qtranslate-x/flags/th.png" alt="Thai (th)" /> Thai</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="https://www.wdi.co.th/th"><img src="http://www.wdi.co.th/wp-content/uploads/2015/09/WDI_logo.png" width="125" height="50" /></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="mobile-menu hidden-lg hidden-md hidden-sm">
                <li class="mobile-language text-center">
                    <ul class="language-chooser language-chooser-image qtranxs_language_chooser" id="qtranslate-chooser">
                        <li class="lang-en"><a href="https://www.wdi.co.th/en/" hreflang="en" title="English (en)" class="qtranxs_image qtranxs_image_en"><img src="https://www.wdi.co.th/wp-content/plugins/qtranslate-x/flags/gb.png" alt="English (en)" /><span style="display:none">English</span></a></li>
                        <li class="lang-th active"><a href="https://www.wdi.co.th/th/" hreflang="th" title="Thai (th)" class="qtranxs_image qtranxs_image_th"><img src="https://www.wdi.co.th/wp-content/plugins/qtranslate-x/flags/th.png" alt="Thai (th)" /><span style="display:none">Thai</span></a></li>
                    </ul>
                    <div class="qtranxs_widget_end"></div>
                </li>
                <li class="navbar-search text-center">
                    <form method="get" action="https://www.wdi.co.th/th/" autocomplete="off">
                        <input name="s" id="s" type="text" id="searchform" placeholder="Site Search" value="" />
                        <input type="hidden" name="search-type" value="all" />
                    </form>
                </li>
            </ul>
            <div class="menu-main-nav-container">
                <ul id="menu-main-nav" class="menu">
                    <li id="menu-item-502" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-502"><a href="/wdi/www.wdi.co.th/th/index.php">หน้าแรก</a></li>
                    <li id="menu-item-8184" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-8184"><a href="/wdi/www.wdi.co.th/th/product/product-led-lamps.php">สินค้า</a>
                        <ul class="sub-menu">
                            <li id="menu-item-3560" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-3560"><a href="#">ไฟแอลอีดี</a></li>
                            <li id="menu-item-3561" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-3561"><a href="#">ไฟฉุกเฉิน</a></li>
                            <li id="menu-item-3562" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-3562"><a href="#">ไฟส่องสว่างหน้า</a></li>
                            <li id="menu-item-3563" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-3563"><a href="#">ไฟสัญญาณ</a></li>
                            <li id="menu-item-3564" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-3564"><a href="#">อุปกรณ์ทั่วไป</a></li>
                            <li id="menu-item-3565" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-3565"><a href="#">อุปกรณ์ประดับยนต์</a></li>
                            <li id="menu-item-3566" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-3566"><a href="#">ชิ้นส่วนทดแทน</a></li>
                        </ul>
                    </li>
                    <li id="menu-item-71" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-71"><a href="/wdi/www.wdi.co.th/th/about.php">เกี่ยวกับ WDI</a></li>
                    <li id="menu-item-72" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-72"><a href="/wdi/www.wdi.co.th/th/media/media.php">มีเดีย</a></li>
                    <li id="menu-item-74" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-74"><a href="/wdi/www.wdi.co.th/th/map/mapShow.php">ร้านค้า</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const menuLinks = document.querySelectorAll('.menu li a');

        menuLinks.forEach(link => {
            const linkPath = link.getAttribute('href');

            // ตรวจสอบว่าลิงก์ในเมนูมี path ตรงกับ URL ปัจจุบันหรือไม่
            if (linkPath === currentPath) {
                link.classList.add('active');
                const parentLi = link.closest('li');
                if (parentLi) parentLi.classList.add('active');
            }

            // เพิ่มการ highlight ตอนคลิกด้วย (optional)
            link.addEventListener('click', function() {
                menuLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                const parentLi = this.closest('li');
                if (parentLi) parentLi.classList.add('active');
            });
        });
    });
</script>