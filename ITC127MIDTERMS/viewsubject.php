<?php
$message = "";
require_once "config.php";
session_start();
$link = mysqli_connect("localhost", "root", "", "itc127-2b-2024");
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$Username = $_SESSION['username'];
// Retrieve user profile information
$proquery = "SELECT usertype, profile_picture FROM tblaccounts WHERE username = ?";
$stmtprof = mysqli_prepare($link, $proquery);
mysqli_stmt_bind_param($stmtprof, "s", $Username);
mysqli_stmt_execute($stmtprof);
mysqli_stmt_bind_result($stmtprof, $Usertype, $profilePicture);
mysqli_stmt_fetch($stmtprof);
mysqli_stmt_close($stmtprof);
// Retrieve student information
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
$studentnumber = $_SESSION['username'] ?? null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View subject to be taken - Subject Advising System</title>
    <link rel="stylesheet" href="view.css">
    <link rel="icon" type="image/png" sizes="32x32" href="./img/logo1.svg">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
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
            <a  href="viewsubject.php">Subjects to be taken</a>
            <div class="welcome">
                <div class="stulogo"></div>
                <h3 style="margin-right:500px;margin-top:20px"class="brand"><strong>Arellano University Subject Advising System</strong></h3>
            </div>
            <div class="stuprofile-picture-container">
                <div class="dropdown">
                    <img src="<?= $profilePicture ?>" alt="Profile Picture" class="stuprofile-picture dropbtn" onclick="toggleDropdown()"><span class="stuhamburger-icon">&#9776;</span>
                    <div class="dropdown-content" id="dropdownContent">
                        <a href="#"><?php echo $_SESSION['usertype']; ?></a>
                        <a href="profile.php">Profile</a>
                        <a href="change.php">Change Password</a>
                        <a href="indexlogout.php">Logout</a>
                    </div>
                </div>
            </div>
            <div class="stuusername"><?php echo $_SESSION['username']; ?></div>
        <?php endif; ?>
    </nav>
</header>
<div class="student-info" style="text-align: center;">
    <h2>Students Information</h2>
    <p><strong>Student Number: <?php echo $studentnumber; ?></strong></p>
    <?php
    // Fetch student information
    $sql_student_info = "SELECT studentnumber, lastname, firstname, middlename, course, yearlevel FROM tblstudent WHERE studentnumber = ?";
    if($stmt = mysqli_prepare($link, $sql_student_info)) {
        mysqli_stmt_bind_param($stmt, "s", $studentnumber);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $studentnumber, $lastname, $firstname, $middlename, $course, $yearlevel);
        mysqli_stmt_fetch($stmt);
        echo '<p><strong>Name: ' . (isset($lastname) ? $lastname . '&nbsp;' . $firstname . '&nbsp;' . $middlename : '') . '</strong></p>
                <p><strong>Course: ' . (isset($course) ? $course : '') . '</strong></p>
                <p><strong>Year Level: ' . (isset($yearlevel) ? $yearlevel : '') . '</strong></p>';
        mysqli_stmt_close($stmt);
    }
    echo '<div class="main">';
    $sql_select_subjects = "
            SELECT subjectcode, description, unit, course
            FROM tblsubject
            WHERE course = ? 
            AND (
                (prerequisite1 IS NULL AND prerequisite2 IS NULL AND prerequisite3 IS NULL)
                AND (
                    prerequisite1 IS NOT NULL AND prerequisite2 IS NOT NULL AND prerequisite3 IS NOT NULL AND
                    EXISTS (
                        SELECT 1 FROM tblgrade WHERE studentnumber = ? AND subjectcode IN (prerequisite1, prerequisite2, prerequisite3)
                    )
                )
                AND (
                    prerequisite1 IS NOT NULL AND prerequisite2 IS NOT NULL AND prerequisite3 IS NULL AND
                    EXISTS (
                        SELECT 1 FROM tblgrade WHERE studentnumber = ? AND subjectcode IN (prerequisite1, prerequisite2)
                    )
                )
                AND (
                    prerequisite1 IS NOT NULL AND prerequisite2 IS NULL AND prerequisite3 IS NULL AND
                    NOT EXISTS (
                        SELECT 1 FROM tblgrade WHERE studentnumber = ? AND subjectcode = prerequisite1
                    )
                )
                AND (
                    prerequisite1 IS NULL AND prerequisite2 IS NOT NULL AND prerequisite3 IS NOT NULL AND
                    NOT EXISTS (
                        SELECT 1 FROM tblgrade WHERE studentnumber = ? AND subjectcode IN (prerequisite2, prerequisite3)
                    )
                )
                AND (
                    prerequisite1 IS NULL AND prerequisite2 IS NOT NULL AND prerequisite3 IS NULL AND
                    NOT EXISTS (
                        SELECT 1 FROM tblgrade WHERE studentnumber = ? AND subjectcode = prerequisite2
                    )
                )
                AND (
                    prerequisite1 IS NULL AND prerequisite2 IS NULL AND prerequisite3 IS NOT NULL AND
                    NOT EXISTS (
                        SELECT 1 FROM tblgrade WHERE studentnumber = ? AND subjectcode = prerequisite3
                    )
                )
            )
            UNION
            SELECT subjectcode, description, unit, course
            FROM tblsubject
            WHERE course = ?
            AND NOT EXISTS (
                SELECT subjectcode FROM tblgrade WHERE studentnumber = ? AND subjectcode = tblsubject.subjectcode
            )
            ";

    $stmt_subjects = mysqli_prepare($link, $sql_select_subjects);
    mysqli_stmt_bind_param($stmt_subjects, "sssssssss", $course, $studentnumber, $studentnumber, $studentnumber, $studentnumber, $studentnumber, $studentnumber, $course, $studentnumber);
    if ($stmt_subjects) {
        mysqli_stmt_execute($stmt_subjects);
        mysqli_stmt_bind_result($stmt_subjects, $subjectcode, $description, $unit, $course);

        echo "<table>";
        echo "<tr>";
        echo "<th>Subject Code</th>";
        echo "<th>Description</th>";
        echo "<th>Unit</th>";
        echo "<th>Course</th>";
        echo "</tr>";

        while (mysqli_stmt_fetch($stmt_subjects)) {
            echo "<tr>";
            echo "<td><strong>$subjectcode</strong></td>";
            echo "<td><strong>$description</strong></td>";
            echo "<td><strong>$unit</strong></td>";
            echo "<td><strong>$course</strong></td>";
            echo "</tr>";
        }

        echo "</table>";

        // Check if any subjects were found
        if (mysqli_stmt_num_rows($stmt_subjects) === 0) {
            echo "<p>No new available subjects found.</p>";
        }

        mysqli_stmt_close($stmt_subjects);
    } else {
        echo "Error: " . mysqli_error($link);
    }
    ?>
</div><br><br>
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
