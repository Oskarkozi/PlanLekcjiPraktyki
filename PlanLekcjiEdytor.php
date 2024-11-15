<?php
session_start();

// Połączenie z bazą danych
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "dziennikdb";
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Pobierz klasę z parametru URL
$klasa = isset($_GET['klasa']) ? $_GET['klasa'] : '';

if (!$klasa) {
    die("Nie podano klasy.");
}

// Pobierz Klasa_id na podstawie nazwy klasy
$classQuery = mysqli_query($conn, "SELECT Klasa_id FROM klasy WHERE Klasa = '$klasa'");
$classData = mysqli_fetch_assoc($classQuery);
if (!$classData) {
    die("Nie znaleziono klasy.");
}
$klasaId = $classData['Klasa_id'];

// Jeśli formularz został przesłany, zaktualizuj plan lekcji
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $success = true;

    foreach ($_POST['schedule'] as $day => $lessons) {
        foreach ($lessons as $lessonNumber => $lessonData) {
            $roomId = !empty($lessonData['room']) ? (int)$lessonData['room'] : NULL;
            $teacherId = !empty($lessonData['teacher']) ? (int)$lessonData['teacher'] : NULL;

            if (!empty($roomId) || !empty($teacherId)) {
                // Sprawdzamy, czy istnieje lekcja w bazie
                $checkQuery = mysqli_query($conn, "SELECT * FROM plan_lekcji WHERE Dzien = $day AND Numer_Lekcji = $lessonNumber AND Klasa_id = $klasaId");
                
                if (mysqli_num_rows($checkQuery) > 0) {
                    // Jeśli lekcja już istnieje, zaktualizuj
                    $sql = "UPDATE plan_lekcji
                            SET Sala_id = $roomId,
                                Nauczyciel_id = $teacherId
                            WHERE Dzien = $day AND Numer_Lekcji = $lessonNumber AND Klasa_id = $klasaId";
                } else {
                    // Jeśli lekcja nie istnieje, dodaj nową
                    $sql = "INSERT INTO plan_lekcji (Dzien, Numer_Lekcji, Sala_id, Nauczyciel_id, Klasa_id)
                            VALUES ($day, $lessonNumber, $roomId, $teacherId, $klasaId)";
                }

                if (!mysqli_query($conn, $sql)) {
                    $success = false;
                    echo "<p style='color: red;'>Błąd podczas zapisywania: " . mysqli_error($conn) . "</p>";
                }
            }
        }
    }

    if ($success) {
        echo "<p style='color: green;'>Plan lekcji zapisany pomyślnie!</p>";
    }
}

// Pobierz dostępne sale i nauczycieli
$roomOptions = mysqli_query($conn, "SELECT Sala_id, Numer_Sali FROM sale");
$teacherOptions = mysqli_query($conn, "SELECT Nauczyciel_id, CONCAT(SUBSTRING(Imie, 1, 1), '. ', Nazwisko) AS Nauczyciel FROM nauczyciele");

// Przygotuj plan lekcji
$sql = "SELECT
            pl.Numer_Lekcji,
            pl.Dzien,
            s.Sala_id,
            n.Nauczyciel_id,
            s.Numer_Sali,
            CONCAT(SUBSTRING(n.Imie, 1, 1), '. ', n.Nazwisko) AS Nauczyciel,
            n.Profesja
        FROM
            plan_lekcji pl
        JOIN
            sale s ON pl.Sala_id = s.Sala_id
        JOIN
            nauczyciele n ON pl.Nauczyciel_id = n.Nauczyciel_id
        WHERE
            pl.Klasa_id = $klasaId
            AND pl.Dzien IN (1, 2, 3, 4, 5)
        ORDER BY
            pl.Dzien, pl.Numer_Lekcji";

$result = mysqli_query($conn, $sql);
$schedule = [1 => [], 2 => [], 3 => [], 4 => [], 5 => []];

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
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: center; border: 1px solid #ddd; }
        th { background-color: #f4b400; color: #fff; }
    </style>
</head>
<body>
    <h1>Plan Lekcji dla klasy <?php echo htmlspecialchars($klasa); ?> <b>Edytor</b></h1>

    <form method="post">
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
            $times = [
                "08:00 - 08:45", "09:00 - 09:45", "10:00 - 10:45",
                "11:00 - 11:45", "12:00 - 12:45", "13:00 - 13:45",
                "14:00 - 14:45", "15:00 - 15:45", "16:00 - 16:45"
            ];

            for ($i = 1; $i <= 9; $i++) {
                echo "<tr>";
                echo "<td class='nr'>$i</td>";
                echo "<td class='godz'>{$times[$i - 1]}</td>";

                for ($day = 1; $day <= 5; $day++) {
                    echo "<td class='dzien'>";

                    $roomId = $teacherId = "";
                    if (isset($schedule[$day][$i])) {
                        $lesson = $schedule[$day][$i];
                        $roomId = $lesson['Sala_id'];
                        $teacherId = $lesson['Nauczyciel_id'];
                    }

                    // Opcje sal
                    echo "<select name='schedule[$day][$i][room]'>";
                    echo "<option value=''>Sala</option>";
                    mysqli_data_seek($roomOptions, 0);
                    while ($room = mysqli_fetch_assoc($roomOptions)) {
                        $selected = $room['Sala_id'] == $roomId ? "selected" : "";
                        echo "<option value='{$room['Sala_id']}' $selected>{$room['Numer_Sali']}</option>";
                    }
                    echo "</select><br>";

                    // Opcje nauczycieli
                    echo "<select name='schedule[$day][$i][teacher]'>";
                    echo "<option value=''>Nauczyciel</option>";
                    mysqli_data_seek($teacherOptions, 0);
                    while ($teacher = mysqli_fetch_assoc($teacherOptions)) {
                        $selected = $teacher['Nauczyciel_id'] == $teacherId ? "selected" : "";
                        echo "<option value='{$teacher['Nauczyciel_id']}' $selected>{$teacher['Nauczyciel']}</option>";
                    }
                    echo "</select>";

                    echo "</td>";
                }

                echo "</tr>";
            }
            ?>
        </table>
        <button type="submit">Zapisz zmiany</button>
    </form>
</body>
</html>
