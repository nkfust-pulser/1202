<?php 
session_start();
$_SESSION['date_map1'] = $_POST["suggest"];
$python = "D:\\Python36\\python.exe";
$pythonscript = "C:\\xampp\\htdocs\\Project\\python\\ff3-4.py";

$item = $_SESSION['date_map1'];
$output = array();
$cmd = ("$python $pythonscript $item");
exec("$cmd",$output);
echo json_encode($output);
?>