<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz App</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom right, #4a90e2, #9013fe);
            margin: 0;
            padding: 0;
            color: #fff;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        
        a {
            text-decoration: none;
            color: #fff;
            font-size: 1.2rem;
            padding: 10px 20px;
            margin: 0 10px;
            border: 2px solid #fff;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
        }

        a:hover {
            background-color: #fff;
            color: #4a90e2;
            transform: scale(1.1);
        }

        
        footer {
            position: absolute;
            bottom: 10px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <h1>ONLINE QUIZ</h1>
    <a href="register.php">Register</a> | 
    <a href="login.php">Login</a> | 
    <a href="admin.php">Admin Login</a>

    <footer>© 2024 Quiz App. All Rights Reserved.</footer>
</body>
</html>
