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
    <article style="font-size: 40px; margin-bottom: 20px">
      현재 상영중인 영화
      <div style="text-align: right">
      <form action="mainpage.php" method="GET">
        <select name="Sorted_By" style="text-align: right" id="sort">
          <option value="0">평점 높은 순</option>
          <option value="movie_name">이름 순</option>
          <option value="year">최근 순</option>
        </select>
        <select name="Genre" style="text-align: right" id="genre">
          <option value="0">장르</option>
          <option value="Fantasy">판타지</option>
          <option value="Action">액션</option>
          <option value="Thriller">스릴러</option>
          <option value="Comedy">코미디</option>
          <option value="Animation">애니메이션</option>
          <option value="Drama">드라마</option>
        </select>
        <input type="submit" name="sorted" value="확인">
      </form>
      </div>
    </article>
    <hr size="4" color="#fac60e">
      <div align="center">
      <table class="movie chart">
        <tr>
          <th>Movie Name</th>
          <th>Production</td>
          <th>Movie Director</th>
          <th>Year</th>
          <th>ETC</th>
        </tr>
<?php
      if(isset($_GET['Sorted_By']) and isset($_GET['Genre'])){
        $sort_value=$_GET['Sorted_By'];
        $genre_value=$_GET['Genre'];

        if($sort_value == year){
          if($genre_value === '0'){
            $sqlquery = "SELECT * FROM movielist ORDER BY $sort_value DESC";
          }else{
            $sqlquery = "SELECT * FROM movielist WHERE genre='$genre_value' ORDER BY $sort_value DESC";
          }

          $result = mysqli_query($conn, $sqlquery);
          while($row = mysqli_fetch_array($result)){
              echo '<tr><td>'.$row['movie_name'].'</td><td>'.$row['production'].'</td><td>'.$row['director'].'</td><td>'.$row['year'].'</td><td>'.$row['genre'].'</td></tr>';
          }

        }elseif ($sort_value == movie_name) {
          if($genre_value === '0'){
            $sqlquery = "SELECT * FROM movielist ORDER BY $sort_value";
          }else{
            $sqlquery = "SELECT * FROM movielist WHERE genre='$genre_value' ORDER BY $sort_value";
          }

          $result = mysqli_query($conn, $sqlquery);
          while($row = mysqli_fetch_array($result)){
              echo '<tr><td>'.$row['movie_name'].'</td><td>'.$row['production'].'</td><td>'.$row['director'].'</td><td>'.$row['year'].'</td><td>'.$row['genre'].'</td></tr>';
          }
        }else{
          if($genre_value === '0'){
            $sqlquery = "SELECT M.movie_name, M.production, M.director, M.year, M.genre, avg(R.rate)
            FROM movielist M
            LEFT JOIN review R
            ON M.MID = R.MID
            GROUP BY M.movie_name, M.production, M.director, M.year, M.genre, R.MID
            ORDER BY avg(R.rate) desc";
          }else{
            $sqlquery = "SELECT M.movie_name, M.production, M.director, M.year, M.genre, avg(R.rate)
            FROM movielist M
            LEFT JOIN review R
            ON M.MID = R.MID
            WHERE M.genre='$genre_value'
            GROUP BY M.movie_name, M.production, M.director, M.year, M.genre, R.MID
            ORDER BY avg(R.rate) desc";
          }
          $result = mysqli_query($conn, $sqlquery);
          while($row = mysqli_fetch_array($result)){
            if( is_null($row['avg(R.rate)'])){
              echo '<tr><td>'.$row['movie_name'].'</td><td>'.$row['production'].'</td><td>'.$row['director'].'</td><td>'.$row['year'].'</td><td style="font-size:15px">'.$row['genre'].'/평점 없음</td></tr>';
            }else{
              echo '<tr><td>'.$row['movie_name'].'</td><td>'.$row['production'].'</td><td>'.$row['director'].'</td><td>'.$row['year'].'</td><td style="font-size:15px">'.$row['genre'].'/'.$row['avg(R.rate)'].'</td></tr>';
            }
          }
        }
        //echo $sqlquery;
      }else{
        $sqlquery = "SELECT * FROM movielist";
        $result = mysqli_query($conn, $sqlquery);
        while($row = mysqli_fetch_array($result)){
          echo '<tr><td>'.$row['movie_name'].'</td><td>'.$row['production'].'</td><td>'.$row['director'].'</td><td>'.$row['year'].'</td></tr>';
        }
      }
 ?>
      </table>
      </div>
  </section>

</body>
</html>
