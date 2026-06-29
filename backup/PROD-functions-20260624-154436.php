<?php
/**
 * Mediplus child theme functions and definitions.
 *
 * Add your custom PHP in this file. 
 * Only edit this file if you have direct access to it on your server (to fix errors if they happen).
 */

add_action( 'wp_enqueue_scripts', 'medilink_child_styles', 18 );
function medilink_child_styles() {
	wp_enqueue_style( 'medilink-child-style', get_stylesheet_uri() );
}
// Custom firlds for medik
function medilink_doctor_enqueue_scripts($hook) {
    global $post;

    if ($hook == 'post.php' || $hook == 'post-new.php') { 
        if (isset($post) && $post->post_type == 'medilink_doctor') { 
            wp_enqueue_media();
            wp_enqueue_script('medilink-doctor-admin-script', get_template_directory_uri() . '/assets/js/admin.js', array('jquery'), null, true);
        }
    }
}
add_action('admin_enqueue_scripts', 'medilink_doctor_enqueue_scripts');

// Dodaj metabox dla niestandardowych pól
function medilink_doctor_custom_fields() {
    add_meta_box(
        'medilink_doctor_images',
        'Zdjęcia lekarza',
        'medilink_doctor_images_callback',
        'medilink_doctor',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'medilink_doctor_custom_fields');

// Wyświetl zawartość metaboxów
function medilink_doctor_images_callback($post) {
    wp_nonce_field('medilink_doctor_save_images', 'medilink_doctor_images_nonce');

    // Pierwsze pole
    $image1 = get_post_meta($post->ID, '_medilink_doctor_image1', true);
    echo '<div style="display:flex;justify-content: space-around;flex-wrap: wrap;flex-direction:row;"><div style="width: min(100%, 700px);border: 2px dashed #c3c4c7;margin: 30px auto;padding: 20px;">';
    echo '<label style="display:block;margin-inline:auto;padding: 10px;width:90%;text-align:center;font-size: 25px;font-weight: 600;" for="medilink_doctor_image1">Zdjęcie na stronie poświęconej danej osobie:</label>';
    echo '<p style="display:block;margin: 2px auto;padding: 10px;width:90%;text-align:center;font-size: 15px;color: #c3c4c7;font-weight:400;">213px x 420px</p>';
    echo '<input style="display:block;;padding: 2px;width:90%;text-align:center;margin:10px auto;font-size:12px;" type="text" id="medilink_doctor_image1" name="medilink_doctor_image1" value="' . esc_attr($image1) . '" style="display:none;"/>';
    echo '<input style="display:block;margin-inline:auto;padding: 10px;width:90%;" type="button" class="button upload_image_button" value="Wgraj zdjęcie" />';
    echo '<img style="display:block;max-width: 300px;height:auto; padding: 20px;margin:0 auto;" src="' . esc_attr($image1) . '" style="display:block;max-width: 300px;height:auto; padding: 20px;">';
    echo '</div>';


    // Drugie pole
    $image2 = get_post_meta($post->ID, '_medilink_doctor_image2', true);
    echo '<div style="width: min(100%, 700px);border: 2px dashed #c3c4c7;margin: 30px auto;padding: 20px;">';
    echo '<label style="display:block;margin-inline:auto;padding: 10px;width:90%;text-align:center;font-size: 25px;font-weight: 600;" for="medilink_doctor_image2">Zdjęcie na stronie zespoł:</label>';
    echo '<p style="display:block;margin: 2px auto;padding: 10px;width:90%;text-align:center;font-size: 15px;color: #c3c4c7;font-weight:400;">230px x 230px</p>';
    echo '<input style="display:block;;padding: 2px;width:90%;text-align:center;margin:10px auto;font-size:12px;" type="text" id="medilink_doctor_image2" name="medilink_doctor_image2" value="' . esc_attr($image2) . '"  />';
    echo '<input style="display:block;margin-inline:auto;padding: 10px;width:90%;" type="button" class="button upload_image_button" value="Wgraj zdjęcie" />';
    echo '<img  style="display:block;max-width: 300px;height:auto; padding: 20px;margin:0 auto;" src="' . esc_attr($image2) . '" style="display:block;max-width: 300px;height:auto; padding: 20px;">';
    echo '</div></div>';
}

// Zapisz dane metaboxów
function medilink_doctor_save_images($post_id) {
    if (!isset($_POST['medilink_doctor_images_nonce']) ||
        !wp_verify_nonce($_POST['medilink_doctor_images_nonce'], 'medilink_doctor_save_images')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['medilink_doctor_image1'])) {
        update_post_meta($post_id, '_medilink_doctor_image1', sanitize_text_field($_POST['medilink_doctor_image1']));
    }

    if (isset($_POST['medilink_doctor_image2'])) {
        update_post_meta($post_id, '_medilink_doctor_image2', sanitize_text_field($_POST['medilink_doctor_image2']));
    }
}
add_action('save_post', 'medilink_doctor_save_images');


//wyłączenie aktualizacji wtyczek
remove_action( 'load-update-core.php', 'wp_update_plugins' );
add_filter( 'pre_site_transient_update_plugins', function( $a ) {
    return null;
} );

add_action('wp_print_scripts', function () {
	global $post;
	if ( is_a( $post, 'WP_Post' ) && !has_shortcode( $post->post_content, 'contact-form-7') ) {
		wp_dequeue_script( 'google-recaptcha' );
		wp_dequeue_script( 'wpcf7-recaptcha' );
	}
});

add_action('init', 'use_jquery_from_google');

function use_jquery_from_google () {
	if (is_admin()) {
		return;
	}

	global $wp_scripts;
	if (isset($wp_scripts->registered['jquery']->ver)) {
		$ver = $wp_scripts->registered['jquery']->ver;
                $ver = str_replace("-wp", "", $ver);
	} else {
		$ver = '1.12.4';
	}

	wp_deregister_script('jquery');
	wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/$ver/jquery.min.js", false, $ver);
}

add_action('wp_footer', 'remove_element_script');
function remove_element_script() {
    ?>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Lista docelowych URL
            var targetURLs = [
                'https://www.fitmedica.pl/oferta/fizjoterapeuta-sportowy/',
                'https://www.fitmedica.pl/oferta/dobry-chirurg-ortopeda-warszawa/',
                'https://www.fitmedica.pl/oferta/neurochirurg/',
                'https://www.fitmedica.pl/oferta/medycyna-sportowa/',
                'https://www.fitmedica.pl/oferta/dobry-kardiolog-warszawa-prywatnie/',
                'https://www.fitmedica.pl/oferta/dobry-reumatolog-prywatnie/',
                'https://www.fitmedica.pl/oferta/dobry-neurolog/',
                'https://www.fitmedica.pl/oferta/dobry-dietetyk-warszawa/',
                'https://www.fitmedica.pl/oferta/usg/'
            ];


            if (targetURLs.includes(window.location.href)) {
                // Znajdź element i usuń go
                var element = document.querySelector('.sidebar-widget-area.sidebar-break-md.col-xl-3.col-lg-4.col-12.no-equal-item.niewidoczny-div');
                if (element) {
                    element.remove();
                }
            }
        });
    </script>
    <?php
}


add_action('wp_footer', function () {
	?>
	<script>
	document.addEventListener('DOMContentLoaded', function () {
		const bar = document.getElementById('holiday-bar');
		const closeBtn = document.getElementById('holiday-bar-close');
		const toggleBtn = document.getElementById('holiday-bar-toggle');

		if (!bar || !closeBtn || !toggleBtn) return;

		const STORAGE_KEY = 'fitmedicaHolidayBarClosed';

		if (localStorage.getItem(STORAGE_KEY) === 'true') {
			bar.style.display = 'none';
			toggleBtn.style.display = 'block';
		}

		closeBtn.addEventListener('click', function () {
			bar.style.display = 'none';
			toggleBtn.style.display = 'block';
			localStorage.setItem(STORAGE_KEY, 'true');
		});

		toggleBtn.addEventListener('click', function () {
			bar.style.display = 'block';
			toggleBtn.style.display = 'none';
			localStorage.removeItem(STORAGE_KEY);
		});
	});
	</script>
	<?php
}, 100);



/**
 * NETIM AI Bot Tracker
 * Wysyła hity botów AI do GEO trackera
 */

add_action('init', 'netim_ai_bot_tracker');

function netim_ai_bot_tracker() {
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';

    $bots = '/GPTBot|OAI-SearchBot|ChatGPT-User|ClaudeBot|Claude-SearchBot|Claude-User|PerplexityBot|Perplexity-User|Google-Extended|Applebot-Extended|Amazonbot|Bytespider|CCBot|meta-externalagent/i';

    if (!preg_match($bots, $ua)) {
        return;
    }

    wp_remote_post('https://llm-geo-tracker.vercel.app/api/agent-hit', [
        'timeout'  => 2,
        'blocking' => false,
        'headers'  => [
            'Content-Type' => 'application/json',
        ],
        'body' => wp_json_encode([
            'client_token' => 'fitmedica',
            'url'          => $_SERVER['REQUEST_URI'] ?? '/',
            'user_agent'   => $ua,
            'ip'           => $_SERVER['REMOTE_ADDR'] ?? '',
            'status'       => http_response_code() ?: 200,
        ]),
    ]);
}

/**
 * NETIM AI Traffic Tracker
 * Wstrzykuje tracking przed </body>
 */

add_action('wp_footer', 'netim_ai_traffic_tracker', 999);

function netim_ai_traffic_tracker() {
    ?>
    <script>
    (function () {
        try {
            var d = document;
            var ref = d.referrer || '';
            var url = location.pathname + location.search + location.hash;
            var params = new URLSearchParams(location.search);
            var utm = params.get('utm_source') || '';

            // AI source detection
            var sources = [
                [/chatgpt|openai/i, 'chatgpt'],
                [/perplexity/i, 'perplexity'],
                [/claude|anthropic/i, 'claude'],
                [/gemini|bard|google\.ai/i, 'gemini'],
                [/copilot|bing\.com\/chat/i, 'copilot'],
                [/meta\.ai/i, 'meta-ai']
            ];

            var ai = null;
            var conf = null;

            if (utm) {
                for (var i = 0; i < sources.length; i++) {
                    if (sources[i][0].test(utm)) {
                        ai = sources[i][1];
                        conf = 'confident';
                        break;
                    }
                }
            }

            if (!ai && ref) {
                for (var j = 0; j < sources.length; j++) {
                    if (sources[j][0].test(ref)) {
                        ai = sources[j][1];
                        conf = 'confident';
                        break;
                    }
                }
            }

            // nie wysyłamy non-AI traffic
            if (!ai) {
                return;
            }

            // Session ID
            var sid = sessionStorage.getItem('netim_sid');

            if (!sid) {
                sid = Date.now().toString(36) + Math.random().toString(36).slice(2, 8);
                sessionStorage.setItem('netim_sid', sid);
            }

            fetch('https://llm-geo-tracker.vercel.app/api/track-visit', {
                method: 'POST',
                keepalive: true,
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    client_token: 'fitmedica',
                    url: url,
                    referrer: ref,
                    utm_source: utm,
                    ai_source: ai,
                    confidence: conf,
                    session_id: sid,
                    user_agent: navigator.userAgent
                })
            }).catch(function () {
                // fail silent
            });

        } catch (e) {
            // fail silent
        }
    })();
    </script>
    <?php
}

/* ============================================================
   FITMEDICA: link zwrotny artykul -> poradnia (domkniecie clustera SEO)
   Neutralny CTA konsultacji na koncu wpisu. Cel = ogolna poradnia per specjalizacja,
   dobierana po kategorii wpisu (kolejnosc $fm_cta_map = priorytet gdy wpis ma kilka kategorii).
   ============================================================ */
add_filter( 'the_content', function ( $content ) {
    if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
        return $content;
    }

    // slug kategorii bloga -> [nazwa poradni w CTA, sciezka poradni]
    $fm_cta_map = array(
        'kardiologia'               => array( 'Poradni Kardiologicznej',  '/oferta/dobry-kardiolog-warszawa-prywatnie/' ),
        'nadcisnienie'              => array( 'Poradni Kardiologicznej',  '/oferta/dobry-kardiolog-warszawa-prywatnie/' ),
        'ortopedia'                 => array( 'Poradni Ortopedycznej',    '/oferta/dobry-chirurg-ortopeda-warszawa/' ),
        'neurologia'                => array( 'Poradni Neurologicznej',   '/oferta/dobry-neurolog/' ),
        'reumatologia'              => array( 'Poradni Reumatologicznej', '/oferta/dobry-reumatolog-prywatnie/' ),
        'fizjoterapia'              => array( 'Poradni Rehabilitacji',    '/oferta/dobry-fizjoterapeuta-warszawa/' ),
        'dietetyka'                 => array( 'Poradni Dietetycznej',     '/oferta/dobry-dietetyk-warszawa/' ),
        'dermatologia'              => array( 'Poradni Dermatologicznej', '/oferta/poradnia-dermatologiczna/' ),
        'psychologia-i-psychiatria' => array( 'Poradni Psychologicznej',  '/oferta/poradnia-psychologiczna/' ),
        'badania-usg'               => array( 'Pracowni USG',            '/oferta/usg/' ),
    );

    $post_cats = wp_list_pluck( get_the_category(), 'slug' );
    $fm_cta    = null;
    foreach ( $fm_cta_map as $slug => $data ) {
        if ( in_array( $slug, $post_cats, true ) ) { $fm_cta = $data; break; }
    }
    if ( ! $fm_cta ) {
        return $content; // brak pasujacej specjalizacji -> bez CTA
    }

    $name = esc_html( $fm_cta[0] );
    $url  = esc_url( home_url( $fm_cta[1] ) );

    $cta  = '<style>.fm-cta{margin:36px 0 8px;padding:24px 26px;background:#f4f7fe;border-radius:12px;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:18px;}'
          . '.fm-cta-txt{flex:1 1 240px;}'
          . '.fm-cta-txt b{display:block;font-family:Raleway,sans-serif;font-weight:700;font-size:18px;line-height:1.3;color:#16181d;margin-bottom:5px;}'
          . '.fm-cta-txt span{font-family:Roboto,sans-serif;font-size:14px;line-height:1.5;color:#5b6472;}'
          . '.fm-cta a.fm-cta-btn{flex:0 0 auto;display:inline-flex;align-items:center;gap:8px;background:#396cf0;color:#fff;font-family:Roboto,sans-serif;font-weight:600;font-size:14px;text-decoration:none;padding:13px 22px;border-radius:8px;transition:background-color .2s ease,transform .15s ease;}'
          . '.fm-cta a.fm-cta-btn svg{width:16px;height:16px;}'
          . '@media(hover:hover) and (pointer:fine){.fm-cta a.fm-cta-btn:hover{background:#2b56c8;}}'
          . '.fm-cta a.fm-cta-btn:active{transform:scale(.97);}</style>';
    $cta .= '<div class="fm-cta"><span class="fm-cta-txt"><b>Potrzebujesz konsultacji?</b>'
          . '<span>Umów wizytę w ' . $name . ' Fitmedica i skonsultuj swój przypadek z lekarzem.</span></span>'
          . '<a class="fm-cta-btn" href="' . $url . '">Umów wizytę '
          . '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a></div>';

    return $content . $cta;
}, 99 );