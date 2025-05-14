<?php
$errors = array(); // Initialize an array to store errors
$success = ""; // Initialize a variable to store success message
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
    if (empty($_POST['txtusername']) || empty($_POST['txtpassword']) || empty($_POST['cmbaccountType'])) {
        $errors[] = "Please enter both username and password.";
    } else {
        $sql = "SELECT * FROM tblaccounts WHERE username = '{$_POST['txtusername']}'";
        $result = mysqli_query($link, $sql);
        if ($result) {
            if (mysqli_num_rows($result) == 0) {
                $status = "ACTIVE";
                $date = date("Y-m-d");
                $time = date("h:i:sa");
                $sql = "INSERT INTO tblaccounts (username, password, usertype, userstatus, createdby, datecreated, timecreated) VALUES ('{$_POST['txtusername']}', '{$_POST['txtpassword']}', '{$_POST['cmbaccountType']}', '$status', '{$_SESSION['username']}', '$date', '$time')";
                $insert_result = mysqli_query($link, $sql);
                if ($insert_result) {
                    $date = date("Y-m-d");
                    $time = date("h:i:sa");
                    $action = "Create";
                    $module = "Accounts Management";
                    $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, id, performedby) VALUES ('$date', '$time', '$action', '$module', '{$_POST['txtusername']}', '{$_SESSION['username']}')";
                    $log_result = mysqli_query($link, $sql);
                    if ($log_result) {
                        $success = "<strong><span style='color:green;'>You have successfully added a new account</span></strong>";
                    } else {
                        $errors[] = "<font color='red'>Error on Insert Log Statement</font>";
                    }
                } else {
                    $errors[] = "<strong><span style='color: red;'>Error on adding new account</span></strong>";
                }
            } else {
                $errors[] = "<strong><span style='color: red;'>Username is already in use</span></strong>";
            }
        } else {
            $errors[] = "<strong><span style='color: red;'>Error on finding if user exists</span></strong>";
        }
    }
}
?>
<html>
<head>
    <title>Add New Account ARELLANO UNIVERSITY SUBJECT ADVISING SYSTEM - AUSAS</title>
    <link rel="icon" type="image/png" sizes="32x32" href="./img/logo1.svg">
    <link rel="stylesheet" href="createacc.css">
</head>
<style>
        header {
            background-color: #1F2833;
            color: #ffffff;
            padding: 10px;
            text-align: center;
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
            <a  href="accounts_management.php">Accounts</a>
            <a href="studentpage.php">Students</a>
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
        <?php elseif ($Usertype === 'REGISTRAR'): ?>
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
        }, 4000);
    }

    <?php
    if (!empty($errors)) {
        echo "displayNotification('<b>" . addslashes(implode("<br>", $errors)) . "</b>', 'error');";
    }
    if (!empty($success)) {
        echo "displayNotification('<b>" . addslashes($success) . "</b>', 'success');";
        echo "setTimeout(function() {
            window.location.href = 'accounts_management.php';
        }, 1000);"; 
    }
    ?>
</script>
<div class="createaccform">
    <p>Fill up this form and submit in order to add a new user</p>
    <br>
    <form id="createaccount" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <strong>  Username: <input type="text" name="txtusername" required> <br></strong>
    <strong><label for="txtpassword">Password:</label></strong>
<input type="password" id="txtpassword" name="txtpassword" required><br><br>
<div id="showPasswordContainer">
                    <input type="checkbox" id="showPassword">
                    <label class="toggle-switch" for="showPassword"></label>
                    <label style="color:black;font-weight:bolder;" for="showPassword" id="passwordText">Show Password</label>
                    <br>
<strong>Account type:</strong>
        <select name="cmbaccountType" id="cmbaccountType" required>
          <option value="">--Select User Type--</option>
                <option value="ADMINISTRATOR">Administrator</option>
                <option value="REGISTRAR">Registrar</option>
                <option value="STAFF">Staff</option>
        <input type="submit" name="btnsubmit" class="btnsubmit" value="Create New Account"><br><br>
        <a href="accounts_management.php">Cancel</a>
    </form>
</div>
</div>
<script>
    document.querySelector('.btnsubmit').addEventListener('click', function(event) {
        var btn = event.target;
        var form = document.getElementById('createaccount');
        var phpErrors = form.querySelector('.php-errors');
        if (form.checkValidity()) {
            btn.value = "Creating please wait a moment...";
            btn.style.pointerEvents = 'none';
            btn.style.opacity = '0.7';
            
            setTimeout(function() {
                btn.value = "Add New Account";
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
