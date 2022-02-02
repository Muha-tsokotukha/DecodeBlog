<?php 

    include "../../config/db.php";
    include "../../config/base_url.php";

    if( isset( $_GET["id"])){
        mysqli_query($con, "DELETE FROM blogs 
        WHERE id=".$_GET["id"]);

        header("Location: $BASE_URL/profile.php");
    }
    else{
        header("Location: $BASE_URL/profile.php?error=1");
    }


?>