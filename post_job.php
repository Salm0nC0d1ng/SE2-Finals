<?php
require_once 'core/config.php';

// Handle job posting form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $query = "INSERT INTO job_posts (title, description, created_at) VALUES ('$title', '$description', NOW())";

    if ($conn->query($query) === TRUE) {
        $success = "Job post created successfully.";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
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

        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-button {
            margin-top: 15px;
            background-color: #6c757d;
        }

        .back-button:hover {
            background-color: #5a6268;
        }

        p {
            text-align: center;
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Post a Job</h1>

        <?php
        if (isset($success)) {
            echo "<p>$success</p>";
        }
        if (isset($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>

        <form method="POST" action="">
            <label for="title">Job Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Job Description:</label>
            <textarea id="description" name="description" rows="5" required></textarea>

            <button type="submit">Post Job</button>
        </form>

        <a href="hr.php"><button class="back-button">Back to Dashboard</button></a>
    </div>
</body>
</html>
