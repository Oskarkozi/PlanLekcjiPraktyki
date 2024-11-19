<?php 
session_start();
include "database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    function validate($data){
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $uname = validate($_POST['uname'] ?? '');
    $pass = validate($_POST['password'] ?? '');

    // Sprawdzenie, czy pola są wypełnione
    if (empty($uname)) {
        $error_message = "User Name is required.";
    } elseif (empty($pass)) {
        $error_message = "Password is required.";
    } elseif (strlen($uname) > 50 || strlen($pass) > 50) {
        $error_message = "Input too long. Max 50 characters.";
    } else {
        // Zabezpieczenie przed SQL Injection za pomocą prepared statements
        $sql = "SELECT * FROM uzytkownicy WHERE user_name = ? AND password = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $uname, $pass);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);

                if ($row['user_name'] === $uname && $row['password'] === $pass) {
                    $_SESSION['user_name'] = $row['user_name'];
                    $_SESSION['id'] = $row['id'];
                    header("Location: indexAdmina.php");
                    exit();
                } else {
                    $error_message = "Incorrect username or password.";
                }
            } else {
                $error_message = "Incorrect username or password.";
            }
        } else {
            $error_message = "Server error. Please try again later.";
        }

        mysqli_stmt_close($stmt);
    }

    // Jeśli wystąpił błąd, przekieruj z komunikatem
    if (!empty($error_message)) {
        header("Location: przedlogin.php?error=" . urlencode($error_message));
        exit();
    }
} else {
    header("Location: przedlogin.php");
    exit();
}
?>
