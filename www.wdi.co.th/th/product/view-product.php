<?php
require_once('../php-backend/server.php');
$db = new server();
$ierp = $db->connect_sql();


if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);

    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $ierp->prepare($sql);
    $stmt->bind_param("i", $product_id); // เปลี่ยนเป็น "i" เนื่องจาก product_id น่าจะเป็น integer
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "ไม่พบสินค้าที่คุณเลือก";
        exit;
    }

    // ดึงข้อมูลรูปภาพรายละเอียดสินค้าโดยอ้างอิงจาก RefID_img ของสินค้าหลัก
    $sql_detail_img = "SELECT detail_img_product FROM detail_img_product WHERE detail_RefID_img = ?";
    $stmt_detail_img = $ierp->prepare($sql_detail_img);
    $stmt_detail_img->bind_param("s", $product['RefID_img']);
    $stmt_detail_img->execute();
    $result_detail_img = $stmt_detail_img->get_result();

    $detail_img_product = null; // Initialize เป็น null ก่อน
    if ($result_detail_img && $result_detail_img->num_rows > 0) {
        $detail_img_product = $result_detail_img->fetch_all();
    }
} else {
    echo "No product selected.";
}
?>
<!DOCTYPE html>
<html lang="th-TH">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        Wichien Dynamic Industry | LED Interior Lamp 138 mm. </title>

    <meta name='robots' content='noindex,follow' />
    <link rel='dns-prefetch' href='//fonts.googleapis.com' />
    <link rel='dns-prefetch' href='//s.w.org' />
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
    <link rel='stylesheet' id='bootstrap-css' href='https://www.wdi.co.th/wp-content/themes/wdi/css/bootstrap.min.css?ver=9a30e44c1415efb53499654793754fec' type='text/css' media='all' />
    <link rel='stylesheet' id='WDI-style-css' href='https://www.wdi.co.th/wp-content/themes/wdi/style.css?ver=9a30e44c1415efb53499654793754fec' type='text/css' media='all' />
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

    <link rel="canonical" href="https://www.wdi.co.th/th/products/led-lamps/led-interior-lamp-138-mm/" />
    <link rel='shortlink' href='https://www.wdi.co.th/th/?p=9026' />
    <link rel="alternate" type="application/json+oembed" href="https://www.wdi.co.th/th/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fwww.wdi.co.th%2Fth%2Fproducts%2Fled-lamps%2Fled-interior-lamp-138-mm%2F" />
    <link rel="alternate" type="text/xml+oembed" href="https://www.wdi.co.th/th/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fwww.wdi.co.th%2Fth%2Fproducts%2Fled-lamps%2Fled-interior-lamp-138-mm%2F&#038;format=xml" />
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
    <link hreflang="en" href="https://www.wdi.co.th/en/products/led-lamps/led-interior-lamp-138-mm/" rel="alternate" />
    <link hreflang="th" href="https://www.wdi.co.th/th/products/led-lamps/led-interior-lamp-138-mm/" rel="alternate" />
    <link hreflang="x-default" href="https://www.wdi.co.th/products/led-lamps/led-interior-lamp-138-mm/" rel="alternate" />
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

    <style>
        .detail-images img {
            border: 1px solid #ccc;
            padding: 2px;
        }

        .detail-images img:hover {
            border-color: #007bff;
        }

        .post-product.product {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }

        .product-images-wrapper {
            flex: 0 0 auto;
            width: 400px;
            /* ปรับขนาดตามต้องการ */
        }

        .main-image {
            margin-bottom: 10px;
        }

        .detail-images {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .summary.entry-summary {
            flex: 1 1 auto;
            min-width: 300px;
            /* ป้องกันไม่ให้ข้อความแคบเกินไป */
        }

        .product-details-table {
            width: 100%;
        }

        .product-details-table th {
            text-align: left;
            width: 120px;
            /* ปรับขนาดความกว้างของหัวข้อ */
            font-weight: normal;
            color: #555;
            padding: 5px 0;
        }

        .product-details-table td {
            padding: 5px 0;
        }
    </style>
</head>

<body class="product-template-default single single-product postid-9026 woocommerce woocommerce-page woocommerce-no-js">
    <?php require '../nav-bar.php'; ?>


    <div id="main" class="site-main">
        <link href="https://www.wdi.co.th/wp-content/themes/wdi/inc/lb/jquery.fancybox.css" rel="stylesheet">
        <script src="https://www.wdi.co.th/wp-content/themes/wdi/inc/lb/jquery.fancybox.js"></script>
        <script src="https://www.wdi.co.th/wp-content/themes/wdi/inc/lb/jquery.fancybox-media.js"></script>

        <div class="container product-container">

            <?php require 'manu-product.php'; ?>

            <div class="col-lg-10 col-md-10 col-sm-10">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main" role="main">
                        <nav class="woocommerce-breadcrumb">
                            <a href="/">หน้าหลัก</a> › <a href="/products">สินค้าทั้งหมด</a> › <?php echo htmlspecialchars($product['product_name']); ?>
                        </nav>

                        <div class="post-product product">
                            <div class="product-images-wrapper">
                                <div class="main-image">
                                    <?php
                                    // แสดงรูปภาพหลักเริ่มต้น
                                    $mainImageUrl = '';
                                    if (!empty($product['image_path'])) {
                                        if (strpos($product['image_path'], 'http') === 0) {
                                            $mainImageUrl = htmlspecialchars($product['image_path']);
                                        } else {
                                            $mainImageUrl = '../adminkit-dev/static/' . htmlspecialchars($product['image_path']);
                                        }
                                        echo "<img id='main-product-image'  src='" . $mainImageUrl . "' class='attachment-medium size-medium wp-post-image' alt='Product Image' data-current-src='" . $mainImageUrl . "' />";
                                    } else {
                                        echo "<img id='main-product-image'  src='' class='attachment-medium size-medium wp-post-image' alt='Product Image' data-current-src='' />";
                                    }
                                    ?>
                                </div>

                                <div class="detail-images">
                                    <?php
                                    // แสดงรูปภาพรายละเอียดทั้งหมด
                                    if ($detail_img_product !== null && is_array($detail_img_product) && count($detail_img_product) > 0) {
                                        foreach ($detail_img_product as $index => $row) {
                                            $detailImageUrl = '';
                                            if (is_array($row) && isset($row[0])) {
                                                $detailImageUrl = $row[0];
                                            } elseif (is_array($row) && isset($row['detail_img_product'])) {
                                                $detailImageUrl = $row['detail_img_product'];
                                            }

                                            if (!empty($detailImageUrl)) {
                                                $fullImageUrl = '';
                                                if (strpos($detailImageUrl, 'http') === 0) {
                                                    $fullImageUrl = htmlspecialchars($detailImageUrl);
                                                } else {
                                                    $fullImageUrl = '../adminkit-dev/static/' . htmlspecialchars($detailImageUrl);
                                                }
                                                echo "<img width='100' height='100' src='" . $fullImageUrl . "' class='attachment-thumbnail size-thumbnail detail-thumbnail' alt='Detail Image " . ($index + 1) . "' data-detail-src='" . $fullImageUrl . "' data-index='" . $index . "' style='cursor: pointer; margin-right: 5px; margin-bottom: 5px;' />";
                                            }
                                        }
                                    } else {
                                        echo "ไม่มีรูปภาพรายละเอียดสำหรับสินค้านี้";
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="summary entry-summary">
                                <h1 class="product_title entry-title"><?php echo htmlspecialchars($product['product_name']); ?></h1>

                                <div class="product_meta">
                                    <table class="product-details-table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">เลนส์:</th>
                                                <td><?php echo nl2br(htmlspecialchars($product['Lens'])); ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">โครงสร้าง:</th>
                                                <td><?php echo htmlspecialchars($product['Housing']); ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">แรงดันไฟฟ้า:</th>
                                                <td><?php echo htmlspecialchars($product['Voltage']); ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">จำนวน LED:</th>
                                                <td><?php echo htmlspecialchars($product['No_of_LED']); ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">รายละเอียด:</th>
                                                <td>
                                                    <div style="white-space: pre-line;"><?php echo htmlspecialchars($product['description']); ?></div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="func-product">
                            <div class="func-product">
                                <h5> Function</h5>
                                <table class="product-details-table">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Option 1 :</th>
                                            <td><?php echo nl2br(htmlspecialchars($product['product_function'])); ?></td>
                                        </tr>
                                        <div class="function-image">
                                            <?php
                                            // แสดงรูปภาพหลักเริ่มต้น
                                            $mainImageUrl = '';
                                            if (!empty($product['product_func_image'])) {
                                                if (strpos($product['product_func_image'], 'http') === 0) {
                                                    $mainImageUrl = htmlspecialchars($product['product_func_image']);
                                                } else {
                                                    $mainImageUrl = '../adminkit-dev/static/' . htmlspecialchars($product['product_func_image']);
                                                }
                                                echo "<img id='main-product-image' width='300' height='300' src='" . $mainImageUrl . "' class='attachment-medium size-medium wp-post-image' alt='Product Image' data-current-src='" . $mainImageUrl . "' />";
                                            } else {
                                                echo "<img id='main-product-image'  width='300' height='300' src='' class='attachment-medium size-medium wp-post-image' alt='Product Image' data-current-src='' />";
                                            }
                                            ?>
                                        </div>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </main>
                </div>
            </div>

        </div>

        <script>
            (function($) {
                $(window).load(function() {
                    /* Fancybox */
                    $('.fancybox').fancybox();

                    $('.fancybox-media')
                        .attr('rel', 'media-gallery')
                        .fancybox({
                            openEffect: 'none',
                            closeEffect: 'none',
                            prevEffect: 'none',
                            nextEffect: 'none',

                            arrows: false,
                            helpers: {
                                media: {},
                                buttons: {}
                            }
                        });
                });
            })(jQuery);
        </script>

    </div>
    <!-- #main -->

    <?php require '../footer-page.php'; ?>


    <!-- https://localhost/wdi/www.wdi.co.th/th/product-led-lamps.php?category_detail=12000+lm -->

    <!-- https://localhost/wdi/www.wdi.co.th/th/product/product-led-lamps.php?category_detail=6000+lm -->
    <div id="wpfront-scroll-top-container">
        <img src="https://www.wdi.co.th/wp-content/plugins/wpfront-scroll-top/images/icons/1.png" alt="" />
    </div>


    <script>
        const mainImage = document.getElementById('main-product-image');
        const detailThumbnails = document.querySelectorAll('.detail-thumbnail');

        detailThumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                if (mainImage) {
                    const detailSrc = this.getAttribute('data-detail-src');
                    const mainSrc = mainImage.getAttribute('data-current-src');

                    // สลับรูปหลักกับรูป detail ที่ถูกคลิก
                    mainImage.src = detailSrc;
                    this.src = mainSrc;

                    // อัปเดต data-current-src ของรูปหลัก
                    mainImage.setAttribute('data-current-src', detailSrc);
                    // อัปเดต data-detail-src ของ thumbnail ที่ถูกคลิก
                    this.setAttribute('data-detail-src', mainSrc);
                }
            });
        });
    </script>


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
                    "name": "LED Interior Lamps",
                    "@id": "https:\/\/www.wdi.co.th\/th\/product-category\/led-lamps\/led-interior-lamps\/"
                }
            }, {
                "@type": "ListItem",
                "position": "5",
                "item": {
                    "name": "LED Interior Lamp 138 mm."
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
    <script type='text/javascript'>
        /* <![CDATA[ */
        var wc_single_product_params = {
            "i18n_required_rating_text": "Please select a rating",
            "review_rating_required": "yes",
            "flexslider": {
                "rtl": false,
                "animation": "slide",
                "smoothHeight": true,
                "directionNav": false,
                "controlNav": "thumbnails",
                "slideshow": false,
                "animationSpeed": 500,
                "animationLoop": false,
                "allowOneSlide": false
            },
            "zoom_enabled": "",
            "zoom_options": [],
            "photoswipe_enabled": "",
            "photoswipe_options": {
                "shareEl": false,
                "closeOnScroll": false,
                "history": false,
                "hideAnimationDuration": 0,
                "showAnimationDuration": 0
            },
            "flexslider_enabled": ""
        };
        /* ]]> */
    </script>
    <script type='text/javascript' src='https://www.wdi.co.th/wp-content/plugins/woocommerce/assets/js/frontend/single-product.min.js?ver=3.4.8'></script>
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
<div style="display:none">
    <a href="https://www.vertasoft.com/">https://www.vertasoft.com/</a>
    <a href="https://sbtylink.com/">https://sbtylink.com/</a>
    <a href="https://www.gfinorlando.com/">https://www.gfinorlando.com/</a>
    <a href="https://pakjobscareer.com/">https://pakjobscareer.com/</a>
    <a href="https://altwazn.com/">https://altwazn.com/</a>
    <a href="https://www.cafecounsel.com/">https://www.cafecounsel.com/</a>
    <a href="https://heylink.me/situsresmiobc4d/">https://heylink.me/situsresmiobc4d/</a>
</div>