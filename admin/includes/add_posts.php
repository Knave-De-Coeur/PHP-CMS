<?php
/**
 * Created by PhpStorm.
 * User: alexa
 * Date: 11/09/2018
 * Time: 12:57
 */
if(isset($_POST['create_post'])) {
//    echo "Working";
    $post_title        = addslashes($_POST['title']);
    $post_category_id  = $_POST['post_category_id'];
//    $post_user         = $_POST['user'];
    $post_author       = addslashes($_POST['author']);
    $post_status       = $_POST['post_status'];

    $post_image        = $_FILES['image']['name'];
    $post_image_temp   = $_FILES['image']['tmp_name'];


    $post_tags         = $_POST['post_tags'];
    $post_content      = addslashes($_POST['post_content']);
    $post_date         = date('d-m-y');
    $post_comment_count = 0;

    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "INSERT INTO posts (Post_Category_Id, Title, Author, Date, Image, Content, Tags, Status) 
              VALUES ({$post_category_id}, '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}'); ";


    $create_post_query = mysqli_query($connection, $query);

    confirmQuery($create_post_query);

}
?>

<form action="" method="post" enctype="multipart/form-data">


    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="post_category_id">Category: </label>
        <br>
        <?php

        $query = "SELECT * FROM categories;";
        $querySelectAllCategories = mysqli_query($connection, $query);
        confirmQuery($querySelectAllCategories);
        ?>

        <select name="post_category_id" id="post-category-select">

            <?php


            while($row = mysqli_fetch_assoc($querySelectAllCategories)) {
                $category_id = $row['Id'];
                $category_title = $row['Title'];
                if($category_id == $post_category_id) {
                    echo "<option selected='selected' value='$category_id'>$category_title</option>";
                }
                else{
                    echo "<option value='$category_id'>$category_title</option>";
                }
            }
            ?>

        </select>
    </div>

    <div class="form-group">
       <label for="title">Post Author</label>
        <input type="text" class="form-control" name="author">
    </div>

    <div class="form-group">
        <select name="post_status" id="">
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
    </div>



    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file"  name="image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control "name="post_content" id="body" cols="30" rows="10"></textarea>
    </div>



    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>


</form>