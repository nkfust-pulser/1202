<?php
session_start();
if(empty($_SESSION['login_userid'])){
  $_SESSION['login_userid'] = "";
}
?>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" >
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



  <title>PULSER 2.0</title>

  <!-- Bootstrap Core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom CSS -->
  <link href="custom_css/index_css.css" rel="stylesheet">

</head>

<body>

  <nav class="navbar navbar-fixed-top navbar-default topnav_css" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <button id="theButton" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
        </button>
        <a class="navbar-brand" href="index.php"><span id="navbar_brand_span" class="fa fa-home"></span></a>
        <label class="navbar-brand">PULSER 2.0</label>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-left">
          <li><a href="#"><label>產品</label></a></li>
          <li><a href="#"><label>應用程式</label></a></li>
          <li><a href="#"><label>說明</label></a></li>
          <li><a href="#"><label>服務</label></a></li>
          <!--<li><a href="index.php"><label class="fa fa-home"></label></a></li>-->
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="<?php echo (!(empty($_SESSION['login_userid'])) ? 'profile.php' : 'login.php')?>"><label><?php echo (!(empty($_SESSION['login_userid'])) ? $_SESSION['login_userid'] : '登入')?></label></a></li>
          <li><a href="<?php echo (!(empty($_SESSION['login_userid'])) ? 'logout.php' : 'register.php')?>"><label><?php echo (!(empty($_SESSION['login_userid'])) ? '登出' : '註冊')?></label></a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div id="content_padding"></div>

  <div class="content_size">

    <div id="index_word" class="index_content_css">
      <label id="pulser_css">Welcome to Pulser 2.0...</label>
      <label id="inspiring_css">Inspiring</label>
      <label id="future">Future</label>
    </div>

  </div>

</body>
<script>

</script>

</html>
