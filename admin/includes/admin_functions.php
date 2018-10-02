<?php
/**
 * Created by PhpStorm.
 * User: alexa
 * Date: 08/09/2018
 * Time: 18:35
 */




// category functions
function InsertCategory() {

    global $connection;
    if(isset($_POST['submit'])) {
        $catTitle = addslashes($_POST['cat_title']);
        if($catTitle == "" || empty($catTitle)) {
            echo "This field should not be empty";
        } else {
            $query = "INSERT INTO categories(Title) VALUES ('$catTitle') ";


            $createCategoryQuery = mysqli_query($connection, $query);

            if(!$createCategoryQuery) {
                die("Query Failed " . mysqli_error($connection));
            }
        }
    }
}

function FindAllCategories() {

    global $connection;
    $query = "SELECT * FROM categories;";
    $select_categories_sidebar_query = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_categories_sidebar_query)) {
    $cat_id = $row['Id'];
    $cat_title = stripslashes($row['Title']);

    echo "<tr>
        <td>$cat_id</td>
        <td>$cat_title</td>
        <td><a href=\"categories.php?edit=$cat_id\">Edit</a></td>
        <td><a href=\"categories.php?delete=$cat_id\">Delete</a></td>
    </tr>";
    }
}

function FindCategoryByPostId($post_Id)
{
    global $connection;
    $query = "SELECT * FROM categories WHERE Id = {$post_Id}; ";
    $select_categories_id = mysqli_query($connection, $query);

    $cat_Title = 0;
    while($row = mysqli_fetch_assoc($select_categories_id))
    {
        $cat_Title = stripslashes($row['Title']);
    }

    return $cat_Title;
}

function DeleteCategory() {
    global $connection;

    if(isset($_GET['delete'])) {
        $idToDelete = $_GET['delete'];
        $query = "DELETE FROM categories WHERE Id = {$idToDelete}; ";

        $queryDeleteCategory = mysqli_query($connection, $query);

        if(!$queryDeleteCategory) {
            die('Query Failed ' . mysqli_error($connection));
        }

        header("Location: categories.php");

    }
}

function UpdateCategory($categoryId) {
    global $connection;

    if(isset($_POST['update_category'])) {
        $titleToUpdate = $_POST['cat_title'];
        $query = "UPDATE categories SET Title = '{$titleToUpdate}' WHERE Id = {$categoryId}; ";

        $queryUpdateCategory = mysqli_query($connection, $query);

        if (!$queryUpdateCategory) {
            die('Query Failed ' . mysqli_error($connection));
        }


    }
}

// posts

function GetAllPostsAndOutputRow() {
    global $connection;
    $query = "SELECT * FROM posts ORDER BY Id DESC; ";
    $queryAllPosts = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($queryAllPosts)){
        $post_Id = $row['Id'];
        $post_title = stripslashes($row['Title']);
        $post_author = stripslashes($row['Author']);
        $post_categoryName = FindCategoryByPostId($row['Post_Category_Id']);
        $post_date = $row['Date'];
        $post_image = $row['Image'];
        $post_tags = $row['Tags'];
        $post_comment = $row['Comment_Count'];
        $post_status = $row['Status'];
        $post_views = $row['View_Count'];

        echo "<tr>";
        echo "<td><input class='checkboxes' type='checkbox' name='checkBoxArray[]' value='$post_Id'/></td>";
        echo "<td>$post_Id</td>";
        echo "<td>$post_author</td>";
        echo "<td>$post_title</td>";
        echo "<td>$post_categoryName</td>";
        echo "<td>$post_status</td>";
        echo "<td><img style='width: 100px;' src='../images/$post_image ' /></td>";
        echo "<td>$post_tags</td>";
        echo "<td>$post_comment</td>";
        echo "<td>$post_date</td>";
        echo "<td><a href='../post.php?p_id=$post_Id'>View Post</a></td>";
        echo "<td><a onclick=\"javascript: return confirm('Are you sure you want to delete?');\" href='posts.php?delete=$post_Id'>Delete</a><br /></td>";
        echo "<td><a href='posts.php?source=edit_post&p_id=$post_Id'>Edit</a></td>";
        echo "<td><a href='posts.php?reset_views=$post_Id'>$post_views</a> </td>";
        echo "</tr>";
    }
}

function FindPostByCommentPostId($comment_post_Id)
{
    global $connection;
    $query = "SELECT * FROM posts WHERE Id = {$comment_post_Id}; ";
    $select_post_id = mysqli_query($connection, $query);

    $post_Title = 0;
    while($row = mysqli_fetch_assoc($select_post_id))
    {
        $post_Title = stripslashes($row['Title']);
    }

    return $post_Title;
}

function GetAllCommentsAndOutputRow() {
    global $connection;
    $query = "SELECT * FROM comments ORDER BY Id DESC; ";
    $queryAllComments = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($queryAllComments)){
        $comment_Id = $row['Id'];
        $comment_post_Id = $row['Post_Id'];
        $comment_post_Title = FindPostByCommentPostId($row['Post_Id']);
        $comment_content = stripslashes($row['Content']);
        $comment_author = $row['Author'];
        $comment_date = $row['Date'];
        $comment_status = $row['Status'];
        $comment_email = $row['Email'];

        echo "<tr>";
        echo "<td>$comment_Id</td>";
        echo "<td>$comment_author</td>";
        echo "<td>$comment_content</td>";
        echo "<td>$comment_email</td>";
        echo "<td>$comment_status</td>";
        echo "<td><a href='posts.php?source=edit_post&p_id=$comment_post_Id'>$comment_post_Title</a></td>";
        echo "<td>$comment_date</td>";
        echo "<td><a href='comments.php?edit=$comment_Id&status=approved'>Approve</a></td>";
        echo "<td><a href='comments.php?edit=$comment_Id&status=unapproved'>Unapprove</a></td>";
        echo "<td><a href='comments.php?delete=$comment_Id'>Delete</a></td>";
    }
}

function resetPostViewCount($post_id) {
    global $connection;
    $reset_view_query = "UPDATE posts SET View_Count = 0 WHERE Id = $post_id; ";
    $execute_reset_query = mysqli_query($connection, $reset_view_query);
    confirmQuery($execute_reset_query);
}

// users

function GetAllUsersAndOutputRow() {
    global $connection;
    $query = "SELECT * FROM users ORDER BY Id DESC; ";
    $queryAllUsers = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($queryAllUsers)){
        $user_Id = $row['Id'];
        $user_username = $row['username'];
        $user_firstname = $row['firstname'];
        $user_lastname = $row['lastname'];
        $user_email = $row['email'];
        $user_image = $row['image'];
        $user_role = $row['role'];

        echo "<tr>";
        echo "<td>$user_Id</td>";
        echo "<td>$user_username</td>";
        echo "<td>$user_firstname</td>";
        echo "<td>$user_lastname</td>";
        echo "<td>$user_email</td>";
        echo "<td>$user_role</td>";
        echo "<td><img style='width: 100px;' src='../images/$user_image ' /></td>";
        echo "<td><a href='users.php?change_to_admin=$user_Id'>Admin</a></td>";
        echo "<td><a href='users.php?change_to_sub=$user_Id'>Subscriber</a></td>";
        echo "<td><a href='users.php?source=edit_user&u_id=$user_Id'>Edit</a></td>";
        echo "<td><a href='users.php?delete=$user_Id'>Delete</a></td>";
    }
}