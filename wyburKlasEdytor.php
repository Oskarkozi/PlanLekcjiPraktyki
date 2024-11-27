<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wyświetlacz planu lekcji</title>
    <link rel="stylesheet" href="edytor.css">
    
</head>
<body>
    <?php
    // Zapytanie SQL do pobrania ID klasy i nazwy klasy
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "dziennikdb";
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

    if (!$conn) {
        echo "Brak połączenia";
    } else {
        // Pobranie klas
        $sql = "SELECT Klasa FROM klasy ORDER BY 
                CAST(SUBSTRING(Klasa, 1, LENGTH(Klasa) - 1) AS UNSIGNED) ASC, 
                SUBSTRING(Klasa, LENGTH(Klasa)) ASC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $klasy = [];
            
            // Grupowanie klas po numerze
            while ($row = mysqli_fetch_assoc($result)) {
                $prefix = preg_replace('/[^0-9]/', '', $row["Klasa"]); // Wyciągnięcie numeru klasy
                if (!isset($klasy[$prefix])) {
                    $klasy[$prefix] = [];
                }
                $klasy[$prefix][] = $row["Klasa"];
            }

            echo "<div class='table-container'>";
            echo "<table>";

            // Nagłówek tabeli
            echo "<tr><th colspan='" . max(array_map('count', $klasy)) . "'>Klasa</th></tr>";

            // Wyświetlanie grup klas w oddzielnych wierszach
            foreach ($klasy as $prefix => $group) {
                echo "<tr>";
                foreach ($group as $klasa) {
                    echo "<td><a href='PlanLekcjiEdytor.php?klasa=" . urlencode($klasa) . "'>" . $klasa . "</a></td>";
                }
                echo "</tr>";
            }

            echo "</table>";
            echo "</div>";
        } else {
            echo "Brak wyników.";
        }

        mysqli_close($conn);
    }
    ?>

    <!-- Kontener z przyciskiem powrotu -->
    <div class="button-container">
        <a href="../indexAdmina.php" class="button">Powrót</a>
    </div>
</body>
</html>  