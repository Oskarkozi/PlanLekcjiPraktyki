<?php
// Database connection
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "dziennikdb";
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
mysqli_set_charset($conn, "utf8mb4");
if (!$conn) {
    echo "Brak połączenia";
    exit();
}

// Sprawdzanie szczęśliwego numerka
$today = date("Y-m-d"); // Dzisiejsza data
$lucky_number = null;

// Sprawdź, czy numerek dla dzisiejszej daty jest już w bazie
$sql_check = "SELECT lucky_number FROM szczensliwy_numer WHERE date = ?";
$stmt = mysqli_prepare($conn, $sql_check);
mysqli_stmt_bind_param($stmt, "s", $today);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $lucky_number);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Jeśli numerka nie ma, wylosuj i zapisz go w bazie
if ($lucky_number === null) {
    $lucky_number = mt_rand(1, 32); // Losowy numerek od 1 do 32

    $sql_insert = "INSERT INTO szczensliwy_numer (date, lucky_number) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql_insert);
    mysqli_stmt_bind_param($stmt, "si", $today, $lucky_number);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Pobieranie klas z bazy danych
$sql_classes = "SELECT Klasa FROM klasy ORDER BY 
                CAST(SUBSTRING(Klasa, 1, LENGTH(Klasa) - 1) AS UNSIGNED) ASC, 
                SUBSTRING(Klasa, LENGTH(Klasa)) ASC";
$result_classes = mysqli_query($conn, $sql_classes);

// Pobieranie nauczycieli z bazy danych
$sql_teachers = "SELECT Nauczyciel_id, Imie, Nazwisko FROM nauczyciele ORDER BY Nazwisko ASC";
$result_teachers = mysqli_query($conn, $sql_teachers);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wybór klasy i nauczyciela</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .lucky-number-container {
            text-align: center;
            margin: 20px auto;
            padding: 15px;
            background-color: #ffcc00;
            border-radius: 10px;
            color: #800000;
            font-weight: bold;
            font-size: 1.5em;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            width: 50%;
        }

        /* Stylizacja dla formularza wyboru nauczyciela */
.form-container {
    text-align: center;
    margin: 20px auto;
    padding: 20px;
    background-color: #ffcc00; /* Żółte tło pasujące do kolorystyki */
    border: 1px solid #800000; /* Bordowa ramka */
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); /* Delikatny cień */
    width: 50%;
}

/* Stylizacja dla tekstu i etykiety */
.form-container label {
    font-size: 1.2em;
    font-weight: bold;
    color: #800000; /* Bordowy kolor tekstu */
    margin-right: 10px;
}

/* Stylizacja dla listy rozwijanej */
.form-container select {
    font-size: 1em;
    padding: 10px;
    border: 2px solid #800000; /* Bordowa ramka */
    border-radius: 5px;
    background-color: #ffffff; /* Białe tło */
    color: #800000; /* Bordowy tekst */
    font-weight: bold;
    width: 60%;
    margin-bottom: 10px;
}

/* Efekt po najechaniu na listę */
.form-container select:hover {
    background-color: #ffe680; /* Jaśniejszy żółty */
    cursor: pointer;
}

/* Stylizacja dla przycisku */
.form-container button {
    font-size: 1.1em;
    padding: 10px 20px;
    background-color: #800000; 
    color: #ffcc00; 
    border: 2px solid #800000; 
    border-radius: 5px;
    font-weight: bold;
    text-transform: uppercase;
    transition: background-color 0.3s ease, color 0.3s ease;
}

/* Efekt po najechaniu na przycisk */
.form-container button:hover {
    background-color: #ffe680; /* Jaśniejszy żółty na hover */
    color: #a00000; /* Ciemniejszy bordowy tekst */
    cursor: pointer;
}

/* Stylizacja dla kontenera przycisku powrotu */
.button-container a.button {
    display: inline-block;
    text-align: center;
    padding: 10px 20px;
    background-color: #800000; /* Bordowe tło */
    color: #ffffff; /* Biały tekst */
    text-decoration: none;
    font-weight: bold;
    border-radius: 5px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); /* Delikatny cień */
    transition: background-color 0.3s ease;
}

/* Efekt po najechaniu na przycisk powrotu */
.button-container a.button:hover {
    background-color: #a00000; /* Jaśniejszy bordowy */
}

    </style>
</head>
<body>

<?php 
//Sekcja tabeli z klasami
if ($result_classes && mysqli_num_rows($result_classes) > 0): ?>
    <table style="border-collapse: collapse; width: 80%; margin: 20px auto; background-color: #ffcc00;">
        <tr style="background-color: #800000; color: white;">
            <th colspan="4" style="padding: 10px;">KLASA</th>
        </tr>
        <?php 
        $counter = 0;
        $columns_per_row = 4; // Liczba kolumn w jednym wierszu
        ?>
        <tr>
        <?php while ($row = mysqli_fetch_assoc($result_classes)): ?>
            <td style="border: 1px solid #800000; text-align: center; padding: 10px;">
                <a href="PlanLekcji.php?klasa=<?php echo urlencode($row['Klasa']); ?>" style="text-decoration: none; color: #800000; font-weight: bold;">
                    <?php echo $row['Klasa']; ?>
                </a>
            </td>
            <?php 
            $counter++;
            if ($counter % $columns_per_row == 0): // Nowy wiersz po n kolumnach
            ?>
        </tr><tr>
            <?php endif; ?>
        <?php endwhile; ?>
        <?php 
        // Jeśli pozostały puste komórki, wypełnij je
        while ($counter % $columns_per_row != 0): 
        ?>
            <td style="border: 1px solid #800000; text-align: center; padding: 10px;"></td>
            <?php $counter++; ?>
        <?php endwhile; ?>
        </tr>
    </table>
<?php else: ?>
    <p>Brak wyników.</p>
<?php endif; ?>

    <!-- Sekcja listy wyboru nauczyciela -->
    <?php if ($result_teachers && mysqli_num_rows($result_teachers) > 0): ?>
    <div class="form-container">
        <form action="ProfilNauczyciela.php" method="GET">
            <label for="nauczyciel">Wybierz nauczyciela:</label>
            <select name="id" id="nauczyciel"> <!-- Zmieniamy nazwę pola na zgodną z URL -->
                <?php while ($teacher = mysqli_fetch_assoc($result_teachers)): ?>
                    <option value="<?php echo $teacher['Nauczyciel_id']; ?>">
                        <?php echo $teacher['Imie'] . ' ' . $teacher['Nazwisko']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Pokaż plan</button>
        </form>
    </div>
<?php else: ?>
    <p>Brak nauczycieli w bazie.</p>
<?php endif; ?>


    <!-- Sekcja szczęśliwego numerka -->
    <div class="lucky-number-container">
        Szczęśliwy numerek na dziś (<?php echo $today; ?>): <span><?php echo $lucky_number; ?></span>
    </div>

    <!-- Sekcja przycisku powrotu -->
    <div class="button-container">
        <a href="index.html" class="button">Powrót</a>
    </div>
</body>
</html>

<?php
// Zamknięcie połączenia
mysqli_close($conn);
?>
