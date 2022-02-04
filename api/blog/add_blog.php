<?php
    include "../../config/db.php";
    include "../../config/base_url.php";

    if(isset($_POST["title"]) && strlen($_POST["description"]) > 0 && 
    isset($_POST["description"]) && strlen($_POST["title"]) > 0 )
    {
        $title = $_POST["title"];
        $desc = $_POST["description"];
        
        session_start();
        $user_id = $_SESSION["user_id"];

        if(isset($_FILES["image"]) && isset($_FILES["image"]["name"]) && strlen($_FILES["image"]["name"]) > 0) {
            $ext = end(explode(".",$_FILES["image"]["name"]));
            $image_name = time().".".$ext;
            move_uploaded_file($_FILES["image"]["tmp_name"],"../../img/blogs/$image_name" );

            
            $path = "/img/blogs/".$image_name ;
            $prep = mysqli_prepare($con, "INSERT INTO blogs ( title, description,img, author_id ) VALUES (?,?, ?,? )");
            mysqli_stmt_bind_param($prep,"sssi", $title, $desc,$path, $user_id);
            mysqli_stmt_execute($prep);
        }
        else{
            $prep = mysqli_prepare($con, "INSERT INTO blogs ( title, description,author_id ) VALUES (?,?,? )");
            mysqli_stmt_bind_param($prep,"ssi", $title, $desc, $user_id );
            mysqli_stmt_execute($prep);
        }
        

        header("Location: $BASE_URL/profile.php");
    }else{
        header("Location: $BASE_URL/newBlog.php?error=3");
    }
?>
