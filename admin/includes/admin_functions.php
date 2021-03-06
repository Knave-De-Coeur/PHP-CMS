<?php
/**
 * Created by PhpStorm.
 * User: alexa
 * Date: 08/09/2018
 * Time: 18:35
 */

// generic functions


function recordCount($table, $checkUser = false) {

    if($checkUser) {
        $userId = loggedInUserId();
        $query = "SELECT * FROM " . $table . " WHERE User_Id = {$userId}; ";

    } else {
        $query = "SELECT * FROM " . $table;
    }

    $select_all_records = query($query);

    return countRecords($select_all_records);
}

function getAllPostUserComments() {
    return query("SELECT * FROM posts INNER JOIN comments c on posts.Id = c.Post_Id WHERE User_Id = " . loggedInUserId());
}

function getAllPostUserCategories() {
    return query("SELECT * FROM categories WHERE User_Id = " . loggedInUserId());
}

function getAllPostUserCommentsWithStatus($status) {
    return query("SELECT * FROM posts INNER JOIN comments c on posts.Id = c.Post_Id WHERE User_Id = " . loggedInUserId() . " AND c.Status = '{$status}'");
}

// category functions
function InsertCategory() {

    global $connection;

    if(isset($_POST['submit'])) {
        $catTitle = addslashes($_POST['cat_title']);

        if ($catTitle == "" || empty($catTitle)) {

            echo "This field should not be empty";

        } else {

            $stmt = mysqli_prepare($connection, "INSERT INTO categories(Title, User_Id) VALUES (?, ?) ");

            mysqli_stmt_bind_param($stmt, "si", $catTitle, loggedInUserId() );

            mysqli_stmt_execute($stmt);

            if (!$stmt) {
                die("Query Failed " . mysqli_error($connection));
            }

            mysqli_stmt_close($stmt);
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
        $titleToUpdate = escape($_POST['cat_title']);

        $stmt = mysqli_prepare($connection, "UPDATE categories SET Title = ? WHERE Id = ?; ");

        mysqli_stmt_bind_param($stmt, 'si', $titleToUpdate, $categoryId);

        mysqli_stmt_execute($stmt);

        if (!$stmt) {
            die('Query Failed ' . mysqli_error($connection));
        }

        mysqli_stmt_close($stmt);

        redirect('categories.php');

    }
}

// posts

function GetAllPostsAndOutputRow() {
    global $connection;

    if($_SESSION['username']) {

        $currentUser = getPostUserByUsername($_SESSION['username']);

        $query = "SELECT posts.Id as postID, posts.User_Id, posts.Post_Category_Id, posts.Title, posts.Tags, posts.Status, 
                     posts.Date, posts.Image, posts.View_Count, posts.Comment_Count, c.Id as catId, c.Title as catTitle
              FROM posts
              LEFT JOIN categories c on posts.Post_Category_Id = c.Id
              WHERE posts.User_Id = {$currentUser->getId()}
              ORDER BY postID DESC; ";
    } else {
        $query = "SELECT posts.Id as postID, posts.User_Id, posts.Post_Category_Id, posts.Title, posts.Tags, posts.Status, 
                     posts.Date, posts.Image, posts.View_Count, posts.Comment_Count, c.Id as catId, c.Title as catTitle
              FROM posts
              LEFT JOIN categories c on posts.Post_Category_Id = c.Id
              ORDER BY postID DESC; ";
    }

    $queryAllPosts = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($queryAllPosts)){

        $post = new Post();


        $post->setId($row['postID']);
        $post->setTitle(stripslashes($row['Title']));
        $post->setUser(getPostUserById($row['User_Id']));
        $post->setCategory(new Category($row['catId'], $row['catTitle']));
        $post->setDate($row['Date']);
        $post->setImage($row['Image']);
        $post->setTags($row['Tags']);
        $post->setStatus($row['Status']);
        $post->setViewCount($row['View_Count']);
        $post->setComments(getCommentsByPostId($row['postID']));

        echo "<tr>";
        echo "<td><input class='checkboxes' type='checkbox' name='checkBoxArray[]' value='$post->Id'/></td>";
        echo "<td>$post->Id</td>";
        echo "<td>{$post->getUser()->getUsername()}</td>";
        echo "<td>$post->title</td>";
        echo "<td>{$post->getCategory()->getTitle()}</td>";
        echo "<td>$post->status</td>";
        echo "<td><img style='width: 100px;' src='../images/$post->image ' /></td>";
        echo "<td>$post->tags</td>";
        echo "<td><a href='post_comments.php?id=$post->Id'>". count($post->getComments()) . "</a></td>";
        echo "<td>$post->date</td>";
        echo "<td><a class='btn btn-primary' href='../post.php?p_id=$post->Id'>View Post</a></td>";
        echo "<input type='hidden' name='post_id' value='$post->Id' />";
//        echo "<td><input class='btn btn-danger' type='submit' name='delete' value='delete' /></td>";
        echo "<td><a class='btn btn-danger delete_link' rel='$post->Id'href='javascript:void(0)'>Delete</a><br /></td>";
        echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id=$post->Id'>Edit</a></td>";
        echo "<td><a href='posts.php?reset_views=$post->Id'>$post->viewCount</a> </td>";
        echo "</tr>";
    }
}

function getPostUserById($user_Id) {
    $author = new User();

    if(!empty($user_Id)) {
        global $connection;
        $query = "SELECT * FROM users WHERE Id = $user_Id; ";
        $query_users = mysqli_query($connection, $query);
        confirmQuery($query_users);
        while ($row = mysqli_fetch_assoc($query_users)) {

            $author->setId($row['Id']);
            $author->setFirstName($row['firstname']);
            $author->setLastName($row['lastname']);
            $author->setUsername($row['username']);
        }
    } else {
        $author->setUsername("N/A");
    }
    return $author;
}

function getPostUserByUsername($username) {
    $author = new User();

    if(!empty($username)) {
        global $connection;
        $query = "SELECT * FROM users WHERE username = '$username' ; ";
        $query_users = mysqli_query($connection, $query);
        confirmQuery($query_users);
        while ($row = mysqli_fetch_assoc($query_users)) {

            $author->setId($row['Id']);
            $author->setFirstName($row['firstname']);
            $author->setLastName($row['lastname']);
            $author->setUsername($row['username']);
        }
    } else {
        $author->setUsername("N/A");
    }
    return $author;
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

function getCommentsByPostId($post_id) {
    $listOfComments = [];
    global $connection;
    $query_comments = "SELECT * FROM comments WHERE Post_Id = $post_id";
    $comments_per_post = mysqli_query($connection, $query_comments);
    confirmQuery($comments_per_post);

    while ($row = mysqli_fetch_assoc($comments_per_post)) {
        $comment = new Comment();

        $comment->setId($row['Id']);
        $comment->setPostId($row['Post_Id']);
        $comment->setAuthor($row['Author']);
        $comment->setEmail($row['Email']);
        $comment->setContent($row['Content']);
        $comment->setDate($row['Date']);
        $comment->setStatus($row['Status']);

        array_push($listOfComments, $comment);
    }

    return $listOfComments;
}

function GetCommentsAndOutputRow($post_id = null) {
    global $connection;

    if($post_id != null) {
        $query = "SELECT * 
                  FROM comments
                  INNER JOIN posts ON comments.Post_Id = posts.Id
                  WHERE Post_Id = $post_id ORDER BY comments.Id DESC; ";
    } else {
        $query = "SELECT * FROM comments ORDER BY Id DESC; ";
    }

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

        if($post_id == null) {
            echo "<td><a href='comments.php?edit=$comment_Id&status=approved'>Approve</a></td>";
            echo "<td><a href='comments.php?edit=$comment_Id&status=unapproved'>Unapprove</a></td>";
            echo "<td><a href='comments.php?delete=$comment_Id'>Delete</a></td>";
        } else {
            echo "<td><a href='post_comments.php?id=$post_id&edit=$comment_Id&status=approved'>Approve</a></td>";
            echo "<td><a href='post_comments.php?id=$post_id&edit=$comment_Id&status=unapproved'>Unapprove</a></td>";
            echo "<td><a href='post_comments.php?id=$post_id&delete=$comment_Id'>Delete</a></td>";
        }
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

//users_online

function usersOnline() {

    if(isset($_GET['onlineusers'])) {
        global $connection;

        if(!$connection) {
            session_start();
            include("../../includes/db_connection.php");
            include("../../includes/functions.php");

            $session = session_id();
            $time = time();
            $time_out_in_seconds = 60;
            $time_out = $time - $time_out_in_seconds;

            $query = "SELECT * FROM users_online WHERE session = '$session'; ";
            $send_query = mysqli_query($connection, $query);
            confirmQuery($send_query);

            $count = mysqli_num_rows($send_query);

            if ($count == null) {
                mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES ('$session', $time)");
            } else {
                mysqli_query($connection, "UPDATE users_online SET time = $time WHERE session = '$session'");
            }

            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > $time_out");
            $count_user = mysqli_num_rows($users_online_query);

            echo $count_user;
        }

    } // get request isset()

}

usersOnline();

