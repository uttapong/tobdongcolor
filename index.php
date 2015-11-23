<!DOCTYPE html>
<html>
    <head>
        <?php require('include.php'); ?>
    </head>
    <body class="login">
      <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '612396988819496',
      xfbml      : true,
      version    : 'v2.5',
      status:true,
    });

  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk/debug.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

function getEvent(token,uid){
  FB.api(
    "/1699682953600821?fields=admins,attending",
    {
        access_token : token
    },
    function (response) {
      console.log(response);
      var auth=false;

      if (response && !response.error) {
        allattend=response.attending.data;
        alladmin=response.admins.data;
        allattend.forEach(function(ele) {
          if(ele.id==uid){ auth=true;}
        });
        alladmin.forEach(function(ele) {
          if(ele.id==uid){ auth=true;}
        });
        if(auth)window.location="main.php";
        else{
          swal("ขออภัย","ท่านยังไม่ได้กดเข้าร่วมกีฬาสีประจำปี\nกรุณากดเข้าร่วมกิจกรรมใน Facebook เพื่อเลือกสีของท่าน!");
        }
      }
    }
);
}
function fblogin(){
  FB.getLoginStatus(function(response) {
  if (response.status === 'connected') {
    console.log(response.authResponse);
    getEvent(response.authResponse.accessToken,response.authResponse.userID);
    //window.location="main";
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
}

</script>

      <div class="container">
    <div class="header clearfix">
      <img src="images/tobdong_logo.svg" />
      <h1>Tobdong Annual Games 2015</h1>
    </div>


    <div class="row login">
      <div class="col-lg-12">
        <div class="btn-login">
        <!-- FACEBOOK -->
        <a href="#" class="sc-btn sc--facebook sc--big" onclick="fblogin()">
          <span class="sc-icon">
              <svg viewBox="0 0 33 33" width="25" height="25" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M 17.996,32L 12,32 L 12,16 l-4,0 l0-5.514 l 4-0.002l-0.006-3.248C 11.993,2.737, 13.213,0, 18.512,0l 4.412,0 l0,5.515 l-2.757,0 c-2.063,0-2.163,0.77-2.163,2.209l-0.008,2.76l 4.959,0 l-0.585,5.514L 18,16L 17.996,32z"></path></g></svg>
          </span>
          <span class="sc-text">
              เข้าสู่ระบบโดย Facebook
          </span>
        </a>
      </div>
      </div>
    </div>

    <footer class="footer">
      <p>&copy; Tobdong Badminton Team 2015. All right reserved.</p>
    </footer>

  </div>
    </body>
</html>
