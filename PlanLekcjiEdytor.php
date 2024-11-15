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

// Pobieranie planu lekcji z bazy danych
$sql = "SELECT
            pl.Lekcja_id,
            pl.Numer_Lekcji,
            pl.Dzien,
            s.Numer_Sali,
            CONCAT(SUBSTRING(n.Imie, 1, 1), '. ', n.Nazwisko) AS Nauczyciel,
            n.Profesja
        FROM
            plan_lekcji pl
        LEFT JOIN sale s ON pl.Sala_id = s.Sala_id
        LEFT JOIN nauczyciele n ON pl.Nauczyciel_id = n.Nauczyciel_id
        WHERE pl.Klasa_id = (SELECT Klasa_id FROM klasy WHERE Klasa = '$klasa')
        ORDER BY pl.Dzien, pl.Numer_Lekcji";

$result = mysqli_query($conn, $sql);

$schedule = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $schedule[$row['Dzien']][$row['Numer_Lekcji']] = $row;
    }
}

// Pobranie listy sal, nauczycieli i profesji
$sale = mysqli_query($conn, "SELECT Sala_id, Numer_Sali FROM sale");
$nauczyciele = mysqli_query($conn, "SELECT Nauczyciel_id, CONCAT(Imie, ' ', Nazwisko) AS Nazwa FROM nauczyciele");
$profesje = mysqli_query($conn, "SELECT DISTINCT Profesja FROM nauczyciele");

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Plan Lekcji Edytor</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Plan Lekcji dla klasy <?php echo htmlspecialchars($klasa); ?> - Edytor</h1>
    <table>
        <tr>
            <th>Nr</th>
            <th>Godziny</th>
            <th>Poniedziałek</th>
            <th>Wtorek</th>
            <th>Środa</th>
            <th>Czwartek</th>
            <th>Piątek</th>
        </tr>

        <?php
        $times = ["08:00 - 08:45", "09:00 - 09:45", "10:00 - 10:45", "11:00 - 11:45", "12:00 - 12:45", "13:00 - 13:45", "14:00 - 14:45", "15:00 - 15:45", "16:00 - 16:45"];

        for ($i = 1; $i <= 9; $i++) {
            echo "<tr>";
            echo "<td>$i</td>";
            echo "<td>{$times[$i - 1]}</td>";

            for ($day = 1; $day <= 5; $day++) {
                echo "<td>";

                // Sprawdzanie, czy komórka ma przypisaną lekcję
                if (isset($schedule[$day][$i])) {
                    $lesson = $schedule[$day][$i];
                    echo "{$lesson['Numer_Sali']}<br>{$lesson['Nauczyciel']}<br>{$lesson['Profesja']}<br>";

                    // Przycisk "Usuń"
                    ?>
                    <form action="akcje.php" method="POST">
                        <input type="hidden" name="action" value="usun">
                        <input type="hidden" name="planlekcji_id" value="<?php echo $lesson['Lekcja_id']; ?>">
                        <button type="submit">Usuń</button>
                    </form>
                    <?php
                } else {
                    // Formularze edytowania danych, gdy komórka jest pusta
                    ?>
                    <form action="akcje.php" method="POST">
                        <input type="hidden" name="action" value="edytuj">
                        <input type="hidden" name="dzien" value="<?php echo $day; ?>">
                        <input type="hidden" name="numer_lekcji" value="<?php echo $i; ?>">
                        
                        <div>
                            <label for="sala">Sala:</label>
                            <select name="sala_id">
                                <?php while ($sala = mysqli_fetch_assoc($sale)) {
                                    echo "<option value='{$sala['Sala_id']}'>{$sala['Numer_Sali']}</option>";
                                } ?>
                            </select>
                        </div>

                        <div>
                            <label for="profesja">Przedmiot:</label>
                            <select name="profesja">
                                <?php while ($profesja = mysqli_fetch_assoc($profesje)) {
                                    echo "<option value='{$profesja['Profesja']}'>{$profesja['Profesja']}</option>";
                                } ?>
                            </select>
                        </div>

                        <div>
                            <label for="nauczyciel">Nauczyciel:</label>
                            <select name="nauczyciel_id">
                                <?php while ($nauczyciel = mysqli_fetch_assoc($nauczyciele)) {
                                    echo "<option value='{$nauczyciel['Nauczyciel_id']}'>{$nauczyciel['Nazwa']}</option>";
                                } ?>
                            </select>
                        </div>

                        <button type="submit">Zapisz</button>
                    </form>
                    <?php
                }

                echo "</td>";
            }

            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
