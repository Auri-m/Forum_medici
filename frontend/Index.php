<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedicoForum — La community dei professionisti della salute</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700;900&family=Mulish:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:       #f5f7fa;
            --white:    #ffffff;
            --navy:     #0a1f3c;
            --teal:     #1a9b8f;
            --teal2:    #0d7a6f;
            --sky:      #e8f4f3;
            --muted:    #6b8099;
            --border:   #e0e8ef;
            --radius:   16px;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Mulish', sans-serif;
            background: var(--bg);
            color: var(--navy);
            overflow-x: hidden;
        }

        /* ─────────── NAVBAR ─────────── */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            background: rgba(255,255,255,0.82);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--border);
            padding: 0 5%;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: fadeDown 0.5s ease both;
        }

        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .nav-logo {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 22px;
            color: var(--navy);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 9px;
        }
        .nav-logo .cross {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, var(--teal), var(--teal2));
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 17px;
            font-weight: 900;
            flex-shrink: 0;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .nav-links a {
            font-size: 14px;
            font-weight: 500;
            color: var(--muted);
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            transition: color 0.2s, background 0.2s;
        }
        .nav-links a:hover {
            color: var(--navy);
            background: var(--sky);
        }
        .nav-links .btn-accedi {
            background: var(--navy);
            color: #fff;
            padding: 9px 22px;
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.2s, transform 0.15s;
        }
        .nav-links .btn-accedi:hover {
            background: var(--teal2);
            transform: translateY(-1px);
            color: #fff;
        }

        /* ─────────── HERO ─────────── */
        .hero {
            min-height: 100vh;
            padding: 120px 5% 80px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 55% 60% at 80% 30%, rgba(26,155,143,0.09) 0%, transparent 65%),
                radial-gradient(ellipse 40% 40% at 10% 90%, rgba(10,31,60,0.05) 0%, transparent 60%);
            pointer-events: none;
        }

        .hero-text { animation: slideLeft 0.7s cubic-bezier(0.22,1,0.36,1) 0.1s both; }

        @keyframes slideLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--sky);
            border: 1px solid rgba(26,155,143,0.2);
            color: var(--teal2);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 6px 14px;
            border-radius: 100px;
            margin-bottom: 24px;
        }
        .hero-badge::before {
            content: '';
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--teal);
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(38px, 4.5vw, 62px);
            font-weight: 900;
            line-height: 1.1;
            letter-spacing: -1px;
            margin-bottom: 22px;
        }
        .hero h1 em {
            font-style: italic;
            color: var(--teal);
        }

        .hero p {
            font-size: 17px;
            color: var(--muted);
            line-height: 1.7;
            max-width: 480px;
            margin-bottom: 36px;
            font-weight: 300;
        }

        .hero-cta {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }
        .btn-primary {
            display: inline-block;
            background: linear-gradient(135deg, var(--teal), var(--teal2));
            color: #fff;
            padding: 15px 32px;
            border-radius: var(--radius);
            font-family: 'Mulish', sans-serif;
            font-weight: 700;
            font-size: 15px;
            text-decoration: none;
            box-shadow: 0 6px 28px rgba(26,155,143,0.28);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 36px rgba(26,155,143,0.36);
        }
        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--navy);
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            padding: 15px 24px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            background: var(--white);
            transition: border-color 0.2s, background 0.2s;
        }
        .btn-ghost:hover {
            border-color: var(--teal);
            background: var(--sky);
        }

        /* ─────────── HERO IMAGE MOSAIC ─────────── */
        .hero-visual {
            position: relative;
            height: 520px;
            animation: slideRight 0.7s cubic-bezier(0.22,1,0.36,1) 0.2s both;
        }

        @keyframes slideRight {
            from { opacity: 0; transform: translateX(30px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .img-card {
            position: absolute;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(10,31,60,0.14);
        }
        .img-card img {
            width: 100%; height: 100%;
            object-fit: cover;
            display: block;
        }

        .img-main {
            width: 64%;
            height: 380px;
            top: 0; right: 0;
        }
        .img-sm1 {
            width: 42%;
            height: 220px;
            bottom: 0; left: 0;
            box-shadow: 0 16px 48px rgba(10,31,60,0.16);
        }
        .img-sm2 {
            width: 32%;
            height: 150px;
            bottom: 80px; right: 66%;
            transform: translateX(50%);
            box-shadow: 0 12px 32px rgba(10,31,60,0.12);
        }

        /* floating stat pill */
        .stat-pill {
            position: absolute;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 100px;
            padding: 10px 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 24px rgba(10,31,60,0.1);
            font-size: 13px;
            font-weight: 600;
            color: var(--navy);
            white-space: nowrap;
            animation: float 3.5s ease-in-out infinite;
        }
        @keyframes float {
            0%,100% { transform: translateY(0); }
            50%      { transform: translateY(-7px); }
        }
        .stat-pill .icon {
            width: 32px; height: 32px;
            background: var(--sky);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
        }
        .pill-1 { top: 30px; left: -20px; animation-delay: 0s; }
        .pill-2 { bottom: 30px; right: -10px; animation-delay: 1.2s; }

        /* ─────────── STATS BAR ─────────── */
        .stats-bar {
            background: var(--navy);
            padding: 40px 5%;
            display: flex;
            justify-content: space-around;
            gap: 24px;
            flex-wrap: wrap;
        }
        .stat-item {
            text-align: center;
            animation: fadeUp 0.5s ease both;
        }
        .stat-item:nth-child(2) { animation-delay: 0.1s; }
        .stat-item:nth-child(3) { animation-delay: 0.2s; }
        .stat-item:nth-child(4) { animation-delay: 0.3s; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 40px;
            font-weight: 700;
            color: var(--teal);
            line-height: 1;
        }
        .stat-label {
            font-size: 13px;
            color: rgba(255,255,255,0.5);
            margin-top: 6px;
            font-weight: 300;
            letter-spacing: 0.04em;
        }

        /* ─────────── FEATURES ─────────── */
        .section {
            padding: 96px 5%;
        }
        .section-tag {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--teal);
            margin-bottom: 12px;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(28px, 3vw, 42px);
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.5px;
            margin-bottom: 16px;
        }
        .section-sub {
            font-size: 16px;
            color: var(--muted);
            max-width: 520px;
            line-height: 1.7;
            font-weight: 300;
            margin-bottom: 56px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        .feat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 32px 28px;
            transition: transform 0.25s, box-shadow 0.25s;
        }
        .feat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(10,31,60,0.09);
        }
        .feat-icon {
            width: 52px; height: 52px;
            background: var(--sky);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .feat-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 19px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .feat-card p {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.65;
            font-weight: 300;
        }

        /* ─────────── PHOTO STRIP ─────────── */
        .photo-strip {
            padding: 0 5% 80px;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 16px;
            height: 340px;
        }
        .photo-strip .ph {
            border-radius: 20px;
            overflow: hidden;
        }
        .photo-strip .ph img {
            width: 100%; height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.4s;
        }
        .photo-strip .ph:hover img {
            transform: scale(1.04);
        }

        /* ─────────── CTA BANNER ─────────── */
        .cta-banner {
            margin: 0 5% 96px;
            background: linear-gradient(135deg, var(--navy) 0%, #0d3060 100%);
            border-radius: 28px;
            padding: 64px 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
            flex-wrap: wrap;
            position: relative;
            overflow: hidden;
        }
        .cta-banner::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 280px; height: 280px;
            border-radius: 50%;
            background: rgba(26,155,143,0.12);
        }
        .cta-banner::after {
            content: '';
            position: absolute;
            bottom: -80px; left: 30%;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }
        .cta-banner h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(24px, 2.5vw, 36px);
            font-weight: 700;
            color: #fff;
            line-height: 1.25;
            max-width: 480px;
            position: relative;
            z-index: 1;
        }
        .cta-banner h2 em {
            font-style: italic;
            color: var(--teal);
        }
        .cta-banner .cta-btns {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }
        .btn-white {
            background: #fff;
            color: var(--navy);
            padding: 14px 28px;
            border-radius: var(--radius);
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        }
        .btn-outline-white {
            border: 1.5px solid rgba(255,255,255,0.3);
            color: #fff;
            padding: 14px 28px;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: background 0.2s, border-color 0.2s;
        }
        .btn-outline-white:hover {
            background: rgba(255,255,255,0.08);
            border-color: rgba(255,255,255,0.6);
        }

        /* ─────────── FOOTER ─────────── */
        footer {
            background: var(--navy);
            padding: 40px 5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }
        footer .nav-logo { color: #fff; }
        footer p {
            font-size: 13px;
            color: rgba(255,255,255,0.35);
        }

        /* ─────────── RESPONSIVE ─────────── */
        @media (max-width: 900px) {
            .hero { grid-template-columns: 1fr; }
            .hero-visual { height: 320px; }
            .features-grid { grid-template-columns: 1fr 1fr; }
            .photo-strip { grid-template-columns: 1fr 1fr; height: auto; }
            .photo-strip .ph:first-child { grid-column: 1 / -1; height: 240px; }
            .photo-strip .ph { height: 180px; }
        }
        @media (max-width: 600px) {
            nav { padding: 0 4%; }
            .nav-links a:not(.btn-accedi) { display: none; }
            .features-grid { grid-template-columns: 1fr; }
            .cta-banner { padding: 40px 28px; }
        }
    </style>
</head>
<body>

<!-- ══ NAVBAR ══ -->
<nav>
    <a href="#" class="nav-logo">
        <span class="cross">✚</span>
        MedicoForum
    </a>
    <div class="nav-links">
        <a href="#features">Funzionalità</a>
        <a href="#community">Community</a>
        <a href="registrazione.php">Registrati</a>
        <a href="login.php" class="btn-accedi">Accedi →</a>
    </div>
</nav>

<!-- ══ HERO ══ -->
<section class="hero">
    <div class="hero-text">
        <div class="hero-badge">La community dei professionisti della salute</div>
        <h1>Connetti, condividi,<br><em>cresci insieme</em><br>come medico.</h1>
        <p>MedicoForum è lo spazio dedicato ai professionisti della salute per scambiarsi casi clinici, aggiornarsi sulle ultime ricerche e costruire reti professionali solide.</p>
        <div class="hero-cta">
            <a href="registrazione.php" class="btn-primary">Unisciti gratis</a>
            <a href="#features" class="btn-ghost">
                <span>Scopri di più</span>
                <span>↓</span>
            </a>
        </div>
    </div>

    <div class="hero-visual">
        <div class="img-card img-main">
            <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=700&q=80" alt="Medici al lavoro">
        </div>
        <div class="img-card img-sm1">
            <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=400&q=80" alt="Medico sorridente">
        </div>
        <div class="img-card img-sm2">
            <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=300&q=80" alt="Consulto medico">
        </div>

        <div class="stat-pill pill-1">
            <span class="icon">👩‍⚕️</span>
            <span>12.400+ medici iscritti</span>
        </div>
        <div class="stat-pill pill-2">
            <span class="icon">💬</span>
            <span>340 discussioni oggi</span>
        </div>
    </div>
</section>

<!-- ══ STATS BAR ══ -->
<div class="stats-bar">
    <div class="stat-item">
        <div class="stat-num">12k+</div>
        <div class="stat-label">Medici registrati</div>
    </div>
    <div class="stat-item">
        <div class="stat-num">58k</div>
        <div class="stat-label">Casi clinici condivisi</div>
    </div>
    <div class="stat-item">
        <div class="stat-num">180+</div>
        <div class="stat-label">Specializzazioni</div>
    </div>
    <div class="stat-item">
        <div class="stat-num">4.9★</div>
        <div class="stat-label">Valutazione media</div>
    </div>
</div>

<!-- ══ FEATURES ══ -->
<section class="section" id="features">
    <div class="section-tag">Perché MedicoForum</div>
    <h2 class="section-title">Tutto ciò di cui hai bisogno<br>in un unico posto</h2>
    <p class="section-sub">Dalla gestione dei casi clinici alla formazione continua, strumenti pensati per chi lavora in corsia ogni giorno.</p>

    <div class="features-grid">
        <div class="feat-card">
            <div class="feat-icon">🩺</div>
            <h3>Casi Clinici</h3>
            <p>Pubblica e discuti casi complessi con colleghi di tutta Italia. Ottieni un secondo parere in pochi minuti.</p>
        </div>
        <div class="feat-card">
            <div class="feat-icon">📚</div>
            <h3>Aggiornamento Continuo</h3>
            <p>Accedi alle ultime pubblicazioni scientifiche, linee guida e notizie dal mondo della medicina.</p>
        </div>
        <div class="feat-card">
            <div class="feat-icon">🤝</div>
            <h3>Networking Professionale</h3>
            <p>Connettiti con specialisti, trova collaborazioni e costruisci la tua rete professionale nel settore sanitario.</p>
        </div>
        <div class="feat-card">
            <div class="feat-icon">🔒</div>
            <h3>Ambiente Sicuro</h3>
            <p>Piattaforma verificata. Solo medici con iscrizione all'Ordine possono accedere ai contenuti riservati.</p>
        </div>
        <div class="feat-card">
            <div class="feat-icon">📊</div>
            <h3>Statistiche & Dati</h3>
            <p>Dashboard personali con insight sul tuo contributo alla community e sull'andamento delle discussioni.</p>
        </div>
        <div class="feat-card">
            <div class="feat-icon">🔔</div>
            <h3>Notifiche Smart</h3>
            <p>Ricevi aggiornamenti personalizzati sulle tue specializzazioni e non perdere mai una discussione rilevante.</p>
        </div>
    </div>
</section>

<!-- ══ PHOTO STRIP ══ -->
<div class="photo-strip" id="community">
    <div class="ph">
        <img src="https://images.unsplash.com/photo-1551601651-2a8555f1a136?w=900&q=80" alt="Team medico">
    </div>
    <div class="ph">
        <img src="https://images.unsplash.com/photo-1582750433449-648ed127bb54?w=400&q=80" alt="Medico donna">
    </div>
    <div class="ph">
        <img src="https://images.unsplash.com/photo-1631815588090-d4bfec5b1ccb?w=400&q=80" alt="Ospedale moderno">
    </div>
</div>

<!-- ══ CTA BANNER ══ -->
<div class="cta-banner">
    <h2>Pronto a entrare nella <em>più grande community</em> medica italiana?</h2>
    <div class="cta-btns">
        <a href="registrazione.php" class="btn-white">Registrati gratis</a>
        <a href="login.php" class="btn-outline-white">Hai già un account</a>
    </div>
</div>

<!-- ══ FOOTER ══ -->
<footer>
    <a href="#" class="nav-logo">
        <span class="cross">✚</span>
        MedicoForum
    </a>
    <p>© 2025 MedicoForum · Tutti i diritti riservati · Riservato ai professionisti sanitari</p>
</footer>

</body>
</html>