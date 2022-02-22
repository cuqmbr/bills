<?php

    session_start();
    
    include_once('head.php');

    if (isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == true) {
        header("Location: index.php");
        exit;
    }

    include('connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $email = $_POST['email'];
        $password = $_POST['pwd'];
    

        $emailErr = $passwordErr = NULL; 


        $dbuser_id = $dbusername = $dbemail = $dbpassword_hashed = NULL;
        
        $query = "SELECT user_id, username, email, password FROM Users WHERE email = '$email'";
        $userdata = mysqli_query($conn, $query);

        if (mysqli_num_rows($userdata) > 0) {
            
            while($row = mysqli_fetch_assoc($userdata)) {
                $dbuser_id = $row['user_id'];
                $dbusername = $row['username'];
                $dbemail = $row['email'];
                $dbpassword_hashed = $row['password'];
            }

            if (password_verify($password, $dbpassword_hashed)) {
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $dbuser_id;
                $_SESSION['username'] = $dbusername;
                $_SESSION['email'] = $dbemail;

                header("Location: index.php");

                mysqli_close($conn);
            } else {
                $passwordErr = "Неправильный пароль";
            }
        } else {

            $emailErr = "Почта не зарегестрирована";
        }
    }
?>

    <link rel="stylesheet" href="css/sign.css"/>

    <body>
        <form method="post" class="form">
            
            <h1>Войти</h1>

            <div class="error">* обязательное поле</div>
            <br>

            <input type="text" name="email" placeholder="Email *" class="input" autofocus>
            <div class="error"><?php echo $emailErr ?></div>
            <br>
            
            <input type="password" name="pwd" placeholder="Пароль *" class="input">
            <div class="error"><?php echo $passwordErr ?></div>
            <br>

            <button type="submit" name="submit" class="submit_button">Войти</button>

            <p>У вас ещё нету аккаунта? <a href="sign_up.php" class="link">Создать аккаунт</a></p>
        </form>
    </body>
</html>