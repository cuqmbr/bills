<?php

    session_start();

    include('connection.php');

    #Validate ownership
    $link_user_id = $_GET['user_id'];
    $session_user_id = $_SESSION['user_id'];

    if ($link_user_id != $session_user_id) {
        header("Location: index.php");
    }

    #Delete user
    $query = "DELETE FROM Users WHERE user_id = '$session_user_id'";
    
    if (mysqli_query($conn, $query)) {
        session_unset();
        session_destroy();

        header("Location: index.php");
        exit();
    } else {
        echo mysqli_errno($conn) . " : " . mysqli_error($conn);
    }

?>