<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/ui-history.php" />

	<title>Buttons | AdminKit Demo</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
		<?php require 'dashboard.php'; ?>


		<div class="main">
			<?php require 'nav-profile.php'; ?>


			<main class="content">
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3">All Orders</h1>
					<div class="row">
						<!-- กล่องแสดงสินค้าทั้งหมด -->
						<div class="col-md-6">
							<div class="card shadow-sm">
								<div class="card-header bg-primary text-white">
									<h5 class="mb-0"><i class="fa-solid fa-box"></i> All Orders</h5>
								</div>
								<div class="card-body">
									<!-- 🔍 ช่องค้นหา -->
									<input type="text" id="search-history" class="form-control mb-2" placeholder="🔍 ค้นหาออเดอร์...">

									<div class="order-list-history p-0">
										<ul class="list-group list-group-flush">
											<li class="list-group-item text-center text-muted">Loading orders...</li>
										</ul>
									</div>
								</div>
							</div>
						</div>


						<!-- กล่องแสดงรายละเอียดสินค้า -->
						<div class="col-md-6">
							<div class="card shadow-sm">
								<div class="card-header bg-primary text-white">
									<h5 class="mb-0"><i class="fa-solid fa-info-circle"></i> Order Details</h5>
								</div>
								<div class="card-body" id="order-details">
									<p class="text-center text-muted">Select an order to see details.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>


			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>AdminKit</strong></a> - <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>Bootstrap Admin Template</strong></a> &copy;
							</p>
						</div>
						<div class="col-6 text-end">
							<ul class="list-inline">
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Support</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Help Center</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Privacy</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Terms</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="order_manage.js"></script>
	<script src="js/app.js"></script>
</body>

</html>