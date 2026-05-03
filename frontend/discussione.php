<?php
require_once 'database.php';

if (!isset($_SESSION['utente'])) {
  header("Location: Login.php");
  exit();
}

try {
  $connessione = new PDO("mysql:host=$host;dbname=$db", $user, $password);
  $connessione->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Errore nella gestione del database: " . $e->getMessage());
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
  header("Location: home.php");
  exit();
}

// ── Gestione nuova risposta ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'rispondi') {
  $corpo = trim($_POST['corpo'] ?? '');
  if ($corpo !== '') {
    $sql = "INSERT INTO risposte (corpo, domanda, dottore, data_risposta) VALUES (?, ?, ?, NOW())";
    $ins = $connessione->prepare($sql);
    $ins->execute([$corpo, $id, $_SESSION['utente']]);
  }
  header("Location: discussione.php?id=$id");
  exit();
}

// ── Fetch domanda ──
$sql = "SELECT titolo, corpo, data_domanda,dottori.nome AS nomeD, cognome, sesso, foto_profilo, specializzazioni.nome AS nomeS
        FROM domande 
        JOIN dottori ON dottore = id_dottore
        JOIN specializzazioni ON specializzazione = codice
        WHERE id_domanda = ?";
$stmt = $connessione->prepare($sql);
$stmt->execute([$id]);
$domanda = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$domanda) {
  header("Location: home.php");
  exit();
}

// ── Fetch risposte ──
$sql = "SELECT corpo, data_risposta, dottori.nome AS nomeD, cognome, sesso, foto_profilo
        FROM risposte
        JOIN dottori ON dottore = id_dottore
        WHERE domanda = ?
        ORDER BY data_risposta ASC";
$stmt = $connessione->prepare($sql);
$stmt->execute([$id]);
$risposte = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($domanda['titolo']) ?> | MedicoForum</title>
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
      --reply-bg: #f5f9ff;
    }

    html {
      scroll-behavior: smooth
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg);
      color: var(--navy);
      overflow-x: hidden;
      display: flex;
      flex-direction: column;
      height: 100vh;
    }

    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.025'/%3E%3C/svg%3E");
      pointer-events: none;
      z-index: 9999;
      opacity: .3;
    }

    /* ══ NAVBAR ══ */
    header {
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
      flex-shrink: 0;
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
      white-space: nowrap;
    }

    .back-btn:hover {
      color: var(--teal);
      border-color: var(--teal);
      background: var(--teal-lt)
    }

    .back-btn svg {
      flex-shrink: 0
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
    }

    .thread-topic {
      font-size: 12px;
      font-weight: 600;
      color: var(--muted);
      background: var(--teal-lt);
      border: 1px solid rgba(15, 159, 142, .2);
      border-radius: 100px;
      padding: 5px 14px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 360px;
    }

    /* ══ LAYOUT ══ */
    .chat-layout {
      display: grid;
      grid-template-columns: 1fr 360px;
      gap: 0;
      flex: 1;
      overflow: hidden;
      min-height: 0;
      padding: 0 5%;
    }

    /* ══ LEFT: RISPOSTE ══ */
    .chat-left {
      display: flex;
      flex-direction: column;
      border-right: 1px solid var(--border);
      overflow: hidden;
      background: var(--bg);
      border: 1px solid var(--border);
    }

    .replies-header {
      padding: 16px 22px 12px;
      border-bottom: 1px solid var(--border);
      background: var(--white);
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-shrink: 0;
    }

    .replies-title {
      font-family: 'DM Serif Display', serif;
      font-size: 16px;
      color: var(--navy);
    }

    .replies-count {
      background: var(--teal-lt);
      color: var(--teal2);
      border: 1px solid rgba(15, 159, 142, .2);
      border-radius: 100px;
      font-size: 11px;
      font-weight: 700;
      padding: 3px 10px;
      letter-spacing: .04em;
    }

    .replies-scroll {
      flex: 1;
      overflow-y: auto;
      padding: 16px 18px;
      display: flex;
      flex-direction: column;
      gap: 12px;
      scrollbar-width: thin;
      scrollbar-color: var(--border) transparent;
    }

    .reply-bubble {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 16px 16px 16px 4px;
      padding: 16px 18px;
      box-shadow: 0 2px 10px rgba(13, 31, 60, .04);
      animation: fadeUp .35s ease both;
    }

    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(10px)
      }

      to {
        opacity: 1;
        transform: translateY(0)
      }
    }

    .reply-author {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 10px;
    }

    .reply-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--teal-lt);
      flex-shrink: 0;
    }

    .reply-name {
      font-weight: 700;
      font-size: 13.5px;
      color: var(--navy);
    }

    .reply-date {
      font-size: 11px;
      color: var(--muted);
      margin-top: 1px;
    }

    .reply-body {
      font-size: 14px;
      color: var(--navy);
      line-height: 1.65;
      font-weight: 400;
    }

    .empty-replies {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 10px;
      flex: 1;
      color: var(--muted);
      text-align: center;
      padding: 40px 24px;
    }

    .empty-icon {
      font-size: 40px;
      opacity: .4;
    }

    .empty-text {
      font-size: 14px;
      font-weight: 500;
    }

    /* ══ REPLY INPUT ══ */
    .reply-input-area {
      border-top: 1px solid var(--border);
      background: var(--white);
      padding: 14px 18px;
      flex-shrink: 0;
    }

    .reply-input-row {
      display: flex;
      gap: 10px;
      align-items: flex-end;
    }

    .reply-textarea {
      flex: 1;
      padding: 11px 14px;
      border: 1.5px solid var(--border);
      border-radius: 14px;
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      color: var(--navy);
      background: var(--bg);
      outline: none;
      resize: none;
      min-height: 46px;
      max-height: 140px;
      transition: all .2s;
      line-height: 1.5;
    }

    .reply-textarea:focus {
      border-color: var(--teal);
      background: #fff;
      box-shadow: 0 0 0 3px rgba(15, 159, 142, .08);
    }

    .reply-textarea::placeholder {
      color: #aabcce
    }

    .send-btn {
      width: 46px;
      height: 46px;
      border-radius: 13px;
      background: linear-gradient(135deg, var(--teal), var(--teal2));
      border: none;
      color: #fff;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 14px rgba(15, 159, 142, .25);
      transition: all .2s;
      flex-shrink: 0;
    }

    .send-btn:hover {
      opacity: .88;
      transform: translateY(-1px)
    }

    .send-btn svg {
      width: 18px;
      height: 18px;
      stroke: #fff;
      fill: none;
      stroke-width: 2.2;
      stroke-linecap: round;
      stroke-linejoin: round
    }

    /* ══ RIGHT: DOMANDA ══ */
    .chat-right {
      display: flex;
      flex-direction: column;
      overflow: hidden;
      background: var(--white);
    }

    .question-panel {
      flex: 1;
      overflow-y: auto;
      padding: 24px 24px 20px;
      scrollbar-width: thin;
      scrollbar-color: var(--border) transparent;
    }

    .q-label {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(196, 154, 60, .1);
      border: 1px solid rgba(196, 154, 60, .3);
      color: var(--gold);
      border-radius: 100px;
      font-size: 10px;
      font-weight: 800;
      letter-spacing: .1em;
      text-transform: uppercase;
      padding: 4px 11px;
      margin-bottom: 14px;
    }

    .q-label::before {
      content: '';
      width: 5px;
      height: 5px;
      background: var(--gold);
      border-radius: 50%;
    }

    .q-title {
      font-family: 'DM Serif Display', serif;
      font-size: 22px;
      line-height: 1.3;
      color: var(--navy);
      margin-bottom: 14px;
    }

    .q-body {
      font-size: 14px;
      line-height: 1.75;
      color: #334765;
      margin-bottom: 22px;
    }

    .q-divider {
      height: 1px;
      background: var(--border);
      margin-bottom: 18px;
    }

    .q-author {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .q-avatar {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--border);
    }

    .q-author-name {
      font-weight: 700;
      font-size: 14px;
      color: var(--navy);
    }

    .q-author-spec {
      font-size: 12px;
      color: var(--muted);
      margin-top: 2px;
    }

    .q-date {
      margin-top: 4px;
      font-size: 11px;
      color: var(--muted);
      font-weight: 500;
    }

    /* ══ RESPONSIVE ══ */
    @media(max-width: 820px) {
      .chat-layout {
        grid-template-columns: 1fr;
        grid-template-rows: auto 1fr;
      }

      .chat-right {
        border-bottom: 1px solid var(--border);
        max-height: 280px;
      }

      .chat-left {
        border-right: none;
      }

      .thread-topic {
        display: none
      }
    }
  </style>
</head>

<body>

  <header>
    <a href="home.php" class="back-btn">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
        stroke-linecap="round" stroke-linejoin="round">
        <path d="M19 12H5M12 19l-7-7 7-7" />
      </svg>
      Torna alla Home
    </a>
    <div class="thread-topic">💬 <?= $domanda['titolo'] ?></div>
    <a href="home.php" class="nav-logo">
      <span class="cross">✚</span>
      MedicoForum
    </a>
  </header>

  <div class="chat-layout">

    <!-- ══ SINISTRA: RISPOSTE ══ -->
    <div class="chat-left">

      <div class="replies-header">
        <div class="replies-title">💬 Risposte</div>
        <span class="replies-count"><?= count($risposte) ?> rispost<?= count($risposte) !== 1 ? 'e' : 'a' ?></span>
      </div>

      <div class="replies-scroll" id="repliesScroll">
        <?php if (empty($risposte)): ?>
          <div class="empty-replies">
            <div class="empty-icon">🩺</div>
            <div class="empty-text">Nessuna risposta ancora.<br>Sii il primo a contribuire!</div>
          </div>
        <?php else: ?>
          <?php foreach ($risposte as $i => $r): ?>
            <div class="reply-bubble" style="animation-delay: <?= $i * 0.05 ?>s">
              <div class="reply-author">
                <img src="img/<?= htmlspecialchars($r['foto_profilo']) ?>" class="reply-avatar" alt="">
                <div>
                  <div class="reply-name">
                    <?= $r['sesso'] === 'm' ? 'Dr.' : 'Dott.ssa' ?>
                    <?= htmlspecialchars($r['nomeD'] . ' ' . $r['cognome']) ?>
                  </div>
                  <div class="reply-date">
                    <?= date('d/m/Y', strtotime($r['data_risposta'])) ?>
                  </div>
                </div>
              </div>
              <div class="reply-body"><?= htmlspecialchars($r['corpo']) ?></div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <!-- INPUT RISPOSTA -->
      <div class="reply-input-area">
        <form method="POST" action="discussione.php?id=<?= $id ?>">
          <input type="hidden" name="action" value="rispondi">
          <div class="reply-input-row">
            <textarea class="reply-textarea" name="corpo" id="replyText" rows="1" placeholder="Scrivi la tua risposta…"
              required></textarea>
            <button type="submit" class="send-btn" title="Invia risposta">
              <svg viewBox="0 0 24 24">
                <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" />
              </svg>
            </button>
          </div>
        </form>
      </div>

    </div><!-- /chat-left -->

    <!-- ══ DESTRA: DOMANDA ══ -->
    <div class="chat-right">
      <div class="question-panel">

        <div class="q-label">Domanda</div>

        <h1 class="q-title"><?= htmlspecialchars($domanda['titolo']) ?></h1>

        <p class="q-body"><?= nl2br(htmlspecialchars($domanda['corpo'])) ?></p>

        <div class="q-divider"></div>

        <div class="q-author">
          <img src="img/<?= htmlspecialchars($domanda['foto_profilo']) ?>" class="q-avatar" alt="">
          <div>
            <div class="q-author-name">
              <?= $domanda['sesso'] === 'm' ? 'Dr.' : 'Dott.ssa' ?>
              <?= htmlspecialchars($domanda['nomeD'] . ' ' . $domanda['cognome']) ?>
            </div>
            <div class="q-author-spec"><?= htmlspecialchars($domanda['nomeS']) ?></div>
            <div class="q-date">
              📅 <?= date('d/m/Y', strtotime($domanda['data_domanda'])) ?>
            </div>
          </div>
        </div>

      </div>
    </div><!-- /chat-right -->

  </div><!-- /chat-layout -->

  <script>
    // Auto-scroll risposte in fondo
    const scroll = document.getElementById('repliesScroll');
    if (scroll) scroll.scrollTop = scroll.scrollHeight;

    // Auto-resize textarea
    const ta = document.getElementById('replyText');
    ta.addEventListener('input', function () {
      this.style.height = 'auto';
      this.style.height = Math.min(this.scrollHeight, 140) + 'px';
    });
  </script>

</body>

</html>