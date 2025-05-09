<?php
require_once('../php-backend/server.php');
$db = new server();
$ierp = $db->connect_sql();

$sql = "SELECT map_name, map_latitude, map_longitude, map_description FROM stores";
$result = $ierp->query($sql);

$locations = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $locations[] = array(
      'map_name' => $row['map_name'],
      'lat' => floatval($row['map_latitude']),
      'lng' => floatval($row['map_longitude']),
      'map_description' => $row['map_description']
    );
  }
}
$json_locations = json_encode($locations);
?>
<!DOCTYPE html>
<html>
<head>
  <title>แสดงตำแหน่งร้านค้าบนแผนที่ Leaflet</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <!-- Leaflet Routing -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
  <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

  <!-- Geocoder -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
  <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
  <link rel="stylesheet" href="\wdi\www.wdi.co.th\wp-content\themes\wdi\css\bootstrap.min.css" type="text/css" media="all" />
  <link rel="stylesheet" href="\wdi\www.wdi.co.th\wp-content\themes\wdi\style.css" type="text/css" media="all" />
  <style>
  body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f5f7fa;
  }

  #layout-container {
    display: flex;
    height: 100vh;
  }

  #shop-sidebar {
    width: 30%;
    max-width: 400px;
    padding: 20px;
    overflow-y: auto;
    background-color: #ffffff;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
    border-right: 1px solid #e0e0e0;
  }

  #map-area {
    flex: 1;
  }

  .shop-title {
    font-size: 1.5em;
    margin-bottom: 15px;
    color: #333;
  }

  .search-input {
    width: 100%;
    padding: 10px 12px;
    font-size: 1em;
    border: 1px solid #ccc;
    border-radius: 6px;
    margin-bottom: 20px;
  }

  .shop-card {
    background-color: #fafafa;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 12px 16px;
    margin-bottom: 15px;
    transition: all 0.2s ease;
  }

  .shop-card:hover {
    background-color: #f0f8ff;
    border-color: #aaa;
  }

  .shop-card strong {
    font-size: 1.1em;
    color: #222;
  }

  .shop-card p {
    margin: 6px 0;
    color: #555;
    font-size: 0.95em;
  }

  .shop-card .btn {
    margin-top: 10px;
    margin-right: 8px;
    padding: 6px 12px;
    font-size: 0.9em;
    border-radius: 5px;
  }

  .btn-primary {
    background-color: #007bff;
    border: none;
    color: white;
  }

  .btn-outline-primary {
    background-color: white;
    border: 1px solid #007bff;
    color: #007bff;
  }

  .btn-primary:hover, .btn-outline-primary:hover {
    opacity: 0.9;
    cursor: pointer;
  }

  @media (max-width: 768px) {
    #layout-container {
      flex-direction: column;
    }

    #shop-sidebar {
      width: 100%;
      max-width: 100%;
      border-right: none;
      border-bottom: 1px solid #ddd;
    }
  }
  .routing-close-btn {
    position: absolute;
    top: 5px;
    right: 8px;
    background: transparent;
    border: none;
    font-size: 20px;
    font-weight: bold;
    color: #444;
    cursor: pointer;
    z-index: 1000;
  }

  .routing-close-btn:hover {
    color: red;
  }
  
</style>
</head>
<body>
<?php require '../nav-bar.php'; ?>
<div id="main" class="site-main">
  <div class="container product-cat-container">
    <div id="layout-container">
      <div id="shop-sidebar">
        <ul><li><a href="#"> Information</a> </li></ul>
        <ul><li><a href="#"> Distributors</a> </li></ul>
        <h2 class="shop-title">รายการร้านค้า</h2>
        <input type="text" id="searchInput" class="search-input" placeholder="ค้นหาร้าน...">
        <div id="storeList"></div>
      </div>
      <div id="map-area"></div>
    </div>
  </div>
</div>
<?php require '../footer-page.php'; ?>

<script>
  const locations = <?php echo $json_locations; ?>;
  const map = L.map('map-area').setView([13.7563, 100.5018], 10);

  // ───── แสดงแผนที่พื้นฐาน ─────
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  // ───── ตัวแปร Global ───
  let userLatLng = null;
  let userMarker = null;
  let routingControl = null;

  // ───── เลือกตำแหน่งผู้ใช้ ─────
  map.on('click', function (e) {
    userLatLng = e.latlng;

    if (userMarker) {
      userMarker.setLatLng(userLatLng);
    } else {
      userMarker = L.marker(userLatLng, {
        title: "ตำแหน่งของฉัน",
        draggable: true
      }).addTo(map);

      userMarker.bindPopup("คุณเลือกตำแหน่งนี้").openPopup();

      userMarker.on('dragend', function (evt) {
        userLatLng = evt.target.getLatLng();
      });
    }

    map.setView(userLatLng, 14);
  });

  // ───── ปุ่มค้นหา ─────
  L.Control.geocoder({ defaultMarkGeocode: true }).addTo(map);

  // ───── DOM Elements ─────
  const storeListDiv = document.getElementById('storeList');
  const searchInput = document.getElementById('searchInput');

  // ───── แสดงรายการร้านค้า ─────
  function renderStoreList(filter = '') {
    storeListDiv.innerHTML = '';

    const filtered = locations?.filter(loc =>
      loc.map_name.toLowerCase().includes(filter.toLowerCase())
    ) || [];

    if (filtered.length === 0) {
      storeListDiv.innerHTML = '<p style="color: #999;">ไม่พบร้านค้าที่ตรงกับคำค้นหา</p>';
      return;
    }

    filtered.forEach(location => {
      const div = document.createElement('div');
      div.className = 'shop-card';
      div.innerHTML = `
        <strong>${location.map_name}</strong><br>
        <small>${location.map_description}</small><br>
        <button class="btn btn-sm btn-outline-primary mt-2 me-2" onclick="openGoogleMap(${location.lat}, ${location.lng})">ดูบน Google Maps</button>
        <button class="btn btn-sm btn-primary mt-2" onclick="goToStore(${location.lat}, ${location.lng})">นำทาง</button>
      `;
      storeListDiv.appendChild(div);
    });
  }

  // ───── ค้นหาร้าน ─────
  searchInput.addEventListener('input', () => {
    renderStoreList(searchInput.value);
  });

  renderStoreList(); // โหลดรายการเริ่มต้น

  // ───── ปักหมุดร้านค้าบนแผนที่ ─────
  locations?.forEach(location => {
    const marker = L.marker([location.lat, location.lng]).addTo(map);
    marker.bindPopup(`<strong>${location.map_name}</strong><br>${location.map_description}`);
  });

  // ───── เปิด Google Maps ─────
  function openGoogleMap(lat, lng) {
    const url = `https://www.google.com/maps/search/?api=1&query=${lat},${lng}`;
    window.open(url, '_blank');
  }

  // ───── นำทางจากตำแหน่งฉันไปยังร้านค้า ─────
  function goToStore(destLat, destLng) {
    if (!userLatLng) {
      alert("กรุณาคลิกที่แผนที่เพื่อเลือกตำแหน่งของคุณก่อน");
      return;
    }

    if (routingControl) {
      map.removeControl(routingControl);
      routingControl = null;
    }

    routingControl = L.Routing.control({
      waypoints: [
        L.latLng(userLatLng.lat, userLatLng.lng),
        L.latLng(destLat, destLng)
      ],
      routeWhileDragging: false,
      show: true
    }).addTo(map);

    routingControl.on('routesfound', function () {
      setTimeout(() => {
        const container = document.querySelector('.leaflet-routing-container');
        if (container && !container.querySelector('.routing-close-btn')) {
          const closeBtn = document.createElement('button');
          closeBtn.innerHTML = '×';
          closeBtn.className = 'routing-close-btn';
          closeBtn.onclick = () => {
            map.removeControl(routingControl);
            routingControl = null;
          };
          container.appendChild(closeBtn);
        }
      }, 50);
    });
  }
</script>



</body>
</html>
