<?php
	include "config/db.php";
	include "config/base_url.php";
	if(isset($_GET["id"])) {
		$id = $_GET["id"];
		$query = mysqli_query($con, "SELECT * FROM blogs WHERE id=$id");

		if(mysqli_num_rows($query) > 0) {

			$row = mysqli_fetch_assoc($query);

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Редактировать блог</title>
	<?php include "views/head.php"; ?>
</head>
<body>
	<?php include "views/header.php"; ?>	

	<section class="container page">
		<div class="page-block">

			<div class="page-header">
				<h2>Редактировать блог</h2>
			</div>
			<form class="form" action="api/blog/update?id=<?=$id; ?>" method="POST" enctype="multipart/form-data">
				
				<fieldset class="fieldset">
					<input class="input" type="text" name="title" placeholder="Заголовок" value="<?=$row['title'];?>">
				</fieldset>

				<fieldset class="fieldset">
					<select name="category_id" class="input" value="<?=$row['category_id'];?>">
						<?php

							$query = mysqli_query($con, "SELECT * FROM categories");
							while($category = mysqli_fetch_assoc($query)) {
								if($category["id"] == $row['category_id']) {
									echo "<option value='".$category["id"]."' selected>".$category["name"]."</option>";
								} else {
									echo "<option value='".$category["id"]."'>".$category["name"]."</option>";
								}
								
							}
						?>
					</select>
				</fieldset class="fieldset">

				<fieldset class="fieldset">
					<button class="button button-yellow input-file">
						<input type="file" name="image">	
						Выберите картинку
					</button>
				</fieldset>
					
				<fieldset class="fieldset">
					<textarea class="input input-textarea" name="description" id="" cols="30" rows="10" placeholder="Описание"><?=$row['description'];?></textarea>
				</fieldset>
				<fieldset class="fieldset">
					<button class="button" type="submit">Сохранить</button>
				</fieldset>
			</form>

			<?php
				if(isset($_GET["error"]) && $_GET["error"] == 3) {
			?>

				<p class="text-danger"> Заголовок и Описание не могут быть пустыми!</p>


			<?php
				}
			?>


		</div>

	</section>
	
	

	
	
</body>
</html>
<?php

	} else {
		header("Location: $BASE_URL/profile");
	}
} else {
	header("Location: $BASE_URL/profile");
}
?>