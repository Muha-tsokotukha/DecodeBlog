<?php 
	include "config/db.php";
	include "config/base_url.php";

	if(!isset($_GET["id"]) || !intval($_GET["id"])){
		header("Location: $BASE_URL");
		exit();
	}
	$id = $_GET["id"];
	$query_blog = mysqli_query($con, "SELECT b.*,u.nickname,c.name FROM blogs b LEFT OUTER JOIN users u on b.author_id=u.id LEFT OUTER JOIN categories c ON b.category_id=c.id WHERE b.id=$id");
	$comment_count = mysqli_num_rows(mysqli_query($con, "SELECT id FROM comments WHERE blog_id=".$id));

	if( mysqli_num_rows($query_blog) == 0 ){
		header("Location: $BASE_URL");
		exit();
	}
	$blog = mysqli_fetch_assoc($query_blog);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Профиль</title>
    <?php include "views/head.php"; ?>
</head>

<?php 
	if( (isset($_SESSION["user_id"]) && $_SESSION["user_id"] != $blog["author_id"]) || !isset($_SESSION["user_id"])  ){
		$update = mysqli_query($con, "UPDATE blogs SET views=(views+1) WHERE id=".$blog["id"] );
	}
?>


<body data-baseurl="<?=$BASE_URL;?>" data-authorid="<?=$blog['author_id']?>">

<?php  include "views/header.php"; ?>

<section class="container page">
<div class="page-content">
		<div class="blogs">
			<div class="blog-item">
				<img class="blog-item--img" src="<?=$BASE_URL; ?>/<?=$blog["img"]?>" alt="">

                <div class="blog-info">
					<span class="link">
						<img src="<?=$BASE_URL; ?>/images/date.svg" alt="">
						26.06.2020
					</span>
					<span class="link">
						<img src="<?=$BASE_URL; ?>/images/visibility.svg" alt="">
						<?=$blog["views"]?>
					</span>
					<a class="link">
						<img src="<?=$BASE_URL; ?>/images/message.svg" alt="">
						<?=$comment_count?>
					</a>
					<span class="link">
						<img src="<?=$BASE_URL; ?>/images/forums.svg" alt="">
						<?=$blog["name"]?>
					</span>
					<a class="link">
						<img src="<?=$BASE_URL; ?>/images/person.svg" alt="">
						<?=$blog["nickname"]?>
					</a>
				</div>

				<div class="blog-header">
					<h3>Обзор Report Manager от Webix</h3>
				</div>
				<p class="blog-desc">
					<?=$blog["description"]?>
				</p>
			</div>
		</div>

        <div id="comments" class="comments">
            

            
        </div>

		<?php 
			if(isset($_SESSION["user_id"])){
		?>

		<span class="comment-add">
                <textarea name="" id="comment-text" class="comment-textarea" placeholder="Введит текст комментария"></textarea>
                <button id="add-comment" class="button">Отправить</button>
        </span>
        
		<?php 
			}
			else{
		?>
		<span class="comment-warning">
                Чтобы оставить комментарий <a href="register">зарегистрируйтесь</a> , или  <a href="login">войдите</a>  в аккаунт.
        </span>
		<?php }?>
	</div>

    <?php include "views/categories.php"; ?>
	
</section>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.0/axios.min.js"></script>
	<script src="<?=$BASE_URL?>/js/comment.js"></script>
</body>
</html>