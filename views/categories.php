
<div class="page-info">
		<div class="page-header">
            <h2>Категории</h2>
        </div>
<?php
    $query = mysqli_query($con, "SELECT * FROM categories");
    while($category = mysqli_fetch_assoc($query)) {
        echo "<a class='list-item' href='?category_id=" . $category["id"] . "'>" . $category["name"] . "</a>";
    }
?>
       
</div>