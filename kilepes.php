<?php
// kilepes.php

// 1. Session indítása
session_start();

// Ha már volt kijelentkezési üzenet, azonnal átirányítunk
if (isset($_SESSION['logout_shown'])) {
    header("Location: index.php");
    exit();
}

// 2. Felhasználónév elmentése az üzenethez (még a session törlése előtt)
$username = isset($_SESSION['felhasznalonev']) ? $_SESSION['felhasznalonev'] : 'Felhasználó';

// 3. Megjelöljük, hogy a kijelentkezési üzenet meg lett jelenítve
$_SESSION['logout_shown'] = true;

// 4. Session megtisztítása
$_SESSION = array();

// 5. Session cookie törlése
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

// 6. Session megsemmisítése
session_destroy();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kilépés - Vaszilij EDC</title>
        <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="https://vaszilijedc.hu/wp-content/uploads/2018/05/Vaszilij-EDC.jpg.webp">
    <style>
        .logout-container {
            text-align: center;
            margin-top: 100px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .spinner {
            margin: 20px auto;
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="page1">
    <div class="logout-container">
        <h2>Kijelentkezés folyamatban...</h2>
        <p>Viszontlátásra, <?php echo htmlspecialchars($username); ?>!</p>
        <p>A rendszer hamarosan átirányít a főoldalra.</p>
        <div class="spinner"></div>
    </div>

    <script>
        // 3 másodperc várakozás után átirányítás
        setTimeout(function() {
            window.location.href = "index.php";
        }, 3000);
    </script>
</body>
</html>