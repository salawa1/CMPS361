<!-- Form Submission -->
<html>
    <head>
        <title>Form Submission</title>
        <body>
            <form method="post">
                Enter your name: <input type="text" name="username"><br><br>
                Enter your age: <input type="text" name="age"><br><br>
                <input type="submit" value="Submit">
            </form>
        </body>
</html>

<?php
    if (($_SERVER["REQUEST_METHOD"]) == "POST") {
        $user = $_POST['username'];
        $age = $_POST['age'];
        echo "Hello, $user! You are $age years old";
    }
?>