<?php
require_once 'database.php';

try {
    // Connessione al DB
    $connessione = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $connessione->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Errore di connessione: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST['nome'] ?? '');
    $cognome = trim($_POST['cognome'] ?? '');
    $sesso = $_POST['sesso'] ?? '';
    $specialita = $_POST['specialita'] ?? null;
    $struttura = $_POST['struttura'] ?? null;
    $data_nascita = $_POST['data_nascita'] ?? '';
    $data_inizio_lavoro = $_POST['data_inizio_lavoro'] ?? '';

    $biografia = trim($_POST['biografia'] ?? '');
    if (empty($biografia)) {
        $biografia = "Questo medico non ha ancora inserito una biografia personale.";
    } elseif (mb_strlen($biografia) > 500) {
        $biografia = mb_substr($biografia, 0, 500);
    }

    $username = trim($_POST['username'] ?? '');
    $password_chiara = $_POST['password'] ?? '';

    if (empty($nome) || empty($cognome) || empty($username) || empty($password_chiara)) {
        die("Errore: Compila tutti i campi obbligatori.");
    }

    $password_hash = password_hash($password_chiara, PASSWORD_BCRYPT);

    if ($sesso == "f") {
        $percorso_foto = 'default_f.jpg';
    } else {
        $percorso_foto = 'default_m.jpg';
    }

    if (isset($_FILES['foto_profilo']) && $_FILES['foto_profilo']['error'] === UPLOAD_ERR_OK) {
        $cartella_destinazione = 'uploads/profili/';

        if (!is_dir($cartella_destinazione)) {
            mkdir($cartella_destinazione, 0777, true);
        }

        $nome_file_originale = basename($_FILES['foto_profilo']['name']);
        $estensione = strtolower(pathinfo($nome_file_originale, PATHINFO_EXTENSION));

        $estensioni_ammesse = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($estensione, $estensioni_ammesse)) {
            $nuovo_nome_file = uniqid('med_') . '.' . $estensione;
            $percorso_completo = $cartella_destinazione . $nuovo_nome_file;

            if (move_uploaded_file($_FILES['foto_profilo']['tmp_name'], $percorso_completo)) {
                $percorso_foto = $percorso_completo;
            }
        } else {
            die("Errore: Formato immagine non supportato. Usa JPG, PNG o WEBP.");
        }
    }

    // 5. Inserimento nel Database
    try {
        $connessione->beginTransaction();

        $sql = "INSERT INTO dottori
                (nome, cognome, sesso, data_nascita, data_inizio_lavoro, foto_profilo, specializzazione, ospedale, biografia) 
                VALUES 
                (:nome, :cognome, :sesso, :data_nascita, :data_inizio, :foto, :specialita, :struttura, :biografia)";

        $stmt = $connessione->prepare($sql);

        $stmt->execute([
            ':nome' => $nome,
            ':cognome' => $cognome,
            ':sesso' => $sesso,
            ':data_nascita' => $data_nascita,
            ':data_inizio' => $data_inizio_lavoro,
            ':foto' => $percorso_foto,
            ':specialita' => $specialita,
            ':struttura' => $struttura,
            ':biografia' => $biografia
        ]);

        $id_dottore_nuovo = $connessione->lastInsertId();

        $sql_credenziali = "INSERT INTO credenziali 
            (username, password, dottore) 
            VALUES 
            (:username, :password, :id_dottore)";

        $stmt_credenziali = $connessione->prepare($sql_credenziali);

        $stmt_credenziali->execute([
            ':username' => $username,
            ':password' => $password_hash,
            ':id_dottore' => $id_dottore_nuovo
        ]);

        $connessione->commit();

        $_SESSION["registrato"] = true;
        header("Location: login.php?registrazione=ok");
        exit;

    } catch (PDOException $e) {
        // 6. ANNULLA TUTTO in caso di errore
        if ($connessione->inTransaction()) {
            $connessione->rollBack();
        }

        if ($e->getCode() == 23000) {
            die("Errore: L'Username scelto è già in uso. Torna indietro e scegline un altro.");
        } else {
            die("Errore di sistema durante la registrazione: " . $e->getMessage());
        }
    }

} else {
    header("Location: Registrati.php");
    exit;
}
?>