<?php
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
    // LIST - Wyświetlanie wszystkich sal
    $sql = "SELECT * FROM sale";
    $result = $conn->query($sql);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <link rel="stylesheet" href="crud.css">
        <title>Lista sal</title>
    </head>
    <body>
        <h1>Lista sal</h1>
        <a href="?action=create">Dodaj nową salę</a><br><a href="crud.php">Powrót do wyboru tabel</a>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Numer Sali</th>
                <th>Komputerowa</th>
                <th>Akcje</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['Sala_id']; ?></td>
                    <td><?php echo $row['Numer_Sali']; ?></td>
                    <td><?php echo $row['Komputerowa'] ? "Tak" : "Nie"; ?></td>
                    <td>
                        <a href="?action=edit&id=<?php echo $row['Sala_id']; ?>">Edytuj</a> |
                        <a href="?action=delete&id=<?php echo $row['Sala_id']; ?>">Usuń</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </body>
    </html>
    <?php
} elseif ($action == 'create') {
    // CREATE - Dodawanie nowej sali
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $numer_sali = $_POST['numer_sali'];
        $komputerowa = isset($_POST['komputerowa']) ? 1 : 0;
        $sql = "INSERT INTO sale (Numer_Sali, Komputerowa) VALUES ('$numer_sali', '$komputerowa')";

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

        <title>Dodaj salę</title>
    </head>
    <body>
        <h1>Dodaj salę</h1>
        <form method="POST">
            <label>Numer sali:</label>
            <input type="number" name="numer_sali" required>
            <br>
            <label>Komputerowa:</label>
            <input type="checkbox" name="komputerowa">
            <br>
            <button type="submit">Dodaj</button>
        </form>
        <a href="?action=list">Powrót do listy</a>
    </body>
    </html>
    <?php
} elseif ($action == 'edit') {
    // EDIT - Edycja sali
    $id = $_GET['id'];
    $sql = "SELECT * FROM sale WHERE Sala_id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $numer_sali = $_POST['numer_sali'];
        $komputerowa = isset($_POST['komputerowa']) ? 1 : 0;
        $sql = "UPDATE sale SET Numer_Sali = '$numer_sali', Komputerowa = '$komputerowa' WHERE Sala_id = $id";

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

        <title>Edytuj salę</title>
    </head>
    <body>
        <h1>Edytuj salę</h1>
        <form method="POST">
            <label>Numer sali:</label>
            <input type="number" name="numer_sali" value="<?php echo $row['Numer_Sali']; ?>" required>
            <br>
            <label>Komputerowa:</label>
            <input type="checkbox" name="komputerowa" <?php echo $row['Komputerowa'] ? "checked" : ""; ?>>
            <br>
            <button type="submit">Zapisz</button>
        </form>
        <a href="?action=list">Powrót do listy</a>
    </body>
    </html>
    <?php
} elseif ($action == 'delete') {
    // DELETE - Usuwanie sali
    $id = $_GET['id'];
    $sql = "DELETE FROM sale WHERE Sala_id = $id";

    if ($conn->query($sql)) {
        header("Location: ?action=list");
    } else {
        echo "Błąd: " . $conn->error;
    }
}
?>
