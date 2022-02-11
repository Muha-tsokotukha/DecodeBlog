<header class="header container">
	<div class="header-logo">
	    <a href="<?=$BASE_URL; ?>/index.php">Decode Blog</a>	
	</div>
	<form class="header-search" method="GET">
		<input name="page" value="1" type="hidden">
		<input name="q" type="text" class="input-search" placeholder="Поиск по блогам">
		<button type="submit" class="button button-search">
			<img src="<?=$BASE_URL; ?>/images/search.svg" alt="">	
			Найти
		</button>
	</form>
	<div>
	<?php
		
		if(isset($_SESSION["user_id"])) {
	?>
        <a href="<?=$BASE_URL; ?>/profile.php?nickname=<?=$_SESSION["nickname"]?>">
            <img class="avatar" src="<?=$BASE_URL; ?>/images/avatar.png" alt="Avatar">
        </a>

		<?php
		} else {
		?>
        <div class="button-group">
            <a href="<?=$BASE_URL; ?>/register.php" class="button">Регистрация</a>
            <a href="<?=$BASE_URL; ?>/login.php" class="button">Вход</a>
        </div>

		<?php
		}
		?>
	</div>
</header>