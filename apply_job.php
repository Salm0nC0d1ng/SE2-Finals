<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'applicant') {
    header('Location: login.php');
    exit;
}

// Include database configuration
include 'core/config.php';

// Initialize variables
$job = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['job_id'])) {
        die('Invalid request. Job ID is missing.');
    }

    $job_id = intval($_POST['job_id']);
    $applicant_id = $_SESSION['user_id'];
    $cover_letter = mysqli_real_escape_string($conn, $_POST['cover_letter']);
    $resume = mysqli_real_escape_string($conn, $_POST['resume']);

    // Check if the applicant has already applied for the job
    $checkQuery = "SELECT id FROM applications WHERE job_post_id = $job_id AND applicant_id = $applicant_id";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        $error = "You have already applied for this job.";
    } else {
        // Insert application into the database
        $query = "INSERT INTO applications (applicant_id, job_post_id, resume, cover_letter, status, updated_at) 
                  VALUES ($applicant_id, $job_id, '$resume', '$cover_letter', 'Pending', NOW())";

        if ($conn->query($query) === TRUE) {
            $success = "Your application has been submitted successfully.";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
} else {
    if (!isset($_GET['job_id'])) {
        die('Invalid request. Job ID is missing.');
    }

    $job_id = intval($_GET['job_id']);

    // Fetch job details
    $jobQuery = "SELECT title, description FROM job_posts WHERE id = $job_id";
    $jobResult = $conn->query($jobQuery);

    if ($jobResult->num_rows > 0) {
        $job = $jobResult->fetch_assoc();
    } else {
        die('Job not found.');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job</title>
    <!-- CSS Styling (same as earlier) -->
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #343a40;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .navbar h1 {
            margin: 0;
            font-size: 20px;
        }

        .container {
            padding: 20px;
            margin: auto;
            max-width: 800px;
            background: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #343a40;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-button {
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            color: #007bff;
        }

        .back-button:hover {
            text-decoration: underline;
        }

        .message {
            text-align: center;
            margin-top: 20px;
        }

        .message.error {
            color: red;
        }

        .message.success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>FindHire - Apply for Job</h1>
    </div>

    <div class="container">
        <h2>Apply for Job</h2>

        <?php if (isset($error)): ?>
            <div class="message error"> <?php echo htmlspecialchars($error); ?> </div>
        <?php elseif (isset($success)): ?>
            <div class="message success"> <?php echo htmlspecialchars($success); ?> </div>
        <?php endif; ?>

        <?php if ($job): ?>
            <h3><?php echo htmlspecialchars($job['title']); ?></h3>
            <p><?php echo nl2br(htmlspecialchars($job['description'])); ?></p>

            <form method="POST">
                <label for="cover_letter">Cover Letter</label>
                <textarea name="cover_letter" id="cover_letter" rows="5" required></textarea>

                <label for="resume">Resume</label>
                <textarea name="resume" id="resume" rows="5" required></textarea>

                <input type="hidden" name="job_id" value="<?php echo $job_id; ?>" />

                <button type="submit">Submit Application</button>
            </form>
        <?php endif; ?>

        <a href="view_jobs.php" class="back-button">Back to Job Listings</a>
    </div>
</body>
</html>
