<?php
require_once 'database.php'; // includo il file di configurazione

// Controllo di sicurezza: se l'utente non è loggato, reindirizza al Login
if (!isset($_SESSION['utente'])) {
    header("Location: Login.php");
    exit();
}

try {
    $connessione = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $connessione->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Errore nella gestione del database $db: " . $e->getMessage());
}

// ── LOGICA PROFILO DINAMICO ──
$id_richiesto = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$id_profilo = $id_richiesto > 0 ? $id_richiesto : $_SESSION['utente'];

// Flag booleano per capire se il profilo visualizzato è di chi ha fatto l'accesso
$is_own_profile = ($id_profilo == $_SESSION['utente']);

// ── LOGICA GESTIONE DELLA PROVENIENZA (BACK BUTTON) ──
$disc_id = isset($_GET['disc']) ? (int) $_GET['disc'] : 0;
if ($disc_id > 0) {
    $back_url = "discussione.php?id=" . $disc_id;
    $back_text = "Torna alla Discussione";
} else {
    $back_url = "home.php";
    $back_text = "Torna alla Home";
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo Medico | MedicoForum</title>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
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
            --r: 14px;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--navy);
            overflow-x: hidden;
        }

        /* ── Grain Effect ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.025'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 9999;
            opacity: .3;
        }

        /* ══════════ NAVBAR ══════════ */
        header {
            position: sticky;
            top: 0;
            z-index: 200;
            background: rgba(255, 255, 255, .97);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            height: 64px;
            display: flex;
            align-items: center;
            padding: 0 5%;
            gap: 20px;
            box-shadow: 0 1px 0 var(--border), 0 4px 20px rgba(13, 31, 60, .04);
        }

        .back-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--muted);
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 10px;
            transition: all .2s;
            background: var(--bg);
            border: 1px solid var(--border);
            white-space: nowrap;
        }

        .back-btn:hover {
            color: var(--teal);
            border-color: var(--teal);
            background: var(--teal-lt);
        }

        .edit-profile-btn {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--teal2);
            text-decoration: none;
            padding: 7px 16px;
            border-radius: 10px;
            background: var(--teal-lt);
            border: 1.5px solid rgba(15, 159, 142, .25);
            transition: all .2s;
        }

        .edit-profile-btn:hover {
            background: #d1f5f1;
            border-color: var(--teal);
            transform: translateY(-1px);
        }

        .nav-logo {
            font-family: 'DM Serif Display', serif;
            font-size: 20px;
            color: var(--navy);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
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
        }

        /* ══════════ LAYOUT 2 COLONNE ══════════ */
        .page-wrapper {
            max-width: 1100px;
            margin: 0 auto;
            padding: 30px 24px 100px;
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 24px;
            align-items: start;
        }

        /* ══════════ SIDEBAR (SINISTRA) ══════════ */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: sticky;
            top: 90px;
        }

        .profile-card {
            background: linear-gradient(160deg, var(--navy) 0%, #132d54 100%);
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .06);
            box-shadow: 0 12px 30px rgba(13, 31, 60, .15);
        }

        .profile-cover {
            height: 100px;
            background: linear-gradient(135deg, var(--teal), var(--teal2));
            position: relative;
            overflow: hidden;
        }

        .profile-cover::after {
            content: '';
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=500&q=50') center/cover no-repeat;
            opacity: .25;
        }

        .profile-info {
            padding: 0 24px 24px;
            margin-top: -40px;
            position: relative;
            text-align: center;
        }

        .big-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--white), #f0f4f8);
            border: 4px solid var(--navy);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 800;
            color: var(--teal);
            margin: 0 auto 12px;
            box-shadow: 0 4px 14px rgba(15, 159, 142, .35);
            object-fit: cover;
        }

        .pname {
            font-family: 'DM Serif Display', serif;
            font-size: 22px;
            color: #fff;
            margin-bottom: 2px;
        }

        .puser {
            font-size: 13px;
            color: var(--teal);
            font-weight: 500;
            margin-bottom: 16px;
        }

        .spec-badge {
            display: inline-block;
            background: rgba(15, 159, 142, .2);
            border: 1px solid rgba(15, 159, 142, .4);
            color: #5dd8cc;
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .profile-stats {
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
            text-align: left;
        }

        .pstat {
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 12px;
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pstat-label {
            font-size: 11px;
            color: rgba(255, 255, 255, .45);
            text-transform: uppercase;
            letter-spacing: .06em;
            font-weight: 600;
        }

        .pstat-val {
            font-size: 13px;
            color: #fff;
            font-weight: 500;
            padding-left: 10px;
            text-align: end;
        }

        /* Widget Contatto */
        .widget {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(13, 31, 60, .05);
        }

        .widget-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            font-family: 'DM Serif Display', serif;
            font-size: 16px;
            color: var(--navy);
        }

        .widget-body {
            padding: 20px;
        }

        .contact-form textarea {
            width: 100%;
            padding: 14px;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            color: var(--navy);
            background: var(--bg);
            resize: vertical;
            min-height: 100px;
            margin-bottom: 12px;
            outline: none;
            transition: all .2s;
        }

        .contact-form textarea:focus {
            border-color: var(--teal);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(15, 159, 142, .08);
        }

        .btn-submit {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--teal);
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            box-shadow: 0 4px 16px rgba(15, 159, 142, .3);
            font-family: 'DM Sans', sans-serif;
        }

        .btn-submit:hover {
            background: var(--teal2);
            transform: translateY(-1px);
        }

        /* ══════════ MAIN FEED E ABOUT CARD (DESTRA) ══════════ */
        main {
            min-width: 0;
            animation: fadeUp .5s ease .1s both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* About Card */
        .about-card {
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: 18px;
            padding: 28px;
            margin-bottom: 32px;
            box-shadow: 0 2px 10px rgba(13, 31, 60, .04);
        }

        .about-title {
            font-family: 'DM Serif Display', serif;
            font-size: 22px;
            color: var(--navy);
            margin-bottom: 14px;
        }

        .about-text {
            font-size: 14.5px;
            color: var(--muted);
            line-height: 1.6;
        }

        .sub-heading {
            font-size: 13px;
            font-weight: 700;
            color: var(--navy);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 12px;
        }

        .skills-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 24px;
        }

        .skill-pill {
            background: var(--bg);
            border: 1px solid var(--border);
            color: var(--navy);
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
        }

        .pub-list {
            list-style: none;
            padding: 0;
        }

        .pub-list li {
            font-size: 13.5px;
            color: var(--muted);
            padding-left: 18px;
            position: relative;
            margin-bottom: 12px;
            line-height: 1.5;
        }

        .pub-list li::before {
            content: '•';
            color: var(--teal);
            position: absolute;
            left: 0;
            font-size: 18px;
            top: -2px;
        }

        .pub-list li strong {
            color: var(--navy);
        }

        /* Feed Posts */
        .feed-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .feed-title {
            font-family: 'DM Serif Display', serif;
            font-size: 24px;
            letter-spacing: -.3px;
            color: var(--navy);
        }

        .question-card {
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: 18px;
            padding: 22px 24px;
            margin-bottom: 16px;
            box-shadow: 0 2px 10px rgba(13, 31, 60, .04);
            transition: all .25s;
        }

        .question-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(13, 31, 60, .09);
            border-color: rgba(15, 159, 142, .25);
        }

        .card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
            gap: 10px;
        }

        .card-tags {
            display: flex;
            gap: 6px;
            align-items: center;
            flex-wrap: wrap;
        }

        .spec-tag {
            background: var(--teal-lt);
            color: var(--teal2);
            padding: 4px 11px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .03em;
            border: 1px solid rgba(15, 159, 142, .15);
        }

        .date-tag {
            font-size: 12px;
            color: var(--muted);
            font-weight: 500;
        }

        .question-title {
            font-family: 'DM Serif Display', serif;
            font-size: 18px;
            line-height: 1.35;
            color: var(--navy);
            margin-bottom: 9px;
            cursor: pointer;
            transition: color .2s;
        }

        .question-title:hover {
            color: var(--teal);
        }

        .question-preview {
            font-size: 13.5px;
            color: var(--muted);
            line-height: 1.65;
            font-weight: 400;
            margin-bottom: 16px;
        }

        .card-footer {
            border-top: 1px solid var(--border);
            padding-top: 13px;
        }

        .read-more {
            font-size: 12px;
            font-weight: 600;
            color: var(--teal);
            text-decoration: none;
            transition: color .2s;
        }

        .read-more:hover {
            color: var(--teal2);
        }

        /* Pinned card */
        .btn-logout {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #f8d7da;
            color: #b02a37;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .btn-logout:hover {
            background-color: #b02a37;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(176, 42, 55, 0.2);
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <header>
        <a href="<?= $back_url ?>" class="back-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
            <?= $back_text ?>
        </a>

        <?php if ($is_own_profile): ?>
            <a href="modifica_profilo.php" class="edit-profile-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                </svg>
                Modifica profilo
            </a>
        <?php endif; ?>

        <div class="nav-logo">
            <span class="cross">✚</span>
            MedicoForum
        </div>
    </header>

    <div class="page-wrapper">

        <aside class="sidebar">

            <div class="profile-card">
                <div class="profile-cover"></div>
                <div class="profile-info">
                    <?php
                    $sql = "SELECT d.nome AS nome, d.cognome, d.sesso, d.biografia, d.data_inizio_lavoro, 
                            o.nome AS nomeO, d.foto_profilo, s.nome AS nomeS, 
                            (SELECT COUNT(*) FROM domande WHERE dottore = d.id_dottore) AS nPost 
                            FROM dottori d
                            JOIN ospedali o ON d.ospedale = o.id_ospedale
                            JOIN specializzazioni s ON d.specializzazione = s.codice
                            WHERE d.id_dottore = ?";
                    $profilo = $connessione->prepare($sql);
                    $profilo->execute(array($id_profilo));

                    if ($profilo->rowCount() > 0) {
                        $profilo = $profilo->fetch(PDO::FETCH_ASSOC);
                        echo '<img src="img/' . $profilo["foto_profilo"] . '" class="big-avatar">
                        <h1 class="pname">';
                        if ($profilo["sesso"] == 'm') {
                            echo 'Dr. ';
                        } else {
                            echo 'Dott.ssa ';
                        }
                        echo htmlspecialchars($profilo["nome"] . ' ' . $profilo["cognome"]) . '</h1>
                        <div class="spec-badge">' . htmlspecialchars($profilo["nomeS"]) . '</div>
                        
                        <div class="profile-stats">
                        <div class="pstat">
                            <span class="pstat-label">Ospedale</span>
                            <span class="pstat-val">' . htmlspecialchars($profilo["nomeO"]) . '</span>
                        </div>
                        <div class="pstat">
                            <span class="pstat-label">Esperienza</span>
                            <span class="pstat-val">' . (date('Y') - date('Y', strtotime($profilo["data_inizio_lavoro"]))) . ' anni</span>
                        </div>
                        <div class="pstat">
                            <span class="pstat-label">Post pubblicati</span>
                            <span class="pstat-val">' . $profilo["nPost"] . '</span>
                        </div>
                        ';
                    }
                    ?>

                    <?php if ($is_own_profile): ?>
                        <a href="login.php" class="btn-logout"><span class="icon"></span> Esci dal Profilo</a>
                    <?php endif; ?>
                </div>
            </div>
    </div>

    </aside>

    <main>
        <article class="about-card">
            <h2 class="about-title">Biografia Medica</h2>
            <?php
            echo '<p class="about-text">' . nl2br(htmlspecialchars($profilo['biografia'])) . '</p>';
            ?>
        </article>

        <div class="feed-header">
            <h2 class="feed-title" style="color: #0b7d6f !important;">Attività nel Forum</h2>
        </div>
        <h4 class="feed-title" style="margin-bottom: 20px;">Domande</h4>

        <?php
        $sql = 'SELECT titolo, corpo, data_domanda, id_domanda FROM domande WHERE dottore=? ORDER BY data_domanda DESC';
        $domande = $connessione->prepare($sql);
        $domande->execute(array($id_profilo));

        if ($domande->rowCount() > 0) {
            while ($domanda = $domande->fetch(PDO::FETCH_ASSOC)) {
                echo '<article class="question-card">
            <div class="card-top">';
                echo '<span class="date-tag">' . date('d/m/Y', strtotime($domanda['data_domanda'])) . '</span>
            </div>
            <h3 class="question-title">' . htmlspecialchars($domanda['titolo']) . '</h3>
            <p class="question-preview">' . htmlspecialchars($domanda['corpo']) . '</p>
            <div class="card-footer">
                <a href="discussione.php?id=' . $domanda["id_domanda"] . '" class="read-more">Leggi la discussione →</a>
            </div>
        </article>';
            }
        } else {
            if ($is_own_profile) {
                echo '<p class="about-text">Non hai ancora pubblicato nessuna domanda. Condividi i tuoi casi clinici per ricevere feedback dalla community!</p>';
            } else {
                echo '<p class="about-text">Questo medico non ha ancora pubblicato nessuna domanda.</p>';
            }
        }

        echo '<h4 class="feed-title" style="margin-top: 30px; margin-bottom: 20px;">Risposte</h4>';

        $sql = 'SELECT corpo, data_risposta, domanda FROM risposte WHERE dottore=? ORDER BY data_risposta DESC';
        $risposte = $connessione->prepare($sql);
        $risposte->execute(array($id_profilo));

        if ($risposte->rowCount() > 0) {
            while ($risposta = $risposte->fetch(PDO::FETCH_ASSOC)) {
                echo '<article class="question-card">
            <div class="card-top">
                <span class="date-tag">' . date('d/m/Y', strtotime($risposta['data_risposta'])) . '</span>
            </div>
            <p class="question-preview">' . htmlspecialchars($risposta['corpo']) . '</p>
            <div class="card-footer">
                <a href="discussione.php?id=' . $risposta["domanda"] . '" class="read-more">Leggi la discussione →</a>
            </div>
        </article>';
            }
        } else {
            if ($is_own_profile) {
                echo '<p class="about-text">Non hai ancora risposto a nessuna domanda. Partecipa alle discussioni per condividere la tua esperienza!</p>';
            } else {
                echo '<p class="about-text">Questo medico non ha ancora risposto a nessuna domanda.</p>';
            }
        }
        ?>
    </main>

    </div>

</body>

</html>