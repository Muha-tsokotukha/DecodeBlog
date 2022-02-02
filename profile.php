<?php include "config/db.php"; 
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php  include "views/head.php";
            include "common/time_ago.php";
    
            session_start();
            if(!$_SESSION["user_id"]){
            header("Location: $BASE_URL/mainPage.php");
            }
    ?>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Decode Blog</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/comps/blogs.css">
    <link rel="stylesheet" href="css/comps/categs.css">
    <link rel="stylesheet" href="css/comps/nav.css">
</head>
<body>

    <?php include "views/header.php";?>
    

    <div class="container">
        
        <div class="topic">
            <h1>Мои блоги</h1>
            <a href="<?=$BASE_URL ?>/newBlog.php">Новый блог</a>    
        </div>  




        

        
        <?php
                $query = mysqli_query($con, "SELECT * FROM blogs");

                if( mysqli_num_rows($query) > 0 ){
                    while($row = mysqli_fetch_assoc($query) ){

                    
        ?>
        <!-- Getting blog posts -->
        <div class="blog">
            
            <div class="blog-edit">
                <h3> <?= $row["title"]  // these are php ?>   </h3>
                <span class="blog-edit--dots">&#65049;</span> 
                <ul>
                    <li><a href="<?=$BASE_URL?>/editblog.php?id=<?=$row["id"]?>">Редактировать</a></li>
                    <li ><a style="color: red;" href="<?=$BASE_URL?>/api/blog/delete.php?id=<?=$row["id"]?>">Удалить</a></li>
                </ul>
            </div>
            
            <img class="blog-image" src="<?php echo $BASE_URL.$row["img"]; ?>" alt="">

            <p>  <?= $row["description"] // these are php ?> </p>
            <div class="blog-info">

                <div class="blog-info--date">
                    <img src="img/calendar.png" alt="">
                    <?php echo to_time_ago(strtotime($row["date"])); ?>
                    
                </div>
                <div class="blog-info--views">
                    <img src="img/eye.png" alt="">
                    21
                </div>
                <div class="blog-info--comments">
                    <img src="img/Shape.png" alt="">
                    4
                </div>
                <!-- <div class="blog-info--topic"></div> -->
                <div class="blog-info--author">
                    <img src="img/author.png" alt="">
                    Nast1289
                </div>

            </div>
            
        </div>
        <?php 
                    }
                }else{ 
        ?>        
            <h5>No blogs yet!</h5>  
        <?php 
                } 
        ?>        

    </div>

    <section class="categories">
        <img src="img/avatar.png" alt="">
        <h4>Елнур Сеитжанов</h4>
        <p>В основном пишу про веб-разработку на React & Redux </p>
        <p>285 постов за все время</p>

        <button>  <!-- maybe should use a -->
            Редактировать  
        </button>

        <button class="button-danger"><a href="api/user/signout.php" >Выйти</a></button>
    </section>
</body>

</html>
