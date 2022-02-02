<?php
    include "../../config/db.php";
    include "../../config/base_url.php";

    if(isset($_POST["title"]) && strlen($_POST["description"]) > 0 && 
    isset($_POST["description"]) && strlen($_POST["title"]) > 0 )
    {
        $title = $_POST["title"];
        $desc = $_POST["description"];
        
        if(isset($_FILES["image"]) && isset($_FILES["image"]["name"]) && strlen($_FILES["image"]["name"]) > 0) {
            $ext = end(explode(".",$_FILES["image"]["name"]));
            $image_name = time().".".$ext;
            move_uploaded_file($_FILES["image"]["tmp_name"],"../../img/blogs/$image_name" );

            
            $path = "/img/blogs/".$image_name ;
            $prep = mysqli_prepare($con, "INSERT INTO blogs ( title, description,img ) VALUES (?,?, ? )");
            mysqli_stmt_bind_param($prep,"sss", $title, $desc,$path);
            mysqli_stmt_execute($prep);
        }
        else{
            $prep = mysqli_prepare($con, "INSERT INTO blogs ( title, description ) VALUES (?,? )");
            mysqli_stmt_bind_param($prep,"ss", $title, $desc );
            mysqli_stmt_execute($prep);
        }
        

        header("Location: $BASE_URL/profile.php");
    }else{
        header("Location: $BASE_URL/newBlog.php?error=3");
    }
?>
