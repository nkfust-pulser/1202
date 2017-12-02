<?php

// Include config file
require_once 'connect_members.php';


$username = $password = $confirm_password = $user_real_name = $mail_address = "";

$username_err = $password_err = $confirm_password_err = $user_real_name_err = $mail_address_err = "";

// Processing form data when form is submitted

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
  if(empty(trim($_POST["user_register_id"]))){
    $username_err = "請輸入帳號";
  } else{

        // Prepare a select statement
    $sql = "SELECT id FROM members_account WHERE userid = ?";

    if($stmt = mysqli_prepare($link, $sql)){

            // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
      $param_username = trim($_POST["user_register_id"]);

            // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){

        /* store result */
        mysqli_stmt_store_result($stmt);

        if(mysqli_stmt_num_rows($stmt) == 1){
          $username_err = "此帳號已被採用!";
        } else{
          $username = trim($_POST["user_register_id"]);
        }
      } else{
        echo "抱歉...請重新再輸入一次";
      }
    }

        // Close statement
    mysqli_stmt_close($stmt);
  }
  if(empty(trim($_POST['user_register_real_name']))){
    $user_real_name_err = "請輸入姓名";
  }else{
    $user_real_name = trim($_POST['user_register_real_name']);
  }

    // Validate password
  if(empty(trim($_POST['user_reiger_password']))){
    $password_err = "請輸入密碼.";     
  } elseif(strlen(trim($_POST['user_reiger_password'])) < 6){
    $password_err = "密碼長度至少要6個以上";
  } else{
    $password = trim($_POST['user_reiger_password']);
  }

    // Validate confirm password
  if(empty(trim($_POST["register_passoword_confirmation"]))){
    $confirm_password_err = '請再次輸入密碼';     
  } else{
    $confirm_password = trim($_POST['register_passoword_confirmation']);
    if($password != $confirm_password){
      $confirm_password_err = '密碼輸入不同!';
    }
  }
  if(empty(trim($_POST['register_mail']))){
    $mail_address_err = "請輸入註冊信箱";
  }else{
    $sql_mail = "SELECT id FROM members_account WHERE mail_address = ?";
    if($stmt = mysqli_prepare($link, $sql_mail)){
      mysqli_stmt_bind_param($stmt, 's', $param_mail_address);
      $param_mail_address = trim($_POST['register_mail']);
      if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt)==1){
          $mail_address_err = "此信箱已被採用";
        }
        else{
          $mail_address = trim($_POST['register_mail']);
        }
      }
      else{
        echo "抱歉...請重新再輸入一次";
      }

    }
    mysqli_stmt_close($stmt);
  }


    // Check input errors before inserting in database
  if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($user_real_name_err) && empty($mail_address_err)){

        // Prepare an insert statement
    $sql = "INSERT INTO members_account (userid, username, password, mail_address) VALUES (?, ?, ?, ?)";

    if($stmt = mysqli_prepare($link, $sql)){

            // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "ssss", $param_userid, $param_name, $param_password, $param_mail);

            // Set parameters
      $param_userid = $username;
      $param_name = $user_real_name;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_mail = $mail_address;
            var_dump($param_userid);
            var_dump($param_name);
            var_dump($param_password);
            var_dump($param_mail);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page

              $sql2 = "INSERT INTO users_information (userid,username,mail_address) VALUES (?,?,?)";

              if($stmt2 = mysqli_prepare($link, $sql2)){

            // Bind variables to the prepared statement as parameters
               mysqli_stmt_bind_param($stmt2, "sss", $param_userid2, $param_name2, $param_mail2);

            // Set parameters
               $param_userid2 = $username;
               $param_name2 = $user_real_name;
               $param_mail2 = $mail_address;

               var_dump($username);
               var_dump($user_real_name);
               var_dump($mail_address);
            // Attempt to execute the prepared statement
               if(mysqli_stmt_execute($stmt2)){
                // Redirect to login page
                header("location: login.php");
              } else{
                echo "抱歉...請再次輸入資訊!!!!!";
              }
            }         

        // Close statement
            mysqli_stmt_close($stmt2);
          } else{
            echo "抱歉...請再次輸入資訊!!";
          }
        }         

        // Close statement
        mysqli_stmt_close($stmt);
      }


      if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($user_real_name_err) && empty($mail_address_err)){

        // Prepare an insert statement

      }
    // Close connection
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
      <link href="custom_css/register_css.css" rel="stylesheet">
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
            <ul class="nav navbar-nav navbar-right" id="navbarRight">
              <li><a href="login.php"><label>登入</label></a></li>
              <li><a id ="span1"><span class="fa fa-facebook-official"></span></a></li>
              <li><a id ="span2"><span class="fa fa-instagram"></span></a></li>
              <li><a id ="span3"><span class="fa fa-google-plus-official"></span></a></li>
            </ul>
          </div>
        </div>
      </nav>


      <div class="topnav_and_form_padding"></div>

      <form id="myForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="container-fluid" id="formContent">
          <div class="register_box">

            <div class="form_inside_padding"></div>

            <div class="text-center"><span id="form_title">歡迎使用PULSER 2.0</span></div>
            <div class="form_inside_padding2"></div>
            <div class="form-group" <?php echo (!empty($username)) ? 'has-error' : ''; ?>">
              <label>帳號</label>
              <input placeholder="請輸入帳號..." class="form-control" type="text" name="user_register_id">
              <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group" <?php echo (!empty($user_real_name)) ? 'has-error' : ''; ?>">
              <label>姓名</label>
              <input placeholder="請輸入姓名..." class="form-control" type="text" name="user_register_real_name">
              <span class="help-block"><?php echo $user_real_name_err; ?></span>
            </div>
            <div class="form-group" <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
              <label>密碼</label>
              <input placeholder="請輸入密碼..." class="form-control" type="password" name="user_reiger_password" 
              value="<?php echo $password; ?>">
              <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group" <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
              <label>確認密碼</label>
              <input placeholder="密碼確認..." class="form-control" type="password" name="register_passoword_confirmation"
              value="<?php echo $confirm_password; ?>">
              <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group" <?php echo (!empty($mail_address)) ? 'has-error' : ''; ?>">
              <label>註冊信箱</label>
              <input placeholder="請輸入信箱..." class="form-control" type="text" name="register_mail">
              <span class="help-block"><?php echo $mail_address_err; ?></span>
            </div>

            <div class="form_inside_padding4"></div>
            <div class="form_inside_padding4"></div>
            <div class="text-center">
             <input type="hidden" name="refer" value=" <?php echo (isset($_GET['refer'])) ?$_GET['refer']:'register.php';?>">
             <button type="submit" class="btn btn-info btn-lg round">註冊</button>
           </div>
           <div class="form_inside_padding3"></div>
           <div class="form-group text-center">
            <a href="login.php">已經有帳號了嗎?</a>
          </div>
          <div class="form_inside_padding3"></div>
        </div>
      </div>
    </form>
    <div class="buttom_padding"></div>

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
