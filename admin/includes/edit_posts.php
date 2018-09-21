<?php
/**
 * Created by PhpStorm.
 * User: alexa
 * Date: 11/09/2018
 * Time: 12:57
 */
if(isset($_GET['p_id'])) {
    $post_id = $_GET['p_id'];

    $query = "SELECT * FROM posts WHERE Id =  $post_id; ";

    $queryPostById = mysqli_query($connection, $query);

    confirmQuery($queryPostById);

    while($row = mysqli_fetch_assoc($queryPostById)){
        $post_Id = $row['Id'];
        $post_title = $row['Title'];
        $post_author = $row['Author'];
        $post_category_id = $row['Post_Category_Id'];
        $post_date = $row['Date'];
        $post_image = $row['Image'];
        $post_content = $row['Content'];
        $post_tags = $row['Tags'];
        $post_comment = $row['Comment_Count'];
        $post_status = $row['Status'];
    }
}

if(isset($_POST['update_post'])) {
    $post_title         = $_POST['title'];
    $post_category_id   = $_POST['post_category_id'];
    $post_author        = $_POST['author'];
    $post_status        = $_POST['post_status'];

    $post_image         = $_FILES['image']['name'];
    $post_image_temp    = $_FILES['image']['tmp_name'];


    $post_tags          = $_POST['post_tags'];
    $post_content       = $_POST['post_content'];
    $post_date          = date('d-m-y');
    $post_comment_count = 4;

    if(empty($post_image))
    {
        $query = "SELECT * FROM posts WHERE Id = $post_id; ";
        $select_image = mysqli_query($connection, $query);

        confirmQuery($select_image);

        while( $row = mysqli_fetch_assoc($select_image))
        {
            $post_image = $row['Image'];
        }
    }

    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "UPDATE posts SET Post_Category_Id = $post_category_id, Title = '$post_title', Date = now(), Image = '$post_image', 
                               Author='$post_author', Content = '$post_content', Tags = '$post_tags', Status='$post_status' 
              WHERE id = $post_id; ";


    $update_post_query = mysqli_query($connection, $query);

    confirmQuery($update_post_query);

}
?>

<form action="" method="post" enctype="multipart/form-data">


    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title" value="<?php echo $post_title; ?>">
    </div>

    <div class="form-group">
        <?php

        $query = "SELECT * FROM categories;";
        $querySelectAllCategories = mysqli_query($connection, $query);
        confirmQuery($querySelectAllCategories);
        ?>

        <select name="post_category_id" id="">

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
        <input type="text" class="form-control" name="author" value="<?php echo $post_author; ?>">
    </div>


    <div class="form-group">
        <label for="post_status">Post Status</label>
        <input type="text" class="form-control" name="post_status" value="<?php echo $post_status; ?>">
    </div>

<!--    <div class="form-group">-->
<!--        <select name="post_status" id="">-->
<!--            <option value="draft">Post Status</option>-->
<!--            <option value="published">Published</option>-->
<!--            <option value="draft">Draft</option>-->
<!--        </select>-->
<!--    </div>-->



    <div class="form-group">
        <img width="100" src="../images/<?php echo $post_image; ?>" alt="">
        <label for="post_image">Post Image</label>
        <input type="file"  name="image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control "name="post_content" id="body" cols="30" rows="10" ><?php echo $post_content; ?></textarea>
    </div>



    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>


</form>