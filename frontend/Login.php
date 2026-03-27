
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accesso — MedicoForum</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #f0f4f8;
            --bg2:       #ffffff;
            --white:     #ffffff;
            --navy:      #0d1f3c;
            --teal:      #0f9f8e;
            --teal2:     #0b8070;
            --teal-glow: rgba(15,159,142,0.12);
            --gold:      #b8894a;
            --muted:     #6b82a0;
            --border:    #dde5ef;
            --radius:    20px;
        }

        html, body {
            height: 100%;
            background: var(--bg);
            color: var(--navy);
            font-family: 'DM Sans', sans-serif;
            overflow: hidden;
        }

        /* ─── Grain overlay ─── */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 999;
            opacity: 0.35;
        }

        /* ─── Layout ─── */
        .auth-wrapper {
            display: flex;
            height: 100vh;
        }

        /* ═══════════ SINISTRA ═══════════ */
        .auth-visual-side {
            flex: 1.1;
            position: relative;
            overflow: hidden;
            animation: revealLeft 1s cubic-bezier(0.16,1,0.3,1) both;
        }

        @keyframes revealLeft {
            from { opacity: 0; transform: translateX(-24px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* Slideshow */
        .slideshow-container {
            position: absolute;
            inset: 0;
        }

        .slide {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 1.4s ease-in-out;
            transform: scale(1.04);
            transition: opacity 1.4s ease-in-out, transform 8s ease-in-out;
        }

        .slide.active {
            opacity: 1;
            transform: scale(1);
        }

        /* Multi-layer overlay */
        .visual-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(to right, rgba(11,20,35,0.3) 0%, transparent 50%),
                linear-gradient(to top, rgba(11,20,35,0.95) 0%, rgba(11,20,35,0.4) 40%, transparent 70%),
                linear-gradient(135deg, rgba(11,20,35,0.6) 0%, rgba(15,159,142,0.1) 100%);
            z-index: 2;
        }

        /* Contenuto sopra la foto */
        .visual-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 3;
            padding: 60px 56px;
        }

        .visual-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(45,212,191,0.12);
            border: 1px solid rgba(45,212,191,0.3);
            border-radius: 100px;
            padding: 8px 18px;
            font-size: 12px;
            font-weight: 600;
            color: var(--teal);
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 24px;
            backdrop-filter: blur(8px);
        }

        .visual-tag::before {
            content: '';
            width: 6px;
            height: 6px;
            background: var(--teal);
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.5; transform: scale(1.4); }
        }

        .visual-headline {
            font-family: 'DM Serif Display', serif;
            font-size: clamp(30px, 3.5vw, 50px);
            line-height: 1.15;
            color: var(--white);
            margin-bottom: 18px;
            max-width: 480px;
        }

        .visual-headline em {
            font-style: italic;
            color: var(--teal);
        }

        .visual-desc {
            font-size: 15px;
            color: rgba(255,255,255,0.55);
            line-height: 1.7;
            max-width: 360px;
            font-weight: 300;
            margin-bottom: 36px;
        }

        /* Stats row */
        .stats-row {
            display: flex;
            gap: 36px;
        }

        .stat {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .stat-num {
            font-family: 'DM Serif Display', serif;
            font-size: 26px;
            color: var(--white);
            letter-spacing: -0.5px;
        }

        .stat-label {
            font-size: 12px;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 600;
        }

        .stat-divider {
            width: 1px;
            background: rgba(255,255,255,0.12);
            align-self: stretch;
        }

        /* Slide indicators */
        .slide-dots {
            position: absolute;
            top: 50%;
            right: 28px;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            gap: 10px;
            z-index: 4;
        }

        .dot {
            width: 3px;
            height: 20px;
            background: rgba(255,255,255,0.2);
            border-radius: 100px;
            cursor: pointer;
            transition: all 0.4s ease;
        }

        .dot.active {
            background: var(--teal);
            height: 36px;
            box-shadow: 0 0 12px rgba(45,212,191,0.5);
        }

        /* ═══════════ DESTRA ═══════════ */
        .auth-form-side {
            width: 480px;
            flex-shrink: 0;
            background: var(--bg2);
            border-left: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 56px;
            position: relative;
            overflow: hidden;
            animation: revealRight 1s cubic-bezier(0.16,1,0.3,1) 0.15s both;
        }

        @keyframes revealRight {
            from { opacity: 0; transform: translateX(24px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* Ambient glow top-right */
        .auth-form-side::before {
            content: '';
            position: absolute;
            top: -120px;
            right: -80px;
            width: 360px;
            height: 360px;
            background: radial-gradient(circle, rgba(15,159,142,0.06) 0%, transparent 70%);
            pointer-events: none;
        }

        .auth-form-side::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -60px;
            width: 280px;
            height: 280px;
            background: radial-gradient(circle, rgba(184,137,74,0.04) 0%, transparent 65%);
            pointer-events: none;
        }

        .form-inner {
            width: 100%;
            max-width: 360px;
            position: relative;
            z-index: 1;
        }

        /* ── Logo ── */
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            margin-bottom: 52px;
        }

        .logo-mark {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--teal) 0%, var(--teal2) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #ffffff;
            box-shadow: 0 8px 24px rgba(15,159,142,0.25);
        }

        .logo-text {
            font-family: 'DM Serif Display', serif;
            font-size: 22px;
            color: var(--navy);
            letter-spacing: -0.3px;
        }

        /* ── Header ── */
        .form-header {
            margin-bottom: 44px;
        }

        .form-eyebrow {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--teal);
            margin-bottom: 12px;
        }

        .form-title {
            font-family: 'DM Serif Display', serif;
            font-size: 36px;
            line-height: 1.1;
            color: var(--navy);
            letter-spacing: -0.5px;
            margin-bottom: 10px;
        }

        .form-title em {
            font-style: italic;
            color: var(--teal);
        }

        .form-sub {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.6;
            font-weight: 300;
        }

        /* ── Fields ── */
        .field {
            margin-bottom: 24px;
        }

        label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 10px;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 15px;
            pointer-events: none;
            transition: color 0.2s;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 15px 18px 15px 46px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            color: var(--navy);
            background: #f7f9fc;
            border: 1.5px solid var(--border);
            border-radius: 14px;
            transition: all 0.25s ease;
            outline: none;
        }

        input:focus {
            background: var(--white);
            border-color: var(--teal);
            box-shadow: 0 0 0 4px rgba(15,159,142,0.08), inset 0 0 0 1px rgba(15,159,142,0.1);
        }

        input:focus + .input-focus-line { width: 100%; }
        input:focus ~ .input-icon { color: var(--teal); }

        .input-focus-line {
            height: 1px;
            background: linear-gradient(to right, transparent, var(--teal), transparent);
            width: 0;
            transition: width 0.4s ease;
            margin: 0 auto;
        }

        input::placeholder { color: #b0c0d4; }

        /* password toggle */
        .btn-eye {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            font-size: 15px;
            padding: 4px;
            transition: color 0.2s;
            line-height: 1;
        }

        .btn-eye:hover { color: var(--teal); }

        /* forgot */
        .link-row {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .link {
            font-size: 12px;
            font-weight: 600;
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s;
            letter-spacing: 0.02em;
        }

        .link:hover { color: var(--teal); }

        /* ── Submit ── */
        .btn-submit {
            width: 100%;
            margin-top: 8px;
            padding: 17px;
            background: linear-gradient(135deg, var(--teal) 0%, var(--teal2) 100%);
            border: none;
            border-radius: 14px;
            color: #0b1423;
            font-family: 'DM Sans', sans-serif;
            font-weight: 700;
            font-size: 15px;
            letter-spacing: 0.03em;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
            box-shadow: 0 8px 28px rgba(45,212,191,0.25);
            position: relative;
            overflow: hidden;
        }

        .btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 60%);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 36px rgba(45,212,191,0.35);
        }

        .btn-submit:active {
            transform: translateY(0);
            opacity: 0.9;
        }

        /* ── Divider ── */
        .divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 32px 0;
            color: var(--muted);
            font-size: 12px;
            letter-spacing: 0.1em;
            opacity: 0.6;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── Footer ── */
        .card-footer {
            text-align: center;
            font-size: 13px;
            color: var(--muted);
            font-weight: 300;
        }

        .card-footer a {
            color: var(--teal);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .card-footer a:hover { color: var(--teal2); }

        /* Security badge */
        .security-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 36px;
            font-size: 11px;
            color: var(--muted);
            letter-spacing: 0.08em;
            opacity: 0.6;
        }

        .security-note svg {
            opacity: 0.7;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 960px) {
            .auth-visual-side { display: none; }
            .auth-form-side {
                width: 100%;
                padding: 48px 32px;
            }
        }

        /* ── Stagger animations ── */
        .form-inner > * {
            animation: fadeUp 0.6s cubic-bezier(0.16,1,0.3,1) both;
        }

        .logo         { animation-delay: 0.3s; }
        .form-header  { animation-delay: 0.4s; }
        .field:nth-child(1) { animation-delay: 0.5s; }
        .field:nth-child(2) { animation-delay: 0.55s; }
        .btn-submit   { animation-delay: 0.6s; }
        .divider      { animation-delay: 0.65s; }
        .card-footer  { animation-delay: 0.7s; }
        .security-note { animation-delay: 0.75s; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">

    <!-- ════ SINISTRA: HERO + SLIDESHOW ════ -->
    <div class="auth-visual-side">

        <div class="slideshow-container">
            <!-- Foto mediche ad alta qualità -->
            <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=1400&q=85&fit=crop" class="slide active" alt="Laboratorio medico">
            <img src="https://images.unsplash.com/photo-1504813184591-01572f98c85f?w=1400&q=85&fit=crop" class="slide" alt="Chirurgo al lavoro">
            <img src="https://images.unsplash.com/photo-1551076805-e1869033e561?w=1400&q=85&fit=crop" class="slide" alt="Diagnostica moderna">
            <img src="https://images.unsplash.com/photo-1530026405186-ed1f139313f8?w=1400&q=85&fit=crop" class="slide" alt="Ricercatrice">
            <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=1400&q=85&fit=crop" class="slide" alt="Medico con paziente">
        </div>

        <div class="visual-overlay"></div>

        <!-- Dots navigazione -->
        <div class="slide-dots">
            <div class="dot active" data-index="0"></div>
            <div class="dot" data-index="1"></div>
            <div class="dot" data-index="2"></div>
            <div class="dot" data-index="3"></div>
            <div class="dot" data-index="4"></div>
        </div>

        <!-- Contenuto in basso -->
        <div class="visual-content">
            <div class="visual-tag">Piattaforma verificata</div>
            <h2 class="visual-headline">
                Dove la <em>medicina</em><br>incontra la comunità
            </h2>
            <p class="visual-desc">
                Forum esclusivo per professionisti della salute. Casi clinici, ricerca e aggiornamenti in un ambiente riservato.
            </p>
            <div class="stats-row">
                <div class="stat">
                    <span class="stat-num">14.800+</span>
                    <span class="stat-label">Medici iscritti</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat">
                    <span class="stat-num">320+</span>
                    <span class="stat-label">Specialità</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat">
                    <span class="stat-num">98k</span>
                    <span class="stat-label">Discussioni</span>
                </div>
            </div>
        </div>

    </div>

    <!-- ════ DESTRA: FORM ════ -->
    <div class="auth-form-side">
        <div class="form-inner">

            <a href="index.html" class="logo">
                <div class="logo-mark">✚</div>
                <div class="logo-text">MedicoForum</div>
            </a>

            <div class="form-header">
                <p class="form-eyebrow">Accesso riservato</p>
                <h1 class="form-title">Bentornato,<br><em>Collega</em></h1>
                <p class="form-sub">Inserisci le tue credenziali per accedere alla community.</p>
            </div>

            <form action="prima.php" method="post" autocomplete="off">

                <div class="field">
                    <label for="username">Username</label>
                    <div class="input-wrap">
                        <span class="input-icon">👤</span>
                        <input type="text" id="username" name="username" placeholder="es. m.rossi" required>
                        <div class="input-focus-line"></div>
                    </div>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <span class="input-icon">🔑</span>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                        <button type="button" class="btn-eye" id="togglePwd" aria-label="Mostra password">👁</button>
                        <div class="input-focus-line"></div>
                    </div>
                    <div class="link-row">
                        <a href="recupero_password.php" class="link">Password dimenticata?</a>
                    </div>
                </div>

                <input class="btn-submit" type="submit" name="submit" value="Accedi →">

            </form>

            <div class="divider">oppure</div>

            <div class="card-footer">
                Non hai ancora un account?
                <a href="registrazione.php">Registrati gratuitamente</a>
            </div>

            <div class="security-note">
                <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 1L1 3.5V7C1 9.76 3.24 12.22 6 13C8.76 12.22 11 9.76 11 7V3.5L6 1Z" stroke="currentColor" stroke-width="1.2" fill="none"/>
                </svg>
                Connessione sicura · Crittografia end-to-end
            </div>

        </div>
    </div>

</div>

<script>
    // ── Slideshow con Ken Burns ──
    document.addEventListener('DOMContentLoaded', function () {

        const slides = document.querySelectorAll('.slide');
        const dots   = document.querySelectorAll('.dot');
        let current  = 0;

        function goTo(n) {
            slides[current].classList.remove('active');
            dots[current].classList.remove('active');
            current = n;
            slides[current].classList.add('active');
            dots[current].classList.add('active');
        }

        // Auto-advance
        setInterval(() => goTo((current + 1) % slides.length), 4500);

        // Dots click
        dots.forEach(d => d.addEventListener('click', () => goTo(+d.dataset.index)));

        // ── Toggle password ──
        const toggleBtn = document.getElementById('togglePwd');
        const pwdInput  = document.getElementById('password');

        toggleBtn.addEventListener('click', function () {
            const show = pwdInput.type === 'password';
            pwdInput.type   = show ? 'text' : 'password';
            toggleBtn.textContent = show ? '🙈' : '👁';
        });

    });
</script>

</body>
</html>