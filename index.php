<?php 
    include "common/time_ago.php";
    include "config/db.php";
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php  include "views/head.php";  ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Decode Blog</title>
    
    <link rel="stylesheet" href="css/vendor/reset.css">
    <link rel="stylesheet" href="css/comps/sign_in.css">
    <link rel="stylesheet" href="css/comps/sign_in2.css">
    <link rel="stylesheet" href="css/comps/nav.css">
    <link rel="stylesheet" href="css/comps/1categs.css">
    <link rel="stylesheet" href="css/comps/blogs.css">
    
    
    
    
</head>
<body>

    <?php include "views/header.php"; ?>    

    

    <div class="container">
        
        <div class="topic">
            <h1>Блоги по программированию</h1>
            <p>Популярные и лучшие публикации по программированию для начинающихи </p>
            <p style="margin-left: 12%;">профессиональных программистов и IT-специалистов.</p>
        </div>  



            <?php
                $query = mysqli_query($con, "SELECT b.*, u.nickname FROM blogs b left outer join users u on b.author_id=u.id");

                if( mysqli_num_rows($query) > 0 ){
                    while($row = mysqli_fetch_assoc($query) ){        
            ?>
        
        <div class="blog">
            
            <div class="blog-edit">
            </div>
                
            <img class="blog-image" src="<?php echo $BASE_URL.$row["img"]; ?>" alt="">
            <h3> <?= $row["title"]  // these are php ?>   </h3>

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
                <div class="blog-info--comments" >
                    <img src="img/Shape.png" alt="">
                    4
                </div>
                <!-- <div class="blog-info--topic"></div> -->
                <div class="blog-info--author">
                    <img src="img/author.png" alt="">
                    <a href="<?=$BASE_URL?>/profile.php?nickname=<?=$row["nickname"]?>">
                        <?php echo $row["nickname"]?>
                    </a>
                </div>

            </div>
            
        </div>
                        
            <?php 
                    }}
                else{
                    echo "No blogs!";
                }
            ?>
        

        



    </div>

    <section class="categories">
        <h2>Категории</h2>
        <a href="">Прогнозы в IT</a>
        <a href="">Веб-разработка</a>
        <a href="">Мобильная разработка</a>
        <a href="">Фриланс</a>
        <a href="">Алгоритмы</a>
        <a href="">Тестирование IT систем</a>
        <a href="">Разработка игр</a>
        <a href="">Дизайн и юзабилити</a>
        <a href="">Искуственный интеллект</a>
        <a href="">Машинное обучение</a>

    </section>
</body>
</html>