<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Slim Framework for PHP 5</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
        <link href='https://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,900,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/sc-btn.css" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/spin.css" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
      <script src="js/bootbox.min.js"></script>
      <script src="js/winwheel_1.2.js"></script>
    </head>
    <body>
      <script>

  window.fbAsyncInit = function() {


    FB.init({
      appId      : '612396988819496',
      xfbml      : true,
      version    : 'v2.0',
      status:true,
    });

    FB.getLoginStatus(function(response) {
      //console.log(response);
    if (response.status === 'connected') {

      FB.api('/me?fields=picture.width(120).height(120),name,id', function(response)
      {
        $('#myname').html(response.name);
        $("#myimg").attr("src",response.picture.data.url);
        getInfo(response.id);
      });
    }
    else {
      FB.login();
    }
  });


  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk/debug.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

   $( document ).ready(function() {
  $('.userlink').tooltip();

});

var userRank='NA';
   function getInfo(fbid){
     $.ajax({
     url: "lib.php",
     method: "POST",
     data: { action:'getinfo',fbid: fbid }
   }).done(function(res) {
     if(res.rank){
       $('#myrank').html( res.rank );
       userRank=res.rank;
       begin(userRank,fbid);
       //if(!res.color)$('#mycolor').html(' <button class="btn btn-lg btn-success" role="button">จับสลากเลือกสีสำหรับนักกีฬา</button> <button class="btn btn-lg btn-warning" role="button">จับสลากเลือกสีสำหรับกองเชียร์</button>');
     }else $('#myrank').html('ท่านยังไม่ถูกประเมินมือ');

   });
   }

</script>

<div class="container">
      <div class="user-head clearfix" style="text-align: center;margin-top: 50px;">
        <img src="images/tobdong_logo.svg" style="height: 100px;"/></div>
        <div style="width: 100%;text-align:center;"><h2 style="font-family: 'Fredoka One', cursive;">Tobdong Annual Game 2015</h2></div>
        <hr />
          <div><img id="myimg" src="" style="height:120px;width:120px;float: left; margin:10px 0 10px 5px;border-radius: 75px;"/></div>
          <div style="float: left">
            <div class="user-info">
              <p style="">Welcome, <span id="myname">...</span><p>
              <p style="">Rank: <span id="myrank">...</span><p>
                <p style="">Team: <span id="mycolor">ขอให้โชคดี</span><p>
            </div>

          </div>
          <div style="clear:both"></div>
          <hr />

<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname="tobdongcolor";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);
$conn->query("SET NAMES UTF8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getColorAll($color){
  global $conn;
  $result = $conn->query("select name,fbid,rank  from member where color='{$color}' ");
  while($row=$result->fetch_assoc()){
    echo "<div class='userimg' ><a href='https://www.facebook.com/{$row[id]}' class='userlink' data-toggle='tooltip' title='{$row[name]}'><img class='userphoto' src='http://graph.facebook.com/{$row[fbid]}/picture?type=square'></img></a></div>";
  }
}
?>

          <div class="row">

            <div class="col-xs-12">
              <div style="width:100%;height: 582px;text-align:center;margin-top: 20px;" class="the_wheel">
              <canvas class="the_canvas" id="myDrawingCanvas" width="434" height="434" style="margin-top:74px;">
  							<p class="noCanvasMsg" align="center">ขออภัยเว็บบราวเซอร์ของคุณเก่าเกินไป</p>
  						</canvas>
            </div>
            </div>

            <div class="col-xs-12">
                <div class='color-head' style="background-color: #eee;"><button onClick="startSpin();" class='btn btn-success btn-lg' role='button'>หมุนจับสลาก</button></div>

            </div>

          </div>
</div>





      <footer class="footer">
        <p>&copy; Company 2014</p>
      </footer>

    </div> <!-- /container -->



    </body>
</html>
