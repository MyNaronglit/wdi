<?php
require_once('server.php');
$db = new server();
$ierp = $db->connect_sql();

// ดึงรายการสินค้า ทั้งการค้นหาและเรียงลำดับ
if (isset($_GET['action']) && $_GET['action'] == 'fetch_orders') {
    $orders = [];

    // ตรวจสอบค่าการค้นหา
    $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
    $searchTermEscaped = mysqli_real_escape_string($ierp, $searchTerm);

    // ตรวจสอบค่าการเรียงลำดับ (ค่าเริ่มต้นเป็น DESC)
    $sortOrder = isset($_GET['sort']) && $_GET['sort'] == 'ASC' ? 'ASC' : 'DESC';

    // คิวรี่ข้อมูลสินค้า
    $queryPending = "SELECT product_id, item_number, product_name, created_at ,category , category_detail
                     FROM products ";

    // ถ้ามีการค้นหา ให้เพิ่มเงื่อนไข
    if (!empty($searchTermEscaped)) {
        $queryPending .= " WHERE product_name LIKE '%$searchTermEscaped%' 
                          OR item_number LIKE '%$searchTermEscaped%' ";
    }

    // เพิ่มเงื่อนไข ORDER BY
    $queryPending .= " ORDER BY created_at $sortOrder ";

    $resultPending = mysqli_query($ierp, $queryPending);

    while ($row = mysqli_fetch_assoc($resultPending)) {
        $orders[] = [
            'product_id'    => $row['product_id'],
            'item_number'   => $row['item_number'],
            'product_name'  => $row['product_name'],
            'created_at'    => $row['created_at'],
            'category'      => $row['category'],
            'category_detail' => $row['category_detail']
        ];
    }

    echo json_encode($orders);
    exit;
}




if (isset($_GET['action']) && $_GET['action'] == 'get_order_details' && isset($_GET['id'])) {
    $product_id = mysqli_real_escape_string($ierp, $_GET['id']);
    $query = "SELECT * FROM products WHERE product_id = '$product_id'";
    $result = mysqli_query($ierp, $query);

    if (!$result || mysqli_num_rows($result) == 0) {
        error_log("Order not found for ID: $product_id"); // Log error
        echo '<p class="text-center text-danger">Order not found.</p>';
        exit;
    }

    $product = mysqli_fetch_assoc($result);
    echo '<div class="product-details">';

    // แสดงรูปภาพถ้ามี
    if (!empty($product['image_path'])) {
        echo '<img src="' . htmlspecialchars($product['image_path']) . '" width="100" height="auto" alt="Product Image">';
    }
    
    // ข้อมูลที่ต้องแสดง
    $fields = [
        'product_id'   => 'Order ID',
        'product_name' => 'Product',
        'item_number'  => 'SKU',
        'description'  => 'Description',
        'status'       => 'Status',
        'created_at'   => 'Created At'
    ];
    
    // วนลูปแสดงข้อมูลเฉพาะที่มีค่า
    foreach ($fields as $key => $label) {
        if (!empty($product[$key])) {
            echo '<p><strong>' . $label . ':</strong> ' . htmlspecialchars($product[$key]) . '</p>';
        }
    }
    
    // ปุ่ม Edit และ Delete
    echo '
        <button class="btn btn-info edit-product" data-product_id="' . htmlspecialchars($product['product_id']) . '">Edit</button>
        <button class="btn btn-danger delete-product" data-product_id="' . htmlspecialchars($product['product_id']) . '">✖ Delete</button>
    </div>';

    exit;
}


// อัปเดตสถานะออเดอร์
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_status') {
    $order_id = intval($_POST['order_id']);
    $new_status = trim($_POST['status']); // ตัดช่องว่างด้านหน้า/หลังออก
    $new_status = strtolower($new_status);

    // ตรวจสอบค่าว่าอยู่ใน ENUM หรือไม่
    if (!in_array($new_status, ['pending', 'completed', 'failed'])) {
        echo json_encode(["success" => false, "error" => "Invalid status"]);
        exit;
    }

    // ใช้ Prepared Statement ป้องกัน SQL Injection
    $stmt = $ierp->prepare("UPDATE orders SET payment_status = ? WHERE order_id = ?");
    $stmt->bind_param("si", $new_status, $order_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
    exit;
}
// ดึงข้อมูลสินค้าเพื่อแก้ไข
if (isset($_GET['action']) && $_GET['action'] === 'get_edit_product' && isset($_GET['id'])) {

    $product_id = $_GET['id'];

    $stmt = $ierp->prepare("SELECT * FROM products WHERE product_id = ? LIMIT 1");
    $stmt->bind_param("s", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // ดึง detail images
        $detail_stmt = $ierp->prepare("SELECT detail_img_product FROM detail_img_product WHERE detail_product_id = ?");
        $detail_stmt->bind_param("s", $product_id);
        $detail_stmt->execute();
        $detail_result = $detail_stmt->get_result();

        $detail_images = [];
        while ($detail_row = $detail_result->fetch_assoc()) {
            $detail_images[] = $detail_row['detail_img_product'];
        }

        // ✅ ดึง category ทั้งหมด
        $all_stmt = $ierp->query("SELECT category, category_detail FROM products");
        $all_products = [];
        while ($all_row = $all_stmt->fetch_assoc()) {
            $all_products[] = [
                'category' => $all_row['category'],
                'category_detail' => $all_row['category_detail']
            ];
        }

        echo json_encode([
            'product' => [
                'product_id' => $row['product_id'],
                'product_name' => $row['product_name'],
                'item_number' => $row['item_number'],
                'status' => $row['status'],
                'category' => $row['category'],
                'category_detail' => $row['category_detail'],
                'description' => $row['description'],
                'created_at' => $row['created_at'],
                'image_path' => $row['image_path'],
                'RefID_img' => $row['RefID_img'],
                'Lens' => $row['Lens'],
                'Housing' => $row['Housing'],
                'Voltage' => $row['Voltage'],
                'No_of_LED' => $row['No_of_LED'],
                'product_function' => $row['product_function'],
                'product_func_image' => $row['product_func_image'],
                'detail_images' => $detail_images
            ],
            'all_products' => $all_products // ✅ ส่ง array นี้ไปให้ JS ใช้สร้าง dropdown
        ]);
    } else {
        echo json_encode(["error" => "Product not found"]);
    }

    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_product') {

    // รับค่าจาก AJAX
    $product_id = mysqli_real_escape_string($ierp, $_POST['product_id']);
    $product_name = mysqli_real_escape_string($ierp, $_POST['product_name']);
    $item_number = mysqli_real_escape_string($ierp, $_POST['item_number'] ?? '');
    $status = mysqli_real_escape_string($ierp, $_POST['status']);
    $category = mysqli_real_escape_string($ierp, $_POST['category']);
    $category_detail = mysqli_real_escape_string($ierp, $_POST['category_detail']);
    $description = mysqli_real_escape_string($ierp, $_POST['description']);
    $lens = mysqli_real_escape_string($ierp, $_POST['Lens'] ?? '');
    $housing = mysqli_real_escape_string($ierp, $_POST['Housing'] ?? '');
    $voltage = mysqli_real_escape_string($ierp, $_POST['Voltage'] ?? '');
    $no_of_led = mysqli_real_escape_string($ierp, $_POST['No_of_LED'] ?? '');
    $product_function = mysqli_real_escape_string($ierp, $_POST['product_function'] ?? '');

    // ดึงข้อมูลปัจจุบันจากฐานข้อมูลก่อน
    $query = "SELECT image_path, product_func_image FROM products WHERE product_id = '$product_id' LIMIT 1";
    $result = mysqli_query($ierp, $query);
    $current_data = mysqli_fetch_assoc($result);

    // กำหนดค่าของไฟล์เป็นค่าปัจจุบันในฐานข้อมูล
    $image = $current_data['image_path'];
    $product_func_image = $current_data['product_func_image'];
    
    // ตรวจสอบการอัปโหลดไฟล์หลัก
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; 
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $imageName = basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $imageName;

        // ตรวจสอบและย้ายไฟล์ที่อัปโหลด
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $image = $targetPath; // อัปเดตค่าหากมีการอัปโหลด
        } else {
            echo json_encode(["error" => "Failed to upload main image"]);
            exit;
        }
    }

    // ตรวจสอบการอัปโหลด product_func_image
    if (isset($_FILES['product_func_image']) && $_FILES['product_func_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $imageName = basename($_FILES['product_func_image']['name']);
        $targetPath = $uploadDir . $imageName;
        if (move_uploaded_file($_FILES['product_func_image']['tmp_name'], $targetPath)) {
            $product_func_image = $targetPath; // อัปเดตค่าหากมีการอัปโหลด
            echo "Function image uploaded successfully. Path: " . $product_func_image . "<br>"; // ตรวจสอบ Path
        } else {
            echo json_encode(["error" => "Failed to upload function image"]);
            exit;
        }
    }

    // อัปเดตข้อมูลสินค้า
    $query = "UPDATE products SET
        product_name = '$product_name',
        item_number = '$item_number',
        status = '$status',
        category = '$category',
        category_detail = '$category_detail',
        description = '$description',
        image_path = '$image',
        product_func_image = '$product_func_image',
        Lens = '$lens',
        Housing = '$housing',
        Voltage = '$voltage',
        No_of_LED = '$no_of_led',
        product_function = '$product_function'
        WHERE product_id = '$product_id'";

    if (mysqli_query($ierp, $query)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Failed to update product"]);
    }
    exit;
}




// ... (การเชื่อมต่อฐานข้อมูลของคุณ)

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'add_product') {

    // รับค่าจาก AJAX
    $product_name = mysqli_real_escape_string($ierp, $_POST['product_name']);
    $item_number = mysqli_real_escape_string($ierp, $_POST['item_number']);
    $status = mysqli_real_escape_string($ierp, $_POST['status']);
    $category = mysqli_real_escape_string($ierp, $_POST['category']);
    $description = mysqli_real_escape_string($ierp, $_POST['description']);
    $category_detail = mysqli_real_escape_string($ierp, $_POST['category_detail']);
    $Lens = mysqli_real_escape_string($ierp, $_POST['Lens']);
    $Housing = mysqli_real_escape_string($ierp, $_POST['Housing']);
    $Voltage = mysqli_real_escape_string($ierp, $_POST['Voltage']);
    $No_of_LED = mysqli_real_escape_string($ierp, $_POST['No_of_LED']);
    $product_function = mysqli_real_escape_string($ierp, $_POST['product_function']);
    $car_model_input = mysqli_real_escape_string($ierp, $_POST['car_model_input']);
    $car_brand_input = mysqli_real_escape_string($ierp, $_POST['car_brand_input']);

    $image = null;
    $product_func_image = []; 
    $image_details_paths = [];
    $car_image_upload = [];
    $car_image_upload_brand = [];
    $uniqid = strrev(uniqid());

    // ตรวจสอบการอัปโหลดไฟล์หลัก
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $imageName = basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $imageName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $image = $targetPath;
        } else {
            echo json_encode(["error" => "Failed to upload main image"]);
            exit;
        }
    }

    if (isset($_FILES['product_func_image']) && is_array($_FILES['product_func_image']['tmp_name'])) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
    
        foreach ($_FILES['product_func_image']['tmp_name'] as $i => $tmpName) {
            if ($_FILES['product_func_image']['error'][$i] === UPLOAD_ERR_OK) {
                $imageName = basename($_FILES['product_func_image']['name'][$i]);
                $targetPath = $uploadDir . $imageName;
                if (move_uploaded_file($tmpName, $targetPath)) {
                    $product_func_image[] = $targetPath;
                }
            }
        }
    
        // แปลง array เป็น string แยกด้วยคอมมา
        $product_func_image = implode(',', $product_func_image);
    }
    

        // ตรวจสอบการอัปโหลดไฟล์ car_image_upload
        if (isset($_FILES['car_image_upload']) && $_FILES['car_image_upload']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/'; 
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); 
            }
            $imageName = basename($_FILES['car_image_upload']['name']);
            $targetPath = $uploadDir . $imageName;
            if (move_uploaded_file($_FILES['car_image_upload']['tmp_name'], $targetPath)) {
                $car_image_upload = $targetPath; 
            } else {
                echo json_encode(["error" => "Failed to upload function image"]);
                exit;
            }
        }

        if (isset($_FILES['car_image_upload_brand']) && $_FILES['car_image_upload_brand']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $imageName = basename($_FILES['car_image_upload_brand']['name']);
            $targetPath = $uploadDir . $imageName;
            if (move_uploaded_file($_FILES['car_image_upload_brand']['tmp_name'], $targetPath)) {
                $car_image_upload_brand = $targetPath;
            } else {
                echo json_encode(["error" => "Failed to upload function image"]);
                exit;
            }
        }

    // เพิ่มข้อมูลสินค้าหลัก
    $query = "INSERT INTO products (RefID_img, product_name, item_number, status, category, description, image_path, category_detail, Lens, Housing, Voltage, No_of_LED, product_function, product_func_image , car_model_input , car_brand_input , car_image_upload , car_image_upload_brand)
              VALUES ( '$uniqid', '$product_name', '$item_number', '$status', '$category', '$description', '$image', '$category_detail', '$Lens', '$Housing', '$Voltage', '$No_of_LED', '$product_function', '$product_func_image' , '$car_model_input' , '$car_brand_input' , '$car_image_upload' , '$car_image_upload_brand')";

    if (mysqli_query($ierp, $query)) {
        // ดึง product_id ของสินค้าที่เพิ่งเพิ่ม
        $product_id = mysqli_insert_id($ierp);

        // ตรวจสอบและบันทึกรูปภาพ detail หลายรูป
        if (isset($_FILES['image_details']) && is_array($_FILES['image_details']['error'])) {
            $uploadDir = 'uploads/details/'; // โฟลเดอร์สำหรับเก็บ detail images
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // สร้างโฟลเดอร์หากยังไม่มี
            }

            foreach ($_FILES['image_details']['error'] as $key => $error) {
                if ($error === UPLOAD_ERR_OK) {
                    $imageName = basename($_FILES['image_details']['name'][$key]);
                    $targetPath = $uploadDir . $imageName;

                    if (move_uploaded_file($_FILES['image_details']['tmp_name'][$key], $targetPath)) {
                        $insertDetailQuery = "INSERT INTO detail_img_product (detail_RefID_img, detail_product_id, 	detail_img_product)
                                              VALUES ('$uniqid', '$product_id', '$targetPath')";
                        mysqli_query($ierp, $insertDetailQuery); // ไม่ต้องตรวจสอบ error ตรงนี้ก็ได้ หรือจะทำ log ก็ได้
                    }
                }
            }
        }
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Failed to add product"]);
    }
    exit;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_product') {
    $product_id = mysqli_real_escape_string($ierp, $_POST['product_id']);

    // ดึง path รูปก่อนลบ (หากต้องการลบไฟล์จากโฟลเดอร์จริง)
    $query_img = mysqli_query($ierp, "SELECT image_path, product_func_image FROM products WHERE product_id = '$product_id'");
    $img = mysqli_fetch_assoc($query_img);
    if ($img) {
        if (!empty($img['image_path']) && file_exists($img['image_path'])) {
            unlink($img['image_path']); // ลบรูปหลัก
        }
        if (!empty($img['product_func_image']) && file_exists($img['product_func_image'])) {
            unlink($img['product_func_image']); // ลบรูป function
        }
    }

    // ลบ detail images
    mysqli_query($ierp, "DELETE FROM detail_img_product WHERE detail_product_id = '$product_id'");

    // ลบข้อมูลสินค้า
    $deleteProduct = "DELETE FROM products WHERE product_id = '$product_id'";
    if (mysqli_query($ierp, $deleteProduct)) {
        echo json_encode(["success" => true, "message" => "ลบสินค้าสำเร็จ"]);
    } else {
        echo json_encode(["error" => "ไม่สามารถลบสินค้าได้"]);
    }
    exit;
}

