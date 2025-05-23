<?php
$success = "";
$error=array();
require_once "config.php";
session_start();
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
$Username = $_SESSION['username'];
$query = "SELECT usertype, profile_picture FROM tblaccounts WHERE username = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "s", $Username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $Usertype, $profilePicture);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if(isset($_GET['studentnumber'])) {
    $studentnumber = $_GET['studentnumber'];

    $sql_student_info = "SELECT studentnumber, lastname, firstname, middlename, course, yearlevel FROM tblstudent WHERE studentnumber = ?";
    if($stmt = mysqli_prepare($link, $sql_student_info)) {
        mysqli_stmt_bind_param($stmt, "s", $studentnumber);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $studentnumber, $lastname, $firstname, $middlename, $course, $yearlevel);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
}
if(isset($course)) {
// Modify the SQL query to select subjects based on course
$sql_subjects = "SELECT subjectcode, description FROM tblsubject WHERE course = ?";
if($stmt = mysqli_prepare($link, $sql_subjects)) {
    mysqli_stmt_bind_param($stmt, "s", $course);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $subjectcode, $description);
    $options = "";
    while(mysqli_stmt_fetch($stmt)) {
        // Add each option to the dropdown menu
        $options .= "<option value='$subjectcode'>$subjectcode</option>";
    }        
    mysqli_stmt_close($stmt);
}
}
if(isset($_GET['btnsubmit'])) {
    // Retrieve form data
    $studentnumber = $_GET['studentnumber'];
    $subjectcode = $_GET['subjectcode'];
    $grade = $_GET['grade'];
    $sql_check_grade = "SELECT COUNT(*) FROM tblgrade WHERE studentnumber = ? AND subjectcode = ?";
    if($stmt_check = mysqli_prepare($link, $sql_check_grade)) {
        mysqli_stmt_bind_param($stmt_check, "ss", $studentnumber, $subjectcode);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_bind_result($stmt_check, $grade_count);
        mysqli_stmt_fetch($stmt_check);
        mysqli_stmt_close($stmt_check);

        if($grade_count > 0) {
            $errors[]  = "<strong><span style='color: red;'>Grade are already exists for this subject and student</span></strong>";
        } else {
            $dateencoded = date('Y-m-d H:i:s', strtotime('now'));
            $sql_insert_grade = "INSERT INTO tblgrade (studentnumber, subjectcode, grade, encodedby, dateencoded) VALUES (?, ?, ?, ?, ?)";
            if($stmt = mysqli_prepare($link, $sql_insert_grade)) {
                mysqli_stmt_bind_param($stmt, "sssss", $studentnumber, $subjectcode, $grade, $encodedby, $dateencoded);
                if(mysqli_stmt_execute($stmt)) {
                    $success= "<strong><span style='color: green;'>You have successfully added a grade.</span></strong>";
                    $action = "Add";
                    $module = "Grades Management";
                    $tblstudentnumber = $_GET['studentnumber'];
                    $ID = $tblstudentnumber;
                    $dateLog = date('Y-m-d', strtotime('now'));
                    $timeLog = date('H:i:sa', strtotime('now'));
                    $sql_insert_log = "INSERT INTO tbllogs (datelog, timeLog, id, performedby, action, module) VALUES (?, ?, ?, ?, ?, ?)";
                    if($stmt_log = mysqli_prepare($link, $sql_insert_log)) {
                        mysqli_stmt_bind_param($stmt_log, "ssssss", $dateLog, $timeLog, $ID, $encodedby, $action, $module);
                        mysqli_stmt_execute($stmt_log);
                        mysqli_stmt_close($stmt_log);
                    }
                } else {
                    $errors[] = "<strong><span style='color: red;'>Error adding grade.</span></strong>";
                }
                mysqli_stmt_close($stmt);
            }
        }
    }
}
mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Grades - Subject Advising System</title>
    <link rel="icon" type="image/png" sizes="32x32" href="./img/logo1.svg">
    <link rel="stylesheet" href="studcreate.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
</head>
<style>
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
            <a  href="grades-management.php">grades</a>
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
            <a style="background-color: green" href="grades-management.php">grades</a>
            <div class ="welcome">
            <div class="reglogo"></div></div>
       <h3 style="margin-right:300px"class="brand"><strong>Arellano University Subject Advising System</strong></h3>
       <div class="profile-picture-container">
    <div class="dropdown">
    <img src="<?= $profilePicture ?>" alt="Profile Picture" class="profile-picture dropbtn" onclick="toggleDropdown()"><span class="hamburger-icon">&#9776;</span>
        <div class="dropdown-content" id="dropdownContent">
             <a href="#"><?php echo $_SESSION['usertype']; ?></a>
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
<div class="formaddgrade">
    <h2>Fill Up this form to Add Grades</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET" id="addgrade">
    <?php if(isset($studentnumber)) : ?>
    <div>
        <h2>Student Information</h2>
        <p><strong>Student Number: <?php echo $studentnumber; ?></p></strong>
        <p><strong>Name: <?php echo $lastname . ' ' . $firstname . ' ' . $middlename; ?></p></strong>
        <p><strong>Course: <?php echo $course; ?></p></strong>
        <p><strong>Year Level: <?php echo $yearlevel; ?></p></strong>
        <input type="hidden" name="studentnumber" value="<?php echo $studentnumber; ?>"> 
        <label for="subjectcode"><strong>Subject Code:</strong></label>
                    <select id="subjectcode" name="subjectcode" required>
                        <option value="">Select Subject</option>
                        <?php echo $options; ?>
                    </select><br><br>
                    <label><strong>Description:</strong></label> <span id="description"></span>
                    <br><br>
                </div>
            <?php endif; ?>

        <label for="grade"><strong>Grade:</strong></label>
        <select id="grade" name="grade" required>
        <strong> <option value="" disabled selected>Select Grade</option></strong>
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
        <input type="submit" id="btnsubmit"name="btnsubmit" value="Save">
        <a href="grades-management.php">Cancel</a>
    </form>
    </div>
    <script>
$('#subjectcode').change(function(){
    var selectedSubject = $(this).val();
    $.ajax({
        type: 'POST',
        url: 'get_description.php', // Replace 'get_description.php' with the actual file name
        data: { subjectcode: selectedSubject },
        success: function(response) {
            $('#description').text(response);
        }
    });
});
        document.getElementById('btnsubmit').addEventListener('click', function(event) {
            var btn = event.target;
            var form = document.getElementById('addgrade');
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
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#">Privacy Policy</a></li>
            </ul>
        </footer> 
</html>
