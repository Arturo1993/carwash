<?php
include ("head.php");
include("connect.php");

if(isset($_POST['c_name']) && $_POST['c_name'] != "" && isset($_POST['c_surname']) && $_POST['c_surname'] != "" && isset($_POST['branch_n']) && $_POST['branch_n'] != "") {
    $worker_query = mysqli_prepare($mysql, "INSERT INTO crew_manager(crew_manager_name, crew_manager_surname, Branch_id, date_w) VALUES(?,?,?, NOW())") or die(mysqli_error($mysql));

    mysqli_stmt_bind_param($worker_query, "ssi", $_POST['c_name'], $_POST['c_surname'], $_POST['branch_n']);
    if (mysqli_stmt_execute($worker_query)) {
        echo "<div class='res'>'ჩაწერა ხოშიანად'</div>";
    } else {
        echo "<div class='res'>'რაღაც ვვერ წერს ჩახედე აბა'</div>";
    }
}
$branch_query = mysqli_query($mysql, "SELECT * FROM branch"); //branch lookup

?>
<script>
    //როცა ჩაიტვირთება დოკუმენტი გაეშვას ფუნქცია
    $( document ).ready(function() {
        var branch_name = "";
        $("#sel1").on( "change", function(){
            branch_name = $(this).val();
        });
        //დაითრიე HTML ელემენტი რომელსაც აქვს ეს ID. და მაგის დაკლიკებაზე გაუშვი ფუნქცია რომელიც შედის ფუნქციის შიგნით.
        $("#br_id").on( "click", function() {
            //გამოცხადებულია 2 ცვლადი ბრენჩის სახელი და ბრენჩის მისამართი
            var crew_manager_name = $("#c_name").val();
            var crew_manager_surname = $("#c_surname").val();
            //.val იღებს ინფუთად შეტანილ მნიშვნელობებს b_name ის val ში შეყვანილ მნიშვნელობას
            // და მნიშვნელობას ანიჭებს ჯავასკრიპტში გამოცხადებულ ცვლადს.
            //var branch_phone = $("#b_phone").val();
            $.ajax({
                //გაგზავნე აჯაქს რიქვესთი branch.php რიქვესტის ტიპი იყოს პოსტი.
                url: 'Manage_crew_manager.php',
                type: 'POST',
                data: { c_name: crew_manager_name, c_surname: crew_manager_surname, branch_n: branch_name } ,
                // ეს ცვალდები გაიგზავნოს php ფაილში აჯაქსიდან
                success: function (response) {
                    alert($(response).filter('div.res').text());
                    $("#c_name").val("");
                    $("#c_surname").val("");
                    $("#sel1").val("");
                }
            });
        });
    });
</script>
<form action="" method="post">
    <div class="col-sm-4">

        <div class="form-group">
            <label>მენეჯერის სახელი:</label>
            <input type="text" class="form-control" id="c_name">
        </div>

        <div class="form-group">
            <label>მენეჯერის გვარი:</label>
            <input type="text" class="form-control" id="c_surname">
        </div>

        <div class="form-group">
            <label>ფილიალის დასახელება:</label>
            <select class="form-control" id="sel1" required>
                <option></option>
                <?php while($branch_array = mysqli_fetch_array($branch_query)) {
                    echo "<option value='$branch_array[idBranch]' id='brn_opt'>$branch_array[Branch_Name]</option>"; //branch lookup gagrdzeleba
                } ?>
            </select>
        </div>

        <div align="right">
            <input type="button" class="btn btn-default" name="branch_submit" id="br_id" value="დამატება">
        </div>
    </div>
</form>
