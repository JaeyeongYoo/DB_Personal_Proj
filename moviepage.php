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
    font-size: 30px;
  }
  .review{
    font-family: "Bernard", monospace;
    font-size: 60px;
    text-align: left;
  }
  .reviewtable tr td{
    font-family: "Tint", monospace;
    text-align: left;
    padding-left: 15px;
  }
  .reviewtable tr th{
    font-family: "Tint", monospace;
    font-size: 40px;
    padding: 20px;
  }
  .reviewtable #userid{ width: 20px; }
  .reviewtable #userreview{ width: 150px; text-align: left;}
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
    <article style="font-size: 20px"> 영화를 검색하세요.
      <form action="moviepage.php" method="POST">
        <p>
          <input type="text" name="moviesearch" placeholder="전체 영화">
          <input type="submit" value="검색" name="movie_search">
        </p>
      </form>
    </article>
    <hr size="4" color="#fac60e">
    <article>
      <div align="center">
      <table class="movie chart">
        <tr>
          <th>Movie Name</th>
          <th>Production</td>
          <th>Movie Director</th>
          <th>Year</th>
        </tr>
<?php
      if (isset($_POST['movie_search'])){
        $ms = $_POST['moviesearch'];
        $sqlquery = "SELECT * FROM movielist WHERE movie_name LIKE '%$ms%'";
        $result = mysqli_query($conn, $sqlquery);
        while($row = mysqli_fetch_array($result)){
          echo '<tr><td><a href="moviepage.php?id='.$row['movie_name'].'">'.$row['movie_name'].'</td><td>'.$row['production'].'</td><td>'.$row['director'].'</td><td>'.$row['year'].'</td></tr>';
        }
      }
      if (isset($_GET['id'])){
        $ms = $_GET['id'];
        $sqlquery = "SELECT * FROM movielist WHERE movie_name = '$ms'";
        $result = mysqli_query($conn, $sqlquery);
        $row = mysqli_fetch_array($result);
        echo '<tr><td><a href="moviepage.php?id='.$row['movie_name'].'">'.$row['movie_name'].'</td><td>'.$row['production'].'</td><td>'.$row['director'].'</td><td>'.$row['year'].'</td></tr>';
 ?>
      </table>
      </div>
      <div>
<?php
          echo file_get_contents("data/".$row['movie_name']);
      }
?>
      </div>
    </article>
    <article class="review">
<?php

      if($_SESSION['user_id'] and isset($_GET['id'])){
        $movie_name=$_GET['id']
?>
      <hr color="#fac60e" size="10">
      <div>Review</div>
      <div style="text-align:center">
        <form action="moviepost.php" method="POST">
          <select name="number" id="select">
            <option value="0">0점</option>
  					<option value="1">1점</option>
  					<option value="2">2점</option>
  					<option value="3">3점</option>
  					<option value="4">4점</option>
  					<option value="5">5점</option>
  				</select>
          <textarea name="review" placeholder="Review this movie." id="input_comment"></textarea>
          <?php echo '<input type="hidden" name="movie" value="'.$movie_name.'">' ?>
          <input type="submit" value="리뷰쓰기" name="review_post">
        </form>
      </div>
      <div>

  <?php
      }
  ?>
      <table class="reviewtable">
  <?php
      if (isset($_GET['id'])){
        $movie_name = $_GET['id'];
        $reviewquery = "SELECT * FROM review R WHERE MID IN (SELECT MID FROM movielist WHERE movie_name = '$movie_name')";
        $review_result = mysqli_query($conn, $reviewquery);
        $ratequery = "SELECT AVG(rate) FROM review WHERE MID = (SELECT MID FROM movielist WHERE movie_name = '$movie_name')";
        $rate_result = mysqli_query($conn, $ratequery);
        echo '<tr><th id="userid"></th><th id="userreview">평점 - '.mysqli_fetch_array($rate_result)[0].'</th></tr>';
        while($row = mysqli_fetch_array($review_result)){
          echo '<tr><td id="userid">'.$row['user_id'].'</td><td id="userreview"> '.$row['Review'].'</td></tr>';
        }
      }
  ?>
        </table>
      </div>
    </article>
  </section>
</body>
</html>
