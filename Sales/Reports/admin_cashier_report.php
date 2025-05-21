<?php
session_start();
include("../../conn.php");



// Retrieve user data from the session
$userId = $_SESSION["user_id"];
$lastName = $_SESSION["user_lastname"];
$givenName = $_SESSION["user_givenname"];
$position = $_SESSION["user_position"];
?>
<?PHP
if($_SESSION["user_position"]!="Admin"){
    header("location:../../index.php");
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
                        <a href="../../Dashboard/admin.php" class="btn py-4 d-inline-flex rounded text-light">
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
                                <li><a href="../product_infos.php" class="btn rounded text-light">Products Informations</a></li>
                                <li><a href="admin_cashier_report.php" class="btn rounded text-light">Cashier's Report</a></li>
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
                                <li><a href="../../Inventory/users_profile.php" class="btn rounded text-light">User's Profile</a></li>
                                <li><a href="../../Inventory/requests.php" class="btn rounded text-light">Requests</a></li>
                                <li><a href="../../Sales/" class="btn rounded text-light">Delivery</a></li>
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
            <a class="navbar-brand" href="../../Dashboard/admin.php">
            Promeat Products
            </a>

            <!-- User Dropdown -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown mx-4">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="../../Account/profile.php">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../../index.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
    <div class="container-lg py-4">
        <div class="profile-container">
            <h4>Cashiers Report</h4>
            <form action="admin_cashier_report.php" method="get">
                <input type="date" class="border-1 rounded" name='date' value="<?PHP 
                    if(isset($_GET["date"])){
                        echo $_GET["date"];
                    }else{
                        echo date("Y-m-d");
                    } ?>" style="width: 170px; height: 37px;">
                <input type="submit" name="search" value="Search" class="btn btn-secondary mb-1">
            </form>
            <table class="table table-striped">
                <tr><th>Cashier</th><th>Quantity Sold</th><th>Total Sales</th></tr>
                <?PHP
                
                    $acc = $conn->query("select * from tblaccount where fldposition = 'Cashier'");
                    if(mysqli_num_rows($acc) == 0){
                        echo "<tr><th colspan=3 class='text-secondary'><h6>Currently no Report.</h6></th></tr>";
                    }else{
                        while($col=$acc->fetch_assoc()){
                            echo "<tr>
                            <td>$col[fldlastname], $col[fldgivenname]</td>";
                            if(isset($_GET["date"])){
                                $date = $_GET["date"];
                            }else{
                                $date = date("Y-m-d");
                            }        
                            $result = $conn->query("SELECT * FROM tblsales where cashier='$col[fldlastname], $col[fldgivenname]' and daily='$date'");
                            if(mysqli_num_rows($result) == 0){
                                echo "<td colspan=3 class='text-secondary'>Currently no Record.</td></tr>";
                            }else{
                                $quan = 0;
                                $sales = 0;
                                while($row=$result->fetch_assoc()){
                                    $quan += $row["quan"];
                                    $sales += $row["tprice"];
                                }
                                echo "
                                <td>$quan</td>
                                <td>₱$sales</td></tr>";
                            }
                        }
                    }
                    ?>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>