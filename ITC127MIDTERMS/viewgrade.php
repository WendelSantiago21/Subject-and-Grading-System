<?php
$message = "";
require_once "config.php";
session_start();
$link = mysqli_connect("localhost", "root", "", "itc127-2b-2024");
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$Username = $_SESSION['username'];
$proquery = "SELECT usertype, profile_picture FROM tblaccounts WHERE username = ?";
$stmtprof = mysqli_prepare($link, $proquery);
mysqli_stmt_bind_param($stmtprof, "s", $Username);
mysqli_stmt_execute($stmtprof);
mysqli_stmt_bind_result($stmtprof, $Usertype, $profilePicture);
mysqli_stmt_fetch($stmtprof);
mysqli_stmt_close($stmtprof);
$query = "SELECT a.usertype, a.username, s.lastname, s.firstname, s.middlename, s.course, s.yearlevel
          FROM tblaccounts a
          INNER JOIN tblstudent s ON a.username = s.studentnumber
          WHERE a.username = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "s", $Username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $Usertype, $Username, $lastname, $firstname, $middlename, $course, $yearlevel);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> View Grades- Subject Advising System</title>
    <link rel="stylesheet" href="view.css">
    <link rel="icon" type="image/png" sizes="32x32" href="./img/logo1.svg">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
</head>
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
                <h3 style="margin-right:380px" class="brand"><strong>Arellano University Subject Advising System</strong></h3>
            </div>
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
            <div class="username"><?php echo $_SESSION['username']; ?></div>
        <?php elseif ($Usertype === 'REGISTRAR'): ?>
            <a href="index.php">Home</a>
            <a href="studentpage.php">Students</a>
            <a href="subject_management.php">Subjects</a>
            <a  href="grades-management.php">Grades</a>
            <div class="welcome">
                <div class="reglogo"></div>
                <h3 style="margin-right:390px"class="brand"><strong>Arellano University Subject Advising System</strong></h3>
            </div>
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
        <?php else: ?>
            <a  href="index.php">Home</a>
            <a href="viewgrade.php">View Grades</a>
            <a href="viewsubject.php">Subjects to be taken</a>
            <div class="welcome">
                <div class="stulogo"></div>
                <h3 style="margin-right:500px;margin-top:30px"class="brand"><strong>Arellano University Subject Advising System</strong></h3>
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
<div class="container">
    <?php if ($Usertype === 'STUDENT'): ?>
        <div class="student-info">
            <h2 class="info-heading">Student Information</h2>
            <div class="info-details">
                <p><strong>Student Number:</strong> <?= $Username ?></p>
                <p><strong>Name:</strong> <?= $lastname ?> <?= $firstname ?> <?= $middlename ?></p>
                <p><strong>Course:</strong> <?= $course ?></p>
                <p><strong>Year Level:</strong> <?= $yearlevel ?></p>
            </div>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <input type="submit" onclick="exportToword()" value="Download Your Grade As Word">
        </form>
    <script>
       function exportToword() {
    var studentNumber = "<?= $Username ?>";
    var lastName = "<?= $lastname ?>";
    var firstName = "<?= $firstname ?>";
    var middleName = "<?= $middlename ?>";
    var course = "<?= $course ?>";
    var yearLevel = "<?= $yearlevel ?>";
    var gradeRows = document.querySelectorAll('.Grade-table table tr');
    var html = "<table style='border-collapse: collapse; width: 100%; margin-top: 20px;'>";
    html += "<tr><th colspan='2' style='background-color: #007bff; color: white; padding: 10px;'>Student Information</th></tr>" +
        "<tr><td style='border: 1px solid #ddd; padding: 10px;'>Student Number</td><td style='border: 1px solid #ddd; padding: 10px;'>" + studentNumber + "</td></tr>" +
        "<tr><td style='border: 1px solid #ddd; padding: 10px;'>Name</td><td style='border: 1px solid #ddd; padding: 10px;'>" + lastName + '&nbsp;' + firstName + '&nbsp;' + middleName + "</td></tr>" +
        "<tr><td style='border: 1px solid #ddd; padding: 10px;'>Course</td><td style='border: 1px solid #ddd; padding: 10px;'>" + course + "</td></tr>" +
        "<tr><td style='border: 1px solid #ddd; padding: 10px;'>Year Level</td><td style='border: 1px solid #ddd; padding: 10px;'>" + yearLevel + "</td></tr>";

    html += "<tr><th colspan='4' style='background-color: #007bff; color: white; padding: 10px;'>Grades</th></tr>";
    html += "<tr><th style='border: 1px solid #ddd; padding: 10px;'>Subject Code</th><th style='border: 1px solid #ddd; padding: 10px;'>Description</th><th style='border: 1px solid #ddd; padding: 10px;'>Unit</th><th style='border: 1px solid #ddd; padding: 10px;'>Grade</th></tr>";
    gradeRows.forEach(function(row) {
        var cells = row.querySelectorAll('td');
        if (cells.length >= 4) {
            var subjectCode = cells[0].textContent.trim();
            var description = cells[1].textContent.trim();
            var unit = cells[2].textContent.trim();
            var grade = cells[3].textContent.trim();
            html += "<tr><td style='border: 1px solid #ddd; padding: 10px;'>" + subjectCode + "</td><td style='border: 1px solid #ddd; padding: 10px;'>" + description + "</td><td style='border: 1px solid #ddd; padding: 10px;'>" + unit + "</td><td style='border: 1px solid #ddd; padding: 10px;'>" + grade + "</td></tr>";
        }
    });
    html += "</table>";
    var blob = new Blob([html], { type: 'application/vnd.ms-word' });
    if (window.navigator.msSaveBlob) {
        window.navigator.msSaveOrOpenBlob(blob, 'grade.doc');
    } else {
        var link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = 'grade.doc';
        link.click();
    }
}
    </script>
        <div class="Grade-table">
            <h2>Grades</h2>
        <?php
        $sql_select_grades = "SELECT g.subjectcode, s.description, s.unit, g.grade, g.encodedby, g.dateencoded 
                              FROM tblgrade g
                              INNER JOIN tblsubject s ON g.subjectcode = s.subjectcode
                              WHERE g.studentnumber = ?";
        if ($stmt_grades = mysqli_prepare($link, $sql_select_grades)) {
            mysqli_stmt_bind_param($stmt_grades, "s", $Username);
            mysqli_stmt_execute($stmt_grades);
            mysqli_stmt_bind_result($stmt_grades, $subjectcode, $description, $unit, $grade, $encodedby, $dateencoded);
            $row_count = 0;
            mysqli_stmt_store_result($stmt_grades);
            $row_count = mysqli_stmt_num_rows($stmt_grades);
            if ($row_count > 0) {
                echo "<table border='1'>
                        <tr><th>Subject Code</th><th>Description</th><th>Unit</th><th>Grade</th><th>Encoded By</th><th>Date Encoded</th></tr>";
                while (mysqli_stmt_fetch($stmt_grades)) {
                    echo "<tr>
                            <td><strong>$subjectcode</strong></td>
                            <td><strong>$description</strong></td>
                            <td><strong>$unit</strong></td>
                            <td><strong>$grade</strong></td>
                            <td><strong>$encodedby</strong></td>
                            <td><strong>$dateencoded</strong></td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='color: red;'>No grades found.</p>";
            }
            mysqli_stmt_close($stmt_grades);
        } else {
            echo "<p>Error in preparing statement.</p>";
        }
        ?>
    <?php else: ?>
        <p style="font-color:red">Access Denied</p>
    <?php endif; ?>
</div>
</body>
<footer class="footer">
    <div class="social-media">
        <a href="https://www.facebook.com/ArellanoUniversityOfficial/"><img src="img/facebook.svg" alt="Facebook"></a>
        <a href="https://twitter.com/Arellano_U"><img src="img/twitter.svg" alt="Twitter"></a>
        <a href="https://www.instagram.com/explore/topics/495287895113599/arellano-university/"><img src="img/instagram.svg" alt="Instagram"></a>
    </div>
    <footer class="footer">
        <ul>
            <li><a style="color:black" href="#">Terms of Service</a></li>
            <li><a style="color:black" href="#">Privacy Policy</a></li>
        </ul>
    </footer>
</html>
