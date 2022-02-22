<?php

    session_start();

    include('connection.php');

    #Validate ownership
    $link_user_id = $_GET['user_id'];
    $session_user_id = $_SESSION['user_id'];

    if ($link_user_id != $session_user_id) {
        header("Location: index.php");
    }

    #Form handling
    $dbpassword_hashed = $password = $new_password = $confirm_new_password = NULL;
    $passwordErr = $confirm_passwordErr = NULL;
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!empty($_POST['submit_password'])) {

            #Retrive database password
            $query = "SELECT password FROM Users WHERE user_id = '$session_user_id'";
            $result = mysqli_query($conn, $query);
        
            if (mysqli_num_rows($result) > 0) {
                    
                while($row = mysqli_fetch_array($result)) {
                    $dbpassword_hashed = $row['password'];
                }
            }

            #Validate new password
            $password = $_POST['pwd'];
            $new_password = $_POST['npwd'];
            $confirm_new_password = $_POST['cnpwd'];

            if ($new_password != $confirm_new_password) {
                $confirm_passwordErr = 'Пароли не совпадают';
            }
                
            if (mb_strlen($new_password) < 8) {
                $confirm_passwordErr = "Используйте больше 8 символов";
            } 
            
            if (empty($new_password)) {
                $confirm_passwordErr = "Вы не ввели пароль";
            }
            
            if (!password_verify($password, $dbpassword_hashed)) {
                $passwordErr = "Вы ввели неправильный пароль";
            }
            
            #Set new password
            if ($confirm_passwordErr == NULL && $passwordErr == NULL) {

                $password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                $query = "UPDATE Users SET password = '$password_hashed' WHERE (user_id = '$session_user_id')";

                if (mysqli_query($conn, $query)) {
                    header("Location: logout.php"); 
                    mysqli_close($conn);
                } else {
                    echo mysqli_errno($conn) . " : " . mysqli_error($conn);
                }
            }

        }
    }
    
    include_once('head.php');

    ####Get data to make graphs####
    $book_info = array();

    #Get user's books
    $book_ids = $book_names = array();

    $query = "SELECT book_id, name FROM Books WHERE owner_id = '$session_user_id'";
    $result = mysqli_query($conn, $query);
       
    if (mysqli_num_rows($result) > 0) {

        while($row = mysqli_fetch_array($result)) {
            
            array_push($book_ids, $row['book_id']);
            array_push($book_names, $row['name']);
        }
    }

    #Get user's boooks receipts into $book_info array
    
    $start_dates_all = $final_dates_all = $start_nums_all = $final_nums_all = $rates_all = $start_dates = $final_dates = $start_nums = $final_nums = $rates = array();
    
    $curr_id = NULL;
    $curr_num = -1;

    for ($i=0; $i < count($book_ids); $i++) { 
        
        $query = "SELECT start_date, final_date, start_num, final_num, rate FROM Receipts WHERE book_id = '$book_ids[$i]' ORDER BY start_date LIMIT 100";
        $result = mysqli_query($conn, $query);
           
        if (mysqli_num_rows($result) > 0) {
    
            while($row = mysqli_fetch_array($result)) {
                
                if (date(strtotime($row['final_date'])) > date(strtotime('-2 month'))) {

                    array_push($start_dates_all, $row['start_date']);
                    array_push($final_dates_all, $row['final_date']);
                    array_push($start_nums_all, $row['start_num']);
                    array_push($final_nums_all, $row['final_num']);
                    array_push($rates_all, $row['rate']);

                    if ($curr_id != $book_ids[$i]) {

                        $curr_id = $book_ids[$i];
                        $curr_num++;
    
                        array_push($book_info, array($book_ids[$i], $book_names[$i], array(array($row['start_date'], $row['final_date'], $row['start_num'], $row['final_num'], $row['rate']))));
                    } else if ($curr_id == $book_ids[$i]) {
    
                        array_push($book_info[$curr_num][2], array($row['start_date'], $row['final_date'], $row['start_num'], $row['final_num'], $row['rate']));
                    }
                }
            }
        }
    }

    #$print_r($book_info);

?>

    <link rel="stylesheet" href="css/profile.css"/>

    <head>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart', 'bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {

        var chartDiv = document.getElementById('chart_div');
        
        var data = google.visualization.arrayToDataTable([
          ['Месяц', <?php foreach ($book_info as $b) { echo "'$b[1]', "; } ?>],
          ['<?php echo strftime('%B', strtotime('-3 month')); ?>', <?php $valid = array(); foreach ($book_info as $b) { foreach ($b[2] as $r) { if (date(strtotime($r[1])) > date(strtotime('-3 month')) && date(strtotime($r[1])) < date(strtotime('-2 month'))) { array_push($valid, $r); } else { array_push($valid, array( 0, 0, 0, 0, 0)); } } } /*print_r($valid);*/ foreach ($valid as $v) { $diff = $v[3] - $v[2]; $amount = $diff * $v[4]; echo ''.$amount.', '; } ?>],
          ['<?php echo strftime('%B', strtotime('-2 month')); ?>', <?php $valid = array(); foreach ($book_info as $b) { foreach ($b[2] as $r) { if (date(strtotime($r[1])) > date(strtotime('-2 month')) && date(strtotime($r[1])) < date(strtotime('-1 month'))) { array_push($valid, $r); } else { array_push($valid, array( 0, 0, 0, 0, 0)); } } } /*print_r($valid);*/ foreach ($valid as $v) { $diff = $v[3] - $v[2]; $amount = $diff * $v[4]; echo ''.$amount.', '; } ?>],
          ['<?php echo strftime('%B', strtotime('-1 month')); ?>', <?php $valid = array(); foreach ($book_info as $b) { foreach ($b[2] as $r) { if (date(strtotime($r[1])) > date(strtotime('-1 month')) && date(strtotime($r[1])) < date(strtotime('today'))) { array_push($valid, $r); } else { array_push($valid, array( 0, 0, 0, 0, 0)); } } } /*print_r($valid);*/ foreach ($valid as $v) { $diff = $v[3] - $v[2]; $amount = $diff * $v[4]; echo ''.$amount.', '; } ?>]
        ]);

        var classicOptions = {
          series: {
            0: {targetAxisIndex: 0},
          },
          title: 'Растраты за месяц',
          vAxes: {
            0: {title: 'Сумма'},
          }
        };

        function drawClassicChart() {
          var classicChart = new google.visualization.ColumnChart(chartDiv);
          classicChart.draw(data, classicOptions);
        }

        drawClassicChart();
    };
    </script>

    </head>

    <body class="container">
        <?php include_once('elements/header.php') ?>

        <div class="content">

            <div class="stats">

                <h2 class="title">Статистика</h2>

                <div class="chart_div" id="chart_div"></div>

            </div>

            <hr>

            <div class="chpwd">
                
                <form method="post" class="form">

                    <h2 class="title">Изменить пароль</h2>
                    
                    <input type="password" class="input" name="pwd" placeholder="Старый пароль*">
                    <div class="error"><?php echo $passwordErr ?></div>

                    <input type="password" class="input" name="npwd" placeholder="Новый пароль*">
                    <div class="error"><?php echo $confirm_passwordErr ?></div>

                    <input type="password" class="input" name="cnpwd" placeholder="Повторите пароль*">
                    <div class="error"></div>

                    <input type="submit" name="submit_password" class="submit_button" value="Сохранить"/>

                </form>

            </div>

            <hr>

            <div class="settings">

                <h2 class="title">Управление аккаунтом</h2>

                <a href="remove_user.php?user_id='$session_user_id'" class="btn">Удалить аккаунт</a>

            </div>

        </div>

        <?php include_once('elements/footer.php') ?>
    </body>
</html>