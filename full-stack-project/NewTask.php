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
                    <li><a href="profile.php">Profile</a></li>
                    <li id="logout">Logout</li>
                </ul>
            </div>

        </div>
    </nav>

    <div class="main-back">
            
        <form  action="addTask.php" method="POST">
            <div class="form" id="frmnew-item">
                <div class="upper-sec">
                    <label class="lbl-new-item">New task</label>
                    
                    <div class="div-btn">
                        <a name="btnCancel" id="btnCancel" href="home.php" class="new-item">Cancel</a>
                        <input type="submit" id="Save" value="Save" name="btnSave" class="btnSubm">
                    </div>
                </div>

                <label class="lbl">Title:</label>
                <input class="txtInput" type="text" required  id="txtTitle" name="txttitle" required placeholder="Title...">
                <label id="lblunFeedback"></label>
                
                <label class="lbl">Description:</label>
                <textarea class="txtInput" required required  id="txtDesc" name="txtDesc"></textarea>
                <label id="lbpaFeedback"></label>
                
                <label class="lbl">completion date</label>
                <input class="txtInput" type="date" required  id="dtDate" name="dtDate" required placeholder="completion date...">
                <label id="lbrepaFeedback"></label>
                
                <label class="lbl">assigned to</label>
                <input class="txtInput" type="text" required  id="txtassign" name="txtassign" required placeholder="assigned to...">
                <label id="lblunFeedback"></label>
            </div>
        </form>
            

    </div>
    <!--<script src="javascript/NewTask.js"></script>-->
    <script src="javascript/Logout.js"></script>
</body>
</html>