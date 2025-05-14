<?php
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
mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Advising System Page.com</title>
    <link rel="icon" type="image/png" sizes="32x32" href="./img/logo1.svg">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: beige;
            margin: 0;
            padding: 0;
        }
        
        .topnav {
    overflow: hidden;
    background-color: #1F2833;
    font-weight:bold;
    color:white;
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
        .Welcome {
    background-color: #335792;
    padding: 10px;
    text-align: center;
    margin-bottom: 18px;
}
.logo {
    position:absolute;
    top: 10px;
    right: 0;
    width: 50px;
    height: 80px;
    background-image: url('./img/logo1.svg');
    background-size: contain;
    background-repeat: no-repeat;
    border-radius: 50%;
    margin-right: 420px;
}
.stulogo {
    position:absolute;
    top:0;
    right: 0;
    width: 50px;
    height: 80px;
    background-image: url('./img/logo1.svg');
    background-size: contain;
    background-repeat: no-repeat;
    border-radius: 50%;
    margin-right: 530px;
}

.Welcome h1 {
    color: #ffffff;
    font-size: 18px;
    margin-top: 5px;
}

.Welcome a {
    display: inline-block;
    background-color: #ff6f61;
    color: #ffffff;
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.Welcome a:hover {
    background-color: #ff5440;
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
    margin-right: 460px;
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

.profile-picture-container {
position: absolute;
top: 5px;
right: 80px;
}
.regprofile-picture-container {
position: absolute;
top: 0px;
right: 50px;
margin-bottom:5px;
}
.profile-picture {
width: 70px;
height: 70px;
border-radius: 50%;
margin-bottom:10px;
object-fit: cover;
border:none;
box-shadow:none;
}

.profile-info {
    color: #333;
}

.profile-info h1 {
    font-size: 24px;
    margin-bottom: 5px;
}

.profile-info h4 {
    font-size: 16px;
    margin-bottom: 10px;
}

.profile-actions {
    margin-left: auto;
}

.profile-actions a {
    color: #3498db;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s ease;
    margin-top: 10px;
}

.profile-actions a:hover {
    color: #1e87cd;
}
.profile-picture-container {
    position: absolute;
    top: 5px;
    right: 40px;
}
.regprofile-picture-container {
    position: absolute;
    top: 0px;
    right: 40px;
    margin-bottom:5px;
}
.stuprofile-picture-container {
    position: absolute;
    top: 0px;
    right: 50px;
    margin-bottom:10px;
}
.stuprofile-picture {
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
    margin-left: 1250px; 
    display: inline-block;
}
.stuusername {
    color: white;
    font-size: 18px;
    margin-left: 1280px; 
    display: inline-block;
}
.regusername {
    color: white;
    font-size: 18px;
    margin-left: 790px; 
    display: inline-block;
}

.footer {
    text-align: center;
    font-size: 1rem;
    font-weight: bold;
    background-color: #45A29E;
}
.footer ul {
    list-style: none;
}

.footer ul li {
    display: inline-block;
    margin: 0 10px;
}
.social-media {
    text-align: center;
    margin-top: 20px;
    padding-top: 10px;
    background-color: #45A29E;
}
.social-media img {
    width: 30px;
    height: 30px;
    transition: transform 0.3s ease;
}

.social-media img:hover {
    transform: scale(1.2);
}
.hamburger-icon {
    font-size: 18px;
    color: white; 
    border-radius: 50%;
    padding: 6px;
    position: absolute;
    bottom:25px;
    right:70px; 
}
.reghamburger-icon {
    font-size: 18px;
    color: white; 
    border-radius: 50%;
    padding: 6px;
    position: absolute;
    bottom:25px;
    right:40px; 
}
.stuhamburger-icon {
    font-size: 18px;
    color: white; 
    border-radius: 50%;
    padding: 6px;
    position: absolute;
    bottom:25px;
    right:40px; 
}
.hero {
      text-align: center;
      padding: 150px 0;
      background: linear-gradient(45deg, #ff8a00, #e52e71);
      color: #fff;
      position: relative;
      overflow: hidden;
    }

    .hero::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      z-index: -1;
      animation: heroAnimation 15s infinite alternate;
    }

    @keyframes heroAnimation {
      0% {
        transform: scale(1);
      }
      100% {
        transform: scale(1.05);
      }
    }

    .hero-content {
      opacity: 0;
      animation: fadeInUp 1s forwards 0.5s;
    }

    .hero-heading {
      font-size: 72px;
      margin-bottom: 20px;
      animation: fadeInUp 1s forwards 0.8s;
      animation-timing-function: ease-out;
    }

    .hero-text {
      font-size: 24px;
      margin-bottom: 30px;
      animation: fadeInUp 1s forwards 1.1s;
      animation-timing-function: ease-out;
    }

    .btn {
      display: inline-block;
      background-color: #fff;
      color: #ff8a00;
      padding: 15px 30px;
      border-radius: 50px;
      text-decoration: none;
      font-size: 24px;
      transition: background-color 0.3s ease;
      animation: fadeInUp 1s forwards 1.4s;
    }

    .btn:hover {
      background-color: #e05244;
    }

    .features {
      padding: 150px 0;
      background-color: #f9f9f9;
      transition: background-color 0.5s ease;
    }

    .features-heading {
      text-align: center;
      margin-bottom: 50px;
      animation: fadeIn 1s forwards 2s;
      transition: color 0.5s ease;
    }

    .feature {
      text-align: center;
      margin-bottom: 50px;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      animation: fadeInUp 1s forwards;
      position: relative;
      background-color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .feature:hover {
      transform: translateY(-10px);
      box-shadow: 0 0 40px rgba(0, 0, 0, 0.2);
    }

    .feature-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.4);
      border-radius: 20px;
      z-index: -1;
      opacity: 0;
      animation: featureAnimation 1s forwards;
    }

    @keyframes featureAnimation {
      0% {
        opacity: 0;
        transform: scale(1);
      }
      100% {
        opacity: 1;
        transform: scale(1.02);
      }
    }

    .feature-image {
      width: 200px;
      border-radius: 50%;
      margin-bottom: 20px;
      animation: fadeInUp 1s forwards 0.8s;
    }

    .feature-content {
      position: relative;
      z-index: 1;
      animation: fadeInUp 1s forwards 1s;
    }

    .feature-heading {
      margin-top: 20px;
      font-size: 28px;
      color: black;
      animation: fadeInUp 1s forwards 1.2s;
    }

    .feature-text {
      font-size: 18px;
      color: black;
      animation: fadeInUp 1s forwards 1.4s;
    }

    footer {
      background-color: #222;
      color: #fff;
      padding: 50px 0;
      text-align: center;
      animation: fadeIn 1s forwards 3s;
    }

    .footer-links {
      list-style-type: none;
      margin-top: 20px;
    }

    .footer-links-item {
      display: inline-block;
      margin-left: 10px;
      animation: fadeIn 1s forwards 3.2s;
    }

    .footer-link {
      color: #fff;
      text-decoration: none;
      transition: color 0.3s ease;
      font-size: 18px;
    }

    .footer-link:hover {
      color: #ff6f61;
    }

    @keyframes fadeInUp {
      0% {
        transform: translateY(50px);
        opacity: 0;
      }
      100% {
        transform: translateY(0);
        opacity: 1;
      }
    }

    @keyframes fadeIn {
      0% {
        opacity: 0;
      }
      100% {
        opacity: 1;
      }
    }

    @keyframes fadeInLeft {
      0% {
        opacity: 0;
        transform: translateX(-50px);
      }
      100% {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes fadeInRight {
       0% {
        opacity: 0;
        transform: translateX(50px);
      }
      100% {
        opacity: 1;
        transform: translateX(0);
      }
    }
    .feature:nth-child(odd) {
      background-color: #f3f3f3;
    }

    .feature:nth-child(even) {
      background-color: #eaeaea;
    }

    .feature-overlay {
      background: rgba(255, 255, 255, 0.3);
    }

    .feature:hover .feature-overlay {
      background: rgba(255, 255, 255, 0.5);
    }

    .feature-image {
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .feature-heading {
      color: #ff6f61;
      font-size: 32px;
      margin-top: 30px;
    }

    .feature-text {
      color: #444;
      font-size: 16px;
      line-height: 1.6;
    }

    footer {
      margin-top: 100px;
    }

    @media screen and (max-width: 768px) {
      .container {
        padding: 0 15px;
      }

      .logo {
        font-size: 24px;
      }

      .navigation {
        flex-direction: column;
        align-items: center;
      }

      .navigation-item {
        margin-left: 0;
        margin-bottom: 10px;
      }

      .hero-heading {
        font-size: 48px;
      }

      .hero-text {
        font-size: 20px;
      }

      .btn {
        padding: 12px 24px;
        font-size: 20px;
      }

      .feature-heading {
        font-size: 24px;
      }

      .feature-text {
        font-size: 14px;
      }
    }

    .animated-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, rgba(255, 138, 0, 0.5), rgba(229, 46, 113, 0.5));
      transform: skewY(-10deg);
      z-index: -2;
      animation: animatedBackground 10s linear infinite;
    }

    @keyframes animatedBackground {
      0% {
        background-position: 0 0;
      }
      100% {
        background-position: 100% 100%;
      }
    }

    .animated-text {
      position: relative;
      display: inline-block;
      animation: glitch 1s infinite;
    }

    @keyframes glitch {
      0% {
        transform: translateY(0) translateZ(0);
        opacity: 1;
      }
      25% {
        transform: translateY(-5px) translateZ(0);
      }
      50% {
        transform: translateY(0) translateZ(0);
        opacity: 0.7;
      }
      75% {
        transform: translateY(5px) translateZ(0);
      }
      100% {
        transform: translateY(0) translateZ(0);
        opacity: 1;
      }
    }

    .animated-border {
      position: relative;
      display: inline-block;
    }

    .animated-border::before,
    .animated-border::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border: 2px solid transparent;
      z-index: -1;
      transition: all 0.3s ease;
    }

    .animated-border::before {
      border-top-color: #ff8a00;
      border-right-color: #e52e71;
    }

    .animated-border::after {
      border-bottom-color: #ff8a00;
      border-left-color: #e52e71;
    }

    .animated-border:hover::before,
    .animated-border:hover::after {
      border-color: transparent;
    }
    .fadeIn {
      opacity: 0;
      animation: fadeInAnimation 1s forwards;
    }

    @keyframes fadeInAnimation {
      0% {
        opacity: 0;
        transform: translateY(50px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fadeInDelay {
      opacity: 0;
      animation: fadeInAnimation 1s forwards;
      animation-delay: 0.5s;
    }

    .fadeInDelayTwo {
      opacity: 0;
      animation: fadeInAnimation 1s forwards;
      animation-delay: 1s;
    }
    .cta-section {
      text-align: center;
      padding: 100px 0;
      background-color: #222;
      color: #fff;
    }

    .cta-heading {
      font-size: 48px;
      margin-bottom: 30px;
      animation: fadeIn 1s forwards 2s;
    }

    .cta-text {
      font-size: 24px;
      margin-bottom: 50px;
      animation: fadeIn 1s forwards 2.5s;
    }

    .cta-btn {
      display: inline-block;
      background-color: #ff6f61;
      color: #fff;
      padding: 15px 30px;
      border-radius: 50px;
      text-decoration: none;
      font-size: 24px;
      transition: background-color 0.3s ease;
      animation: fadeIn 1s forwards 3s;
    }

    .cta-btn:hover {
      background-color: #e05244;
    }

    .animation-wrapper {
      position: relative;
      overflow: hidden;
    }

    .animated-feature {
      position: relative;
      z-index: 1;
    }

    .animation-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 20px;
      z-index: -1;
      opacity: 0;
      animation: fadeInOverlay 1s forwards;
    }

    @keyframes fadeInOverlay {
      0% {
        opacity: 0;
      }
      100% {
        opacity: 1;
      }
    }

    .animated-feature:hover .animation-overlay {
      background: rgba(255, 255, 255, 0.5);
    }

    .animation-image {
      width: 150px;
      border-radius: 50%;
      margin-bottom: 20px;
      animation: fadeInUp 1s forwards 0.8s;
    }

    .animation-heading {
      font-size: 28px;
      margin-top: 20px;
      animation: fadeInUp 1s forwards 1s;
    }

    .animation-text {
      font-size: 18px;
      color: #ccc;
      animation: fadeInUp 1s forwards 1.2s;
    }
    .body-section {
      padding: 100px 0;
    }

    .body-heading {
      font-size: 42px;
      text-align: center;
      margin-bottom: 50px;
      animation: fadeIn 1s forwards 2s;
    }

    .body-text {
      font-size: 18px;
      line-height: 1.8;
      margin-bottom: 30px;
      animation: fadeIn 1s forwards 2.5s;
    }

    .body-image {
      width: 100%;
      max-width: 600px;
      display: block;
      margin: 0 auto;
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      animation: fadeInUp 1s forwards 3s;
    }

    .body-image:hover {
      transform: scale(1.05);
    }

    .body-quote {
      font-size: 24px;
      font-style: italic;
      text-align: center;
      margin-top: 30px;
      animation: fadeIn 1s forwards 3.5s;
    }

    .body-author {
      font-size: 18px;
      font-weight: bold;
      text-align: center;
      animation: fadeIn 1s forwards 4s;
    }
     @keyframes fadeIn {
      0% {
        opacity: 0;
      }
      100% {
        opacity: 1;
      }
    }

    @keyframes fadeInUp {
      0% {
        opacity: 0;
        transform: translateY(50px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInLeft {
      0% {
        opacity: 0;
        transform: translateX(-50px);
      }
      100% {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes fadeInRight {
      0% {
        opacity: 0;
        transform: translateX(50px);
      }
      100% {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes fadeInDown {
      0% {
        opacity: 0;
        transform: translateY(-50px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInOverlay {
      0% {
        opacity: 0;
      }
      100% {
        opacity: 1;
      }
    }

    @keyframes glitch {
      0% {
        transform: translateY(0) translateZ(0);
        opacity: 1;
      }
      25% {
        transform: translateY(-5px) translateZ(0);
      }
      50% {
        transform: translateY(0) translateZ(0);
        opacity: 0.7;
      }
      75% {
        transform: translateY(5px) translateZ(0);
      }
      100% {
        transform: translateY(0) translateZ(0);
        opacity: 1;
      }
    }

    @keyframes animatedBackground {
      0% {
        background-position: 0 0;
      }
      100% {
        background-position: 100% 100%;
      }
    }

    @keyframes featureAnimation {
      0% {
        opacity: 0;
        transform: scale(1);
      }
      100% {
        opacity: 1;
        transform: scale(1.02);
      }
    }

    @keyframes heroAnimation {
      0% {
        transform: scale(1);
      }
      100% {
        transform: scale(1.05);
      }
    }

    @keyframes animatedBackgroundTwo {
      0% {
        background-position: 0 0;
      }
      100% {
        background-position: -100% -100%;
      }
    }

    @keyframes animatedBackgroundThree {
      0% {
        background-position: 0 0;
      }
      100% {
        background-position: 100% 100%;
      }
    }

    @keyframes animatedBackgroundFour {
      0% {
        background-position: 0 0;
      }
      100% {
        background-position: -100% 100%;
      }
    }

    @keyframes fadeInAnimation {
      0% {
        opacity: 0;
        transform: translateY(50px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }
    .animated-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, rgba(255, 138, 0, 0.5), rgba(229, 46, 113, 0.5));
      transform: skewY(-10deg);
      z-index: -2;
      animation: animatedBackground 10s linear infinite;
    }

    .animated-bg-two {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(-45deg, rgba(255, 138, 0, 0.5), rgba(229, 46, 113, 0.5));
      transform: skewY(-10deg);
      z-index: -2;
      animation: animatedBackgroundTwo 10s linear infinite;
    }

    .animated-bg-three {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, rgba(255, 138, 0, 0.5), rgba(229, 46, 113, 0.5));
      transform: skewY(-10deg);
      z-index: -2;
      animation: animatedBackgroundThree 10s linear infinite;
    }

    .animated-bg-four {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(-45deg, rgba(255, 138, 0, 0.5), rgba(229, 46, 113, 0.5));
      transform: skewY(-10deg);
      z-index: -2;
      animation: animatedBackgroundFour 10s linear infinite;
    }

    .animated-text {
      position: relative;
      display: inline-block;
      animation: glitch 1s infinite;
    }

    .animated-border {
      position: relative;
      display: inline-block;
    }

    .animated-border::before,
    .animated-border::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border: 2px solid transparent;
      z-index: -1;
      transition: all 0.3s ease;
    }

    .animated-border::before {
      border-top-color: #ff8a00;
      border-right-color: #e52e71;
    }

    .animated-border::after {
      border-bottom-color: #ff8a00;
      border-left-color: #e52e71;
    }

    .animated-border:hover::before,
    .animated-border:hover::after {
      border-color: transparent;
    }
    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .overlay:hover {
      opacity: 1;
    }
    .expandable {
      cursor: pointer;
      transition: transform 0.3s ease;
    }

    .expandable:hover {
      transform: scale(1.1);
    }

    .clickable {
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .clickable:hover {
      background-color: #ddd;
    }

    .hoverable {
      transition: transform 0.3s ease;
    }

    .hoverable:hover {
      transform: translateY(-5px);
    }

    .focusable {
      outline: none;
      transition: box-shadow 0.3s ease;
    }

    .focusable:focus {
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    }

    .blink {
      animation: blinkAnimation 1s infinite;
    }

    @keyframes blinkAnimation {
      0% {
        opacity: 1;
      }
      50% {
        opacity: 0;
      }
      100% {
        opacity: 1;
      }
    }
    @keyframes slideInFromLeft {
      0% {
        transform: translateX(-100%);
        opacity: 0;
      }
      100% {
        transform: translateX(0);
        opacity: 1;
      }
    }

    @keyframes slideInFromRight {
      0% {
        transform: translateX(100%);
        opacity: 0;
      }
      100% {
        transform: translateX(0);
        opacity: 1;
      }
    }

    @keyframes slideInFromTop {
      0% {
        transform: translateY(-100%);
        opacity: 0;
      }
      100% {
        transform: translateY(0);
        opacity: 1;
      }
    }

    @keyframes slideInFromBottom {
      0% {
        transform: translateY(100%);
        opacity: 0;
      }
      100% {
        transform: translateY(0);
        opacity: 1;
      }
    }

    @keyframes rotateIn {
      0% {
        transform: rotate(-180deg);
        opacity: 0;
      }
      100% {
        transform: rotate(0deg);
        opacity: 1;
      }
    }

    @keyframes bounce {
      0% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-20px);
      }
      100% {
        transform: translateY(0);
      }
    }

    @keyframes pulse {
      0% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.05);
      }
      100% {
        transform: scale(1);
      }
    }

    @keyframes shake {
      0% {
        transform: translateX(0);
      }
      25% {
        transform: translateX(-10px);
      }
      50% {
        transform: translateX(10px);
      }
      75% {
        transform: translateX(-5px);
      }
      100% {
        transform: translateX(0);
      }
    }

    @keyframes fadeIn {
      0% {
        opacity: 0;
      }
      100% {
        opacity: 1;
      }
    }

    @keyframes fadeOut {
      0% {
        opacity: 1;
      }
      100% {
        opacity: 0;
      }
    }
    .animated-border {
      position: relative;
      display: inline-block;
      overflow: hidden;
    }

    .animated-border::before,
    .animated-border::after {
      content: '';
      position: absolute;
      top: 0;
      bottom: 0;
      background-color: #ff8a00;
      width: 0%;
      transition: width 0.3s ease;
    }

    .animated-border::before {
      left: 0;
    }

    .animated-border::after {
      right: 0;
    }

    .animated-border:hover::before,
    .animated-border:hover::after {
      width: 100%;
    }

    .animated-text {
      position: relative;
      display: inline-block;
      overflow: hidden;
    }

    .animated-text::after {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, #ff8a00, transparent);
      animation: slideInFromRight 1s infinite;
    }

    .animated-text:hover::after {
      left: 100%;
      animation: slideInFromLeft 1s infinite;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .overlay:hover {
      opacity: 1;
    }

    .expandable {
      cursor: pointer;
      transition: transform 0.3s ease;
    }

    .expandable:hover {
      transform: scale(1.1);
    }

    .clickable {
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .clickable:hover {
      background-color: #ddd;
    }

    .hoverable {
      transition: transform 0.3s ease;
    }

    .hoverable:hover {
      transform: translateY(-5px);
    }

    .focusable {
      outline: none;
      transition: box-shadow 0.3s ease;
    }

    .focusable:focus {
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    }

    .blink {
      animation: blinkAnimation 1s infinite;
    }

    @keyframes blinkAnimation {
      0% {
        opacity: 1;
      }
      50% {
        opacity: 0;
      }
      100% {
        opacity: 1;
      }
    }
    .transition {
      transition: all 0.3s ease;
    }

    .transition:hover {
      transform: scale(1.1);
    }

    .fadeInDelay {
      opacity: 0;
      animation: fadeInAnimation 1s forwards;
      animation-delay: 0.5s;
    }

    .fadeInDelayTwo {
      opacity: 0;
      animation: fadeInAnimation 1s forwards;
      animation-delay: 1s;
    }
    .rainbow-text {
      background: linear-gradient(to right, #ff8a00, #ffbd00, #fff200, #b2ff00, #00ff6d, #00ffea, #00b2ff, #006dff, #4700ff, #a300ff, #e100ff, #ff00c8);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      animation: rainbowAnimation 10s linear infinite;
    }

    @keyframes rainbowAnimation {
      0% {
        background-position: 0% 50%;
      }
      100% {
        background-position: 100% 50%;
      }
    }

    .floating {
      animation: floatingAnimation 3s ease-in-out infinite;
    }

    @keyframes floatingAnimation {
      0% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-20px);
      }
      100% {
        transform: translateY(0);
      }
    }

    .zoom {
      transition: transform 0.5s ease;
    }

    .zoom:hover {
      transform: scale(1.1);
    }
    </style>
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
            </div>
            <h3 style="margin-left:600px;margin-top:20px" class="brand"><strong>Arellano University Subject Advising System</strong></h3>
            <div class="profile-picture-container">
                <div class="dropdown">
                    <img src="<?= $profilePicture ?>" alt="Profile Picture" style="margin-right:60px" class="profile-picture dropbtn" onclick="toggleDropdown()"><span class="hamburger-icon">&#9776;</span>
                    <div class="dropdown-content" id="dropdownContent">
                        <a href="#"><?php echo $_SESSION['usertype']; ?></a>
                        <a href="advising-management.php">Advising Subject</a>
                        <a href="profile.php">Edit Profile</a>
                        <a href="indexlogout.php">Logout</a>
                    </div>
                </div>
            </div>
            <div class="username"><?php echo $_SESSION['username']; ?></div>
        <?php elseif ($Usertype === 'REGISTRAR' || $Usertype === 'STAFF'): ?>
            <a href="index.php">Home</a>
            <a href="studentpage.php">Students</a>
            <a href="subject_management.php">Subjects</a>
            <a href="grades-management.php">Grades</a>
            <div class="welcome">
                <div class="reglogo"></div>
            </div>
            <h3 style="margin-right:280px;margin-top:10px" class="brand"><strong>Arellano University Subject Advising System</strong></h3>
            <div class="regprofile-picture-container">
                <div class="dropdown">
                    <img src="<?= $profilePicture ?>" alt="Profile Picture" class="profile-picture dropbtn" onclick="toggleDropdown()"><span class="reghamburger-icon">&#9776;</span>
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
            <a href="index.php">Home</a>
            <a href="viewgrade.php">View Grades</a>
            <a href="viewsubject.php">Subjects to be taken</a>
            <div class="welcome">
                <div class="stulogo"></div>
            </div>
            <h3 style="margin-left:500px;margin-top:20px" class="brand"><strong>Arellano University Subject Advising System</strong></h3>
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
<body>
<div class="notification" id="notification"></div>
<div class="hero">
    <div class="container">
        <div class="hero-content">
            <h2 class="hero-heading">WELCOME TO OUR AU SUBJECT ADVISING SYSTEM </h2>
            <p class="hero-text">WEB DEVELOPER ---  ARVINNE P. TORNO</p>
            <p class="hero-text">DATA ADMINISTRATOR ---  ARVINNE P. TORNO</p>
            <p class="hero-text">This work is protected by copyright law, and any unauthorized reproduction,<br> distribution, or adaptation is strictly prohibited.
             <br> ---  ARVINNE P. TORNO</p>
            <a href="#" class="btn">Learn More</a>
        </div>
    </div>
</div>
<div class="features">
    <div class="container">
      <h2 class="features-heading">Contacts</h2>
      <div class="feature-row">
        <div class="feature">
          <div class="feature-content">
            <h3 class="feature-heading">CONTACT US</h3>
            <p class="feature-text">VIA EMAIL: tornoarvin@gmail.com</p>
            <p class="feature-text">VIA PHONE NUMBER:09458298358</p>
          </div>
        </div>
        <center>
        <div class="container">
    <h2 class="section-title">About AU Subject Advising System</h2><br>
    <div class="section-row">
        <div class="section-item hoverable transition">
            <div class="section-content">
                <h3 class="section-heading">Easy Subject Management</h3>
                <p class="section-text">Manage subjects effortlessly with our intuitive interface. Add, update, and remove subjects with ease.</p>
            </div>
        </div>
        <div class="section-item hoverable transition">
            <div class="section-content">
                <h3 class="section-heading">Efficient Grades Management</h3>
                <p class="section-text">Streamline grade management for students. Easily input, track, and manage student grades.</p>
            </div>
        </div>
        <div class="section-item hoverable transition">
            <div class="section-content">
                <h3 class="section-heading">User-Friendly Accounts Management</h3>
                <p class="section-text">Manage user accounts seamlessly. Add, edit, and delete accounts with our user-friendly system.</p>
            </div>
        </div>
    </div>
</div><br>
<section class="features">
    <div class="container">
        <h2 class="features-heading">More Features</h2>
        <div class="feature-row">
            <div class="feature">
                <div class="feature-content">
                    <h3 class="feature-heading">Comprehensive Academic Support</h3>
                    <p class="feature-text">The AU Subject Advising System offers comprehensive academic support for students, faculty, and administrators. Students can access a wealth of resources to help them plan their academic journey, from viewing available subjects to understanding degree requirements.</p>
                </div>
            </div>
            <div class="feature">
                <div class="feature-content">
                    <h3 class="feature-heading">Personalized Advising</h3>
                    <p class="feature-text">Our system provides personalized advising services tailored to each student's academic needs. Through intuitive tools and recommendations, students can receive guidance on selecting the right subjects, based on their program, interests, and career goals.</p>
                </div>
            </div>
            <div class="feature">
                <div class="feature-content">
                    <h3 class="feature-heading">Efficient Administration</h3>
                    <p class="feature-text">For administrators and faculty members, our system streamlines administrative tasks related to subject management, grading, and student records. Administrators can easily oversee course offerings, manage student enrollments, and generate reports for accreditation purposes.</p>
                </div>
            </div>
            <div class="feature">
                <div class="feature-content">
                    <h3 class="feature-heading">Interactive Learning</h3>
                    <p class="feature-text">We promote interactive learning experiences through our system. Students can engage with course materials, participate in discussions, and collaborate with peers, enhancing their understanding and retention of subject matter.</p>
                </div>
            </div>
            <div class="feature">
                <div class="feature-content">
                    <h3 class="feature-heading">Responsive Design</h3>
                    <p class="feature-text">Our website features a responsive design that adapts seamlessly to various devices and screen sizes. Whether students access the system on a desktop computer, laptop, tablet, or smartphone, they'll have a consistent and user-friendly experience.</p>
                </div>
            </div>
        </div>
    </div>
</section>

        </center>
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
        }, 1000);
    }

    <?php
    if (!empty($message )) {
        echo "displayNotification('<b>" . addslashes($message ) . "</b>', 'success');";
    }
    ?>
</script>
<script>
    function toggleDropdown() {
        var dropdownContent = document.getElementById("dropdownContent");
        if (dropdownContent.style.display === "block") {
            dropdownContent.style.display = "none";
        } else {
            dropdownContent.style.display = "block";
        }
    }
</script>
</body>

<footer class="footer">
    <div class="social-media">
        <a  href="https://www.facebook.com/ArellanoUniversityOfficial/"><img src="img/facebook.svg" alt="Facebook"></a>
        <a href="https://twitter.com/Arellano_U"><img src="img/twitter.svg" alt="Twitter"></a>
        <a href="https://www.instagram.com/explore/topics/495287895113599/arellano-university/"><img src="img/instagram.svg" alt="Instagram"></a>
    </div>
    <ul>
        <li><a style="color:black; text-decoration: none; margin-bottom: 50px" href="#">Terms of Service</a></li>
        <li><a style="color:black; text-decoration: none; margin-bottom: 50px" href="#">Privacy Policy</a></li>
    </ul>
</footer>
</html>