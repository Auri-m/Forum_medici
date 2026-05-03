<?php
// Includo il file di configurazione con le credenziali ($host, $db, $user, $password)
require_once 'database.php';

try {
    // Connessione al DB
    $connessione = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $connessione->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Errore di connessione: " . $e->getMessage());
}

// Controllo che il modulo sia stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Recupero e pulizia dei dati base (Step 1 e 2)
    $nome = trim($_POST['nome'] ?? '');
    $cognome = trim($_POST['cognome'] ?? '');
    $sesso = $_POST['sesso'] ?? '';
    $specialita = $_POST['specialita'] ?? null;
    $struttura = $_POST['struttura'] ?? null;
    $data_nascita = $_POST['data_nascita'] ?? '';
    $data_inizio_lavoro = $_POST['data_inizio_lavoro'] ?? '';

    // Dati dello Step 3 (Sicurezza - Assumo che questi campi esistano nel tuo HTML)
    $username = trim($_POST['username'] ?? '');
    $password_chiara = $_POST['password'] ?? '';

    // 2. Controlli di base
    if (empty($nome) || empty($cognome) || empty($username) || empty($username) || empty($password_chiara)) {
        die("Errore: Compila tutti i campi obbligatori.");
    }

    // 3. Sicurezza: Cripto la password prima di salvarla
    $password_hash = password_hash($password_chiara, PASSWORD_BCRYPT);

    // 4. Gestione Upload Foto Profilo (Opzionale)
    
    if($sesso=="f"){
        $percorso_foto = 'default_f.jpg';
    }else{
        $percorso_foto = 'default_m.jpg';
    }
     


    if (isset($_FILES['foto_profilo']) && $_FILES['foto_profilo']['error'] === UPLOAD_ERR_OK) {
        $cartella_destinazione = 'uploads/profili/';

        // Se la cartella non esiste, la creo
        if (!is_dir($cartella_destinazione)) {
            mkdir($cartella_destinazione, 0777, true);
        }

        // Genero un nome file unico per evitare sovrascritture (es. utente1 e utente2 caricano "foto.jpg")
        $nome_file_originale = basename($_FILES['foto_profilo']['name']);
        $estensione = strtolower(pathinfo($nome_file_originale, PATHINFO_EXTENSION));

        // Controllo che sia un'immagine valida
        $estensioni_ammesse = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($estensione, $estensioni_ammesse)) {
            $nuovo_nome_file = uniqid('med_') . '.' . $estensione;
            $percorso_completo = $cartella_destinazione . $nuovo_nome_file;

            // Sposto il file dalla cartella temporanea a quella finale
            if (move_uploaded_file($_FILES['foto_profilo']['tmp_name'], $percorso_completo)) {
                $percorso_foto = $percorso_completo; // Salverò questo percorso nel DB
            }
        } else {
            die("Errore: Formato immagine non supportato. Usa JPG, PNG o WEBP.");
        }
    }

    // 5. Inserimento nel Database
    try {
        $connessione->beginTransaction();
        $sql = "INSERT INTO  dottori
                (nome, cognome, sesso,  data_nascita, data_inizio_lavoro, foto_profilo, specializzazione, ospedale) 
                VALUES 
                (:nome, :cognome, :sesso, :data_nascita, :data_inizio, :foto, :specialita, :struttura)";

        $stmt = $connessione->prepare($sql);

        // ESEGUI la query associando le variabili ai segnaposto
        $stmt->execute([
            ':nome' => $nome,
            ':cognome' => $cognome,
            ':sesso' => $sesso,
            ':data_nascita' => $data_nascita,
            ':data_inizio' => $data_inizio_lavoro,
            ':foto' => $percorso_foto,
            ':specialita' => $specialita,
            ':struttura' => $struttura
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

        echo "<h2>Registrazione avvenuta con successo!</h2>";
        echo "<p>Benvenuto in MedicoForum, $nome. <a href='login.php'>Clicca qui per accedere</a>.</p>";
        // Redirect eventuale
        // In produzione, puoi usare questo per reindirizzare l'utente automaticamente:
        // header("Location: login.php?registrazione=ok");
        // exit;


    } catch (PDOException $e) {
        // 6. ANNULLA TUTTO in caso di errore
        // Se la seconda query fallisce, la prima viene annullata e il DB resta pulito
        if ($connessione->inTransaction()) {
            $connessione->rollBack();
        }

        // Controllo se l'errore è dovuto a un Username già esistente
        if ($e->getCode() == 23000) {
            die("Errore: L'Username scelto è già in uso. Torna indietro e scegline un altro.");
        } else {
            die("Errore di sistema durante la registrazione: " . $e->getMessage());
        }
    }


} else {
    // Se qualcuno prova ad accedere a questo file direttamente via URL senza inviare il form
    header("Location: Registrati.php");
    exit;
}
?>