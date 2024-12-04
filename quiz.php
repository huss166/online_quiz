<?php
include 'db.php';

// Ensure user is logged in
if (!isset($_COOKIE['user_id'])) {
    header("Location: login.php");
    exit();
}

// Initialize score and answered questions if not set
if (!isset($_COOKIE['score'])) {
    setcookie("score", 0, time() + (86400 * 30), "/");
}

if (!isset($_COOKIE['answered_questions'])) {
    setcookie("answered_questions", json_encode([]), time() + (86400 * 30), "/");
}

// Decode the answered questions cookie
$answered_questions = json_decode($_COOKIE['answered_questions'], true);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selected_option = $_POST['answer'];
    $question_id = $_POST['question_id'];

    // Check if the answer is correct
    $sql = "SELECT correct_option FROM questions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $question_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $question = $result->fetch_assoc();

    if ($selected_option == $question['correct_option']) {
        setcookie("score", $_COOKIE['score'] + 1, time() + (86400 * 30), "/");
    }

    // Add the question ID to answered questions
    $answered_questions[] = $question_id;
    setcookie("answered_questions", json_encode($answered_questions), time() + (86400 * 30), "/");

    // Redirect to avoid resubmission
    header("Location: quiz.php");
    exit();
}

// Fetch the next unanswered question
$answered_ids = implode(",", $answered_questions) ?: "0"; // Default to "0" if no questions answered
$sql = "SELECT * FROM questions WHERE id NOT IN ($answered_ids) ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    // All questions are answered
    header("Location: result.php");
    exit();
}

$question = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            margin: 0;
            padding: 0;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        h1 {
            font-size: 2.8rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }

        /* Quiz Container */
        .quiz-container {
            background: rgba(0, 0, 0, 0.6);
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.4);
            width: 400px;
            text-align: left;
        }

        /* Question Styles */
        p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        /* Radio Buttons */
        input[type="radio"] {
            margin-right: 10px;
        }

        label {
            font-size: 1rem;
            display: block;
            margin-bottom: 10px;
        }

        /* Button Styles */
        button {
            padding: 12px 24px;
            border: none;
            background: #ff7e5f;
            color: #fff;
            font-size: 1.2rem;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #feb47b;
        }

        /* Score Display */
        .score {
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <h1>Quiz</h1>

    <div class="quiz-container">
        <form method="POST">
            <p><?php echo $question['question']; ?></p>

            <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">

            <label>
                <input type="radio" name="answer" value="1" required> <?php echo $question['option1']; ?>
            </label>
            <label>
                <input type="radio" name="answer" value="2" required> <?php echo $question['option2']; ?>
            </label>
            <label>
                <input type="radio" name="answer" value="3" required> <?php echo $question['option3']; ?>
            </label>
            <label>
                <input type="radio" name="answer" value="4" required> <?php echo $question['option4']; ?>
            </label>

            <button type="submit">Submit Answer</button>
        </form>

        <div class="score">
            Score: <?php echo $_COOKIE['score']; ?>
        </div>
    </div>

</body>
</html>
