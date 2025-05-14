<?php
$message = "";
require_once "config.php";
require_once "session-checker.php";
$Username = $_SESSION['username'];
$query = "SELECT usertype, profile_picture FROM tblaccounts WHERE username = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "s", $Username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $Usertype, $profilePicture);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
$link = mysqli_connect("localhost", "root", "", "itc127-2b-2024");
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(isset($_GET['studentnumber'])) {
    $studentnumber = $_GET['studentnumber']; 
}

if(isset($_POST['btnsearch'])) {
    $studentnumber = $_POST['studentnumber']; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advising Subject Management- Subject Advising System</title>
    <link rel="icon" type="image/png" sizes="32x32" href="./img/logo1.svg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap">
</head>
<style>
 header {
            background-color: #1F2833;
            font-family: Raleway,san-serif;
            color: #ffffff;
            padding: 10px;
            text-align: center;
        }
        body {
            font-family: Arial, sans-serif;
            margin-bottom: 250px ;
            padding: 0;
            background: #66FCF1;
	        background-size: cover;
        }
        .topnav {
            overflow: hidden;
            background-color: #1F2833;
            font-weight:bold;
        }

        .topnav a {
            margin-top: 20px;
            float: left;
            display: block;
            color: #ffffff;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .topnav a:hover {
            background: #FFE45C;
            color: black;
            transform: scale(1.05, 1);
            transition: .3s;
        }

        .topnav .dropdown {
            float: left;
            overflow: hidden;
        }

        .topnav .dropdown .dropbtn {
            display: block;
            color: #ffffff;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .topnav .dropdown .dropdown-content {
            display: none;
            position: absolute;
            background-color: #333;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .topnav .dropdown:hover .dropdown-content {
            display: block;
        }
        .dropdown-content:hover {
            background: #FFE45C;
            color: black;
            transform: scale(1.05, 1);
            transition: .3s;
            overflow: hidden;
        }
        .footer {
            background-color: #45A29E;
            bottom: 0;
        }
        .social-media {
            background-color: #45A29E;
        }
        
.header {
    background-color: #333;
    color: #fff;
    padding: 20px 0;
    text-align: center;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
    margin-right: 445px;
    margin-top:20px;
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
form {
    text-align: left;
    margin-top: 30px;
    margin-left: 50px;
}

input[type="number"]{
    padding: 10px;
    width: 20%;
    margin-bottom: 10px;
    border: 1px solid #000000;
    border-radius: 4px;
    
}

input[type="submit"] {
    padding: 10px 20px;
    background-color: orange;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: 0.3s; 
}

input[type="submit"]:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

a {
    text-decoration: none;
    color: #000000;
    margin-right: 10px;
}
table {
    background-color: #d4d4d4;
    width: 100%;
    border-collapse: absolute;
    margin-top: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow-y: auto; 
}

th, td {
    padding: 12px 15px;
    text-align: left;
    border: 1px solid #000000;
    font-weight: 50px;
    color: #000000;
    position: relative;
}
th {
    background-color: #F88379;
    color: #000000;
    border: 1px solid #000000;
    
}

tr {
    font-weight: 50px;
    color: #000000;
}

th:before,
td:before {
    content: '';
    position: absolute;
    top: -1px;
    left: -1px;
    right: -1px;
    bottom: -1px;
    background: linear-gradient(45deg, rgba(255,255,255,0.5), rgba(0,0,0,0.1)); 
    z-index: -1; 
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
    input[type="submit"] {
    padding: 10px 20px;
    background-color: #0059ff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}
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
<header>
    <nav class="topnav" id="mytopnav">
        <?php if ($Usertype === 'ADMINISTRATOR'): ?>
            <a href="index.php">Home</a>
            <a href="accounts_management.php">Accounts</a>
            <a href="studentpage.php">Students</a>
            <a href="subject_management.php">Subjects</a>
            <a href="grades-management.php">Grades</a>
            <div class="welcome">
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
        <?php elseif ($Usertype === 'REGISTRAR'): ?>
            <a href="index.php">Home</a>
            <a href="studentpage.php">Students</a>
            <a href="subject_management.php">Subjects</a>
            <a href="grades-management.php">Grades</a>
            <div class="welcome">
                <div class="reglogo"></div>
                <h3 style="margin-right:390px"class="brand"><strong>Arellano University Subject Advising System</strong></h3>
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
            <div class="regusername"><?php echo $_SESSION['username']; ?></div>
        <?php else: ?>
            <a  href="index.php">Home</a>
            <a  href="viewgrade.php">View Grades</a>
            <a href="viewsubject.php">Subjects to be taken</a>
            <div class="welcome">
                <div class="stulogo"></div>
                <h3 style="margin-right:500px;margin-top:10px"class="brand"><strong>Arellano University Subject Advising System</strong></h3>
            </div>
            <div class="stuprofile-picture-container">
                <div class="dropdown">
                    <img src="<?= $profilePicture ?>" alt="Profile Picture" class="stuprofile-picture dropbtn" onclick="toggleDropdown()"><span class="stuhamburger-icon">&#9776;</span>
                    <div class="dropdown-content" id="dropdownContent">
                        <a href="#"><?php echo $_SESSION['usertype']; ?></a>
                        <a href="profile.php">Profile</a>
                        <a href="change.php">change Password</a>
                        <a href="indexlogout.php">Logout</a>
                    </div>
                </div>
            </div>
            <div class="stuusername"><?php echo $_SESSION['username']; ?></div>
        <?php endif; ?>
    </nav>
</header>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <label for="studentnumber"><strong>Student Number:</strong></label>
        <input type="number" id="studentnumber" name="studentnumber" value="<?php echo $studentnumber; ?>">
        <input type="submit" style="background-color: orange; color: #fff; font-weight: bold" name="btnsearch" value="Search"><br>
        <button type="button" style="width: 180px; height: 30px; margin-right: 10px; background-color: orange; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight:bold" onclick="openLogsModal()">View Logs</button>
    </form>
    <div class="modallogs" id="logsModal">
    <div class="modal-contentlogs">
        <h2><strong>Logs</strong></h2>
        <strong>Search:</strong> <input type="text" id="txtlogsearch">
        <button type="button" id="btnLogSearch" style="width: 120px; height: 30px; margin-right:5px;">Search Logs</button>
        <input type="file" id="fileInput" style="display: none;" accept=".xls">
        <label for="fileInput" id="fileInputLabel" style="cursor: pointer; width: 180px; height: 30px; font-weight:bold;color:black; background-color:lightblue; margin-left:20px;">Import As Excel</label>
        <div id="logsContent"></div> 
        <button type="button" onclick="closeLogsModal()" style="font-weight: bold;">Close</button>
        <button type="button" style="width: 120px; height: 50px;background-color:Red;color:white; margin-left:5px;" onclick="openDeleteAllLogsModal()">Delete All Logs</button>
        <div class="modal" id="deleteAllLogsModal">
            <div class="modal-content">
                <h2><strong>Are you sure you want to delete all logs?</strong></h2>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="deleteAllLogsForm" method="POST" onsubmit="return confirmDeleteLogs()">
                    <input type="submit" name="btnDeleteLogs" value="Yes" style="font-weight: bold;background-color:green;">
                    <button type="button" onclick="closeDeleteAllLogsModal();" style="font-weight: bold;background-color:red;">No</button>
                </form>
            </div>
        </div>
    </div>   
</div>
    <script>
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
<script>
            function openDeleteModal(subjectcode) {
            var modal = document.getElementById("deleteformmodal");
            modal.style.display = "block";
            var subjectcodeInput = document.getElementById("deletesubject");
            subjectcodeInput.value = subjectcode;
        }
        

    function closeDeleteModal() {
        var modal = document.getElementById('deleteformmodal');
        modal.style.display = 'none';
    }
    </script>
    <?php
    if(isset($studentnumber)) {
        echo '<div class="student-info" style="text-align: center;">
        <h2>Students Information</h2>
        <p><strong>Student Number: ' . htmlspecialchars($studentnumber) . '</strong></p>';

        // Fetch student information
        $sql_student_info = "SELECT studentnumber, lastname, firstname, middlename, course, yearlevel FROM tblstudent WHERE studentnumber = ?";
        $stmt_student_info = mysqli_prepare($link, $sql_student_info);
        mysqli_stmt_bind_param($stmt_student_info, "s", $studentnumber);
        mysqli_stmt_execute($stmt_student_info);
        mysqli_stmt_bind_result($stmt_student_info, $studentnumber, $lastname, $firstname, $middlename, $course, $yearlevel);
        mysqli_stmt_fetch($stmt_student_info);

        echo '<p><strong>Name: ' . (isset($lastname) ? htmlspecialchars($lastname) . '&nbsp;' . htmlspecialchars($firstname) . '&nbsp;' . htmlspecialchars($middlename) : '') . '</strong></p>
        <p><strong>Course: ' . (isset($course) ? htmlspecialchars($course) : '') . '</strong></p>
        <p><strong>Year Level: ' . (isset($yearlevel) ? htmlspecialchars($yearlevel) : '') . '</strong></p>';

        mysqli_stmt_close($stmt_student_info);
        echo '<div class="main">';
        // Fetch subjects
        $sql_subjects = "SELECT s.subjectcode, s.description, s.unit, 
                         CONCAT_WS(' ',
                            IFNULL(s.prerequisite1, ''),
                            IFNULL(s.prerequisite2, ''),
                            IFNULL(s.prerequisite3, '')
                         ) AS prerequisites
                         FROM tblsubject s
                         LEFT JOIN tblgrade g ON s.subjectcode = g.subjectcode AND g.studentnumber = ?
                         LEFT JOIN tblgrade g1 ON s.prerequisite1 = g1.subjectcode AND g1.studentnumber = ?
                         LEFT JOIN tblgrade g2 ON s.prerequisite2 = g2.subjectcode AND g2.studentnumber = ?
                         LEFT JOIN tblgrade g3 ON s.prerequisite3 = g3.subjectcode AND g3.studentnumber = ?
                         WHERE s.course = ? 
                         AND g.studentnumber IS NULL 
                         AND (s.prerequisite1 IS NULL OR g1.studentnumber IS NOT NULL) 
                         AND (s.prerequisite2 IS NULL OR g2.studentnumber IS NOT NULL) 
                         AND (s.prerequisite3 IS NULL OR g3.studentnumber IS NOT NULL)";

        $stmt_subjects = mysqli_prepare($link, $sql_subjects);
        mysqli_stmt_bind_param($stmt_subjects, "sssss", $studentnumber, $studentnumber, $studentnumber, $studentnumber, $course);
        mysqli_stmt_execute($stmt_subjects);
        mysqli_stmt_bind_result($stmt_subjects, $subjectcode, $description, $unit, $prerequisites);

        $row_count = 0;
        echo "<table>";
        echo "<tr>";
        echo "<th>Subject Code</th>";
        echo "<th>Description</th>";
        echo "<th>Unit</th>";
        echo "<th>Pre-requisites</th>";
        echo "</tr>";

        while (mysqli_stmt_fetch($stmt_subjects)) {
            $row_count++;
            echo "<tr>";
            echo "<td>" . htmlspecialchars($subjectcode) . "</td>";
            echo "<td>" . htmlspecialchars($description) . "</td>";
            echo "<td>" . htmlspecialchars($unit) . "</td>";
            echo "<td>" . htmlspecialchars($prerequisites) . "</td>";
            echo "</tr>";
        }

        if ($row_count === 0) {
            echo "<tr><td colspan='4'>No subjects found.</td></tr>";
        }

        echo "</table>";

        mysqli_stmt_close($stmt_subjects);
        echo '</div>';
    }
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

<?php
mysqli_close($link);
?>
