<?php
    include "../../config/db.php";
    include "../../config/base_url.php";

    if(isset($_POST["title"], $_POST["description"], $_POST["category_id"], $_GET["id"]) && 
        strlen($_POST["title"])> 0 && 
        strlen($_POST["description"])> 0 && 
        intval($_GET["id"]) && intval($_POST["category_id"])) {
            $title = $_POST["title"];
            $desc = $_POST["description"];
            $id = $_GET["id"];
            $category_id = $_POST["category_id"];
            session_start();
            if(isset($_FILES["image"]) && isset($_FILES["image"]["name"]) 
            && strlen($_FILES["image"]["name"])> 0) {
                
                $query = mysqli_query($con, "SELECT img FROM blogs WHERE id=$id");
                if(mysqli_num_rows($query) > 0) {
                    $row = mysqli_fetch_assoc($query);
                    $old_path = __DIR__ . "/../../".$row["img"];
                    if(file_exists($old_path)) {
                        unlink($old_path);
                    }
                }
  
                $ext = end(explode(".", $_FILES["image"]["name"]));
                $image_name = time().".".$ext;
                move_uploaded_file($_FILES["image"]["tmp_name"], "../../images/blogs/$image_name");
                $prep = mysqli_prepare($con, "UPDATE blogs SET title=?, description=?, img=?, category_id=? WHERE id=? AND author_id=".$_SESSION["user_id"]);
                $path = "/images/blogs/".$image_name;
                mysqli_stmt_bind_param($prep, "sssii", $title, $desc, $path, $category_id, $id);
                mysqli_stmt_execute($prep);
            } else {
                $prep = mysqli_prepare($con, "UPDATE blogs SET title=?, description=?, category_id=? WHERE id=?  AND author_id=".$_SESSION["user_id"]);
                mysqli_stmt_bind_param($prep, "ssii", $title, $desc, $category_id, $id);
                mysqli_stmt_execute($prep);
            }
            
            header("Location: $BASE_URL/profile.php?nickname=".$_SESSION["nickname"]);
    } else {
        header("Location: $BASE_URL/editblog.php?id=".$_GET['id']."&error=3");
    }
?>