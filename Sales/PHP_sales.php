<?php
session_start();
include("../conn.php");

if (isset($_POST["toSold"])) {
    $uploadDir = 'productPic/';

    // Create the directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (isset($_FILES["prodpic"]) && $_FILES["prodpic"]["error"] == UPLOAD_ERR_OK) {
        $fileName = $_FILES["prodpic"]["name"];
        $tmpName = $_FILES["prodpic"]["tmp_name"];
        $fileSize = $_FILES["prodpic"]["size"];
        $fileError = $_FILES["prodpic"]["error"];
        $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = array("jpg", "jpeg", "png");

        if (in_array($imageExtension, $allowedExtensions)) {
            if ($fileSize < 5000000) { // 5MB limit
                $newImageName = uniqid() . '.' . $imageExtension;
                $uploadPath = $uploadDir . $newImageName;

                if (move_uploaded_file($tmpName, $uploadPath)) {
                    // Insert data into the database
                    $conn->query("UPDATE tblstock set fldstatus='tosold', fldpicture ='$newImageName', fldfprice='$_POST[fprice]', flddesc='$_POST[desc]' where fldproduct='$_POST[prod]'");
                    header("location:product_infos.php");
                } else {
                    echo "Error uploading the file.";
                }
            } else {
                echo "File size exceeds the limit of 5MB.";
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, and PNG files are allowed.";
        }
    } else {
        echo "Error uploading the file: " . $_FILES["prodpic"]["error"];
    }
}elseif(isset($_GET['buy'])){
    $cashier = "$_SESSION[user_lastname], $_SESSION[user_givenname]";
    $prod = $_GET['prod'];
    $quan = $_GET['quan'];
    $uprice = $_GET['uprice'];
    $tprice = $quan * $uprice;
    $daily = date("Y-m-d");
    date_default_timezone_set("Asia/Manila");
    $hourly = date("H");

    $conn->query("INSERT INTO tblsales (cashier, product, quan, uprice, tprice, status, daily, hourly)
    VALUES ('$cashier','$prod','$quan','$uprice','$tprice','cart','$daily','$hourly')");
    
    $stock = $_GET["stock"] - $quan;
    $conn->query("UPDATE tblstock set fldquantity='$stock' where fldproduct='$prod'");

    $result = $conn->query("SELECT * FROM tblstock where fldproduct='$prod'");
    while($row=$result->fetch_assoc()){
        if($row["fldquantity"]==0){
            $conn->query("UPDATE tblstock set fldstatus='onhold' where fldproduct='$prod'");
        }
    }


    header("location:pos.php");
}elseif(isset($_GET["cancelOrder"])){
    $conn->query("DELETE from tblsales where id='$_GET[cancelOrder]'");
    $prod = $_GET['prod'];
    $result = $conn->query("SELECT * FROM tblstock where fldproduct='$prod'");
    while($row=$result->fetch_assoc()){
        $stock = $_GET["quan"] + $row['fldquantity'];
        $conn->query("UPDATE tblstock set fldstatus='tosold', fldquantity='$stock' where fldproduct='$prod'");
    }
    header("location:pos.php");
}elseif(isset($_GET["new"])){
    $res = $conn->query("select * from tblsales where status = 'print'");
    if(mysqli_num_rows($res)==0){
        header("location:pos.php?error");
    }else{
        $conn->query("UPDATE tblsales set status='sold' where status='print'");
        header("location:pos.php");
    }
}elseif(isset($_GET["print"])){
    $conn->query("UPDATE tblsales set status='print' where status='cart'");
    header("location:../2Print/p_receipt.php?cash=$_GET[cash]&cashier=$_SESSION[user_lastname], $_SESSION[user_givenname]");
}
?>