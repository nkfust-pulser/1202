<?php
session_start();

if(!(empty($_SESSION['which_file']))){
	$python = "D:\\Python36\\python.exe";
	$pythonscript = "C:\\xampp\\htdocs\\Project\\python\\ff3-4.py";

	$item = $_SESSION['which_file'];
	$output = array();
	$cmd = ("$python $pythonscript $item");
	exec("$cmd",$output);
	echo json_encode($output);
}

?>