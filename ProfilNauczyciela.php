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

// Get teacher ID from URL (e.g., "nauczyciel_id=1")
$nauczyciel_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;


// Fetch schedule for the given teacher for all days of the week
$sql = "SELECT
            pl.Numer_Lekcji,
            pl.Dzien,
            s.Numer_Sali,
            k.Klasa,
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
            pl.Nauczyciel_id = '$nauczyciel_id'
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
    <title>Plan Lekcji dla Nauczyciela</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="page-plan">
    <h1>Plan Lekcji dla nauczyciela</h1>

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
                    echo "<td class='dzien'>{$lesson['Klasa']}<br>{$lesson['Numer_Sali']}<br>{$lesson['Profesja']}</td>";
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
