<!-- Form Submission -->
<html>
    <head>
        <title>Quiz</title>
        <body>
            <form method="post">
                Enter a number: <input type="value" name="number"><br><br>
                <input type="submit" value="Submit">
            </form>
        </body>
</html>

<?php
// PHP code
if (($_SERVER["REQUEST_METHOD"]) == "POST") {
    $number = $_POST['number'];
    if ($number % 2 == 0) {
        echo "<br>$number is an even number";
    } else {
        echo "<br>$number is an odd number";
    }
}
?>
