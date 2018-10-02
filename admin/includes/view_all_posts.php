<?php
/**
 * Created by PhpStorm.
 * User: alexa
 * Date: 11/09/2018
 * Time: 12:50
 */

include "classes/Comment.php";
include "classes/Post.php";

if(isset($_GET['delete'])) {
    $post_id = $_GET['delete'];
    $query = "DELETE FROM posts WHERE Id = " . $post_id;

    $query_delete_post = mysqli_query($connection, $query);

    confirmQuery($query_delete_post);

    header("Location: posts.php");
}

if(isset($_GET['reset_views'])) {
    resetPostViewCount($_GET['reset_views']);
}

?>

<?php

if(isset($_POST['checkBoxArray'])) {
    $post_ids = $_POST['checkBoxArray'];

    foreach ($post_ids as $postValueId) {
        $bulk_options = $_POST['bulk_options'];
        switch ($bulk_options) {
            case 'published':
                $query = "UPDATE posts SET Status = '$bulk_options' WHERE Id = $postValueId; ";
                $update_post_to_published = mysqli_query($connection, $query);
                confirmQuery($update_post_to_published);
                break;

            case 'draft':
                $query = "UPDATE posts SET Status = '$bulk_options' WHERE Id = $postValueId; ";
                $update_post_to_draft = mysqli_query($connection, $query);
                confirmQuery($update_post_to_draft);
                break;

            case 'delete':
                $query = "DELETE FROM posts WHERE Id = $postValueId; ";
                $update_post_to_draft = mysqli_query($connection, $query);
                confirmQuery($update_post_to_draft);
                break;

            case 'clone':
                $query = "SELECT * FROM posts WHERE Id = $postValueId; ";
                $select_post_query = mysqli_query($connection, $query);
                confirmQuery($select_post_query);

                while ($row = mysqli_fetch_array($select_post_query)) {
                    $post_title = addslashes($row['Title']);
                    $post_author = addslashes($row['Author']);
                    $post_category_id = $row['Post_Category_Id'];
                    $post_date = $row['Date'];
                    $post_image = $row['Image'];
                    $post_tags = $row['Tags'];
                    $post_content = $row['Content'];
                    $post_status = $row['Status'];
                }

                $query = "INSERT INTO posts (Post_Category_Id, Title, Author, Date, Image, Content, Tags, Status) 
                VALUES ({$post_category_id}, '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}'); ";


                $clone_post_query = mysqli_query($connection, $query);

                confirmQuery($clone_post_query);
                break;

            default:
                break;
        }
    }
}

?>

<form action="" method="post">



    <table class="table table-bordered table-hover" >
        <div id="bulkOptionsContainer" class="col-xs-4">
            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>
        </div>

        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add Posts</a>
        </div>

        <thead>
        <tr>
            <th><input id="selectAllBoxes" type="checkbox"></th>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>View</th>
            <th>Delete</th>
            <th>Edit</th>
            <th>Views</th>
        </tr>
        </thead>
        <tbody>
        <?php

        GetAllPostsAndOutputRow();

        ?>
        </tbody>
    </table>
</form>


