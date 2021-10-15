<?php
    include 'classes/dbh.class.php';  
    include 'classes/subs.class.php';  
    include 'classes/subscontroller.class.php';    
    if (isset($_POST['email'])){
        $controller = new SubsController();
        $subsDate = date('Y-m-d H:i:s');
        $result = $controller->addSubscription($_POST['email'], isset($_POST['tos']), $subsDate);
        if (isset($_POST['javaScriptEnabled']))
        //JavaScript is enabled, it handles response
        {
            if($result === 'save_success'){
                echo 'save_success';
            }
            else{
                echo $result;
            }
            exit();//exit only if javascrip enabled
        }
        else{
            //Javascript is not enabled, response handled by php
        }     
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta lang="en-US">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pineapple</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="js/script.js" defer></script>     
    </head>
    <body>
        <div class="container">
            <header id="top-bar">
                <img src="/img/logo_pineapple-1.svg" alt="Pineapple logo" id="big-logo">
                <img src="/img/pineapple.svg" alt="Pineapple logo" id="small-logo">
                <nav>
                    <ul id="top-menu">
                        <li><a href="#">About</a></li>
                        <li><a href="#">How it works</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </nav>
            </header>
            <div class="main-content">                
                <main>
                    <?php if (isset($result) && ($result == 'save_success')): ?>
                        <img src="img/ic_success.svg" alt="Submission success trophy" class="trophy">
                        <h1 class="main-title centered">Thanks for subscribing!</h1>
                        <p class="sub-title centered">You have successfully subscribed to our email listing. Check your email for the discount code.</p>
                    <?php else: ?>
                        <img src="img/ic_success.svg" alt="Submission success trophy" class="trophy" hidden>
                        <h1 class="main-title centered">Subscribe to newsletter</h1>
                        <p class="sub-title centered">Subscribe to our newsletter and get 10% discount on pineapple glasses.</p>
                        
                    <?php endif; ?>
                    <form id="subscribe-form" method="post" action="index.php" <?php if (isset($result) && ($result == 'save_success')): ?>hidden<?php endif; ?>>
                        <div id="input-container">
                            <input type="email" id="email-input" name="email" placeholder="Type your email address here…" required>
                            <input type="submit" value="">
                        </div>
                        <?php if (isset($result) && ($result != 'save_success')): ?>
                            <div class="error-message"><?php echo $result ?></div>
                        <?php endif; ?>
                        <div id="tos-container" class="centered">
                            <input type="checkbox" id="tos" name="tos">
                            <label for="tos">I agree to <a href="#">terms of service</a></label>
                        </div>
                    </form>
                </main>
                <hr>
                <footer>
                    <span class="icon-facebook"></span>
                    <span class="icon-instagram"></span>
                    <span class="icon-twitter"></span>
                    <span class="icon-youtube"></span>
                </footer>             
            </div>
        </div>
    </body>
</html>