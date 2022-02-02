<?php  include "views/head.php";
        include "config/db.php";
        include "config/base_url.php";
        

    if( isset($_GET["id"]) ){
        $id = $_GET["id"];
        $query = mysqli_query($con,"SELECT * FROM blogs 
        WHERE id=$id");
        
        if( mysqli_num_rows($query) > 0 ){
            $row = mysqli_fetch_assoc($query);
        

?>

<!DOCTYPE html>
<html lang="en">
<head>
    

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edit Blog</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/comps/nav.css">
    <link rel="stylesheet" href="css/comps/new_blog.css">
    <link rel="stylesheet" href="css/comps/typography.css">
    
    
    
</head>
<body>

    <?php 
        include "views/header.php";
    ?>

    <section>

        <div class="container">  
            <form action="<?=$BASE_URL ?>/api/blog/update.php?id=<?=$id?>" method="POST" enctype="multipart/form-data">
                
                <h1>Редактировать блог</h1>
                <input type="text" placeholder="Заголовок блога" name="title" value="<?=$row["title"]?>">
                <select name="" id="" >
                    <option value="" disabled selected>Выберите категорию</option>
                </select>

                <input type="file" name="image">
                
                <textarea name="description" id="" cols="30" rows="10"><?=$row["description"]?></textarea>
                <button type="sumbit">Сохранить</button>
                <?php 
                    if(isset($_GET["error"])){

                ?>
                    <p class="text-danger">Title and description cannot be empty!</p>
                <?php 
                    }
                ?>
            </form>
        </div>
    </section>

</body>
</html>
<?php 
    } else{
        header("Location: $BASE_URL/profile.php");
    }
} else {
    header("Location: $BASE_URL/profile.php");
}
?>