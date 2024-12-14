<?php
session_start();
require_once 'core/config.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Fetch the user's applications
$query = "
    SELECT a.id, a.status, j.title AS title, j.description AS job_description 
    FROM applications a 
    JOIN job_posts j ON a.job_post_id = j.id 
    WHERE a.applicant_id = $user_id
";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        .status {
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            text-align: center;
        }

        .status.Hired {
            background-color: #28a745;
        }

        .status.Rejected {
            background-color: #dc3545;
        }

        .status.Denied {
            background-color: #ffc107;
            color: black;
        }

        .status.Pending {
            background-color: #007bff;
        }

        .back-button {
            margin-top: 15px;
            background-color: #6c757d;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }

        .back-button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Applications</h1>

        <table>
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Job Description</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['job_description']) . "</td>";
                        echo "<td class='status " . htmlspecialchars($row['status']) . "'>" . htmlspecialchars($row['status']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>You have not applied for any jobs.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="applicant.php" class="back-button">Back to Dashboard</a>
    </div>
</body>
</html>
