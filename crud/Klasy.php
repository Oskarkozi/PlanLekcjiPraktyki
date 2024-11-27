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
    // LIST - Wyświetlanie wszystkich klas
    $sql = "SELECT * FROM klasy";
    $result = $conn->query($sql);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Lista klas</title>
        <link rel="stylesheet" href="crud.css">
    </head>
    <body>
        <h1>Lista klas</h1>
        <a href="?action=create">Dodaj nową klasę</a><br><a href="crud.php">Powrót do wyboru tabel</a>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Klasa</th>
                <th>Akcje</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['Klasa_id']; ?></td>
                    <td><?php echo $row['Klasa']; ?></td>
                    <td>
                        <a href="?action=edit&id=<?php echo $row['Klasa_id']; ?>">Edytuj</a> |
                        <a href="?action=delete&id=<?php echo $row['Klasa_id']; ?>">Usuń</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </body>
    </html>
    <?php
} elseif ($action == 'create') {
    // CREATE - Dodawanie nowej klasy
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $klasa = $_POST['klasa'];
        $sql = "INSERT INTO klasy (Klasa) VALUES ('$klasa')";

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

        <title>Dodaj klasę</title>
    </head>
    <body>
        <h1>Dodaj klasę</h1>
        <form method="POST">
            <label>Nazwa klasy:</label>
            <input type="text" name="klasa" required>
            <button type="submit">Dodaj</button>
        </form>
        <a href="?action=list">Powrót do listy</a>
    </body>
    </html>
    <?php
} elseif ($action == 'edit') {
    // EDIT - Edycja klasy
    $id = $_GET['id'];
    $sql = "SELECT * FROM klasy WHERE Klasa_id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $klasa = $_POST['klasa'];
        $sql = "UPDATE klasy SET Klasa = '$klasa' WHERE Klasa_id = $id";

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

        <title>Edytuj klasę</title>
    </head>
    <body>
        <h1>Edytuj klasę</h1>
        <form method="POST">
            <label>Nazwa klasy:</label>
            <input type="text" name="klasa" value="<?php echo $row['Klasa']; ?>" required>
            <button type="submit">Zapisz</button>
        </form>
    </body>
    </html>
    <?php
} elseif ($action == 'delete') {
    // DELETE - Usuwanie klasy
    $id = $_GET['id'];
    $sql = "DELETE FROM klasy WHERE Klasa_id = $id";

    if ($conn->query($sql)) {
        header("Location: ?action=list");
    } else {
        echo "Błąd: " . $conn->error;
    }
}
?>
