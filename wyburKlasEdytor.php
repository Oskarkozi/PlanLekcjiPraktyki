<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_name'])) {
    header("Location: index.html");
    exit();
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wyświetlacz planu lekcji</title>
    <style>
        /* Gradient na całe tło strony */
        body {
            font-weight: bold;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(180deg, #800000, #ffcc00); /* Gradient z ciemnej czerwieni do żółci */
            color: #fff;
            min-height: 100vh; /* Upewnia się, że gradient pokrywa całe okno przeglądarki */
        }

        /* Styl tabeli */
        table {
            width: 80%; /* Zmniejszona szerokość tabeli dla lepszego wyglądu */
            border-collapse: collapse;
            margin: 20px auto; /* Wyśrodkowanie tabeli na stronie */
        }

        th {
            background-color: #800000; /* Ciemnoczerwony kolor tła nagłówków */
            color: #ffcc00; /* Żółty kolor tekstu */
            padding: 10px;
            text-align: center;
            font-weight: bold;
            border-bottom: 3px solid #ff4500; /* Pomarańczowa linia pod nagłówkiem */
        }

        td {
            background-color: #ffcc00; /* Żółty kolor tła komórek */
            color: #800000; /* Ciemnoczerwony kolor tekstu */
            padding: 10px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #800000; /* Ciemnoczerwone obramowanie komórek */
        }

        a {
            text-decoration: none;
            color: #800000; /* Ciemnoczerwony kolor tekstu linków */
        }

        a:hover {
            color: #ff4500; /* Pomarańczowy kolor po najechaniu myszką */
        }
        .button {
            flex: 1;
            padding: 20px;
            margin: 0 10px;
            font-size: 1.2em;
            color: white;
            background-color: #70562f;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s, transform 0.2s;
        }

        /* Efekt po najechaniu myszką */
        .button:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        /* Stylizacja focus */
        .button:focus {
            outline: 2px solid #fff;
            outline-offset: 4px;
        }
        
    </style>
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
            echo "<table>";
            echo "<tr><th colspan='" . mysqli_num_rows($result) . "'>Klasa</th></tr>"; // Wyśrodkowanie nagłówka
            echo "<tr>"; // Jeden wiersz na wszystkie klasy

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<td><a href='PlanLekcjiEdytor.php?klasa=" . urlencode($row["Klasa"]) . "'>" . $row["Klasa"] . "</a></td>";
            }
            echo "</tr>";
            echo "</table>";
        } else {
            echo "Brak wyników.";
        }

        // Zamknięcie połączenia z bazą danych
        mysqli_close($conn);
    }
    ?>
    <br>
        <div class="button-container">
        <a href="indexAdmina.php" class="button">powrót</a>
    </div>
</body>
</html>
