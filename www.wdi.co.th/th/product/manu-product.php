<div class="sidebar-cat col-lg-2 col-md-2 col-sm-2 hidden-xs">
    <ul>
        <?php
        require_once('../php-backend/server.php');
        $db = new server();
        $ierp = $db->connect_sql();

        if ($ierp) {
            // ดึงข้อมูลหมวดหมู่ทั้งหมด
            $sql_category = "SELECT DISTINCT category FROM products";
            $result_category = $ierp->query($sql_category);

            if ($result_category && $result_category->num_rows > 0) {
                $replacementPartsCategory = '';  // ตัวแปรเก็บหมวดหมู่ "Replacement Parts"
                $accessoriesCategory = '';       // ตัวแปรเก็บหมวดหมู่ "Accessories (FITT)"
                
                // แยกหมวดหมู่ตามเงื่อนไข
                while ($row_category = $result_category->fetch_assoc()) {
                    $category_raw = $row_category["category"];
                    $category_url = urlencode($category_raw);
                    $category_display = htmlspecialchars($category_raw);

                    // แยกหมวดหมู่ "Replacement Parts" และ "Accessories (FITT)"
                    if ($category_raw == 'Replacement Parts') {
                        $replacementPartsCategory .= "<li class='cat-item cat-item-299'><a href='product-led-lamps.php?category={$category_url}'>{$category_display}</a>";
                    } elseif ($category_raw == 'Accessories (FITT)') {
                        $accessoriesCategory .= "<li class='cat-item cat-item-299'><a href='product-led-lamps.php?category={$category_url}'>{$category_display}</a>";
                    } else {
                        // แสดงหมวดหมู่อื่นๆ
                        echo "<li class='cat-item cat-item-299'><a href='product-led-lamps.php?category={$category_url}'>{$category_display}</a>";
                    }

                    // ดึงข้อมูล category_detail และแสดง
                    $sql_category_detail = "SELECT DISTINCT category_detail FROM products WHERE category = ?";
                    $stmt = $ierp->prepare($sql_category_detail);
                    $stmt->bind_param("s", $category_raw);
                    $stmt->execute();
                    $result_category_detail = $stmt->get_result();

                    if ($result_category_detail && $result_category_detail->num_rows > 0) {
                        echo "<ul class='children'>";
                        while ($row_category_detail = $result_category_detail->fetch_assoc()) {
                            $category_detail_raw = $row_category_detail["category_detail"];
                            $category_detail_url = urlencode($category_detail_raw);
                            $category_detail_display = htmlspecialchars($category_detail_raw);

                            echo "<li class='cat-item cat-item-300'><a href='product-led-lamps.php?category_detail={$category_detail_url}'>{$category_detail_display}</a></li>";
                        }
                        echo "</ul>";
                    }

                    if ($stmt) $stmt->close();
                    echo "</li>";
                }

                // แสดงหมวดหมู่ "Replacement Parts"
                if ($replacementPartsCategory) {
                    echo "<ul>{$replacementPartsCategory}</ul>";
                }

                // แสดงหมวดหมู่ "Accessories (FITT)"
                if ($accessoriesCategory) {
                    echo "<ul>{$accessoriesCategory}</ul>";
                }

            } else {
                echo "<li>No categories found.</li>";
            }
        } else {
            echo "<li>Database connection error.</li>";
        }
        ?>
    </ul>
</div>
<script>
    // ป้องกันไม่ให้ลิงก์ทำงาน
    $('a').click(function(e) {
        e.preventDefault(); // ป้องกันการคลิกจากลิงก์
    });
</script>
