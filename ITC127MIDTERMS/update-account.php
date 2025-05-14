<?php
$errors = array();
$success = "";
$account = array();
require_once "config.php";
include "session-checker.php";
sleep(1);
if (isset($_POST['btnsubmit']) && isset($_GET['username'])) {
    $sql = "UPDATE tblaccounts SET password = ?, usertype = ?, userstatus = ? WHERE username = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssss", $_POST['txtpassword'], $_POST['cmbtype'], $_POST['rbstatus'], $_GET['username']);
        if (mysqli_stmt_execute($stmt)) {
            $sql_insert = "INSERT INTO tbllogs (datelog, timelog, action, module, id, performedby) VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt_insert = mysqli_prepare($link, $sql_insert)) {
                $date = date("Y-m-d");
                $time = date("h:i:sa");
                $module = "Accounts Management";
                $action = "Update";
                $id = $_GET['username'];
                $performedby = isset($_SESSION['username']) ? $_SESSION['username'] : '';
                mysqli_stmt_bind_param($stmt_insert, "ssssss", $date, $time, $action, $module, $id, $performedby);
                if (mysqli_stmt_execute($stmt_insert)) {
                    $success = "<strong><span style='color:green;'>You have successfully updated an account</span></strong>";
                } else {
                    $errors[] = "<font color='red'>Error on Inserting Logs</font>";
                }
            }
        } else {
            $errors[] = "<font color='red'>Error on updating accounts</font>";
        }
    }
} else {
    if (isset($_GET['username']) && !empty(trim($_GET['username']))) {
        $sql_select = "SELECT * FROM tblaccounts WHERE username = ?";
        if ($stmt_select = mysqli_prepare($link, $sql_select)) {
            mysqli_stmt_bind_param($stmt_select, "s", $_GET['username']);
            if (mysqli_stmt_execute($stmt_select)) {
                $result = mysqli_stmt_get_result($stmt_select);
                $account = mysqli_fetch_array($result, MYSQLI_ASSOC);
            } else {
                $errors[] = "<font color='red'>Error on loading current account data</font>";
            }
        }
    } else {
        $errors[] = "<font color='red'>account is not found</font>";
    }
    $userstatus = isset($account['userstatus']) ? $account['userstatus'] : '';
}
$Username = $_SESSION['username'];
$query = "SELECT usertype, profile_picture FROM tblaccounts WHERE username = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "s", $Username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $Usertype, $profilePicture);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Account - Arellano University Subject Advising System</title>
    <link rel="icon" type="image/png" sizes="32x32" href="./img/logo1.svg">
    <link rel="stylesheet" href="update.css">
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
            <a style="background-color: green" href="accounts_management.php">Accounts</a>
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
<div class="container-form">
    <h2 class="form-title">Update Account</h2>
    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST" id="formupdate">
        <div class="formupdate">
        <strong>Username: <span><strong> <?php echo isset($account['username']) ? $account['username'] : ''; ?></strong></span><br><br></strong>
           <strong>  <label for="txtpassword">Password:</label></strong>
            <input type="password" id="txtpassword" name="txtpassword" value="<?php echo isset($account['password']) ? $account['password'] : ''; ?>" required></strong>
            <div id="showPasswordContainer">
                    <input type="checkbox" id="showPassword">
                    <label class="toggle-switch" for="showPassword"></label>
                    <label style="color:black;font-weight:bolder;" for="showPassword" id="passwordText">Show Password</label>
                </div><br>
        <div class="formupdate">
        <strong>Current User Type: </strong><span><strong> <?php echo isset($account['usertype']) ? $account['usertype'] : ''; ?></strong></span><br><br>
        <strong> <label for="cmbtype">Change user type to:</label></strong>
            <select name="cmbtype" id="cmbtype" required>
                <option value="">--Select User Type--</option>
                <option value="ADMINISTRATOR">Administrator</option>
                <option value="REGISTRAR">Registrar</option>
                <option value="STAFF">Student</option>
            </select>
        </div>
        <?php
        $userstatus = isset($account['userstatus']) ? $account['userstatus'] : '';
        if ($userstatus == 'ACTIVE') {
        ?>
        <div class="formupdate">
            <input type="radio" name="rbstatus" value="ACTIVE" checked>Active<br>
            <input type="radio" name="rbstatus" value="INACTIVE">Inactive<br>
        </div>
        <?php
        } else {
        ?>
        <div class="formupdate">
            <input type="radio" name="rbstatus" value="ACTIVE">Active<br>
            <input type="radio" name="rbstatus" value="INACTIVE" checked>Inactive<br>
        </div>
        <?php
        }        
        ?>
        <br>
        <div class="formupdate">
            <input type="submit" name="btnsubmit" value="Update" class="btn-submit">
            <a href="accounts_management.php" class="btn-cancel">Cancel</a>
        </div>
        <div class="php-errors"></div>
    </form>
</div>
    </div>
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
        document.querySelector('.btn-submit').addEventListener('click', function(event) {
            var btn = event.target;
            var form = document.getElementById('formupdate');
            var phpErrors = form.querySelector('.php-errors');
            if (form.checkValidity()) {
                btn.value = "please wait for updating...";
                btn.style.pointerEvents = 'none';
                btn.style.opacity = '0.7';
                
                setTimeout(function() {
                    btn.value = "Update";
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
                <li><a style = "color:black"href="#">Terms of Service</a></li>
                <li><a style = "color:black"href="#">Privacy Policy</a></li>
            </ul>
        </footer>
</html>
