<?php

    session_start();
    
    include_once('head.php');
    include('connection.php');

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
        header("Location: login.php");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        #Get user id
        $user_id = $_SESSION['user_id'];

        #Collect data from html form via POST request method
        $book_name = $_POST['book_name'];
        $bill_adress = $_POST['bill_adress'];
        $bill_account = $_POST['bill_account'];

        #Define error variables and set to empty valuse
        $book_nameErr = $bill_adressErr = $bill_accountErr = NULL;

        #Validate form and catch errors

        #Book name validation
        if (empty($book_name)) {
            $book_nameErr = 'Вы не ввели название';
        }

        #Book adress validation
        if (empty($bill_adress)) {
            $bill_adressErr = 'Вы не ввели адрес';
        }
        
        #Billing account validation
        if (empty($bill_account)) {
            $bill_accountErr = 'Вы не ввели счёт';
        }
        
        #Post data to the database is there are no errors
        if ($book_nameErr == NULL && $bill_adressErr == NULL && $bill_accountErr == NULL) {
            
            $query = "INSERT INTO Books (owner_id, name, account, adress) VALUES ('$user_id', '$book_name', '$bill_account', '$bill_adress')";

            if (mysqli_query($conn, $query)) {
                echo "New record has been created successfully";
                header("Location: index.php");
            } else {
                echo mysqli_errno($conn) . " : " . mysqli_error($conn);
            }
        }

        mysqli_close($conn);
    }

?>

    <link rel="stylesheet" href="css/createbook.css"/>

    <body class="container">
        <?php include_once('elements/header.php') ?>

        <div class="content">
            <form method="post" class="form">
                
                <h1 class="form_title">Создать книжку</h1>
 
                <div class="error">* обязательное поле</div>
                <br>

                <input type="text" name="book_name" placeholder="Название *" class="input">
                <div class="error"><?php echo $book_nameErr ?></div>
                <br>
                    
                <input type="text" name="bill_adress" placeholder="Адрес *" class="input">
                <div class="error"><?php echo $bill_adressErr ?></div>
                <br>

                <input type="text" name="bill_account" placeholder="Счёт *" class="input">
                <div class="error"><?php echo $bill_accountErr ?></div>
                <br>

                <button type="submit" name="submit" class="submit_button">Создать</button>
                <br><br>

                <a href="index.php" class="link">Назад</a>
            </form>
        </div>

        <?php include_once('elements/footer.php') ?>
    </body>
</html>