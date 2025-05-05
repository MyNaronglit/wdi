<?php
require_once('../php-backend/server.php');
$db = new server();
$ierp = $db->connect_sql();


    $category = isset($_GET['category']) ? $_GET['category'] : null;
    $category01 = isset($_GET['category01']) ? $_GET['category01'] : null;
    $category_detail = isset($_GET['category_detail']) ? $_GET['category_detail'] : null;
    $car_brand_input = isset($_GET['car_brand_input']) ? $_GET['car_brand_input'] : null;
    $car_model_input = isset($_GET['car_model_input']) ? $_GET['car_model_input'] : null;

    // ทำ query เพื่อดึงข้อมูลสินค้าที่เกี่ยวข้องกับ category_detail นี้
    $sql = "SELECT * FROM products WHERE category_detail = ? ";
    $stmt = $ierp->prepare($sql);
    $stmt->bind_param("s", $category_detail);
    $stmt->execute();
    $result01 = $stmt->get_result();

    // ทำ query เพื่อดึงข้อมูลสินค้าที่เกี่ยวข้องกับ category_detail นี้
    $sql = "SELECT * FROM products WHERE  car_model_input = ?";
    $stmt = $ierp->prepare($sql);
    $stmt->bind_param("s",$car_model_input);
    $stmt->execute();
    $result02 = $stmt->get_result();


    $sql_replacement_parts = "SELECT product_id ,category, product_name,car_brand_input, car_image_upload_brand FROM `products` WHERE category = ?";
    $stmt_replacement_parts = $ierp->prepare($sql_replacement_parts);
    $stmt_replacement_parts->bind_param("s", $category);
    $stmt_replacement_parts->execute();
    $result_replacement_parts = $stmt_replacement_parts->get_result();


    $sql_car_brand_input = "SELECT product_id , product_name,car_model_input,image_path, car_image_upload FROM `products` WHERE car_brand_input = ? and category = ?";
    $stmt_car_brand_input = $ierp->prepare($sql_car_brand_input);
    $stmt_car_brand_input->bind_param("ss", $car_brand_input, $category01); 
    $stmt_car_brand_input->execute();
    $result_car_brand_input = $stmt_car_brand_input->get_result();
?>
    <!DOCTYPE html>
    <html lang="th-TH">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            Wichien Dynamic Industry | Product categories | LED Interior Lamps </title>

        <meta name='robots' content='noindex,follow' />
        <link rel='dns-prefetch' href='//fonts.googleapis.com' />
        <link rel='dns-prefetch' href='//s.w.org' />
        <link rel="alternate" type="application/rss+xml" title="Wichien Dynamic Industry &raquo; LED Interior Lamps Category Feed" href="https://www.wdi.co.th/th/product-category/led-lamps/led-interior-lamps/feed/" />
        <script type="text/javascript">
            window._wpemojiSettings = {
                "baseUrl": "https:\/\/s.w.org\/images\/core\/emoji\/11\/72x72\/",
                "ext": ".png",
                "svgUrl": "https:\/\/s.w.org\/images\/core\/emoji\/11\/svg\/",
                "svgExt": ".svg",
                "source": {
                    "concatemoji": "https:\/\/www.wdi.co.th\/wp-includes\/js\/wp-emoji-release.min.js?ver=9a30e44c1415efb53499654793754fec"
                }
            };
            ! function(e, a, t) {
                var n, r, o, i = a.createElement("canvas"),
                    p = i.getContext && i.getContext("2d");

                function s(e, t) {
                    var a = String.fromCharCode;
                    p.clearRect(0, 0, i.width, i.height), p.fillText(a.apply(this, e), 0, 0);
                    e = i.toDataURL();
                    return p.clearRect(0, 0, i.width, i.height), p.fillText(a.apply(this, t), 0, 0), e === i.toDataURL()
                }

                function c(e) {
                    var t = a.createElement("script");
                    t.src = e, t.defer = t.type = "text/javascript", a.getElementsByTagName("head")[0].appendChild(t)
                }
                for (o = Array("flag", "emoji"), t.supports = {
                        everything: !0,
                        everythingExceptFlag: !0
                    }, r = 0; r < o.length; r++) t.supports[o[r]] = function(e) {
                    if (!p || !p.fillText) return !1;
                    switch (p.textBaseline = "top", p.font = "600 32px Arial", e) {
                        case "flag":
                            return s([55356, 56826, 55356, 56819], [55356, 56826, 8203, 55356, 56819]) ? !1 : !s([55356, 57332, 56128, 56423, 56128, 56418, 56128, 56421, 56128, 56430, 56128, 56423, 56128, 56447], [55356, 57332, 8203, 56128, 56423, 8203, 56128, 56418, 8203, 56128, 56421, 8203, 56128, 56430, 8203, 56128, 56423, 8203, 56128, 56447]);
                        case "emoji":
                            return !s([55358, 56760, 9792, 65039], [55358, 56760, 8203, 9792, 65039])
                    }
                    return !1
                }(o[r]), t.supports.everything = t.supports.everything && t.supports[o[r]], "flag" !== o[r] && (t.supports.everythingExceptFlag = t.supports.everythingExceptFlag && t.supports[o[r]]);
                t.supports.everythingExceptFlag = t.supports.everythingExceptFlag && !t.supports.flag, t.DOMReady = !1, t.readyCallback = function() {
                    t.DOMReady = !0
                }, t.supports.everything || (n = function() {
                    t.readyCallback()
                }, a.addEventListener ? (a.addEventListener("DOMContentLoaded", n, !1), e.addEventListener("load", n, !1)) : (e.attachEvent("onload", n), a.attachEvent("onreadystatechange", function() {
                    "complete" === a.readyState && t.readyCallback()
                })), (n = t.source || {}).concatemoji ? c(n.concatemoji) : n.wpemoji && n.twemoji && (c(n.twemoji), c(n.wpemoji)))
            }(window, document, window._wpemojiSettings);
        </script>
        <style type="text/css">
            img.wp-smiley,
            img.emoji {
                display: inline !important;
                border: none !important;
                box-shadow: none !important;
                height: 1em !important;
                width: 1em !important;
                margin: 0 .07em !important;
                vertical-align: -0.1em !important;
                background: none !important;
                padding: 0 !important;
            }
        </style>
        <link rel='stylesheet' id='contact-form-7-css' href='https://www.wdi.co.th/wp-content/plugins/contact-form-7/includes/css/styles.css?ver=5.0.2' type='text/css' media='all' />
        <link rel='stylesheet' id='rs-plugin-settings-css' href='https://www.wdi.co.th/wp-content/plugins/revslider/public/assets/css/settings.css?ver=5.2.5.1' type='text/css' media='all' />
        <style id='rs-plugin-settings-inline-css' type='text/css'>
            #rs-demo-id {}
        </style>
        <link rel='stylesheet' id='woocommerce-layout-css' href='https://www.wdi.co.th/wp-content/plugins/woocommerce/assets/css/woocommerce-layout.css?ver=3.4.8' type='text/css' media='all' />
        <link rel='stylesheet' id='woocommerce-smallscreen-css' href='https://www.wdi.co.th/wp-content/plugins/woocommerce/assets/css/woocommerce-smallscreen.css?ver=3.4.8' type='text/css' media='only screen and (max-width: 768px)' />
        <link rel='stylesheet' id='woocommerce-general-css' href='https://www.wdi.co.th/wp-content/plugins/woocommerce/assets/css/woocommerce.css?ver=3.4.8' type='text/css' media='all' />
        <style id='woocommerce-inline-inline-css' type='text/css'>
            .woocommerce form .form-row .required {
                visibility: visible;
            }
        </style>
        <link rel='stylesheet' id='wpsl-styles-css' href='https://www.wdi.co.th/wp-content/plugins/wp-store-locator/css/styles.min.css?ver=2.2.15' type='text/css' media='all' />
        <link rel='stylesheet' id='wpfront-scroll-top-css' href='https://www.wdi.co.th/wp-content/plugins/wpfront-scroll-top/css/wpfront-scroll-top.min.css?ver=2.0.1' type='text/css' media='all' />
        <link rel="stylesheet" href="\wdi\www.wdi.co.th\wp-content\themes\wdi\css\bootstrap.min.css" type="text/css" media="all" />
        <link rel="stylesheet" href="\wdi\www.wdi.co.th\wp-content\themes\wdi\style.css" type="text/css" media="all" />
        <link rel='stylesheet' id='font-awesome-css' href='https://www.wdi.co.th/wp-content/themes/wdi/css/font-awesome.min.css?ver=9a30e44c1415efb53499654793754fec' type='text/css' media='all' />
        <link rel='stylesheet' id='googleFonts-css' href='https://fonts.googleapis.com/css?family=Play%3A400%2C700&#038;ver=9a30e44c1415efb53499654793754fec' type='text/css' media='all' />
        <script type='text/javascript' src='https://www.wdi.co.th/wp-includes/js/jquery/jquery.js?ver=1.12.4'></script>
        <script type='text/javascript' src='https://www.wdi.co.th/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.4.1'></script>
        <script type='text/javascript' src='https://www.wdi.co.th/wp-content/plugins/revslider/public/assets/js/jquery.themepunch.tools.min.js?ver=5.2.5.1'></script>
        <script type='text/javascript' src='https://www.wdi.co.th/wp-content/plugins/revslider/public/assets/js/jquery.themepunch.revolution.min.js?ver=5.2.5.1'></script>
        <script type='text/javascript' src='https://www.wdi.co.th/wp-content/themes/wdi/js/bootstrap.js?ver=1'></script>
        <script type='text/javascript' src='https://www.wdi.co.th/wp-content/themes/wdi/js/functions.js?ver=1'></script>
        <link rel='https://api.w.org/' href='https://www.wdi.co.th/th/wp-json/' />
        <link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://www.wdi.co.th/xmlrpc.php?rsd" />
        <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="https://www.wdi.co.th/wp-includes/wlwmanifest.xml" />

        <style type="text/css">
            .qtranxs_flag_en {
                background-image: url(http://wdi-th.com/wp-content/plugins/qtranslate-x/flags/gb.png);
                background-repeat: no-repeat;
            }

            .qtranxs_flag_TH {
                background-image: url(http://wdi-th.com/wp-content/plugins/qtranslate-x/flags/th.png);
                background-repeat: no-repeat;
            }
        </style>
        <link hreflang="en" href="https://www.wdi.co.th/en/product-category/led-lamps/led-interior-lamps/" rel="alternate" />
        <link hreflang="th" href="https://www.wdi.co.th/th/product-category/led-lamps/led-interior-lamps/" rel="alternate" />
        <link hreflang="x-default" href="https://www.wdi.co.th/product-category/led-lamps/led-interior-lamps/" rel="alternate" />
        <meta name="generator" content="qTranslate-X 3.4.6.8" />
        <noscript>
            <style>
                .woocommerce-product-gallery {
                    opacity: 1 !important;
                }
            </style>
        </noscript>
        <meta name="generator" content="Powered by Slider Revolution 5.2.5.1 - responsive, Mobile-Friendly Slider Plugin for WordPress with comfortable drag and drop interface." />
        <link rel="icon" href="https://www.wdi.co.th/wp-content/uploads/2015/09/cropped-WDI_siteicon_512-150x150.png" sizes="32x32" />
        <link rel="icon" href="https://www.wdi.co.th/wp-content/uploads/2015/09/cropped-WDI_siteicon_512-300x300.png" sizes="192x192" />
        <link rel="apple-touch-icon-precomposed" href="https://www.wdi.co.th/wp-content/uploads/2015/09/cropped-WDI_siteicon_512-300x300.png" />
        <meta name="msapplication-TileImage" content="https://www.wdi.co.th/wp-content/uploads/2015/09/cropped-WDI_siteicon_512-300x300.png" />

    </head>

    <body class="archive tax-product_cat term-led-interior-lamps term-9 woocommerce woocommerce-page woocommerce-no-js">
    <?php require '../nav-bar.php'; ?>

        <div id="main" class="site-main">
            <div class="container product-cat-container">
            <?php require 'manu-product.php'; ?>

                <div class="col-lg-10 col-md-9 col-sm-8 col-xs-12">
                    <div id="primary" class="content-area">
                        <main id="main" class="site-main" role="main">
                            <nav class="woocommerce-breadcrumb"><a href="#">Home</a>&nbsp;&#47;&nbsp;<a href="#">สินค้า</a>&nbsp;&#47;&nbsp;<a href="#">LED Lamps</a>&nbsp;&#47;&nbsp;<?php echo htmlspecialchars($category_detail); ?></nav>
                            
                                                        
                            <?php
                            $has_replacement = $result_replacement_parts && $result_replacement_parts->num_rows > 0;
                            $has_car_brand_input = $result_car_brand_input && $result_car_brand_input->num_rows > 0;
                            $has_accessories01 = $result01 && $result01->num_rows > 0;
                            $has_accessories02 = $result02 && $result02->num_rows > 0;
                            ?>

                            <ul class="product-catalog">
                                <?php
                                if ($has_replacement) {
                                    while ($row = $result_replacement_parts->fetch_assoc()) {
                                        $car_brand_input = htmlspecialchars($row['car_brand_input']);
                                        $category = htmlspecialchars($row['category']);
                                        echo "<li class='post-product'>";
                                        echo "<a href='./product-led-lamps.php?car_brand_input=" . urlencode($car_brand_input) . "&category01=" . urlencode($category) . "'>";
                                        echo "<h4>" . htmlspecialchars($row['car_brand_input']) . "</h4>";
                                        echo "<div class='product-catalog-image'>";
                                        $img = $row['car_image_upload_brand'];
                                        $img_src = strpos($img, 'http') === 0 ? $img : "../adminkit-dev/static/" . htmlspecialchars($img);
                                        echo "<img src='{$img_src}' width='300' height='225' />";
                                        echo "</div></a></li>";
                                    }
                                }
                                ?>
                            </ul>

                            <ul class="product-catalog">
                                <?php
                                if ($has_car_brand_input) {
                                    while ($row = $result_car_brand_input->fetch_assoc()) {
                                        $car_model_input = htmlspecialchars($row['car_model_input']);
                                        echo "<li class='post-product'>";
                                        echo "<a href='./product-led-lamps.php?car_model_input={$car_model_input}'>";
                                        echo "<h4>" . htmlspecialchars($row['car_model_input']) . "</h4>";
                                        echo "<div class='product-catalog-image'>";
                                        $img = $row['car_image_upload'];
                                        $img_src = strpos($img, 'http') === 0 ? $img : "../adminkit-dev/static/" . htmlspecialchars($img);
                                        echo "<img src='{$img_src}' width='300' height='225' />";
                                        echo "</div></a></li>";
                                    }
                                }
                                ?>
                            </ul>
                            <ul class="product-catalog">
                                <?php
                                if ($has_accessories01) {
                                    while ($row = $result01->fetch_assoc()) {
                                        $product_id = htmlspecialchars($row['product_id']);
                                        echo "<li class='post-product'>";
                                        echo "<a href='./view-product.php?product_id={$product_id}'>";
                                        echo "<h4>" . htmlspecialchars($row['product_name']) . "</h4>";
                                        echo "<div class='product-catalog-image'>";
                                        $img = $row['image_path'];
                                        $img_src = strpos($img, 'http') === 0 ? $img : "../adminkit-dev/static/" . htmlspecialchars($img);
                                        echo "<img src='{$img_src}' width='300' height='225' />";
                                        echo "</div></a></li>";
                                    }
                                }
                                ?>
                            </ul>

                            <ul class="product-catalog">
                                <?php
                                if ($has_accessories02) {
                                    while ($row = $result02->fetch_assoc()) {
                                        $product_id = htmlspecialchars($row['product_id']);
                                        echo "<li class='post-product'>";
                                        echo "<a href='./view-product.php?product_id={$product_id}'>";
                                        echo "<h4>" . htmlspecialchars($row['product_name']) . "</h4>";
                                        echo "<div class='product-catalog-image'>";
                                        $img = $row['image_path'];
                                        $img_src = strpos($img, 'http') === 0 ? $img : "../adminkit-dev/static/" . htmlspecialchars($img);
                                        echo "<img src='{$img_src}' width='300' height='225' />";
                                        echo "</div></a></li>";
                                    }
                                }
                                ?>
                            </ul>

                            <?php
                            // ถ้าไม่มีสินค้าเลยทั้ง 2 กลุ่ม ให้แสดงข้อความนี้
                            if (!$has_replacement && !$has_accessories01 && !$has_accessories02 && !$has_car_brand_input) {
                                echo "<ul class='product-catalog'><li>No products found for this category detail.</li></ul>";
                            }
                            ?>

                        </main>
                    </div>
                </div>
            </div>
        </div>
        <!-- #main -->
        <?php require '../footer-page.php'; ?>


        <div id="wpfront-scroll-top-container">
            <img src="https://www.wdi.co.th/wp-content/plugins/wpfront-scroll-top/images/icons/1.png" alt="" />
        </div>
        <script type="text/javascript">
            function wpfront_scroll_top_init() {
                if (typeof wpfront_scroll_top == "function" && typeof jQuery !== "undefined") {
                    wpfront_scroll_top({
                        "scroll_offset": 100,
                        "button_width": 0,
                        "button_height": 0,
                        "button_opacity": 0.8,
                        "button_fade_duration": 200,
                        "scroll_duration": 400,
                        "location": 1,
                        "marginX": 20,
                        "marginY": 20,
                        "hide_iframe": false,
                        "auto_hide": false,
                        "auto_hide_after": 2,
                        "button_action": "top",
                        "button_action_element_selector": "",
                        "button_action_container_selector": "html, body",
                        "button_action_element_offset": 0
                    });
                } else {
                    setTimeout(wpfront_scroll_top_init, 100);
                }
            }
            wpfront_scroll_top_init();
        </script>
        <script type="application/ld+json">
            {
                "@context": "https:\/\/schema.org\/",
                "@type": "BreadcrumbList",
                "itemListElement": [{
                    "@type": "ListItem",
                    "position": "1",
                    "item": {
                        "name": "Home",
                        "@id": "https:\/\/www.wdi.co.th\/th"
                    }
                }, {
                    "@type": "ListItem",
                    "position": "2",
                    "item": {
                        "name": "\u0e2a\u0e34\u0e19\u0e04\u0e49\u0e32",
                        "@id": "https:\/\/www.wdi.co.th\/th\/products\/"
                    }
                }, {
                    "@type": "ListItem",
                    "position": "3",
                    "item": {
                        "name": "LED Lamps",
                        "@id": "https:\/\/www.wdi.co.th\/th\/product-category\/led-lamps\/"
                    }
                }, {
                    "@type": "ListItem",
                    "position": "4",
                    "item": {
                        "name": "LED Interior Lamps"
                    }
                }]
            }
        </script>
        <script type="text/javascript">
            var c = document.body.className;
            c = c.replace(/woocommerce-no-js/, 'woocommerce-js');
            document.body.className = c;
        </script>
        <script type='text/javascript'>
            /* <![CDATA[ */
            var wpcf7 = {
                "apiSettings": {
                    "root": "https:\/\/www.wdi.co.th\/th\/wp-json\/contact-form-7\/v1",
                    "namespace": "contact-form-7\/v1"
                },
                "recaptcha": {
                    "messages": {
                        "empty": "Please verify that you are not a robot."
                    }
                }
            };
            /* ]]> */
        </script>
        <script type='text/javascript' src='https://www.wdi.co.th/wp-content/plugins/contact-form-7/includes/js/scripts.js?ver=5.0.2'></script>
        <script type='text/javascript'>
            /* <![CDATA[ */
            var wc_add_to_cart_params = {
                "ajax_url": "\/wp-admin\/admin-ajax.php",
                "wc_ajax_url": "\/th\/?wc-ajax=%%endpoint%%",
                "i18n_view_cart": "View cart",
                "cart_url": "https:\/\/www.wdi.co.th\/th\/inquiry\/",
                "is_cart": "",
                "cart_redirect_after_add": "no"
            };
            /* ]]> */
        </script>
        <script type='text/javascript' src='https://www.wdi.co.th/wp-content/plugins/woocommerce/assets/js/frontend/add-to-cart.min.js?ver=3.4.8'></script>
        <script type='text/javascript' src='https://www.wdi.co.th/wp-content/plugins/woocommerce/assets/js/jquery-blockui/jquery.blockUI.min.js?ver=2.70'></script>
        <script type='text/javascript' src='https://www.wdi.co.th/wp-content/plugins/woocommerce/assets/js/js-cookie/js.cookie.min.js?ver=2.1.4'></script>
        <script type='text/javascript'>
            /* <![CDATA[ */
            var woocommerce_params = {
                "ajax_url": "\/wp-admin\/admin-ajax.php",
                "wc_ajax_url": "\/th\/?wc-ajax=%%endpoint%%"
            };
            /* ]]> */
        </script>
        <script type='text/javascript' src='https://www.wdi.co.th/wp-content/plugins/woocommerce/assets/js/frontend/woocommerce.min.js?ver=3.4.8'></script>
        <script type='text/javascript'>
            /* <![CDATA[ */
            var wc_cart_fragments_params = {
                "ajax_url": "\/wp-admin\/admin-ajax.php",
                "wc_ajax_url": "\/th\/?wc-ajax=%%endpoint%%",
                "cart_hash_key": "wc_cart_hash_fefb973b518d4142c80e8330e94cdb98",
                "fragment_name": "wc_fragments_fefb973b518d4142c80e8330e94cdb98"
            };
            /* ]]> */
        </script>
        <script type='text/javascript' src='https://www.wdi.co.th/wp-content/plugins/woocommerce/assets/js/frontend/cart-fragments.min.js?ver=3.4.8'></script>
        <script type='text/javascript' src='https://www.wdi.co.th/wp-content/plugins/wpfront-scroll-top/js/wpfront-scroll-top.min.js?ver=2.0.1'></script>
        <script type='text/javascript' src='https://www.wdi.co.th/wp-includes/js/wp-embed.min.js?ver=9a30e44c1415efb53499654793754fec'></script>
    </body>

    </html>
