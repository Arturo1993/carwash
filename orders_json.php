<?php
include("connect.php");
include("session_check_out.php");

if(isset($_POST['l_val']) && $_POST['l_val'] != "") {
    $ordersDetailsQuery = mysqli_prepare($mysql, "SELECT o.idOrders, b.Branch_Name bn, c.car_type ct
                                                    FROM orders o JOIN branch b
                                                    ON o.Branch_id=b.idBranch JOIN car_types c
                                                    ON o.CarType_id=c.id
                                                    WHERE o.license_plate=? AND o.endcrew_id=0")or die( mysqli_error($mysql) );
    mysqli_stmt_bind_param($ordersDetailsQuery, "s", $_POST['l_val']);
    mysqli_stmt_execute($ordersDetailsQuery);
    mysqli_stmt_bind_result($ordersDetailsQuery, $id, $branchName, $carType);
    mysqli_stmt_fetch($ordersDetailsQuery);

    echo json_encode(array("id" => $id, "branch" => $branchName, "car_type" => $carType));
    flush();
}