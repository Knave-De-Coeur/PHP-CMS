<?php
/**
 * Created by PhpStorm.
 * User: alexa
 * Date: 11/09/2018
 * Time: 12:57
 */
if(isset($_GET['u_id'])) {
    $user_id = $_GET['u_id'];

    $query = "SELECT * FROM posts WHERE Id =  $user_id; ";

    $queryUserById = mysqli_query($connection, $query);

    confirmQuery($queryUserById);

    while($row = mysqli_fetch_assoc($queryUserById)){
        $post_title = stripslashes($row['Title']);
        $post_author = stripslashes($row['Author']);
        $post_category_id = $row['Post_Category_Id'];
        $post_date = $row['Date'];
        $post_image = $row['Image'];
        $post_content = stripslashes($row['Content']);
        $post_tags = $row['Tags'];
        $post_comment = $row['Comment_Count'];
        $post_status = $row['Status'];
    }
}

if(isset($_POST['update_post'])) {
    $post_title         = addslashes($_POST['title']);
    $post_category_id   = $_POST['post_category_id'];
    $post_author        = addslashes($_POST['author']);
    $post_status        = $_POST['post_status'];

    $post_image         = $_FILES['image']['name'];
    $post_image_temp    = $_FILES['image']['tmp_name'];


    $post_tags          = $_POST['post_tags'];
    $post_content       = addslashes($_POST['post_content']);
    $post_date          = date('d-m-y');

    if(empty($post_image))
    {
        $query = "SELECT * FROM posts WHERE Id = $user_id; ";
        $select_image = mysqli_query($connection, $query);

        confirmQuery($select_image);

        while( $row = mysqli_fetch_assoc($select_image))
        {
            $post_image = $row['Image'];
        }
    }

    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "UPDATE posts SET 
              Title='{$post_title}', Post_Category_Id=$post_category_id,  Date=NOW(), Image='$post_image', Author='{$post_author}', Content='{$post_content}', Tags='{$post_tags}', Status='$post_status' 
              WHERE Id = $user_id";



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
        <label for="user_role">Role</label>
        <select name="user_role" id="">
            <?php

            $query = "SELECT * FROM users WHERE Id = $user_id; ";
            $select_users = mysqli_query($connection, $query);

            confirmQuery($select_users);

            while($row = mysqli_fetch_assoc($select_users)) {
//                $user_id = $row['Id'];
                $user_role = $row['role'];

                echo "<option value='$user_id'>$user_role</option>";
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