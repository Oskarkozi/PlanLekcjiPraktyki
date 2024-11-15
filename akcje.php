<?php
session_start();

// Połączenie z bazą danych
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "dziennikdb";
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Brak połączenia: " . mysqli_connect_error());
}

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_name'])) {
    header("Location: index.html");
    exit();
}

// Pobieranie klasy z parametru URL 
$klasa = isset($_GET['Klasa']) ? $_GET['Klasa'] : '';


// Jeśli klasa nie została podana w URL, zatrzymujemy skrypt
if (empty($klasa)) {
    echo "Błąd: Nie podano klasy w URL.";
    exit();
}

// Sprawdzenie, czy klasa istnieje w bazie danych
$klasa_id = getKlasaId($conn, $klasa);

if ($klasa_id === null) {
    // Obsługuje sytuację, gdy nie znaleziono klasy
    echo "Błąd: Klasa o nazwie '$klasa' nie istnieje w bazie danych.";
    exit();
}

// Dodawanie lub edytowanie danych
if (isset($_POST['action']) && $_POST['action'] == 'edytuj') {
    $dzien = $_POST['dzien'];
    $numer_lekcji = $_POST['numer_lekcji'];
    $sala_id = $_POST['sala_id'];
    $profesja = $_POST['profesja'];
    $nauczyciel_id = $_POST['nauczyciel_id'];

    // Sprawdzenie, czy lekcja już istnieje
    $sql_check = "SELECT * FROM plan_lekcji WHERE Klasa_id = '$klasa_id' AND Dzien = '$dzien' AND Numer_Lekcji = '$numer_lekcji'";
    $result_check = mysqli_query($conn, $sql_check);
    
    if (mysqli_num_rows($result_check) > 0) {
        // Jeśli lekcja już istnieje, aktualizujemy dane
        $sql_update = "UPDATE plan_lekcji SET Sala_id = '$sala_id', Profesja = '$profesja', Nauczyciel_id = '$nauczyciel_id' WHERE Klasa_id = '$klasa_id' AND Dzien = '$dzien' AND Numer_Lekcji = '$numer_lekcji'";
        mysqli_query($conn, $sql_update);
    } else {
        // Jeśli lekcja nie istnieje, dodajemy ją
        $sql_insert = "INSERT INTO plan_lekcji (Klasa_id, Dzien, Numer_Lekcji, Sala_id, Profesja, Nauczyciel_id) 
                        VALUES ('$klasa_id', '$dzien', '$numer_lekcji', '$sala_id', '$profesja', '$nauczyciel_id')";
        mysqli_query($conn, $sql_insert);
    }

    header("Location: PlanLekcjiEdytor.php?klasa=$klasa");
    exit();
}

// Usuwanie lekcji
if (isset($_POST['action']) && $_POST['action'] == 'usun') {
    $planlekcji_id = $_POST['planlekcji_id'];

    // Usuwanie lekcji z bazy
    $sql_delete = "DELETE FROM plan_lekcji WHERE Lekcja_id = '$planlekcji_id'";
    mysqli_query($conn, $sql_delete);

    header("Location: PlanLekcjiEdytor.php?klasa=$klasa");
    exit();
}

// Funkcja sprawdzająca, czy klasa istnieje w bazie
function getKlasaId($conn, $klasa) {
    $sql = "SELECT Klasa_id FROM klasy WHERE Klasa = '$klasa'";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['Klasa_id'];
    } else {
        // Jeśli klasa nie została znaleziona, zwróć null
        return null;
    }
}

mysqli_close($conn);
?>
