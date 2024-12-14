<?php
// Include the database configuration file
include 'core/config.php';

// Start a session
session_start();

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check user credentials
    $query = "SELECT id, role FROM users WHERE username = '$username' AND password = md5('$password')";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role'] = $row['role'];

        // Redirect based on role
        if ($row['role'] == 'hr') {
            header("Location: hr.php");
        } elseif ($row['role'] == 'applicant') {
            header("Location: applicant.php");
        }
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>FindHire Login Page</title>
</head>
<body>
    <div class="flex-container">
        <form method="POST" action="">
            <div>
                <img src="img/Logo.png" alt="Logo" class="center" width="220" height="150" />
            </div>
            <div>
                <p>Username:</p>
                <input type="text" name="username" required />
                <p>Password:</p>
                <input type="password" name="password" required />
            </div>
            <br />
            <div>
                <input type="submit" value="Login" />
            </div>
            <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
            <p>Don't have an Account?</p>
            <a href="registration.php">Register Here</a>
        </form>
    </div>
</body>
</html>

<style>
    body {
        background-image: url("img/pexels-sevenstormphotography-439391.jpg");
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    }
    .flex-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        background: #000000a8 !important;
        width: fit-content;
        border-radius: 25px;
        margin: 0 auto;
        padding-bottom: 50px;
		padding-left:10px;
		padding-right:10px;
    }
    p {
        font-family: Arial, Helvetica, sans-serif;
        font-weight: bolder;
        color: whitesmoke;
        text-shadow: -1px 1px 0 #000, 1px 1px 0 #000, 1px -1px 0 #000,
            -1px -1px 0 #000;
    }
    a {
        color: #add8e6;
        text-shadow: -1px 1px 0 #000, 1px 1px 0 #000, 1px -1px 0 #000,
            -1px -1px 0 #000;
    }
</style>
