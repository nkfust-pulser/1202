<?php
require_once('connect_members.php');
$user_date = '';
$user_date_err = '';
$option_times = array();
$which_map = '';
$which_map_err = '';

$sql = "SELECT measure_time FROM measure_time ORDER BY measure_time DESC";
if($stmt = mysqli_prepare($link, $sql))
{
    if(mysqli_stmt_execute($stmt))
    {
        mysqli_stmt_bind_result($stmt, $choose_times);
        while(mysqli_stmt_fetch($stmt))
        {
            $option_times[] = $choose_times;
        }
    }
}
mysqli_stmt_close($stmt);

echo json_encode($option_times);
?>