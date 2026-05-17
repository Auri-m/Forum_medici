<?php
/**
 * ════════════════════════════════════════════════════════════
 *  news_api.php — Notizie mediche da feed RSS gratuiti
 *  Nessuna chiave API · Nessun limite · Nessun costo
 *  Cache lato server: 1 ora
 *  PHP 7.0+  ·  richiede estensione SimpleXML (attiva di default)
 * ════════════════════════════════════════════════════════════
 *  DEBUG: apri news_api.php?debug=1 nel browser
 * ════════════════════════════════════════════════════════════
 */

$RSS_FEEDS = array(
    array('url' => 'https://www.ansa.it/saluteebenessere/rss.xml',            'source' => 'ANSA Salute'),
    array('url' => 'https://www.corriere.it/rss/salute.xml',                  'source' => 'Corriere Salute'),
    array('url' => 'https://www.quotidianosanita.it/rss',                     'source' => 'Quotidiano Sanità'),
    array('url' => 'https://www.salute.gov.it/portale/news/rss.jsp',          'source' => 'Min. della Salute'),
    array('url' => 'https://www.fnomceo.it/feed/',                            'source' => 'FNOMCeO'),
    array('url' => 'https://www.pharmastar.it/rss.php',                       'source' => 'Pharmastar'),
    array('url' => 'https://www.ilfattoquotidiano.it/category/salute/feed/',  'source' => 'Il Fatto - Salute'),
    array('url' => 'https://www.nurse24.it/feed',                             'source' => 'Nurse24'),
);

$FALLBACK_IMAGES = array(
    'https://images.unsplash.com/photo-1584982751601-97dcc096659c?w=600&q=75',
    'https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=600&q=75',
    'https://images.unsplash.com/photo-1551076805-e1869033e561?w=600&q=75',
    'https://images.unsplash.com/photo-1504813184591-01572f98c85f?w=600&q=75',
    'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=600&q=75',
    'https://images.unsplash.com/photo-1585435557343-3b092031a831?w=600&q=75',
);

$CACHE_FILE     = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'medicoforum_rss_v1.json';
$CACHE_DURATION = 1800; // 30 minuti — articoli più freschi

$DEBUG = isset($_GET['debug']) && $_GET['debug'] === '1';
$FLUSH = isset($_GET['flush']) && $_GET['flush'] === '1';

// ── ?flush=1 — Svuota la cache e forza ricarica dei feed ──
if ($FLUSH) {
    $deleted = array();
    $files = array($CACHE_FILE, sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'medicoforum_rss_slides_v1.json');
    foreach ($files as $f) {
        if (file_exists($f)) { @unlink($f); $deleted[] = basename($f); }
    }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array('ok' => true, 'flushed' => $deleted, 'msg' => 'Cache svuotata. Ricarica la pagina.'));
    exit;
}

if (!$DEBUG) {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Cache-Control: public, max-age=1800');
}

if (!$DEBUG && file_exists($CACHE_FILE) && (time() - filemtime($CACHE_FILE)) < $CACHE_DURATION) {
    echo file_get_contents($CACHE_FILE);
    exit;
}

$log = array();
$log[] = 'PHP ' . PHP_VERSION;
$log[] = 'Cache: ' . $CACHE_FILE;
$log[] = 'SimpleXML: '      . (extension_loaded('simplexml') ? 'disponibile' : 'NON disponibile');
$log[] = 'cURL: '           . (function_exists('curl_init')  ? 'disponibile' : 'non disponibile');
$log[] = 'allow_url_fopen: '. (ini_get('allow_url_fopen')    ? 'ON' : 'OFF');

function httpGet($url, &$log)
{
    $ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120';

    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 4,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT      => $ua,
            CURLOPT_HTTPHEADER     => array('Accept: application/rss+xml, application/xml, text/xml, */*'),
            CURLOPT_ENCODING       => 'gzip, deflate',
        ));
        $body   = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err    = curl_error($ch);
        curl_close($ch);
        if ($body !== false && $status >= 200 && $status < 300) {
            $log[] = '  cURL OK (HTTP ' . $status . ', ' . strlen($body) . ' byte)';
            return $body;
        }
        $log[] = '  cURL: HTTP ' . $status . ($err ? ' — ' . $err : '');
    }

    if (ini_get('allow_url_fopen')) {
        $ctx = stream_context_create(array(
            'http' => array(
                'timeout'       => 10,
                'ignore_errors' => true,
                'user_agent'    => $ua,
                'header'        => "Accept: application/rss+xml, application/xml, text/xml, */*\r\n",
            ),
            'ssl'  => array('verify_peer' => false, 'verify_peer_name' => false),
        ));
        $body = @file_get_contents($url, false, $ctx);
        if ($body !== false) {
            $log[] = '  file_get_contents OK (' . strlen($body) . ' byte)';
            return $body;
        }
        $log[] = '  file_get_contents: fallito';
    }
    return null;
}

function extractImage($text)
{
    if (preg_match('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $text, $m)) {
        $src = $m[1];
        if (strpos($src, 'http') === 0 && strpos($src, '1x1') === false && strpos($src, 'pixel') === false) {
            return $src;
        }
    }
    return '';
}

function parseRSS($xml, $defaultSource, $fallbackImages, &$imgIndex, &$log)
{
    libxml_use_internal_errors(true);
    $feed = @simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
    if ($feed === false) {
        $errors = libxml_get_errors();
        libxml_clear_errors();
        $log[] = '  XML non valido: ' . (isset($errors[0]) ? trim($errors[0]->message) : 'errore');
        return array();
    }

    $feed->registerXPathNamespace('media',   'http://search.yahoo.com/mrss/');
    $feed->registerXPathNamespace('content', 'http://purl.org/rss/1.0/modules/content/');
    $feed->registerXPathNamespace('dc',      'http://purl.org/dc/elements/1.1/');

    $items = array();
    if (isset($feed->channel->item)) {
        foreach ($feed->channel->item as $item) { $items[] = $item; }
    } elseif (isset($feed->entry)) {
        foreach ($feed->entry as $entry) { $items[] = $entry; }
    }

    $out = array();
    foreach ($items as $item) {
        $title = trim(strip_tags((string)($item->title ?? '')));
        if ($title === '') continue;

        $url = '';
        if (isset($item->link)) $url = trim((string)$item->link);
        if ($url === '' && isset($item->id)) $url = trim((string)$item->id);
        if ($url === '' || strpos($url, 'http') !== 0) continue;

        $desc = '';
        if (isset($item->description)) $desc = trim(strip_tags((string)$item->description));
        if ($desc === '' && isset($item->summary)) $desc = trim(strip_tags((string)$item->summary));
        $desc = mb_substr($desc, 0, 200);

        $image = '';

        // 1. media:content
        $mc = $item->xpath('media:content[@url]');
        if (!empty($mc)) {
            $img = (string)$mc[0]->attributes()->url;
            if (strpos($img, 'http') === 0) $image = $img;
        }
        // 2. media:thumbnail
        if ($image === '') {
            $mt = $item->xpath('media:thumbnail[@url]');
            if (!empty($mt)) {
                $img = (string)$mt[0]->attributes()->url;
                if (strpos($img, 'http') === 0) $image = $img;
            }
        }
        // 3. enclosure
        if ($image === '' && isset($item->enclosure)) {
            $enc  = $item->enclosure->attributes();
            $type = (string)($enc['type'] ?? '');
            if (strpos($type, 'image') !== false) $image = (string)($enc['url'] ?? '');
        }
        // 4. <img> dentro description
        if ($image === '') $image = extractImage((string)($item->description ?? ''));
        // 5. content:encoded
        if ($image === '') {
            $ce = $item->xpath('content:encoded');
            if (!empty($ce)) $image = extractImage((string)$ce[0]);
        }
        // 6. fallback Unsplash
        if ($image === '') {
            $image = $fallbackImages[$imgIndex % count($fallbackImages)];
            $imgIndex++;
        }

        $date = '';
        if (isset($item->pubDate)) {
            $ts = @strtotime((string)$item->pubDate);
            if ($ts) $date = date('c', $ts);
        }
        if ($date === '' && isset($item->updated)) {
            $ts = @strtotime((string)$item->updated);
            if ($ts) $date = date('c', $ts);
        }

        $out[] = array(
            'title'       => $title,
            'description' => $desc,
            'url'         => $url,
            'image'       => $image,
            'source'      => $defaultSource,
            'publishedAt' => $date ?: date('c'),
        );
    }
    return $out;
}

// ── Scarica tutti i feed ──
$allArticles = array();
$imgIndex    = 0;

foreach ($RSS_FEEDS as $feed) {
    $log[] = '[' . $feed['source'] . '] ' . $feed['url'];
    $body  = httpGet($feed['url'], $log);
    if ($body === null) {
        $log[] = '  nessuna risposta HTTP.';
        continue;
    }
    $items = parseRSS($body, $feed['source'], $FALLBACK_IMAGES, $imgIndex, $log);
    if (empty($items)) {
        $log[] = '  nessun articolo parsato.';
    } else {
        $log[] = '  ' . count($items) . ' articoli trovati.';
        $allArticles = array_merge($allArticles, $items);
    }
}

// ── Deduplica ──
$seen     = array();
$articles = array();
foreach ($allArticles as $a) {
    $key = md5($a['url']);
    if (!isset($seen[$key])) { $seen[$key] = true; $articles[] = $a; }
}

// ── Ordina per data ──
usort($articles, function($a, $b) { return strcmp($b['publishedAt'], $a['publishedAt']); });
$articles = array_slice($articles, 0, 10);

$log[] = 'Totale articoli finali: ' . count($articles);

// ── Fallback statico ──
if (empty($articles)) {
    $log[] = 'Tutti i feed non raggiungibili — uso fallback statico.';
    $articles = array(
        array(
            'title'       => 'Linee guida ESC 2025: novità per la pratica cardiologica',
            'description' => 'Le raccomandazioni aggiornate della Società Europea di Cardiologia.',
            'url'         => 'https://www.giornaledicardiologia.it/archivio/4570/articoli/45733/',
            'image'       => 'https://images.unsplash.com/photo-1584982751601-97dcc096659c?w=600&q=75',
            'source'      => 'Giornale di Cardiologia',
            'publishedAt' => date('c'),
        ),
        array(
            'title'       => 'AIFA: aggiornamento farmaci autorizzati in Italia',
            'description' => 'Lista completa dei medicinali con schede tecniche e note AIFA aggiornate.',
            'url'         => 'https://www.aifa.gov.it',
            'image'       => 'https://images.unsplash.com/photo-1585435557343-3b092031a831?w=600&q=75',
            'source'      => 'AIFA',
            'publishedAt' => date('c'),
        ),
    );
}

$result = array(
    'ok'        => true,
    'count'     => count($articles),
    'cached_at' => date('c'),
    'articles'  => $articles,
);

if ($DEBUG) {
?><!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>news_api.php — Debug RSS</title>
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:system-ui,sans-serif;padding:24px;background:#f0f4f8;color:#0d1f3c}
    h1{font-size:22px;margin-bottom:6px}
    .sub{color:#6b82a0;font-size:13px;margin-bottom:24px}
    h2{font-size:15px;font-weight:700;margin:28px 0 10px;color:#0f9f8e}
    .log{background:#fff;border:1px solid #dce4ef;border-radius:12px;padding:16px 20px;margin-bottom:8px}
    .log p{font-size:12px;font-family:monospace;padding:3px 0;line-height:1.7}
    .ok{color:#15803d}.warn{color:#b45309}
    .badge{display:inline-flex;align-items:center;padding:2px 10px;border-radius:100px;font-size:11px;font-weight:700}
    .badge-ok{background:#dcfce7;color:#15803d}
    .badge-warn{background:#fef9c3;color:#854d0e}
    .cards{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:14px;margin-bottom:28px}
    .card{background:#fff;border:1px solid #dce4ef;border-radius:14px;overflow:hidden}
    .card img{width:100%;height:110px;object-fit:cover;display:block}
    .card-body{padding:12px}
    .card-source{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#0f9f8e;margin-bottom:4px}
    .card-title{font-size:13px;font-weight:600;line-height:1.4;margin-bottom:4px}
    .card-date{font-size:11px;color:#6b82a0}
    pre{background:#1a1a2e;color:#e2e8f0;padding:20px;border-radius:14px;font-size:11px;overflow:auto;line-height:1.6;white-space:pre-wrap}
  </style>
</head>
<body>
  <h1>news_api.php — Debug RSS</h1>
  <p class="sub">Feed RSS gratuiti · Nessuna chiave API · Cache 1 ora</p>

  <h2>Ambiente</h2>
  <div class="log">
    <?php foreach (array_slice($log, 0, 5) as $l): ?>
      <p><?= htmlspecialchars($l) ?></p>
    <?php endforeach; ?>
  </div>

  <h2>Feed analizzati</h2>
  <div class="log">
    <?php foreach (array_slice($log, 5) as $l):
      $cls = strpos($l,' articoli') !== false ? 'ok' : (strpos($l,'nessun') !== false || strpos($l,'non rag') !== false ? 'warn' : '');
    ?>
      <p class="<?= $cls ?>"><?= htmlspecialchars($l) ?></p>
    <?php endforeach; ?>
  </div>

  <h2>Risultato
    <span class="badge <?= count($articles) > 0 ? 'badge-ok' : 'badge-warn' ?>">
      <?= count($articles) ?> articoli
    </span>
  </h2>

  <div class="cards">
    <?php foreach ($articles as $a): ?>
    <div class="card">
      <img src="<?= htmlspecialchars($a['image']) ?>" onerror="this.style.display='none'" alt="">
      <div class="card-body">
        <div class="card-source"><?= htmlspecialchars($a['source']) ?></div>
        <div class="card-title"><?= htmlspecialchars($a['title']) ?></div>
        <div class="card-date"><?= htmlspecialchars(substr($a['publishedAt'],0,10)) ?></div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <h2>JSON inviato al browser</h2>
  <pre><?= htmlspecialchars(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ?></pre>
</body>
</html>
<?php
} else {
    $json = json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json !== false) @file_put_contents($CACHE_FILE, $json);
    echo $json;
}