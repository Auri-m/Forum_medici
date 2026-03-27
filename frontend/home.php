<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home | MedicoForum</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}

:root{
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
  --r:       14px;
}

html{scroll-behavior:smooth}
body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--navy);overflow-x:hidden}

/* ── Grain ── */
body::before{content:'';position:fixed;inset:0;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.025'/%3E%3C/svg%3E");pointer-events:none;z-index:9999;opacity:.3}

/* ══════════ TOP BAR ══════════ */
.topbar{background:var(--navy);padding:6px 5%;display:flex;align-items:center;justify-content:space-between;font-size:11.5px;color:rgba(255,255,255,.45);letter-spacing:.04em}
.topbar-left{display:flex;gap:20px;align-items:center}
.topbar-right{display:flex;gap:16px;align-items:center}
.topbar a{color:rgba(255,255,255,.5);text-decoration:none;transition:color .2s}
.topbar a:hover{color:var(--teal)}
.live-badge{display:flex;align-items:center;gap:6px;color:rgba(255,255,255,.6)}
.live-dot{width:6px;height:6px;background:#4ade80;border-radius:50%;animation:blink 1.4s ease-in-out infinite}
@keyframes blink{0%,100%{opacity:1}50%{opacity:.25}}

/* ══════════ NAVBAR ══════════ */
header{position:sticky;top:0;z-index:200;background:rgba(255,255,255,.97);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border-bottom:1px solid var(--border);height:64px;display:flex;align-items:center;padding:0 5%;gap:20px;animation:navDown .5s cubic-bezier(.22,1,.36,1) both;box-shadow:0 1px 0 var(--border),0 4px 20px rgba(13,31,60,.04)}
@keyframes navDown{from{opacity:0;transform:translateY(-16px)}to{opacity:1;transform:translateY(0)}}

.nav-logo{font-family:'DM Serif Display',serif;font-size:20px;color:var(--navy);text-decoration:none;display:flex;align-items:center;gap:10px;flex-shrink:0;letter-spacing:-.3px}
.nav-logo .cross{width:34px;height:34px;background:linear-gradient(135deg,var(--teal),var(--teal2));border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;font-weight:900;flex-shrink:0;box-shadow:0 4px 12px rgba(15,159,142,.3)}

/* Nav links */
.nav-links{display:flex;align-items:center;gap:2px;flex:1;justify-content:center}
.nav-links a{font-size:13.5px;font-weight:500;color:var(--muted);text-decoration:none;padding:7px 13px;border-radius:9px;transition:color .2s,background .2s;white-space:nowrap}
.nav-links a:hover,.nav-links a.active{color:var(--navy);background:var(--teal-lt)}
.nav-links a.active{color:var(--teal);font-weight:600}

/* Search */
.nav-search{position:relative;flex:0 0 200px}
.nav-search input{width:100%;padding:8px 14px 8px 36px;border:1.5px solid var(--border);border-radius:10px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--navy);background:var(--bg);outline:none;transition:all .2s}
.nav-search input:focus{border-color:var(--teal);background:#fff;box-shadow:0 0 0 3px rgba(15,159,142,.08)}
.nav-search input::placeholder{color:#aabcce}
.nav-search .search-icon{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:var(--muted);pointer-events:none}
.nav-search .search-icon svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round}

/* Right side */
.nav-right{display:flex;align-items:center;gap:8px;flex-shrink:0}

.icon-btn{width:38px;height:38px;border-radius:10px;border:1.5px solid var(--border);background:var(--white);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;position:relative;text-decoration:none;color:var(--navy)}
.icon-btn:hover{background:var(--teal-lt);border-color:var(--teal)}
.icon-btn svg{width:17px;height:17px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
.badge-dot{position:absolute;top:6px;right:6px;width:7px;height:7px;background:#f87171;border-radius:50%;border:1.5px solid #fff}

.profile-pill{display:flex;align-items:center;gap:8px;padding:5px 14px 5px 5px;border-radius:100px;border:1.5px solid var(--border);background:var(--white);text-decoration:none;font-size:13px;font-weight:600;color:var(--navy);transition:all .2s;cursor:pointer}
.profile-pill:hover{background:var(--teal-lt);border-color:var(--teal)}
.avatar{width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,var(--teal),var(--teal2));color:#fff;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;letter-spacing:.02em;flex-shrink:0}

/* ══════════ HERO SLIDESHOW ══════════ */
.hero-slider{position:relative;height:280px;overflow:hidden;border-bottom:1px solid var(--border)}
.slide{position:absolute;inset:0;opacity:0;transition:opacity 1.2s ease-in-out}
.slide.active{opacity:1}
.slide img{width:100%;height:100%;object-fit:cover;display:block}
.slide-overlay{position:absolute;inset:0;background:linear-gradient(to right,rgba(13,31,60,.82) 0%,rgba(13,31,60,.45) 50%,transparent 100%)}
.slide-content{position:absolute;inset:0;display:flex;align-items:center;padding:0 5%;z-index:2}
.slide-inner{max-width:560px}
.slide-tag{display:inline-flex;align-items:center;gap:7px;background:rgba(15,159,142,.2);border:1px solid rgba(15,159,142,.4);border-radius:100px;padding:5px 14px;font-size:11px;font-weight:700;color:#5dd8cc;letter-spacing:.1em;text-transform:uppercase;margin-bottom:14px}
.slide-tag::before{content:'';width:5px;height:5px;background:#5dd8cc;border-radius:50%;animation:blink 1.4s ease-in-out infinite}
.slide-title{font-family:'DM Serif Display',serif;font-size:clamp(22px,2.8vw,34px);color:#fff;line-height:1.2;margin-bottom:10px}
.slide-title em{font-style:italic;color:#5dd8cc}
.slide-desc{font-size:14px;color:rgba(255,255,255,.65);line-height:1.6;font-weight:300;margin-bottom:18px;max-width:420px}
.slide-btn{display:inline-flex;align-items:center;gap:8px;background:var(--teal);color:#fff;padding:10px 20px;border-radius:10px;font-size:13px;font-weight:700;text-decoration:none;transition:all .2s;box-shadow:0 4px 16px rgba(15,159,142,.3)}
.slide-btn:hover{background:var(--teal2);transform:translateY(-1px)}

/* Slide controls */
.slide-controls{position:absolute;bottom:20px;right:5%;z-index:3;display:flex;align-items:center;gap:10px}
.slide-dot{width:6px;height:6px;border-radius:100px;background:rgba(255,255,255,.3);cursor:pointer;transition:all .3s}
.slide-dot.active{background:var(--teal);width:22px}
.slide-arrows{display:flex;gap:6px;margin-left:12px}
.slide-arrow{width:30px;height:30px;border-radius:8px;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);color:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;backdrop-filter:blur(6px)}
.slide-arrow:hover{background:rgba(255,255,255,.25)}
.slide-arrow svg{width:13px;height:13px;stroke:#fff;fill:none;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round}

/* ══════════ QUICK STATS BAR ══════════ */
.quick-stats{background:var(--navy);padding:14px 5%;display:flex;justify-content:space-around;gap:20px;flex-wrap:wrap}
.qstat{display:flex;align-items:center;gap:10px}
.qstat-icon{width:32px;height:32px;background:rgba(15,159,142,.18);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:15px}
.qstat-num{font-family:'DM Serif Display',serif;font-size:18px;color:#fff;line-height:1}
.qstat-label{font-size:11px;color:rgba(255,255,255,.4);letter-spacing:.04em}

/* ══════════ LAYOUT 3 COLONNE ══════════ */
.page-wrapper{max-width:1320px;margin:0 auto;padding:28px 24px 100px;display:grid;grid-template-columns:248px 1fr 272px;gap:22px;align-items:start}

/* ══════════ SIDEBAR BASE ══════════ */
.sidebar{position:sticky;top:80px;display:flex;flex-direction:column;gap:16px;max-height:calc(100vh - 100px);overflow-y:auto;scrollbar-width:none}
.sidebar::-webkit-scrollbar{display:none}

/* ══════════ WIDGET ══════════ */
.widget{background:var(--white);border:1px solid var(--border);border-radius:18px;overflow:hidden;box-shadow:0 2px 12px rgba(13,31,60,.05)}
.widget-header{padding:14px 18px 12px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:8px}
.widget-title{font-family:'DM Serif Display',serif;font-size:14px;color:var(--navy);display:flex;align-items:center;gap:7px}
.widget-title-icon{font-size:13px}
.widget-link{font-size:11px;font-weight:600;color:var(--teal);text-decoration:none;transition:color .2s;white-space:nowrap}
.widget-link:hover{color:var(--teal2)}
.widget-body{padding:14px 18px}

/* ══════════ LEFT: PROFILO ══════════ */
.profile-widget{border:none;overflow:visible;background:transparent}
.profile-card{background:linear-gradient(160deg,var(--navy) 0%,#132d54 100%);border-radius:18px;overflow:hidden;border:1px solid rgba(255,255,255,.06)}
.profile-cover{height:72px;background:linear-gradient(135deg,var(--teal),var(--teal2));position:relative;overflow:hidden}
.profile-cover::after{content:'';position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=500&q=50') center/cover no-repeat;opacity:.25}
.profile-info{padding:0 18px 18px;margin-top:-24px;position:relative}
.big-avatar{width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,var(--teal),#4fc3c3);border:3px solid var(--navy);display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:800;color:#fff;margin-bottom:10px;box-shadow:0 4px 14px rgba(15,159,142,.35)}
.pname{font-family:'DM Serif Display',serif;font-size:15px;color:#fff;margin-bottom:2px}
.pspec{font-size:11px;color:rgba(255,255,255,.45);margin-bottom:14px}
.profile-stats{display:grid;grid-template-columns:1fr 1fr;gap:8px}
.pstat{background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.08);border-radius:10px;padding:10px;text-align:center}
.pstat-num{font-family:'DM Serif Display',serif;font-size:18px;color:var(--teal);line-height:1}
.pstat-label{font-size:9px;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.06em;margin-top:3px}

/* Completion bar */
.profile-complete{padding:12px 18px;border-top:1px solid rgba(255,255,255,.07)}
.complete-label{font-size:11px;color:rgba(255,255,255,.4);display:flex;justify-content:space-between;margin-bottom:6px}
.complete-label span{color:var(--teal);font-weight:600}
.complete-bar{height:4px;background:rgba(255,255,255,.1);border-radius:100px;overflow:hidden}
.complete-fill{height:100%;background:linear-gradient(to right,var(--teal),#4fc3c3);border-radius:100px;width:72%}

/* ══════════ LEFT: SPECIALIZZAZIONI ══════════ */
.spec-list{list-style:none;display:flex;flex-direction:column;gap:2px}
.spec-list li a{display:flex;align-items:center;justify-content:space-between;padding:8px 10px;border-radius:10px;text-decoration:none;font-size:13px;font-weight:500;color:var(--navy);transition:all .2s}
.spec-list li a:hover{background:var(--teal-lt);color:var(--teal2)}
.spec-list li a .spec-left{display:flex;align-items:center;gap:8px}
.spec-emoji{font-size:14px}
.count-pill{font-size:10px;background:var(--teal-lt);color:var(--teal2);padding:2px 8px;border-radius:100px;font-weight:700;border:1px solid rgba(15,159,142,.15)}

/* ══════════ LEFT: QUICK LINKS ══════════ */
.quick-links{display:flex;flex-direction:column;gap:2px}
.quick-link{display:flex;align-items:center;gap:10px;padding:9px 10px;border-radius:10px;text-decoration:none;font-size:13px;font-weight:500;color:var(--navy);transition:all .2s}
.quick-link:hover{background:var(--teal-lt);color:var(--teal2)}
.quick-link-icon{width:28px;height:28px;border-radius:8px;background:var(--bg);display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;transition:background .2s}
.quick-link:hover .quick-link-icon{background:var(--teal-lt)}

/* ══════════ MAIN FEED ══════════ */
main{min-width:0;animation:fadeUp .5s ease .1s both}
@keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}

/* Feed header */
.feed-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;gap:12px;flex-wrap:wrap}
.feed-title-group{}
.feed-label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--teal);margin-bottom:4px}
.feed-title{font-family:'DM Serif Display',serif;font-size:24px;letter-spacing:-.3px;color:var(--navy)}

/* Tabs */
.feed-tabs{display:flex;gap:4px;background:var(--white);border:1px solid var(--border);border-radius:12px;padding:4px}
.feed-tab{padding:7px 16px;border-radius:9px;font-size:13px;font-weight:600;color:var(--muted);cursor:pointer;transition:all .2s;border:none;background:none;font-family:'DM Sans',sans-serif}
.feed-tab.active{background:var(--navy);color:#fff;box-shadow:0 2px 8px rgba(13,31,60,.2)}
.feed-tab:hover:not(.active){color:var(--navy);background:var(--bg)}

/* New post box */
.new-post-box{background:var(--white);border:1.5px solid var(--border);border-radius:18px;padding:16px 20px;margin-bottom:18px;display:flex;align-items:center;gap:12px;cursor:pointer;transition:all .2s;box-shadow:0 2px 8px rgba(13,31,60,.04)}
.new-post-box:hover{border-color:var(--teal);box-shadow:0 4px 20px rgba(15,159,142,.1)}
.new-post-avatar{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--teal),var(--teal2));display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;flex-shrink:0}
.new-post-placeholder{flex:1;background:var(--bg);border:1.5px solid var(--border);border-radius:10px;padding:10px 16px;font-size:13px;color:#aabcce;font-family:'DM Sans',sans-serif;cursor:pointer;transition:all .2s}
.new-post-box:hover .new-post-placeholder{border-color:rgba(15,159,142,.3);background:#f7fbfa}
.new-post-actions{display:flex;gap:6px}
.np-btn{width:34px;height:34px;border-radius:9px;border:1.5px solid var(--border);background:var(--white);display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:15px;transition:all .2s}
.np-btn:hover{background:var(--teal-lt);border-color:var(--teal)}

/* ══════════ QUESTION CARD ══════════ */
.question-card{background:var(--white);border:1.5px solid var(--border);border-radius:18px;padding:22px 24px;margin-bottom:14px;box-shadow:0 2px 10px rgba(13,31,60,.04);transition:all .25s;animation:fadeUp .4s ease both}
.question-card:hover{transform:translateY(-3px);box-shadow:0 12px 40px rgba(13,31,60,.09);border-color:rgba(15,159,142,.25)}
.question-card:nth-child(2){animation-delay:.05s}
.question-card:nth-child(3){animation-delay:.1s}
.question-card:nth-child(4){animation-delay:.15s}
.question-card:nth-child(5){animation-delay:.2s}

.card-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;gap:10px}
.author-row{display:flex;align-items:center;gap:10px}
.author-avatar{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--teal),var(--teal2));color:#fff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0}
.author-avatar.a2{background:linear-gradient(135deg,#6366f1,#4338ca)}
.author-avatar.a3{background:linear-gradient(135deg,#f59e0b,#d97706)}
.author-avatar.a4{background:linear-gradient(135deg,#ec4899,#be185d)}
.author-name{font-weight:600;font-size:13px;color:var(--navy)}
.author-meta{font-size:11.5px;color:var(--muted);margin-top:1px}
.author-meta span{color:var(--teal);font-weight:600}

.card-tags{display:flex;gap:6px;align-items:center;flex-wrap:wrap}
.spec-tag{background:var(--teal-lt);color:var(--teal2);padding:4px 11px;border-radius:100px;font-size:11px;font-weight:700;letter-spacing:.03em;border:1px solid rgba(15,159,142,.15);white-space:nowrap}
.hot-tag{background:#fef3c7;color:#92400e;border:1px solid #fde68a;padding:4px 11px;border-radius:100px;font-size:10px;font-weight:700;letter-spacing:.04em;text-transform:uppercase}

.question-title{font-family:'DM Serif Display',serif;font-size:17px;line-height:1.35;color:var(--navy);margin-bottom:9px;cursor:pointer;transition:color .2s}
.question-title:hover{color:var(--teal)}
.question-preview{font-size:13.5px;color:var(--muted);line-height:1.65;font-weight:300;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;margin-bottom:16px}

/* Image preview inside card */
.card-image{width:100%;height:160px;object-fit:cover;border-radius:12px;margin-bottom:14px;display:block}

.card-footer{display:flex;align-items:center;justify-content:space-between;border-top:1px solid var(--border);padding-top:13px;gap:12px}
.card-actions{display:flex;gap:14px}
.card-action{display:flex;align-items:center;gap:5px;font-size:12.5px;color:var(--muted);cursor:pointer;transition:color .2s;border:none;background:none;font-family:'DM Sans',sans-serif;padding:0}
.card-action:hover{color:var(--teal)}
.card-action svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
.card-action.liked{color:#f87171}
.card-action.liked svg{fill:#f87171;stroke:#f87171}

.read-more{font-size:12px;font-weight:600;color:var(--teal);text-decoration:none;transition:color .2s;white-space:nowrap}
.read-more:hover{color:var(--teal2)}

/* Pinned card */
.question-card.pinned{border-color:rgba(196,154,60,.35);background:linear-gradient(to bottom right,#fff,#fffdf5)}
.pin-badge{display:flex;align-items:center;gap:5px;font-size:10px;font-weight:700;color:var(--gold);text-transform:uppercase;letter-spacing:.08em;margin-bottom:10px}

/* Load more */
.load-more{width:100%;padding:14px;background:var(--white);border:1.5px solid var(--border);border-radius:14px;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;color:var(--muted);cursor:pointer;transition:all .2s;margin-top:4px}
.load-more:hover{border-color:var(--teal);color:var(--teal);background:var(--teal-lt)}

/* ══════════ RIGHT SIDEBAR ══════════ */

/* Ad card */
.ad-card{border-radius:18px;overflow:hidden;border:1.5px solid var(--border);box-shadow:0 2px 12px rgba(13,31,60,.06);transition:all .2s}
.ad-card:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(13,31,60,.1)}
.ad-img-wrap{position:relative;height:150px;overflow:hidden}
.ad-img-wrap img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .4s}
.ad-card:hover .ad-img-wrap img{transform:scale(1.04)}
.ad-badge{position:absolute;top:10px;right:10px;background:rgba(13,31,60,.6);color:rgba(255,255,255,.65);font-size:9px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:3px 8px;border-radius:5px;backdrop-filter:blur(4px)}
.ad-body{background:var(--white);padding:14px 16px 16px}
.ad-brand{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--teal);margin-bottom:4px}
.ad-title{font-family:'DM Serif Display',serif;font-size:14px;color:var(--navy);line-height:1.35;margin-bottom:12px}
.ad-cta{display:inline-flex;align-items:center;gap:6px;background:var(--navy);color:#fff;font-size:11px;font-weight:700;padding:7px 14px;border-radius:8px;text-decoration:none;transition:background .2s}
.ad-cta:hover{background:var(--teal2)}

/* News */
.news-list{display:flex;flex-direction:column;gap:14px}
.news-item{display:flex;gap:11px;align-items:flex-start;cursor:pointer;text-decoration:none}
.news-thumb{width:58px;height:58px;border-radius:11px;object-fit:cover;flex-shrink:0;transition:transform .25s}
.news-item:hover .news-thumb{transform:scale(1.04)}
.news-tag{font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--teal);margin-bottom:3px}
.news-title{font-size:12.5px;font-weight:600;color:var(--navy);line-height:1.4;display:block;transition:color .2s}
.news-item:hover .news-title{color:var(--teal)}
.news-time{font-size:11px;color:var(--muted);margin-top:3px}

/* Trending topics */
.trend-list{display:flex;flex-direction:column;gap:2px}
.trend-item{display:flex;align-items:center;justify-content:space-between;padding:8px 10px;border-radius:10px;text-decoration:none;cursor:pointer;transition:background .2s}
.trend-item:hover{background:var(--bg)}
.trend-left{display:flex;align-items:center;gap:10px}
.trend-rank{font-size:11px;font-weight:700;color:var(--muted);width:16px;text-align:center}
.trend-name{font-size:13px;font-weight:600;color:var(--navy);transition:color .2s}
.trend-item:hover .trend-name{color:var(--teal)}
.trend-count{font-size:11px;color:var(--muted)}

/* Events */
.event-list{display:flex;flex-direction:column;gap:10px}
.event-item{display:flex;gap:12px;align-items:center;padding:10px;border-radius:12px;transition:background .2s;cursor:pointer}
.event-item:hover{background:var(--bg)}
.event-date-box{width:42px;height:46px;background:var(--teal-lt);border-radius:11px;display:flex;flex-direction:column;align-items:center;justify-content:center;flex-shrink:0;border:1px solid rgba(15,159,142,.18)}
.event-day{font-family:'DM Serif Display',serif;font-size:17px;color:var(--teal2);line-height:1}
.event-mon{font-size:8.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em}
.event-name{font-size:12.5px;font-weight:600;color:var(--navy);line-height:1.35}
.event-loc{font-size:11px;color:var(--muted);margin-top:2px}

/* ══════════ FAB ══════════ */
.fab{position:fixed;bottom:30px;right:30px;display:flex;align-items:center;gap:10px;padding:0 22px;height:50px;background:linear-gradient(135deg,var(--teal),var(--teal2));color:#fff;border-radius:100px;text-decoration:none;font-size:14px;font-weight:700;box-shadow:0 6px 28px rgba(15,159,142,.4);transition:all .2s;z-index:100;font-family:'DM Sans',sans-serif}
.fab:hover{transform:translateY(-2px);box-shadow:0 10px 36px rgba(15,159,142,.5)}
.fab-plus{font-size:20px;font-weight:300;line-height:1}

/* ══════════ FILTER DRAWER ══════════ */
.overlay{position:fixed;inset:0;background:rgba(13,31,60,.4);backdrop-filter:blur(3px);z-index:300;opacity:0;visibility:hidden;transition:all .3s}
.overlay.open{opacity:1;visibility:visible}
.filter-drawer{position:fixed;top:0;left:-360px;width:340px;height:100%;background:var(--white);z-index:301;box-shadow:8px 0 48px rgba(13,31,60,.12);transition:left .35s cubic-bezier(.22,1,.36,1);padding:28px;display:flex;flex-direction:column}
.filter-drawer.open{left:0}
.drawer-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;padding-bottom:18px;border-bottom:1px solid var(--border)}
.drawer-title{font-family:'DM Serif Display',serif;font-size:20px;color:var(--navy)}
.drawer-close{width:32px;height:32px;border-radius:8px;background:var(--bg);border:1.5px solid var(--border);color:var(--muted);font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .2s}
.drawer-close:hover{background:var(--teal-lt);border-color:var(--teal);color:var(--navy)}
.filter-form{display:flex;flex-direction:column;gap:18px;flex:1}
.filter-group{display:flex;flex-direction:column;gap:7px}
.filter-label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.09em;color:var(--muted)}
.filter-group select,.filter-group input[type=text]{padding:11px 14px;border:1.5px solid var(--border);border-radius:12px;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--navy);background:var(--bg);outline:none;transition:all .2s;-webkit-appearance:none;appearance:none}
.filter-group select:focus,.filter-group input:focus{border-color:var(--teal);background:#fff;box-shadow:0 0 0 3px rgba(15,159,142,.08)}
.filter-chips{display:flex;flex-wrap:wrap;gap:7px}
.filter-chip{padding:6px 13px;border:1.5px solid var(--border);border-radius:100px;font-size:12px;font-weight:600;color:var(--muted);cursor:pointer;transition:all .2s;background:var(--white)}
.filter-chip:hover,.filter-chip.active{border-color:var(--teal);color:var(--teal);background:var(--teal-lt)}
.apply-btn{margin-top:auto;padding:14px;background:linear-gradient(135deg,var(--teal),var(--teal2));color:#fff;border:none;border-radius:13px;font-family:'DM Sans',sans-serif;font-weight:700;font-size:15px;cursor:pointer;box-shadow:0 4px 18px rgba(15,159,142,.25);transition:all .2s}
.apply-btn:hover{opacity:.9;transform:translateY(-1px)}

/* ══════════ RESPONSIVE ══════════ */
@media(max-width:1100px){.page-wrapper{grid-template-columns:230px 1fr}.sidebar-right{display:none}}
@media(max-width:800px){.page-wrapper{grid-template-columns:1fr;padding:16px 14px 90px}.sidebar-left{display:none}.hero-slider{height:220px}.nav-links{display:none}.quick-stats{display:none}}
@media(max-width:500px){.feed-tabs{display:none}.hero-slider{height:180px}.fab{right:16px;bottom:20px;padding:0 18px;height:46px;font-size:13px}}
</style>
</head>
<body>

<!-- ══ TOP BAR ══ -->
<div class="topbar">
  <div class="topbar-left">
    <div class="live-badge"><div class="live-dot"></div> 1.240 medici online ora</div>
    <span>·</span>
    <a href="#">📋 Linee guida ESC 2025 aggiornate</a>
  </div>
  <div class="topbar-right">
    <a href="#">ECM & Formazione</a>
    <a href="#">Contatti</a>
    <a href="#">App Mobile</a>
  </div>
</div>

<!-- ══ HEADER ══ -->
<header>
  <a href="index.php" class="nav-logo">
    <span class="cross">✚</span>
    MedicoForum
  </a>

  <nav class="nav-links">
    <a href="#" class="active">🏠 Home</a>
    <a href="#">🩺 Casi Clinici</a>
    <a href="#">📚 Ricerca</a>
    <a href="#">🤝 Network</a>
    <a href="#">📅 Congressi</a>
  </nav>

  <div class="nav-search">
    <div class="search-icon">
      <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    </div>
    <input type="text" placeholder="Cerca casi, colleghi…">
  </div>

  <div class="nav-right">
    <div class="icon-btn" id="openFilters" title="Filtri">
      <svg viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
    </div>
    <a href="#" class="icon-btn" title="Messaggi">
      <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
    </a>
    <a href="#" class="icon-btn" title="Notifiche">
      <div class="badge-dot"></div>
      <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
    </a>
    <a href="profilo.php" class="profile-pill">
      <span class="avatar">DR</span>
      Dr. Rossi
    </a>
  </div>
</header>

<!-- ══ HERO SLIDESHOW ══ -->
<div class="hero-slider" id="heroSlider">
  <div class="slide active">
    <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=1600&q=80" alt="">
    <div class="slide-overlay"></div>
    <div class="slide-content">
      <div class="slide-inner">
        <div class="slide-tag">In evidenza</div>
        <h2 class="slide-title">Nuove linee guida ESC sulla <em>fibrillazione atriale</em></h2>
        <p class="slide-desc">L'European Society of Cardiology ha pubblicato le raccomandazioni aggiornate 2025. Partecipa alla discussione con i tuoi colleghi cardiologi.</p>
        <a href="#" class="slide-btn">Leggi la discussione →</a>
      </div>
    </div>
  </div>
  <div class="slide">
    <img src="https://images.unsplash.com/photo-1504813184591-01572f98c85f?w=1600&q=80" alt="">
    <div class="slide-overlay"></div>
    <div class="slide-content">
      <div class="slide-inner">
        <div class="slide-tag">Caso clinico</div>
        <h2 class="slide-title">Diagnosi differenziale di <em>FUO</em> in paziente immunocompromesso</h2>
        <p class="slide-desc">Un caso complesso di febbre di origine sconosciuta che ha coinvolto 12 specialisti da tutta Italia. Condividi la tua esperienza.</p>
        <a href="#" class="slide-btn">Partecipa →</a>
      </div>
    </div>
  </div>
  <div class="slide">
    <img src="https://images.unsplash.com/photo-1551076805-e1869033e561?w=1600&q=80" alt="">
    <div class="slide-overlay"></div>
    <div class="slide-content">
      <div class="slide-inner">
        <div class="slide-tag">Congresso</div>
        <h2 class="slide-title">Congresso Nazionale <em>ANMCO 2025</em> — Milano</h2>
        <p class="slide-desc">12-14 Aprile · Fieramilano. Iscriviti gratuitamente tramite MedicoForum e ottieni crediti ECM.</p>
        <a href="#" class="slide-btn">Iscriviti gratis →</a>
      </div>
    </div>
  </div>
  <div class="slide">
    <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=1600&q=80" alt="">
    <div class="slide-overlay"></div>
    <div class="slide-content">
      <div class="slide-inner">
        <div class="slide-tag">Ricerca</div>
        <h2 class="slide-title">FDA approva nuovo inibitore per <em>tumori HER2+</em></h2>
        <p class="slide-desc">La comunità oncologica di MedicoForum sta analizzando l'impatto clinico dell'approvazione. Unisciti al dibattito.</p>
        <a href="#" class="slide-btn">Scopri di più →</a>
      </div>
    </div>
  </div>

  <!-- Controls -->
  <div class="slide-controls">
    <div class="slide-dot active" data-i="0"></div>
    <div class="slide-dot" data-i="1"></div>
    <div class="slide-dot" data-i="2"></div>
    <div class="slide-dot" data-i="3"></div>
    <div class="slide-arrows">
      <div class="slide-arrow" id="prevSlide"><svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></div>
      <div class="slide-arrow" id="nextSlide"><svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></div>
    </div>
  </div>
</div>

<!-- ══ QUICK STATS ══ -->
<div class="quick-stats">
  <div class="qstat">
    <div class="qstat-icon">👨‍⚕️</div>
    <div><div class="qstat-num">14.800+</div><div class="qstat-label">Medici iscritti</div></div>
  </div>
  <div class="qstat">
    <div class="qstat-icon">🩺</div>
    <div><div class="qstat-num">58.400</div><div class="qstat-label">Casi clinici</div></div>
  </div>
  <div class="qstat">
    <div class="qstat-icon">💬</div>
    <div><div class="qstat-num">340</div><div class="qstat-label">Discussioni oggi</div></div>
  </div>
  <div class="qstat">
    <div class="qstat-icon">🏥</div>
    <div><div class="qstat-num">320+</div><div class="qstat-label">Specialità</div></div>
  </div>
  <div class="qstat">
    <div class="qstat-icon">⭐</div>
    <div><div class="qstat-num">4.9 / 5</div><div class="qstat-label">Soddisfazione</div></div>
  </div>
</div>

<!-- ══ LAYOUT 3 COLONNE ══ -->
<div class="page-wrapper">

  <!-- ══ SIDEBAR SINISTRA ══ -->
  <aside class="sidebar sidebar-left">

    <!-- Profilo -->
    <div class="profile-widget">
      <div class="profile-card">
        <div class="profile-cover"></div>
        <div class="profile-info">
          <div class="big-avatar">DR</div>
          <div class="pname">Dr. Mario Rossi</div>
          <div class="pspec">Medicina Interna · Bologna</div>
          <div class="profile-stats">
            <div class="pstat"><div class="pstat-num">24</div><div class="pstat-label">Post</div></div>
            <div class="pstat"><div class="pstat-num">138</div><div class="pstat-label">Risposte</div></div>
            <div class="pstat"><div class="pstat-num">4</div><div class="pstat-label">Salvati</div></div>
            <div class="pstat"><div class="pstat-num">92</div><div class="pstat-label">Like</div></div>
          </div>
        </div>
        <div class="profile-complete">
          <div class="complete-label">Profilo completato <span>72%</span></div>
          <div class="complete-bar"><div class="complete-fill"></div></div>
        </div>
      </div>
    </div>

    <!-- Specializzazioni -->
    <div class="widget">
      <div class="widget-header">
        <span class="widget-title"><span class="widget-title-icon">🏷️</span> Specializzazioni</span>
        <a href="#" class="widget-link">Tutte →</a>
      </div>
      <div class="widget-body">
        <ul class="spec-list">
          <li><a href="#"><span class="spec-left"><span class="spec-emoji">🫀</span> Cardiologia</span><span class="count-pill">48</span></a></li>
          <li><a href="#"><span class="spec-left"><span class="spec-emoji">👶</span> Pediatria</span><span class="count-pill">31</span></a></li>
          <li><a href="#"><span class="spec-left"><span class="spec-emoji">🧠</span> Neurologia</span><span class="count-pill">27</span></a></li>
          <li><a href="#"><span class="spec-left"><span class="spec-emoji">🩺</span> Med. Interna</span><span class="count-pill">22</span></a></li>
          <li><a href="#"><span class="spec-left"><span class="spec-emoji">🦴</span> Ortopedia</span><span class="count-pill">15</span></a></li>
          <li><a href="#"><span class="spec-left"><span class="spec-emoji">🔬</span> Oncologia</span><span class="count-pill">19</span></a></li>
          <li><a href="#"><span class="spec-left"><span class="spec-emoji">🫁</span> Pneumologia</span><span class="count-pill">14</span></a></li>
        </ul>
      </div>
    </div>

    <!-- Quick links -->
    <div class="widget">
      <div class="widget-header">
        <span class="widget-title"><span class="widget-title-icon">⚡</span> Accesso rapido</span>
      </div>
      <div class="widget-body" style="padding:10px 14px">
        <div class="quick-links">
          <a href="#" class="quick-link"><span class="quick-link-icon">📌</span> Post salvati</a>
          <a href="#" class="quick-link"><span class="quick-link-icon">📊</span> Le mie statistiche</a>
          <a href="#" class="quick-link"><span class="quick-link-icon">🏆</span> Badge e riconoscimenti</a>
          <a href="#" class="quick-link"><span class="quick-link-icon">📅</span> I miei congressi</a>
          <a href="#" class="quick-link"><span class="quick-link-icon">⚙️</span> Impostazioni</a>
        </div>
      </div>
    </div>

  </aside>

  <!-- ══ FEED CENTRALE ══ -->
  <main>

    <div class="feed-header">
      <div class="feed-title-group">
        <div class="feed-label">Community</div>
        <div class="feed-title">Discussioni recenti</div>
      </div>
      <div class="feed-tabs">
        <button class="feed-tab active">🔥 Popolari</button>
        <button class="feed-tab">🕐 Recenti</button>
        <button class="feed-tab">⭐ Seguiti</button>
        <button class="feed-tab">📌 Salvati</button>
      </div>
    </div>

    <!-- New post box -->
    <div class="new-post-box">
      <div class="new-post-avatar">DR</div>
      <div class="new-post-placeholder">Condividi un caso clinico o fai una domanda ai colleghi…</div>
      <div class="new-post-actions">
        <div class="np-btn" title="Immagine">📷</div>
        <div class="np-btn" title="File">📎</div>
      </div>
    </div>

    <!-- CARD PINNED -->
    <article class="question-card pinned">
      <div class="pin-badge">📌 In evidenza dalla redazione</div>
      <div class="card-top">
        <div class="author-row">
          <div class="author-avatar">GV</div>
          <div>
            <div class="author-name">Dr. G. Verdi</div>
            <div class="author-meta"><span>Cardiologia</span> · 2 ore fa</div>
          </div>
        </div>
        <div class="card-tags">
          <span class="spec-tag">Cardiologia</span>
          <span class="hot-tag">🔥 Hot</span>
        </div>
      </div>
      <h2 class="question-title">Interazione tra DOACs e nuovi farmaci antiepilettici: esperienze cliniche a confronto?</h2>
      <p class="question-preview">Ho un paziente di 72 anni in terapia con Apixaban per fibrillazione atriale non valvolare. Recentemente il neurologo ha introdotto un nuovo farmaco antiepilettico e mi trovo a gestire una situazione di potenziale interazione farmacologica importante…</p>
      <div class="card-footer">
        <div class="card-actions">
          <button class="card-action liked">
            <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            24
          </button>
          <button class="card-action">
            <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            14 risposte
          </button>
          <button class="card-action">
            <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            132 viste
          </button>
        </div>
        <a href="#" class="read-more">Leggi tutto →</a>
      </div>
    </article>

    <!-- CARD 2 con immagine -->
    <article class="question-card">
      <div class="card-top">
        <div class="author-row">
          <div class="author-avatar a2">LB</div>
          <div>
            <div class="author-name">Dott.ssa L. Bianchi</div>
            <div class="author-meta"><span>Pediatria</span> · 5 ore fa</div>
          </div>
        </div>
        <div class="card-tags"><span class="spec-tag">Pediatria</span></div>
      </div>
      <h2 class="question-title">Gestione della bronchiolite nel neonato pretermine: linee guida aggiornate 2025</h2>
      <img class="card-image" src="https://images.unsplash.com/photo-1581056771107-24ca5f033842?w=800&q=75" alt="Neonato">
      <p class="question-preview">Confronto sull'utilizzo della soluzione fisiologica ipertonica al 3% aerosolizzata nei lattanti sotto i 3 mesi con anamnesi di prematurità. Le nuove linee guida sembrano divergere rispetto alla pratica clinica consolidata…</p>
      <div class="card-footer">
        <div class="card-actions">
          <button class="card-action">
            <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            18
          </button>
          <button class="card-action">
            <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            12 risposte
          </button>
          <button class="card-action">
            <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            89 viste
          </button>
        </div>
        <a href="#" class="read-more">Leggi tutto →</a>
      </div>
    </article>

    <!-- CARD 3 -->
    <article class="question-card">
      <div class="card-top">
        <div class="author-row">
          <div class="author-avatar a3">MR</div>
          <div>
            <div class="author-name">Dr. M. Romano</div>
            <div class="author-meta"><span>Med. Interna</span> · Ieri</div>
          </div>
        </div>
        <div class="card-tags"><span class="spec-tag">Medicina Interna</span></div>
      </div>
      <h2 class="question-title">Iter diagnostico per sospetta febbre di origine sconosciuta (FUO) in paziente 45 anni</h2>
      <p class="question-preview">Paziente femmina, 45 anni, presenta febbricola persistente serale da oltre 3 settimane. Esami ematochimici di base nella norma, PCR lievemente mossa. Come impostereste il workup diagnostico in seconda battuta?</p>
      <div class="card-footer">
        <div class="card-actions">
          <button class="card-action">
            <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            9
          </button>
          <button class="card-action">
            <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            7 risposte
          </button>
          <button class="card-action">
            <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            54 viste
          </button>
        </div>
        <a href="#" class="read-more">Leggi tutto →</a>
      </div>
    </article>

    <!-- CARD 4 -->
    <article class="question-card">
      <div class="card-top">
        <div class="author-row">
          <div class="author-avatar a4">SF</div>
          <div>
            <div class="author-name">Dott.ssa S. Ferrari</div>
            <div class="author-meta"><span>Oncologia</span> · 2 giorni fa</div>
          </div>
        </div>
        <div class="card-tags"><span class="spec-tag">Oncologia</span><span class="hot-tag">🆕 Nuovo</span></div>
      </div>
      <h2 class="question-title">Impatto clinico della nuova approvazione FDA per tumori HER2+: prime evidenze italiane</h2>
      <p class="question-preview">Dopo l'approvazione del nuovo inibitore, stiamo raccogliendo le prime esperienze italiane. Chi ha già utilizzato questo farmaco in trial o in uso compassionevole? Quali outcome avete osservato?</p>
      <div class="card-footer">
        <div class="card-actions">
          <button class="card-action">
            <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            31
          </button>
          <button class="card-action">
            <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            19 risposte
          </button>
          <button class="card-action">
            <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            210 viste
          </button>
        </div>
        <a href="#" class="read-more">Leggi tutto →</a>
      </div>
    </article>

    <!-- CARD 5 -->
    <article class="question-card">
      <div class="card-top">
        <div class="author-row">
          <div class="author-avatar">AC</div>
          <div>
            <div class="author-name">Dr. A. Conti</div>
            <div class="author-meta"><span>Neurologia</span> · 3 giorni fa</div>
          </div>
        </div>
        <div class="card-tags"><span class="spec-tag">Neurologia</span></div>
      </div>
      <h2 class="question-title">Nuovi biomarcatori liquorali per diagnosi precoce Alzheimer: esperienza clinica</h2>
      <p class="question-preview">Con la recente disponibilità dei biomarcatori Aβ42/40 e p-tau217 nel liquor, come state integrando questi dati nella vostra pratica clinica? Quali soglie di cut-off utilizzate nella realtà italiana?</p>
      <div class="card-footer">
        <div class="card-actions">
          <button class="card-action">
            <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            15
          </button>
          <button class="card-action">
            <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            8 risposte
          </button>
          <button class="card-action">
            <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            76 viste
          </button>
        </div>
        <a href="#" class="read-more">Leggi tutto →</a>
      </div>
    </article>

    <button class="load-more">Carica altre discussioni →</button>

  </main>

  <!-- ══ SIDEBAR DESTRA ══ -->
  <aside class="sidebar sidebar-right">

    <!-- AD 1 -->
    <div class="ad-card">
      <div class="ad-img-wrap">
        <span class="ad-badge">Sponsorizzato</span>
        <img src="https://images.unsplash.com/photo-1585435557343-3b092031a831?w=600&q=75" alt="">
      </div>
      <div class="ad-body">
        <div class="ad-brand">Medscape CME</div>
        <div class="ad-title">Aggiornamento ECM in Cardiologia Interventistica 2025</div>
        <a href="#" class="ad-cta">Scopri il corso →</a>
      </div>
    </div>

    <!-- NEWS -->
    <div class="widget">
      <div class="widget-header">
        <span class="widget-title"><span class="widget-title-icon">📰</span> News Mediche</span>
        <a href="#" class="widget-link">Tutte →</a>
      </div>
      <div class="widget-body">
        <div class="news-list">
          <a href="#" class="news-item">
            <img class="news-thumb" src="https://images.unsplash.com/photo-1579165466741-7f35e4755182?w=200&q=70" alt="">
            <div>
              <div class="news-tag">Ricerca</div>
              <span class="news-title">Nuovi biomarcatori per la diagnosi precoce dell'Alzheimer</span>
              <div class="news-time">3 ore fa</div>
            </div>
          </a>
          <a href="#" class="news-item">
            <img class="news-thumb" src="https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=200&q=70" alt="">
            <div>
              <div class="news-tag">Linee Guida</div>
              <span class="news-title">ESC aggiorna le raccomandazioni sulla fibrillazione atriale</span>
              <div class="news-time">Ieri</div>
            </div>
          </a>
          <a href="#" class="news-item">
            <img class="news-thumb" src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=200&q=70" alt="">
            <div>
              <div class="news-tag">Farmacologia</div>
              <span class="news-title">FDA approva nuovo inibitore per tumori HER2+</span>
              <div class="news-time">2 giorni fa</div>
            </div>
          </a>
        </div>
      </div>
    </div>

    <!-- TRENDING -->
    <div class="widget">
      <div class="widget-header">
        <span class="widget-title"><span class="widget-title-icon">📈</span> Trending</span>
      </div>
      <div class="widget-body" style="padding:10px 14px">
        <div class="trend-list">
          <div class="trend-item"><div class="trend-left"><span class="trend-rank">1</span><span class="trend-name">#FibrillazioneAtriale</span></div><span class="trend-count">142 post</span></div>
          <div class="trend-item"><div class="trend-left"><span class="trend-rank">2</span><span class="trend-name">#Alzheimer2025</span></div><span class="trend-count">98 post</span></div>
          <div class="trend-item"><div class="trend-left"><span class="trend-rank">3</span><span class="trend-name">#DOAC</span></div><span class="trend-count">87 post</span></div>
          <div class="trend-item"><div class="trend-left"><span class="trend-rank">4</span><span class="trend-name">#HER2</span></div><span class="trend-count">74 post</span></div>
          <div class="trend-item"><div class="trend-left"><span class="trend-rank">5</span><span class="trend-name">#Bronchiolite</span></div><span class="trend-count">61 post</span></div>
        </div>
      </div>
    </div>

    <!-- AD 2 -->
    <div class="ad-card">
      <div class="ad-img-wrap">
        <span class="ad-badge">Sponsorizzato</span>
        <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=600&q=75" alt="">
      </div>
      <div class="ad-body">
        <div class="ad-brand">Humanitas Research</div>
        <div class="ad-title">Posizioni aperte per Specialisti in Medicina d'Urgenza</div>
        <a href="#" class="ad-cta">Candidati ora →</a>
      </div>
    </div>

    <!-- EVENTI -->
    <div class="widget">
      <div class="widget-header">
        <span class="widget-title"><span class="widget-title-icon">📅</span> Prossimi Congressi</span>
        <a href="#" class="widget-link">Vedi tutti →</a>
      </div>
      <div class="widget-body">
        <div class="event-list">
          <div class="event-item">
            <div class="event-date-box"><span class="event-day">12</span><span class="event-mon">Apr</span></div>
            <div><div class="event-name">Congresso Nazionale ANMCO</div><div class="event-loc">📍 Milano, Fieramilano</div></div>
          </div>
          <div class="event-item">
            <div class="event-date-box"><span class="event-day">24</span><span class="event-mon">Apr</span></div>
            <div><div class="event-name">Workshop Pediatria d'Urgenza</div><div class="event-loc">📍 Roma, Bambino Gesù</div></div>
          </div>
          <div class="event-item">
            <div class="event-date-box"><span class="event-day">08</span><span class="event-mon">Mag</span></div>
            <div><div class="event-name">Forum Oncologia 2025</div><div class="event-loc">📍 Bologna, IRCCS</div></div>
          </div>
          <div class="event-item">
            <div class="event-date-box"><span class="event-day">21</span><span class="event-mon">Mag</span></div>
            <div><div class="event-name">Congresso SIN — Neurologia</div><div class="event-loc">📍 Firenze, Fortezza</div></div>
          </div>
        </div>
      </div>
    </div>

  </aside>

</div>

<!-- ══ FAB ══ -->
<a href="/nuova-domanda" class="fab">
  <span class="fab-plus">+</span>
  Nuova discussione
</a>

<!-- ══ FILTER DRAWER ══ -->
<div class="overlay" id="overlay"></div>
<div class="filter-drawer" id="filterDrawer">
  <div class="drawer-header">
    <div class="drawer-title">Filtra discussioni</div>
    <button class="drawer-close" id="closeDrawer">✕</button>
  </div>
  <div class="filter-form">
    <div class="filter-group">
      <div class="filter-label">Specializzazione</div>
      <select><option>Tutte le specializzazioni</option><option>Cardiologia</option><option>Pediatria</option><option>Neurologia</option><option>Oncologia</option><option>Medicina Interna</option></select>
    </div>
    <div class="filter-group">
      <div class="filter-label">Ordina per</div>
      <select><option>Più recenti</option><option>Più commentati</option><option>Più votati</option><option>Più visti</option></select>
    </div>
    <div class="filter-group">
      <div class="filter-label">Periodo</div>
      <div class="filter-chips">
        <div class="filter-chip active">Oggi</div>
        <div class="filter-chip">7 giorni</div>
        <div class="filter-chip">30 giorni</div>
        <div class="filter-chip">Tutto</div>
      </div>
    </div>
    <div class="filter-group">
      <div class="filter-label">Tipo di contenuto</div>
      <div class="filter-chips">
        <div class="filter-chip active">Tutto</div>
        <div class="filter-chip">Casi clinici</div>
        <div class="filter-chip">Domande</div>
        <div class="filter-chip">Ricerca</div>
        <div class="filter-chip">News</div>
      </div>
    </div>
    <div class="filter-group">
      <div class="filter-label">Cerca per parola chiave</div>
      <input type="text" placeholder="es. DOACs, bronchiolite…">
    </div>
    <button class="apply-btn">Applica filtri →</button>
  </div>
</div>

<script>
// ── Slideshow ──
let cur = 0;
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.slide-dot');

function goTo(n) {
  slides[cur].classList.remove('active');
  dots[cur].classList.remove('active');
  cur = (n + slides.length) % slides.length;
  slides[cur].classList.add('active');
  dots[cur].classList.add('active');
}

let timer = setInterval(() => goTo(cur + 1), 5000);

document.getElementById('nextSlide').addEventListener('click', () => { clearInterval(timer); goTo(cur + 1); timer = setInterval(() => goTo(cur + 1), 5000); });
document.getElementById('prevSlide').addEventListener('click', () => { clearInterval(timer); goTo(cur - 1); timer = setInterval(() => goTo(cur + 1), 5000); });
dots.forEach(d => d.addEventListener('click', () => { clearInterval(timer); goTo(+d.dataset.i); timer = setInterval(() => goTo(cur + 1), 5000); }));

// ── Feed tabs ──
document.querySelectorAll('.feed-tab').forEach(t => {
  t.addEventListener('click', () => {
    document.querySelectorAll('.feed-tab').forEach(x => x.classList.remove('active'));
    t.classList.add('active');
  });
});

// ── Filter drawer ──
const overlay = document.getElementById('overlay');
const drawer = document.getElementById('filterDrawer');
document.getElementById('openFilters').addEventListener('click', () => { overlay.classList.add('open'); drawer.classList.add('open'); });
document.getElementById('closeDrawer').addEventListener('click', () => { overlay.classList.remove('open'); drawer.classList.remove('open'); });
overlay.addEventListener('click', () => { overlay.classList.remove('open'); drawer.classList.remove('open'); });

// ── Filter chips ──
document.querySelectorAll('.filter-chips').forEach(group => {
  group.querySelectorAll('.filter-chip').forEach(chip => {
    chip.addEventListener('click', () => {
      group.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
      chip.classList.add('active');
    });
  });
});

// ── Like toggle ──
document.querySelectorAll('.card-action').forEach(btn => {
  btn.addEventListener('click', function() {
    if (this.querySelector('path[d*="20.84"]')) {
      this.classList.toggle('liked');
    }
  });
});
</script>
</body>
</html>