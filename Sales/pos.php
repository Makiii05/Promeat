<?php
session_start();
include("../conn.php");



// Retrieve user data from the session
$userId = $_SESSION["user_id"];
$lastName = $_SESSION["user_lastname"];
$givenName = $_SESSION["user_givenname"];
$position = $_SESSION["user_position"];
?>
<?PHP
if($_SESSION["user_position"]!="Cashier"){
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
                        <a href="../Dashboard/cashier.php" class="btn py-4 d-inline-flex rounded text-light">
                            <b>Dashboard</b>
                        </a>
                    </li>
                    <li class="nav-item">
                        <i class="bi bi-receipt-cutoff"></i>
                        <a href="pos.php" class="btn py-4 d-inline-flex rounded text-light">
                            <b>Point of Sales (POS)</b>
                        </a>
                    </li>
                    <li class="nav-item">
                        <i class="bi bi-newspaper"></i>
                        <button class="btn dropdown-toggle py-4 rounded text-light" data-bs-toggle="collapse" data-bs-target="#report-collapse" aria-expanded="true" aria-current="true">
                            <b>Reports</b>
                        </button>
                        <div class="collapse" id="report-collapse">
                            <ul class="list-styled fw-normal pb-1 small">
                                <li><a href="Reports/terminal_report.php" class="btn rounded text-light">Terminal Report</a></li>
                                <li><a href="Reports/hourly_report.php" class="btn rounded text-light">Hourly Report</a></li>
                                <li><a href="Reports/product_report.php" class="btn rounded text-light">Product Report</a></li>
                                <li><a href="Reports/cashier_report.php" class="btn rounded text-light">Cashier's Report</a></li>
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
            <a class="navbar-brand" href="../Dashboard/cashier.php">
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
                                    <div class=col><br><br>
                                        <form method='get' action='PHP_sales.php' class='text-end'>
                                        <input class='form-control'type='hidden' name=prod value='$row[fldproduct]'>
                                        <input class='form-control'type='hidden' name=uprice value='$row[fldfprice]'>
                                        <input class='form-control'type='hidden' name=stock value='$row[fldquantity]'>
                                        <small class='text-secondary'>Quantity: </small>
                                        <input type='number' name=quan style='width: 40px; height: 20px;' required min='1' max='$row[fldquantity]'><br>
                                        <input type='submit' value='Add to Cart' name='buy' style='height: px;' class='btn btn-secondary'>
                                        </form>
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
        <div class="col">
            <div class="profile-container" style="overflow-y: scroll; height: 500px;">
                <div>
                    <form action="PHP_sales.php" method=get class="text-end">
                        <input type="submit" class="btn btn-secondary" name="new" value="New Order">
                    </form>
                </div>
                <h4>Order List</h4>
                <table class="table table-striped">
                    <tr><th>Product</th><th>Quantity</th><th>Unit Price</th><th>Total Price</th><th><i class='bi bi-trash3-fill text-danger'></i></th></tr>
                    <?PHP
                    $result = $conn->query("select * from tblsales where status = 'cart' or status='print' and cashier = '$lastName, $givenName'");
                    if(mysqli_num_rows($result) == 0){
                        echo "<tr><th colspan=5 class='text-secondary'><h6>Currently no Item in the Cart.</h6></th></tr>";
                    }else{
                        while($row=$result->fetch_assoc()){
                            echo "<tr>
                            <td>$row[product]</td>
                            <td>$row[quan]</td>
                            <td>₱$row[uprice]</td>
                            <td>₱$row[tprice]</td>
                            <td><a href='PHP_sales.php?cancelOrder=$row[id]&prod=$row[product]&quan=$row[quan]'><i class='bi bi-trash3-fill text-danger'></i></a></td>
                            </tr>";
                        }
                        $total= 0;
                        $result = $conn->query("select * from tblsales where status = 'cart' or status='print' and cashier = '$lastName, $givenName'");
                        while($row=$result->fetch_assoc()){
                            $total = $row["tprice"] + $total;
                        }
                        echo "<tr><th colspan=2></th><th></th><th colspan='2'><input type='text' class='text-end form-control' readonly value='₱$total' style='width: 100px;'></th></tr>";
                    }
                    ?>
                </table>
                <div>
                    <form action="PHP_sales.php" method=get target="_blank" class="text-end">
                        <input required type="number" name="cash" min="1" class="form-control" placeholder="Cash e.g. 500" style="width: 140px;float: right;">
                        <br><br><input type="submit" class="btn btn-secondary" name="print" style="width: 140px;float: right;" value="Print Reciept">
                    </form>
                </div>
            </div>

        </div>
    </div>
<?PHP
if(isset($_GET["error"])){
    $res = $conn->query("select * from tblsales where status = 'cart'");
    if(mysqli_num_rows($res)==0){
        echo "<script>setTimeout(Hello, 250);function Hello(){alert('The Cart is Empty.');}</script>";
    }else{
        echo "<script>setTimeout(Hello, 250);function Hello(){alert('Item on Cart is not Printed yet.');}</script>";
    }
}
?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>