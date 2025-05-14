<?php
$errors = array();
$success = "";
require_once "config.php";
include("session-checker.php");
$Username = $_SESSION['username'];
$query = "SELECT usertype, profile_picture FROM tblaccounts WHERE username = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "s", $Username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $Usertype, $profilePicture);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
sleep(1);
if (isset($_POST['btnsubmit'])) {
    if (!preg_match('/^\d{7}$/', $_POST['txtstudentnum'])) {
        $errors[] = "<font color='red'>STUDENT NUMBER MUST BE EXACTLY 7 DIGITS AND MUST BE NUMERIC</font>";
    } elseif (empty($_POST['txtlname']) || empty($_POST['txtfname']) || empty($_POST['txtpassword']) || empty($_POST['txtmname']) || empty($_POST['cmbcoursetype']) || empty($_POST['cmbyrlevel'])) {
        $errors[] = "<font color='red'>FILL UP ALL THE FORM</font>";
    } else {
        $sql = "SELECT * FROM tblstudent WHERE studentnumber = '{$_POST['txtstudentnum']}'";
        $result = mysqli_query($link, $sql);
        if ($result) {
            if (mysqli_num_rows($result) == 0) {
                $date = date("Y-m-d");
                $time = date("h:i:sa");
                $sql = "INSERT INTO tblstudent (studentnumber, lastname, firstname, middlename, course, yearlevel, sem, createdby, datecreated) VALUES ('{$_POST['txtstudentnum']}', '{$_POST['txtlname']}', '{$_POST['txtfname']}', '{$_POST['txtmname']}', '{$_POST['cmbcoursetype']}', '{$_POST['cmbyrlevel']}', '{$_POST['cmbsem']}', '{$_SESSION['username']}', '$date')";
                $insert_result = mysqli_query($link, $sql);
                $sql = "INSERT INTO tblaccounts (username, password, usertype, userstatus, createdby, datecreated,timecreated) VALUES ('{$_POST['txtstudentnum']}', '{$_POST['txtpassword']}', 'STUDENT', 'ACTIVE','{$_SESSION['username']}', '$date','$time')";
                $insert_result = mysqli_query($link, $sql);
                if ($insert_result) {
                    $date = date("Y-m-d");
                    $time = date("h:i:sa");
                    $action = "Create";
                    $module = "Students Management";
                    $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, id, performedby) VALUES ('$date', '$time', '$action', '$module', '{$_POST['txtstudentnum']}', '{$_SESSION['username']}')";
                    $log_result = mysqli_query($link, $sql);
                    if ($log_result) {
                        $success = "<strong><span style='color:green;'>You have successfully added a new student</span></strong>";
                    } else {
                        $errors[] = "<font color='red'>Error on Insert Log Statement</font>";
                    }
                } else {
                    $errors[] = "<strong><span style='color: red;'>Error on adding new account</span></strong>";
                }
            } else {
                $errors[] = "<strong><span style='color: red;'>Student number is already in use</span></strong>";
            }
        } else {
            $errors[] = "<strong><span style='color: red;'>Error on finding if user exists</span></strong>";
        }
    }
}
?>
<html>
<head>
    <title>Student Page Add New Account ARELLANO UNIVERSITY SUBJECT ADVISING SYSTEM - AUSAS</title>
    <link rel="icon" type="image/png" sizes="32x32" href="./img/logo1.svg">
    <link rel="stylesheet" href="studcreate.css">
</head>
<style>
.header {
    background-color: #333;
    color: #fff;
    padding: 30px 0;
    text-align: center;
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
.profile-picture-container {
    position: absolute;
    top: 0px;
    right: 80px;
}

.profile-picture  {
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
    margin-left: 1090px; 
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
    cursor:pointer;
}
</style>
<header>
    <nav class="topnav" id="mytopnav">
        <?php if ($Usertype === 'ADMINISTRATOR'): ?>
            <a href="index.php">Home</a>
            <a href="accounts_management.php">Accounts</a>
            <a style="background-color: green" href="studentpage.php">Students</a>
            <a href="subject_management.php">Subjects</a>
            <div class ="welcome">
                <div class="logo"></div>
            <h3 style="margin-right:400px" class="brand"><strong>Arellano University Subject Advising System</strong></h3>
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
            <div class ="welcome">
            <div class="reglogo"></div></div>
       <h3 style="margin-right:200px"class="brand"><strong>Arellano University Subject Advising System</strong></h3>
       <div class="profile-picture-container">
    <div class="dropdown">
        <img src="<?= $profilePicture ?>" alt="Profile Picture" class="profile-picture dropbtn" onclick="toggleDropdown()">
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
        <?php else: ?>
            <div class ="welcome">
            <div class="logo"></div></div>
       <h3 style="margin-right:10px"class="brand"><strong>Arellano University Subject Advising System</strong></h3>
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
        <?php endif; ?>
    </nav>
</header>
<br><br>
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
    }
    <?php
    if (!empty($errors)) {
        echo "displayNotification('<b>" . addslashes(implode("<br>", $errors)) . "</b>', 'error');";
    }
    if (!empty($success)) {
        echo "displayNotification('<b>" . addslashes($success) . "</b>', 'success');";
        echo "setTimeout(function() {
            window.location.href = 'studentpage.php';
        }, 3000);"; 
    }
?>
</script>
<div class="createaccform">
    <p>Fill up this form and submit in order to add a new student</p>
    <br>
    <form id="createaccount" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    Student number: <input type="number" name="txtstudentnum" required> <br>
            last-name: <input type="text" name="txtlname" required> <br>
            First-name: <input type="text" name="txtfname" required> <br>
            Middle-name: <input type="text" name="txtmname" required> <br>
            <strong><label for="txtpassword">Password:</label></strong>
<input type="password" id="txtpassword" name="txtpassword" required><br><br>
            <div id="showPasswordContainer">
                    <input type="checkbox" id="showPassword">
                    <label class="toggle-switch" for="showPassword"></label>
                    <label style="color:black;font-weight:bolder;" for="showPassword" id="passwordText">Show Password</label>
                </div><br><br>
            Course:
            <select name="cmbcoursetype" id="cmbcoursetype" required>
    <option value="">--Select Course--</option>
    <option value="BACHELOR OF SCIENCE IN ACCOUNTANCY">Bachelor of Science in Accountancy</option>
    <option value="BACHELOR OF SCIENCE IN FINANCIAL MANAGEMENT">Bachelor of Science in Financial Management</option>
    <option value="BACHELOR OF SCIENCE IN MARKETING MANAGEMENT">Bachelor of Science in Marketing Management</option>
    <option value="BACHELOR OF SCIENCE IN HUMAN RESOURCE MANAGEMENT">Bachelor of Science in Human Resource Management</option>
    <option value="BACHELOR OF SCIENCE IN OPERATIONS MANAGEMENT">Bachelor of Science in Operations Management</option>
    <option value="BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY">Bachelor of Science in Information Technology</option>
    <option value="BACHELOR OF SCIENCE IN COMPUTER SCIENCE">Bachelor of Science in Computer Science</option>
    <option value="BACHELOR OF SCIENCE IN HOSPITALITY MANAGEMENT">Bachelor of Science in Hospitality Management</option>
    <option value="BACHELOR OF SCIENCE IN TOURISM MANAGEMENT">Bachelor of Science in Tourism Management</option>
    <option value="BACHELOR OF SCIENCE IN MEDICAL TECHNOLOGY">Bachelor of Science in Medical Technology</option>
    <option value="BACHELOR OF SCIENCE IN PHARMACY">Bachelor of Science in Pharmacy</option>
    <option value="BACHELOR OF ARTS IN COMMUNICATION">Bachelor of Arts in Communication</option>
    <option value="BACHELOR OF ARTS IN ENGLISH LANGUAGE STUDIES">Bachelor of Arts in English Language Studies</option>
    <option value="BACHELOR OF ARTS IN PSYCHOLOGY">Bachelor of Arts in Psychology</option>
    <option value="BACHELOR OF SCIENCE IN CRIMINOLOGY">Bachelor of Science in Criminology</option>
    <option value="BACHELOR OF LAWS">Bachelor of Laws</option>
    <option value="BACHELOR OF ELEMENTARY EDUCATION">Bachelor of Elementary Education</option>
    <option value="BACHELOR OF SECONDARY EDUCATION - ENGLISH">Bachelor of Secondary Education - English</option>
    <option value="BACHELOR OF SECONDARY EDUCATION - MATHEMATICS">Bachelor of Secondary Education - Mathematics</option>
    <option value="BACHELOR OF SECONDARY EDUCATION - SCIENCE">Bachelor of Secondary Education - Science</option>
    <option value="BACHELOR OF SECONDARY EDUCATION - SOCIAL STUDIES">Bachelor of Secondary Education - Social Studies</option>
    <option value="BACHELOR OF SCIENCE IN PHYSICAL THERAPY">Bachelor of Science in Physical Therapy</option>
    <option value="BACHELOR OF SCIENCE IN NURSING">Bachelor of Science in Nursing</option>
    <option value="BACHELOR OF SCIENCE IN RADIOLOGIC TECHNOLOGY">Bachelor of Science in Radiologic Technology</option>
    <option value="BACHELOR OF SCIENCE MEDICAL TECHNOLOGY/ MEDICAL LABORATORY SCIENCE">Bachelor of Science Medical Technology/ Medical Laboratory Science</option>
    <option value="BACHELOR OF SCIENCE IN MIDWIFERY">Bachelor of Science in Midwifery</option>
    <option value="BACHELOR OF SCIENCE IN ENVIRONMENTAL SCIENCE">Bachelor of Science in Environmental Science</option>
    <option value="BACHELOR OF ARTS IN ENGLISH">Bachelor of Arts in English</option>
    <option value="BACHELOR OF SCIENCE IN POLITICAL SCIENCE">Bachelor of Science in Political Science</option>
    <option value="BACHELOR OF SCIENCE IN MATHEMATICS">Bachelor of Science in Mathematics</option>
    <option value="BACHELOR OF LIBRARY AND INFORMATION SCIENCE ">Bachelor of Library and Information Science</option>
</select><br><br>
            Year Level:<select name="cmbyrlevel" id="cmbyrlevel" required>
                <option value="">--Select Year Level--</option>
    <option value="FIRST">FIRST</option>
    <option value="SECOND">SECOND</option>
    <option value="THIRD">THIRD</option>
    <option value="FOURTH">FOURTH</option>
            </select>
           <br><br>
            <input type="submit" name="btnsubmit" class="btnsubmit" value="Add New student">
            <a href="studentpage.php">Cancel</a>
        </form>
</div>
<script>
    document.querySelector('.btnsubmit').addEventListener('click', function(event) {
        var btn = event.target;
        var form = document.getElementById('createaccount');
        var phpErrors = form.querySelector('.php-errors');
        if (form.checkValidity()) {
            btn.value = "please wait Verifying...";
            btn.style.pointerEvents = 'none';
            btn.style.opacity = '0.7';
            
            setTimeout(function() {
                btn.value = "Add New student";
                btn.style.pointerEvents = 'auto';
                btn.style.opacity = '1';
                phpErrors.innerHTML = "";
                form.submit();
            }, 5000);
        } else {
            event.preventDefault();
            phpErrors.innerHTML = "";
            var errorMessage = document.createElement('span');
            errorMessage.style.color = 'red';
            errorMessage.textContent = "Please fill up the form completely.";
            phpErrors.appendChild(errorMessage);
        }
    });
    document.getElementById("showPassword").addEventListener("change", function() {
            var passwordField = document.getElementById("txtpassword");
            var passwordText = document.getElementById("passwordText");
            if (this.checked) {
                passwordField.type = "text";
                passwordText.textContent = "Hide Password";
            } else {
                passwordField.type = "password";
                passwordText.textContent = "Show Password";
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
            var passwordField = document.getElementById("txtpassword");
            passwordField.type = "password";
            var passwordText = document.getElementById("passwordText");
            passwordText.textContent = "Show Password";
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
