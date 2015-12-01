<?php
require('config.php');

if(isset($_REQUEST['action'])&&$_REQUEST['action']=='import'){

  // Create a curl handle
  //$ch = curl_init('https://graph.facebook.com/1699682953600821?fields=admins,attending,maybe&access_token=612396988819496|e2ab814a26b255a01ee2bc59fe8f3995');
  $ret=file_get_contents('https://graph.facebook.com/1699682953600821?fields=admins,attending,maybe&access_token=612396988819496|e2ab814a26b255a01ee2bc59fe8f3995');
  // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  // $ret = curl_exec($ch);
  // print_r($ret);
  // exit(0);
  // Close handle
  // curl_close($ch);
  $users=json_decode($ret,true);
  $admins=$users[admins][data];
  $attend=$users[attending][data];
  $notsure=$users[admins][data];
  $maybe=$users[maybe][data];
  $all=array_merge($admins,$attend,$maybe);
  //print_r($all);
  foreach($all as $user){
    $mysqldata=$conn->query("select name from member where name='{$user[name]}'");
    $mysqldata2=$conn->query("select name from member where fbid='{$user[id]}'");
  //  echo "select name from member where name='{$user[name]}' \n";
    // if(!$mysqldata)echo "select name from member where name='{$user[name]}'";

    if($mysqldata->num_rows>0){
      $row_data=$mysqldata->fetch_assoc();
      $sql="update member set fbid='{$user[id]}' where name='{$user[name]}'";
  //    echo $sql."\n";
      $conn->query($sql);
    }
    else if($mysqldata2->num_rows>0){
      $row_data=$mysqldata2->fetch_assoc();
      $sql="update member set fbid='{$user[id]}' where name='{$user[name]}'";
  //    echo $sql."sql2-------\n";
      $conn->query($sql);
    }
    else{
      $sql="insert into member set fbid='{$user[id]}',name='".mysqli_real_escape_string($conn,$user[name])."',response='{$user[rsvp_status]}';";
  //    echo $sql."\n";
      try {
        $conn->query($sql);
      }
      catch(Exception $e) {
      }
    }

  }

  echo "1";
  exit(0);
}
?>
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
      version    : 'v2.0',
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

function getUser(token){
  // FB.api(
  //   "/1699682953600821?fields=admins,attending,maybe",
  //   {
  //       access_token : token//'612396988819496|e2ab814a26b255a01ee2bc59fe8f3995'
  //   },
  //   function (response) {
  //     console.log(response);
  //     var auth=false;

      // if (response && !response.error) {
        $.ajax({
  type: "POST",
  url: 'import.php',
  data: {token:token,action:'import'},
  dataType: 'json'
}).done(function( data ) {
    if(data=="1")swal("Success","Facebook users has been imported/updated", "success");
  });;
//       }
//       else{
//         swal("ขออภัย","Get User Error!");
//       }
//     }
// );
}
function fblogin(){
  FB.getLoginStatus(function(response) {
  if (response.status === 'connected') {
    console.log(response.authResponse);
    getUser(response.authResponse.accessToken);
    //window.location="main";
  }
  else {
    FB.login(function(response) {
    if (response.authResponse) {
     getUser(response.authResponse.accessToken);
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
      <h4>Tobdong Annual Games : Facebook User Importer</h4>
    </div>


    <div class="row login">
      <div class="col-lg-12">
        <div class="btn-login">
        <!-- FACEBOOK -->
        <a href="#" class="sc-btn sc--facebook sc--small" onclick="fblogin()">
          <span class="sc-icon">
              <svg viewBox="0 0 33 33" width="25" height="25" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M 17.996,32L 12,32 L 12,16 l-4,0 l0-5.514 l 4-0.002l-0.006-3.248C 11.993,2.737, 13.213,0, 18.512,0l 4.412,0 l0,5.515 l-2.757,0 c-2.063,0-2.163,0.77-2.163,2.209l-0.008,2.76l 4.959,0 l-0.585,5.514L 18,16L 17.996,32z"></path></g></svg>
          </span>
          <span class="sc-text">
             Facebook Login
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
