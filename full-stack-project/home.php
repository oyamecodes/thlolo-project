<?php
session_start();
if (!isset($_SESSION['Lusername'])) {
    header("Location: index.php");
    exit();
}
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
            <label id="txtTime">00:00:00</label>

            <div class="nav-inner">
                

                <ul>
                    <div class="dropdown">

                        <img class="dropbtn" src="images/4737445_alarm_alert_bell_notification_ring_icon.png">
                        
                        <div class="dropdown-content">
                    
                        </div>
                    </div>

                    <li><a href="profile.php">Profile</a></li>
                    <li id="logout">Logout</li>
                </ul>
            </div>

        </div>
    </nav>
    
    <div class="main-back-home">
        

            <div class="upper-sec">
                <div method="" action="">
                    <input type="search" placeholder="Search title" id="txtSearch" name="txtSearch" class="txt-search">
                    
                </div>
                
                <div>
                    <a name="btnNewItem" href="NewTask.php" class="new-item">New task</a>
                </div>
            </div>
            
            <div class="tblItems">
                    <table id="tblItems">
                        <thead class="cls-thead">
                            <tr class="cls-th">
                                <th>#</th>                                
                                <th>title</th>
                                <th>Description</th>
                                <th>completion_date</th>
                                <th>assigned_to</th>
                                <th>status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody id="tblTbody">
<?php
require_once 'db_connect.php';

if (isset($_SESSION['Lusername'])) {
    $stmt = $conn->prepare("SELECT * FROM tasks ORDER BY completion_date DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    
    $count = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $count . "</td>";
        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
        echo "<td>" . htmlspecialchars($row['completion_date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['assigned_to']) . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
        echo "<td><div class='icons'>";
        // Only show edit/delete options if user is assigned to the task
        if ($_SESSION['Lusername'] === $row['assigned_to']) {
            echo "<img src='images/eye.png' onclick='ViewItem(this)' id='view-".$row['id']."'>";
            echo "<img src='images/pencil.png' onclick='EditItem(this)' id='edit-".$row['id']."'>";
            echo "<img src='images/delete (1).png' onclick='DeleteItem(this)' id='delete-".$row['id']."' style='cursor: pointer;'>";
        } else {
            // Only show view option for non-assigned tasks
            echo "<img src='images/eye.png' onclick='ViewItem(this)' id='view-".$row['id']."'>";
        }
        echo "</div></td>";
        echo "</tr>";
        $count++;
    }
    
    $stmt->close();
    $conn->close();
} else {
    header("Location: index.php");
    exit();
}
?>
                        </tbody>
                    </table>
            </div>

            <div class="table-scro">
                <label>&lt;</label>
                <label> Page 1 </label>
                <label>&gt;</label>

            </div>
    </div>
    <script defer src="javascript/hom2.js"></script>
     <script defer src="javascript/Logout.js"></script>
</body>
</html>