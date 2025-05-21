<?php
include("../conn.php");
session_start();


// Retrieve user data from the session
$userId = $_SESSION["user_id"];
$lastName = $_SESSION["user_lastname"];
$givenName = $_SESSION["user_givenname"];
$position = $_SESSION["user_position"];
?>
<?PHP
if($_SESSION["user_position"]!="Admin"){
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
                        <a href="../Dashboard/admin.php" class="btn py-4 d-inline-flex rounded text-light">
                            <b>Dashboard</b>
                        </a>
                    </li>
                    <li class="nav-item">
                    <i class="bi bi-shop-window"></i>
                        <button class="btn dropdown-toggle py-4 rounded text-light" data-bs-toggle="collapse" data-bs-target="#sale-collapse" aria-expanded="true" aria-current="true">
                            <b>Sales</b>
                        </button>
                        <div class="collapse" id="sale-collapse">
                            <ul class="list fw-normal pb-1 small">
                                <li><a href="product_infos.php" class="btn rounded text-light">Products Informations</a></li>
                                <li><a href="Reports/admin_cashier_report.php" class="btn rounded text-light">Cashier's Report</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                    <i class="bi bi-card-list"></i>
                        <button class="btn dropdown-toggle rounded py-4 text-light" data-bs-toggle="collapse" data-bs-target="#inventory-collapse" aria-expanded="true" aria-current="true">
                            <b>Inventory</b>
                        </button>
                        <div class="collapse" id="inventory-collapse">
                            <ul class="list fw-normal pb-1 small">
                                <li><a href="../Inventory/users_profile.php" class="btn rounded text-light">User's Profile</a></li>
                                <li><a href="../Inventory/requests.php" class="btn rounded text-light">Requests</a></li>
                                <li><a href="../Inventory/delivery/admin_delivery.php" class="btn rounded text-light">Delivery</a></li>
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
            <a class="navbar-brand" href="../Dashboard/admin.php">
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
    <div class="container-fluid row py-3">
        <div class="col-7">
            <div class="profile-container">
                <h4>Input Product to Sales</h4>
                <form action="PHP_sales.php" method="POST" enctype="multipart/form-data">
                    <div class="container">
                        <div class="row justify-content-center my-2">
                            <div class="form-group px-2">
                                <label for="prod">Product:</label>
                                <select name="prod" id="prod" class="form-select px-2" required>
                                    <?PHP
                                    $result = $conn->query("select * from tblstock where fldstatus = 'onhold'");
                                    if(mysqli_num_rows($result) == 0){
                                        echo "<option value='' disabled selected>All Product are in the List</option>";
                                    }else{
                                        while($row=$result->fetch_assoc()){
                                            if($row["fldquantity"]!=0){
                                                echo "<option value='$row[fldproduct]'>$row[fldproduct]</option>";
                                            }else{
                                                echo "<option value='' disabled selected>All Product are in the List</option>";                                                
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="form-group px-2">
                                    <label for="fprice">Field Price:</label>
                                    <input required name="fprice" type="number" class="form-control" id="fprice">
                                </div>
                                <div class="form-group px-2">
                                    <label for="desc">Description:</label>
                                    <input required name="desc" type="text" class="form-control" id="desc" placeholder="e.g. Kilo per Pack">
                                </div>
                                <label for="pic" class="form-label">Product Picture:</label>
                                <div class="mb-2 px-2 input-group">
                                    <input required name="prodpic" type="file" id="pic" class="form-control" accept=".png, .jpg, .jpeg"/>
                                </div>
                                <div class="mt-2 px-2 text-end">
                                    <button type="submit" class="btn btn-secondary" name="toSold">Add Product</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col">
            <div class="profile-container" style="overflow-y: scroll; height: 500px;">
                <table class="table table-striped">
                    <tr><th colspan="2"><h3>Products Information</h3></th></tr>
                    <?PHP
                    $result = $conn->query("select * from tblstock where fldstatus = 'tosold'");
                    if(mysqli_num_rows($result) == 0){
                        echo "<tr><th><h6 class='text-secondary'>Currently no Product Listed.</h6></th></tr>";
                    }else{
                        while($row=$result->fetch_assoc()){
                            echo "<tr>
                            <th>
                                <div class='row'>
                                    <div class='col col-4  mx-3 my-1 rounded-start-4' style='background-image: url(productPic/$row[fldpicture]); background-size: cover; height:80px; width: 100px;'>
                                    </div>
                                    <div class='col border-start border-dark text-start ps-2 py-1'>
                                        <h5>$row[fldproduct]</h5>
                                        <small class='text-secondary'>₱$row[fldfprice]<br>$row[flddesc]<br>Stock: $row[fldquantity]</small>
                                    </div>
                                </div>
                            </th>
                            </tr>";
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>