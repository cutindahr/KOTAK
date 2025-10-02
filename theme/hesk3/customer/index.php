<?php
global $hesk_settings, $hesklang;

// This guard is used to ensure that users can't hit this outside of actual HESK code
if (!defined('IN_SCRIPT')) {
    die();
}

/**
 * @var array $top_articles
 * @var array $latest_articles
 * @var array $service_messages
 */

$service_message_type_to_class = array(
    '0' => 'none',
    '1' => 'success',
    '2' => '', // Info has no CSS class
    '3' => 'warning',
    '4' => 'danger'
);

require_once(TEMPLATE_PATH . 'customer/util/alerts.php');
require_once(TEMPLATE_PATH . 'customer/util/kb-search.php');
require_once(TEMPLATE_PATH . 'customer/util/rating.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $hesk_settings['hesk_title']; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo HESK_PATH; ?>img/favicon/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo HESK_PATH; ?>img/favicon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo HESK_PATH; ?>img/favicon/favicon-16x16.png" />
    <link rel="manifest" href="<?php echo HESK_PATH; ?>img/favicon/site.webmanifest" />
    <link rel="mask-icon" href="<?php echo HESK_PATH; ?>img/favicon/safari-pinned-tab.svg" color="#5bbad5" />
    <link rel="shortcut icon" href="<?php echo HESK_PATH; ?>img/favicon/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="msapplication-TileColor" content="#2d89ef" />
    <meta name="msapplication-config" content="<?php echo HESK_PATH; ?>img/favicon/browserconfig.xml" />
    <meta name="theme-color" content="#ffffff" />
    <meta name="format-detection" content="telephone=no" />
    <link rel="stylesheet" media="all" href="<?php echo TEMPLATE_PATH; ?>customer/css/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.css?<?php echo $hesk_settings['hesk_version']; ?>" />
    <!--[if IE]>
    <link rel="stylesheet" media="all" href="<?php echo TEMPLATE_PATH; ?>customer/css/ie9.css" />
    <![endif]-->
    <style>
        @media screen and (max-width: 600px) {
          .hidedong {
            visibility: hidden;
            position: absolute;
            left: 0;
          }
          .fitral-text-kecil {
            font-size:0px;
          }
        }
        @media screen and (min-width: 601px) {
          .fitral-text-besar {
            font-size:12px;
          }
        }
        
        <?php outputSearchStyling(); ?>
        .fitral{display:-ms-inline-flexbox;display:inline-flex;-ms-flex-align:center;align-items:center;width:100%;max-width:280px;margin:16px;padding:16px;box-shadow:0 4px 8px 0 rgba(38,40,42,.3);background-color:#fff;letter-spacing:.1px;color:#000000;transition:none}
        .fitral:hover{box-shadow:0 2px 3px 0 rgba(38,40,42,.4);transition:none;background-color:#dcecdf}
        .fitral .fitral__title{font-size:14px;font-weight:700;line-height:1.5;color:#036111}
        .fitral .fitral__descr{font-size:12px}
        .fitral .fitral-icon-in-circle{margin-right:12px}
        .fitral:hover>.fitral-icon-in-circle .icon{transition:none;fill:#fff}
        .fitral-condensed{margin:8px;padding:8px;box-shadow:0 2px 5px 0 rgba(38,40,42,.1)}
        .fitral-condensed:hover{box-shadow:0 4px 6px 0 rgba(38,40,42,.1)}
        .ratefitral { display: -ms-inline-flexbox;
                display: inline-flex;
                margin-left: auto;
                font-size: 12px;
                letter-spacing: .1px
            }
        .topics__block {
            width: 50%;
        }
        .fitral-icon-in-circle {
            width: 40px;
            height: 40px;
            -ms-flex-negative: 0;
            flex-shrink: 0;
            display: -ms-inline-flexbox;
            display: inline-flex;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-align: center;
            align-items: center;
            background-color: #ffffff;
            border-radius: 50%;
        }
    </style>
    <?php include(TEMPLATE_PATH . '../../head.txt'); ?>
</head>

<body class="cust-help">
    <!-- div style="position:fixed;right:20px;bottom:20px;">
    <a href="https://wa.me/+62895332004883?text=Saleum,%20Hai%20Tim%20KOTAK,%20Saya%20ingin%20berkonsultasi..." target="blank">
    <p class="fitral-text-kecil fitral-text-besar" style="color:green;text-align:center;">Konsultasi<br/>Tim KOTAK : <br/>
    <i class="fa fa-whatsapp fitral-icon-in-circle" style="font-size:48px;color:green;background-color:#ffffff;"></i></p>
    </a>
    </div -->
<?php include(TEMPLATE_PATH . '../../header.txt'); ?>
<div class="wrapper">
    <main class="main">
        <header class="header">
            <div class="contr">
                <div class="header__inner">
                    <img src="artikel/gambar/logo bps panjang.png"></img><img src="img/logokotak.png"></img>
                    <?php if ($hesk_settings['can_sel_lang']): ?>
                        <div class="header__lang">
                            <form method="get" action="" style="margin:0;padding:0;border:0;white-space:nowrap;">
                            <div class="dropdown-select center out-close">
                                <select name="language" onchange="this.form.submit()">
                                    <?php hesk_listLanguages(); ?>
                                </select>
                            </div>
                            <?php foreach (hesk_getCurrentGetParameters() as $key => $value): ?>
                            <input type="hidden" name="<?php echo hesk_htmlentities($key); ?>"
                                   value="<?php echo hesk_htmlentities($value); ?>">
                            <?php endforeach; ?>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </header>
        <div class="breadcrumbs">
            <div class="contr">
                <div class="breadcrumbs__inner">
                    <a href="<?php echo $hesk_settings['site_url']; ?>">
                        <span><?php echo $hesk_settings['site_title']; ?></span>
                    </a>
                    <svg class="icon icon-chevron-right">
                        <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-chevron-right"></use>
                    </svg>
                    <div class="last"><?php echo $hesk_settings['hesk_title']; ?></div>
                    <div class="ratefitral">
                        <a href="artikel/pedoman/Pedoman Web Kotak.pdf" target="_blank">
                            <svg class="icon icon-document">
                                <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-export"></use>
                            </svg>Unduh Panduan</a>&nbsp&nbsp|&nbsp                
                        <a href="https://qna-upgrade.bpsaceh.com/knowledgebase.php?article=83">
                            <svg class="icon icon-document">
                                <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-info"></use>
                            </svg>Filosofi Logo KOTAK</a>&nbsp&nbsp|&nbsp
                        <a href="index.php?a=add&category=1">
                            <svg class="icon icon-document">
                                <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-submit-ticket"></use>
                            </svg>Berikan Feedback</a>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="main__content">
            <div class="contr">
                <div class="help-search">
                    <h2 class="search__title"><?php echo $hesklang['how_can_we_help']; ?></h2>
                    <?php displayKbSearch(); ?>
                </div>
                <div class="image-container">
                    <img src="artikel/gambar/kotak_modif.jpg"></img>
                </div>
                <?php hesk3_show_messages($service_messages); ?>
                <!--\ div class="nav">
                    <a href="https://wa.me/+62895332004883?text=Saleum,%20Hai%20Tim%20KOTAK,%20Saya%20ingin%20berkonsultasi..." target="blank" class="fitral">
                        <div class="fitral-icon-in-circle">
                            <i class="fa fa-whatsapp" style="font-size:48px;color:green"></i>
                        </div>
                        <div>
                            <h5 class="fitral__title">WHATSAPP KOTAK</h5>
                            <div class="fitral__descr">Hubungi PIC kami melalui Whatsapp</div>
                        </div>
                    </a>
                </div> -->
                <!-- div class="nav">
                    <a href="index.php?a=add" class="fitral">
                        <div class="icon-in-circle">
                            <svg class="icon icon-submit-ticket">
                                <use xlink:href="< ?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-submit-ticket"></use>
                            </svg>
                        </div>
                        <div>
                            <h5 class="fitral__title">< ?php echo $hesklang['submit_ticket']; ?></h5>
                            <div class="fitral__descr">< ?php echo $hesklang['open_ticket']; ?></div>
                        </div>
                    </a>
                    <a href="ticket.php" class="fitral">
                        <div class="icon-in-circle">
                            <svg class="icon icon-document">
                                <use xlink:href="< ?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-document"></use>
                            </svg>
                        </div>
                        <div>
                            <h5 class="fitral__title">< ?php echo $hesklang['view_existing_tickets']; ?></h5>
                            <div class="fitral__descr">< ?php echo $hesklang['vet']; ?></div>
                        </div>
                    </a>           
                    <a href="/artikel/pedoman/Pedoman Web Kotak.pdf" target="_blank" class="fitral">
                        <div class="icon-in-circle">
                            <svg class="icon icon-document">
                                <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-export"></use>
                            </svg>
                        </div>
                        <div>
                            <h5 class="fitral__title">Unduh panduan</h5>
                            <div class="fitral__descr">Tata cara penggunaan web KOTAK</div>
                        </div>
                    </a>
                </div -->
                <?php if ($hesk_settings['kb_enable']): ?>
                <article class="article">
                    <h3 class="article__heading">
                        <a href="knowledgebase.php">
                            <div class="icon-in-circle">
                                <svg class="icon icon-knowledge">
                                    <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-knowledge"></use>
                                </svg>
                            </div>
                            <span><?php echo $hesklang['kb_text']; ?></span>
                        </a>
                    </h3>
                    
                    <div class="topics">
                        <div class="topics__block">
                            <h5 class="topics__title">
                                <svg class="icon icon-folder">
                                    <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-folder"></use>
                                </svg>
                                <span>
                                    <a class="title-link" href="knowledgebase.php?category=2">Arsip
                                    </a>
                                </span>
                            </h5>
                        </div>
                        <div class="topics__block">
                            <h5 class="topics__title">
                                <svg class="icon icon-folder">
                                    <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-folder"></use>
                                </svg>
                                <span>
                                    <a class="title-link" href="knowledgebase.php?category=4">SDM
                                    </a>
                                </span>
                            </h5>
                        </div>
                        <div class="topics__block">
                            <h5 class="topics__title">
                                <svg class="icon icon-folder">
                                    <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-folder"></use>
                                </svg>
                                <span>
                                    <a class="title-link" href="knowledgebase.php?category=5">BMN
                                    </a>
                                </span>
                            </h5>
                        </div>                    
                        <div class="topics__block">
                            <h5 class="topics__title">
                                <svg class="icon icon-folder">
                                    <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-folder"></use>
                                </svg>
                                <span>
                                    <a class="title-link" href="knowledgebase.php?category=6">Keuangan
                                    </a>
                                </span>
                            </h5>
                        </div>                        
                        <div class="topics__block">
                            <h5 class="topics__title">
                                <svg class="icon icon-folder">
                                    <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-folder"></use>
                                </svg>
                                <span>
                                    <a class="title-link" href="knowledgebase.php?category=7">Humas
                                    </a>
                                </span>
                            </h5>
                        </div>
                    
                    </div>    
                        
                    <br/>
                        
                    <div class="tabbed__head">
                        <ul class="tabbed__head_tabs">
                            <?php
                            if (count($top_articles) > 0):
                            ?>
                            <li class="current" data-link="tab1">
                                <span><?php echo $hesklang['popart']; ?></span>
                            </li>
                            <?php
                            endif;
                            if (count($latest_articles) > 0):
                            ?>
                            <li data-link="tab2">
                                <span><?php echo $hesklang['latart']; ?></span>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="tabbed__tabs">
                        <?php if (count($top_articles) > 0): ?>
                        <div class="tabbed__tabs_tab is-visible" data-tab="tab1">
                            <?php foreach ($top_articles as $article): ?>
                            <a href="knowledgebase.php?article=<?php echo $article['id']; ?>" class="preview">
                                <div class="icon-in-circle">
                                    <svg class="icon icon-knowledge">
                                        <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-knowledge"></use>
                                    </svg>
                                </div>
                                <div class="preview__text">
                                    <h5 class="preview__title"><?php echo $article['subject'] ?></h5>
                                    <p>
                                        <span class="lightgrey"><?php echo $hesklang['kb_cat']; ?>:</span>
                                        <span class="ml-1"><?php echo $article['category']; ?></span>
                                    </p>
                                    <p class="navlink__descr">
                                        <?php echo $article['content_preview']; ?>
                                    </p>
                                </div>
                                <?php if ($hesk_settings['kb_views'] || $hesk_settings['kb_rating']): ?>
                                    <div class="rate">
                                        <?php if ($hesk_settings['kb_views']): ?>
                                            <div style="margin-right: 10px; display: -ms-flexbox; display: flex;">
                                                <svg class="icon icon-eye-close">
                                                    <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-eye-close"></use>
                                                </svg>
                                                <span class="lightgrey"><?php echo $article['views_formatted']; ?></span>
                                            </div>
                                        <?php
                                        endif;
                                        if ($hesk_settings['kb_rating']): ?>
                                            <?php echo hesk3_get_customer_rating($article['rating']); ?>
                                            <?php if ($hesk_settings['kb_views']) echo '<span class="lightgrey">('.$article['votes_formatted'].')</span>'; ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <!--[if IE]>
                                <p>&nbsp;</p>
                            <![endif]-->
                            <?php endforeach; ?>
                        </div>
                        <?php
                        endif;
                        if (count($latest_articles) > 0):
                        ?>
                        <div class="tabbed__tabs_tab <?php echo count($top_articles) === 0 ? 'is-visible' : ''; ?>" data-tab="tab2">
                            <?php foreach ($latest_articles as $article): ?>
                                <a href="knowledgebase.php?article=<?php echo $article['id']; ?>" class="preview">
                                    <div class="icon-in-circle">
                                        <svg class="icon icon-knowledge">
                                            <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-knowledge"></use>
                                        </svg>
                                    </div>
                                    <div class="preview__text">
                                        <h5 class="preview__title"><?php echo $article['subject'] ?></h5>
                                        <p>
                                            <span class="lightgrey"><?php echo $hesklang['kb_cat']; ?>:</span>
                                            <span class="ml-1"><?php echo $article['category']; ?></span>
                                        </p>
                                        <p class="navlink__descr">
                                            <?php echo $article['content_preview']; ?>
                                        </p>
                                    </div>
                                    <?php if ($hesk_settings['kb_views'] || $hesk_settings['kb_rating']): ?>
                                        <div class="rate">
                                            <?php if ($hesk_settings['kb_views']): ?>
                                                <div style="margin-right: 10px; display: -ms-flexbox; display: flex;">
                                                    <svg class="icon icon-eye-close">
                                                        <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-eye-close"></use>
                                                    </svg>
                                                    <span class="lightgrey"><?php echo $article['views_formatted']; ?></span>
                                                </div>
                                            <?php
                                            endif;
                                            if ($hesk_settings['kb_rating']): ?>
                                                <?php echo hesk3_get_customer_rating($article['rating']); ?>
                                                <?php if ($hesk_settings['kb_views']) echo '<span class="lightgrey">('.$article['votes_formatted'].')</span>'; ?>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </a>
                                <!--[if IE]>
                                    <p>&nbsp;</p>
                                <![endif]-->
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <!-- div class="article__footer">
                        <a href="knowledgebase.php" class="btn btn--blue-border" ripple="ripple">< ?php echo $hesklang['viewkb']; ?></a>
                    </div -->
                </article>
                <?php
                endif;
                if ($hesk_settings['alink']):
                ?>
                <div class="article__footer">
                    <a href="<?php echo $hesk_settings['admin_dir']; ?>/" class="link"><?php echo $hesklang['ap']; ?></a>
                </div>
                <?php endif; ?>
            </div>
        </div>
<?php
/*******************************************************************************
The code below handles HESK licensing and must be included in the template.

Removing this code is a direct violation of the HESK End User License Agreement,
will void all support and may result in unexpected behavior.

To purchase a HESK license and support future HESK development please visit:
https://www.hesk.com/buy.php
*******************************************************************************/
$hesk_settings['hesk_license']('Qo8Zm9vdGVyIGNsYXNzPSJmb290ZXIiPg0KICAgIDxwIGNsY
XNzPSJ0ZXh0LWNlbnRlciI+UG93ZXJlZCBieSA8YSBocmVmPSJodHRwczovL3d3dy5oZXNrLmNvbSIgY
2xhc3M9ImxpbmsiPkhlbHAgRGVzayBTb2Z0d2FyZTwvYT4gPHNwYW4gY2xhc3M9ImZvbnQtd2VpZ2h0L
WJvbGQiPkhFU0s8L3NwYW4+PGJyPk1vcmUgSVQgZmlyZXBvd2VyPyBUcnkgPGEgaHJlZj0iaHR0cHM6L
y93d3cuc3lzYWlkLmNvbS8/dXRtX3NvdXJjZT1IZXNrJmFtcDt1dG1fbWVkaXVtPWNwYyZhbXA7dXRtX
2NhbXBhaWduPUhlc2tQcm9kdWN0X1RvX0hQIiBjbGFzcz0ibGluayI+U3lzQWlkPC9hPjwvcD4NCjwvZ
m9vdGVyPg0K',"\104", "a809404e0adf9823405ee0b536e5701fb7d3c969");
/*******************************************************************************
END LICENSE CODE
*******************************************************************************/
?>
    </main>
</div>
<?php include(TEMPLATE_PATH . '../../footer.txt'); ?>
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/jquery-3.5.1.min.js"></script>
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/hesk_functions.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
<?php outputSearchJavascript(); ?>
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/svg4everybody.min.js"></script>
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/selectize.min.js"></script>
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>


<!-- Ikon Chatbot -->
<div id="chatbot-icon">
    <i class="fa fa-comments" style="font-size:30px;"></i>
</div>

<!-- Pop-up Awal -->
<div id="initial-popup" class="chatbot-popup">
    <div class="content">
        <div class="modal__close" id="initial-close-btn">
            <svg class="icon icon-close">
                <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-close"></use>
            </svg>
        </div>
        <img src="img/AdunKu.png">
        <h2>Tanya AdunKu!</h2>
        <p class="adunku-greet">Butuh informasi seputar ketatausahaan di BPS Aceh?</p>
        <p class="adunku-greet">AdunKu siap membantu Anda!</p>
        <button id="start-btn">Mulai</button>
    </div>
</div>

<!-- Pop-up Chat Utama -->
<div id="chatbot-container" class="chatbot-popup">
    <div id="chatbot-header">
        <span>AdunKu</span>
        <button id="chatbot-close-btn">&times;</button>
    </div>
    <div id="chatbot-body">
    </div>
    <div id="chatbot-input">
        <input type="text" id="user-input" placeholder="Ketik pesan Anda...">
        <button id="send-btn">Kirim</button>
    </div>
</div>

<!-- Logika Chatbot -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const chatbotIcon = document.getElementById('chatbot-icon');
        const initialPopup = document.getElementById('initial-popup');
        const startBtn = document.getElementById('start-btn');
        const chatbotContainer = document.getElementById('chatbot-container');
        const chatbotCloseBtn = document.getElementById('chatbot-close-btn');
        const initialCloseBtn = document.getElementById('initial-close-btn');
        const userInput = document.getElementById('user-input');
        const sendBtn = document.getElementById('send-btn');
        const chatbotBody = document.getElementById('chatbot-body');

        let hasGreeted = false;

        initialPopup.style.display = 'none';
        chatbotContainer.style.display = 'none';
        chatbotIcon.style.display = 'flex';

        function addMessage(sender, message) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `chat-message ${sender}-message`;
            messageDiv.textContent = message;
            chatbotBody.appendChild(messageDiv);
            chatbotBody.scrollTop = chatbotBody.scrollHeight;
        }

        function openInitialPopup() {
            initialPopup.style.display = 'flex';
            chatbotIcon.style.display = 'none';
            document.body.classList.add('modal-open');
        }

        function openChatbot() {
            initialPopup.style.display = 'none';
            chatbotContainer.style.display = 'flex';
            document.body.classList.add('modal-open');
            if (!hasGreeted) {
                addMessage('bot', 'Saleum! Ada yang bisa Adun bantu?');
                hasGreeted = true;
            }
        }

        function closeChatbot() {
            chatbotContainer.style.display = 'none';
            initialPopup.style.display = 'none';
            chatbotIcon.style.display = 'flex';
            document.body.classList.remove('modal-open');
        }

        chatbotIcon.addEventListener('click', openInitialPopup);
        startBtn.addEventListener('click', openChatbot);
        chatbotCloseBtn.addEventListener('click', closeChatbot);
        initialCloseBtn.addEventListener('click', closeChatbot);

        sendBtn.addEventListener('click', sendMessage);
        userInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        function sendMessage() {
            const message = userInput.value.trim();
            if (message === '') return;
            
            addMessage('user', message);
            userInput.value = '';
            
            const n8nWebhookUrl = 'https://cutindahrai.app.n8n.cloud/webhook/a4cacacb-0589-4efa-bf5b-74aa2276805e';

            // Kirim pesan ke n8n
            fetch(n8nWebhookUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    message: message
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Jaringan bermasalah atau server n8n tidak merespons');
                }
                return response.json();
            })
            .then(data => {
                // Menampilkan respons dari n8n
                const botResponse = data.response.text;
                addMessage('bot', botResponse);
            })
            .catch(error => {
                console.error('Error saat mengirim ke n8n:', error);
                addMessage('bot', 'Maaf, terjadi kesalahan saat menghubungi server chatbot. Silakan coba lagi nanti.');
            });
        }
    });
</script>
</body>

</html>
