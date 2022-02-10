<?php
    include "../../config/db.php";
    include "../../config/base_url.php";

    if(isset($_POST["title"], $_POST["description"], $_POST["category_id"]) && 
        strlen($_POST["title"])> 0 && 
        strlen($_POST["description"])> 0 && intval($_POST["category_id"])) {
            $title = $_POST["title"];
            $desc = $_POST["description"];
            $cat_id = $_POST["category_id"];
            
            session_start();
            $user_id = $_SESSION["user_id"];

            if(isset($_FILES["image"]) && isset($_FILES["image"]["name"]) 
            && strlen($_FILES["image"]["name"])> 0) {
                $ext = end(explode(".", $_FILES["image"]["name"]));
                $image_name = time().".".$ext;
                move_uploaded_file($_FILES["image"]["tmp_name"], "../../images/blogs/$image_name");
                $prep = mysqli_prepare($con, "INSERT INTO blogs (title, description, img, author_id, category_id) VALUES (?, ?, ?, ?, ?)");
                $path = "/images/blogs/".$image_name;
                mysqli_stmt_bind_param($prep, "sssii", $title, $desc, $path, $user_id, $cat_id);
                mysqli_stmt_execute($prep);
            } else {
                $prep = mysqli_prepare($con, "INSERT INTO blogs (title, description, author_id, category_id) VALUES (?, ?, ?, ?)");
                mysqli_stmt_bind_param($prep, "ssii", $title, $desc, $user_id, $cat_id);
                mysqli_stmt_execute($prep);
            }
            header("Location: $BASE_URL/profile.php?nickname=".$_SESSION["nickname"]);
    } else {
        header("Location: $BASE_URL/newblog.php?error=3");
    }
?>