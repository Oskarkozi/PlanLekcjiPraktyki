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
    // LIST - Wyświetlanie wszystkich emaili
    $sql = "SELECT * FROM nauczyciele";
    $result = $conn->query($sql);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Lista e-maili</title>
        <link rel="stylesheet" href="crud.css">
    </head>
    <body>
        <h1>Lista e-maili nauczycieli</h1>
        <a href="?action=create">Dodaj nowy e-mail</a><br><a href="crud.php">Powrót do wyboru tabel</a>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>E-mail</th>
                <th>Akcje</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['Nauczyciel_id']; ?></td>
                    <td><?php echo $row['Imie']; ?></td>
                    <td><?php echo $row['Nazwisko']; ?></td>
                    <td><?php echo $row['email']; ?></td>
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
    // CREATE - Dodawanie nowego e-maila
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nauczyciel_id = $_POST['nauczyciel_id'];
        $email = $_POST['email'];
        $sql = "UPDATE nauczyciele SET email = '$email' WHERE Nauczyciel_id = $nauczyciel_id";

        if ($conn->query($sql)) {
            header("Location: ?action=list");
        } else {
            echo "Błąd: " . $conn->error;
        }
    }

    $sql = "SELECT * FROM nauczyciele WHERE email IS NULL OR email = ''";
    $result = $conn->query($sql);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="crud.css">
        <title>Dodaj e-mail</title>
    </head>
    <body>
        <h1>Dodaj e-mail</h1>
        <form method="POST">
            <label>Wybierz nauczyciela:</label>
            <select name="nauczyciel_id" required>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <option value="<?php echo $row['Nauczyciel_id']; ?>">
                        <?php echo $row['Imie'] . " " . $row['Nazwisko']; ?>
                    </option>
                <?php } ?>
            </select>
            <br>
            <label>Adres e-mail:</label>
            <input type="email" name="email" required>
            <button type="submit">Dodaj</button>
        </form>
        <a href="?action=list">Powrót do listy</a>
    </body>
    </html>
    <?php
} elseif ($action == 'edit') {
    // EDIT - Edycja e-maila
    $id = $_GET['id'];
    $sql = "SELECT * FROM nauczyciele WHERE Nauczyciel_id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $sql = "UPDATE nauczyciele SET email = '$email' WHERE Nauczyciel_id = $id";

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
        <title>Edytuj e-mail</title>
    </head>
    <body>
        <h1>Edytuj e-mail</h1>
        <form method="POST">
            <label>Adres e-mail:</label>
            <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
            <button type="submit">Zapisz</button>
        </form>
    </body>
    </html>
    <?php
} elseif ($action == 'delete') {
    // DELETE - Usuwanie e-maila
    $id = $_GET['id'];
    $sql = "UPDATE nauczyciele SET email = NULL WHERE Nauczyciel_id = $id";

    if ($conn->query($sql)) {
        header("Location: ?action=list");
    } else {
        echo "Błąd: " . $conn->error;
    }
}
?>
