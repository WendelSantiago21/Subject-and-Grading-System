<?php 
$success = "";
$errors = array();
require_once "config.php";
session_start();

// Check if the user is logged in
if(isset($_SESSION['username'])) {
    $encodedby = $_SESSION['username'];
} else {
    header("Location:indexlogin.php");
    exit; 
}
$link = mysqli_connect("localhost", "root", "", "itc127-2b-2024");
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
if(isset($_GET['studentnumber'])) {
    $studentnumber = $_GET['studentnumber'];
}
$Username = $_SESSION['username'];
$query = "SELECT usertype, profile_picture FROM tblaccounts WHERE username = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "s", $Username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $Usertype, $profilePicture);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['subjectcode'], $_POST['grade'], $_POST['studentnumber'])) {
        $selectedSubject = $_POST['subjectcode'];
        $newGrade = $_POST['grade'];
        $studentnumber = $_POST['studentnumber'];
        $sql_update_grade = "UPDATE tblgrade SET grade = ? WHERE studentnumber = ? AND subjectcode = ?";
        if ($stmt_update_grade = mysqli_prepare($link, $sql_update_grade)) {
            mysqli_stmt_bind_param($stmt_update_grade, "sss", $newGrade, $studentnumber, $selectedSubject);
            if(mysqli_stmt_execute($stmt_update_grade)) {
                $action = "Update";
                $module = "Grades Management";
                $dateLog = date('Y-m-d');
                $timeLog = date('H:i:sa');
                $ID = $studentnumber;
                $sql_insert_log = "INSERT INTO tbllogs (datelog, timeLog, id, performedby, action, module) VALUES (?, ?, ?, ?, ?, ?)";
                if($stmt_log = mysqli_prepare($link, $sql_insert_log)) {
                    mysqli_stmt_bind_param($stmt_log, "ssssss", $dateLog, $timeLog, $ID, $encodedby, $action, $module);
                    mysqli_stmt_execute($stmt_log);
                    mysqli_stmt_close($stmt_log);
                }
                $success = "<strong><span style='color: green;'>You have been successfully updated a grade.</span></strong>";
            } else {
                $errors[]  = "<strong><span style='color: red;'>Error updating grade.</span></strong>";
            }
            mysqli_stmt_close($stmt_update_grade);
        } else {
            $errors[]  = "<strong><span style='color: red;'>Error updating grade.</span></strong>";
        }
    }
}

if(isset($_GET['studentnumber'], $_GET['subjectcode'])) {
    $studentnumber = $_GET['studentnumber'];
    $subjectcode = $_GET['subjectcode'];

    // Fetch subject description based on subject code
    $sql_select_subject = "SELECT description FROM tblsubject WHERE subjectcode = ?";
    if ($stmt_subject = mysqli_prepare($link, $sql_select_subject)) {
        mysqli_stmt_bind_param($stmt_subject, "s", $subjectcode);
        mysqli_stmt_execute($stmt_subject);
        mysqli_stmt_bind_result($stmt_subject, $description);
        mysqli_stmt_fetch($stmt_subject);
        mysqli_stmt_close($stmt_subject);
    }

    // Fetch grades based on student number and subject code
    $sql_select_grades = "SELECT grade FROM tblgrade WHERE studentnumber = ? AND subjectcode = ?";
    if ($stmt_grades = mysqli_prepare($link, $sql_select_grades)) {
        mysqli_stmt_bind_param($stmt_grades, "ss", $studentnumber, $subjectcode);
        mysqli_stmt_execute($stmt_grades);
        mysqli_stmt_bind_result($stmt_grades, $grade);
        mysqli_stmt_fetch($stmt_grades);
        mysqli_stmt_close($stmt_grades);
    }
}

$sql_select_student = "SELECT lastname, firstname, middlename, yearlevel, course FROM tblstudent WHERE studentnumber = ?";
if ($stmt_student = mysqli_prepare($link, $sql_select_student)) {
    mysqli_stmt_bind_param($stmt_student, "s", $studentnumber);
    mysqli_stmt_execute($stmt_student);
    mysqli_stmt_bind_result($stmt_student, $lastname, $firstname, $middlename, $year, $course);
    mysqli_stmt_fetch($stmt_student);
    mysqli_stmt_close($stmt_student);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Grades - Subject Advising System</title>
    <link rel="icon" type="image/png" sizes="32x32" href="./img/logo1.svg">
    <link rel="stylesheet" href="studcreate.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
</head>
<style>
    body{
        margin-bottom:250px;
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
    margin-right: 410px;
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
.formaddgrade {
    max-width: 400px;
    margin: 50px auto;
    padding: 30px;
    background: linear-gradient(to right, #7e57c2, #26c6da);
    border-radius: 20px;
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.4);
    position: relative;
    overflow: hidden;
    animation: pulse 2s infinite alternate;
   max-height: 90wv;
    color: #000000;
}

@keyframes slideIn {
    from {
      opacity: 0;
      transform: translateY(-50px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .formaddgrade {
    animation: slideIn 0.5s ease forwards;
  }

  @keyframes labelFadeIn {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .label {
    animation: labelFadeIn 0.3s ease forwards;
  }


.formaddgrade select, .formaddgrade input[type="submit"], .formaddgrade a {
    width: 100%;
    padding: 15px;
    margin-bottom: 20px;
    border: 2px solid #ccc;
    border-radius: 8px;
    box-sizing: border-box;
    font-size: 16px;
    transition: all 0.3s ease;
}

.formaddgrade select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url('data:image/svg+xml;utf8,<svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M19 9l-7 7-7-7"></path></svg>');
    background-repeat: no-repeat;
    background-position: right 15px center;
    padding-right: 40px;
    background-color: #fff;
}

.formaddgrade input[type="submit"], .formaddgrade a {
    background-color: #007bff;
    color: #fff;
    text-align: center;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-weight: bold;
}

.formaddgrade input[type="submit"]:hover, .formaddgrade a:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}
a {
    text-decoration: none;
    color: #000000;
    margin-right: 10px;
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
.footer {
    text-align: center;
    font-size: 1rem;
    font-weight: bold;
    background-color: #45A29E;
    padding: 10px 0;
    position: fixed;
    width: 100%;
    bottom: 0;
    left: 0;
    z-index: 9999;
}


.footer ul {
    list-style: none;
    padding: 0;
}

.footer ul li {
    display: inline-block;
    margin: 0 10px;
}
.social-media {
    text-align: center;
    margin-top: 20px;
    background-color: #45A29E;
}

.social-media a {
    display: inline-block;
    margin: 0 10px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    overflow: hidden;
}

.social-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
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
            <a href="grades-management.php">grades</a>
            <div class ="welcome">
                <div class="logo"></div>
            <h3 style="margin-right:380px" class="brand"><strong>Arellano University Subject Advising System</strong></h3>
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
        <img src="<?= $profilePicture ?>" alt="Profile Picture" class="profile-picture dropbtn" onclick="toggleDropdown()"><span class="hamburger-icon">&#9776;</span>
        <div class="dropdown-content" id="dropdownContent">
             <a href="#"><?php echo $_SESSION['usertype']; ?></a>
            <a href="profile.php">Edit Profile</a>
            <a href="indexlogout.php">Logout</a>
        </div>
    </div>
    <div>
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
        }, 4000);
    }
    <?php
    if (!empty($errors)) {
        echo "displayNotification('<b>" . addslashes(implode("<br>", $errors)) . "</b>', 'error');";
    }
    if (!empty($success)) {
        echo "displayNotification('<b>" . addslashes($success) . "</b>', 'success');";
        echo "setTimeout(function() {
            window.location.href = 'grades-management.php';
        }, 1000);"; 
    }
?>
</script>
    <?php
    // Fetch student information from the database
    $sql_select_student = "SELECT lastname, firstname, middlename, yearlevel, course FROM tblstudent WHERE studentnumber = ?";
    if ($stmt_student = mysqli_prepare($link, $sql_select_student)) {
        mysqli_stmt_bind_param($stmt_student, "s", $studentnumber);
        mysqli_stmt_execute($stmt_student);
        mysqli_stmt_bind_result($stmt_student, $lastname, $firstname, $middlename, $year, $course);
        mysqli_stmt_fetch($stmt_student);
        mysqli_stmt_close($stmt_student);
    }
    ?>    
       <div class="formaddgrade">
        <h2>Fill Up this form to Update Grades</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" id="updategrade">
            <p><strong>Name: <?php echo $lastname . ' ' . $firstname . ' ' . $middlename; ?></strong></p> 
            <p><strong>Student Number: <?php echo $studentnumber; ?></strong></p> 
            <p><strong>Year: <?php echo $year; ?></strong></p> 
            <p><strong>Course: <?php echo $course; ?></strong></p> 
            <?php if(isset($subjectcode)): ?>
                <p><strong>Subject Code: <?php echo $subjectcode; ?></strong></p> 
                <p><strong>Description: <?php echo $description; ?></strong></p> 
                <p><strong>Current Grade: <?php echo isset($grade) ? $grade : ''; ?></strong></p> 
            <?php endif; ?>
            <input type="hidden" name="subjectcode" value="<?php echo $subjectcode; ?>">
            <input type="hidden" name="studentnumber" value="<?php echo $studentnumber; ?>">
            <label for="grade"><strong>Grade:</strong></label>
            <select id="grade" name="grade" required> 
                <option value="" disabled selected>Select Grade</option>
                <option value="1.0">1.0</option>
                <option value="1.25">1.25</option>
                <option value="1.50">1.50</option>
                <option value="1.75">1.75</option>
                <option value="2.0">2.0</option>
                <option value="2.25">2.25</option>
                <option value="2.50">2.50</option>
                <option value="2.75">2.75</option>
                <option value="3.0">3.0</option>
            </select><br><br>
            <input type="submit" id="btnsubmit" name="btnsubmit" value="Save">
            <a href="grades-management.php">Cancel</a>
        </form>
    </div>
<script>
        $(document).ready(function(){
            $('#subjectcode').change(function(){
                var selectedSubject = $(this).val();
                var description = $('option:selected', this).data('description');
                $('#description').text(description);
            });
            $('#subjectcode').trigger('change');
        });
        document.getElementById('btnsubmit').addEventListener('click', function(event) {
        var btn = event.target;
        var form = document.getElementById('updategrade');
        var phpErrors = form.querySelector('.php-errors');
        if (form.checkValidity()) {
            btn.value = "Saving please wait...";
            btn.style.pointerEvents = 'none';
            btn.style.opacity = '0.7';

            setTimeout(function() {
                btn.value = "Save";
                btn.style.pointerEvents = 'auto';
                btn.style.opacity = '1';
                phpErrors.innerHTML = "";
                form.submit();
            }, 5000);
        } else {
            event.preventDefault();
            phpErrors.innerHTML = "Please fill up the form completely.";
        }
    });
    </script>
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
