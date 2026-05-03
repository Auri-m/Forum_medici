<?php
require_once 'database.php';

if (!isset($_SESSION['utente'])) {
<<<<<<< HEAD
  header("Location: Login.php");
  exit();
}

try {
  $connessione = new PDO("mysql:host=$host;dbname=$db", $user, $password);
  $connessione->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Errore nella gestione del database: " . $e->getMessage());
}

$errori = [];
=======
    header("Location: Login.php");
    exit();
}

try {
    $connessione = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $connessione->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Errore nella gestione del database: " . $e->getMessage());
}

$errori  = [];
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
$successo = false;

// ── Gestione salvataggio ──
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
<<<<<<< HEAD
  $nome = trim($_POST['nome'] ?? '');
  $cognome = trim($_POST['cognome'] ?? '');
  $biografia = trim($_POST['biografia'] ?? '');
  $anni_lavoro = isset($_POST['anni_lavoro']) && $_POST['anni_lavoro'] !== '' ? (int) $_POST['anni_lavoro'] : null;
  $ospedale = isset($_POST['ospedale']) && $_POST['ospedale'] !== '' ? (int) $_POST['ospedale'] : null;
  $specializzaz = trim($_POST['specializzazione'] ?? '');

  if ($nome === '')
    $errori[] = "Il nome è obbligatorio.";
  if ($cognome === '')
    $errori[] = "Il cognome è obbligatorio.";
  if (mb_strlen($biografia) > 500)
    $errori[] = "La biografia non può superare i 500 caratteri.";

  $foto_profilo_new = null;

  if (!empty($_FILES['foto_profilo']['name'])) {
    $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $mime = mime_content_type($_FILES['foto_profilo']['tmp_name']);

    if (!in_array($mime, $allowed)) {
      $errori[] = "Formato immagine non supportato. Usa JPG, PNG o WEBP.";
    } elseif ($_FILES['foto_profilo']['size'] > 4 * 1024 * 1024) {
      $errori[] = "L'immagine non può superare i 4 MB.";
    } else {
      $vecchia_foto = $dottore_attuale['foto_profilo'];
      // Cancelliamo il file solo se esiste e non è una delle immagini di default
      if ($vecchia_foto && $vecchia_foto !== 'default_m.jpg' && $vecchia_foto !== 'default_f.jpg') {
        $path_vecchio = 'img/' . $vecchia_foto;
        if (file_exists($path_vecchio)) {
          unlink($path_vecchio);
        }
      }
      $ext = pathinfo($_FILES['foto_profilo']['name'], PATHINFO_EXTENSION);
      $foto_profilo_new = 'dottore_' . $_SESSION['utente'] . '_' . time() . '.' . $ext;
      move_uploaded_file($_FILES['foto_profilo']['tmp_name'], 'img/' . $foto_profilo_new);
    }
  } else {
    $foto_profilo_new = $dottore_attuale['foto_profilo'];
  }

  if (empty($errori)) {
    if ($foto_profilo_new) {
      $sql = "UPDATE dottori SET nome=?, cognome=?, biografia=?, anni_lavoro=?, ospedale=?, specializzazione=?, foto_profilo=?
                    WHERE id_dottore=?";
      $stmt = $connessione->prepare($sql);
      $stmt->execute([$nome, $cognome, $biografia, $anni_lavoro, $ospedale, $specializzaz, $foto_profilo_new, $_SESSION['utente']]);
    } else {
      $sql = "UPDATE dottori SET nome=?, cognome=?, biografia=?, anni_lavoro=?, ospedale=?, specializzazione=?
                    WHERE id_dottore=?";
      $stmt = $connessione->prepare($sql);
      $stmt->execute([$nome, $cognome, $biografia, $anni_lavoro, $ospedale, $specializzaz, $_SESSION['utente']]);
    }
    $successo = true;
  }
}

=======
    $nome          = trim($_POST['nome']          ?? '');
    $cognome       = trim($_POST['cognome']       ?? '');
    $biografia     = trim($_POST['biografia']     ?? '');
    $anni_lavoro   = isset($_POST['anni_lavoro']) && $_POST['anni_lavoro'] !== '' ? (int)$_POST['anni_lavoro'] : null;
    $ospedale      = isset($_POST['ospedale'])    && $_POST['ospedale']    !== '' ? (int)$_POST['ospedale']    : null;
    $specializzaz  = trim($_POST['specializzazione'] ?? '');

    if ($nome    === '') $errori[] = "Il nome è obbligatorio.";
    if ($cognome === '') $errori[] = "Il cognome è obbligatorio.";
    if (mb_strlen($biografia) > 500) $errori[] = "La biografia non può superare i 500 caratteri.";

    // Gestione foto profilo
    $foto_profilo_new = null;
    if (!empty($_FILES['foto_profilo']['name'])) {
        $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $mime    = mime_content_type($_FILES['foto_profilo']['tmp_name']);
        if (!in_array($mime, $allowed)) {
            $errori[] = "Formato immagine non supportato. Usa JPG, PNG o WEBP.";
        } elseif ($_FILES['foto_profilo']['size'] > 4 * 1024 * 1024) {
            $errori[] = "L'immagine non può superare i 4 MB.";
        } else {
            $ext = pathinfo($_FILES['foto_profilo']['name'], PATHINFO_EXTENSION);
            $foto_profilo_new = 'dottore_' . $_SESSION['utente'] . '_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['foto_profilo']['tmp_name'], 'img/' . $foto_profilo_new);
        }
    }

    if (empty($errori)) {
        if ($foto_profilo_new) {
            $sql = "UPDATE dottori SET nome=?, cognome=?, biografia=?, anni_lavoro=?, ospedale=?, specializzazione=?, foto_profilo=?
                    WHERE id_dottore=?";
            $stmt = $connessione->prepare($sql);
            $stmt->execute([$nome, $cognome, $biografia, $anni_lavoro, $ospedale, $specializzaz, $foto_profilo_new, $_SESSION['utente']]);
        } else {
            $sql = "UPDATE dottori SET nome=?, cognome=?, biografia=?, anni_lavoro=?, ospedale=?, specializzazione=?
                    WHERE id_dottore=?";
            $stmt = $connessione->prepare($sql);
            $stmt->execute([$nome, $cognome, $biografia, $anni_lavoro, $ospedale, $specializzaz, $_SESSION['utente']]);
        }
        $successo = true;
    }
}

// ── Fetch dati attuali ──
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
$sql = "SELECT dottori.nome, dottori.cognome, dottori.biografia, dottori.anni_lavoro,
               dottori.eta, dottori.sesso, dottori.foto_profilo,
               dottori.ospedale AS id_ospedale, dottori.specializzazione AS cod_spec
        FROM dottori
        WHERE id_dottore = ?";
$stmt = $connessione->prepare($sql);
$stmt->execute([$_SESSION['utente']]);
$dottore = $stmt->fetch(PDO::FETCH_ASSOC);

<<<<<<< HEAD
=======
// ── Fetch selects ──
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
$stmt_spec = $connessione->prepare("SELECT codice, nome FROM specializzazioni ORDER BY nome");
$stmt_spec->execute();
$specializzazioni = $stmt_spec->fetchAll(PDO::FETCH_ASSOC);

$stmt_osp = $connessione->prepare("SELECT id_ospedale, nome, citta FROM ospedali ORDER BY nome");
$stmt_osp->execute();
$ospedali = $stmt_osp->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifica Profilo | MedicoForum</title>
<<<<<<< HEAD
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
  <style>
    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0
    }

    :root {
      --bg: #f0f4f8;
      --white: #ffffff;
      --navy: #0d1f3c;
      --navy2: #162844;
      --teal: #0f9f8e;
      --teal2: #0b7d6f;
      --teal-lt: #e6f7f5;
      --gold: #c49a3c;
      --muted: #6b82a0;
      --border: #dce4ef;
    }

    html {
      scroll-behavior: smooth
    }

=======
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0 }

    :root {
      --bg:      #f0f4f8;
      --white:   #ffffff;
      --navy:    #0d1f3c;
      --navy2:   #162844;
      --teal:    #0f9f8e;
      --teal2:   #0b7d6f;
      --teal-lt: #e6f7f5;
      --gold:    #c49a3c;
      --muted:   #6b82a0;
      --border:  #dce4ef;
    }

    html { scroll-behavior: smooth }
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg);
      color: var(--navy);
      overflow-x: hidden;
    }

    body::before {
      content: '';
<<<<<<< HEAD
      position: fixed;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.025'/%3E%3C/svg%3E");
      pointer-events: none;
      z-index: 9999;
      opacity: .3;
=======
      position: fixed; inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.025'/%3E%3C/svg%3E");
      pointer-events: none; z-index: 9999; opacity: .3;
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    }

    /* ══ NAVBAR ══ */
    header {
<<<<<<< HEAD
      position: sticky;
      top: 0;
      z-index: 200;
      background: rgba(255, 255, 255, .97);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid var(--border);
      height: 64px;
      display: flex;
      align-items: center;
      padding: 0 5%;
      gap: 16px;
      box-shadow: 0 1px 0 var(--border), 0 4px 20px rgba(13, 31, 60, .04);
    }

    .back-btn {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13.5px;
      font-weight: 600;
      color: var(--muted);
      text-decoration: none;
      padding: 7px 14px;
      border-radius: 10px;
      background: var(--bg);
      border: 1px solid var(--border);
      transition: all .2s;
    }

    .back-btn:hover {
      color: var(--teal);
      border-color: var(--teal);
      background: var(--teal-lt)
    }

    .nav-logo {
      font-family: 'DM Serif Display', serif;
      font-size: 19px;
      color: var(--navy);
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 9px;
      margin-left: auto;
    }

    .nav-logo .cross {
      width: 30px;
      height: 30px;
      background: linear-gradient(135deg, var(--teal), var(--teal2));
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 14px;
      font-weight: 900;
=======
      position: sticky; top: 0; z-index: 200;
      background: rgba(255,255,255,.97);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid var(--border);
      height: 64px;
      display: flex; align-items: center; padding: 0 5%; gap: 16px;
      box-shadow: 0 1px 0 var(--border), 0 4px 20px rgba(13,31,60,.04);
    }
    .back-btn {
      display: flex; align-items: center; gap: 8px;
      font-size: 13.5px; font-weight: 600; color: var(--muted);
      text-decoration: none; padding: 7px 14px;
      border-radius: 10px; background: var(--bg);
      border: 1px solid var(--border); transition: all .2s;
    }
    .back-btn:hover { color: var(--teal); border-color: var(--teal); background: var(--teal-lt) }
    .nav-logo {
      font-family: 'DM Serif Display', serif;
      font-size: 19px; color: var(--navy);
      text-decoration: none;
      display: flex; align-items: center; gap: 9px; margin-left: auto;
    }
    .nav-logo .cross {
      width: 30px; height: 30px;
      background: linear-gradient(135deg, var(--teal), var(--teal2));
      border-radius: 8px; display: flex; align-items: center; justify-content: center;
      color: #fff; font-size: 14px; font-weight: 900;
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    }

    /* ══ LAYOUT ══ */
    .page-wrapper {
      max-width: 820px;
      margin: 0 auto;
      padding: 36px 24px 80px;
    }

    .page-header {
      margin-bottom: 30px;
    }
<<<<<<< HEAD

    .page-label {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .1em;
      color: var(--teal);
      margin-bottom: 6px;
    }

    .page-title {
      font-family: 'DM Serif Display', serif;
      font-size: 30px;
      color: var(--navy);
      line-height: 1.2;
    }

    .page-subtitle {
      font-size: 14px;
      color: var(--muted);
      margin-top: 6px;
=======
    .page-label {
      font-size: 11px; font-weight: 700; text-transform: uppercase;
      letter-spacing: .1em; color: var(--teal); margin-bottom: 6px;
    }
    .page-title {
      font-family: 'DM Serif Display', serif;
      font-size: 30px; color: var(--navy); line-height: 1.2;
    }
    .page-subtitle {
      font-size: 14px; color: var(--muted); margin-top: 6px;
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    }

    /* ══ ALERTS ══ */
    .alert {
      padding: 14px 18px;
      border-radius: 13px;
      margin-bottom: 24px;
      font-size: 14px;
      font-weight: 500;
      display: flex;
      align-items: flex-start;
      gap: 10px;
    }
<<<<<<< HEAD

    .alert-success {
      background: var(--teal-lt);
      border: 1px solid rgba(15, 159, 142, .25);
      color: var(--teal2);
    }

=======
    .alert-success {
      background: var(--teal-lt);
      border: 1px solid rgba(15,159,142,.25);
      color: var(--teal2);
    }
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    .alert-error {
      background: #fef2f2;
      border: 1px solid #fca5a5;
      color: #b91c1c;
    }
<<<<<<< HEAD

    .alert ul {
      margin: 4px 0 0 16px
    }

    .alert li {
      margin-bottom: 2px
    }
=======
    .alert ul { margin: 4px 0 0 16px }
    .alert li { margin-bottom: 2px }
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e

    /* ══ CARD ══ */
    .form-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 28px 30px;
<<<<<<< HEAD
      box-shadow: 0 4px 20px rgba(13, 31, 60, .05);
      margin-bottom: 20px;
    }

=======
      box-shadow: 0 4px 20px rgba(13,31,60,.05);
      margin-bottom: 20px;
    }
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    .card-section-title {
      font-family: 'DM Serif Display', serif;
      font-size: 16px;
      color: var(--navy);
      margin-bottom: 20px;
      padding-bottom: 12px;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* ══ FORM FIELDS ══ */
    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }
<<<<<<< HEAD

    .form-grid.full {
      grid-template-columns: 1fr
    }
=======
    .form-grid.full { grid-template-columns: 1fr }
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e

    .field {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }
<<<<<<< HEAD

=======
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    label.field-label {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .09em;
      color: var(--muted);
    }

    .field input[type=text],
    .field input[type=number],
    .field select,
    .field textarea {
      padding: 11px 14px;
      border: 1.5px solid var(--border);
      border-radius: 12px;
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      color: var(--navy);
      background: var(--bg);
      outline: none;
      transition: all .2s;
      width: 100%;
      -webkit-appearance: none;
      appearance: none;
    }
<<<<<<< HEAD

=======
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    .field input:focus,
    .field select:focus,
    .field textarea:focus {
      border-color: var(--teal);
      background: #fff;
<<<<<<< HEAD
      box-shadow: 0 0 0 3px rgba(15, 159, 142, .08);
    }

=======
      box-shadow: 0 0 0 3px rgba(15,159,142,.08);
    }
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    .field input[readonly],
    .field input[disabled] {
      background: var(--border);
      color: var(--muted);
      cursor: not-allowed;
      opacity: .7;
    }
<<<<<<< HEAD

=======
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    .field textarea {
      resize: vertical;
      min-height: 110px;
      line-height: 1.6;
    }
<<<<<<< HEAD

=======
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    .char-count {
      font-size: 11px;
      color: var(--muted);
      text-align: right;
      margin-top: -2px;
      transition: color .2s;
    }
<<<<<<< HEAD

    .char-count.warn {
      color: #f59e0b
    }

    .char-count.over {
      color: #ef4444
    }
=======
    .char-count.warn { color: #f59e0b }
    .char-count.over { color: #ef4444 }
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e

    .field-hint {
      font-size: 11px;
      color: var(--muted);
      margin-top: -2px;
    }

    /* ══ FOTO PROFILO ══ */
    .foto-wrap {
      display: flex;
      gap: 20px;
      align-items: flex-start;
    }
<<<<<<< HEAD

=======
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    .foto-preview-box {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      overflow: hidden;
      border: 3px solid var(--border);
      background: var(--bg);
      flex-shrink: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }
<<<<<<< HEAD

=======
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    .foto-preview-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }
<<<<<<< HEAD

=======
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    .foto-upload-col {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }
<<<<<<< HEAD

=======
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    .foto-upload-label {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 18px;
      background: var(--teal-lt);
<<<<<<< HEAD
      border: 1.5px dashed rgba(15, 159, 142, .35);
=======
      border: 1.5px dashed rgba(15,159,142,.35);
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
      border-radius: 12px;
      color: var(--teal2);
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: all .2s;
    }
<<<<<<< HEAD

=======
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    .foto-upload-label:hover {
      background: #d1f5f1;
      border-color: var(--teal);
    }
<<<<<<< HEAD

    .foto-upload-input {
      display: none
    }

=======
    .foto-upload-input { display: none }
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    .foto-name {
      font-size: 12px;
      color: var(--muted);
      font-style: italic;
    }
<<<<<<< HEAD

=======
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    .foto-hint {
      font-size: 11px;
      color: var(--muted);
    }

    /* ══ SUBMIT ══ */
    .submit-row {
      display: flex;
      justify-content: flex-end;
      gap: 12px;
      margin-top: 4px;
    }
<<<<<<< HEAD

=======
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    .btn-cancel {
      padding: 12px 24px;
      border: 1.5px solid var(--border);
      border-radius: 13px;
      background: var(--white);
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      font-weight: 600;
      color: var(--muted);
      text-decoration: none;
      cursor: pointer;
      transition: all .2s;
      display: inline-flex;
      align-items: center;
    }
<<<<<<< HEAD

    .btn-cancel:hover {
      border-color: var(--teal);
      color: var(--teal);
      background: var(--teal-lt)
    }

=======
    .btn-cancel:hover { border-color: var(--teal); color: var(--teal); background: var(--teal-lt) }
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    .btn-save {
      padding: 12px 28px;
      background: linear-gradient(135deg, var(--teal), var(--teal2));
      border: none;
      border-radius: 13px;
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      font-weight: 700;
      color: #fff;
      cursor: pointer;
<<<<<<< HEAD
      box-shadow: 0 4px 18px rgba(15, 159, 142, .25);
=======
      box-shadow: 0 4px 18px rgba(15,159,142,.25);
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
      transition: all .2s;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }
<<<<<<< HEAD

    .btn-save:hover {
      opacity: .9;
      transform: translateY(-1px)
    }

    @media(max-width: 640px) {
      .form-grid {
        grid-template-columns: 1fr
      }

      .form-card {
        padding: 20px 18px
      }
=======
    .btn-save:hover { opacity: .9; transform: translateY(-1px) }

    @media(max-width: 640px) {
      .form-grid { grid-template-columns: 1fr }
      .form-card { padding: 20px 18px }
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
    }
  </style>
</head>

<body>

  <header>
    <a href="profilo.php" class="back-btn">
<<<<<<< HEAD
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
        stroke-linecap="round" stroke-linejoin="round">
        <path d="M19 12H5M12 19l-7-7 7-7" />
      </svg>
=======
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
      Torna al Profilo
    </a>
    <a href="home.php" class="nav-logo">
      <span class="cross">✚</span>
      MedicoForum
    </a>
  </header>

  <div class="page-wrapper">

    <div class="page-header">
      <div class="page-label">Impostazioni account</div>
      <div class="page-title">Modifica profilo</div>
      <div class="page-subtitle">Aggiorna le tue informazioni professionali visibili alla community.</div>
    </div>

    <?php if ($successo): ?>
      <div class="alert alert-success">
        ✅ <span>Profilo aggiornato con successo! Le modifiche sono ora visibili.</span>
      </div>
    <?php endif; ?>

    <?php if (!empty($errori)): ?>
      <div class="alert alert-error">
        <div>
          <strong>Correggi i seguenti errori:</strong>
<<<<<<< HEAD
          <ul><?php foreach ($errori as $e): ?>
              <li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
          </ul>
=======
          <ul><?php foreach ($errori as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
        </div>
      </div>
    <?php endif; ?>

    <form method="POST" action="modifica_profilo.php" enctype="multipart/form-data">

      <!-- ── Dati personali ── -->
      <div class="form-card">
        <div class="card-section-title">
<<<<<<< HEAD
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--teal)" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
            <circle cx="12" cy="7" r="4" />
          </svg>
=======
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--teal)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
          Dati personali
        </div>
        <div class="form-grid">
          <div class="field">
            <label class="field-label" for="nome">Nome *</label>
<<<<<<< HEAD
            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($dottore['nome']) ?>" required
              maxlength="100">
          </div>
          <div class="field">
            <label class="field-label" for="cognome">Cognome *</label>
            <input type="text" id="cognome" name="cognome" value="<?= htmlspecialchars($dottore['cognome']) ?>" required
              maxlength="100">
=======
            <input type="text" id="nome" name="nome"
                   value="<?= htmlspecialchars($dottore['nome']) ?>" required maxlength="100">
          </div>
          <div class="field">
            <label class="field-label" for="cognome">Cognome *</label>
            <input type="text" id="cognome" name="cognome"
                   value="<?= htmlspecialchars($dottore['cognome']) ?>" required maxlength="100">
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
          </div>
          <div class="field">
            <label class="field-label">Età</label>
            <input type="text" value="<?= htmlspecialchars($dottore['eta'] ?? '—') ?>" readonly>
            <span class="field-hint">L'età non è modificabile.</span>
          </div>
          <div class="field">
            <label class="field-label">Sesso</label>
            <input type="text" value="<?= $dottore['sesso'] === 'm' ? 'Maschio' : 'Femmina' ?>" readonly>
            <span class="field-hint">Il sesso non è modificabile.</span>
          </div>
        </div>
      </div>

      <!-- ── Biografia ── -->
      <div class="form-card">
        <div class="card-section-title">
<<<<<<< HEAD
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--teal)" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
            <polyline points="14 2 14 8 20 8" />
            <line x1="16" y1="13" x2="8" y2="13" />
            <line x1="16" y1="17" x2="8" y2="17" />
            <polyline points="10 9 9 9 8 9" />
          </svg>
=======
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--teal)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
          Biografia
        </div>
        <div class="form-grid full">
          <div class="field">
            <label class="field-label" for="biografia">Biografia medica</label>
            <textarea id="biografia" name="biografia" maxlength="500"
<<<<<<< HEAD
              placeholder="Descrivi la tua esperienza clinica, aree di interesse e approccio alla medicina…"><?= htmlspecialchars($dottore['biografia'] ?? '') ?></textarea>
=======
                      placeholder="Descrivi la tua esperienza clinica, aree di interesse e approccio alla medicina…"
                      ><?= htmlspecialchars($dottore['biografia'] ?? '') ?></textarea>
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
            <span class="char-count" id="charCount">
              <span id="charNum"><?= mb_strlen($dottore['biografia'] ?? '') ?></span>/500 caratteri
            </span>
          </div>
        </div>
      </div>

      <!-- ── Info professionali ── -->
      <div class="form-card">
        <div class="card-section-title">
<<<<<<< HEAD
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--teal)" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="7" width="20" height="14" rx="2" />
            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
          </svg>
=======
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--teal)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
          Informazioni professionali
        </div>
        <div class="form-grid">
          <div class="field">
            <label class="field-label" for="anni_lavoro">Anni di esperienza</label>
            <input type="number" id="anni_lavoro" name="anni_lavoro" min="0" max="60"
<<<<<<< HEAD
              value="<?= htmlspecialchars($dottore['anni_lavoro'] ?? '') ?>" placeholder="es. 12">
=======
                   value="<?= htmlspecialchars($dottore['anni_lavoro'] ?? '') ?>"
                   placeholder="es. 12">
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
          </div>
          <div class="field">
            <label class="field-label" for="specializzazione">Specializzazione</label>
            <select id="specializzazione" name="specializzazione">
              <option value="">Seleziona specializzazione</option>
              <?php foreach ($specializzazioni as $s): ?>
<<<<<<< HEAD
                <option value="<?= htmlspecialchars($s['codice']) ?>" <?= $s['codice'] == $dottore['cod_spec'] ? 'selected' : '' ?>>
=======
                <option value="<?= htmlspecialchars($s['codice']) ?>"
                  <?= $s['codice'] == $dottore['cod_spec'] ? 'selected' : '' ?>>
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
                  <?= htmlspecialchars($s['nome']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="field" style="grid-column: 1 / -1">
            <label class="field-label" for="ospedale">Ospedale</label>
            <select id="ospedale" name="ospedale">
              <option value="">Seleziona ospedale</option>
              <?php foreach ($ospedali as $o): ?>
<<<<<<< HEAD
                <option value="<?= htmlspecialchars($o['id_ospedale']) ?>" <?= $o['id_ospedale'] == $dottore['id_ospedale'] ? 'selected' : '' ?>>
=======
                <option value="<?= htmlspecialchars($o['id_ospedale']) ?>"
                  <?= $o['id_ospedale'] == $dottore['id_ospedale'] ? 'selected' : '' ?>>
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
                  <?= htmlspecialchars($o['nome'] . ' — ' . $o['citta']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>

      <!-- ── Foto profilo ── -->
      <div class="form-card">
        <div class="card-section-title">
<<<<<<< HEAD
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--teal)" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="18" height="18" rx="2" />
            <circle cx="8.5" cy="8.5" r="1.5" />
            <polyline points="21 15 16 10 5 21" />
          </svg>
=======
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="var(--teal)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
          Foto profilo
        </div>
        <div class="foto-wrap">
          <div class="foto-preview-box">
            <img src="img/<?= htmlspecialchars($dottore['foto_profilo']) ?>" id="fotoPreview" alt="Foto attuale">
          </div>
          <div class="foto-upload-col">
            <label class="foto-upload-label" for="foto_profilo">
<<<<<<< HEAD
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                <polyline points="17 8 12 3 7 8" />
                <line x1="12" y1="3" x2="12" y2="15" />
              </svg>
              Carica nuova foto
            </label>
            <input type="file" id="foto_profilo" name="foto_profilo" class="foto-upload-input"
              accept="image/jpeg,image/png,image/webp">
=======
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
              Carica nuova foto
            </label>
            <input type="file" id="foto_profilo" name="foto_profilo" class="foto-upload-input"
                   accept="image/jpeg,image/png,image/webp">
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
            <div class="foto-name" id="fotoName">Nessun file scelto</div>
            <div class="foto-hint">JPG, PNG o WEBP · Max 4 MB. Caricare una nuova foto sostituirà quella attuale.</div>
          </div>
        </div>
      </div>

      <!-- ── Pulsanti ── -->
      <div class="submit-row">
        <a href="profilo.php" class="btn-cancel">Annulla</a>
        <button type="submit" class="btn-save">
<<<<<<< HEAD
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
            <polyline points="17 21 17 13 7 13 7 21" />
            <polyline points="7 3 7 8 15 8" />
          </svg>
=======
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
          Salva modifiche
        </button>
      </div>

    </form>
  </div>

  <script>
    // ── Contatore biografia ──
    const bio = document.getElementById('biografia');
    const num = document.getElementById('charNum');
<<<<<<< HEAD
    const cc = document.getElementById('charCount');
=======
    const cc  = document.getElementById('charCount');
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e

    bio.addEventListener('input', function () {
      const n = this.value.length;
      num.textContent = n;
      cc.className = 'char-count' + (n > 450 ? (n >= 500 ? ' over' : ' warn') : '');
    });

    // ── Preview foto ──
    const fotoInput = document.getElementById('foto_profilo');
<<<<<<< HEAD
    const fotoName = document.getElementById('fotoName');
    const fotoPrev = document.getElementById('fotoPreview');
=======
    const fotoName  = document.getElementById('fotoName');
    const fotoPrev  = document.getElementById('fotoPreview');
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e

    fotoInput.addEventListener('change', function () {
      if (this.files && this.files[0]) {
        fotoName.textContent = this.files[0].name;
        const reader = new FileReader();
        reader.onload = e => fotoPrev.src = e.target.result;
        reader.readAsDataURL(this.files[0]);
      }
    });
  </script>

</body>
<<<<<<< HEAD

</html>
=======
</html>
>>>>>>> 3b332312760e69449220779db658b6cdbc6ba79e
