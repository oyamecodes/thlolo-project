<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

    <nav>
        <div class="nav-bar">
            <label id="txtTime">00:00:00</label>
            
            <div>
                <ul>
                    <li><a href="Login.php">Login</a></li>
                </ul>
            </div>

        </div>
    </nav>
    <div class="main-back">
        
        <form action="register_process.php" method="POST">
                <div class="form">
                <div>
                    <img src="images\sign-up-icon-registration.jpg">
                    <div>
                        <label>Sign up</label>
                        <label>Create your new account</label>
                    </div>
                </div>
                <label class="lbl">Username:</label>
                <input class="txtInput" type="text" required id="txtregUsername" name="username" required placeholder="Username">
                <label id="lblunFeedback"></label>
                <label class="lbl">Password:</label>
                <input class="txtInput" type="password" id="txtregPassword" name="password" required placeholder="password">
                <label id="lbpaFeedback"></label>
                <label class="lbl">Re-type password:</label>
                <input class="txtInput" type="password" id="txtRePassword" name="retype" required placeholder="password">
                <label id="lbrepaFeedback"></label>

                <input type="submit" class="log-reg-buttons" value="Register" id="btnRegister">

                <div class="below-text">
                    <label>Already have an account?</label> <a class="lblsign-up" href="index.php">Login</a>
                </div>

            </div>
        </form>

        

    </div>

    <script src="javascript/Register.js"></script>
    
</body>
</html>

<?php

?>
