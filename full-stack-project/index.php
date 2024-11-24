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
                    <li>
                        <a href="SignUp.php">Register</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <div class="main-back">
        <form  action="login_process.php" method="POST">
            <div class="form">
            <div>
                <div>
                    <label>Welcome back</label>
                    <label>Login to your account</label>
                </div>
            </div>
            <label class="lbl">Username:</label>
            <input class="txtInput" type="text" id="txtlogin-username" name="username"  placeholder="Username">
            <label id="lblunFeedback"></label>
            <label class="lbl">Password:</label>
            <input class="txtInput" type="password" id="txtlogin-password" name="password" placeholder="password">
            <label id="lbpaFeedback"></label>
            <input type="submit" class="log-reg-buttons" value="Login" id="btnLogin">

            <div class="below-text">
                <label>Don't have an account?</label> <a class="lblsign-up" href="SignUp.php">Sign up</a>
            </div>
        </div>
        </form>

        
    </div>
    
    <script src="javascript/Login.js"></script>
    
</body>
</html>