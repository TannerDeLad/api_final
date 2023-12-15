<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burger Simulator</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <?php
    include "functions.php";
    ?>
</head>

<body>
    <div id="burgerInfo"></div>
    <script>
        // Function to fetch stock data and update the DOM
        function getBurgerData() {
            axios.get('burgerapi.php')  // Adjust the URL as necessary
                .then(function (response) {
                    const burgers = response.data;
                    let html = '<ul>';
                    burgers.forEach(burger => {
                        html += `<li>${burger.Data}</li>`;
                    });
                    html += '</ul>';
                    document.getElementById('burgerInfo').innerHTML = html;
                })
                .catch(function (error) {
                    console.log("NOPE");
                });
        }
    </script>
    <?php

    $action = "home";
    if ($_POST) {
        $action = filter_input(INPUT_POST, "action");
    }
    if ($action === "register") {
        $firstname = filter_input(INPUT_POST, "fname");
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $apiKey = bin2hex(random_bytes(16));
        addUsertoDatabase($firstname, $email, $apiKey);
        echo "<h1> Thank you for registering for the API, " . $firstname . ", your API key is " . $apiKey;
    } else if ($action === "home") {
        echo "<h1> Register for an API key </h1>";
        include "createForm.php";
        echo "<h1> Use API Key below </h1>";
        include "APIform.php";
    } else if ($action === "API") {
        echo "<h1> Behold- the forbidden data </h1>";
        $firstname = filter_input(INPUT_POST, "fname");
        $apiKey = filter_input(INPUT_POST, "APIKey");
        //validate the key and user's email before allowing this script to run
        if (checkValidation($firstname, $apiKey)) {
            echo "<script>getBurgerData()</script>";
        } else {
            echo "Something is wrong - either the name or key is wrong";
        }

    } else {
        echo "<h1> Not catching anywhere </h1>";
    }
    ?>

</body>

</html>