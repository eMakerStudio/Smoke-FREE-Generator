<?php
/** * Program Name: Affiliate Program Finder Tool 
* Author: Barbara Hohensee
* Version: 1.0.0 
* Last Updated: 2024-12-09 
* Description: 
* The Smoke-Free Calculator helps users track the time, money, and health benefits gained since quitting smoking. 
* It provides insights into progress and motivates users to maintain a smoke-free lifestyle. */ // 


$resultVisible = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultVisible = true; // Show the result container when form is submitted

    // Get inputs from the form
    $name = htmlspecialchars($_POST['name']); // Sanitize the user input
    $quitDate = $_POST['quit_date'];
    $cigarettesPerDay = (int) $_POST['cigarettes_per_day'];
    $pricePerPack = (float) $_POST['price_per_pack'];
    $cigarettesPerPack = (int) $_POST['cigarettes_per_pack'];

    // Calculate days and years since quitting
    $quitDateTime = new DateTime($quitDate);
    $currentDateTime = new DateTime();
    $interval = $quitDateTime->diff($currentDateTime);
    $daysSmokeFree = $interval->days;
    $yearsSmokeFree = $interval->y; // Number of complete years

    // Calculate total cigarettes avoided
    $totalCigarettesAvoided = $cigarettesPerDay * $daysSmokeFree;

    // Calculate money saved
    $costPerCigarette = $pricePerPack / $cigarettesPerPack;
    $moneySaved = $totalCigarettesAvoided * $costPerCigarette;

    // Prepare the results HTML
    $resultHTML = "
        <div class='results'>
            <h2>Congratulations, $name!</h2>
            <p><strong>$yearsSmokeFree years smoke-free!</strong></p>
            <p>You have been smoke-free for <strong>$daysSmokeFree days</strong>.</p>
            <p>You have avoided smoking <strong>$totalCigarettesAvoided cigarettes</strong>.</p>
            <p>You have saved <strong>$" . number_format($moneySaved, 2) . "</strong>.</p>
            <a href='https://etsy.com' class='purchase-button' target='_blank'>Get Your Personalized Mug</a>
            <div class='mug-image'>
                <img src='smoke-free.png' alt='Personalized Smoke-Free Mug'>
            </div>
        </div>
    ";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="author" content="Barbara Hohensee">
    <meta name="version" content="1.0.0">
    <meta name="last-updated" content="2024-12-09">

    <title>Smoke-Free Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            box-sizing: border-box;
            margin: 10px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333333;
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555555;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #dddddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        form button:hover {
            background-color: #45a049;
        }

        .results {
            background-color: #e8f5e9;
            border: 1px solid #c8e6c9;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 300px;
            box-sizing: border-box;
            margin: 10px;
        }

        .results h2 {
            color: #388e3c;
            margin-bottom: 10px;
        }

        .results p {
            font-size: 16px;
            color: #333333;
            margin: 5px 0;
        }

        .purchase-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            text-decoration: none; /* Remove underline from link */
        }

        .purchase-button:hover {
            background-color: #0056b3;
        }

        .mug-image img {
            margin-top: 20px;
            max-width: 80%; /* Set the image to 80% of its container */
            border-radius: 5px;
        }

        .wrapper {
            display: flex;
            flex-direction: <?php echo $resultVisible ? 'row' : 'column'; ?>;
            justify-content: center;
            align-items: center;
            gap: 20px; /* Space between the calculator and results */
        }
    </style>
</head>
<body style="background-image: url('background.png'); background-size: cover; background-position: center;">
    <div class="wrapper">
        <div class="container">
            <h1>Smoke-Free Calculator</h1>
            <form method="post" action="">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="quit_date">Quit Date:</label>
                <input type="date" id="quit_date" name="quit_date" required>

                <label for="cigarettes_per_day">Cigarettes Smoked Per Day:</label>
                <input type="number" id="cigarettes_per_day" name="cigarettes_per_day" required>

                <label for="price_per_pack">Price Per Pack (in $):</label>
                <input type="number" step="0.01" id="price_per_pack" name="price_per_pack" required>

                <label for="cigarettes_per_pack">Cigarettes Per Pack:</label>
                <input type="number" id="cigarettes_per_pack" name="cigarettes_per_pack" required>

                <button type="submit">Calculate</button>
            </form>
        </div>
        <?php
        // Display the results if the form is submitted
        if ($resultVisible) {
            echo $resultHTML;
        }
        ?>
    </div>
</body>
</html>
