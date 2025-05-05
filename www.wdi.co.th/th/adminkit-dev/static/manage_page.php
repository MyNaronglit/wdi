<?php
require_once('server.php');
$db = new server();
$ierp = $db->connect_sql();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลจากฟอร์ม
    $userId = trim($_POST['user_id'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $tags = trim($_POST['tags'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $countries = trim($_POST['countries'] ?? '');

    // ตรวจสอบว่าข้อมูลจำเป็นถูกกรอกครบถ้วน
    if (isset($_POST['action']) && $_POST['action'] === 'update' || $_POST['action'] === 'insert') {
        if (!$userId || !$title || !$content || !$username) {
            echo json_encode(["success" => false, "message" => "❌ โปรดกรอกข้อมูลให้ครบถ้วน"]);
            exit;
        }
    }

    // ตรวจสอบหากเป็นการลบข้อมูลไม่จำเป็นต้องมีข้อมูลอื่นๆ เพียงแค่ news_id
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        if (empty($_POST['news_id'])) {
            echo json_encode(["success" => false, "message" => "❌ โปรดระบุ news_id สำหรับการลบ"]);
            exit;
        }
    }

    $imagePath = uploadImage();

    // ดำเนินการตาม action
    if (isset($_POST['action']) && $_POST['action'] == 'update') {
        // อัพเดตข้อมูลข่าว
        $result = updateNews($ierp, $_POST['news_id'], $userId, $title, $content, $username, $countries, $tags, $category, $imagePath);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'delete') {
        // ลบข้อมูลข่าว
        $result = deleteNews($ierp, $_POST['news_id']);
    } else {
        // เพิ่มข้อมูลข่าวใหม่
        $result = insertNews($ierp, $userId, $title, $content, $username, $countries, $tags, $category, $imagePath);
    }

    // ส่งผลลัพธ์กลับในรูปแบบ JSON
    if ($result) {
        if (isset($_POST['action']) && $_POST['action'] == 'delete') {
            echo json_encode(["success" => true, "message" => "✅ ลบข้อมูลข่าวสำเร็จ"]);
        } else {
            echo json_encode(["success" => true, "message" => "✅ การทำงานสำเร็จ"]);
        }
    } else {
        if (isset($_POST['action']) && $_POST['action'] == 'delete') {
            echo json_encode(["success" => false, "message" => "❌ ลบข้อมูลข่าวล้มเหลว"]);
        } else {
            echo json_encode(["success" => false, "message" => "❌ การทำงานล้มเหลว"]);
        }
    }
}


function uploadImage() {
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $imagePath = $uploadDir . basename($_FILES['image']['name']);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            echo "❌ ไม่สามารถอัปโหลดรูปภาพได้";
            exit;
        }
        return $imagePath;
    }
    return null;
}

function insertNews($ierp, $userId, $title, $content, $username, $countries, $tags, $category, $imagePath) {
    $sql = "INSERT INTO news (news_user_id, news_title, news_content, news_author, news_language, news_tags, news_categories, news_image, news_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    return executeQuery($ierp, $sql, 'isssssss', [$userId, $title, $content, $username, $countries, $tags, $category, $imagePath]);
}
function updateNews($ierp, $newsId, $userId, $title, $content, $username, $countries, $tags, $category, $imagePath) {
    // 1. ดึงข้อมูลเดิมจากฐานข้อมูล
    $sqlSelect = "SELECT news_user_id, news_title, news_content, news_author, news_language, news_tags, news_categories, news_image 
                  FROM news WHERE news_id = ?";
    $stmt = $ierp->prepare($sqlSelect);
    
    if (!$stmt) {
        // กรณี prepare ไม่สำเร็จ
        return false;
    }

    $stmt->bind_param('i', $newsId);
    $stmt->execute();

    // ประกาศตัวแปรไว้ก่อนเพื่อให้แน่ใจว่าไม่มี warning
    $oldUserId = $oldTitle = $oldContent = $oldAuthor = $oldLang = $oldTags = $oldCat = $oldImage = null;

    $stmt->bind_result($oldUserId, $oldTitle, $oldContent, $oldAuthor, $oldLang, $oldTags, $oldCat, $oldImage);

    if (!$stmt->fetch()) {
        $stmt->close();
        return false; // ไม่พบข้อมูล
    }
    $stmt->close();

    // 2. ใช้ค่าที่ส่งมาใหม่ ถ้ามี, ถ้าไม่มีใช้ค่าจากฐานข้อมูลเดิม
    $userId = $userId ?: $oldUserId;
    $title = $title ?: $oldTitle;
    $content = $content ?: $oldContent;
    $username = $username ?: $oldAuthor;
    $countries = $countries ?: $oldLang;
    $tags = $tags ?: $oldTags;
    $category = $category ?: $oldCat;
    $imagePath = $imagePath ?: $oldImage;

    // 3. อัปเดตข้อมูล
    $sqlUpdate = "UPDATE news 
                  SET news_user_id = ?, news_title = ?, news_content = ?, news_author = ?, 
                      news_language = ?, news_tags = ?, news_categories = ?, news_image = ?, news_date = NOW() 
                  WHERE news_id = ?";
    return executeQuery($ierp, $sqlUpdate, 'isssssssi', [
        $userId, $title, $content, $username,
        $countries, $tags, $category, $imagePath,
        $newsId
    ]);
}


function deleteNews($ierp, $newsId) {
    $sql = "DELETE FROM news WHERE news_id = ?";
    return executeQuery($ierp, $sql, 'i', [$newsId]);
}

function executeQuery($ierp, $sql, $types, $params) {
    $stmt = $ierp->prepare($sql);
    if (!$stmt) {
        echo "❌ เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $ierp->error;
        return false;
    }

    $stmt->bind_param($types, ...$params);

    $result = $stmt->execute();
    $stmt->close();
    return $result;
}
?>
