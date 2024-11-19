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
            background: linear-gradient(180deg, #d16200,#a81c00, #313131); /* Gradient z ciemnej czerwieni do żółci */
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
        /*stopka*/
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #2F4F4F;
            color: white;
            text-align: center;
            padding: 4px 0;
            font-size: 0.9em;
            opacity: 0.6;
        }

        footer a {
            color: #45a049;
            text-decoration: none;
            font-weight: bold;
        }

        footer a:hover {
            text-decoration: underline;
        }
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
                echo "<td><a href='PlanLekcji.php?klasa=" . urlencode($row["Klasa"]) . "'>" . $row["Klasa"] . "</a></td>";
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
    <div class="button-container">
        <a href="index.html" class="button">Powrót</a>
    </div>
    <footer>
    <p>© 2024 Eruptor. | <a href="https://github.com/Oskarkozi/PlanLekcjiPraktyki">Open Source.</a></p>
    </footer>
</body>
</html>
