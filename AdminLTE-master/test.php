<?php
include ("../head.php");
include("../connect.php");
include("../session_check.php");
$time_start = microtime(true);
$query=mysqli_query($mysql,"select * from test");
while ($result = mysqli_fetch_assoc($query)) {
   ?>
    <div class="col-xs-12">
        <div class="col-xs-3"><?php echo $result['test'] ?></div>
        <div class="col-xs-3"><?php echo $result['test2'] ?></div>
        <div class="col-xs-3"><?php echo $result['test3'] ?></div>
        <div class="col-xs-3"><?php echo $result['test4'] ?></div>
    </div>
    <?php
    echo "<br>";
}
$time_end = microtime(true);
$execution_time = ($time_end - $time_start);
echo '<b>Total Execution Time:</b> '.$execution_time.' Mins';
