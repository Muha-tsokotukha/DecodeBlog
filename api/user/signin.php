<?php
    include "../../config/db.php";
    include "../../config/base_url.php";

    if(isset($_POST["email"], $_POST["password"]) &&
    strlen($_POST["email"]) > 0 && 
    strlen($_POST["password"]) > 0) {
        $email = $_POST["email"];
        $pass = $_POST["password"];
        $hash = sha1($pass);

        $prep = mysqli_prepare($con, "SELECT id, nickname FROM users WHERE email=? AND password=?");
        mysqli_stmt_bind_param($prep, "ss", $email, $hash);
        mysqli_stmt_execute($prep);
        $query = mysqli_stmt_get_result($prep);
        if(mysqli_num_rows($query) != 1) {
            header("Location: $BASE_URL/login?error=8");
            exit();
        }

        $row = mysqli_fetch_assoc($query);

        session_start();
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["nickname"] = $row["nickname"];
        header("Location: $BASE_URL/profile?nickname=".$row["nickname"]);

    } else {
        header("Location: $BASE_URL/login?error=7");
    }

?>