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

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
      <script src="js/bootbox.min.js"></script>
      <style>
      </style>
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


   function getInfo(fbid){
     $.ajax({
     url: "lib.php",
     method: "POST",
     data: { action:'getinfo',fbid: fbid }
   }).done(function(res) {
     console.log(res);
     if(res.color)$('#mycolor').html( res.color );else $('#mycolor').html('-');
     if(res.rank){
       $('#myrank').html( res.rank );
       if(!res.color)$('#mycolor').html(' <a href="random.php" class="btn btn-lg btn-success" role="button">จับสลากเลือกสีสำหรับนักกีฬา</a> <button class="btn btn-lg btn-warning" role="button">จับสลากเลือกสีสำหรับกองเชียร์</button>');
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
                <p style="">Team: <span id="mycolor">...</span><p>
            </div>

          </div>
          <div style="clear:both"></div>
          <hr />

<?php
require('config.php');

function getColorAll($color){
  global $conn;
  $result = $conn->query("select name,fbid,rank  from member where color='{$color}' ");
  while($row=$result->fetch_assoc()){
    echo "<div class='userimg' ><a href='https://www.facebook.com/{$row[id]}' class='userlink' data-toggle='tooltip' title='{$row[name]}'><img class='userphoto' src='http://graph.facebook.com/{$row[fbid]}/picture?type=square'></img></a></div>";
  }
}
?>

          <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-3">
                <div class='color-head' style="background-color: #3498db;">สีฟ้า</div>

                <div id="B-Team"></div>
                <?php
                getColorAll('B');
                ?>
            </div>

            <div class="col-xs-12 col-md-6 col-lg-3">
              <div class='color-head' style="background-color: #f1c40f;">สีเหลือง</div>

              <div id="Y-Team"></div>
              <?php
              getColorAll('Y');
              ?>
            </div>

            <div class="col-xs-12 col-md-6 col-lg-3">
              <div class='color-head' style="background-color: #FF6CA8;">สีชมพู</div>

              <div id="P-Team"></div>
              <?php
              getColorAll('P');
              ?>
            </div>

            <div class="col-xs-12 col-md-6 col-lg-3">
              <div class='color-head' style="background-color: #1abc9c">สีเขียว</div>

              <div id="G-Team"></div>
              <?php
              getColorAll('G');
              ?>
            </div>
          </div>
</div>





      <footer class="footer">
        <p>&copy; Company 2014</p>
      </footer>

    </div> <!-- /container -->



    </body>
</html>