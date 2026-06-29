<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
namespace radiustheme\Medilink;
use radiustheme\medilink\Helper;
use \WP_Query;
$medilink  = MEDILINK_THEME_PREFIX;
$cpt     = MEDILINK_THEME_CPT_PREFIX;     
wp_enqueue_script( 'imagesloaded' );
wp_enqueue_script( 'isotope-pkgd' );
$departments                = Helper::get_departments();  
$_our_pricing_plan_title    = get_post_meta( $id, "{$cpt}_our_pricing_plan_title", true );
$_department_services       = get_post_meta( $id, "{$cpt}_department_services", true );
$_doctors                   = get_post_meta( $id, "{$cpt}_doctor", true );
$_emergency_cases           = get_post_meta( $id, "{$cpt}_emergency_cases", true );   
$_opening_hour              = get_post_meta( $id, "{$cpt}_opening_hour", true );
$doctors                    = Helper::get_departments_doctor($_doctors);   
?>

<?php
// Działa tylko dla konkretnej poradni: Ortopeda nadgarstka i dłoni Warszawa Wawer
if ( is_singular('medilink_departments') && get_post_field('post_name', get_the_ID()) === 'ortopeda-nadgarstka-i-dloni-warszawa-wawer' ) {

    $order_map = array(
        5963,   // lek. Krzysztof Bajszczak
        14011,  // lek. Katarzyna Białecka
        5956,   // lek. Rafał Garlewicz
        12981,  // lek. Maciej Liszka
        13654,  // lek. Kamila Malesa
    );

    // Sortujemy lekarzy tylko dla tej poradni
    usort($doctors, function($a, $b) use ($order_map) {
        $a_pos = array_search($a->ID, $order_map);
        $b_pos = array_search($b->ID, $order_map);
        $a_pos = $a_pos === false ? PHP_INT_MAX : $a_pos;
        $b_pos = $b_pos === false ? PHP_INT_MAX : $b_pos;
        return $a_pos - $b_pos;
    });
}
?>


<div class="sidebar-widget-area sidebar-break-md col-xl-3 col-lg-4 col-12 no-equal-item niewidoczny-div"></div>        
<div class="col-xl-9 col-lg-8 col-12 no-equal-item">         
    <div class="single-departments-box-layout1 sigle-department-data ">
    <div class="sigle-department-data">
        <div class="item-content">
            <div class="item-content-wrap">
                <?php the_content();?>
            </div>

            <?php if(!empty($_department_services)){ ?> 
                <div class="row">
                    <div class="col-12">
                        <div class="item-cost">
                            <h3 class="item-title title-bar-primary7"><?php echo esc_html($_our_pricing_plan_title); ?></h3>
                            <ul>
                                <?php foreach ($_department_services as $services) {  ?> 
                                    <li><?php echo esc_html($services['services_name']); ?><span><?php echo esc_html($services['services_price']); ?></span></li>                                 
                                <?php } ?>                               
                            </ul>
                            <div class="info-pod-cennikiem">
                                <p>* Oferta oraz podane ceny mają wyłącznie charakter informacyjny i nie stanowią oferty handlowej w rozumieniu Art. 66. § 1. Kodeksu Prawa Cywilnego. Przychodnia zastrzega sobie prawo do zmiany cen i usług zamieszczonych na niniejszej stronie</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if(!empty($_doctors)){ ?>  
                <div class="item-specialist-wrap">
                    <h2 class="item-title title-bar-primary7">
                        <?php 
                        $clinic_name = get_the_title(); // nazwa strony/poradni
                        echo esc_html__( 'Poznaj specjalistów', 'medilink' ) . ' – ' . esc_html( $clinic_name );
                        ?>
                    </h2>
                </div>    

                <div class="row"> 
                    <?php foreach ( $doctors as $doctor ):
                        $thumb_size   = "{$medilink}-size5";
                        $did          = $doctor->ID;
                        $_designation = get_post_meta( $did, "{$cpt}_designation", true );
                        $_degree      = get_post_meta( $did, "{$cpt}_degree", true );       
                        $_about       = get_post_meta( $did, 'medilink_doctor_about', true ); 
                        $img          = get_the_post_thumbnail_url( $did, $thumb_size );  
                    ?>                 
                        <div class="col-xl-6 col-lg-12 col-12">
                            <div class="item-specialist layout-2">
                                <div class="media media-none--xs">
                                    <div class="item-img">
                                        <img src="<?php echo esc_url($img);?>" class="img-fluid media-img-auto" alt="<?php echo esc_attr(get_the_title($did));?>">  
                                    </div>
                                    <div class="media-body">
                                        <h3 class="item-title">
                                            <a href="<?php echo get_permalink($did);?>">
                                                <?php echo get_the_title($doctor->ID);?>
                                            </a>
                                        </h3>
                                        <span class="degree"><?php echo esc_html($_degree); ?></span>
                                        <p><?php echo esc_html($_designation); ?></p>

                                        <?php 
                                        if ($_about) {
                                            // usuń &nbsp;, <br> i sprawdź pierwsze słowo
                                            $_about_clean = trim(strip_tags($_about, '<br>'));
                                            $words = preg_split('/\s+/', $_about_clean, -1, PREG_SPLIT_NO_EMPTY);

                                            if (!empty($words) && strcasecmp($words[0], 'Fizjoterapeuta') === 0) {
                                                array_shift($words);
                                                $_about_clean = implode(' ', $words);
                                            }

                                            // przycinamy do 12 słów
                                            $about_trimmed = wp_trim_words(wp_strip_all_tags($_about_clean), 12, '...');
                                            echo '<div class="doctor-about"><p>' . esc_html($about_trimmed) . '</p></div>';
                                        }
                                        ?>

                                        <a href="<?php echo get_permalink($did);?>" class="item-btn">
                                            <?php echo esc_html__( 'Umów wizytę', 'medilink' ); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    <?php endforeach; ?>
                </div>
            <?php } ?>  
        </div> 
    </div>
</div>

    </div>
 <div class="sidebar-widget-area sidebar-break-md col-xl-3 col-lg-4 col-12 no-equal-item">
 <div class="widgets widget-department-info">
    <span class="section-title title-bar-primary">
    <?php echo esc_html__( 'Oferta', 'medilink' ); ?>
</span>

    <ul class="nav tab-nav-list">
    <?php               
        foreach ( $departments as $key => $department ):
            $post_slug = get_post_field('post_name', $key);
            
            // Ukryj te slug'i
            $hidden_slugs = array(
    'ortopeda-kregoslupa-warszawa-wawer',
    'ortopeda-dzieciecy-warszawa-wawer',
    'ortopeda-nadgarstka-i-dloni-warszawa-wawer',
    'rehabilitacja-i-fizjoterapia-warszawa-wawer',
    'ortopeda-falenica',
    'ortopeda-wawer',
    'ortopeda-anin',
    'ortopeda-praga-poludnie',
    'rehabilitacja-i-fizjoterapia-sportowa-praga-poludnie',
    'rehabilitacja-i-fizjoterapia-sportowa-falenica',
    'rehabilitacja-i-fizjoterapia-sportowa-anin',
    'rehabilitacja-i-fizjoterapia-warszawa-wawer',
    'terapia-manualna-warszawa',
    'usg-ortopedyczne-warszawa',
    'fala-uderzeniowa-warszawa',
    'rehabilitacja-sportowa-warszawa',
    'usg-nadgarstka-i-dloni',
    'medycyna-sportowa-dla-dzieci',
    'eho-serca-dziecka',
    'echokardiogram-warszawa',
    'holter-ekg-warszawa',
				'poradnia-kardiologiczna-anin',
				'poradnia-kardiologiczna-praga-poludnie',
'poradnia-kardiologiczna-falenica',
'poradnia-kardiologiczna-wawer',
'dobry-fizjoterapeuta-warszawa',
'neurolog-warszawa-anin',
'neurolog-praga-poludnie',
'neurolog-warszawa-falenica',
'neurolog-warszawa-wawer',
'chirurgia-stopy',
'sonofeedback-warszawa',
'masaz-rehabilitacja-kregoslupa-warszawa',
'masaz-leczniczy-warszawa',
'masaz-sportowy-warszawa',
'medycyna-sportowa',
'medycyna-sportowa-anin',
'medycyna-sportowa-praga-poludnie',
'medycyna-sportowa-wawer',
'usg-lokcia-warszawa',
'ortopeda-mokotow',
'fizykoterapia-warszawa',
'kinesiotaping-warszawa',
'ortopeda-bemowo',
'ortopeda-bialoleka',
'ortopeda-bielany',
'ortopeda-praga-polnoc',
'ortopeda-ursus',
'ortopeda-wlochy',
'ortopeda-wola',
'ortopeda-zoliborz',
'ortopeda-wilanow',
'ortopeda-wesola',
'ortopeda-stare-miasto',
'ortopeda-srodmiescie',
'ortopeda-targowek',
'ortopeda-ochota-poradnia-ortopedyczna-fitmedica-warszawa',
'ortopeda-ursynow',
'ortopeda-rembertow',
    'usg-kolana-warszawa',
);
            
            if (in_array($post_slug, $hidden_slugs)) continue;
// Dodatkowe ukrywanie po ID dla dwóch wpisów, które nie łapią się po slugach
$hidden_ids = array(
    15650, // medycyna sportowa anin
	16238,
	16723,
	16744,
    15149  // usg łokcia warszawa
);

if (in_array($key, $hidden_ids)) continue;
        ?>
            <li class="nav-item departments_info">
                <a href="<?php echo esc_url( get_permalink($key) ); ?>"><?php echo esc_html($department); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
       <?php  if(!empty($_emergency_cases)){ ?>  
        <div class="widgets widget-call-to-action">
            <div class="media">
                   <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/phone2.svg" alt="<?php esc_html_e( 'figure', 'medilink' ); ?>">
                <div class="media-body space-sm">
                    <span><?php echo esc_html__( 'Emergency Cases', 'medilink' ); ?></span>
                    <span><a href="tel:<?php echo esc_html($_emergency_cases); ?>"><?php echo esc_html($_emergency_cases); ?></a></span>
                </div>
            </div>
        </div>
    <?php } ?>
     <?php  if(!empty($_opening_hour)){ ?>                        
        <div class="widgets widget-schedule">
            <p class="section-title title-bar-primary"><?php echo esc_html__( 'Opening Hours', 'medilink' ); ?></p>
                <ul>
                    <?php foreach ($_opening_hour as $opening_hour) {  ?> 
                        <li><?php echo esc_html($opening_hour['hours_label']); ?> <span><?php echo esc_html($opening_hour['hours']); ?></span></li>                                   
                    <?php } ?>                               
                </ul>                    
        </div>
      <?php } ?>

        <?php
        /* ============================================================
           FITMEDICA: powiazane artykuly z bloga (budowa autorytetu = hub poradni)
           PUBLICZNE od 2026-06-19 (klientka zaakceptowala). Bramka podgladu zdjeta.
           Renderuje sie na poradniach kardiologicznych (mapa $fm_map -> zestawy $fm_sets).
           Mapowanie kolejnych poradni: dopisac slug => klucz w $fm_map oraz zestaw w $fm_sets.
           ============================================================ */
        {

            $fm_dep_id   = get_the_ID();
            $fm_dep_slug = get_post_field( 'post_name', $fm_dep_id );

            // slug poradni -> klucz zestawu kuracji
            $fm_map = array(
                'poradnia-kardiologiczna-wawer'          => 'kardiologia',
                'poradnia-kardiologiczna-anin'           => 'kardiologia',
                'poradnia-kardiologiczna-praga-poludnie' => 'kardiologia',
                'poradnia-kardiologiczna-falenica'       => 'kardiologia',
                'dobry-kardiolog-warszawa-prywatnie'     => 'kardiologia',
                'echokardiogram-warszawa'                => 'kardiologia',
                'eho-serca-dziecka'                      => 'kardiologia',
                'holter-ekg-warszawa'                    => 'kardiologia',
                // ortopedia (ogolny ortopeda per dzielnica) - strony body-part-specific (kregoslup/nadgarstek/usg/dzieciecy/stopa) pozniej osobno
                'ortopeda-anin'                          => 'ortopedia',
                'ortopeda-bemowo'                        => 'ortopedia',
                'ortopeda-bialoleka'                     => 'ortopedia',
                'ortopeda-bielany'                       => 'ortopedia',
                'ortopeda-falenica'                      => 'ortopedia',
                'ortopeda-mokotow'                       => 'ortopedia',
                'ortopeda-ochota-poradnia-ortopedyczna-fitmedica-warszawa' => 'ortopedia',
                'ortopeda-praga-polnoc'                  => 'ortopedia',
                'ortopeda-praga-poludnie'                => 'ortopedia',
                'ortopeda-rembertow'                     => 'ortopedia',
                'ortopeda-srodmiescie'                   => 'ortopedia',
                'ortopeda-stare-miasto'                  => 'ortopedia',
                'ortopeda-targowek'                      => 'ortopedia',
                'ortopeda-ursus'                         => 'ortopedia',
                'ortopeda-ursynow'                       => 'ortopedia',
                'ortopeda-wawer'                         => 'ortopedia',
                'ortopeda-wesola'                        => 'ortopedia',
                'ortopeda-wilanow'                       => 'ortopedia',
                'ortopeda-wlochy'                        => 'ortopedia',
                'ortopeda-wola'                          => 'ortopedia',
                'ortopeda-zoliborz'                      => 'ortopedia',
                'dobry-chirurg-ortopeda-warszawa'        => 'ortopedia',
            );
            // zestaw kuracji: tytul + link "wszystkie" + plakietka + GRUPY (recznie dobrane slugi, kolejnosc = waznosc)
            $fm_sets = array(
                'kardiologia' => array(
                    'live'    => true,
                    'title'   => 'Baza wiedzy o sercu',
                    'all'     => 'Zobacz wszystkie artykuły o sercu',
                    'all_url' => home_url( '/blog/category/kardiologia/' ),
                    'cat'     => 'Kardiologia',
                    'groups'  => array(
                        array(
                            'label' => 'Schorzenia i dolegliwości',
                            'slugs' => array(
                                'zawal-serca',
                                'nadcisnienie-tetnicze-2',
                                'choroba-niedokrwienna-serca',
                                'zaburzenia-rytmu-serca-arytmia',
                                'niewydolnosc-serca-przyczyny-objawy-leczenie',
                                'miazdzyca-naczyn-krwionosnych',
                                'kardiomiopatia',
                                'zapalenie-miesnia-sercowego',
                                'tetniak-aorty-piersiowej',
                                'bradykardia-przyczyny-objawy-i-leczenie',
                                'kolatania-serca-przyczyny-i-objawy-jak-wyglada-leczenie',
                                'czym-jest-nerwica-serca-objawy-i-leczenie',
                            ),
                        ),
                        array(
                            'label' => 'Diagnostyka i badania',
                            'slugs' => array(
                                'czym-jest-echo-serca-i-jakie-choroby-moze-wykryc-to-badanie',
                                'badania-ekg',
                                'ambulatoryjny-pomiar-cisnienia-tetniczego',
                            ),
                        ),
                    ),
                ),
                'ortopedia' => array(
                    'live'    => false, // PODGLAD ONLY (?fmpodglad=1) do akceptacji; potem -> true
                    'title'   => 'Baza wiedzy ortopedyczna',
                    'all'     => 'Zobacz wszystkie artykuły ortopedyczne',
                    'all_url' => home_url( '/blog/category/ortopedia/' ),
                    'cat'     => 'Ortopedia',
                    'groups'  => array(
                        array(
                            'label' => 'Schorzenia i dolegliwości',
                            'slugs' => array(
                                'bol-kregoslupa-kiedy-nalezy-wybrac-sie-do-lekarza',
                                'lakotka-lekotka-czyli-najczestsze-uszkodzenia-powodujace-bol-kolana',
                                'uszkodzenie-wiezadla-krzyzowego-przedniego-wkp-acl-czyli-ze-sportem',
                                'lokiec-tenisisty-przyczyny-objawy-profilaktyka-i-mozliwosci-leczenia',
                                'zespol-zamrozonego-barku',
                                'skrecenie-stawu-skokowego-definicja-objawy-leczenie',
                                'bol-achillesa-czym-dokladnie-jest-skad-sie-bierze-i-jakie-istnieja-mozliwosci-leczenia',
                                'bole-bioder-przyczyny-objawy-i-profilaktyka',
                                'skolioza-objawy-diagnostyka-i-leczenie-od-a-do-z',
                                'chondromalacja-rzepki-kolana-leczenie-przyczyny-objawy',
                                'choroba-duputryena-przykurcz-rozciegna-dloniowego',
                                'czym-jest-osteoporoza',
                            ),
                        ),
                        array(
                            'label' => 'Diagnostyka i badania',
                            'slugs' => array(
                                'badania-sportowe',
                                'czynnosciowe-emg-funkcjonalne-emg-semg',
                                'na-czym-polega-badanie-na-platformie-stabilograficznej',
                                'iniekcja-prp-osocze-bogatoplytkowe',
                                'iniekcja-z-kwasem-hialuronowym-do-stawow-obwodowych-i-pochewek-sciegnistych',
                            ),
                        ),
                    ),
                ),
            );

            $fm_key = isset( $fm_map[ $fm_dep_slug ] ) ? $fm_map[ $fm_dep_slug ] : '';

            if ( $fm_key && isset( $fm_sets[ $fm_key ] ) && ( ! empty( $fm_sets[ $fm_key ]['live'] ) || isset( $_GET['fmpodglad'] ) ) ) {

                $fm_set   = $fm_sets[ $fm_key ];
                $fm_slugs = array();
                foreach ( $fm_set['groups'] as $fm_g ) { $fm_slugs = array_merge( $fm_slugs, $fm_g['slugs'] ); }

                $fm_q = new WP_Query( array(
                    'post_type'           => 'post',
                    'post_status'         => 'publish',
                    'post_name__in'       => $fm_slugs,
                    'posts_per_page'      => count( $fm_slugs ),
                    'ignore_sticky_posts' => true,
                    'no_found_rows'       => true,
                ) );

                $fm_by = array();
                foreach ( $fm_q->posts as $fm_p ) { $fm_by[ $fm_p->post_name ] = $fm_p; }

                if ( ! empty( $fm_by ) ) {
                    ?>
                    <style>
                        .sidebar-widget-area .widget-fm-related .section-title{text-transform:none;}
                        .widget-fm-related .fm-ico{color:#396cf0;opacity:.5;}
                        .widget-fm-related .fm-card{margin-top:30px;background:#fff;box-shadow:0 8px 30px -10px rgba(57,108,240,.20),0 1px 4px rgba(16,24,40,.04);border-radius:10px;overflow:hidden;}
                        /* featured - okladka magazynowa */
                        .widget-fm-related a.fm-feat{display:block;text-decoration:none;position:relative;}
                        .widget-fm-related .fm-feat-media{position:relative;width:100%;height:202px;background:#dfe7f7;overflow:hidden;}
                        .widget-fm-related .fm-feat-media img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .6s cubic-bezier(.23,1,.32,1);}
                        .widget-fm-related .fm-feat-media .fm-ico{position:absolute;top:42%;left:50%;transform:translate(-50%,-50%);width:48px;height:48px;}
                        .widget-fm-related .fm-feat-scrim{position:absolute;inset:0;display:flex;flex-direction:column;justify-content:flex-end;padding:15px 16px 16px;background:linear-gradient(to top,rgba(11,18,38,.92) 0%,rgba(11,18,38,.5) 38%,rgba(11,18,38,0) 72%);}
                        .widget-fm-related .fm-feat-cat{align-self:flex-start;margin-bottom:auto;background:#FF6F22;color:#fff;font-family:'Roboto',sans-serif;font-size:10px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;padding:4px 9px;border-radius:3px;}
                        .widget-fm-related .fm-feat-title{font-family:'Raleway',sans-serif;font-weight:700;font-size:16.5px;line-height:1.28;color:#fff;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;}
                        /* lista */
                        .widget-fm-related ul.fm-list{list-style:none;margin:0;padding:5px 0;}
                        .widget-fm-related ul.fm-list:empty{display:none;}
                        .sidebar-widget-area .widget-fm-related .fm-list li.fm-item{margin:0;padding:0;list-style:none;}
                        .widget-fm-related li.fm-item + li.fm-item{border-top:1px solid #f0f1f4;}
                        .widget-fm-related a.fm-link{display:flex;gap:13px;align-items:center;padding:11px 16px;text-decoration:none;transition:background-color .18s ease;}
                        .widget-fm-related .fm-thumb{flex:0 0 60px;width:60px;height:60px;border-radius:7px;overflow:hidden;background:#eef2fb;position:relative;}
                        .widget-fm-related .fm-thumb img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .45s cubic-bezier(.23,1,.32,1);}
                        .widget-fm-related .fm-thumb .fm-ico{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:24px;height:24px;}
                        .widget-fm-related .fm-body{flex:1 1 auto;min-width:0;}
                        .widget-fm-related .fm-title{font-family:'Raleway',sans-serif;font-weight:600;font-size:13.5px;line-height:1.33;color:#1a1a1a;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;transition:color .2s ease;}
                        .widget-fm-related .fm-date{display:block;margin-top:5px;font-family:'Roboto',sans-serif;font-size:10.5px;font-weight:500;color:#9aa3af;text-transform:uppercase;letter-spacing:.05em;}
                        /* cta footer */
                        .widget-fm-related a.fm-all-link{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:14px 16px;border-top:1px solid #eef0f3;background:#f7f9fd;font-family:'Roboto',sans-serif;font-weight:600;font-size:13px;color:#396cf0;text-decoration:none;transition:background-color .2s ease;}
                        .widget-fm-related a.fm-all-link svg{width:16px;height:16px;flex:0 0 auto;transition:transform .2s ease;}
                        @media (hover:hover) and (pointer:fine){
                            .widget-fm-related a.fm-feat:hover .fm-feat-media img{transform:scale(1.05);}
                            .widget-fm-related a.fm-link:hover{background:#f4f7fe;}
                            .widget-fm-related a.fm-link:hover .fm-title{color:#396cf0;}
                            .widget-fm-related a.fm-link:hover .fm-thumb img{transform:scale(1.08);}
                            .widget-fm-related a.fm-all-link:hover{background:#eef3fd;}
                            .widget-fm-related a.fm-all-link:hover svg{transform:translateX(4px);}
                        }
                        .widget-fm-related .fm-group-label{margin:0;padding:14px 16px 9px;font-family:'Roboto',sans-serif;font-size:11px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#5b6472;}
                        .widget-fm-related .fm-group-label--sep{border-top:1px solid #eef0f3;margin-top:3px;}
                        @media (prefers-reduced-motion: reduce){.widget-fm-related img,.widget-fm-related svg{transition:none;}}
                    </style>
                    <div class="widgets widget-fm-related">
                        <span class="section-title title-bar-primary"><?php echo esc_html( $fm_set['title'] ); ?></span>
                        <div class="fm-card">
                            <?php
                            $fm_feat_slug = $fm_set['groups'][0]['slugs'][0];
                            foreach ( $fm_set['groups'] as $fm_gi => $fm_g ) : ?>
                                <p class="fm-group-label<?php echo $fm_gi > 0 ? ' fm-group-label--sep' : ''; ?>"><?php echo esc_html( $fm_g['label'] ); ?></p>
                                <?php if ( 0 === $fm_gi && isset( $fm_by[ $fm_feat_slug ] ) ) :
                                    $fm_p = $fm_by[ $fm_feat_slug ]; ?>
                                    <a class="fm-feat" href="<?php echo esc_url( get_permalink( $fm_p ) ); ?>">
                                        <span class="fm-feat-media">
                                            <?php $fm_img = get_the_post_thumbnail( $fm_p->ID, 'medium', array( 'alt' => esc_attr( get_the_title( $fm_p ) ), 'loading' => 'lazy' ) );
                                            if ( $fm_img ) { echo $fm_img; } else { ?>
                                                <svg class="fm-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h4l2-6 4 12 2-6h6"/></svg>
                                            <?php } ?>
                                            <span class="fm-feat-scrim">
                                                <span class="fm-feat-cat"><?php echo esc_html( $fm_set['cat'] ); ?></span>
                                                <span class="fm-feat-title"><?php echo esc_html( get_the_title( $fm_p ) ); ?></span>
                                            </span>
                                        </span>
                                    </a>
                                <?php endif; ?>
                                <ul class="fm-list">
                                    <?php foreach ( $fm_g['slugs'] as $fm_slug ) :
                                        if ( 0 === $fm_gi && $fm_slug === $fm_feat_slug ) { continue; }
                                        if ( ! isset( $fm_by[ $fm_slug ] ) ) { continue; }
                                        $fm_p = $fm_by[ $fm_slug ]; ?>
                                        <li class="fm-item">
                                            <a class="fm-link" href="<?php echo esc_url( get_permalink( $fm_p ) ); ?>">
                                                <span class="fm-thumb">
                                                    <?php $fm_img = get_the_post_thumbnail( $fm_p->ID, 'thumbnail', array( 'alt' => esc_attr( get_the_title( $fm_p ) ), 'loading' => 'lazy' ) );
                                                    if ( $fm_img ) { echo $fm_img; } else { ?>
                                                        <svg class="fm-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h4l2-6 4 12 2-6h6"/></svg>
                                                    <?php } ?>
                                                </span>
                                                <span class="fm-body">
                                                    <span class="fm-title"><?php echo esc_html( get_the_title( $fm_p ) ); ?></span>
                                                    <span class="fm-date"><?php echo esc_html( get_the_date( 'j M Y', $fm_p ) ); ?></span>
                                                </span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endforeach; ?>
                            <a class="fm-all-link" href="<?php echo esc_url( $fm_set['all_url'] ); ?>">
                                <?php echo esc_html( $fm_set['all'] ); ?>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                            </a>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            }
        }
        ?>
</div>
   
   