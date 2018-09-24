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
        $catTitle = $_POST['cat_title'];
        if($catTitle == "" || empty($catTitle)) {
            echo "This field should not be empty";
        } else {
            $query = "INSERT INTO categories(Title) ";
            $query .= "VALUES ('{$catTitle}') ";


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
    $cat_title = $row['Title'];

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
        $cat_Title = $row['Title'];
    }

    return$cat_Title;
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
    $query = "SELECT * FROM posts; ";
    $queryAllPosts = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($queryAllPosts)){
        $post_Id = $row['Id'];
        $post_title = $row['Title'];
        $post_author = $row['Author'];
        $post_categoryName = FindCategoryByPostId($row['Post_Category_Id']);
        $post_date = $row['Date'];
        $post_image = $row['Image'];
        $post_tags = $row['Tags'];
        $post_comment = $row['Comment_Count'];
        $post_status = $row['Status'];

        echo "<tr>";
        echo "<td>$post_Id</td>";
        echo "<td>$post_author</td>";
        echo "<td>$post_title</td>";
        echo "<td>$post_categoryName</td>";
        echo "<td>$post_status</td>";
        echo "<td><img style='width: 100px;' src='../images/$post_image ' /></td>";
        echo "<td>$post_tags</td>";
        echo "<td>$post_comment</td>";
        echo "<td>$post_date</td>";
        echo "<td><a href='posts.php?delete=$post_Id'>Delete</a><br /><a href='posts.php?source=edit_post&p_id=$post_Id'>Edit</a></td>";
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
        $post_Title = $row['Title'];
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
        $comment_content = $row['Content'];
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