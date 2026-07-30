<?php
session_start();

if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Temporary login
    if ($username === "CASH4MH/admin" && $password === "Derek@789") {

        $_SESSION['admin'] = true;

        header("Location: dashboard.php");
        exit;

    } else {

        $error = "Invalid username or password.";

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Admin Login</title>

<style>

body{
font-family:Arial,sans-serif;
background:#f4f6f9;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
margin:0;
}

.login-box{

width:380px;
background:#fff;
padding:35px;
border-radius:10px;
box-shadow:0 10px 30px rgba(0,0,0,.08);

}

input{

width:100%;
padding:12px;
margin-bottom:15px;
box-sizing:border-box;

}

button{

width:100%;
padding:12px;
background:#2d7d46;
color:white;
border:none;
cursor:pointer;

}

.error{

color:red;
margin-bottom:15px;

}

</style>

</head>

<body>

<div class="login-box">

<h2>Admin Login</h2>

<?php if($error): ?>

<div class="error"><?= $error ?></div>

<?php endif; ?>

<form method="POST">

<input
type="text"
name="username"
placeholder="Username"
required>

<input
type="password"
name="password"
placeholder="Password"
required>

<button type="submit">

Login

</button>

</form>

</div>

</body>

</html>