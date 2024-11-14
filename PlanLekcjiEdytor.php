<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_name'])) {
    header("Location: index.html");
    exit();
}

// Połączenie z bazą danych
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "dziennikdb";
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Brak połączenia: " . mysqli_connect_error());
}

// Pobierz klasę z parametru URL
$klasa = isset($_GET['klasa']) ? $_GET['klasa'] : '';

// Pobieranie planu lekcji dla wybranej klasy na wszystkie dni tygodnia
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

// Inicjalizacja tablicy na plan lekcji
$schedule = [
    1 => [], // poniedziałek
    2 => [], // wtorek
    3 => [], // środa
    4 => [], // czwartek
    5 => [], // piątek
];

// Przechowywanie wyników w tablicy asocjacyjnej wg dnia i numeru lekcji
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
</head>
<body>
    <h1>Plan Lekcji dla klasy <?php echo htmlspecialchars($klasa); ?> <b>Edytor</b></h1>

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
        // Definicja godzin lekcyjnych
        $times = [
            "08:00 - 08:45", "09:00 - 09:45", "10:00 - 10:45",
            "11:00 - 11:45", "12:00 - 12:45", "13:00 - 13:45",
            "14:00 - 14:45", "15:00 - 15:45", "16:00 - 16:45"
        ];

        for ($i = 1; $i <= 9; $i++) {
            echo "<tr>";
            echo "<td class='nr'>$i</td>";
            echo "<td class='godz'>{$times[$i - 1]}</td>";

            // Iteracja przez dni tygodnia (1 do 5)
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
</body>
</html>
