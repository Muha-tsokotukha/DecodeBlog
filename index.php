<?php
	include "config/db.php";
	include "common/time_ago.php";
	$limit = 3;
	$sql = "SELECT b.*, u.nickname, c.name FROM blogs b LEFT OUTER JOIN users u ON b.author_id=u.id LEFT OUTER JOIN categories c ON b.category_id=c.id";
	
	$sql_count =  "SELECT CEIL(COUNT(*)/$limit) as total FROM blogs";

	$category = null;
	if(isset($_GET["category_id"]) && intval($_GET["category_id"])) {
		$sql .= " WHERE b.category_id=".$_GET["category_id"];
		$sql_count .= " WHERE category_id=".$_GET["category_id"];
		$category = $_GET["category_id"];
	}
	
	
	$page = 1; 
	

	if(isset($_GET["page"]) && intval($_GET["page"])){
		$skip = ($_GET['page'] - 1) * $limit;
		$sql .= " LIMIT $skip,$limit ";
		$page = $_GET['page']; 
	}else{
		$sql .= " LIMIT $limit";
	}
	$query_count = mysqli_query($con, $sql_count);
	$count = mysqli_fetch_assoc($query_count);
	

	$query = mysqli_query($con, $sql);

	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Главная</title>
    <?php include "views/head.php"; ?>
</head>
<body>
<?php  include "views/header.php"; ?>

<section class="container page">
	<div class="page-content">
			<h2 class="page-title">Блоги по программированию</h2>
			<p class="page-desc">Популярные и лучшие публикации по программированию для начинающих
 и профессиональных программистов и IT-специалистов.</p>

		<div class="blogs">

			<?php

				
				if(mysqli_num_rows($query) > 0) {
					while($row = mysqli_fetch_assoc($query)) {

			?>


			<div class="blog-item">
				<img class="blog-item--img" src="<?=$BASE_URL; ?>/<?=$row["img"]; ?>" alt="">
				<div class="blog-header">
					<h3><?=$row["title"]; ?></h3>
				</div>
				<p class="blog-desc">
					<?=$row["description"]; ?>
				</p>

				<div class="blog-info">
					<span class="link">
						<img src="<?=$BASE_URL; ?>/images/date.svg" alt="">
						<?php echo to_time_ago(strtotime($row["date"])); ?>
					</span>
					<span class="link">
						<img src="<?=$BASE_URL; ?>/images/visibility.svg" alt="">
						21
					</span>
					<a class="link">
						<img src="<?=$BASE_URL; ?>/images/message.svg" alt="">
						4
					</a>
					<span class="link">
						<img src="<?=$BASE_URL; ?>/images/forums.svg" alt="">
						<?=$row["name"] ?>
					</span>
					<a class="link" href="<?=$BASE_URL; ?>/profile.php?nickname=<?=$row["nickname"] ?>">
						<img src="<?=$BASE_URL; ?>/images/person.svg" alt="">
						
						<?=$row["nickname"] ?>


					</a>
				</div>
			</div>
			<?php
					}
				} else {
			?>

			<h3>0 blogs</h3>
			<?php
				}
			?>

		<?php  

			$cat_str = "";
			if($category){
				$cat_str = "&category_id=$category";
			}


			if( $page != 1 ){

				echo "<a class='pagination-item' href='?page=" . ($page - 1) . "$cat_str' > Prev</a>";
			}

			for($i = 1; $i <= $count["total"]; $i++ ){
				echo "<a class='pagination-item' href='?page=$i$cat_str' >".$i. "</a>";

			}
			if( $page != $count['total']  )
			echo "<a class='pagination-item' href='?page=" . ($page + 1 ). "$cat_str' > Next</a>";
			

		?>

		</div>
	</div>
    <?php include "views/categories.php"; ?>
</section>	
</body>
</html>