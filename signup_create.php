<?php
$conn = mysqli_connect("localhost", "root", "tp97fkdhs", "dbproj");
$sql = "
  INSERT INTO user
    (user_id, password, name, created)
    VALUES(
        '{$_POST['userid']}',
        '{$_POST['pw']}',
        '{$_POST['user_name']}',
        NOW()
    )
";
$result = mysqli_query($conn, $sql);
if($result === false){
?>
  <script type="text/javascript">
    alert('회원가입에 실패했습니다.');
    history.back(-1);
  </script>
<?php
  error_log(mysqli_error($conn));
}else{
?>
  <script type="text/javascript">
    alert('회원가입이 완료되었습니다.');
    location.href = 'mainpage.php';
  </script>
<?php
}
 ?>
<meta charset="utf-8">
