<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>JANG MOVIE</title>

  <style>
  @font-face
  {
   font-family: "Tint";
   src:url(./font/210springR.eot)  format('embedded-opentype'),
    url(./font/210springR.woff) format('woff'),
    url(./font/210springR.ttf) format('truetype');
  }
  @font-face
  {
   font-family: "Bernard";
   src:url(./font/Bernard.eot) format('embedded-opentype'),
    url(./font/Bernard.woff) format('woff'),
    url(./font/Bernard.ttf) format('truetype');
  }
  body{
    text-align: center;
    font-family: "Tint", monospace;
    background-color: #FFFFFF;
  }
  header{
    width: 100%;
    height: 130px;
    text-align: center;
    font-family: "Bernard", monospace;
    font-size: 70px;
    padding: 0px;
    margin: 0px;
    padding-top: 40px;
  }
  a{
    text-decoration: none;
    color: #000000;
  }
  a:hover{
    color: #fac60e;
  }
  div p, nav ul p{ font-size: 20px; padding: 3px; margin: 0px; }
  nav
  {
    display: table-cell;
    text-align: left;
    margin-top: 50px;
    padding-right: 100px;
  }
  ul, li, ol { list-style: none; padding: 0px; margin: 5px; }
  nav ul li a { font-size:20px; }
  nav div {
    border: 4px solid #fac60e;
    padding: 10px;
  }
  section
  {
    width: 770px;
    display: table-cell;
    margin-top: 50px;
    text-align: center;
  }
  .information{
    margin:30px;
    padding:10px;
  }
  .info1, .info2{
    display: inline-block;
    height: 100px;
    vertical-align: center;
    line-height: 40px;
    margin-top: 30px;
  }
  .info1{
    text-align: right;
    width: 100px;
    font-size: 22px;
  }
  .info2{
    text-align: left;
    width: 300px;
  }
  </style>
</head>
<body>
  <script>
  function check_id()
  {
    var userid = document.getElementById("uid").value;
    if(userid){
      url="check.php?userid="+userid;
      window.open(url,"chkid","width=300, height=100");
    }else{
      alert("아이디를 입력하세요");
    }
  }
  </script>
  <header>
    <a href="mainpage.php">Jang's Movie</a>
  </header>
  <nav>
    <div>
<?php
      if(!$_SESSION['user_id'] && !$_SESSION['user_name']){
?>
      <p>LOGIN</p>
      <form action="auto.php" method="POST">
        <p><input type="text" name="login_id" placeholder="id"></p>
        <p><input type="password" name="login_pw" placeholder="pw"></textarea></p>
        <p><input type="submit" value="로그인" name="login_user"><a href="signup.php"> sign up</a></p>
      </form>
<?php }else {
        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'];
        echo "<p>안녕하세요!<br>".$user_name."님</p>";
?>
        <form action="auto.php" method="POST">
          <input type="submit" value="로그아웃" name="logout_user">
        </form>
<?php } ?>
    </div>
    <ul>
      <p style="font-size:40px">MENU</p>
      <li><a href="moviepage.php">Movie Page</a></li>
      <li><a href="theaterpage.php">Theater Page</a></li>
      <li><a href="">Like List</a></li>
      <li><a href="">My Page</a></li>
    </ul>
  </nav>
  <section>
    <br><br>
    <div style="font-size:60px">-회원 가입-</div>
    <p>정보를 입력하세요.</p>
    <hr style="border: 3px double #fac60e">
    <form action="signup_create.php" method="POST">
      <div class="infomation">
        <div class="info1">
          아이디:<br>
          비밀번호:<br>
          이름:<br>
        </div>
        <div class="info2">
          <input type="text" name="userid" id="uid" placeholder="ID">&nbsp;<input type="button" value="중복 확인" onClick="check_id()" class=m_box><br>
          <input type="password" name="pw" placeholder="password"><br>
          <input type="text" name="user_name" placeholder="이름">
        </div>
      </div>
      <br>
      <input type="hidden" name="checked_id" value="">
      <div>
        <input type="submit" value="가입하기"> <input type="reset" value="다시쓰기">
      </div>
    </form>
  </section>

</body>
</html>
