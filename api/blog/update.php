<?php
    include "../../config/db.php";
    include "../../config/base_url.php";

    if(isset($_POST["title"]) && strlen($_POST["description"]) > 0 && 
    isset($_POST["description"]) && strlen($_POST["title"]) > 0 &&
    isset($_GET["id"]) &&
    strlen($_GET["id"]) > 0 )
    {
        $id = $_GET["id"];
        $desc = $_POST["description"];
        $title = $_POST["title"];
        if(isset($_FILES["image"]) && isset($_FILES["image"]["name"]) && strlen($_FILES["image"]["name"]) > 0) {
            
            $query = mysqli_query($con, "SELECT img FROM blogs WHERE id=$id");
            if(  mysqli_num_rows($query) >  0 ){
                $row = mysqli_fetch_assoc($query);
                $old_path = __DIR__ . "/../../".$row["img"];
                if(file_exists($old_path)){
                    unlink($old_path);
                }
            }
            
            $ext = end(explode(".",$_FILES["image"]["name"]));
            $image_name = time().".".$ext;
            move_uploaded_file($_FILES["image"]["tmp_name"],"../../img/blogs/$image_name" );

            
            $path = "/img/blogs/".$image_name ;
            $prep = mysqli_prepare($con, "UPDATE blogs set  title=?, description=?,img=? where id=$id");
            mysqli_stmt_bind_param($prep,"sss", $title, $desc,$path);
            mysqli_stmt_execute($prep);
        }
        else{
            $prep = mysqli_prepare($con, "UPDATE blogs set  title=?, description=? where id=$id");
            mysqli_stmt_bind_param($prep,"ss", $title, $desc );
            mysqli_stmt_execute($prep);
        }
        

        header("Location: $BASE_URL/profile.php");
    }else{
        header("Location: $BASE_URL/editblog.php?id=".$_GET["id"]."&error=3");
    }
?>
