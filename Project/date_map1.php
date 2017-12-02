<?php
session_start();
if(empty($_SESSION['login_userid'])){
  session_destroy();
  header('Location:login.php');
  exit(); 
}
require_once('connect_members.php');

?>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    
    <style>
    path {stroke-width: 4;fill: none;}
    .axis {shape-rendering: crispEdges;}
    .x.axis line {stroke: lightgrey;}
    .x.axis .minor {stroke-opacity:.5;}
    .x.axis path {display: none;}
    .y.axis line, .y.axis path {fill: none;stroke: #000;stroke-width: 1;}
</style>

<title>Date and Map</title>

<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<!-- Custom CSS -->
<link href="custom_css/date_map_sidebar.css" rel="stylesheet">
<link href="custom_css/date_map_css.css" rel="stylesheet">
<link href="custom_css/date_map_top_nav.css" rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom Fonts -->

    
</head>

<body>
    <!-- /sidebar and topnav wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand"><p>PULSER 2.0</p></li>
                <li><a href="dash4.php"><span class="glyphicon glyphicon-equalizer"></span>儀表板</a></li>
                <li><a href="date_map1.php"><span class="glyphicon glyphicon-th-list"></span>紀錄搜尋</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-user"></span>社群</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-book"></span>說明</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-info-sign"></span>關於我們</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-earphone"></span>聯絡我們</a></li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- top-nav -->
        <div>
            <div class="container-fluid topbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href=""><span class="glyphicon glyphicon-bell"></span>提醒</a></li>
                    <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span><?php echo($_SESSION['login_userid']);?></a></li>
                    <li><a href="logout.php"><span id="logout_span" class="glyphicon glyphicon-log-in logout_span"></span></a></li>
                </ul>
            </div>
        </div>
        <!-- top-nav -->
    </div>
    <!-- /sidebar and topnav wrapper -->


    <!-- area_page_wrapper -->
    <div id="page-wrapper">
        <!-- area_select_date_and_map -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1 class="page-header"><label>紀錄搜尋</label></h1>
                </div>
                <div class="clearfix"></div>
                <div class="text-center">
                   <ol class="breadcrumb">
                      <li><span class="glyphicon glyphicon-calendar"></span><label id="DATE"></label></li>
                      <li><span class="glyphicon glyphicon-remove" id ="device_sign"></span><label>無配對使用裝置</label></li>
                  </ol>
              </div>
          </div>
          <!--date_map_page-content-->
          <div class="date_map_page-content text-center">
            <!--beginning of date and pick div-->
            <div class="map_and_datepicker">
                <!--map_and_datepicker_padding-->
                <div class="map_and_datepicker_padding text-left">
                    <!--map-select-->
                    <div>
                        <div class="date_map_select">
                            <label>選擇圖型:</label>
                            <select id='map_select'>
                              <option value="raw">原始圖型</option>
                              <option value="fft">FFT圖型</option>
                              <option value="fft_30">FFT-30圖型</option>
                          </select>
                          <div></div>
                      </div>
                  </div>
                  <!--map-select-->
                  <div class="date_map_space"></div>
                  <!--datepicker-->
                  <div>
                    <div class="date_map_input_datepicker">
                        <label>選擇時間:</label>
                        <select id = "time_select">
                        </select>
                    </div>
                </div>
                <!--datepicker-->
                <div class="date_map_space"></div>
                <!--time-->

                <!--time-->
                <!--input-button-ok-->
                <button id="submitData" class="btn submitButton" onclick="change_map()" >確定</button>
                <!--input-button-ok-->
            </div>
            <!--map_and_datepicker_padding-->
        </div>
        <!--end of date and pick div-->
        <div id="result"></div>
        <div class="date_map_space2"></div>
        <!--beginning of map div-->
        <div class="map_div">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title map_div_h3">
                        <i class="fa fa-bar-chart-o fa-fw"></i>
                        <label id="map_label">原始圖形</label>
                    </h3>
                </div>
                <div class="panel-body">
                    <div id="graph" class="aGraph">
                    </div>
                </div>
            </div>

        </div>
        <!--end of map div-->
    </div>
    <!--date_map_page-content-->
</div>
<!-- area_select_date_and_map -->

</div>
<!-- area_page_wrapper -->

</body>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/nonemap.js"></script>
<script src="js/today_date.js"></script>
<script src="js/date_map_map.js"></script>
<script>
    $(document).ready(function(){
        $.ajax({
            type: 'GET',
            url: 'test2.php',
            dataType: "json",  
            success: function(data) {
                loaddata(data);
            },
            error: function() {
                alert("ERROR");
            }
        });
    });
    
    
    function loaddata(d){
        var r = document.getElementById('time_select');
        var array1 = d;
        var t;
        for(t=0;t<array1.length;t++){
            var option = document.createElement("option");
            option.value = array1[t];
            option.text = array1[t];
            r.appendChild(option);
        }
    }
</script>

<script type='text/javascript'>
    function change_map()
    {
        var x = document.getElementById('map_select').value;
        if(x == 'raw'){
            d3.select("svg").remove();
            x = '原始圖型';
            $.ajax({
                type: 'GET',
                url: 'fromPython.php',
                dataType: "json",  
                success: function(data) {
                    getRaw(data[5]);
                },
                error: function() {
                    alert("ERROR");
                }
            });
        }
        else if(x == 'fft')
        {
            d3.select("svg").remove();
            x = "FFT圖型";
            $.ajax({
                type: 'GET',
                url: 'fromPython.php',
                dataType: "json",  
                success: function(data) {
                    getFFT30(data[4],data[0]);
                },
                error: function() {
                    alert("ERROR");
                }
            });
        }
        else{
            d3.select("svg").remove();
            x = "FFT-30圖型";
            $.ajax({
                type: 'GET',
                url: 'fromPython.php',
                dataType: "json",  
                success: function(data) {
                    getFFT(data[4],data[0]);
                },
                error: function() {
                    alert("ERROR");
                }
            });
        }
        document.getElementById("map_label").innerHTML = x;
    }

</script>

<script type="text/javascript">
    $("#submitData").click(function(){
    var txt = document.getElementById('time_select').value;
    $.post("fromPython2.php",  {suggest: txt} ,function(data){
        console.log(txt);
    });
});
</script>

<?php
mysqli_close($link);
?>



</html>

