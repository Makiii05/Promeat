<?php
include("../../conn.php");
if (isset($_GET["date"])) {
    $date = $_GET["date"];
} else {
    $date = date("Y-m-d");
}

$dataPoints = array();
$prod = $conn->query("SELECT * FROM tblstock");
while ($col = $prod->fetch_assoc()) {
    $total = 0;
    $result = $conn->query("SELECT * FROM tblsales WHERE daily='$date' AND product='$col[fldproduct]'");
    while ($row = $result->fetch_assoc()) {
        $total += $row["tprice"];
    }
    $dataPoints[] = array('y' => $total, 'label' => $col['fldproduct']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        li::marker {
            color: #212529;
        }
    </style>
</head>
<body>
    <div id="chartContainer" style="height: 330px; width: 100%;"></div>
</body>
<script>
    window.onload = function() {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Product Sales Graph on <?php echo $date; ?>"
            },
            axisY: {
                title: "Sales (in Peso)"
            },
            data: [{
                type: "column",
                yValueFormatString: "#,##0.## Peso",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
    }
</script>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</html>