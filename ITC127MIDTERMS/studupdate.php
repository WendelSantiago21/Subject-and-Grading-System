<?php
$errors = array();
$success = "";
$account = array();
require_once "config.php";
include "session-checker.php";
$Username = $_SESSION['username'];
$query = "SELECT usertype, profile_picture FROM tblaccounts WHERE username = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "s", $Username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $Usertype, $profilePicture);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
sleep(1);

if(isset($_POST['btnsubmit']) && isset($_GET['studentnumber'])) {
    $lastname = $_POST['txtlname'];
    $firstname = $_POST['txtfname'];
    $middlename = $_POST['txtmname'];
    $yearlevel = $_POST['cmbyrlevel'];
    $course = $_POST['cmbcoursetype'];
    $studentnumber = $_GET['studentnumber'];
    $sql = "UPDATE tblstudent SET lastname=?, firstname=?, middlename=?, yearlevel=?, course=? WHERE studentnumber=?";
    if($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssss", $lastname, $firstname, $middlename, $yearlevel, $course, $studentnumber);    
        if(mysqli_stmt_execute($stmt)) {
            $date = date("Y-m-d");
            $time = date("h:i:sa");
            $action = "Update";
            $module = "Students Management";
            $performedby = isset($_SESSION['username']) ? $_SESSION['username'] : '';
            $sql_insert = "INSERT INTO tbllogs (datelog, timelog, action, module, id, performedby) VALUES (?, ?, ?, ?, ?, ?)";
            if($stmt_insert = mysqli_prepare($link, $sql_insert)) {
                mysqli_stmt_bind_param($stmt_insert, "ssssss", $date, $time, $action, $module, $studentnumber, $performedby);
                if(mysqli_stmt_execute($stmt_insert)) {
                    $success = "<strong><span style='color:green;'>You have successfully updated the student</span></strong>";
                } else {
                    $errors[] = "<font color='red'>Error on inserting logs</font>";
                }
            } else {
                $errors[] = "<font color='red'>Error on preparing insert query</font>";
            }
        } else {
            $errors[] = "<font color='red'>Error updating the account</font>";
        }
    } else {
        $errors[] = "<font color='red'>Error preparing the update query</font>";
    }
}

if(isset($_GET['studentnumber']) && !empty(trim($_GET['studentnumber']))) {
    $sql_select = "SELECT * FROM tblstudent WHERE studentnumber = ?";
    if($stmt_select = mysqli_prepare($link, $sql_select)) {
        mysqli_stmt_bind_param($stmt_select, "s", $_GET['studentnumber']);
        if(mysqli_stmt_execute($stmt_select)) {
            $result = mysqli_stmt_get_result($stmt_select);
            $account = mysqli_fetch_array($result, MYSQLI_ASSOC);
        } else {
            $errors[] = "<font color='red'>Error fetching current account data</font>";
        }
    }
} else {
    $errors[] = "<font color='red'>Account not found</font>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student - Arellano University Subject Advising System</title>
    <link rel="icon" type="image/png" sizes="32x32" href="./img/logo1.svg">
    <link rel="stylesheet" href="update.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: #f2f2f2;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
        }
        #cmbyrlevel{
    width: 100%;
    padding: 7px;
    border: none;
    border-radius: 5px;
    background-color: #e9e9e9;
    color: #000000;
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 10px;
    appearance: none; 
    -webkit-appearance: none; 
    -moz-appearance: none;
  }
  #cmbyrlevel:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}
#cmbyrlevel::-ms-expand {
    display: none;
}

#cmbyrlevel:after {
    content: '\25BC'; 
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    color: #666;
    pointer-events: none; /
}
#cmbyrlevel:hover,
#cmbyrlevel:focus {
    background-color: #e0e0e0;
}
#cmbyrlevel option {
    padding: 10px;
    background-color: #f7f7f7;
    color: #333;
}

#cmbyrlevel option:hover {
    background-color: #e0e0e0;
}
        #cmbcoursetype {
    width: 100%;
    padding: 7px;
    border: none;
    border-radius: 5px;
    background-color: #e9e9e9;
    color: #000000;
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 10px;
    appearance: none; 
    -webkit-appearance: none; 
    -moz-appearance: none;
  }
  #cmbcoursetype:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}
#cmbcoursetype::-ms-expand {
    display: none;
}

#cmbcoursetype::after {
    content: '\25BC'; 
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    color: #666;
    pointer-events: none; /
}
#cmbcoursetype:hover,
#cmbcoursetype:focus {
    background-color: #e0e0e0;
}
#cmbcoursetype option {
    padding: 10px;
    background-color: #f7f7f7;
    color: #333;
}

#cmbcoursetype option:hover {
    background-color: #e0e0e0;
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
</head>
<header>
    <nav class="topnav" id="mytopnav">
        <?php if ($Usertype === 'ADMINISTRATOR'): ?>
            <a href="index.php">Home</a>
            <a href="accounts_management.php">Accounts</a>
            <a  href="studentpage.php">Students</a>
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
    <h2 class="form-title">fill up this form to Update Student</h2>
    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST" id="formupdate">
        <div class="formupdate">
        <div class="php-errors">
                <?php
                if (!empty($login_message)) {
                    echo $login_message;
                }
                ?>
            </div>
          Student number: <input type="number" name="txtstudentnum" value="<?php echo isset($account['studentnumber']) ? $account['studentnumber'] : ''; ?>" readonly><br>
          Lastname: <input type="text" name="txtlname" value="<?php echo isset($account['lastname']) ? $account['lastname'] : ''; ?>" required>
Firstname: <input type="text" name="txtfname" value="<?php echo isset($account['firstname']) ? $account['firstname'] : ''; ?>" required>
Middlename: <input type="text" name="txtmname" value="<?php echo isset($account['middlename']) ? $account['middlename'] : ''; ?>" required>
          Current Course Type: <span><strong><?php echo isset($account['course']) ? $account['course'] : ''; ?></strong></span><br><br>
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
Current Year Level: <span><strong> <?php echo isset($account['yearlevel']) ? $account['yearlevel'] : ''; ?></strong></span><br><br>
<select name="cmbyrlevel" id="cmbyrlevel" required>
                <option value="">--Select Year Level--</option>
    <option value="FIRST">FIRST</option>
    <option value="SECOND">SECOND</option>
    <option value="THIRD">THIRD</option>
    <option value="FOURTH">FOURTH</option>
    </select><br><br>
        <div class="formupdate">
            <input type="submit" name="btnsubmit" value="Update" class="btn-submit">
            <a href="studentpage.php" class="btn-cancel">Cancel</a>
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
