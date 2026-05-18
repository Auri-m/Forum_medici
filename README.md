**Progetto di Masenello Aurora e Nardin Giovanni 5^B** *Documentazione di Progetto - Versione 1.0 · Maggio 2026*

---

## 🩺 Cos'è MedicoForum
MedicoForum è una piattaforma web riservata esclusivamente ai medici, progettata per favorire la collaborazione clinica tra professionisti della salute.  
L'obiettivo è offrire uno spazio protetto dove i dottori possono pubblicare quesiti clinici, ricevere risposte dai colleghi, restare aggiornati tramite notizie mediche in tempo reale e gestire il proprio profilo professionale.

Il progetto nasce dall'esigenza di creare un ambiente di consultazione peer-to-peer strutturato, in cui ogni contributo è riconducibile a un medico verificato con specializzazione, ospedale di riferimento e anni di esperienza. L'accesso è pertanto strettamente vincolato alla registrazione con credenziali univoche.

---

## ✨ Caratteristiche Distintive

- 🔒 **Accesso esclusivo:** Riservato ai professionisti medici registrati.
- 🔍 **Ricerca e Filtri:** Domande filtrabili per specializzazione, ospedale e anni di esperienza. Ricerca testuale full-text su titolo, corpo, nome e cognome dell'autore (con debounce client-side).
- 📰 **Feed Notizie Mediche:** Aggregatore RSS da sorgenti istituzionali italiane (ANSA Salute, Ministero della Salute, ecc.) con cache lato server.
- 👤 **Profilo Medico Completo:** Gestione anagrafica, specializzazione, biografia e upload foto profilo.
- 📝 **Registrazione Multi-step:** Validazione in tempo reale dell'username tramite AJAX. Passaggio da dati anagrafici a professionali, fino alle credenziali.
- 🔐 **Sicurezza:** Password memorizzate con hashing `bcrypt`.

### Funzionalità nel Dettaglio:
* **Registrazione & Login:** Modulo a 3 step con campi obbligatori. Redirect automatico per sessioni attive.
* **Visualizzazione Discussioni:** Lista con requisiti applicati (specializzazione, anni di esperienza, ospedale). Link diretti ai profili.
* **Nuova Domanda & Risposte:** Form con limiti di caratteri (50 per titolo, 500 per corpo). Applicazione fino a 3 requisiti di interazione per chi risponde. Se un utente non soddisfa i requisiti, la piattaforma inibisce la partecipazione.
* **Aggregazione RSS:** Parsing XML tramite `SimpleXML` da 8 sorgenti italiane. Immagini di fallback da Unsplash, cache JSON (TTL 30 min) e fallback statico. Endpoint dedicato con modalità debug e flush della cache.

---

## 🏗️ Architettura e Flusso

Il progetto segue un'architettura **monolitica server-side rendering (SSR)** senza separazione MVC formale. Ogni pagina PHP svolge i ruoli di controller e view contemporaneamente.
La connessione al database è centralizzata in `database.php`, incluso con `require_once` all'inizio di ogni script.

**Flusso tipico di una richiesta:**
1. Il browser invia una richiesta GET o POST alla pagina PHP.
2. `database.php` avvia la sessione e definisce le variabili di connessione.
3. La pagina verifica la sessione attiva; in assenza, reindirizza a `login.php`.
4. La logica di business (query PDO, controlli filtri) viene eseguita in cima al file.
5. L'HTML viene emesso inline con valori già elaborati dal PHP.

*Nessuna pagina è accessibile senza sessione attiva (eccetto Index.php e Login.php). Le password non sono mai in chiaro.*

---

## 📁 Struttura dei File

| File | Responsabilità |
|------|----------------|
| `database.php` | Connessione DB, avvio sessione, configurazione credenziali |
| `Index.php` | Landing page pubblica con presentazione piattaforma e notizie RSS |
| `Login.php` | Form di accesso e verifica credenziali |
| `registrazione.php` | Form multi-step di registrazione (frontend) |
| `Registrazione_process.php` | Backend: validazione, hashing password, upload foto, INSERT transazionale |
| `check_username.php` | API AJAX: verifica disponibilità username in tempo reale |
| `home.php` | Feed discussioni con ricerca, filtri, inserimento nuova domanda e notizie |
| `discussione.php` | Pagina singola discussione con controllo filtri e form risposta |
| `profilo.php` | Visualizzazione profilo pubblico del medico |
| `modifica_profilo.php` | Form e logica di aggiornamento profilo (con upload foto) |
| `NewAPI.php` | Aggregatore RSS notizie mediche con cache e modalità debug |

---

## 🗄️ Database Schema

**Database:** `forum` — **Charset:** `utf8mb4_general_ci` — **Engine:** `InnoDB` — **Server:** `MariaDB 10.4`

### Specializzazioni
| Colonna | Tipo | Vincolo | Note |
|---------|------|---------|------|
| `codice` | INT(11) | PK, AUTO_INC | Identificatore della specializzazione |
| `nome` | VARCHAR(50) | NOT NULL | Es. Cardiologia, Neurologia (20 specialità) |
| `descrizione` | VARCHAR(500) | NULLABLE | Descrizione sintetica dell'ambito clinico |

### Ospedali
| Colonna | Tipo | Vincolo | Note |
|---------|------|---------|------|
| `id_ospedale` | INT(11) | PK, AUTO_INC | Identificatore dell'ospedale |
| `nome` | VARCHAR(50) | NOT NULL | Nome della struttura (15 ospedali del Veneto) |
| `provincia` | VARCHAR(50) | NOT NULL | Sigla della provincia (es. PD, VR, VE) |
| `citta` | VARCHAR(50) | NOT NULL | Comune |
| `via` | VARCHAR(50) | NOT NULL | Via/piazza della sede |
| `civico` | INT(11) | NOT NULL | Numero civico |

### Dottori
| Colonna | Tipo | Vincolo | Note |
|---------|------|---------|------|
| `id_dottore` | INT(11) | PK, AUTO_INC | Identificatore univoco del medico |
| `nome` | VARCHAR(30) | NOT NULL | Nome del medico |
| `cognome` | VARCHAR(30) | NOT NULL | Cognome del medico |
| `sesso` | VARCHAR(1) | NOT NULL | m / f (determina la foto di default) |
| `data_nascita` | DATE | NULLABLE | Data di nascita |
| `data_inizio_lavoro` | DATE | NULLABLE | Data di inizio attività professionale |
| `foto_profilo` | VARCHAR(500) | NULLABLE | Percorso relativo dell'immagine |
| `specializzazione` | INT(11) | FK → specializzazioni.codice | Specializzazione del medico |
| `ospedale` | INT(11) | FK → ospedali.id_ospedale | Struttura ospedaliera di lavoro |
| `biografia` | VARCHAR(500) | NULLABLE | Testo libero di presentazione (max 500 char) |

### Credenziali
| Colonna | Tipo | Vincolo | Note |
|---------|------|---------|------|
| `id_credenziali` | INT(11) | PK, AUTO_INC | Identificatore credenziale |
| `username` | VARCHAR(20) | NOT NULL, UNIQUE | Username univoco per l'accesso |
| `password` | VARCHAR(255) | NULLABLE | Hash bcrypt della password |
| `dottore` | INT(11) | FK → dottori.id_dottore | Medico associato (1:1) |

### Domande
| Colonna | Tipo | Vincolo | Note |
|---------|------|---------|------|
| `id_domanda` | INT(11) | PK, AUTO_INC | Identificatore della discussione |
| `titolo` | VARCHAR(50) | NOT NULL | Titolo sintetico (max 50 char) |
| `corpo` | VARCHAR(500) | NOT NULL | Testo completo del quesito (max 500 char) |
| `data_domanda` | DATE | NULLABLE | Data di pubblicazione |
| `specializzazione_filtro`| INT(11) | FK → specializzazioni (NULL) | Richiede questa specializzazione per rispondere |
| `anni_exp_filtro` | INT(11) | NULLABLE | Anni minimi di esperienza richiesti |
| `ospedale_filtro` | INT(11) | FK → ospedali.id_ospedale (NULL)| Visibile solo ai medici di questo ospedale |
| `dottore` | INT(11) | FK → dottori.id_dottore | Autore della domanda |

### Risposte
| Colonna | Tipo | Vincolo | Note |
|---------|------|---------|------|
| `id_risposta` | INT(11) | PK, AUTO_INC | Identificatore della risposta |
| `corpo` | VARCHAR(500) | NOT NULL | Testo della risposta (max 500 char) |
| `data_risposta` | DATE | DEFAULT current_timestamp() | Data di pubblicazione |
| `dottore` | INT(11) | FK → dottori.id_dottore | Medico che ha risposto |
| `domanda` | INT(11) | FK → domande.id_domanda | Domanda a cui si risponde |

---

## 🔌 Endpoint API

### API RSS Notizie (`GET /NewAPI.php`)
| Parametro | Valore | Descrizione |
|-----------|--------|-------------|
| *(nessuno)* | — | Risposta JSON con gli ultimi 10 articoli medici (dalla cache se disponibile) |
| `?debug=1` | GET | Pagina HTML di debug con log per ogni feed RSS e anteprima card degli articoli |
| `?flush=1` | GET | Svuota il file di cache e forza il ri-fetch di tutti i feed al prossimo accesso |

**Struttura della risposta JSON (modalità standard):**
```json
{
  "ok": true,
  "count": 10,
  "cached_at": "2026-05-18T10:00:00+00:00",
  "articles": [
    {
      "title": "...",
      "description": "...",
      "url": "...",
      "image": "...",
      "source": "ANSA Salute",
      "publishedAt": "..."
    }
  ]
}