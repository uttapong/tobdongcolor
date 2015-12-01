<!DOCTYPE html>
<html>
    <head>
      <?php require('include.php'); ?>
      <script src="js/winwheel_1.2.js"></script>
      <link rel="stylesheet" href="css/spin.css" />
    </head>
    <body>
      <script>
<?php if(isset($_REQUEST['token'])){ ?>
  window.fbAsyncInit = function() {


    FB.init({
      appId      : '612396988819496',
      xfbml      : true,
      version    : 'v2.0',
      status:true,
    });

    <?php if(!isset($_REQUEST['token'])){ ?>

    FB.getLoginStatus(function(response) {
      //console.log(response);
    if (response.status === 'connected') {

      FB.api('/me?fields=picture.width(120).height(120),name,id', function(response)
      {
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
<?php }else { ?>
  $( document ).ready(function() {
  getInfo('<?php echo  $_REQUEST['token'];?>');
});

<?php }  ?>

  };
  <?php } ?>

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
     <?php if(isset($_REQUEST['token'])){echo "fbid='".$_REQUEST['token']."';";  }?>
     $.ajax({
     url: "lib.php",
     method: "POST",
     data: { action:'getinfo',fbid: fbid <?php if(isset($_REQUEST['token'])){echo ",token:'".$_REQUEST['token']."'";  }?>}
   }).done(function(res) {
     <?php if(isset($_REQUEST['token'])){
      echo "$('#loading').hide();";
       echo "$('#myname').html( res.name );";  }?>
     if(res.rank){
       $('#myrank').html( res.rank );
       userRank=res.rank;
       <?php if(isset($_REQUEST['token'])){echo "begin(userRank,fbid);";  }else {
         echo "begin(userRank,{$_REQUEST['token']});";
       }?>

       //if(!res.color)$('#mycolor').html(' <button class="btn btn-lg btn-success" role="button">จับสลากเลือกสีสำหรับนักกีฬา</button> <button class="btn btn-lg btn-warning" role="button">จับสลากเลือกสีสำหรับกองเชียร์</button>');
     }else $('#myrank').html('ท่านยังไม่ถูกประเมินมือ');
     $('#user-data').slideDown();
   }).fail(function() {
    swal("อินเทอร์เนตกากมาก", "กรุณาพิจารณาเปลี่ยนค่ายอินเทอร์เนต", "error");
  });;
   }

   function confirmRandom(){
     swal({   title: "Are you sure?",
      text: "คุณไม่สามารถเปลี่ยนแปลงสีของคุณได้หลังจากกดจับสลาก!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "มั่นใจมาก!",
      closeOnConfirm: true },
      function(){   startSpin(); });
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
                <p style="">Team: <span id="mycolor">Good luck!</span><p>
            </div>

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

            <div class="col-xs-12">
              <div style="width:100%;height: 582px;text-align:center;" class="the_wheel">
              <canvas class="the_canvas" id="myDrawingCanvas" width="434" height="434" style="margin-top:74px;">
  							<p class="noCanvasMsg" align="center">ขออภัยเว็บบราวเซอร์ของคุณเก่าเกินไป</p>
  						</canvas>
            </div>
            </div>

            <div class="col-xs-12">
                <div class='color-head' style="background-color: #eee;"><button onClick="confirmRandom();" class='btn btn-success btn-lg' role='button'>หมุนจับสลาก</button></div>

            </div>

          </div>
</div>

<footer class="footer">
  <p>&copy; Tobdong Badminton Team 2015. All right reserved.</p>
</footer>

    </div> <!-- /container -->

    </body>
</html>
