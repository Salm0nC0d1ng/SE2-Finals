<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .dashboard-header {
            width: 100%;
            background-color: #fff;
            padding: 15px 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            text-align: center;
        }

        .dashboard-header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .dashboard-content {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
        }

        .dashboard-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px;
            width: 300px;
            text-align: center;
        }

        .dashboard-card h2 {
            font-size: 18px;
            color: #555;
        }

        .dashboard-card button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .dashboard-card button:hover {
            background-color: #0056b3;
        }

        .dashboard-footer {
            margin-top: 20px;
            text-align: center;
            color: #777;
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
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>HR Dashboard</h1>
        </div>

        <div class="dashboard-content">
            <div class="dashboard-card">
                <h2>Post a Job</h2>
                <p>Create and publish job postings.</p>
                <button onclick="location.href='post_job.php';">Go</button>
            </div>

            <div class="dashboard-card">
                <h2>Manage Applications</h2>
                <p>Review, accept, or reject applications.</p>
                <button onclick="location.href='manage_applications.php';">Go</button>
            </div>

            <div class="dashboard-card">
                <h2>Messages</h2>
                <p>View and respond to applicant messages.</p>
                <button onclick="location.href='hmessages.php';">Go</button>
            </div>
        </div>
        <form method="POST" action="logout.php">
            <button type="submit" class="logout">Logout</button>
        </form>

        <div class="dashboard-footer">
            &copy; 2024 FindHire. All rights reserved.
        </div>
    </div>
</body>
</html>
