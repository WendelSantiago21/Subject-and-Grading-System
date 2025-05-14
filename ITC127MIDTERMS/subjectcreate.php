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
    if(empty($_POST['txtsubjectcode']) || empty($_POST['txtdescription']) || empty($_POST['cmbunit']) || empty($_POST['cmbcoursetype'])) {
        $errors[] = "Please enter all required fields.";
    } else {
        $sql = "SELECT * FROM tblsubject WHERE subjectcode = ?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "s", $_POST['txtsubjectcode']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 0) {
            mysqli_stmt_close($stmt);
            $date = date("Y-m-d");
            $prerequisite1 = empty($_POST['prerequisite1']) ? NULL : $_POST['prerequisite1'];
            $prerequisite2 = empty($_POST['prerequisite2']) ? NULL : $_POST['prerequisite2'];
            $prerequisite3 = empty($_POST['prerequisite3']) ? NULL : $_POST['prerequisite3'];
            $sql = "INSERT INTO tblsubject (subjectcode, description, unit, course, prerequisite1, prerequisite2, prerequisite3, createdby, datecreated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "ssissssss", $_POST['txtsubjectcode'], $_POST['txtdescription'], $_POST['cmbunit'], $_POST['cmbcoursetype'], $prerequisite1, $prerequisite2, $prerequisite3, $_SESSION['username'], $date);       
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                $date = date("Y-m-d");
                $time = date("H:i:s");
                $action = "Create";
                $module = "Subjects Management";
                $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, id, performedby) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($link, $sql);
                mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $_POST['txtsubjectcode'], $_SESSION['username']);
                
                if (mysqli_stmt_execute($stmt)) {
                    $success = "<strong><span style='color:green;'>You have successfully created a new Subject</span></strong>";
                } else {
                    $errors[] = "<font color='red'>Error on Insert Log Statement</font>";
                }
            } else {
                $errors[] = "<strong><span style='color: red;'>Error on adding new subject</span></strong>";
            }
        } else {
            $errors[] = "<strong><span style='color: red;'>Subject code is already in use</span></strong>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Subject - Arellano University Subject Advising System</title>
    <link rel="icon" type="image/png" sizes="32x32" href="./img/logo1.svg">
    <link rel="stylesheet" href="studcreate.css"> 
</head>
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
    .logo {
    position:absolute;
    top: 2;
    right: 0;
    width: 50px;
    height: 60px;
    background-image: url('./img/logo1.svg');
    background-size: contain;
    background-repeat: no-repeat;
    border-radius: 50%;
    margin-right: 440px;
}

#prerequisite1
  {
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
#prerequisite1:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}
#prerequisite1 :-ms-expand {
    display: none;
}
#prerequisite1::after {
    content: '\25BC'; 
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    color: #666;
    pointer-events: none; /
}
#prerequisite1:hover,
#prerequisite1:focus {
    background-color: #e0e0e0;
}
#prerequisite1 option {
    padding: 10px;
    background-color: #f7f7f7;
    color: #333;
}

#prerequisite1 option:hover {
    background-color: #e0e0e0;

}#prerequisite2
  {
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
#prerequisite2:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}
#prerequisite2 :-ms-expand {
    display: none;
}
#prerequisite2::after {
    content: '\25BC'; 
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    color: #666;
    pointer-events: none; /
}
#prerequisite2:hover,
#prerequisite2:focus {
    background-color: #e0e0e0;
}
#prerequisite2 option {
    padding: 10px;
    background-color: #f7f7f7;
    color: #333;
}

#prerequisite2 option:hover {
    background-color: #e0e0e0;
}
#prerequisite3
  {
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
#prerequisite3:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}
#prerequisite3 :-ms-expand {
    display: none;
}
#prerequisite3::after {
    content: '\25BC'; 
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    color: #666;
    pointer-events: none; /
}
#prerequisite3:hover,
#prerequisite3:focus {
    background-color: #e0e0e0;
}
#prerequisite3 option {
    padding: 10px;
    background-color: #f7f7f7;
    color: #333;
}

#prerequisite3 option:hover {
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
#cmbunit
  {
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
  #cmbunit:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}
#cmbunit :-ms-expand {
    display: none;
}
#cmbunit::after {
    content: '\25BC'; 
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    color: #666;
    pointer-events: none; /
}
#cmbunit:hover,
#cmbunit:focus {
    background-color: #e0e0e0;
}
#cmbunit option {
    padding: 10px;
    background-color: #f7f7f7;
    color: #333;
}

#cmbunit option:hover {
    background-color: #e0e0e0;
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
        }, 4000);
    }
    <?php
    if (!empty($errors)) {
        echo "displayNotification('<b>" . addslashes(implode("<br>", $errors)) . "</b>', 'error');";
    }
    if (!empty($success)) {
        echo "displayNotification('<b>" . addslashes($success) . "</b>', 'success');";
        echo "setTimeout(function() {
            window.location.href = 'subject_management.php';
        }, 1000);"; 
    }
?>
</script>
<div class="createaccform">
    <p>Fill up this form and submit in order to add a new subject</p>
    <br>
    <form id="addsubject" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <?php if (!empty($errors)) : ?>
            <div class="php-errors">
                <?php echo implode("<br>", $errors); ?>
            </div>
        <?php endif; ?>
        Subject Code: <input type="text" name="txtsubjectcode" required> <br>
        Description: <input type="text" name="txtdescription" required> <br>
        Pre requisite 1:
        <select name="prerequisite1" id="prerequisite1">
            <option value="">--Select Course First--</option>
        </select><br><br>
        Pre requisite 2:
        <select name="prerequisite2" id="prerequisite2">
            <option value="">--Select Course First--</option>
        </select><br><br>
        Pre requisite 3:
        <select name="prerequisite3" id="prerequisite3">
            <option value="">--Select Course First--</option>
        </select><br><br>
        Number of Unit:
        <select name="cmbunit" id="cmbunit" required>
            <option value="">--Select Unit--</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="5">5</option>
        </select><br><br>
        Course:
        <select name="cmbcoursetype" id="cmbcoursetype" required>
    <option value="">--Select Course--</option>
    <option value="BACHELOR OF SCIENCE IN COMPUTER SCIENCE">Bachelor of Science in Computer Science</option>
    <option value="BACHELOR OF SCIENCE IN ACCOUNTANCY">Bachelor of Science in Accountancy</option>
    <option value="BACHELOR OF SCIENCE IN FINANCIAL MANAGEMENT">Bachelor of Science in Financial Management</option>
    <option value="BACHELOR OF SCIENCE IN MARKETING MANAGEMENT">Bachelor of Science in Marketing Management</option>
    <option value="BACHELOR OF SCIENCE IN HUMAN RESOURCE MANAGEMENT">Bachelor of Science in Human Resource Management</option>
    <option value="BACHELOR OF SCIENCE IN OPERATIONS MANAGEMENT">Bachelor of Science in Operations Management</option>
    <option value="BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY">Bachelor of Science in Information Technology</option>
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
        <input type="submit" name="btnsubmit" class="btnsubmit" value="Add New Subject">
        <a href="subject_management.php">Cancel</a>
    </form>
</div>
<script>
     document.querySelector('.btnsubmit').addEventListener('click', function(event) {
        var btn = event.target;
        var form = document.getElementById('addsubject');
        var phpErrors = form.querySelector('.php-errors');
        if (form.checkValidity()) {
            btn.value = "please wait Verifying...";
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
document.getElementById('cmbcoursetype').addEventListener('change', function() {
    var course = this.value;
    var prerequisites = document.querySelectorAll('[name^="prerequisite"]');
    
    if (course !== '') {
        prerequisites.forEach(function(prerequisite) {
            fetchPrerequisites(course, prerequisite);
        });
    } else {
        prerequisites.forEach(function(prerequisite) {
            clearPrerequisites(prerequisite);
        });
    }
});

function fetchPrerequisites(course, prerequisite) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() { 
        if (xhr.readyState == 4 && xhr.status == 200) {
            prerequisite.innerHTML = xhr.responseText;
        }
    };
    xhr.open("GET", "get_prerequisites.php?course=" + encodeURIComponent(course), true);
    xhr.send();
}

function clearPrerequisites(prerequisite) {
    prerequisite.innerHTML = "<option value=''>--Select Course First--</option>";
}
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
