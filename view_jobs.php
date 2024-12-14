<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'applicant') {
    header('Location: login.php');
    exit;
}

// Include database configuration
include 'core/config.php';

// Fetch all job posts
$query = "SELECT id, title, description, created_at FROM job_posts ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Job Posts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .job {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .job:last-child {
            border-bottom: none;
        }

        .job h2 {
            margin: 0 0 10px;
            font-size: 18px;
        }

        .job p {
            margin: 5px 0;
            color: #555;
        }

        .apply-button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .apply-button:hover {
            background-color: #0056b3;
        }

        .back-button {
            display: block;
            margin: 20px auto;
            padding: 10px;
            background-color: #6c757d;
            color: #fff;
            text-decoration: none;
            text-align: center;
            border-radius: 5px;
            max-width: 200px;
        }

        .back-button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Available Job Posts</h1>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="job">
                    <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                    <p><strong>Posted At:</strong> <?php echo htmlspecialchars($row['created_at']); ?></p>
                    <a href="apply_job.php?job_id=<?php echo $row['id']; ?>" class="apply-button">Apply Now</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No job posts available at the moment.</p>
        <?php endif; ?>
        <a href="applicant.php" class="back-button">Back to Dashboard</a>
    </div>
</body>
</html>
