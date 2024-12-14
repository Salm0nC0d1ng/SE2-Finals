<?php
require_once 'core/config.php';

// Handle Accept Application
if (isset($_GET['accept_id'])) {
    $application_id = intval($_GET['accept_id']);

    // Fetch application details
    $applicationQuery = "
        SELECT a.job_post_id, u.username 
        FROM applications a 
        JOIN users u ON a.applicant_id = u.id 
        WHERE a.id = $application_id";
    $applicationResult = $conn->query($applicationQuery);
    $application = $applicationResult->fetch_assoc();

    if (!$application) {
        die('Application not found.');
    }

    $job_id = $application['job_post_id'];
    $applicant_name = $application['username'];

    // Update job post with hired applicant
    $updateJobQuery = "UPDATE job_posts SET hired_applicant = '$applicant_name' WHERE id = $job_id";
    $conn->query($updateJobQuery);

    // Update application status
    $updateApplicationQuery = "UPDATE applications SET status = 'Hired' WHERE id = $application_id";
    $conn->query($updateApplicationQuery);

    // Reject other applications for the same job
    $rejectOthersQuery = "UPDATE applications SET status = 'Rejected' WHERE job_post_id = $job_id AND id != $application_id";
    $conn->query($rejectOthersQuery);

    header('Location: manage_applications.php');
    exit;
}

// Handle Deny Application
if (isset($_GET['deny_id'])) {
    $application_id = intval($_GET['deny_id']);

    // Update application status to Denied
    $updateApplicationQuery = "UPDATE applications SET status = 'Denied' WHERE id = $application_id";
    $conn->query($updateApplicationQuery);

    header('Location: manage_applications.php');
    exit;
}

// Fetch job applications from the database
$query = "
    SELECT a.id, a.status, u.username AS applicant_name, j.title AS job_title 
    FROM applications a 
    JOIN users u ON a.applicant_id = u.id 
    JOIN job_posts j ON a.job_post_id = j.id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Applications</title>
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

        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn.deny {
            background-color: #dc3545;
        }

        .btn.deny:hover {
            background-color: #c82333;
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
        <h1>Manage Applications</h1>

        <table>
            <thead>
                <tr>
                    <th>Applicant Name</th>
                    <th>Job Title</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['applicant_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['job_title']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                        echo "<td>";

                        if ($row['status'] !== 'Hired' && $row['status'] !== 'Denied') {
                            echo "<a href='manage_applications.php?accept_id=" . $row['id'] . "' class='btn'>Accept</a> ";
                            echo "<a href='manage_applications.php?deny_id=" . $row['id'] . "' class='btn deny'>Deny</a>";
                        }

                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No applications found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="hr.php" class="back-button">Back to Dashboard</a>
    </div>
</body>
</html>
