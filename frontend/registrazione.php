 
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrati — MedicoForum</title>
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
            --muted:     #6b82a0;
            --border:    #dde5ef;
        }

        html, body {
            min-height: 100%;
            background: var(--bg);
            color: var(--navy);
            font-family: 'DM Sans', sans-serif;
        }

        /* ─── Grain overlay ─── */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 999;
            opacity: 0.3;
        }

        /* ═══════════ LAYOUT ═══════════ */
        .auth-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ═══════════ SINISTRA: VISUAL ═══════════ */
        .auth-visual-side {
            flex: 1;
            position: relative;
            overflow: hidden;
            animation: revealLeft 1s cubic-bezier(0.16,1,0.3,1) both;
        }

        @keyframes revealLeft {
            from { opacity: 0; transform: translateX(-24px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .visual-bg {
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1551601651-2a8555f1a136?w=1400&q=85&fit=crop') center/cover no-repeat;
            transform: scale(1.03);
            transition: transform 12s ease-in-out;
        }

        .visual-bg.zoomed { transform: scale(1); }

        /* Multi-layer overlay */
        .visual-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(to right, rgba(13,31,60,0.25) 0%, transparent 55%),
                linear-gradient(to top, rgba(13,31,60,0.92) 0%, rgba(13,31,60,0.35) 40%, transparent 65%),
                linear-gradient(135deg, rgba(13,31,60,0.5) 0%, rgba(15,159,142,0.08) 100%);
        }

        /* Slide dots */
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
            box-shadow: 0 0 12px rgba(15,159,142,0.5);
        }

        /* Content in basso */
        .visual-content {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            z-index: 3;
            padding: 56px;
        }

        .visual-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(15,159,142,0.15);
            border: 1px solid rgba(15,159,142,0.35);
            border-radius: 100px;
            padding: 8px 18px;
            font-size: 12px;
            font-weight: 600;
            color: #5dd8cc;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 22px;
            backdrop-filter: blur(8px);
        }

        .visual-tag::before {
            content: '';
            width: 6px; height: 6px;
            background: #5dd8cc;
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.5; transform: scale(1.5); }
        }

        .visual-headline {
            font-family: 'DM Serif Display', serif;
            font-size: clamp(28px, 3vw, 46px);
            line-height: 1.15;
            color: var(--white);
            margin-bottom: 16px;
            max-width: 460px;
        }

        .visual-headline em {
            font-style: italic;
            color: #5dd8cc;
        }

        .visual-desc {
            font-size: 15px;
            color: rgba(255,255,255,0.5);
            line-height: 1.7;
            max-width: 340px;
            font-weight: 300;
            margin-bottom: 36px;
        }

        /* Benefits list */
        .benefits {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 14px;
            color: rgba(255,255,255,0.75);
            font-size: 14px;
            font-weight: 400;
        }

        .benefit-icon {
            width: 34px;
            height: 34px;
            background: rgba(15,159,142,0.18);
            border: 1px solid rgba(15,159,142,0.3);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
            backdrop-filter: blur(6px);
        }

        /* ═══════════ DESTRA: FORM ═══════════ */
        .auth-form-side {
            width: 540px;
            flex-shrink: 0;
            background: var(--bg2);
            border-left: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 0 56px 48px;
            position: relative;
            overflow-y: auto;
            animation: revealRight 1s cubic-bezier(0.16,1,0.3,1) 0.15s both;
        }

        @keyframes revealRight {
            from { opacity: 0; transform: translateX(24px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* Ambient glows */
        .auth-form-side::before {
            content: '';
            position: fixed;
            top: -100px; right: -60px;
            width: 320px; height: 320px;
            background: radial-gradient(circle, rgba(15,159,142,0.06) 0%, transparent 70%);
            pointer-events: none;
        }

        .form-inner {
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 1;
            padding-top: 52px;
        }

        /* ── Logo ── */
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            margin-bottom: 44px;
        }

        .logo-mark {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--teal) 0%, var(--teal2) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #ffffff;
            box-shadow: 0 8px 24px rgba(15,159,142,0.2);
        }

        .logo-text {
            font-family: 'DM Serif Display', serif;
            font-size: 22px;
            color: var(--navy);
            letter-spacing: -0.3px;
        }

        /* ── Header ── */
        .form-header {
            margin-bottom: 36px;
        }

        .form-eyebrow {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--teal);
            margin-bottom: 10px;
        }

        .form-title {
            font-family: 'DM Serif Display', serif;
            font-size: 32px;
            line-height: 1.1;
            color: var(--navy);
            letter-spacing: -0.5px;
            margin-bottom: 8px;
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

        /* ── Step indicator ── */
        .steps {
            display: flex;
            align-items: center;
            gap: 0;
            margin-bottom: 36px;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: 0.04em;
            cursor: pointer;
            transition: color 0.3s;
        }

        .step.active { color: var(--teal); }
        .step.done   { color: var(--teal); }

        .step-num {
            width: 26px; height: 26px;
            border-radius: 50%;
            background: var(--bg);
            border: 1.5px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            transition: all 0.3s;
            flex-shrink: 0;
        }

        .step.active .step-num {
            background: var(--teal);
            border-color: var(--teal);
            color: #fff;
            box-shadow: 0 4px 12px rgba(15,159,142,0.25);
        }

        .step.done .step-num {
            background: var(--teal);
            border-color: var(--teal);
            color: #fff;
        }

        .step-line {
            flex: 1;
            height: 1.5px;
            background: var(--border);
            margin: 0 10px;
            transition: background 0.3s;
        }

        .step-line.done { background: var(--teal); }

        /* ── Form panels ── */
        .form-panel {
            display: none;
        }

        .form-panel.active {
            display: block;
            animation: panelIn 0.4s cubic-bezier(0.16,1,0.3,1) both;
        }

        @keyframes panelIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Fields ── */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .field {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 9px;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            pointer-events: none;
            transition: opacity 0.2s;
            opacity: 0.5;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 14px 16px 14px 42px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: var(--navy);
            background: #f7f9fc;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            transition: all 0.25s ease;
            outline: none;
            appearance: none;
        }

        input:focus, select:focus {
            background: var(--white);
            border-color: var(--teal);
            box-shadow: 0 0 0 4px rgba(15,159,142,0.08);
        }

        input::placeholder { color: #b0c0d4; }

        .input-hint {
            font-size: 11px;
            color: var(--muted);
            margin-top: 6px;
            opacity: 0.7;
        }

        /* Password strength */
        .pwd-strength {
            display: flex;
            gap: 4px;
            margin-top: 8px;
        }

        .pwd-bar {
            flex: 1;
            height: 3px;
            background: var(--border);
            border-radius: 100px;
            transition: background 0.3s;
        }

        .pwd-bar.weak   { background: #f87171; }
        .pwd-bar.medium { background: #fbbf24; }
        .pwd-bar.strong { background: var(--teal); }

        .pwd-label {
            font-size: 11px;
            color: var(--muted);
            margin-top: 6px;
        }

        /* select arrow */
        .select-wrap { position: relative; }
        .select-wrap::after {
            content: '▾';
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            color: var(--muted);
            pointer-events: none;
        }

        /* Checkbox privacy */
        .check-group {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px;
            background: #f7f9fc;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            margin-bottom: 20px;
            cursor: pointer;
            transition: border-color 0.2s;
        }

        .check-group:has(input:checked) {
            border-color: var(--teal);
            background: rgba(15,159,142,0.04);
        }

        .check-group input[type="checkbox"] {
            width: 18px; height: 18px;
            flex-shrink: 0;
            padding: 0;
            margin-top: 1px;
            accent-color: var(--teal);
            cursor: pointer;
            border-radius: 4px;
        }

        .check-text {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.5;
        }

        .check-text a {
            color: var(--teal);
            text-decoration: none;
            font-weight: 600;
        }

        /* Buttons */
        .btn-row {
            display: flex;
            gap: 12px;
            margin-top: 8px;
        }

        .btn-back {
            flex: 0 0 auto;
            padding: 15px 20px;
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            color: var(--muted);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-back:hover {
            border-color: var(--navy);
            color: var(--navy);
        }

        .btn-next,
        .btn-submit {
            flex: 1;
            padding: 15px;
            background: linear-gradient(135deg, var(--teal) 0%, var(--teal2) 100%);
            border: none;
            border-radius: 12px;
            color: var(--navy);
            font-family: 'DM Sans', sans-serif;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 6px 20px rgba(15,159,142,0.2);
            position: relative;
            overflow: hidden;
        }

        .btn-next::after,
        .btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.18) 0%, transparent 60%);
        }

        .btn-next:hover,
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(15,159,142,0.3);
        }

        /* ── Footer ── */
        .card-footer {
            text-align: center;
            font-size: 13px;
            color: var(--muted);
            font-weight: 300;
            margin-top: 28px;
        }

        .card-footer a {
            color: var(--teal);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .card-footer a:hover { color: var(--teal2); }

        /* Security note */
        .security-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 28px;
            font-size: 11px;
            color: var(--muted);
            letter-spacing: 0.08em;
            opacity: 0.55;
        }

        /* ── Stagger animations ── */
        .form-inner > * {
            animation: fadeUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
        }

        .logo        { animation-delay: 0.3s; }
        .form-header { animation-delay: 0.38s; }
        .steps       { animation-delay: 0.44s; }
        .form-panel  { animation-delay: 0.5s; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 1000px) {
            .auth-visual-side { display: none; }
            .auth-form-side { width: 100%; padding: 0 32px 48px; }
        }

        @media (max-width: 500px) {
            .form-row { grid-template-columns: 1fr; }
            .auth-form-side { padding: 0 20px 40px; }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">

    <!-- ════ SINISTRA: VISUAL ════ -->
    <div class="auth-visual-side">
        <div class="visual-bg" id="visualBg"></div>
        <div class="visual-overlay"></div>

        <div class="slide-dots">
            <div class="dot active"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>

        <div class="visual-content">
            <div class="visual-tag">Registrazione gratuita</div>
            <h2 class="visual-headline">
                Entra nella<br><em>community</em><br>dei medici italiani
            </h2>
            <p class="visual-desc">
                Accedi a casi clinici rari, confrontati con specialisti e tieniti aggiornato in un ambiente verificato e sicuro.
            </p>
            <div class="benefits">
                <div class="benefit-item">
                    <div class="benefit-icon">🔬</div>
                    Casi clinici e discussioni specialistiche
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">🤝</div>
                    Networking con 14.800+ colleghi
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">📚</div>
                    ECM e aggiornamenti in tempo reale
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">🔒</div>
                    Ambiente esclusivo con verifica FNOMCeO
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
                <p class="form-eyebrow">Iscrizione gratuita</p>
                <h1 class="form-title">Unisciti a<br><em>MedicoForum</em></h1>
                <p class="form-sub">Crea il tuo account verificato in pochi minuti.</p>
            </div>

            <!-- Step indicator -->
            <div class="steps">
                <div class="step active" id="s1" onclick="goStep(1)">
                    <div class="step-num">1</div>
                    Dati personali
                </div>
                <div class="step-line" id="line1"></div>
                <div class="step" id="s2" onclick="goStep(2)">
                    <div class="step-num">2</div>
                    Professione
                </div>
                <div class="step-line" id="line2"></div>
                <div class="step" id="s3" onclick="goStep(3)">
                    <div class="step-num">3</div>
                    Sicurezza
                </div>
            </div>

            <form action="registrazione_process.php" method="POST" id="regForm">

                <!-- ─ STEP 1: Dati personali ─ -->
                <div class="form-panel active" id="panel1">

                    <div class="form-row">
                        <div class="field">
                            <label for="nome">Nome</label>
                            <div class="input-wrap">
                                <span class="input-icon">👤</span>
                                <input type="text" id="nome" name="nome" placeholder="Mario" required>
                            </div>
                        </div>
                        <div class="field">
                            <label for="cognome">Cognome</label>
                            <div class="input-wrap">
                                <span class="input-icon">👤</span>
                                <input type="text" id="cognome" name="cognome" placeholder="Rossi" required>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label for="email">Indirizzo Email</label>
                        <div class="input-wrap">
                            <span class="input-icon">✉️</span>
                            <input type="email" id="email" name="email" placeholder="mario.rossi@email.it" required>
                        </div>
                    </div>

                    <div class="field">
                        <label for="username">Username</label>
                        <div class="input-wrap">
                            <span class="input-icon">@</span>
                            <input type="text" id="username" name="username" placeholder="es. m.rossi" required>
                        </div>
                        <p class="input-hint">Sarà il tuo identificativo nella community.</p>
                    </div>

                    <div class="btn-row">
                        <button type="button" class="btn-next" onclick="nextStep(1)">Continua →</button>
                    </div>
                </div>

                <!-- ─ STEP 2: Professione ─ -->
                <div class="form-panel" id="panel2">

                    <div class="field">
                        <label for="ordine">N° Iscrizione Ordine (FNOMCeO)</label>
                        <div class="input-wrap">
                            <span class="input-icon">🏥</span>
                            <input type="text" id="ordine" name="ordine" placeholder="Es. 12345 — Provincia" required>
                        </div>
                        <p class="input-hint">Necessario per la verifica come medico.</p>
                    </div>

                    <div class="field">
                        <label for="specialita">Specializzazione</label>
                        <div class="input-wrap select-wrap">
                            <span class="input-icon">🩺</span>
                            <select id="specialita" name="specialita">
                                <option value="" disabled selected>Seleziona la tua specialità</option>
                                <option>Medicina Generale</option>
                                <option>Cardiologia</option>
                                <option>Neurologia</option>
                                <option>Oncologia</option>
                                <option>Pediatria</option>
                                <option>Chirurgia Generale</option>
                                <option>Ginecologia</option>
                                <option>Ortopedia</option>
                                <option>Psichiatria</option>
                                <option>Radiologia</option>
                                <option>Altra specialità</option>
                            </select>
                        </div>
                    </div>

                    <div class="field">
                        <label for="struttura">Struttura / Ospedale</label>
                        <div class="input-wrap">
                            <span class="input-icon">🏛️</span>
                            <input type="text" id="struttura" name="struttura" placeholder="Es. Ospedale Niguarda, Milano">
                        </div>
                    </div>

                    <div class="btn-row">
                        <button type="button" class="btn-back" onclick="prevStep(2)">← Indietro</button>
                        <button type="button" class="btn-next" onclick="nextStep(2)">Continua →</button>
                    </div>
                </div>

                <!-- ─ STEP 3: Sicurezza ─ -->
                <div class="form-panel" id="panel3">

                    <div class="field">
                        <label for="password">Password</label>
                        <div class="input-wrap">
                            <span class="input-icon">🔑</span>
                            <input type="password" id="password" name="password" placeholder="Crea una password sicura" required oninput="checkPwd(this.value)">
                            <button type="button" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--muted);font-size:14px;" id="togglePwd">👁</button>
                        </div>
                        <div class="pwd-strength">
                            <div class="pwd-bar" id="bar1"></div>
                            <div class="pwd-bar" id="bar2"></div>
                            <div class="pwd-bar" id="bar3"></div>
                            <div class="pwd-bar" id="bar4"></div>
                        </div>
                        <p class="pwd-label" id="pwdLabel">Minimo 8 caratteri, una maiuscola e un numero.</p>
                    </div>

                    <div class="field">
                        <label for="conferma">Conferma Password</label>
                        <div class="input-wrap">
                            <span class="input-icon">🔑</span>
                            <input type="password" id="conferma" name="conferma" placeholder="Ripeti la password" required>
                        </div>
                    </div>

                    <label class="check-group" style="text-transform:none;letter-spacing:0;font-weight:400;display:flex;">
                        <input type="checkbox" name="privacy" required>
                        <span class="check-text">Accetto i <a href="#">Termini di Servizio</a> e la <a href="#">Privacy Policy</a>. Confermo di essere un professionista sanitario registrato.</span>
                    </label>

                    <div class="btn-row">
                        <button type="button" class="btn-back" onclick="prevStep(3)">← Indietro</button>
                        <button type="submit" class="btn-submit">Crea account ✓</button>
                    </div>
                </div>

            </form>

            <div class="card-footer">
                Hai già un account? <a href="login.php">Accedi qui</a>
            </div>

            <div class="security-note">
                <svg width="11" height="13" viewBox="0 0 12 14" fill="none">
                    <path d="M6 1L1 3.5V7C1 9.76 3.24 12.22 6 13C8.76 12.22 11 9.76 11 7V3.5L6 1Z" stroke="currentColor" stroke-width="1.2" fill="none"/>
                </svg>
                Dati protetti · Verifica FNOMCeO · GDPR compliant
            </div>

        </div>
    </div>

</div>

<script>
    // ── Multi-step form ──
    let currentStep = 1;
    const totalSteps = 3;

    function goStep(n) {
        if (n > currentStep) return; // Non si può saltare avanti
        showStep(n);
    }

    function nextStep(from) {
        // Validazione base del pannello corrente
        const panel = document.getElementById('panel' + from);
        const inputs = panel.querySelectorAll('input[required], select[required]');
        for (const inp of inputs) {
            if (!inp.value.trim()) {
                inp.focus();
                inp.style.borderColor = '#f87171';
                setTimeout(() => inp.style.borderColor = '', 1500);
                return;
            }
        }
        if (from < totalSteps) showStep(from + 1);
    }

    function prevStep(from) {
        if (from > 1) showStep(from - 1);
    }

    function showStep(n) {
        // Nascondi tutti i pannelli
        document.querySelectorAll('.form-panel').forEach(p => p.classList.remove('active'));
        document.getElementById('panel' + n).classList.add('active');

        // Aggiorna step indicators
        for (let i = 1; i <= totalSteps; i++) {
            const s = document.getElementById('s' + i);
            s.classList.remove('active', 'done');
            if (i < n)  s.classList.add('done');
            if (i === n) s.classList.add('active');
        }

        // Aggiorna linee
        for (let i = 1; i < totalSteps; i++) {
            const line = document.getElementById('line' + i);
            line.classList.toggle('done', i < n);
        }

        currentStep = n;
    }

    // ── Password strength ──
    function checkPwd(val) {
        const bars   = [1,2,3,4].map(i => document.getElementById('bar' + i));
        const label  = document.getElementById('pwdLabel');
        const scores = [val.length >= 8, /[A-Z]/.test(val), /[0-9]/.test(val), /[^a-zA-Z0-9]/.test(val)];
        const score  = scores.filter(Boolean).length;
        const levels = ['','weak','weak','medium','strong'];
        const labels = ['','Troppo corta','Debole','Discreta','Ottima! 🔒'];

        bars.forEach((b, i) => {
            b.className = 'pwd-bar';
            if (i < score) b.classList.add(levels[score]);
        });

        label.textContent = val.length ? labels[score] : 'Minimo 8 caratteri, una maiuscola e un numero.';
    }

    // ── Toggle password ──
    document.getElementById('togglePwd').addEventListener('click', function () {
        const pwd  = document.getElementById('password');
        const show = pwd.type === 'password';
        pwd.type  = show ? 'text' : 'password';
        this.textContent = show ? '🙈' : '👁';
    });

    // ── Ken Burns effect sul visual ──
    setTimeout(() => document.getElementById('visualBg').classList.add('zoomed'), 100);
</script>

</body>
</html>