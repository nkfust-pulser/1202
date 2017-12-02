<?php
session_start();
if(!(empty($_SESSION['login_userid'])))
{
  header("Location: index.php");
}

require_once("connect_members.php");

$username = $password = $user_real_name = $user_mail_address = "";
$username_err = $password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
  if(empty(trim($_POST["user_enter_username"]))){$username_err = '請輸入帳號';} 
  else{$username = trim($_POST["user_enter_username"]);}
  if(empty(trim($_POST['user_enter_password']))){$password_err = '請輸入密碼';} 
  else{$password = trim($_POST['user_enter_password']);}

    // Validate credentials
  if(empty($username_err) && empty($password_err))
  {
    $sql = "SELECT userid, password, username, mail_address FROM members_account WHERE userid = ?";
    if($stmt = mysqli_prepare($link, $sql))
    {
    // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_username);
      // Set parameters
      $param_username = $username;
      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt))
      { 
      // Store result
        mysqli_stmt_store_result($stmt);
      // Check if username exists, if yes then verify password
        if(mysqli_stmt_num_rows($stmt) == 1)
        { 
        // Bind result variables
          mysqli_stmt_bind_result($stmt, $username, $hashed_password, $user_real_name, $user_mail_address);
          if(mysqli_stmt_fetch($stmt))
          {
            var_dump($hashed_password);
            var_dump($password);
            var_dump(password_verify($password, $hashed_password));
            if(password_verify($password, $hashed_password))
            {
              $_SESSION['login_userid'] = $username;
              $_SESSION['login_user_real_name'] = $user_real_name;
              $_SESSION['login_user_mail_address'] = $user_mail_address;  
              header("location: load_data.php");
            } 
            else{
              // Display an error message if password is not valid
              $password_err = '輸入密碼錯誤';
            }
          }
        } 
        else{
          $username_err = '找不到該帳號';
        }
      }
      else{
        echo "帳號或密碼錯誤!請重新輸入";
      }
    }
    mysqli_stmt_close($stmt);
  }
  mysqli_close($link);
}
?>
<html lang="zh-Hant">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="js/jquery.js"></script>

  <title>PULSER 2.0</title>

  <!-- Bootstrap Core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >

  <!--custom-css-->
  <link href="custom_css/login_css.css" rel="stylesheet">
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
          <li><a href="register.php"><label>註冊</label></a></li>
          <li><a id="span1"><span class="fa fa-facebook-official"></span></a></li>
          <li><a id="span2"><span class="fa fa-instagram"></span></a></li>
          <li><a id="span3"><span class="fa fa-google-plus-official"></span></a></li>
        </ul>
      </div>
    </div>
  </nav>


  <div class="topnav_and_form_padding"></div>

  <form id = "myForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

    <div class="container-fluid" id='content-page'>

      <div class="loginbox">
        <div class=" form_title_padding"></div>
        <div class="text-center"> 
          <span class="singtext2">登入 PULSER 2.0</span>
        </div>
        <div class="form_inside_padding0"></div>
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
          <label class="form_label"></label>
          <label class="form_label">帳號</label>
                  <div class="form_inside_padding4"></div>

          <input class="form-control" placeholder="帳號" name="user_enter_username" type="text" 
          value="<?php echo $username?>">
          <span class="help-block"><?php echo $username_err; ?></span>
        </div>
        <div class="form_inside_padding1"></div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
          <label class="form_label">密碼</label>
                  <div class="form_inside_padding4"></div>
          <input class="form-control" placeholder="密碼" name="user_enter_password" type="password">
          <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form_inside_padding2"></div>
        <div class="text-center">
          <input type="hidden" name="refer" value=" <?php echo (isset($_GET['refer'])) ?$_GET['refer']:'login.php';?>">
          <button type="submit" class="btn btn-info btn-lg round">登入</button>
        </div>
        <div class="form_inside_padding2"></div>
        <div class="form-group text-center">
          <a href="#">忘記密碼?</a>
          <a class="" href="register.php">註冊帳號</a>
        </div>
        <div class="form_inside_padding3"></div>

      </div>

    </form>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
      $( document ).ready(function() {
        $('#myForm')[0].reset();
      });
    </script>
  </body>

  <?php
  mysqli_close($link);
  ?>
  </html>
