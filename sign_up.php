<?php

    session_start();
    
    include_once('head.php');

    if (isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == true) {
        header("Location: index.php");
        exit;
    }

    include('connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        #Collect data from html form via POST request method
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['pwd'];
        $conf_password = $_POST['cpwd'];

        #Define error variables and set to empty valuse
        $usernameErr = $emailErr = $passwordErr = $conf_passwordErr = NULL;

        #Validate form and catch errors

        #Username confirmation
        if (empty($username)) {
            $usernameErr = "Вы не ввели имя пользователя";
        }

        #Email confirmation
        if (empty($email)) {
            $emailErr = "Вы не ввели email";
        } elseif (preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email) ? FALSE : TRUE) {
            $emailErr = "Используйте валидную почту";
        }

        #Password confirmation
        if (empty($password)) {
            $passwordErr = "Вы не ввели пароль";
        } elseif (mb_strlen($password) < 8) {
            $passwordErr = "Используйте больше 8 символов";
        }

        #Password confirmation
        if ($conf_password != $password) {
            $conf_passwordErr = "Пароли не совпадают";
        }
        
        #Post data to the database is there are no errors
        if ($usernameErr == NULL && $emailErr == NULL && $passwordErr == NULL && $conf_passwordErr == NULL) {
         
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO Users (username, email, password) VALUES ('$username', '$email', '$password_hashed')";
        
            if (mysqli_query($conn, $query)) {
                header("Location: login.php");
                
                mysqli_close($conn);
              } else {
                #echo mysqli_errno($conn) . " : " . mysqli_error($conn);

                $errno = mysqli_errno($conn);

                if ($errno == 1062) {
                    $emailErr = "Почта уже зарегестрирована";
                }
              }
        }
    }

?>

    <link rel="stylesheet" href="css/sign.css"/>

    <body>
        <form method="post" class="form">
            
            <h1>Создать аккаунт</h1>

            <div class="error">* обязательное поле</div>
            <br>

            <input type="text" name="username" placeholder="Имя пользователя *" class="input" autofocus>
            <div class="error"><?php echo $usernameErr; ?></div>
            <br>

            <input type="text" name="email" placeholder="Email *" class="input">
            <div class="error"><?php echo $emailErr; ?></div>
            <br>
        
            <input type="password" name="pwd" placeholder="Пароль *" class="input">
            <div class="error"><?php echo $passwordErr; ?></div>
            <br>

            <input type="password" name="cpwd" placeholder="Повторите пароль *" class="input">
            <div class="error"><?php echo $conf_passwordErr; ?></div>
            <br>

            <button type="submit" name="submit" class="submit_button">Создать</button>

            <p>У вас уже есть аккаунт? <a href="login.php" class="link">Войти</a></p>
        </form>
    </body>
</html>