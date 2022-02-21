<?php 
    include "../../config/db.php";
    
    if( isset($_GET["nickname"]) && strlen($_GET["nickname"]) > 0 && (intval($_GET["page"]) || $_GET["page"] == 0 ) ){
        session_start();
        $page = $_GET["page"];

        $limit = 3;
        $skip = $page * $limit;
        $prep = mysqli_prepare($con, "SELECT b.*,c.name, u.nickname FROM blogs b LEFT OUTER JOIN categories c on b.category_id=c.id LEFT OUTER JOIN users u on b.author_id=u.id WHERE u.nickname=? LIMIT $skip, $limit");
        mysqli_stmt_bind_param($prep, "s", $_GET["nickname"]);
        mysqli_stmt_execute($prep);
        $query = mysqli_stmt_get_result($prep);

        $blogs = array();
        if( mysqli_num_rows($query) > 0 ){
            while($row = mysqli_fetch_assoc($query)){
                $blogs[] = $row;
            }
        }
        echo json_encode($blogs);
    }
?>