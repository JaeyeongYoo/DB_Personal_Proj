<?php
  session_start();
  $user_id = "";
  $pw = "";
  $user_name = "";
  $_SESSION['user_id'] = $user_id;
  $_SESSION['user_name'] = $user_name;

  $conn = mysqli_connect("localhost", "root", "tp97fkdhs", "dbproj");

  if (isset($_POST['login_user'])){
    $user_id = mysqli_real_escape_string($conn, $_POST['login_id']);
    $pw = mysqli_real_escape_string($conn, $_POST['login_pw']);

    $sqlquery = "SELECT * FROM user WHERE user_id='$user_id' AND password='$pw'";
    $result = mysqli_query($conn, $sqlquery);

    if(mysqli_num_rows($result) == 1){ //값이 하나면
      $_SESSION['user_id'] = $user_id;
      $sqlname = "SELECT * FROM user WHERE user_id='$user_id'";
      $result = mysqli_query($conn, $sqlname);
      $row = mysqli_fetch_array($result);
      $_SESSION['user_name'] = $row[3];
      $_SESSION['user_pw'] = $row[2];
?>
    <script>
      alert('로그인 성공');
      history.back(-1);
    </script>
<?php
    }else{
?>
    <script>
      alert('로그인 실패');
      history.back(-1);
    </script>
<?php
    }
  }

  if (isset($_POST['logout_user'])) {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_pw']);
    unset($_SESSION['user_name']);
?>
  <script>
    alert('로그아웃 되셨습니다.');
    history.back(-1);
  </script>
<?php
  }
?>
