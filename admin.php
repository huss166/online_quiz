<?php 
include 'db.php';

// Logout functionality
if (isset($_POST['logout'])) {
    // Destroy session or unset cookies to log out the admin
    setcookie("user_id", "", time() - 3600, "/");
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_question'])) {
        $question = $_POST['question'];
        $option1 = $_POST['option1'];
        $option2 = $_POST['option2'];
        $option3 = $_POST['option3'];
        $option4 = $_POST['option4'];
        $correct = $_POST['correct'];

        $sql = "INSERT INTO questions (question, option1, option2, option3, option4, correct_option) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $question, $option1, $option2, $option3, $option4, $correct);
        $stmt->execute();
    }

    if (isset($_POST['delete_question'])) {
        $id = $_POST['question_id'];

        $sql = "DELETE FROM questions WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        h1 {
            font-size: 2.5rem;
            color: #4CAF50;
            margin-bottom: 20px;
            text-align: center;
        }

        h2 {
            font-size: 1.8rem;
            color: #ff5722;
            margin-top: 40px;
        }

        /* Form Styling */
        .admin-panel {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: left;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Space between forms */
        .form-container {
            margin-bottom: 40px;
        }

        .logout-button {
            background-color: #f44336;
            margin-top: 20px;
            width: auto;
            padding: 10px;
            text-align: center;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            border-radius: 5px;
        }

        .logout-button:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>

    <div class="admin-panel">
        <h1>Admin Panel</h1>
        
        <!-- Add Question Form -->
        <div class="form-container">
            <h2>Add Question</h2>
            <form method="POST">
                <input type="text" name="question" placeholder="Question" required><br>
                <input type="text" name="option1" placeholder="Option 1" required><br>
                <input type="text" name="option2" placeholder="Option 2" required><br>
                <input type="text" name="option3" placeholder="Option 3" required><br>
                <input type="text" name="option4" placeholder="Option 4" required><br>
                <input type="number" name="correct" placeholder="Correct Option (1-4)" required><br>
                <button type="submit" name="add_question">Add Question</button>
            </form>
        </div>

        <!-- Delete Question Form -->
        <div class="form-container">
            <h2>Delete Question</h2>
            <form method="POST">
                <input type="number" name="question_id" placeholder="Question ID" required><br>
                <button type="submit" name="delete_question">Delete Question</button>
            </form>
        </div>

        <!-- Logout Button -->
        <form method="POST">
            <button type="submit" name="logout" class="logout-button">Logout</button>
        </form>
    </div>

</body>
</html>
