-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 19, 2026 alle 19:10
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forum`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `credenziali`
--

CREATE TABLE `credenziali` (
  `id_credenziali` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `dottore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `credenziali`
--

INSERT INTO `credenziali` (`id_credenziali`, `username`, `password`, `dottore`) VALUES
(1, 'admin', 'admin', 1),
(2, 'utentex', 'utentex', 2),
(3, 'luca.verdi', 'Verdi2026', 3),
(4, 'elena.romano', 'Romano2026', 4),
(5, 'alessandro.colombo', 'Colombo2026', 5),
(6, 'martina.ricci', 'Ricci2026', 6),
(7, 'francesco.marino', 'Marino2026', 7),
(8, 'chiara.greco', 'Greco2026', 8),
(9, 'matteo.gallo', 'Gallo2026', 9),
(10, 'sara.conti', 'Conti2026', 10),
(11, 'andrea.esposito', 'Esposito2026', 11),
(12, 'valentina.de luca', 'De Luca2026', 12),
(13, 'davide.costa', 'Costa2026', 13),
(14, 'silvia.giordano', 'Giordano2026', 14),
(15, 'marco.rizzo', 'Rizzo2026', 15),
(16, 'francesca.lombardi', 'Lombardi2026', 16),
(17, 'lorenzo.moretti', 'Moretti2026', 17),
(18, 'anna.barbieri', 'Barbieri2026', 18),
(19, 'gabriele.fontana', 'Fontana2026', 19),
(20, 'elisa.russo', 'Russo2026', 20),
(21, 'simone.santoro', 'Santoro2026', 21),
(22, 'federica.caruso', 'Caruso2026', 22),
(23, 'nicola.mariani', 'Mariani2026', 23),
(24, 'alessia.ferrara', 'Ferrara2026', 24),
(25, 'daniele.galli', 'Galli2026', 25),
(26, 'roberta.martini', 'Martini2026', 26),
(27, 'emanuele.leone', 'Leone2026', 27),
(28, 'marta.longo', 'Longo2026', 28),
(29, 'giacomo.pellegrini', 'Pellegrini2026', 29),
(30, 'ilaria.serra', 'Serra2026', 30),
(31, 'roberto.conte', 'Conte2026', 31),
(32, 'laura.fiore', 'Fiore2026', 32),
(33, 'stefano.vitale', 'Vitale2026', 33),
(34, 'eleonora.de angelis', 'De Angelis2026', 34),
(35, 'paolo.farina', 'Farina2026', 35),
(36, 'beatrice.gatti', 'Gatti2026', 36),
(37, 'antonio.monti', 'Monti2026', 37),
(38, 'irene.piras', 'Piras2026', 38),
(39, 'enrico.ferri', 'Ferri2026', 39),
(40, 'giorgia.sorrentino', 'Sorrentino2026', 40),
(41, 'giovanni.basile', 'Basile2026', 41),
(42, 'alice.testa', 'Testa2026', 42),
(43, 'federico.riva', 'Riva2026', 43),
(44, 'camilla.silvestri', 'Silvestri2026', 44),
(45, 'filippo.mazza', 'Mazza2026', 45),
(46, 'michela.villa', 'Villa2026', 46),
(47, 'riccardo.parisi', 'Parisi2026', 47),
(48, 'sofia.donati', 'Donati2026', 48),
(49, 'valerio.d\'amico', 'D\'Amico2026', 49),
(50, 'veronica.ferrero', 'Ferrero2026', 50);

-- --------------------------------------------------------

--
-- Struttura della tabella `domande`
--

CREATE TABLE `domande` (
  `id_domanda` int(11) NOT NULL,
  `titolo` varchar(50) NOT NULL,
  `corpo` varchar(500) NOT NULL,
  `dottore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `domande`
--

INSERT INTO `domande` (`id_domanda`, `titolo`, `corpo`, `dottore`) VALUES
(1, 'Gestione ipertensione resistente', 'Paziente maschio, 65 anni, non risponde alla triplice terapia standard. Quali alternative farmacologiche consigliate o quali esami di secondo livello?', 1),
(2, 'Sospetta intolleranza al lattosio', 'Qual è il test diagnostico più affidabile attualmente per confermare l\'intolleranza in un paziente adulto di 25 anni?', 5),
(3, 'Cefalea a grappolo', 'Richiesta parere per gestione acuta e profilassi per una paziente di 40 anni con attacchi molto frequenti prevalentemente notturni.', 8),
(4, 'Dubbio su tracciato ECG', 'Onda T invertita nelle derivazioni V2 e V3 su paziente di 30 anni asintomatico e sportivo. Approfondimenti suggeriti o variante normale?', 3),
(5, 'Diabete tipo 2 e nuovi farmaci', 'Quali sono le vostre esperienze con i nuovi inibitori SGLT2 in pazienti con diabete di tipo 2 e lieve insufficienza renale cronica?', 7),
(6, 'Frattura scomposta clavicola', 'Trattamento conservativo con tutore vs intervento chirurgico in giovane atleta (22 anni). Quali sono i vostri pareri in base ai tempi di recupero?', 10),
(7, 'Gestione ansia pre-operatoria', 'Quali protocolli seguite nei vostri reparti per interventi di chirurgia minore in pazienti in età pediatrica molto agitati?', 11),
(8, 'Rash cutaneo atipico', 'Paziente con macchie eritematose insorte 2 giorni dopo l\'assunzione di amoxicillina. Conviene fare un test allergologico immediato?', 12),
(9, 'Gestione insonnia cronica', 'Utilizzo di melatonina ad alte dosi rispetto a benzodiazepine a bassissimo dosaggio: approcci a lungo termine per paziente anziano.', 4),
(10, 'Lesione legamento crociato anteriore', 'Quali sono secondo voi i tempi di recupero post-operatorio e i protocolli riabilitativi ottimali per un ritorno sicuro allo sport?', 15);

-- --------------------------------------------------------

--
-- Struttura della tabella `dottori`
--

CREATE TABLE `dottori` (
  `id_dottore` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `sesso` varchar(1) NOT NULL,
  `eta` int(3) NOT NULL,
  `anni_lavoro` int(3) NOT NULL,
  `foto_profilo` varchar(500) DEFAULT NULL,
  `specializzazione` int(11) NOT NULL,
  `ospedale` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `dottori`
--

INSERT INTO `dottori` (`id_dottore`, `nome`, `cognome`, `sesso`, `eta`, `anni_lavoro`, `foto_profilo`, `specializzazione`, `ospedale`) VALUES
(1, 'Mario', 'Rossi', 'm', 45, 15, 'default_m.jpg', 1, 1),
(2, 'Giulia', 'Bianchi', 'f', 38, 8, 'default_f.jpg', 2, 2),
(3, 'Luca', 'Verdi', 'm', 52, 22, 'default_m.jpg', 3, 3),
(4, 'Elena', 'Romano', 'f', 41, 12, 'default_f.jpg', 4, 4),
(5, 'Alessandro', 'Colombo', 'm', 60, 30, 'default_m.jpg', 5, 5),
(6, 'Martina', 'Ricci', 'f', 35, 5, 'default_f.jpg', 6, 6),
(7, 'Francesco', 'Marino', 'm', 48, 18, 'default_m.jpg', 7, 7),
(8, 'Chiara', 'Greco', 'f', 55, 25, 'default_f.jpg', 8, 8),
(9, 'Matteo', 'Gallo', 'm', 39, 9, 'default_m.jpg', 9, 9),
(10, 'Sara', 'Conti', 'f', 44, 14, 'default_f.jpg', 10, 10),
(11, 'Andrea', 'Esposito', 'm', 50, 20, 'default_m.jpg', 11, 11),
(12, 'Valentina', 'De Luca', 'f', 36, 6, 'default_f.jpg', 12, 12),
(13, 'Davide', 'Costa', 'm', 62, 32, 'default_m.jpg', 13, 13),
(14, 'Silvia', 'Giordano', 'f', 47, 17, 'default_f.jpg', 14, 14),
(15, 'Marco', 'Rizzo', 'm', 53, 23, 'default_m.jpg', 15, 15),
(16, 'Francesca', 'Lombardi', 'f', 40, 10, 'default_f.jpg', 16, 1),
(17, 'Lorenzo', 'Moretti', 'm', 58, 28, 'default_m.jpg', 17, 2),
(18, 'Anna', 'Barbieri', 'f', 33, 3, 'default_f.jpg', 18, 3),
(19, 'Gabriele', 'Fontana', 'm', 46, 16, 'default_m.jpg', 19, 4),
(20, 'Elisa', 'Russo', 'f', 51, 21, 'default_f.jpg', 20, 5),
(21, 'Simone', 'Santoro', 'm', 37, 7, 'default_m.jpg', 1, 6),
(22, 'Federica', 'Caruso', 'f', 49, 19, 'default_f.jpg', 2, 7),
(23, 'Nicola', 'Mariani', 'm', 65, 35, 'default_m.jpg', 3, 8),
(24, 'Alessia', 'Ferrara', 'f', 42, 12, 'default_f.jpg', 4, 9),
(25, 'Daniele', 'Galli', 'm', 54, 24, 'default_m.jpg', 5, 10),
(26, 'Roberta', 'Martini', '', 34, 4, 'default_f.jpg', 6, 11),
(27, 'Emanuele', 'Leone', '', 59, 29, 'default_m.jpg', 7, 12),
(28, 'Marta', 'Longo', '', 43, 13, 'default_f.jpg', 8, 13),
(29, 'Giacomo', 'Pellegrini', 'm', 56, 26, 'default_m.jpg', 9, 14),
(30, 'Ilaria', 'Serra', 'f', 32, 2, 'default_f.jpg', 10, 15),
(31, 'Roberto', 'Conte', 'm', 61, 31, 'default_m.jpg', 11, 1),
(32, 'Laura', 'Fiore', 'f', 39, 9, 'default_f.jpg', 12, 2),
(33, 'Stefano', 'Vitale', 'm', 48, 18, 'default_m.jpg', 13, 3),
(34, 'Eleonora', 'De Angelis', 'f', 52, 22, 'default_f.jpg', 14, 4),
(35, 'Paolo', 'Farina', 'm', 45, 15, 'default_m.jpg', 15, 5),
(36, 'Beatrice', 'Gatti', 'f', 36, 6, 'default_f.jpg', 16, 6),
(37, 'Antonio', 'Monti', 'm', 57, 27, 'default_m.jpg', 17, 7),
(38, 'Irene', 'Piras', 'f', 41, 11, 'default_f.jpg', 18, 8),
(39, 'Enrico', 'Ferri', 'm', 63, 33, 'default_m.jpg', 19, 9),
(40, 'Giorgia', 'Sorrentino', 'f', 35, 5, 'default_f.jpg', 20, 10),
(41, 'Giovanni', 'Basile', '', 50, 20, 'default_m.jpg', 1, 11),
(42, 'Alice', 'Testa', '', 44, 14, 'default_f.jpg', 2, 12),
(43, 'Federico', 'Riva', '', 55, 25, 'default_m.jpg', 3, 13),
(44, 'Camilla', 'Silvestri', '', 38, 8, 'default_f.jpg', 4, 14),
(45, 'Filippo', 'Mazza', '', 64, 34, 'default_m.jpg', 5, 15),
(46, 'Michela', 'Villa', '', 47, 17, 'default_f.jpg', 6, 1),
(47, 'Riccardo', 'Parisi', '', 40, 10, 'default_m.jpg', 7, 2),
(48, 'Sofia', 'Donati', '', 53, 23, 'default_f.jpg', 8, 3),
(49, 'Valerio', 'D\'Amico', '', 46, 16, 'default_m.jpg', 9, 4),
(50, 'Veronica', 'Ferrero', 'f', 37, 7, 'default_f.jpg', 10, 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `ospedali`
--

CREATE TABLE `ospedali` (
  `id_ospedale` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `provincia` varchar(50) NOT NULL,
  `citta` varchar(50) NOT NULL,
  `via` varchar(50) NOT NULL,
  `civico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ospedali`
--

INSERT INTO `ospedali` (`id_ospedale`, `nome`, `provincia`, `citta`, `via`, `civico`) VALUES
(1, 'Azienda Ospedale Università Padova', 'PD', 'Padova', 'Via Giustiniani', 2),
(2, 'Ospedale dell\'Angelo', 'VE', 'Venezia', 'Via Paccagnella', 11),
(3, 'Ospedale Borgo Trento', 'VR', 'Verona', 'Piazzale Aristide Stefani', 1),
(4, 'Ospedale Ca\' Foncello', 'TV', 'Treviso', 'Piazzale dell\'Ospedale', 1),
(5, 'Ospedale San Bortolo', 'VI', 'Vicenza', 'Viale Rodolfi', 37),
(6, 'Ospedale San Martino', 'BL', 'Belluno', 'Viale Europa', 22),
(7, 'Ospedale Santa Maria della Misericordia', 'RO', 'Rovigo', 'Viale Tre Martiri', 140),
(8, 'Ospedale Civile SS. Giovanni e Paolo', 'VE', 'Venezia', 'Sestiere Castello', 6777),
(9, 'Ospedale Civile di San Donà', 'VE', 'San Donà di Piave', 'Via Nazario Sauro', 25),
(10, 'Ospedale San Giacomo', 'TV', 'Castelfranco Veneto', 'Via dei Carpani', 16),
(11, 'Ospedale Alto Vicentino', 'VI', 'Santorso', 'Via Garziere', 42),
(12, 'Ospedale Borgo Roma', 'VR', 'Verona', 'Piazzale Ludovico Antonio Scuro', 10),
(13, 'Ospedale Immacolata Concezione', 'PD', 'Piove di Sacco', 'Via San Rocco', 8),
(14, 'Ospedale di Dolo', 'VE', 'Dolo', 'Via Riviera XXIX Aprile', 2),
(15, 'Ospedale di Jesolo', 'VE', 'Jesolo', 'Via Levantina', 104);

-- --------------------------------------------------------

--
-- Struttura della tabella `risposte`
--

CREATE TABLE `risposte` (
  `id_risposta` int(11) NOT NULL,
  `corpo` varchar(500) NOT NULL,
  `dottore` int(11) NOT NULL,
  `domanda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `risposte`
--

INSERT INTO `risposte` (`id_risposta`, `corpo`, `dottore`, `domanda`) VALUES
(1, 'Suggerisco di valutare l\'aggiunta di spironolattone come quarta linea di terapia, monitorando attentamente la potassiemia.', 2, 1),
(2, 'Assolutamente il Breath Test al lattosio (test del respiro). Rimane il gold standard non invasivo.', 6, 2),
(3, 'Per gli attacchi acuti della cefalea a grappolo, l\'ossigeno puro al 100% ad alti flussi (12-15 L/min) con mascherina è il trattamento più efficace.', 13, 3),
(4, 'Concordo per l\'ossigeno nell\'acuto. Come terapia di profilassi, il verapamil ad alte dosi è spesso la prima scelta, previa esecuzione di un ECG.', 18, 3),
(5, 'In un giovane sportivo potrebbe trattarsi di una variante fisiologica (repolarizzazione precoce), ma farei comunque un ecocardiogramma per escludere cardiomiopatie.', 21, 4),
(6, 'Gli SGLT2 hanno mostrato ottimi dati non solo per il compenso glicemico ma proprio per la protezione renale. Ottima scelta, ma attenzione a monitorare il filtrato glomerulare.', 19, 5),
(7, 'Nel giovane atleta la chirurgia con placca e viti garantisce spesso un recupero più prevedibile e veloce per il ritorno all\'attività agonistica.', 25, 6),
(8, 'Nel nostro reparto usiamo spesso protocolli con midazolam per via orale circa 30 minuti prima dell\'ingresso in sala operatoria. Molto efficace.', 16, 7),
(9, 'Il test allergologico immediato è sconsigliato in fase acuta. Sospendi l\'antibiotico, tratta con antistaminici e cortisonici, e rimanda i test a distanza di 4-6 settimane.', 22, 8),
(10, 'Eviterei assolutamente le benzodiazepine nel lungo termine nell\'anziano per il rischio di cadute e tolleranza. Preferisco puntare molto sull\'educazione all\'igiene del sonno.', 28, 9),
(11, 'Il protocollo riabilitativo deve iniziare prestissimo, già nei primi giorni post-operatori per recuperare l\'estensione completa. Ritorno allo sport non prima di 6 mesi.', 30, 10),
(12, 'Anche una valutazione endocrinologica per escludere un iperaldosteronismo primario potrebbe avere senso in un caso di ipertensione così resistente.', 35, 1),
(13, 'Aggiungo che nel caso di intolleranza al lattosio, è utile consigliare da subito una dieta ad esclusione prima di eseguire il test, per valutare la remissione sintomatologica.', 42, 2),
(14, 'Oltre alla placca, in casi selezionati di frattura di clavicola utilizziamo i chiodi endomidollari elastici (TEN), meno invasivi e con ottimi risultati estetici.', 45, 6),
(15, 'Per il rash da amoxicillina, ricorda di documentare bene le lesioni con delle foto, torneranno utilissime all\'allergologo al momento della visita ambulatoriale.', 50, 8);

-- --------------------------------------------------------

--
-- Struttura della tabella `specializzazioni`
--

CREATE TABLE `specializzazioni` (
  `codice` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descrizione` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `specializzazioni`
--

INSERT INTO `specializzazioni` (`codice`, `nome`, `descrizione`) VALUES
(1, 'Cardiologia', 'Diagnosi e cura delle malattie cardiovascolari.'),
(2, 'Chirurgia Generale', 'Interventi chirurgici su organi addominali, tiroide, mammella.'),
(3, 'Dermatologia', 'Cura delle patologie della pelle e degli annessi cutanei.'),
(4, 'Endocrinologia', 'Diagnosi e trattamento delle malattie del sistema endocrino.'),
(5, 'Gastroenterologia', 'Studio e cura delle malattie dell\'apparato digerente.'),
(6, 'Ginecologia e Ostetricia', 'Salute del sistema riproduttivo femminile e gravidanza.'),
(7, 'Medicina Interna', 'Trattamento medico di patologie complesse e multiorgano.'),
(8, 'Neurologia', 'Diagnosi e cura delle malattie del sistema nervoso centrale e periferico.'),
(9, 'Oncologia', 'Diagnosi e trattamento dei tumori.'),
(10, 'Ortopedia e Traumatologia', 'Cura delle affezioni del sistema muscolo-scheletrico.'),
(11, 'Pediatria', 'Cura e salute di neonati, bambini e adolescenti.'),
(12, 'Psichiatria', 'Diagnosi e trattamento dei disturbi mentali.'),
(13, 'Radiologia', 'Diagnostica per immagini.'),
(14, 'Urologia', 'Patologie dell\'apparato urinario e genitale maschile.'),
(15, 'Oculistica', 'Malattie dell\'occhio e della vista.'),
(16, 'Otorinolaringoiatria', 'Patologie di orecchio, naso e gola.'),
(17, 'Anestesia e Rianimazione', 'Terapia intensiva e gestione del dolore pre e post operatorio.'),
(18, 'Medicina d\'Emergenza-Urgenza', 'Gestione del pronto soccorso e situazioni critiche.'),
(19, 'Nefrologia', 'Malattie dei reni e vie urinarie.'),
(20, 'Pneumologia', 'Diagnosi e cura delle malattie dell\'apparato respiratorio.');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `credenziali`
--
ALTER TABLE `credenziali`
  ADD PRIMARY KEY (`id_credenziali`),
  ADD KEY `dottore` (`dottore`);

--
-- Indici per le tabelle `domande`
--
ALTER TABLE `domande`
  ADD PRIMARY KEY (`id_domanda`),
  ADD KEY `dottore` (`dottore`);

--
-- Indici per le tabelle `dottori`
--
ALTER TABLE `dottori`
  ADD PRIMARY KEY (`id_dottore`),
  ADD KEY `ospedale` (`ospedale`),
  ADD KEY `specializzazione` (`specializzazione`);

--
-- Indici per le tabelle `ospedali`
--
ALTER TABLE `ospedali`
  ADD PRIMARY KEY (`id_ospedale`);

--
-- Indici per le tabelle `risposte`
--
ALTER TABLE `risposte`
  ADD PRIMARY KEY (`id_risposta`),
  ADD KEY `domanda` (`domanda`),
  ADD KEY `dottore` (`dottore`);

--
-- Indici per le tabelle `specializzazioni`
--
ALTER TABLE `specializzazioni`
  ADD PRIMARY KEY (`codice`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `credenziali`
--
ALTER TABLE `credenziali`
  MODIFY `id_credenziali` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT per la tabella `domande`
--
ALTER TABLE `domande`
  MODIFY `id_domanda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `dottori`
--
ALTER TABLE `dottori`
  MODIFY `id_dottore` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT per la tabella `ospedali`
--
ALTER TABLE `ospedali`
  MODIFY `id_ospedale` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT per la tabella `risposte`
--
ALTER TABLE `risposte`
  MODIFY `id_risposta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT per la tabella `specializzazioni`
--
ALTER TABLE `specializzazioni`
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `credenziali`
--
ALTER TABLE `credenziali`
  ADD CONSTRAINT `credenziali_ibfk_1` FOREIGN KEY (`dottore`) REFERENCES `dottori` (`id_dottore`);

--
-- Limiti per la tabella `domande`
--
ALTER TABLE `domande`
  ADD CONSTRAINT `domande_ibfk_1` FOREIGN KEY (`dottore`) REFERENCES `dottori` (`id_dottore`);

--
-- Limiti per la tabella `dottori`
--
ALTER TABLE `dottori`
  ADD CONSTRAINT `dottori_ibfk_1` FOREIGN KEY (`ospedale`) REFERENCES `ospedali` (`id_ospedale`),
  ADD CONSTRAINT `dottori_ibfk_2` FOREIGN KEY (`specializzazione`) REFERENCES `specializzazioni` (`codice`);

--
-- Limiti per la tabella `risposte`
--
ALTER TABLE `risposte`
  ADD CONSTRAINT `risposte_ibfk_1` FOREIGN KEY (`domanda`) REFERENCES `domande` (`id_domanda`),
  ADD CONSTRAINT `risposte_ibfk_2` FOREIGN KEY (`dottore`) REFERENCES `dottori` (`id_dottore`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
