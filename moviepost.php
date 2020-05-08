<?php
  session_start();

  $conn = mysqli_connect("localhost", "root", "tp97fkdhs", "dbproj");

  if (isset($_POST['review_post'])){
    $review_text=$_POST['review'];
    $review_score=$_POST['number'];
    $review_id=$_SESSION['user_id'];
    $review_movie=$_POST['movie'];

    $find_uid = "SELECT PID FROM user WHERE user_id = '$review_id'";
    $find_mid = "SELECT MID FROM movielist WHERE movie_name = '$review_movie'";
    $result_uid = mysqli_query($conn, $find_uid);
    $result_mid = mysqli_query($conn, $find_mid);

    if($result_uid === false or $result_mid === false){
?>
      <script type="text/javascript">
        alert('리뷰등록에 실패했습니다.');
        history.back(-1);
      </script>
<?php
    }else{
      $uid = mysqli_fetch_array($result_uid)[0];
      $mid = mysqli_fetch_array($result_mid)[0];

      $insert_review = "INSERT INTO review VALUES($uid, '$review_id', $mid, $review_score, '$review_text')";
      $result_review = mysqli_query($conn, $insert_review);
      if($result_review === false){
?>
        <script type="text/javascript">
          alert('리뷰등록에 실패했습니다.');
          history.back(-1);
        </script>
<?php
      }else{
?>
        <script type="text/javascript">
          alert('리뷰등록에 성공했습니다.');
          history.back(-1);
        </script>
<?php
      }
    }
  }
?>
