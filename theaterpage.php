<?php
  session_start();

  $conn = mysqli_connect('localhost', 'root', 'tp97fkdhs', 'dbproj');
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
  @font-face
  {
   font-family: "Alien";
   src:url(./font/THE_Oegyeinseolmyeongseo.eot) format('embedded-opentype'),
    url(./font/THE_Oegyeinseolmyeongseo.woff) format('woff'),
    url(./font/THE_Oegyeinseolmyeongseo.ttf) format('truetype');
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
    width: 175px;
  }
  section
  {
    width: 770px;
    display: table-cell;
    margin-top: 50px;
    text-align: center;
  }
  section table
  {
    min-width: 700px;
    font-size: 22px;
    width: 750px;
    margin: 10px;
    padding: 10px;
    padding-top: 20px;
    padding-bottom: 20px;
  }

  section table tr td, section table tr th
  {
    width: 250px;
    height: 35px;
    text-align: center;
  }
  section table tr th
  {
    font-family: "Bernard", monospace;
    font-size: 40px;
    padding: 15px;
    border-bottom: 3px solid #25176d;
  }
  section table tr td.local{
    padding: 15px;
    border-top: 2px solid #25176d;
  }
  </style>
</head>
<body>
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
    <hr size=10 color=#fac60e>
    <article style='font-size: 40px; font-family: "Alien", monospace'>
      CINEMA; 상영관
    </article>
    <hr size=10 color=#fac60e>
    <table>
      <tr>
        <th> C I N E M A </th>
        <th> M O V I E &nbsp; L I S T </th>
      </tr>
<?php
      $rowsetting_query = "SELECT T.TID, T.local, COUNT(DISTINCT S.MID) FROM theater T, schedule S WHERE T.TID = S.TRID GROUP BY S.TRID, T.TID, T.local";
      $rsresult = mysqli_query($conn, $rowsetting_query);

      while($rsrow = mysqli_fetch_array($rsresult)){
?>
        <tr>
          <td class="local" style='font-size: 50px; font-weight: bold' rowspan="<?php echo $rsrow['count(distinct S.MID)']; ?>">
            <?php echo $rsrow['local']; ?>
          </td>
          <td class="local" style='font-size: 30px; font-weight: bold'>
              상영 가능한 영화
          </td>
        </tr>
<?php
        $movielist_query = 'SELECT DISTINCT T.TID, T.local, M.movie_name FROM theater T, movielist M, schedule S WHERE S.TRID = T.TID AND S.MID = M.MID AND T.TID ='. $rsrow["TID"].' GROUP BY T.TID, T.local, M.movie_name';

        //echo "상영가능 영화 쿼리: ".$movielist_query;

        $listresult = mysqli_query($conn, $movielist_query);
        while($listrow = mysqli_fetch_array($listresult)){
          echo "<tr><td></td><td class='movie'>".$listrow['movie_name']."</td></tr>";
        }
      }
?>
    </table>
  </section>

</body>
</html>
