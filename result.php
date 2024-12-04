<?php 
// Ensure user is logged in
if (!isset($_COOKIE['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch the final score
$score = isset($_COOKIE['score']) ? $_COOKIE['score'] : 0;

// Reset cookies for next quiz
setcookie("score", "", time() - 3600, "/");
setcookie("answered_questions", "", time() - 3600, "/");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        h1 {
            font-size: 3rem;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.5rem;
            margin-bottom: 30px;
            color: #333;
        }

        a {
            text-decoration: none;
            color: #fff;
            background-color: #4CAF50;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            margin: 0 10px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #45a049;
        }

        /* Container Styling */
        .result-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>
<body>

    <div class="result-container">
        <h1>Quiz Completed</h1>
        <p>Your final score is: <?php echo $score; ?></p>
        <a href="quiz.php">Try Again</a> | <a href="index.php">Home</a>
    </div>

</body>
</html>
