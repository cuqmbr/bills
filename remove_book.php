<?php

    session_start();

    include('connection.php');

    #Validate ownership
    $link_user_id = $_GET['user_id'];
    $session_user_id = $_SESSION['user_id'];

    if ($link_user_id != $session_user_id) {
        header("Location: index.php");
    }

    #Delete book
    $book_id = $_GET['book_id'];

    $query = "DELETE FROM Books WHERE book_id = '$book_id'";
    
    if (mysqli_query($conn, $query)) {
        echo "Book deleted successfully";
        header('Location: index.php');
    } else {
        echo mysqli_errno($conn) . " : " . mysqli_error($conn);
    }

?>