<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_name'])) {
    header("Location: index.html");
    exit();
}
// Sprawdzenie, czy istnieje ciasteczko z datą ostatniej edycji
$last_edit_date = isset($_COOKIE['last_edit_date']) ? $_COOKIE['last_edit_date'] : null;
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eruptor-Admin</title>
    
    <style>
        /* Stylizacja strony */
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: radial-gradient(circle, #FF4500, #8B0000, #2F4F4F);
            font-family: Arial, sans-serif;
        }

        /* Stylizacja logo */
        .logo {
            width: 500px;
            height: auto;
            margin-bottom: 40px;
        }

        /* Kontener na przyciski */
        .button-container {
            display: flex;
            justify-content: space-around;
            width: 100%;
            max-width: 500px;
        }

        /* Styl przycisków */
        .button {
            flex: 1;
            padding: 20px;
            margin: 0 10px;
            font-size: 1.2em;
            color: white;
            background-color: #70562f;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s, transform 0.2s;
        }

        /* Efekt po najechaniu myszką */
        .button:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        /* Stylizacja focus */
        .button:focus {
            outline: 2px solid #fff;
            outline-offset: 4px;
        }

        /* Stylizacja responsywna dla urządzeń mobilnych */
        @media (max-width: 600px) {
            .button-container {
                flex-direction: column;
                align-items: center;
            }

            .button {
                width: 80%;
                margin: 10px 0;
                font-size: 1.1em;
            }
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
        .last-edit{
            text-align: center;
            margin: 20px auto;
            padding: 15px;
            background-color: #ffcc00;
            border-radius: 10px;
            color: #800000;
            font-weight: bold;
            font-size: 1.5em;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
    <body>
        <!-- Informacja o dacie ostatniej edycji -->
    <?php if ($last_edit_date): ?>
        <div class="last-edit">
            Ostatnia edycja miała miejsce: <?php echo $last_edit_date; ?>
        </div>
    <?php else: ?>
        <div class="last-edit">
            Brak informacji o dacie ostatniej edycji.
        </div>
    <?php endif; ?>

    <!-- Logo umieszczone na środku -->
    <img src="logo.png" alt="Logo" class="logo">
    <!-- Kontener na przyciski -->
        <div class="button-container">
            <!-- Pierwszy przycisk -->
            <a href="edytor/wyburKlasEdytor.php" class="button">Edytor Planu Lekcji</a>
            <!-- Drugi przycisk -->
            <a href="crud/crud.php" class="button">CRUD</a>
        </div>

    <br>

        <div class="button-container">
        <a href="index.html" class="button">Powrót</a>
    </div>
        <footer>
        <p>© 2024 Eruptor. | <a href="https://github.com/Oskarkozi/PlanLekcjiPraktyki">Open Source.</a></p>
    </footer>
    </body>
</html>
