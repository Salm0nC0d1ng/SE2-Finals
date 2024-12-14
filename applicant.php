<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'applicant') {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .dashboard {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .nav {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .nav a {
            display: block;
            width: 100%;
            text-align: center;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .nav a:hover {
            background-color: #0056b3;
        }

        .logout {
            margin-top: 20px;
            padding: 10px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>Applicant Dashboard</h1>
        <div class="nav">
            <a href="view_jobs.php">View Job Posts</a>
            <a href="my_applications.php">My Applications</a>
            <a href="messages.php">Messages</a>
        </div>
        <form method="POST" action="logout.php">
            <button type="submit" class="logout">Logout</button>
        </form>
        <br>
        <div class="dashboard-footer">
            &copy; 2024 FindHire. All rights reserved.
        </div>
    </div>
</body>
</html>
