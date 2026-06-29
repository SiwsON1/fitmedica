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
</div> 
   
   