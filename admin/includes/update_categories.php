
<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Edit Category</label>

        <?php
        if(isset($_GET['edit'])) {
            $idToEdit = $_GET['edit'];
            $query = "SELECT * FROM categories WHERE Id = {$idToEdit}; ";
            $select_categories_id = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($select_categories_id)) {
                $cat_id = $row['Id'];
                $cat_title = $row['Title'];
                echo $cat_id;
                ?>
                <input type="text" id="cat-title" class="form-control"
                       name="cat_title" value="<?php if (isset($cat_title)) echo $cat_title; ?>">

                <?php
            }

        }

        ?>

        <?php // update

        UpdateCategory($cat_id);

        ?>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
    </div>
</form>
