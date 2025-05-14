<?php
$message = "";
require_once "config.php";
require_once "studdelete.php";
$Username = $_SESSION['username'];
$query = "SELECT usertype, profile_picture FROM tblaccounts WHERE username = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "s", $Username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $Usertype, $profilePicture);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
if (isset($_POST['btnDeleteLogs'])) {
    $sql_delete_logs = "TRUNCATE TABLE tbllogs";
    if (mysqli_query($link, $sql_delete_logs)) {
        $message = "<strong><span style='color: green;'>You have Deleted all logs successfully</span></strong>";
        $date = date("Y-m-d");
        $time = date("h:i:sa");
        $action = "Deleted all logs";
        $id = $_SESSION['username'];
        $module = "Database Management";
        $insert_query = "INSERT INTO tbllogs (datelog, timelog, id, performedby, action, module) VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt_log = mysqli_prepare($link, $insert_query)) {
            mysqli_stmt_bind_param($stmt_log, "ssssss", $date, $time, $id, $_SESSION['usertype'], $action, $module);
            if (mysqli_stmt_execute($stmt_log)) {
                $message .= "<br><strong><span style='color: green;'>Log for deletion inserted successfully</span></strong>";
            } else {
                $message .= "<br><strong><span style='color: red;'>Error inserting deletion log: " . mysqli_error($link) . "</span></strong>";
            }
        } else {
            $message .= "<br><strong><span style='color: red;'>Error preparing log statement: " . mysqli_error($link) . "</span></strong>";
        }        
    } else {
        $message = "<strong><span style='color: red;'>Error on deleting logs</span></strong>";
    }
}
if(isset($_POST['btnsubmit'])) {
    $username = trim($_POST['txtstudentnum']); 
    $studentnum = trim($_POST['txtstudentnum']); 
    $sql_delete_account1 = "DELETE FROM tblstudent WHERE studentnumber = ?";
    if($stmt_delete1 = mysqli_prepare($link, $sql_delete_account1)) {
        mysqli_stmt_bind_param($stmt_delete1, "s", $studentnum);
        if(mysqli_stmt_execute($stmt_delete1)) {
            // Prepare delete statement for tblstudents
            $sql_delete_account2 = "DELETE FROM tblaccounts WHERE username = ?";
            if($stmt_delete2 = mysqli_prepare($link, $sql_delete_account2)) {
                mysqli_stmt_bind_param($stmt_delete2, "s", $username);
                if(mysqli_stmt_execute($stmt_delete2)) {
                    $sql_insert_log = "INSERT INTO tbllogs (datelog, timelog, id, performedby, action, module) VALUES (?, ?, ?, ?, ?, ?)";
                    if($stmt_log = mysqli_prepare($link, $sql_insert_log)) {
                        $date = date("Y-m-d");
                        $time = date("h:i:sa");
                        $module = "Students Management";
                        $action = "Delete";
                        mysqli_stmt_bind_param($stmt_log, "ssssss", $date, $time, $username, $_SESSION['username'], $action, $module);
                        if(mysqli_stmt_execute($stmt_log)) {
                            $message = "<strong><span style='color: green;'>You have successfully Deleted a Student</span></strong>";
                        } else {
                            $message = "<strong><span style='color: red;'>Error on inserting logs</span></strong>";
                        }
                    } else {
                        $message = "<strong><span style='color: red;'>Error preparing log statement</span></strong>";
                    }
                } else {
                    $message = "<strong><span style='color: red;'>Error on deleting student account</span></strong>";
                }
            } else {
                $message = "<strong><span style='color: red;'>Error preparing delete statement for student account</span></strong>";
            }
        } else {
            $message = "<strong><span style='color: red;'>Error on deleting account</span></strong>";
        }
    } else {
        $message = "<strong><span style='color: red;'>Error preparing delete statement for account</span></strong>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Page -  Subject Advising System</title>
    <link rel="icon" type="image/png" sizes="32x32" href="./img/logo1.svg">
     <link rel="stylesheet" href="style.css">
     <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        .modal-content {
            background-color: #ffffff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            max-width: 400px;
        }
        .modal-content form {
            display: flex;
            flex-direction: column;
        }
        .modal-content button {
            margin-top: 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            background-color: #007bff;
            color: #ffffff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .modal-content button:hover {
            background-color: #0056b3;
        }
        
        #deleteStudentNum {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            font-size: 16px;
            color: #333;
            box-sizing: border-box;
            position: relative;
            margin-bottom:10px;
        }

        #deleteStudentNum:focus {
            outline: none;
            border-color: #5cb85c;
        }

        #deleteStudentNum::before {
            content: '\f007';
            font-family: FontAwesome;
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #aaa;
        }
.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.Welcome {
    background-color: #335792;
    padding: 10px;
    text-align: center;
    margin-bottom: 20px;
}
.logo {
    position:absolute;
    top: 10px;
    right: 0;
    width: 50px;
    height: 60px;
    background-image: url('./img/logo1.svg');
    background-size: contain;
    background-repeat: no-repeat;
    border-radius: 50%;
    margin-right: 430px;
    margin-top:10px;
}
.reglogo {
    position:absolute;
    top: 10px;
    right: 0;
    width: 50px;
    height: 60px;
    background-image: url('./img/logo1.svg');
    background-size: contain;
    background-repeat: no-repeat;
    border-radius: 50%;
    margin-right: 480px;
}
.Welcome h1 {
    color: #ffffff;
    font-size: 18px;
    margin-top: 5px;
}

.Welcome a {
    display: inline-block;
    background-color: #ff6f61;
    color: #ffffff;
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.Welcome a:hover {
    background-color: #ff5440;
}

.accountwelcome {
    background-color: #f9f9f9;
    border: 2px solid #000000;
    border-radius: 8px;
    padding: 5px;
    margin-bottom: 40px;
    text-align: center;
}

.accountwelcome h1 {
    color: #000000;
    font-size: 24px;
    margin-bottom: 10px;
}
.notification {
    display: none;
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #ffffff;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    z-index: 1;
}
.accountwelcome h4 {
    color: #000000;
    font-size: 18px;
    margin-top: 10px;
}

form {
    text-align: left;
    margin-top: 30px;
    margin-left: 50px;
}

input[type="text"]{
    padding: 10px;
    width: 20%;
    margin-bottom: 10px;
    border: 1px solid #000000;
    border-radius: 4px;
    
}

input[type="submit"] {
    padding: 10px 20px;
    background-color: #0059ff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

input[type="submit"]:hover {
    background-color: #000877;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

a {
    text-decoration: none;
    color: #000000;
    margin-right: 10px;
}

.btnupdate, .btndelete .btnlogs{
    display: inline-block;
    padding: 5px 10px;
    text-align: center;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}
input[type="submit"].btnlogs{
    background-color: #ff2222;
    margin-left: 5px;
}
.btnupdate {
    background-color: #00c907; 
    color: #fff;
    border: 2px solid #00c907;
}

.btndelete {
    background-color: #ff2222; 
    color: #fff;
    margin-left:5px;
    margin-right:5px;
    border: 2px solid #ff2222;
}

.btnupdate:hover, .btndelete:hover {
    background-color: transparent; 
}
.profile-picture-container {
    position: absolute;
    top: 5px;
    right: 80px;
}

.profile-picture {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin-bottom:10px;
    object-fit: cover;
    border:none;
    box-shadow:none;
}
.username {
    color: white;
    font-size: 18px;
    margin-left: 1100px; 
    display: inline-block;
}
.regusername{
    color: white;
    font-size: 18px;
    margin-left: 1070px; 
    display: inline-block;
}
.hamburger-icon {
    font-size: 18px;
    color: white; 
    border-radius: 50%;
    padding: 6px;
    position: absolute;
    bottom:25px;
    right:21px; 
}
.modallogs {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-contentlogs {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 800px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .modal-contentlogs table {
        width: 100%;
        border-collapse: collapse;
        background-color:lightblue;
    }

    .modal-contentlogs table th,
    .modal-contentlogs table td {
        padding: 8px;
        border: 1px solid #ddd;
        text-align: left;
        background-color:lightblue;
    }

    .modal-contentlogs table th {
        background-color: #f2f2f2;
    }

    .modal-contentlogs table tr:nth-child(even) {
        background-color:lightblue;
    }

    .modal-contentlogs table tr:hover {
        background-color:lightblue;
    }

    .modal-contentlogs button {
        margin-top: 10px;
        padding: 10px 20px;
        border: none;
        border-radius: 3px;
        background-color: #007bff;
        color: #ffffff;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .modal-contentlogs button:hover {
        background-color: #0056b3;
    }
@media screen and (max-width: 600px) {
    body {
        margin: 0;
        padding: 0;
        width: 100%;
        overflow-x: hidden; 
    }
    .container {
        padding: 10px;
        box-sizing: border-box; 
    }
    input[type="text"],
    input[type="password"] {
        width: 100%;
        box-sizing: border-box;
    }
    table {
        font-size: 14px;
        width: 100%;
        max-width: 100%;
        margin-top: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
    }
    th, td {
        padding: 12px 10px; 
        text-align: left;
        border: 1px solid #000000;
        font-weight: normal; 
        color: #000000;
        white-space: nowrap;
        overflow: hidden; 
        text-overflow: ellipsis; 
    }
    tr {
        font-weight: normal; 
        color: #000000;
    }
    .btnupdate, .btndelete {
        display: block;
        width: 100%;
        margin-bottom: 10px;
    }

}
    </style>
</head>
<header>
    <nav class="topnav" id="mytopnav">
        <?php if ($Usertype === 'ADMINISTRATOR'): ?>
            <a href="index.php">Home</a>
            <a href="accounts_management.php">Accounts</a>
            <a  href="studentpage.php">Students</a>
            <a href="subject_management.php">Subjects</a>
            <a href="grades-management.php">Grades</a>
            <div class ="welcome">
                <div class="logo"></div>
            <h3 style="margin-right:380px;margin-top:33px" class="brand"><strong>Arellano University Subject Advising System</strong></h3>
            </div>
            <div class="profile-picture-container">
    <div class="dropdown">
        <img src="<?= $profilePicture ?>" alt="Profile Picture" class="profile-picture dropbtn" onclick="toggleDropdown()"><span class="hamburger-icon">&#9776;</span>
        <div class="dropdown-content" id="dropdownContent">
             <a href="#"><?php echo $_SESSION['usertype']; ?></a>
             <a href="advising-management.php">Advising Subject</a>
            <a href="profile.php">Edit Profile</a>
            <a href="indexlogout.php">Logout</a>
        </div>
    </div>
    </div>
        <div class="username"><?php echo $_SESSION['username']; ?></div>
       </div>
        <?php elseif ($Usertype === 'REGISTRAR'|| $Usertype === 'STAFF'): ?>
            <a href="index.php">Home</a>
            <a href="studentpage.php">Students</a>
            <a href="subject_management.php">Subjects</a>
            <a href="grades-management.php">grades</a>
            <div class ="welcome">
            <div class="reglogo"></div></div>
       <h3 style="margin-right:300px"class="brand"><strong>Arellano University Subject Advising System</strong></h3>
       <div class="profile-picture-container">
    <div class="dropdown">
        <img src="<?= $profilePicture ?>" alt="Profile Picture" class="profile-picture dropbtn" onclick="toggleDropdown()"><span class="hamburger-icon">&#9776;</span>
        <div class="dropdown-content" id="dropdownContent">
             <a href="#"><?php echo $_SESSION['usertype']; ?></a>
             <a href="advising-management.php">Advising Subject</a>
            <a href="profile.php">Edit Profile</a>
            <a href="indexlogout.php">Logout</a>
        </div>
    </div>
    </div>
        <div class="regusername"><?php echo $_SESSION['username']; ?></div>
       </div>
        <?php else: ?>
            <div class="profile-picture-container">
    <div class="dropdown">
        <img src="<?= $profilePicture ?>" alt="Profile Picture" class="profile-picture dropbtn" onclick="toggleDropdown()">
        <div class="dropdown-content" id="dropdownContent">
             <a href="#"><?php echo $_SESSION['usertype']; ?></a>
            <a href="profile.php">Edit Profile</a>
            <a href="indexlogout.php">Logout</a>
        </div>
    </div>
    </div>
        <div class="username"><?php echo $_SESSION['username']; ?></div>
       </div>
       <h3 style="margin-right:10px"class="brand"><strong>Arellano University Subject Advising System</strong></h3>
        <?php endif; ?>
    </nav>
</header>
<body>
    <div class="notification" id="notification"></div>
    <script>
        function displayNotification(message, type) {
            var notification = document.getElementById('notification');
            notification.style.display = 'block';
            notification.innerHTML = '<div class="notification-content">' +
                '<div class="notification-icon ' + type + '"></div>' +
                '<div class="notification-message">' + message + '</div>' +
                '</div>';
            setTimeout(function() {
                notification.style.display = 'none';
            }, 3000);
            event.preventDefault();
        }
       <?php
        if (!empty($message )) {
            echo "displayNotification('<b>" . addslashes($message ) . "</b>', 'success');";
        }
        ?>
    </script>
     <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <strong>Search:</strong> <input type="text" name="txtsearch">
        <input type="submit"style="background-color: orange; color: #fff; font-weight: bold"  name="btnsearch" value="Search"><br>
        <button type="button" onclick="openLogsModal()" style="width: 180px; height: 30px; margin-right: 10px; background-color: orange; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight:bold">View Logs</button>
        <strong><a style="cursor:hand" href="studcreate.php">Create new Student</a></strong>        
    </form>
    </form>
    <div class="modal" id="deleteformmodal">
    <div class="modal-content">
        <h2><strong>Are you sure you want to delete this account?</strong></h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"id="deleteForm" method="POST">
            <label for="deleteStudentNum">Student number:</label>
            <input type="text" id="deleteStudentNum" name="txtstudentnum" readonly>
            <button type="submit" name="btnsubmit" value="Yes" onclick="confirmDeleteAccount()" style="font-weight: bold;background-color:green;">Yes</button>
            <button type="button" name="btncancel" onclick="closeDeleteModal();" style="font-weight: bold;background-color:red;">No</button>
        </form>
    </div>
</div>
<div class="modallogs" id="logsModal">
    <div class="modal-contentlogs">
        <h2><strong>Logs</strong></h2>
        <strong>Search:</strong> <input type="text" id="txtlogsearch">
        <button type="button" id="btnLogSearch" style="width: 120px; height: 30px; margin-right:5px;">Search Logs</button>
        <input type="file" id="fileInput" style="display: none;" accept=".xls">
        <label for="fileInput" id="fileInputLabel" style="cursor: pointer; width: 180px; height: 30px; font-weight:bold;color:black; background-color:lightblue; margin-left:20px;">Export as Excel</label>
        <div id="logsContent"></div> 
        <button type="button" onclick="closeLogsModal()" style="font-weight: bold;">Close</button>
        <button type="button" style="width: 120px; height: 50px;background-color:Red;color:white; margin-left:5px;" onclick="openDeleteAllLogsModal()">Delete All Logs</button>
        <div class="modal" id="deleteAllLogsModal">
            <div class="modal-content">
                <h2><strong>Are you sure you want to delete all logs?</strong></h2>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"id="deleteAllLogsForm" method="POST" onsubmit="return confirmDeleteLogs()">
                    <input type="submit" name="btnDeleteLogs" value="Yes" style="font-weight: bold;background-color:green;">
                    <button type="button" onclick="closeDeleteAllLogsModal();" style="font-weight: bold;background-color:red;">No</button>
                </form>
            </div>
        </div>
    </div>   
</div>
<script>
     document.getElementById("btnLogSearch").addEventListener("click", fetchLogs);
    document.getElementById("fileInputLabel").addEventListener("click", handleFileDownload);
    function fetchLogs() {
        var searchText = document.getElementById("txtlogsearch").value;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'fetch_logs.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('logsContent').innerHTML = xhr.responseText;
            }
        };
        xhr.send('txtlogsearch=' + searchText);
    }
    function handleFileDownload() {
    var logsContent = document.getElementById("logsContent").innerHTML;
    var logsTable = "<table>" + logsContent + "</table>";
    var blob = new Blob([logsTable], { type: 'application/vnd.ms-excel' });
    var link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.download = 'Reportlogs.xls'; 
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
    <script>
        function openDeleteModal(studentnumber) {
            var modal = document.getElementById("deleteformmodal");
            modal.style.display = "block";
            var studentNumInput = document.getElementById("deleteStudentNum");
            studentNumInput.value = studentnumber;
        }
        function closeDeleteModal() {
            var modal = document.getElementById("deleteformmodal");
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            var modal = document.querySelector(".modal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function openDeleteAllLogsModal() {
            var modal = document.getElementById('deleteAllLogsModal');
            modal.style.display = 'block';
        }

        function closeDeleteAllLogsModal() {
            var modal = document.getElementById('deleteAllLogsModal');
            modal.style.display = 'none';
        }
        function toggleDropdown() {
        var dropdownContent = document.getElementById("dropdownContent");
        if (dropdownContent.style.display === "block") {
            dropdownContent.style.display = "none";
        } else {
            dropdownContent.style.display = "block";
        }
    }
    function openLogsModal() {
            var modal = document.getElementById('logsModal');
            modal.style.display = 'block';
            fetchLogs();
        }

        function closeLogsModal() {
            var modal = document.getElementById('logsModal');
            modal.style.display = 'none';
        }

        function fetchLogs() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_logs.php', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('logsContent').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>
   <?php
   echo '<div class="main">';
    if (!function_exists('buildTable')) {
        function buildTable($result) {
            if(mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th>Student number</th> <th>Lastname</th> <th>Firstname</th> <th>Middlename</th> <th>Course</th> <th>Year Level</th> <th>Date Created </th> <th>Action</th>";
                echo "</tr>";
                echo "<br>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td><strong>" . $row['studentnumber'] . "</strong></td>";
                    echo "<td><strong>" . $row['lastname'] . "</td></strong>";
                    echo "<td><strong>" . $row['firstname'] . "</td></strong>";
                    echo "<td><strong>" . $row['middlename'] . "</td></strong>";
                    echo "<td><strong>" . $row['course'] . "</td></strong>";
                    echo "<td><strong>" . $row['yearlevel'] . "</td></strong>";
                    echo "<td><strong>" . $row['datecreated'] . "</td></strong>";
                    echo "<td>";
                    echo "<a href='studupdate.php?studentnumber=" . $row['studentnumber'] . "' class='btnupdate'><strong>Update</strong></a>'<br>'"; 
                    echo "<button onclick='openDeleteModal(\"" . $row['studentnumber'] . "\")' class='btndelete' style='width: 70px; height: 30px;'><strong>Delete</strong></button>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No record/s found.";
            }
        }     
    }    
    if(isset($_POST['btnsearch'])) {
        $sql = "SELECT * FROM tblstudent WHERE studentnumber LIKE ? OR lastname LIKE ?";
        if($stmt = mysqli_prepare($link, $sql)) {
            $searchvalue = '%' . $_POST['txtsearch'] . '%';
            mysqli_stmt_bind_param($stmt, "ss", $searchvalue, $searchvalue);
            if(mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                buildTable($result);
            } else {
                echo "Error executing statement: " . mysqli_stmt_error($stmt);
            }
        } else {
            echo "Error preparing statement: " . mysqli_error($link);
        }
    } else {
        $sql = "SELECT * FROM tblstudent ORDER BY studentnumber";
        if ($stmt = mysqli_prepare($link, $sql)) {
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt); 
                buildTable($result);
            } else {
                echo "Error executing statement: " . mysqli_stmt_error($stmt);
            }
        } else {
            echo "Error preparing statement: " . mysqli_error($link);
        }
    }
    mysqli_close($link);
    echo '</div>';
 ?> 
 </body>
<footer class="footer">
 <div class="social-media">
     <a href="https://www.facebook.com/ArellanoUniversityOfficial/"><img src="img/facebook.svg" alt="Facebook"></a>
     <a href="https://twitter.com/Arellano_U"><img src="img/twitter.svg" alt="Twitter"></a>
     <a href="https://www.instagram.com/explore/topics/495287895113599/arellano-university/"><img src="img/instagram.svg" alt="Instagram"></a>
 </div>
 <footer class="footer">
     <ul>
         <li><a href="#">Terms of Service</a></li>
         <li><a href="#">Privacy Policy</a></li>
     </ul>
</footer>
</html>