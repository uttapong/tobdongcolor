<!DOCTYPE html>
<html>
    <head>
      <?php require('include.php'); ?>
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
      //var fbid=response.authResponse.userID;
      FB.api('/me?fields=picture.width(200).height(200),name,id', function(response)
      {
        console.log(response);
        $('#loading').hide()
        $('#myname').html(response.name);
        $("#myimg").attr("src",response.picture.data.url);
        getInfo(response.id);
      });
    }
    else {
      FB.login(function(response) {
      if (response.authResponse) {
       getEvent(response.authResponse.accessToken,response.authResponse.userID);
      } else {
       sweetAlert("Oops...", "ขออภัยท่านกดยกเลิกหรือเข้าสู่ระบบผิดพลาด", "error");
      }
  });
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
       if(!res.color)$('#mycolor').html(' <a href="random.php" class="btn btn-lg btn-success" role="button">จับสลากเลือกสีสำหรับนักกีฬา</a>');
     }else $('#myrank').html('ท่านยังไม่ถูกประเมินมือ');
     $('#user-data').slideDown();

   }).fail(function() {
    swal("อินเทอร์เนตกากมาก", "กรุณาพิจารณาเปลี่ยนค่ายอินเทอร์เนต", "error");
  });
   }

</script>

<div class="container">
      <div class="user-head clearfix" style="text-align: center;margin-top: 50px;">
        <img src="images/tobdong_logo.svg" style="height: 100px;"/></div>
        <div style="width: 100%;text-align:center;"><h2 style="font-family: 'Fredoka One', cursive;">Tobdong Annual Game 2015</h2></div>
        <hr />
        <div id="loading" style="text-align:center"><img style="height: 100px;" src='images/loading.svg' /> กำลังโหลดข้อมูล...</div>
        <div id="user-data" style="display:none;">
          <div><img id="myimg" src="" style="height:120px;width:120px;float: left; margin:10px 0 10px 5px;border-radius: 75px;"/></div>
          <div style="float: left">
            <div class="user-info">
              <p style="">Welcome, <span id="myname">...</span><p>
              <p style="">Rank: <span id="myrank">...</span><p>
                <p style="">Team: <span id="mycolor">...</span><p>
            </div>

          </div>
        </div>
          <div style="clear:both"></div>
          <hr />

<?php
require('config.php');

function getColorAll($color){
  global $conn;
  $result = $conn->query("select name,fbid,rank  from member where color='{$color}' and response<>'head'");
  while($row=$result->fetch_assoc()){
    echo "<div class='userimg' ><a target='_blank' href='https://www.facebook.com/{$row[fbid]}' class='userlink' data-toggle='tooltip' title='{$row[name]}'><img class='userphoto' src='http://graph.facebook.com/{$row[fbid]}/picture?type=square'></img></a></div>";
  }
}

function getHead($color){
  global $conn;
  $result = $conn->query("select name,fbid,rank  from member where color='{$color}' and response='head' ");
  while($row=$result->fetch_assoc()){
    echo "<div class='userimg' ><a target='_blank' href='https://www.facebook.com/{$row[fbid]}' class='userlink' data-toggle='tooltip' title='{$row[name]}'><img class='userphoto' src='http://graph.facebook.com/{$row[fbid]}/picture?type=square'></img></a></div>";
  }
}
?>

          <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-3">
                <div class='color-head' style="background-color: #3498db;">สีฟ้า</div>
                <div class="team-head">
                  <div class='head-text'>หัวหน้าสี</div>
                  <?php
                  getHead('B');
                  ?>
                </div>
                <div id="B-Team"></div>
                <?php
                getColorAll('B');
                ?>
            </div>

            <div class="col-xs-12 col-md-6 col-lg-3">
              <div class='color-head' style="background-color: #f1c40f;">สีเหลือง</div>
              <div class="team-head">
                <div class='head-text'>หัวหน้าสี</div>
                <?php
                getHead('Y');
                ?>
              </div>
              <div id="Y-Team"></div>
              <?php
              getColorAll('Y');
              ?>
            </div>

            <div class="col-xs-12 col-md-6 col-lg-3">
              <div class='color-head' style="background-color: #FF6CA8;">สีชมพู</div>
              <div class="team-head">
                <div class='head-text'>หัวหน้าสี</div>
                <?php
                getHead('P');
                ?>
              </div>
              <div id="P-Team"></div>
              <?php
              getColorAll('P');
              ?>
            </div>

            <div class="col-xs-12 col-md-6 col-lg-3">
              <div class='color-head' style="background-color: #1abc9c">สีเขียว</div>
              <div class="team-head">
                <div class='head-text'>หัวหน้าสี</div>
                <?php
                getHead('G');
                ?>
              </div>
              <div id="G-Team"></div>
              <?php
              getColorAll('G');
              ?>
            </div>
          </div>
</div>





<footer class="footer">
  <p>&copy; Tobdong Badminton Team 2015. All right reserved.</p>
</footer>

    </div> <!-- /container -->



    </body>
</html>
