<!DOCTYPE html>
<html lang="en">
<head>
    <?php  include "views/head.php";  ?>    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Вход</title>
    <link rel="stylesheet" href="css/all.css">
</head>
<body>
    <div class="container">

        <?php include "views/header.php"; ?>    

        <section class="login" >
            <h2>
                Вход
            </h2>
            <form action="api/user/signin.php" method="POST">
                <input type="text" name="email" placeholder="Введите email">
                <input type="password" name="password" placeholder="Введите пароль">
                <button>Войти</button>
            </form>
        </section>


    </div>
</body>
</html>