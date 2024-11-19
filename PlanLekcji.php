<?php
// Database connection
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "dziennikdb";
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Brak połączenia: " . mysqli_connect_error());
}

// Get class from URL (e.g., "3a")
$klasa = isset($_GET['klasa']) ? $_GET['klasa'] : '';

// Fetch schedule for the given class for all days of the week
$sql = "SELECT
            pl.Numer_Lekcji,
            pl.Dzien,
            s.Numer_Sali,
            CONCAT(SUBSTRING(n.Imie, 1, 1), '. ', n.Nazwisko) AS Nauczyciel,
            n.Profesja
        FROM
            plan_lekcji pl
        JOIN
            klasy k ON pl.Klasa_id = k.Klasa_id
        JOIN
            sale s ON pl.Sala_id = s.Sala_id
        JOIN
            nauczyciele n ON pl.Nauczyciel_id = n.Nauczyciel_id
        WHERE
            k.Klasa = '$klasa'
            AND pl.Dzien IN (1, 2, 3, 4, 5)
        ORDER BY
            pl.Dzien, pl.Numer_Lekcji";

$result = mysqli_query($conn, $sql);

// Initialize array to store schedule
$schedule = [
    1 => [], // Monday
    2 => [], // Tuesday
    3 => [], // Wednesday
    4 => [], // Thursday
    5 => [], // Friday
];

// Store results in associative array by day and lesson number
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $schedule[$row['Dzien']][$row['Numer_Lekcji']] = $row;
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Lekcji</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
    <style>
        /* Styl przycisku */
        .button-container {
            margin-top: 30px;
            text-align: center;
            width: 100%;
        }

        .button {
            display: inline-block;
            padding: 15px 30px;
            font-size: 1.2em;
            color: white;
            background-color: #800000;
            border: solid;
            border-style: solid;
            border-width: 5px;
            border-radius: 8px;
            border-color: #ffcc00;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s, transform 0.2s;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        }

        .button:hover {
            color: yellow;
            transform: scale(1.1);
            box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.3);
        }

        .button:focus {
            outline: 2px solid #fff;
            outline-offset: 4px;
        }
    </style>
</head>
<body>
    <h1>Plan Lekcji dla klasy <?php echo htmlspecialchars($klasa); ?></h1>

    <table>
        <tr>
            <th class="nr">nr</th>
            <th class="godz">godz</th>
            <th class="dzien">poniedziałek</th>
            <th class="dzien">wtorek</th>
            <th class="dzien">środa</th>
            <th class="dzien">czwartek</th>
            <th class="dzien">piątek</th>
        </tr>

        <?php
        // Define lesson times
        $times = [
            "08:00 - 08:45", "09:00 - 09:45", "10:00 - 10:45",
            "11:00 - 11:45", "12:00 - 12:45", "13:00 - 13:45",
            "14:00 - 14:45", "15:00 - 15:45", "16:00 - 16:45"
        ];

        for ($i = 1; $i <= 9; $i++) {
            echo "<tr>";
            echo "<td class='nr'>$i</td>";
            echo "<td class='godz'>{$times[$i - 1]}</td>";

            // Loop through all days of the week (1 to 5)
            for ($day = 1; $day <= 5; $day++) {
                if (isset($schedule[$day][$i])) {
                    $lesson = $schedule[$day][$i];
                    echo "<td class='dzien'>{$lesson['Numer_Sali']}<br>{$lesson['Nauczyciel']}<br>{$lesson['Profesja']}</td>";
                } else {
                    echo "<td class='dzien'></td>";
                }
            }

            echo "</tr>";
        }

        ?>
    </table>
    <div class="button-container">
        <a href="BazaDanych.php" class="button">Powrót</a>
    </div>
</body>
</html>
