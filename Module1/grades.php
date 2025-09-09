<?php
// Define grade variable
$grade = 67;

// If statement
if ($grade >= 90) {
    echo "90-100 => A<br>";
} elseif ($grade >= 80) {
    echo "80-89 => B<br>";
}    elseif ($grade >= 70) {
    echo "70-79 => C<br>";
} else {
    echo "below 70 => Fail";
}
?>