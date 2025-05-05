<?php
session_start();
session_destroy(); // ทำลาย session

// ป้องกันแคช
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redirect ไปหน้าแรกแบบไม่สามารถย้อนกลับมาได้
header("Location: /wdi/www.wdi.co.th/th/index.php", true, 302);
exit();
?>
