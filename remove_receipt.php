<?php

    session_start();

    include('connection.php');

    #Validate ownership
    $link_user_id = $_GET['user_id'];
    $session_user_id = $_SESSION['user_id'];

    if ($link_user_id != $session_user_id) {
        header("Location: index.php");
    }

    #Delete receipt
    $receipt_id = $_GET['receipt_id'];
    $book_id = $_GET['book_id'];

    $query = "DELETE FROM Receipts WHERE receipt_id = '$receipt_id'";
    
    if (mysqli_query($conn, $query)) {
        echo "Receipt deleted successfully";
        header('Location: book.php?user_id='.$session_user_id.'&book_id='.$book_id.'');
    } else {
        echo mysqli_errno($conn) . " : " . mysqli_error($conn);
    }

?>