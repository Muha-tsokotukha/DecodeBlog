<?php 
	include "config/db.php";
	include "common/time_ago.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Профиль</title>
	<?php 
	include "views/head.php"; 
	if(!isset($_SESSION["user_id"])) {
		header("Location: $BASE_URL");
		exit();
	}

	?>
</head>
<body data-baseurl="<?=$BASE_URL?>">

<?php  
	include "views/header.php";
?>

<section class="container page">
	<div class="page-content">
		<div class="page-header">
			<h2>Мои блоги</h2>
			<a class="button" href="<?=$BASE_URL ?>/newblog.php">Новый блог</a>
		</div>

		<div class="blogs">
		</div>
		
	</div>
	<div class="page-info">
		<div class="user-profile">
			<img class="user-profile--ava" src="<?=$BASE_URL; ?>/images/avatar.png" alt="">

			<h1>Елнур Сеитжанов</h1>
			<h2>В основном пишу про веб - разработку, на React & Redux</h2>
			<p>285 постов за все время</p>
			<a href="" class="button">Редактировать</a>

			<a href="api/user/signout.php" class="button button-danger">Выход</a>
		</div>
	</div>
</section>	

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.0/axios.min.js"></script>
<script src="<?=$BASE_URL?>/js/profile.js"></script>
</body>
</html>