<?php
	include "config/db.php";
	include "common/time_ago.php";
	$limit = 3;
	$sql = "SELECT b.*, u.nickname, c.name FROM blogs b LEFT OUTER JOIN users u ON b.author_id=u.id LEFT OUTER JOIN categories c ON b.category_id=c.id";
	
	$sql_count =  "SELECT CEIL(COUNT(*)/$limit) as total FROM blogs b LEFT OUTER JOIN users u ON b.author_id=u.id";

	$category = null;
	if(isset($_GET["category_id"]) && intval($_GET["category_id"])) {
		$sql .= " WHERE b.category_id=".$_GET["category_id"];
		$sql_count .= " WHERE b.category_id=".$_GET["category_id"];
		$category = $_GET["category_id"];
	}
	$q = "";
	if(isset($_GET["q"])){
		$q =strtolower($_GET["q"]);
		$sql .= " WHERE LOWER(b.title) LIKE ? OR LOWER(b.description) LIKE ? OR LOWER(u.nickname) LIKE ?";
		$sql_count .= " WHERE LOWER(b.title) LIKE ? OR LOWER(b.description) LIKE ? OR LOWER(u.nickname) LIKE ?";
	}



	$page = 1; 
	if(isset($_GET["page"]) && intval($_GET["page"])){
		$skip = ($_GET['page'] - 1) * $limit;
		$sql .= " LIMIT $skip,$limit ";
		$page = $_GET['page']; 
	}else{
		$sql .= " LIMIT $limit";
	}

	if( $q ){
		$param = "%$q%";
		$prep_count = mysqli_prepare($con,$sql_count );
		mysqli_stmt_bind_param($prep_count, "sss",$param,$param,$param);
		mysqli_stmt_execute($prep_count);
		$query_count = mysqli_stmt_get_result($prep_count);
		$count = mysqli_fetch_assoc($query_count);
		
		$prep_blogs = mysqli_prepare($con,$sql);
		mysqli_stmt_bind_param($prep_blogs, "sss",$param,$param,$param);
		mysqli_stmt_execute($prep_blogs);
		$query = mysqli_stmt_get_result($prep_blogs);
	}
	else{
		$query_count = mysqli_query($con,$sql_count);
		$count = mysqli_fetch_assoc($query_count);

		$query = mysqli_query($con, $sql);
	}

	
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
			$q_str = "";
			if( $q ){
				$q_str = "&q=$q";
			}

			if( $page != 1 ){

				echo "<a class='pagination-item' href='?page=" . ($page - 1) . "$cat_str$q_str' > Prev</a>";
			}

			for($i = 1; $i <= $count["total"]; $i++ ){
				echo "<a class='pagination-item' href='?page=$i$cat_str$q_str' >".$i. "</a>";

			}
			if( $page != $count['total']  )
			echo "<a class='pagination-item' href='?page=" . ($page + 1 ). "$cat_str$q_str' > Next</a>";
			

		?>

		</div>
	</div>
    <?php include "views/categories.php"; ?>
</section>	
</body>
</html>