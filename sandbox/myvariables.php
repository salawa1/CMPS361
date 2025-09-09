<?php
    // var car = "toyota";
    $vehicle = "toyota";
    $ageOfVehicle = 7;
    $costOfVehicle = 23456.99;
    $makeOfVehicle = "Tundra";

    // Density of a liquid
    $startingGravity = 1.110;
    $finalGravity = 0.99;

        // Conditional Statement
        if ($finalGravity <= 0.99) {
            echo "Fermentation is completed <br>";
        } elseif ($finalGravity >= 1.020) {
            echo "Fermentation is not completed <br>";
        } else {
            echo "We need to add a nutrient to push the fermentation <br>";
        }

    // Loop stuff
    for ($i = 1; $i <= 20; $i++){
        echo "The loop starts here $i <br>";
    }

    // Save work orders
    $startingNumber = 34;
    $endingNumber = 99;
    $sumOfAllNumbers = $startingNumber + $endingNumber;

    // echo $sumOfAllNumbers;

    // echo "My Vehicle that I own is a $vehicle";


?>
<html>
    <head>
        <title>Sandbox Class</title>
        <h1>Fermentation Status</h1>
    </head>
</html>