<!DOCTYPE html>
<html lang="en">
<head>
    <?php  include "views/head.php";  ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/all.css">
</head>
<body>
    
    <?php include "views/header.php"; ?>    


        <section class="login">
            <h2 style="margin-left: 25%;"> <!-- Костыль -->
                Регистрация
            </h2>
            <form action="api/user/signup.php" method="POST">
                <input type="text" name="email" placeholder="Введите email">
                <input type="text" name="full_name" placeholder="Введите полное имя">
                <input type="text" name="nickname" placeholder="Введите никнейм">
                <input type="password" name="password" placeholder="Введите пароль">
                <input type="password" name="password2" placeholder="Подтвердите пароль">
                <button type="submit">Зарегистрироваться</button>
            </form>
            
        </section>


    </div>
</body>
</html>