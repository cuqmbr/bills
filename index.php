<?php

    session_start();

    include_once('head.php');
    include('connection.php');

?>

    <link rel="stylesheet" href="css/index.css"/>
    <!--<script src="js/dragndrop.js" defer></script>-->

    <body class="container">
        <?php include_once('elements/header.php') ?>
            
        <div class="content">
            
            <?php
            
                $user_id = $_SESSION['user_id'];

                $books = array();

                $query = 'SELECT book_id, name, adress, account FROM Books WHERE owner_id = '.$user_id.'';
                $userdata = mysqli_query($conn, $query);
        
                if (mysqli_num_rows($userdata) > 0) {
                    
                    foreach (mysqli_fetch_all($userdata) as $row) {                 
                        array_push($books, $row);
                    }

                    foreach ($books as $book) {
                        $book_id = $book[0];

                        echo '<div class="card draggable" draggable="false">
                                <div class="card-content-wrapper">
                                    <h3>'.$book[1].'</h3>
                                    <p>'.$book[2].'</p>
                                    <p>Счёт '.$book[3].'</p>
                                    <a href="book.php?user_id='.$user_id.'&book_id='.$book_id.'" class="btn1">Подробнее</a><br><br>
                                    <a href="remove_book.php?user_id='.$user_id.'&book_id='.$book_id.'" class="link">Удалить</a>
                                </div>
                              </div>';
                    }
                }

                #print_r($books);
            ?>
                
            <div class="card draggable" draggable="false">
                <a href="createbook.php" class="add-btn" title="Добавить книжку">+</a>
            </div>

        </div>

        <?php include_once('elements/footer.php') ?>
    </body>
</html>