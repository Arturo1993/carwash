<?php
include ("../head.php");
include("../connect.php");
include("../session_check.php");

if(isset($_POST['g_name']) && $_POST['g_name'] != "" ) {
    $order_query = mysqli_prepare($mysql, "INSERT INTO orders(CarType_id, Branch_id, worker_id, Payment_type, Price,
                                    Time_start, Recivedcrew_id) VALUES(?,?,?,?,?,?,?)") or die(mysqli_error($mysql));

    mysqli_stmt_bind_param($order_query, "sssssss", $_POST['c_type'], $_POST['br_id'], $_POST['g_name'], $_POST['pay'], $_POST['pr'], $_POST['r_time'], $_POST['r_man']);
    if (mysqli_stmt_execute($order_query)) {
        echo "<div class='res'>'ჩაწერა ხოშიანად'</div>";
    } else {
        echo "<div class='res'>'რაღაც ვვერ წერს ჩახედე აბა'</div>";
    }
}


if(isset($_POST['id_of_car_type']) && $_POST['id_of_car_type'] != '') {

    $price_query = mysqli_prepare($mysql, "SELECT Price_value FROM price WHERE car_type_id=?") or die(mysqli_error($mysql));
    mysqli_stmt_bind_param($price_query, "s", $_POST['id_of_car_type']);
    mysqli_stmt_execute($price_query);
    mysqli_stmt_bind_result($price_query, $price);


    if (mysqli_stmt_fetch($price_query)) {
        echo "<div class='res'>".$price."</div>";
    } else {
        echo "<div class='res'>'რაღაც ვვერ წერს ჩახედე აბა'</div>";
    }
}



$branchIdQuery = "SELECT Branchid FROM users WHERE idUsers = ?";
$stmt2 = $mysql->prepare($branchIdQuery);
$stmt2->bind_param("s", $_SESSION['id']);
$stmt2->execute();
$result2 = $stmt2->get_result();
$branchIdArray = $result2->fetch_assoc();



$managQuery = "SELECT name FROM users WHERE Branchid = ?";
$branchIdArray['Branchid'] = 1;
$stmt = $mysql->prepare($managQuery);
$stmt->bind_param("s", $branchIdArray['Branchid']);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {

    //echo $row['name'];

}



?>
<script>
    //როცა ჩაიტვირთება დოკუმენტი გაეშვას ფუნქცია
    $( document ).ready(function() {

        $("#tm_id").on( "click", function() {
            var d = new Date();
            var month = d.getMonth() + 1;
            <?php
                $idate = date("d-m-Y H:i:s");

                $effectiveDate = strtotime("+120 minutes", strtotime($idate));


            ?>
           // alert(d.getDate()+'-'+month+'-'+d.getFullYear()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds());
            //$("#received_time").val(d.getDate()+'-'+month+'-'+d.getFullYear()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds());
            //$("#received_time").val(d.getDate()+'-'+month+'-'+d.getFullYear()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds());
            $("#received_time").val('<?php echo date("Y-m-d H:i:s",$effectiveDate);?>');
        });

        $('#sel1').on("change", function () {
            var id = $(this).val();
            $.ajax({
                //გაგზავნე აჯაქს რიქვესთი branch.php რიქვესტის ტიპი იყოს პოსტი.
                url: 'orders_view.php',
                type: 'POST',
                data: { id_of_car_type: id} ,
                // ეს ცვალდები გაიგზავნოს php ფაილში აჯაქსიდან
                success: function (response) {
                    $("#prc").prop('disabled', false);
                    $("#prc").val($(response).filter('div.res').text());
                }
            });
        });

        $("#tm_id2").on( "click", function() {
            var d = new Date();
            var month = d.getMonth() + 1;
           // alert(d.getDate()+'-'+month+'-'+d.getFullYear()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds());
            //
            //$("#received_time").val(d.getDate()+'-'+month+'-'+d.getFullYear()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds());
            $("#received_time2").val(d.getDate()+'-'+month+'-'+d.getFullYear()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds());
        });
        //დაითრიე HTML ელემენტი რომელსაც აქვს ეს ID. და მაგის დაკლიკებაზე გაუშვი ფუნქცია რომელიც შედის ფუნქციის შიგნით.
        $("#order_add").on( "click", function() {
            var car_type_id = $("#sel1").val();
            var worker = $("#sel2").val();
            var payment = $("#sel3").val();
            var price = $("#prc").val();
            var rec_time = $("#received_time").val();
            var received_manager = $("#rec_mngr_id").val();



            $.ajax({
                //გაგზავნე აჯაქს რიქვესთი branch.php რიქვესტის ტიპი იყოს პოსტი.
                url: 'orders_view.php',
                type: 'POST',
                data: { c_type: car_type_id, g_name: worker, pay: payment, pr: price, r_time: rec_time, r_man: received_manager, br_id: '<?php echo $branchIdArray['Branchid'];?>'} ,
                // ეს ცვალდები გაიგზავნოს php ფაილში აჯაქსიდან
                success: function (response) {
                    alert($(response).filter('div.res').text());
                    $("#sel1").val("");
                    $("#sel2").val("");
                    $("#sel3").val("");
                    $("#prc").val("");
                    $("#received_time").val("");

                }
            });
        });
    });
</script>
<form action="" method="post">
    <div class="col-sm-4">

        <div class="form-group">
            <label>ავტომობილის ტიპი:</label>
            <select class="form-control" id="sel1" required>
                <option id='car_type_opt'></option>
                <?php
                    $car_type_query = mysqli_query($mysql, "SELECT * FROM car_types");
                    while($car_type_array = mysqli_fetch_array($car_type_query)) {
                        echo "<option value='$car_type_array[id]' id='car_type_opt'>$car_type_array[car_type]</option>"; //branch lookup gagrdzeleba
                } ?>
            </select>
        </div>
        <div class="form-group">
            <label>მრეცხავი:</label>
            <select class="form-control" id="sel2" required>
                <option></option>
                <?php
                $workersQuery = mysqli_query($mysql, "SELECT * FROM workers WHERE Branch_id = '".$branchIdArray['Branchid']."'");
                while($workersArray = mysqli_fetch_array($workersQuery)) {
                    echo "<option value='$workersArray[idWorkers]' id='worker_opt'>".$workersArray['Workers_Name'].' '.$workersArray['Worker_Surname']."</option>"; //branch lookup gagrdzeleba
                } ?>
            </select>
        </div>
        <div class="form-group">
            <label>გადახდის ტიპი:</label>
            <select class="form-control" id="sel3" required>
                <option></option>
                <?php
                $paymentQuery = mysqli_query($mysql, "SELECT * FROM payment_type");
                while($paymentArray = mysqli_fetch_array($paymentQuery)) {
                    echo "<option value='$paymentArray[id]' id='payment_opt'>$paymentArray[type]</option>"; //branch lookup gagrdzeleba
                } ?>
            </select>
        </div>
        <div class="form-group">
            <label>ფასი:</label>
            <input type="text" class="form-control" id="prc" disabled>
        </div>
        <div class="form-group">
            <label>შეკვეთის დაწყების დრო:</label>
            <input type="text" class="form-control" id="received_time">
            <input type="button" class="btn btn-default" name="time_sub" id="tm_id" value="დამატება">
        </div>
<!--        <div class="form-group">-->
<!--            <label>შეკვეთის დასრულების დრო:</label>-->
<!--            <input type="text" class="form-control" id="received_time2">-->
<!--            <input type="button" class="btn btn-default" name="time_sub" id="tm_id2" value="დამატება">-->
<!--        </div>-->
        <div class="form-group">
            <label>შეკვეთის მიმღები მენეჯერი:</label>
            <input type="text" class="form-control" id="rec_mngr" value="<?php echo $_SESSION['user'];?>">
            <input type="hidden"  id="rec_mngr_id" value="<?php echo $_SESSION['id'];?>">
        </div>
<!--        <div class="form-group">-->
<!--            <label>შეკვეთის დამსრულებელი მენეჯერი:</label>-->
<!--            <select class="form-control" id="sel4" required>-->
<!--                <option></option>-->
<!--                --><?php
//                    $managQuery = "SELECT idUsers, name FROM users WHERE Branchid = ?";
//                    $stmt = $mysql->prepare($managQuery);
//                    $stmt->bind_param("s", $branchIdArray['Branchid']);
//                    $stmt->execute();
//                    $result = $stmt->get_result();
//
//                    while ($row = $result->fetch_assoc()) {
//
//                        echo "<option value='$row[id]' id='fin_man'>$row[name]</option>";
//
//                    } ?>
<!--            </select>-->
<!--        </div>for edit page-->

        <div align="right">
            <input type="button" class="btn btn-default" name="branch_submit" id="order_add" value="დამატება">
        </div>
    </div>
</form>
<?php
$idate = date("d-m-Y H:i:s");

$effectiveDate = strtotime("+120 minutes", strtotime($idate));

//echo date("Y-m-d H:i:s",$effectiveDate);
//echo date("d-m-Y H:i:s");