<?php
/**
 * Plugin Name: Fitmedica - Weryfikacja Medyczna
 * Description: Badge "Zweryfikowano medycznie" pod artykułami blogowymi z wyborem lekarza weryfikującego.
 * Version: 1.0
 * Author: NETIM
 */

if (!defined('ABSPATH')) exit;

/* -----------------------------------------------
   AUTO-SETUP - jednorazowe przypisanie lekarza
   do 2 pierwszych postow. Uruchamia sie raz.
   ----------------------------------------------- */

add_action('init', function () {
    if (get_option('fitmedica_mv_setup_v2')) return;

    $posts_to_setup = [
        'zapalenie-rozciegna-podeszwowego-stopy-przyczyny-objawy-i-leczenie' => 'maciej-langner',
        'stenoza-kanalu-kregowego-przyczyny-objawy-i-leczenie'               => 'maciej-langner',
    ];

    foreach ($posts_to_setup as $post_slug => $doctor_slug) {
        $q = new WP_Query([
            'name'           => $post_slug,
            'post_type'      => 'post',
            'posts_per_page' => 1,
            'fields'         => 'ids',
            'no_found_rows'  => true,
        ]);
        if (!empty($q->posts)) {
            update_post_meta($q->posts[0], '_medical_reviewer', $doctor_slug);
            update_post_meta($q->posts[0], '_medical_review_date', '2026-05');
        }
        wp_reset_postdata();
    }

    update_option('fitmedica_mv_setup_v2', true);
});

/**
 * Dane lekarzy - dodaj nowych lekarzy tutaj.
 */
function fitmedica_get_doctors() {
    return [
        'maciej-langner' => [
            'name'      => 'lek. Maciej Langner',
            'specialty' => 'Ortopedia i traumatologia',
            'photo'     => '/wp-content/uploads/2020/05/lek-maciej-langner-230-230.jpg',
            'profile'   => '/zespol/dr-maciej-langner/',
            'bio'       => 'Jeden z pionierow chirurgii artroskopowej w Polsce. Konsultant w Klinice Chirurgii Urazowej i Ortopedii CMKP w Otwocku. Specjalizuje sie w operacyjnym leczeniu stawu kolanowego.',
        ],
        'michal-saganek' => [
            'name'      => 'lek. Michał Saganek',
            'specialty' => 'Ortopedia sportowa',
            'photo'     => '/wp-content/uploads/2025/12/freepik-2026030612050414B8.jpeg',
            'profile'   => '/zespol/',
            'bio'       => '',
        ],
    ];
}

/* -----------------------------------------------
   META BOX - dropdown w edytorze posta
   ----------------------------------------------- */

add_action('add_meta_boxes', function () {
    add_meta_box(
        'fitmedica_medical_reviewer',
        'Weryfikacja medyczna',
        'fitmedica_reviewer_meta_box_html',
        'post',
        'side',
        'high'
    );
});

function fitmedica_reviewer_meta_box_html($post) {
    wp_nonce_field('fitmedica_reviewer_save', '_fitmedica_nonce');

    $current_doc  = get_post_meta($post->ID, '_medical_reviewer', true);
    $current_date = get_post_meta($post->ID, '_medical_review_date', true);
    $doctors      = fitmedica_get_doctors();

    echo '<p><label for="medical_reviewer"><strong>Lekarz weryfikujacy:</strong></label></p>';
    echo '<select id="medical_reviewer" name="medical_reviewer" style="width:100%">';
    echo '<option value="">- brak -</option>';
    foreach ($doctors as $slug => $doc) {
        $sel = selected($current_doc, $slug, false);
        echo '<option value="' . esc_attr($slug) . '"' . $sel . '>' . esc_html($doc['name']) . '</option>';
    }
    echo '</select>';

    echo '<p style="margin-top:10px"><label for="medical_review_date"><strong>Data weryfikacji (YYYY-MM):</strong></label></p>';
    echo '<input type="month" id="medical_review_date" name="medical_review_date" '
       . 'value="' . esc_attr($current_date) . '" style="width:100%">';
}

add_action('save_post', function ($post_id) {
    if (!isset($_POST['_fitmedica_nonce'])) return;
    if (!wp_verify_nonce($_POST['_fitmedica_nonce'], 'fitmedica_reviewer_save')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $reviewer = sanitize_text_field($_POST['medical_reviewer'] ?? '');
    $date     = sanitize_text_field($_POST['medical_review_date'] ?? '');

    update_post_meta($post_id, '_medical_reviewer', $reviewer);
    update_post_meta($post_id, '_medical_review_date', $date);
});

/* -----------------------------------------------
   FRONT - badge pod trescia artykulu
   ----------------------------------------------- */

add_filter('the_content', function ($content) {
    if (!is_singular('post') || !in_the_loop() || !is_main_query()) {
        return $content;
    }

    $slug = get_post_meta(get_the_ID(), '_medical_reviewer', true);
    if (empty($slug)) return $content;

    $doctors = fitmedica_get_doctors();
    if (!isset($doctors[$slug])) return $content;

    $doc      = $doctors[$slug];
    $date_raw = get_post_meta(get_the_ID(), '_medical_review_date', true);

    // YYYY-MM -> "V 2026"
    $roman = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
    if ($date_raw && preg_match('/^(\d{4})-(\d{2})$/', $date_raw, $m)) {
        $date_display = $roman[(int)$m[2] - 1] . ' ' . $m[1];
    } else {
        $date_display = $roman[(int)date('n') - 1] . ' ' . date('Y');
    }

    $photo   = esc_url(home_url($doc['photo']));
    $profile = esc_url(home_url($doc['profile']));
    $name    = esc_html($doc['name']);
    $spec    = esc_html($doc['specialty']);
    $bio     = esc_html($doc['bio'] ?? '');

    $bio_html = $bio ? "\n        <div class=\"mv-bio\">{$bio}</div>" : '';

    $badge = <<<HTML
<div class="medical-verification">
    <a href="{$profile}" class="mv-photo-link">
        <img src="{$photo}" alt="{$name}" class="mv-photo" width="96" height="96" loading="lazy">
    </a>
    <div class="mv-content">
        <div class="mv-badge">
            <svg viewBox="0 0 24 24" width="14" height="14"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z" fill="currentColor"/></svg>
            Zweryfikowano medycznie
        </div>
        <a href="{$profile}" class="mv-name">{$name}</a>
        <div class="mv-spec">{$spec} &middot; Weryfikacja: {$date_display}</div>{$bio_html}
    </div>
</div>
HTML;

    return $content . $badge;
}, 20);

/* -----------------------------------------------
   CSS
   ----------------------------------------------- */

add_action('wp_footer', function () {
    if (!is_singular('post')) return;
    ?>
<style>
/* --- Weryfikacja medyczna --- */
.medical-verification{margin:32px 0 0;padding:26px 30px;background:linear-gradient(135deg,#f7f9fc 0%,#eef3fb 100%);border-radius:12px;border:1px solid #dce4f0;display:flex;align-items:center;gap:22px;box-shadow:0 2px 12px rgba(57,110,235,.06)}
.medical-verification .mv-photo{width:96px;height:96px;min-width:96px;border-radius:50%;object-fit:cover;border:3px solid #fff;box-shadow:0 3px 12px rgba(57,110,235,.15)}
.medical-verification .mv-content{display:flex;flex-direction:column;gap:2px}
.medical-verification .mv-badge{display:inline-flex;align-items:center;gap:6px;font-size:11.5px;text-transform:uppercase;letter-spacing:.6px;color:#2a8636;font-weight:600;background:#e8f5e9;padding:4px 12px;border-radius:20px;width:fit-content;margin-bottom:5px}
.medical-verification .mv-badge svg{fill:#2a8636}
.medical-verification .mv-photo-link{flex-shrink:0}
a.mv-name{font-family:'Raleway',sans-serif;font-size:18px;font-weight:700;color:#1a1f36;text-decoration:none}
a.mv-name:hover{color:#396eeb}
.medical-verification .mv-spec{font-size:13.5px;color:#64748b;font-weight:500}
.medical-verification .mv-bio{font-size:13.5px;color:#4a5568;line-height:1.55;margin-top:4px}
@media(max-width:480px){.medical-verification{flex-direction:column;text-align:center;gap:14px;padding:22px}.medical-verification .mv-photo{width:80px;height:80px;min-width:80px}.medical-verification .mv-badge{margin:0 auto 4px}}
/* --- FAQ kompaktowe --- */
.faq-container.netim{margin:24px 0 !important}
.faq-container.netim .faq-heading{font-size:22px !important;margin:0 0 4px 0 !important}
.faq-container.netim .faq-subheading{font-size:14px !important;margin:0 0 16px 0 !important}
.faq-container.netim .faq-accordion{gap:6px !important}
.faq-container.netim .faq-item{border-radius:8px !important}
.faq-container.netim .faq-question{padding:14px 48px 14px 20px !important;font-size:14.5px !important}
.faq-container.netim .faq-question::after{width:24px !important;height:24px !important;font-size:16px !important;right:16px !important}
.faq-container.netim .faq-answer>div{padding:0 20px 16px 20px !important;padding-top:14px !important}
.faq-container.netim .faq-accordion .faq-item:nth-child(n+7){display:none !important}
</style>
    <?php
});

/* -----------------------------------------------
   Schema.org - MedicalWebPage + Physician
   ----------------------------------------------- */

add_action('wp_head', function () {
    if (!is_singular('post')) return;

    global $post;
    $slug = get_post_meta($post->ID, '_medical_reviewer', true);
    if (empty($slug)) return;

    $doctors = fitmedica_get_doctors();
    if (!isset($doctors[$slug])) return;

    $doc      = $doctors[$slug];
    $date_raw = get_post_meta($post->ID, '_medical_review_date', true);

    $schema = [
        '@context'   => 'https://schema.org',
        '@type'      => 'MedicalWebPage',
        'lastReviewed' => $date_raw ?: date('Y-m'),
        'reviewedBy' => [
            '@type'            => 'Physician',
            'name'             => $doc['name'],
            'medicalSpecialty' => $doc['specialty'],
            'image'            => home_url($doc['photo']),
            'url'              => home_url($doc['profile']),
        ],
    ];

    echo '<script type="application/ld+json">'
       . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
       . "</script>\n";
});
