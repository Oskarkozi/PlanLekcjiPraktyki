<?php
// Database connection
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "dziennikdb";
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

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
$result = mysqli_query($conn, $sql_classes);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wybór klasy</title>
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
    </style>
</head>
<body>
    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <table>
            <tr>
                <th colspan="<?php echo mysqli_num_rows($result); ?>">Klasa</th>
            </tr>
            <tr>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <td><a href="PlanLekcji.php?klasa=<?php echo urlencode($row['Klasa']); ?>"><?php echo $row['Klasa']; ?></a></td>
                <?php endwhile; ?>
            </tr>
        </table>
    <?php else: ?>
        <p>Brak wyników.</p>
    <?php endif; ?>

    <div class="lucky-number-container">
        Szczęśliwy numerek na dziś (<?php echo $today; ?>): <span><?php echo $lucky_number; ?></span>
    </div>

    <div class="button-container">
        <a href="index.html" class="button">Powrót</a>
    </div>
</body>
</html>

<?php
// Close the connection
mysqli_close($conn);
?>
