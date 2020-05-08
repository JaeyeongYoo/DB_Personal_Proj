<?php
	$conn = mysqli_connect("localhost", "root", "tp97fkdhs", "dbproj");
	$uid = $_GET["userid"];
	$sql = "select * from user where user_id='".$uid."'";
	$member = mysqli_query($conn, $sql);
	if(!$member->num_rows)
  {
?>
	<div style='font-family:"malgun gothic"';><?php echo $uid; ?> 는 사용 가능한 아이디입니다.</div>
<?php
	}else{
?>
	<div style='font-family:"malgun gothic"; color:red;'><?php echo $uid; ?>는 중복된 아이디입니다.<div>
<?php
	}
?>
<br>
<button value="닫기" onclick="window.close()">닫기</button>
<script>
</script>
