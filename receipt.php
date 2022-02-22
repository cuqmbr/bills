<?php

    session_start();

    include('head.php');
    include('connection.php');

    $book_id = $_GET['book_id'];
    $book_name = $_GET['book_name'];
    $receipt_num = $_GET['receipt_num'];
    $receipt_id = $_GET['receipt_id'];

    #Retrieve receipt data
    $start_date = $final_date = $start_num = $final_num = $rate = $total = NULL;
        
    $query = "SELECT start_date, final_date, start_num, final_num, rate, comment FROM Receipts WHERE receipt_id = '$receipt_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
            
        while($row = mysqli_fetch_array($result)) {
            $start_date = $row['start_date'];
            $final_date = $row['final_date'];
            $start_num = $row['start_num'];
            $final_num = $row['final_num'];
            $rate = $row['rate'];
            $comment = $row['comment'];
        }
    }

    #Validate ownership
    $link_user_id = $_GET['user_id'];
    $session_user_id = $_SESSION['user_id'];

    if ($link_user_id != $session_user_id) {
        header("Location: index.php");
    }

    #Post method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        #Collect data from html form via POST request method
        $start_date = $_POST['start_date'];
        $final_date = $_POST['final_date'];
        $start_num = $_POST['start_num'];
        $final_num = $_POST['final_num'];
        $rate = $_POST['rate'];
        $comment = $_POST['comment'];
    
        #Define error variables and set to empty valuse
        $dateErr = $numErr = $rateErr = $commentErr = NULL;
    
        #Validate form and catch errors
    
        #Date confirmation
        if(empty($start_date) || empty($final_date)) {
            $dateErr = "Вы не ввели дату";
        }
    
        #Num confirmation
        if ($start_num < 0 || empty($final_num)) {
            $numErr = "Вы не ввели показания счётчика";
        }

        #Rate confirmation
        if (empty($rate)) {
            $rateErr = "Вы не ввели тариф";
        }

        #Comment validation
        if (strlen($comment) > 255) {
            $commentErr = "Коммнтарий не можеть быть длиннее 255 символов";
        }

        #Post data to the database is there are no errors
        if ($dateErr == NULL && $numErr == NULL && $rateErr == NULL && $commentErr == NULL) {

            if ($receipt_id == NULL) {
                
                $query = "INSERT INTO Receipts (book_id, start_date, final_date, start_num, final_num, rate, comment) VALUES ('$book_id', '$start_date', '$final_date', '$start_num', '$final_num', '$rate', '$comment')";
            
                if (mysqli_query($conn, $query)) {
                    echo "New record has been created successfully";
                    header('Location: book.php?user_id='.$session_user_id.'&book_id='.$book_id.'');
                } else {
                    echo mysqli_errno($conn) . " : " . mysqli_error($conn);
                }  
            } else {

                $query = "UPDATE Receipts SET start_date = '$start_date', final_date = '$final_date', start_num = '$start_num', final_num = '$final_num', rate = '$rate', comment = '$comment' WHERE (receipt_id = '$receipt_id')";
            
                if (mysqli_query($conn, $query)) {
                    echo "Receipts has been updated";
                    header('Location: book.php?user_id='.$session_user_id.'&book_id='.$book_id.'');
                } else {
                    echo mysqli_errno($conn) . " : " . mysqli_error($conn);
                }  
            }
        }

        mysqli_close($conn);
    }

?>

    <link rel="stylesheet" href="css/receipt.css"/>

    <body class="container">
        <?php include_once('elements/header.php') ?>

        <div class="content">
        
            <a href="<?php echo 'book.php?user_id='.$session_user_id.'&book_id='.$book_id.'' ?>" class='btn1'>Назад</a>

            <form method="post" class="form" autocomplete="off">
                
                <h2><?php echo $book_name; ?>: Запись №<?php echo $receipt_num; ?></h2>
                
                <div class="input-container">
                    
                    <p class="input-label">Дата*:</p>
                    <input type="date" name="start_date" class="input" value=<?php echo $start_date ?>> - <input type="date" name="final_date" class="input" value=<?php echo $final_date ?>>
                    <div class="error"><?php echo $dateErr; ?></div>
                    <br>
    
                    <p class="input-label">Показания счётчика*: &emsp;&ensp;&ensp; За месяц:</p>
                    <input type="number" name="start_num" id="start_num" class="num-input input" min="0" placeholder="Начало" value=<?php echo $start_num ?>> - <input type="number" name="final_num" id="final_num" class="num-input input" min="0" placeholder="Конец" value=<?php echo $final_num ?>> : <input type="number" name="monthly" id="monthly" class="num-input input" min="0" readonly>
                    <div class="error"><?php echo $numErr; ?></div>
                    <br>

                    <p class="input-label">Тариф*: &emsp;&emsp;&emsp;&emsp;&emsp;&nbsp; Сумма:</p>
                    <input type="number" step="0.01" name="rate" id="rate" class="input" value=<?php echo $rate; ?>> : <input type="number" step="0.01" name="total" id="total" class="input" readonly>
                    <div class="error"><?php echo $rateErr; ?></div>
                    <br>
                    
                    <p class="input-label">Комментарий к записи:</p>
                    <textarea name="comment" class="input comment"><?php echo $comment ?></textarea>
                    <div class="error"><?php echo $commentErr; ?></div>
                    <br>
    
                    <button type="submit" name="submit" class="submit_button">Сохранить</button>
                    <br><br>

                    <a href="<?php echo 'remove_receipt.php?user_id='.$session_user_id.'&book_id='.$book_id.'&receipt_id='.$receipt_id.'' ?>" class="link" method="post">Удалить</a>
                </div>
                

            </form>

        </div>

        <?php include_once('elements/footer.php') ?>
    </body>
</html>

<script src="receipt.js"></script>