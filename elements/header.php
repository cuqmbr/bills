<style>
    /* ****HEADER**** */
    .header {
        background-color: #D3DCE3;
        
        height: 100px;

        padding: 0px 20px 0px 20px;

        border-bottom: 1px solid #aaa;
        box-shadow: 0px 1.5px 8px #444;

        top: 0;

        z-index: 100;
    }

    /* NAVIGATION*** */
    .navigation {
        height: 100px;

        display: grid;

        grid-template-rows: 0px 100%;

        align-items: center;
    }

    .buttons {  
        width: fit-content;
        
        position: relative;
        left: 100%;
        transform: translate(-100%, 0);
    }

    .btn1 {
        display: inline-block;

        background-color: #235A81;
        
        padding: 20px 40px 20px 40px;
        margin: 0px 5px 0px 5px;

        border-radius: 30px;

        text-decoration: none;
        font-size: 15px;
        text-shadow: 0.5px 0.5px 0.5px #444;
        font-weight: bolder;
        color: #fff;
    }

    .btn1:hover {
        background-color: #1f4f72;
    }

    .btn2 {
        background-color: transparent;
        
        padding: 20px 40px 20px 40px;
        margin: 0px 5px 0px 5px;

        border-radius: 30px;

        text-decoration: none;
        font-size: 15px;
        text-shadow: 0.5px 0.5px 0.5px #fff;
        font-weight: bolder;
        color: #444;
    }

    .btn2:hover {
        background-color: #235A81;
        color: #fff;
        text-shadow: 0.5px 0.5px 0.5px #444;
    }
    /* MENUS */
    .menus {
        width: fit-content;
    
        transform: translate(0%, 50px);
    }

    .logo {
        height: 60px;
    }
    
    
    @media screen and (max-width: 450px) {
        .btn1 {
            display: inline-block;

            background-color: #235A81;
            
            padding: 20px 30px 20px 30px;
            margin: 0px 5px 0px 5px;

            border-radius: 30px;

            text-decoration: none;
            font-size: 15px;
            text-shadow: 0.5px 0.5px 0.5px #444;
            font-weight: bolder;
            color: #fff;
        }

        .btn2 {
            background-color: transparent;
            
            padding: 20px 30px 20px 30px;
            margin: 0px 5px 0px 5px;

            border-radius: 30px;

            text-decoration: none;
            font-size: 15px;
            text-shadow: 0.5px 0.5px 0.5px #fff;
            font-weight: bolder;
            color: #444;
        }

    .logo {
        height: 50px;
    }
    }
</style>

<header class="header">
                
                <nav class="navigation">
                    
                    <div class="menus">

                        <a href="index.php" title="На главную"><img src="img/logo.png" class="logo"></a>           

                    </div>

                    <div class="buttons">
                        <?php 
                            if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
                                echo '<a href="login.php" class="btn1">Войти</a>';
                            } else {
                                echo '<a href="profile.php?user_id='.$_SESSION['user_id'].'" class="btn2">Аккаунт</a>
                                <a href="logout.php" class="btn1">Выйти</a>';
                            }
                        ?>
                    </div>
                    
                </nav>
</header>