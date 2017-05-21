<?php
include ("head_out.php");
include("connect.php");
include("session_check_out.php");

if(isset($_POST['ord_id']) && $_POST['ord_id'] != "" && isset($_POST['fin_time']) && $_POST['fin_time'] != ""
    && isset($_POST['end_crew']) && $_POST['end_crew'] != "") {

    $ordersUpdate = mysqli_prepare($mysql, "UPDATE orders SET Time_end = ?, endcrew_id = ? WHERE idOrders = ?")or die( mysqli_error($mysql) );
    mysqli_stmt_bind_param($ordersUpdate, "ssi", $_POST['fin_time'], $_POST['end_crew'], $_POST['ord_id']);
    if (mysqli_stmt_execute($ordersUpdate)) {
        echo "<div class='res'>'ჩაწერა ხოშიანად'</div>";
    } else {
        echo "<div class='res'>'რაღაც ვვერ წერს ჩახედე აბა'</div>";
    }
}

?>
<script>

    $( document ).ready(function() {

        $("#details").hide();

        $(".lic_val").on( "click", function() {

            var lic_plate = $(this).val();
            var worker = $(this).parent().siblings('#workers').text();
            var car_type = $(this).parent().siblings('#type').text();
            <?php
            $idate = date("d-m-Y H:i:s");

            $effectiveDate = strtotime("+120 minutes", strtotime($idate));

            ?>
            var time = '<?php echo date("Y-m-d H:i:s",$effectiveDate)?>';
            var crew_manager = '<?php echo $_SESSION['name'].' '.$_SESSION['surname']?>';
            var crew_manager_id = '<?php echo $_SESSION['id']?>';

            $.ajax({
                url: 'orders_json.php',
                dataType: 'JSON',
                type: 'POST',
                data: { l_val: lic_plate },
                success: function (response) {
                    $("#main").hide();
                    $("#details").show();

                    var order_id = response.id;

                    var prev = '<div class="col-sm-4"><div class="form-group"> <label>მანქანის ტიპი:</label>\
                                <input type="text" class="form-control" id="w_name" readonly value="'+response.car_type+'"> </div><div class="form-group">\
                                <div class="form-group"> <label>მანქანის ნომერი:</label>\
                                <input type="text" class="form-control" id="w_name" readonly value="'+lic_plate+'"> </div>\
                                <div class="form-group"> <label>მრეცხავი:</label>\
                                <input type="text" class="form-control" id="w_name" readonly value="'+worker+'"> </div>\
                                <div class="form-group"> <label>დასრულების დრო:</label>\
                                <input type="text" class="form-control" id="w_name" readonly value="'+time+'"> </div>\
                                <div class="form-group"> <label>შეკვეთის მიმღები მენეჯერი:</label>\
                                <input type="text" class="form-control" id="w_name" readonly value="'+crew_manager+'"> </div>\
                                <div class="form-group">\
                                <label>ფილიალის სახელი:</label><input type="text" class="form-control" id="w_surname" value="'+response.branch+'" readonly></div>\
                                <div align="right"><input type="button" class="btn btn-success" name="branch_submit" id="order_finish" value="შეკვეთის დასრულება">\
                                </div></div>';
                    var prev2 = '<input type="button" class="btn btn-success" name="branch_submit" value="უკან დაბრუნება" onclick="location.reload()">';

                    $('#details').html(prev);
                    $('#back').html(prev2);

                    $("#order_finish").on( "click", function() {
                        $.ajax({
                            url: 'orders.php',
                            type: 'POST',
                            data: { ord_id: order_id, fin_time: time, end_crew: crew_manager_id },
                            success: function (response) {
                                alert($(response).filter('div.res').text());
                                location.reload(); location;
                            }
                        });
                    });
                }
            });
        });
    });
</script>

<?php

if(!isset($_POST['l_val'])) {
    $ordersQuery = "SELECT o.license_plate lp, b.Branch_Name bn, w.Workers_Name wn, w.Worker_Surname ws, c.car_type ct, u.name un, u.surname us
                        FROM `orders`o JOIN branch b
                        ON o.Branch_id=b.idBranch JOIN workers w
                        ON o.worker_id=w.idWorkers JOIN car_types c
                        ON o.CarType_id=c.id JOIN users u
                        ON o.Recivedcrew_id=u.idUsers
                        WHERE o.Branch_id=? AND o.endcrew_id=0";

    $stmt = $mysql->prepare($ordersQuery);
    $stmt->bind_param("s", $_SESSION['branch_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {

        $lic_plate[] = $row['lp'];
        //$b_name[] = $row['bn'];
        $w_name[] = $row['wn'];
        $w_surname[] = $row['ws'];
        $c_type[] = $row['ct'];
//        $u_name[] = $row['un'];
//        $u_surname[] = $row['us'];
    }
    ?>

    <div align="right" id="back">
    </div>

    <div align="center" id="details">
        <form action="" method="post">

        </form>
    </div>

    <table class="table" id="main">
        <thead>
        <tr>
            <th>მანქანის ტიპი</th>
            <th>მანქანის ნომერი</th>
            <th>მრეცხავის სახელი</th>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i = 0; $i < sizeof($lic_plate); $i++) {
            ?>
            <tr>
                <td id="type"><?= $c_type[$i]; ?></td>
                <td><input type='button' class='btn btn-success lic_val' name='lic' value='<?= $lic_plate[$i]; ?>'/>
                </td>
                <td id='workers'><?= $w_name[$i] . ' ' . $w_surname[$i]; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php
}
?>