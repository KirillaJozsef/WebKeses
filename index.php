<?php
session_start();

// Adatbázis kapcsolat
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "regisztracio";

// Ha már be van jelentkezve, átirányít a főoldalra
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: fooldal.php");
    exit();
}

// Változók inicializálása
$error = '';
$success = '';
$formData = ['felhasznalonev' => '', 'email' => ''];
$isRegistering = isset($_POST['register']);

// Bejelentkezési kísérlet feldolgozása
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$isRegistering && isset($_POST['login_felhasznalonev'], $_POST['login_jelszo'])) {
    $felhasznalonev = trim($_POST['login_felhasznalonev']);
    $jelszo = $_POST['login_jelszo'];
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Kapcsolódási hiba: " . $conn->connect_error);
    }
    
    $stmt = $conn->prepare("SELECT id, felhasznalonev, jelszo FROM felhasznalok WHERE felhasznalonev = ?");
    if ($stmt) {
        $stmt->bind_param("s", $felhasznalonev);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($jelszo, $user['jelszo'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['felhasznalonev'] = $user['felhasznalonev'];
                $_SESSION['last_activity'] = time();

                   // Üdvözlő üzenet beállítása
                $_SESSION['welcome_message'] = "Üdvözlöm " . htmlspecialchars($user['felhasznalonev']) . "!";

                header("Location: fooldal.php");
                exit();
            } else {
                $error = "Hibás felhasználónév vagy jelszó!";
            }
        } else {
            $error = "Hibás felhasználónév vagy jelszó!";
        }
        $stmt->close();
    }
    $conn->close();
}

// Regisztrációs kísérlet feldolgozása
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isRegistering) {
    $formData['felhasznalonev'] = trim($_POST['reg_felhasznalonev']);
    $formData['email'] = trim($_POST['reg_email']);
    $jelszo = $_POST['reg_jelszo'];
    $jelszo_ujra = $_POST['reg_jelszo_ujra'];
    
    // Validáció
    if (empty($formData['felhasznalonev'])) {
        $error = "Felhasználónév megadása kötelező!";
    } elseif (strlen($formData['felhasznalonev']) < 3) {
        $error = "A felhasználónév minimum 3 karakter hosszú legyen!";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $formData['felhasznalonev'])) {
        $error = "A felhasználónév csak betűket, számokat és alulvonást tartalmazhat!";
    } elseif (empty($formData['email'])) {
        $error = "Email cím megadása kötelező!";
    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $error = "Érvénytelen email cím formátum!";
    } elseif (empty($jelszo)) {
        $error = "Jelszó megadása kötelező!";
    } elseif (strlen($jelszo) < 8) {
        $error = "A jelszónak minimum 8 karakter hosszúnak kell lennie!";
    } elseif ($jelszo !== $jelszo_ujra) {
        $error = "A jelszavak nem egyeznek!";
    } else {
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
            die("Kapcsolódási hiba: " . $conn->connect_error);
        }
        
        // Ellenőrizzük, hogy létezik-e már a felhasználó
        $stmt = $conn->prepare("SELECT id FROM felhasznalok WHERE felhasznalonev = ? OR email = ?");
        $stmt->bind_param("ss", $formData['felhasznalonev'], $formData['email']);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $error = "A felhasználónév vagy email cím már foglalt!";
        } else {
            $jelszo_hash = password_hash($jelszo, PASSWORD_DEFAULT);
            $aktivacios_kod = bin2hex(random_bytes(16));
            
            $stmt = $conn->prepare("INSERT INTO felhasznalok (felhasznalonev, email, jelszo, aktivacios_kod) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $formData['felhasznalonev'], $formData['email'], $jelszo_hash, $aktivacios_kod);
            
            if ($stmt->execute()) {
                $success = "Sikeres regisztráció! Most már bejelentkezhet.";
                $isRegistering = false; // Visszaváltunk a bejelentkezésre
            } else {
                $error = "Adatbázis hiba: " . $conn->error;
            }
        }
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés - Vaszilij EDC</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
      <link rel="icon" type="image/png" href="https://vaszilijedc.hu/wp-content/uploads/2018/05/Vaszilij-EDC.jpg.webp">
</head>
<body>
<div class="wrapper">
 </div>

    <div class="form-container">
        <!-- Bejelentkezés -->
        <div id="login-form" class="form-section" style="<?php echo $isRegistering ? 'display:none;' : ''; ?>">
            <form method="POST" action="">
                <h1>Bejelentkezés</h1>

                <?php if (!empty($error) && !$isRegistering): ?>
                    <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <div class="alert success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>

                <div class="input-box">
                    <input type="text" name="login_felhasznalonev" placeholder="Felhasználónév" required
                           value="<?php echo htmlspecialchars($_POST['login_felhasznalonev'] ?? ''); ?>">
                    <i class='bx bx-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="login_jelszo" placeholder="Jelszó" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <button type="submit" class="btn">Bejelentkezés</button>

                <!-- Váltás regisztrációra -->
                <div class="register-link">
                    <p>Nincs fiókod? <button type="button" class="link-btn" onclick="showRegister()">Regisztrálj</button></p>
                </div>
            </form>
        </div>

        <!-- Regisztráció -->
        <div id="register-form" class="form-section" style="<?php echo !$isRegistering ? 'display:none;' : ''; ?>">
            <form method="POST" action="">
                <input type="hidden" name="register" value="1">
                <h1>Regisztráció</h1>

                <?php if (!empty($error) && $isRegistering): ?>
                    <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <div class="input-box">
                    <input type="text" name="reg_felhasznalonev" placeholder="Felhasználónév" required
                           value="<?php echo htmlspecialchars($formData['felhasznalonev']); ?>"
                           pattern="[a-zA-Z0-9_]+" title="Csak betűk, számok és alulvonás">
                    <i class='bx bx-user'></i>
                </div>
                <div class="input-box">
                    <input type="email" name="reg_email" placeholder="Email cím" required
                           value="<?php echo htmlspecialchars($formData['email']); ?>">
                    <i class='bx bx-envelope'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="reg_jelszo" placeholder="Jelszó" required
                           minlength="8" pattern="^(?=.*[A-Z])(?=.*[0-9])(?=.*[^a-zA-Z0-9]).{8,}$"
                           title="Legalább 8 karakter, tartalmaznia kell nagybetűt, számot és speciális karaktert">
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="reg_jelszo_ujra" placeholder="Jelszó újra" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <button type="submit" class="btn">Regisztráció</button>

                <!-- Váltás bejelentkezésre -->
                <div class="register-link">
                    <p>Már van fiókod? <button type="button" class="link-btn" onclick="showLogin()">Bejelentkezés</button></p>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS logika -->
<script>
function showLogin() {
    document.getElementById('login-form').style.display = 'block';
    document.getElementById('register-form').style.display = 'none';
    document.querySelector('[onclick="showLogin()"]').classList.add('active-tab');
    document.querySelector('[onclick="showRegister()"]').classList.remove('active-tab');
}

function showRegister() {
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('register-form').style.display = 'block';
    document.querySelector('[onclick="showLogin()"]').classList.remove('active-tab');
    document.querySelector('[onclick="showRegister()"]').classList.add('active-tab');
}
</script>

</body>
</html>