<?php

    session_start();

    include('head.php');
    include('connection.php');

    $book_id = $_GET['book_id'];

    $book_name = $book_adress = NULL;

    $query = "SELECT name, adress FROM Books WHERE book_id = '$book_id'";
    $book_data = mysqli_query($conn, $query);

    if (mysqli_num_rows($book_data) > 0) {
            
        while($row = mysqli_fetch_assoc($book_data)) {
            $book_name = $row['name'];
            $book_adress = $row['adress'];
        }
    }

    #Validate ownership
    $link_user_id = $_GET['user_id'];
    $session_user_id = $_SESSION['user_id'];

    if ($link_user_id != $session_user_id) {
        header("Location: index.php");
    }

?>

    <link rel="stylesheet" href="css/book.css"/>

    <body class="container">
        <?php include_once('elements/header.php') ?>
            
        <div class="content">

            <a href="index.php" class="btn1">На главную</a>

            <h2><?php echo $book_name ?></h2>
            <h3><?php echo $book_adress ?></h3>

            <div class="card-wrapper">

                <?php
                
                    $query = 'SELECT receipt_id, start_date, final_date FROM Receipts WHERE book_id = '.$book_id.'';
                    $receipts_data = mysqli_fetch_all(mysqli_query($conn, $query));

                    $receipt_num = count($receipts_data) + 1;

                ?>

                <div class="card">
                    <a href="<?php echo 'receipt.php?user_id='.$session_user_id.'&book_id='.$book_id.'&book_name='.$book_name.'&receipt_num='.$receipt_num.'' ?>" class="add-btn" title="Добавить запись">+</a>
                </div>
                
                <?php
                    
                    if (!empty($receipts_data[0])) {
                        
                        foreach (array_reverse($receipts_data) as $row) {
                            
                            $receipt_num--;

                            echo '<div class="card">
                                      <div class="card-content-wrapper">
                                          <h3>Запись №'.$receipt_num.'</h3>
                                          <p>'.date("d.m.Y", strtotime($row[1])).' - '.date("d.m.Y", strtotime($row[2])).'</p>
                                          <a href="receipt.php?user_id='.$session_user_id.'&book_id='.$book_id.'&receipt_id='.$row[0].'&book_name='.$book_name.'&receipt_num='.$receipt_num.'" class="btn1">Посмотреть / Изменить</a>
                                      </div>
                                  </div>';
                        }
                    }

                
                ?>

                <!--<div class="card">
                    <div class="card-content-wrapper">
                        <h3>Запись №263</h3>
                        <p>01.03.2021 - 01.04.2021</p>
                        <a href="" class="btn1">Подробнее</a>
                    </div>
                </div>-->

            </div>

        </div>

        <?php include_once('elements/footer.php') ?>
    </body>
</html>