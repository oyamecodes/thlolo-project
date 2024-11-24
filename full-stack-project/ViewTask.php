<?php
session_start();
if (isset($_SESSION['Lusername']) && isset($_GET['id'])) {
    $pID = intval($_GET['id']);

    require_once 'db_connect.php';

    // Verify task exists and belongs to user
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ? AND (assigned_to = ? OR ? IN (SELECT username FROM users WHERE role = 'Admin'))");
    $stmt->bind_param("iss", $pID, $_SESSION['Lusername'], $_SESSION['Lusername']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
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
                    <label id="txtTime"></label>
                    <div>
                        <ul>
                            <li><a href="profile.php">Profile</a></li>
                            <li id="logout">Logout</li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="main-back">
                <div class="form" id="frmnew-item">
                    <div class="upper-sec">
                        <label class="lbl-new-item">Edit Item</label>
                        <div class="div-btn">
                            <a name="btnCancel" id="btnCancel" href="home.php" class="new-item">Close</a>
                        </div>
                    </div>
                    <form method='POST' action='EditTask.php?id=<?php echo $row['id']; ?>' class='form-submit'>
                        <label class="lbl">Title: </label>
                        <input class="txtInput" type="text" id="txttitle" name="txttitle" value="<?php echo $row['title']; ?>" required placeholder="Title..."/>
                        <label id="lblunFeedback"></label>
                        <br>
                        <label class="lbl">Description: </label>
                        <textarea class="txtInput" required id="txtDesc" name="txtDesc"><?php echo $row['description']; ?></textarea>
                        <label id="lbpaFeedback"></label>
                        <label class="lbl">Completion Date: </label>
                        <input class="txtInput" value="<?php echo $row['completion_date']; ?>" type="date" id="dtDate" required name="dtDate" placeholder="Due Date..."/>
                        <label id="lbrepaFeedback"></label>
                        <br>
                        <label class="lbl">Assigned to: </label>
                        <input class="txtInput" type="text" value="<?php echo $row['assigned_to']; ?>" id="txtassign" name="txtassign" required placeholder="assign to..."/>
                        <br>
                        <label class="lbl">Status: </label>
                        <select class="txtInput" id="status" name="status">
                            <option value="pending" <?php if ($row['status'] == 'pending') echo 'selected'; ?>>pending</option>
                            <option value="in-progress" <?php if ($row['status'] == 'in-progress') echo 'selected'; ?>>in-progress</option>
                            <option value="completed" <?php if ($row['status'] == 'completed') echo 'selected'; ?>>completed</option>
                        </select>
                        <br>
                        <input class='btn btn-info btn-block addItemBtn new-item' type='submit' value='Update' />
                    </form>
                    <form method='POST' action='delete.php?id=<?php echo $row['id']; ?>' class='form-submit'>
                        <button class='btn btn-info btn-block addItemBtn new-item'><i class='fas fa-cart-plus'></i>&nbsp;&nbsp;Delete</button>
                    </form>
                </div>
            </div>
            <script src="javascript/ViewItem.js"></script>
            <script src="javascript/Logout.js"></script>
        </body>
        </html>
        <?php
    } else {
        echo "Task not found or access denied.";
    }
    $stmt->close();
    $conn->close();
} else {
    header("Location: index.php");
    exit();
}
?>