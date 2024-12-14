<?php
session_start();
require_once 'core/config.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Handle new message submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['receiver_id'], $_POST['job_post_id'], $_POST['message'])) {
    $receiver_id = intval($_POST['receiver_id']);
    $job_post_id = intval($_POST['job_post_id']);
    $message = $conn->real_escape_string(trim($_POST['message']));

    if (!empty($message)) {
        $insertQuery = "
            INSERT INTO messages (sender_id, receiver_id, job_post_id, message) 
            VALUES ($user_id, $receiver_id, $job_post_id, '$message')
        ";
        $conn->query($insertQuery);
    }
}

// Fetch messages related to the user
$query = "
    SELECT m.id, m.message, m.sent_at, u.username AS sender_name, j.title AS job_title 
    FROM messages m 
    JOIN users u ON m.sender_id = u.id 
    JOIN job_posts j ON m.job_post_id = j.id 
    WHERE m.sender_id = $user_id OR m.receiver_id = $user_id
    ORDER BY m.sent_at DESC
";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
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

        .message-list {
            margin-top: 20px;
        }

        .message {
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .message .sender {
            font-weight: bold;
        }

        .message .time {
            font-size: 0.9em;
            color: #666;
        }

        .new-message-form {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-group button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
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
        <h1>Messages</h1>

        <div class="message-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='message'>";
                    echo "<div class='sender'>From: " . htmlspecialchars($row['sender_name']) . " (Job: " . htmlspecialchars($row['job_title']) . ")</div>";
                    echo "<div class='time'>Sent at: " . htmlspecialchars($row['sent_at']) . "</div>";
                    echo "<div class='content'>" . nl2br(htmlspecialchars($row['message'])) . "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No messages found.</p>";
            }
            ?>
        </div>

        <form method="POST" class="new-message-form">
            <div class="form-group">
                <label for="receiver_id">Send to:</label>
                <select name="receiver_id" id="receiver_id" required>
                    <?php
                    $usersQuery = "SELECT id, username FROM users WHERE id != $user_id";
                    $usersResult = $conn->query($usersQuery);

                    while ($user = $usersResult->fetch_assoc()) {
                        echo "<option value='" . intval($user['id']) . "'>" . htmlspecialchars($user['username']) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="job_post_id">Related Job:</label>
                <select name="job_post_id" id="job_post_id" required>
                    <?php
                    $jobsQuery = "SELECT id, title FROM job_posts";
                    $jobsResult = $conn->query($jobsQuery);

                    while ($job = $jobsResult->fetch_assoc()) {
                        echo "<option value='" . intval($job['id']) . "'>" . htmlspecialchars($job['title']) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea name="message" id="message" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <button type="submit">Send Message</button>
            </div>
        </form>

        <a href="hr.php" class="back-button">Back to Dashboard</a>
    </div>
</body>
</html>
