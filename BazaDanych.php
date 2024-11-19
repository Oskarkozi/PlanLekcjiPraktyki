<?php
// Database connection
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "dziennikdb";
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if (!$conn) {
    echo "Brak połączenia";
} else {
    // Get classes from the database
    $sql = "SELECT Klasa FROM klasy ORDER BY 
            CAST(SUBSTRING(Klasa, 1, LENGTH(Klasa) - 1) AS UNSIGNED) ASC, 
            SUBSTRING(Klasa, LENGTH(Klasa)) ASC";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th colspan='" . mysqli_num_rows($result) . "'>Klasa</th></tr>";
        echo "<tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<td><a href='PlanLekcji.php?klasa=" . urlencode($row["Klasa"]) . "'>" . $row["Klasa"] . "</a></td>";
        }
        echo "</tr>";
        echo "</table>";
    } else {
        echo "Brak wyników.";
    }

    // Close the connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wybór klasy</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="button-container">
        <a href="index.html" class="button">Powrót</a>
    </div>
</body>
</html>
