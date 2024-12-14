<?php
// Include the database configuration file
require_once 'core/config.php';

// Check if the connection variable is properly initialized
if (!isset($conn)) {
    die("Database connection not initialized. Please check your configuration.");
}

// Handle registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['accountType']);

    // Check if username already exists
    $checkQuery = "SELECT id FROM users WHERE username = '$username'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        $error = "Username already exists. Please choose another.";
    } else {
        // Insert the user into the database
        $query = "INSERT INTO users (username, password, role) VALUES ('$username', md5('$password'), '$role')";

        if ($conn->query($query) === TRUE) {
            $success = "Registration successful. You can now <a href='login.php'>login</a>.";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>FindHire Register Page</title>
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
                <p>Account Type:</p>
                <select id="accountType" name="accountType">
                    <option value="applicant">Applicant</option>
                    <option value="hr">HR</option>
                </select>
            </div>
            <br />
            <div>
                <input type="submit" value="Register" />
            </div>
            <?php
            if (isset($error)) {
                echo "<p style='color: red;'>$error</p>";
            }
            if (isset($success)) {
                echo "<p style='color: green;'>$success</p>";
            }
            ?>
            <p>Already have an Account?</p>
            <a href="login.php">Login Here</a>
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
