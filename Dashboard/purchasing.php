<?php
include("../conn.php");
session_start();


// Retrieve user data from the session
$userId = $_SESSION["user_id"];
$lastName = $_SESSION["user_lastname"];
$givenName = $_SESSION["user_givenname"];
$position = $_SESSION["user_position"];

$date = date("Y-m-d");
$daily = $conn->query("SELECT * FROM tblsales where daily='$date'");
$total = $conn->query("SELECT * FROM tblsales");
$prod = $conn->query("SELECT * FROM tblstock");
if(mysqli_num_rows($daily) == 0){
    $Unit = 0;
    $Sold = 0;
}else{
    $Unit = 0;
    $Sold = 0;
    while($row=$daily->fetch_assoc()){
        $Unit += $row["quan"];
        $Sold += $row["tprice"];
    }
}
if(mysqli_num_rows($total) == 0){
    $TUnit = 0;
    $TSold = 0;
}else{
    $TUnit = 0;
    $TSold = 0;
    while($cow=$total->fetch_assoc()){
        $TUnit += $cow["quan"];
        $TSold += $cow["tprice"];
    }
}
$Tprod = mysqli_num_rows($prod);

?>
<?PHP
if($_SESSION["user_position"]!="Purchasing Officer"){
    header("location:../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body{
            background: #dde1e7
        }
        li::marker{
            color: #212529;
        }
        .profile-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            box-shadow: -5px -5px 9px rgba(255,255,255,0.45), 5px 5px 9px rgba(94,104,121,0.3);
        }
        .icon-100 {
            font-size: 70px; 
        }
        .icon-200 {
            font-size: 200px; 
        }
        .icon-300 { 
            font-size: 300px; 
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Offcanvas Navigation -->
        <div class="offcanvas offcanvas-start bg-dark text-light" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title text-light" id="offcanvasNavbarLabel"><?PHP echo "$givenName ($position)"; ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <i class="bi bi-speedometer2"></i>
                        <a href="purchasing.php" class="btn py-4 d-inline-flex rounded text-light">
                            <b>Dashboard</b>
                        </a>
                    </li>
                    <li class="nav-item">
                    <i class="bi bi-card-list"></i>
                        <a href="../Inventory/delivery/delivery.php" class="btn py-4 d-inline-flex rounded text-light">
                            <b>Inventory</b>
                        </a>
                    </li>
                    <li class="nav-item">
                    <i class="bi bi-envelope-plus-fill"></i>
                        <button class="btn py-4 dropdown-toggle rounded text-light" data-bs-toggle="collapse" data-bs-target="#report-collapse" aria-expanded="true" aria-current="true">
                            <b>Purchasing</b>
                        </button>
                        <div class="collapse" id="report-collapse">
                            <ul class="list-styled fw-normal pb-1 small">
                                <li><a href="../Inventory/purchasing/purchase_request.php" class="btn rounded text-light">Purchase Requests</a></li>
                                <li><a href="../Inventory/purchasing/purchase_order.php" class="btn rounded text-light">Purchase Order</a></li>
                                <li><a href="../Inventory/purchasing/account_payable.php" class="btn rounded text-light">Account Payable</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light w-100">
            <!-- Toggle Button -->
            <button class="btn btn-outline-secondary mx-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <i class="bi bi-list"></i> Menu
            </button>

            <!-- Logo -->
            <a class="navbar-brand" href="purchasing.php">
            Promeat Products
            </a>

            <!-- User Dropdown -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown mx-4">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="../Account/profile.php">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../index.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
    <!-- DATA -->
    <div class="container">
        <div class="row">
            <div class="col mt-3" style="height: 100px;">
                <div class="row gx-5">
                    <div class="col row rounded mx-2 profile-container" style="padding: 0;">
                        <div class="col col-1 rounded-start bg-danger" style="width: 10px;"></div>
                        <div class="col col-3"><i class="bi bi-cart-check icon-100"></i></div>
                        <div class="col"><h5>Today Unit Sold:<br><?PHP echo $Unit?></h5><small class="text-secondary">Total Unit Sold:<br><?PHP echo $TUnit?></small></div>
                    </div>
                    <div class="col row mx-2 rounded profile-container" style="padding: 0;">
                        <div class="col col-1 rounded-start bg-primary" style="width: 10px;"></div>
                        <div class="col col-3"><i class="bi bi-graph-up-arrow icon-100"></i></div>
                        <div class="col"><h5>Today Sales:<br>₱ <?PHP echo $Sold?></h5><small class="text-secondary">Total Sales:<br>₱ <?PHP echo $TSold?></small></div>
                    </div>
                    <div class="col row mx-2 rounded profile-container" style="padding: 0;">
                        <div class="col col-1 rounded-start bg-success" style="width: 10px;"></div>
                        <div class="col col-3"><i class="bi bi-dropbox icon-100"></i></div>
                        <div class="col mt-1" ><h5>Total Products:<br><?PHP echo $Tprod?></h5></div>                        
                    </div>
                </div>
            </div>
            <div class="w-100"></div>
<!-- IFRAME -->
            <div class="col profile-container my-3">
                <div>
                    <h5>Search Data</h5>
                    <form action="Charts/totalsales.php" method="get" target="chart">
                        <input type="date" class="border-1 rounded" name='date' value="<?PHP echo date('Y-m-d') ?>" style="width: 170px; height: 37px;">
                        <input type="submit" name="search" value="Search" class="btn btn-secondary mb-1">
                    </form>
                    <iframe src="Charts/totalsales.php" frameborder="0" height="350" name="chart" class="rounded" width="100%"></iframe>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>