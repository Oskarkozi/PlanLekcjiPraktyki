<?php
// Ustawienie daty ostatniej edycji w ciasteczku
setcookie('last_edit_date', date('Y-m-d H:i:s'), time() + 3600 * 24 * 30, '/'); // Ciasteczko ważne przez 30 dni

// Konfiguracja bazy danych
$host = "localhost";
$username = "root";
$password = "";
$dbname = "dziennikdb";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Akcja CRUD
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

if ($action == 'list') {
    // LIST - Wyświetlanie wszystkich nauczycieli
    $sql = "SELECT * FROM nauczyciele";
    $result = $conn->query($sql);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <link rel="stylesheet" href="crud.css">
        <title>Lista nauczycieli</title>
    </head>
    <body>
        <h1>Lista nauczycieli</h1>
        <a href="?action=create">Dodaj nowego nauczyciela</a><br><a href="crud.php">Powrót do wyboru tabel</a>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Profesja</th>
                <th>Akcje</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['Nauczyciel_id']; ?></td>
                    <td><?php echo $row['Imie']; ?></td>
                    <td><?php echo $row['Nazwisko']; ?></td>
                    <td><?php echo $row['Profesja']; ?></td>
                    <td>
                        <a href="?action=edit&id=<?php echo $row['Nauczyciel_id']; ?>">Edytuj</a> |
                        <a href="?action=delete&id=<?php echo $row['Nauczyciel_id']; ?>">Usuń</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </body>
    </html>
    <?php
} elseif ($action == 'create') {
    // CREATE - Dodawanie nowego nauczyciela
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $imie = $_POST['imie'];
        $nazwisko = $_POST['nazwisko'];
        $profesja = $_POST['profesja'];
        $sql = "INSERT INTO nauczyciele (Imie, Nazwisko, Profesja) VALUES ('$imie', '$nazwisko', '$profesja')";

        if ($conn->query($sql)) {
            header("Location: ?action=list");
        } else {
            echo "Błąd: " . $conn->error;
        }
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Dodaj nauczyciela</title>
        <link rel="stylesheet" href="crud.css">

    </head>
    <body>
        <h1>Dodaj nauczyciela</h1>
        <form method="POST">
            <label>Imię:</label>
            <input type="text" name="imie" required>
            <br>
            <label>Nazwisko:</label>
            <input type="text" name="nazwisko" required>
            <br>
            <label>Profesja:</label>
            <input type="text" name="profesja" required>
            <br>
            <button type="submit">Dodaj</button>
        </form>
        <a href="?action=list">Powrót do listy</a>
    </body>
    </html>
    <?php
} elseif ($action == 'edit') {
    // EDIT - Edycja nauczyciela
    $id = $_GET['id'];
    $sql = "SELECT * FROM nauczyciele WHERE Nauczyciel_id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $imie = $_POST['imie'];
        $nazwisko = $_POST['nazwisko'];
        $profesja = $_POST['profesja'];
        $sql = "UPDATE nauczyciele SET Imie = '$imie', Nazwisko = '$nazwisko', Profesja = '$profesja' WHERE Nauczyciel_id = $id";

        if ($conn->query($sql)) {
            header("Location: ?action=list");
        } else {
            echo "Błąd: " . $conn->error;
        }
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <link rel="stylesheet" href="crud.css">

        <title>Edytuj nauczyciela</title>
    </head>
    <body>
        <h1>Edytuj nauczyciela</h1>
        <form method="POST">
            <label>Imię:</label>
            <input type="text" name="imie" value="<?php echo $row['Imie']; ?>" required>
            <br>
            <label>Nazwisko:</label>
            <input type="text" name="nazwisko" value="<?php echo $row['Nazwisko']; ?>" required>
            <br>
            <label>Profesja:</label>
            <input type="text" name="profesja" value="<?php echo $row['Profesja']; ?>" required>
            <br>
            <button type="submit">Zapisz</button>
        </form>
        <a href="?action=list">Powrót do listy</a>
    </body>
    </html>
    <?php
} elseif ($action == 'delete') {
    // DELETE - Usuwanie nauczyciela
    $id = $_GET['id'];
    $sql = "DELETE FROM nauczyciele WHERE Nauczyciel_id = $id";

    if ($conn->query($sql)) {
        header("Location: ?action=list");
    } else {
        echo "Błąd: " . $conn->error;
    }
}
?>
