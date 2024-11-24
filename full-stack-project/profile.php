<?php
session_start();
if (!isset($_SESSION['Lusername'])) {
    header("Location: index.php");
    exit();
}

require_once 'db_connect.php';
$username = $_SESSION['Lusername'];

$stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    session_destroy();
    header("Location: index.php");
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <nav>
        <div class="nav-bar">
            <label id="txtTime">00:00:00</label>
            <div>
                <ul>
                    <li id="logout">Logout</li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="main-back">
        <!-- Add method and action to the form -->
        <form method="POST" action="update_profile.php" id="profileForm">
            <div class="form">
                <div class="div-upp-pro">
                    <img src="images/profilep.jpg" alt="Profile Picture" class="pro-pic">
                    
                    <div class="div-btn-profile">
                        <a href="home.php" class="new-item">Home</a>
                        <button type="submit" name="update" class="btnSubm">Save</button>
                    </div> 
                </div>

                <label class="lbl" for="txtUsername">Username:</label>
                <input class="txtInput" type="text" id="txtUsername" name="username" 
                       required placeholder="Username" value="<?php echo htmlspecialchars($username); ?>">
                <label id="lblunFeedback" class="feedback"></label>

                <label class="lbl" for="txtPassword">Password:</label>
                <input class="txtInput" type="password" id="txtPassword" name="password" 
                       placeholder="Enter new password" required>
                <label id="lbpaFeedback" class="feedback"></label>

                <label class="lbl" for="txtRePassword">Re-type password:</label>
                <input class="txtInput" type="password" id="txtRePassword" name="repassword" 
                       placeholder="Confirm new password" required>
                <label id="lbrepaFeedback" class="feedback"></label>

                <label class="lbl-new-item"></label>
            </div>
        </form>
    </div>
    
    <script>
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        const password = document.getElementById('txtPassword').value;
        const repassword = document.getElementById('txtRePassword').value;
        
        if (password !== repassword) {
            e.preventDefault();
            alert('Passwords do not match!');
            return false;
        }
        return true;
    });
    </script>
    <script defer src="javascript/profile.js"></script>
    <script defer src="javascript/Logout.js"></script>
</body>
</html>

