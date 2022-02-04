<div class="nav">
            
        <div class="nav-logo">
            <a href="<?=$BASE_URL?>/index.php" STYLE="text-decoration:none;color:inherit;">
                Decode Blog
            </a>
        </div>

        <div class="nav-search">
            <input class="nav-search--bar" placeholder="Поиск по блогам">
            </input>
            <div class="nav-search--search">
                <img src="img/search.png" alt="search">
                Найти
            </div>
        </div>

        <?php 
        
            
            if(isset($_SESSION["user_id"]))
            {
        ?>
        <div class="nav-auth" >
            <a href="<?=$BASE_URL?>/profile.php?nickname=<?=$_SESSION['nickname']?>" style="background-color: inherit;border: none;"  >
                <img src="img/avatar.png" alt="">
            </a>
        </div>
        <?php 
            }
            else{
        ?>

        <div class="nav-auth">
                <a href="reg.php">Регистрация</a>
                <a href="login.php">Вход</a>
        </div>
        
        <?php 
            }
        ?>

        
</div>