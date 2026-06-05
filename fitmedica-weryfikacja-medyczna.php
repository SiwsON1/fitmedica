<?php
/**
 * Plugin Name: Fitmedica - Weryfikacja Medyczna
 * Description: Badge "Zweryfikowano medycznie", FAQ accordion i zrodla pod artykulami blogowymi.
 * Version: 2.0
 * Author: NETIM
 */

if (!defined('ABSPATH')) exit;

/* -----------------------------------------------
   AUTO-SETUP - jednorazowe przypisanie lekarza
   do 2 pierwszych postow. Uruchamia sie raz.
   ----------------------------------------------- */

add_action('init', function () {
    if (get_option('fitmedica_mv_setup_v3')) return;

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
            update_post_meta($q->posts[0], '_medical_review_date', '2026-04');
        }
        wp_reset_postdata();
    }

    update_option('fitmedica_mv_setup_v3', true);
});

/* -----------------------------------------------
   AUTO-SETUP FAQ + ZRODLA - 2 nowe artykuly
   (zerwany biceps, bol Achillesa) - weryfikator
   mgr Jan Sala. Uruchamia sie raz.
   ----------------------------------------------- */

add_action('init', function () {
    if (get_option('fitmedica_faq_setup_v2')) return;

    $articles = [
        'zerwany-biceps-przyczyny-leczenie-i-rehabilitacja' => [
            'reviewer'    => 'jan-sala',
            'review_date' => '2026-05',
            'faq' => [
                [
                    'question' => 'Ile trwa powrót do sprawności po operacji zerwanego bicepsa?',
                    'answer'   => 'Pełny powrót zajmuje zwykle od 4 do 6 miesięcy. Pierwsze tygodnie to ochrona zszytego ścięgna, ruchy ręką bez obciążenia wprowadza się około 4-6 tygodnia, codzienne czynności wracają po około 3 miesiącach, a obciążenia sportowe i siłowe po 6 miesiącach. Tempo zależy od typu zerwania i uprawianej dyscypliny.',
                ],
                [
                    'question' => 'Czy dystalne zerwanie bicepsa trzeba operować w określonym czasie?',
                    'answer'   => 'Tak, przy całkowitym zerwaniu przyczepu dalszego liczy się czas. Najlepsze warunki do zszycia ścięgna są w pierwszych dwóch, trzech tygodniach od urazu. Później ścięgno się obkurcza i bliznowacieje, co utrudnia operację i pogarsza odzysk siły. Dlatego ból i nagłe osłabienie zgięcia łokcia warto skonsultować szybko.',
                ],
                [
                    'question' => 'Co się stanie, jeśli nie zoperuję zerwanego ścięgna dystalnego?',
                    'answer'   => 'Ścięgno dalszego przyczepu nie zrośnie się samo z kością. Bez operacji zostaje trwały ubytek siły, najbardziej odczuwalny przy odwracaniu przedramienia (np. wkręcanie śrubokrętem) i zginaniu łokcia. U osób mało aktywnych bywa to akceptowalne, ale sportowcy i pracujący fizycznie zwykle korzystają z rekonstrukcji.',
                ],
                [
                    'question' => 'Czy zerwanie głowy długiej bicepsa (w barku) zawsze wymaga operacji?',
                    'answer'   => 'Najczęściej nie. Proksymalne zerwanie głowy długiej często leczy się zachowawczo, bo pozostałe przyczepy przejmują funkcję, a utrata siły jest niewielka. Operację rozważa się głównie u osób młodych, aktywnych sportowo lub gdy przeszkadza widoczna deformacja albo bolesny skurcz mięśnia.',
                ],
                [
                    'question' => 'Czy "efekt Popeye\'a" zniknie po leczeniu?',
                    'answer'   => 'Widoczne zgrubienie mięśnia to przemieszczony brzusiec po zerwaniu głowy długiej w barku. Przy leczeniu zachowawczym taka deformacja zwykle pozostaje, choć rzadko przeszkadza w funkcji, a operacja koryguje ją głównie ze względów estetycznych lub przy bolesnym skurczu. To inny problem niż zerwanie przyczepu dalszego przy łokciu, gdzie liczy się przede wszystkim odzyskanie siły, a nie wygląd ramienia.',
                ],
                [
                    'question' => 'Kiedy mogę wrócić na siłownię i do podnoszenia ciężarów?',
                    'answer'   => 'Lekkie ćwiczenia bez obciążania ramienia fizjoterapeuta wprowadza zwykle po kilku tygodniach, ale pełny trening siłowy i dźwiganie dużych ciężarów dopiero po około 6 miesiącach od operacji. Zbyt wczesny powrót grozi ponownym zerwaniem świeżo zszytego ścięgna. Progresję obciążeń ustala się indywidualnie.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'American Academy of Orthopaedic Surgeons',
                    'title'     => 'Biceps Tendon Tear at the Elbow',
                    'publisher' => 'OrthoInfo (AAOS)',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
                [
                    'authors'   => 'Looney A.M., Day J., Bodendorfer B.M. i wsp.',
                    'title'     => 'Operative vs. nonoperative treatment of distal biceps ruptures: a systematic review and meta-analysis',
                    'publisher' => 'Journal of Shoulder and Elbow Surgery',
                    'note'      => '2022; 31(4): e169-e189',
                ],
                [
                    'authors'   => 'Sutton K.M., Dodds S.D., Ahmad C.S., Sethi P.M.',
                    'title'     => 'Surgical Treatment of Distal Biceps Rupture',
                    'publisher' => 'Journal of the American Academy of Orthopaedic Surgeons',
                    'note'      => '2010; 18(3): 139-148',
                ],
                [
                    'authors'   => 'American Academy of Orthopaedic Surgeons',
                    'title'     => 'Biceps Tendon Tear at the Shoulder',
                    'publisher' => 'OrthoInfo (AAOS)',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'bol-achillesa-czym-dokladnie-jest-skad-sie-bierze-i-jakie-istnieja-mozliwosci-leczenia' => [
            'reviewer'    => 'jan-sala',
            'review_date' => '2026-05',
            'faq' => [
                [
                    'question' => 'Ile trwa leczenie tendinopatii ścięgna Achillesa?',
                    'answer'   => 'Zwykle od 3 do 6 miesięcy konsekwentnej rehabilitacji. Podstawą jest około 12-tygodniowy program ćwiczeń, ale przy przewlekłych dolegliwościach poprawa bywa wolniejsza. Ścięgno adaptuje się powoli, bo jest słabo ukrwione, dlatego liczy się regularność i cierpliwość, a nie sam odpoczynek.',
                ],
                [
                    'question' => 'Czy mogę biegać i trenować podczas leczenia bólu Achillesa?',
                    'answer'   => 'Często można, ale tylko po zmniejszeniu obciążenia i jeśli ból nie narasta w trakcie ani następnego dnia. Całkowity bezruch nie jest zalecany, bo ścięgno potrzebuje kontrolowanego obciążenia, żeby się regenerować. Na czas leczenia warto ograniczyć bieganie i skoki, a kondycję utrzymać mniej obciążającymi formami: pływaniem, rowerem, wioślarstwem. Reakcja ścięgna dzień po wysiłku to lepszy wyznacznik niż sam ból podczas treningu.',
                ],
                [
                    'question' => 'Na czym polegają ćwiczenia ekscentryczne i jak długo je wykonywać?',
                    'answer'   => 'To kontrolowane opuszczanie pięty, które wzmacnia ścięgno pod obciążeniem. Klasyczny protokół zakłada trzy serie po 15 powtórzeń, dwa razy dziennie, przez około 12 tygodni, z nogą wyprostowaną i ugiętą w kolanie. To jeden ze sprawdzonych sposobów, ale obecnie stosuje się też inne formy stopniowego obciążania ścięgna, dobierane do bólu i etapu leczenia. Plan powinien ułożyć fizjoterapeuta, bo zbyt wczesna intensywność potrafi nasilić ból.',
                ],
                [
                    'question' => 'Czy fala uderzeniowa i osocze bogatopłytkowe (PRP) pomagają na ból Achillesa?',
                    'answer'   => 'Mogą być dodatkiem do ćwiczeń u części pacjentów z przewlekłym bólem, ale efekt nie jest gwarantowany. Fala uderzeniowa bywa łączona z rehabilitacją, gdy sama terapia ruchem nie wystarcza. PRP nie ma mocnych dowodów jako rutynowe leczenie tendinopatii Achillesa, dlatego o jego zastosowaniu decyduje się indywidualnie po badaniu. Fundamentem leczenia pozostają ćwiczenia, a zabiegi je uzupełniają, nie zastępują.',
                ],
                [
                    'question' => 'Jak odróżnić tendinopatię od zerwania ścięgna Achillesa?',
                    'answer'   => 'Tendinopatia narasta stopniowo: ból i sztywność pojawiają się przy starcie aktywności i nasilają z czasem. Zerwanie to nagły uraz, często z uczuciem uderzenia lub "strzału" w łydkę, osłabieniem odbicia i trudnością ze stanięciem na palcach. Ból bywa silny na początku, ale potrafi szybko zelżeć, co nie znaczy, że uraz jest błahy. Zerwanie wymaga pilnej konsultacji, bo decyzja o leczeniu zapada w pierwszych dniach.',
                ],
                [
                    'question' => 'Czy ból ścięgna Achillesa może wrócić i jak temu zapobiec?',
                    'answer'   => 'Tak, nawroty są częste, jeśli wróci się do pełnych obciążeń zbyt szybko. Ryzyko zmniejsza stopniowe zwiększanie kilometrażu, rozgrzewka, dobre obuwie, praca nad ruchomością stawu skokowego i siłą łydki. Utrzymanie ćwiczeń wzmacniających po ustąpieniu bólu to najlepsza profilaktyka.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Chimenti R.L., Neville C., Houck J. i wsp.',
                    'title'     => 'Achilles Pain, Stiffness, and Muscle Power Deficits: Midportion Achilles Tendinopathy Revision - 2024',
                    'publisher' => 'Journal of Orthopaedic & Sports Physical Therapy',
                    'note'      => '2024; 54(12): CPG1-CPG32',
                ],
                [
                    'authors'   => 'Alfredson H., Pietila T., Jonsson P., Lorentzon R.',
                    'title'     => 'Heavy-load eccentric calf muscle training for the treatment of chronic Achilles tendinosis',
                    'publisher' => 'American Journal of Sports Medicine',
                    'note'      => '1998; 26(3): 360-366',
                ],
                [
                    'authors'   => 'Silbernagel K.G., Thomee R., Eriksson B.I., Karlsson J.',
                    'title'     => 'Continued sports activity, using a pain-monitoring model, during rehabilitation in patients with Achilles tendinopathy',
                    'publisher' => 'American Journal of Sports Medicine',
                    'note'      => '2007; 35(6): 897-906',
                ],
                [
                    'authors'   => 'Rompe J.D., Furia J., Maffulli N.',
                    'title'     => 'Eccentric loading versus eccentric loading plus shock-wave treatment for midportion Achilles tendinopathy: a randomized controlled trial',
                    'publisher' => 'American Journal of Sports Medicine',
                    'note'      => '2009; 37(3): 463-470',
                ],
            ],
        ],
    ];

    foreach ($articles as $post_slug => $data) {
        $q = new WP_Query([
            'name'           => $post_slug,
            'post_type'      => 'post',
            'posts_per_page' => 1,
            'fields'         => 'ids',
            'no_found_rows'  => true,
        ]);
        if (!empty($q->posts)) {
            $pid = $q->posts[0];
            update_post_meta($pid, '_medical_reviewer', $data['reviewer']);
            update_post_meta($pid, '_medical_review_date', $data['review_date']);
            update_post_meta($pid, '_fitmedica_faq', $data['faq']);
            update_post_meta($pid, '_fitmedica_sources', $data['sources']);
        }
        wp_reset_postdata();
    }

    update_option('fitmedica_faq_setup_v2', true);
});

/* -----------------------------------------------
   AUTO-SETUP FAQ + ZRODLA - partia ortopedyczna
   (kolano biegacza, zespol ciesni nadgarstka,
   skrecenie stawu skokowego). Bez weryfikatora -
   nikt nie robil realnego review medycznego.
   Uruchamia sie raz.
   ----------------------------------------------- */

add_action('init', function () {
    if (get_option('fitmedica_faq_setup_v3')) return;

    $articles = [
        'skrecenie-stawu-skokowego-definicja-objawy-leczenie' => [
            'faq' => [
                [
                    'question' => 'Jak odróżnić skręcenie kostki od złamania?',
                    'answer'   => 'Po samych objawach nie zawsze się da, bo silny ból, obrzęk i zasinienie występują w obu przypadkach. Dlatego przy poważniejszym urazie wykonuje się RTG, które wyklucza złamanie lub przemieszczenie kości. Gdy podejrzewa się zerwanie więzadeł, pomocne jest USG stawu skokowego. Jeśli po urazie nie można obciążyć nogi ani na niej stanąć, warto pilnie zgłosić się do lekarza.',
                ],
                [
                    'question' => 'Co oznaczają stopnie skręcenia kostki?',
                    'answer'   => 'W I stopniu dochodzi do naciągnięcia lub naderwania części więzadeł, z niewielkim obrzękiem i bez utraty stabilności. II stopień to istotne uszkodzenie więzadeł i torebki stawowej, z większym bólem i ograniczeniem ruchu. III stopień oznacza całkowite zerwanie więzadeł, rozległy obrzęk, silny ból i niestabilność stawu. Stopień urazu decyduje o sposobie leczenia.',
                ],
                [
                    'question' => 'Co robić zaraz po skręceniu stawu skokowego?',
                    'answer'   => 'W pierwszych godzinach pomaga schemat PRICE: ochrona stawu (na przykład orteza), odciążenie i odpoczynek, chłodzenie zimnymi okładami, ucisk opaską elastyczną oraz uniesienie nogi powyżej poziomu serca. Takie postępowanie ogranicza obrzęk i ból. Zimno i ucisk warto zastosować jak najszybciej, zanim obrzęk zdąży się rozwinąć.',
                ],
                [
                    'question' => 'Czy skręconą kostkę trzeba unieruchamiać na sztywno?',
                    'answer'   => 'Zwykle nie na długo. W większości skręceń lepsze efekty daje leczenie czynnościowe, czyli stabilizacja ortezą i stopniowy powrót do ruchu oraz obciążania, niż długie unieruchomienie w sztywnym gipsie. Wczesne, kontrolowane usprawnianie pod okiem fizjoterapeuty sprzyja szybszemu powrotowi do sprawności. Sposób leczenia zawsze dobiera się do stopnia urazu.',
                ],
                [
                    'question' => 'Czy skręcenie stawu skokowego wymaga operacji?',
                    'answer'   => 'Najczęściej nie. Skręcenia I i II stopnia leczy się zachowawczo, łącząc odciążenie, leki przeciwbólowe i rehabilitację. Operację rozważa się głównie przy całkowitym zerwaniu więzadeł (III stopień) lub przy utrzymującej się niestabilności mimo leczenia. Zabieg często wykonuje się artroskopowo, przez niewielkie nacięcia.',
                ],
                [
                    'question' => 'Czy po skręceniu kostka może pozostać niestabilna?',
                    'answer'   => 'Tak, źle leczone lub nawracające skręcenia mogą prowadzić do przewlekłej niestabilności stawu, a z czasem do uszkodzenia chrząstki i zmian zwyrodnieniowych. Dlatego po urazie ważna jest pełna rehabilitacja, w tym ćwiczenia równowagi i czucia głębokiego, które wzmacniają stabilizację i zmniejszają ryzyko kolejnych skręceń.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Martin R.L., Davenport T.E., Fraser J.J. i wsp.',
                    'title'     => 'Ankle Stability and Movement Coordination Impairments: Lateral Ankle Ligament Sprains Revision 2021',
                    'publisher' => 'Journal of Orthopaedic & Sports Physical Therapy',
                    'note'      => '2021; 51(4): CPG1-CPG80',
                ],
                [
                    'authors'   => 'Vuurberg G., Hoorntje A., Wink L.M. i wsp.',
                    'title'     => 'Diagnosis, treatment and prevention of ankle sprains: update of an evidence-based clinical guideline',
                    'publisher' => 'British Journal of Sports Medicine',
                    'note'      => '2018; 52(15): 956',
                ],
                [
                    'authors'   => 'American Academy of Orthopaedic Surgeons',
                    'title'     => 'Sprained Ankle',
                    'publisher' => 'OrthoInfo (AAOS)',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
    ];

    foreach ($articles as $post_slug => $data) {
        $q = new WP_Query([
            'name'           => $post_slug,
            'post_type'      => 'post',
            'posts_per_page' => 1,
            'fields'         => 'ids',
            'no_found_rows'  => true,
        ]);
        if (!empty($q->posts)) {
            $pid = $q->posts[0];
            update_post_meta($pid, '_fitmedica_faq', $data['faq']);
            update_post_meta($pid, '_fitmedica_sources', $data['sources']);
        }
        wp_reset_postdata();
    }

    update_option('fitmedica_faq_setup_v3', true);
});

/**
 * Dane lekarzy - pelna lista zespolu fitmedica.pl/zespol/
 */
function fitmedica_get_doctors() {
    return [
        'stanislaw-pomianowski' => [
            'name'      => 'prof. dr hab. n. med. Stanislaw Pomianowski',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2020/05/prof-dr-hab-n-med-stanislaw-pomianowski-230-230.jpg',
            'profile'   => '/zespol/prof-dr-hab-n-med-stanislaw-pomianowski/',
        ],
        'rafal-kaminski' => [
            'name'      => 'dr hab. n. med. Rafal Kaminski, prof. CMKP',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2020/05/rafal-kaminski-u-213.jpeg',
            'profile'   => '/zespol/dr-hab-n-med-rafal-kaminski/',
        ],
        'marcin-zlotorowicz' => [
            'name'      => 'dr hab. n. med. Marcin Zlotorowicz, prof. CMKP',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2020/05/dr-hab-n-med-marcin-zlotorowicz-prof-cmkp-230-230.jpg',
            'profile'   => '/zespol/dr-hab-n-med-marcin-zlotorowicz/',
        ],
        'krzysztof-kulinski' => [
            'name'      => 'dr n. med. Krzysztof Kulinski',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2020/03/dr-n-med-krzysztof-kulinski-230-230.jpg',
            'profile'   => '/zespol/dr-krzysztof-kulinski/',
        ],
        'pawel-bartosz' => [
            'name'      => 'dr n. med. Pawel Bartosz',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2024/12/dr-n-med-pawel-bartosz-230-230-1.jpg',
            'profile'   => '/zespol/dr-n-med-pawel-bartosz/',
        ],
        'michal-janyst' => [
            'name'      => 'dr n. med. Michal Janyst',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2024/05/Janyst-230-230.jpeg',
            'profile'   => '/zespol/michal-janyst/',
        ],
        'maciej-langner' => [
            'name'      => 'lek. Maciej Langner',
            'specialty' => 'Ortopedia i traumatologia',
            'photo'     => '/wp-content/uploads/2020/05/lek-maciej-langner-230-230.jpg',
            'profile'   => '/zespol/dr-maciej-langner/',
            'bio'       => 'Jeden z pionierow chirurgii artroskopowej w Polsce. Konsultant w Klinice Chirurgii Urazowej i Ortopedii CMKP w Otwocku. Specjalizuje sie w leczeniu stawu kolanowego.',
        ],
        'michal-lenkiewicz' => [
            'name'      => 'lek. Michal Lenkiewicz',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2020/03/lek-michal-lenkiewicz-230-230.jpg',
            'profile'   => '/zespol/dr-michal-lenkiewicz/',
        ],
        'krzysztof-krauze' => [
            'name'      => 'lek. Krzysztof Krauze',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2020/03/lek-krzysztof-krauze-230-230.jpg',
            'profile'   => '/zespol/dr-krzysztof-krauze/',
        ],
        'maciej-makowski' => [
            'name'      => 'lek. Maciej Makowski',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2020/03/lek-maciej-makowski-230-230.jpg',
            'profile'   => '/zespol/dr-maciej-makowski/',
        ],
        'krzysztof-bajszczak' => [
            'name'      => 'lek. Krzysztof Bajszczak',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2020/03/lek-krzysztof-bajszczak-230-230.jpg',
            'profile'   => '/zespol/lek-krzysztof-bajszczak/',
        ],
        'dominika-pyszno-prokopowicz' => [
            'name'      => 'dr n. med. Dominika Pyszno-Prokopowicz',
            'specialty' => 'Kardiologia',
            'photo'     => '/wp-content/uploads/2020/03/dr-n-med-dominika-pyszno-prokopowicz-230-230.jpg',
            'profile'   => '/zespol/dr-n-med-dominika-pyszno-prokopowicz/',
        ],
        'artur-pisarski' => [
            'name'      => 'lek. Artur Pisarski',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2025/09/freepik-20260105101315OYij.jpeg',
            'profile'   => '/zespol/lek-artur-pisarski/',
        ],
        'maciej-baranowski' => [
            'name'      => 'dr n. med. Maciej Baranowski',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2025/03/spacialista-230-230.jpg',
            'profile'   => '/zespol/maciej-baranski/',
        ],
        'katarzyna-bialecka' => [
            'name'      => 'lek. Katarzyna Bialecka',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2025/03/specialistka-23-230.jpg',
            'profile'   => '/zespol/katarzyna-bialecka/',
        ],
        'oleg-tchoriwski' => [
            'name'      => 'dr n. med. Oleg Tchoriwski',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2025/03/spacialista-230-230.jpg',
            'profile'   => '/zespol/dr-oleg-tchoriwski/',
        ],
        'joanna-friedman-gruszczynska' => [
            'name'      => 'dr n. med. Joanna Friedman-Gruszczynska',
            'specialty' => 'Kardiologia dziecieca',
            'photo'     => '/wp-content/uploads/2020/03/dr-n-med-joanna-friedman-gruszczynska-230-230.jpg',
            'profile'   => '/zespol/dr-n-med-joanna-friedman-gruszczynska/',
        ],
        'monika-lubas' => [
            'name'      => 'lek. Monika Lubas',
            'specialty' => 'Reumatologia',
            'photo'     => '/wp-content/uploads/2020/03/lek-monika-lubas-230-230.jpg',
            'profile'   => '/zespol/lek-monika-lubas/',
        ],
        'michal-saganek' => [
            'name'      => 'lek. Michal Saganek',
            'specialty' => 'Ortopedia sportowa',
            'photo'     => '/wp-content/uploads/2025/12/freepik-2026030612050414B8.jpeg',
            'profile'   => '/zespol/lek-michal-saganek/',
        ],
        'jerzy-pregowski' => [
            'name'      => 'dr hab. n. med. Jerzy Pregowski, prof. NIK',
            'specialty' => 'Kardiologia',
            'photo'     => '/wp-content/uploads/2020/03/dr-hab-n-med-jerzy-pregowski-prof-NIK-230-230.jpg',
            'profile'   => '/zespol/dr-hab-n-med-jerzy-pregowski/',
        ],
        'marcin-szumanski' => [
            'name'      => 'mgr Marcin Szumanski',
            'specialty' => 'Fizjoterapia',
            'photo'     => '/wp-content/uploads/2020/03/mgr-marcin-szumanski-230-230.jpg',
            'profile'   => '/zespol/marcin-szumanski/',
        ],
        'hanna-domanska' => [
            'name'      => 'mgr Hanna Domanska',
            'specialty' => 'Dietetyka',
            'photo'     => '/wp-content/uploads/2020/03/mgr-hanna-domanska-230-230.jpg',
            'profile'   => '/zespol/mgr-hanna-domanska/',
        ],
        'ewa-strozynska' => [
            'name'      => 'dr n. med. Ewa Strozynska',
            'specialty' => 'Neurologia',
            'photo'     => '/wp-content/uploads/2025/03/specialistka-23-230.jpg',
            'profile'   => '/zespol/ewa-strozynska/',
        ],
        'maciej-kicinski' => [
            'name'      => 'lek. Maciej Kicinski',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2025/03/spacialista-230-230.jpg',
            'profile'   => '/zespol/dr-maciej-kicinski/',
        ],
        'rafal-garlewicz' => [
            'name'      => 'lek. Rafal Garlewicz',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2024/12/lek-rafal-garlewicz-230-230.jpg',
            'profile'   => '/zespol/dr-rafal-garlewicz/',
        ],
        'kacper-kostyra' => [
            'name'      => 'lek. Kacper Kostyra',
            'specialty' => 'Neurochirurgia',
            'photo'     => '/wp-content/uploads/2025/03/spacialista-230-230.jpg',
            'profile'   => '/zespol/kacper-kostyra/',
        ],
        'tomasz-okon' => [
            'name'      => 'lek. Tomasz Okon',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2025/03/spacialista-230-230.jpg',
            'profile'   => '/zespol/dr-tomasz-okon/',
        ],
        'jacek-weglarz' => [
            'name'      => 'lek. Jacek Weglarz',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2025/03/spacialista-230-230.jpg',
            'profile'   => '/zespol/dr-jacek-weglarz/',
        ],
        'maciej-wleklik' => [
            'name'      => 'lek. Maciej Wleklik',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2020/01/lek-maciej-wleklik-230-230.jpg',
            'profile'   => '/zespol/maciej-wleklik/',
        ],
        'maciej-zbrzezniak' => [
            'name'      => 'dr n. med. Maciej Zbrzezniak',
            'specialty' => 'Urologia',
            'photo'     => '/wp-content/uploads/2024/12/dr-n-med-maciej-zbrzezniak-230-230.jpg',
            'profile'   => '/zespol/dr-n-med-maciej-zbrzezniak/',
        ],
        'jakub-sorn' => [
            'name'      => 'mgr Jakub Sorn',
            'specialty' => 'Fizjoterapia',
            'photo'     => '/wp-content/uploads/2025/12/freepik-20260105101003JPam.jpeg',
            'profile'   => '/zespol/mgr-jakub-sorn/',
        ],
        'artur-peplonski' => [
            'name'      => 'dr n. med. Artur Peplonski',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2025/03/spacialista-230-230.jpg',
            'profile'   => '/zespol/dr-n-med-artur-peplonski/',
        ],
        'kamila-malesa' => [
            'name'      => 'lek. Kamila Malesa',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2025/04/dr-kamila-malesa-230-230.jpg',
            'profile'   => '/zespol/lek-kamila-malesa/',
        ],
        'marcin-para' => [
            'name'      => 'dr n. med. Marcin Para',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2025/03/spacialista-230-230.jpg',
            'profile'   => '/zespol/marcin-para/',
        ],
        'ewa-trams' => [
            'name'      => 'lek. Ewa Trams',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2024/12/lek-ewa-trams-230-230.jpg',
            'profile'   => '/zespol/ewa-trams/',
        ],
        'rafal-osinski' => [
            'name'      => 'lek. Rafal Osinski',
            'specialty' => 'Psychiatria',
            'photo'     => '/wp-content/uploads/2024/12/lek-rafal-osinski-230-230.jpg',
            'profile'   => '/zespol/rafal-osinski/',
        ],
        'maciej-liszka' => [
            'name'      => 'lek. Maciej Liszka',
            'specialty' => 'Ortopedia',
            'photo'     => '/wp-content/uploads/2025/03/spacialista-230-230.jpg',
            'profile'   => '/zespol/lek-maciej-liszka/',
        ],
        'agnieszka-krauze' => [
            'name'      => 'mgr Agnieszka Krauze',
            'specialty' => 'Psychologia',
            'photo'     => '/wp-content/uploads/2025/03/mgr-agnieszka-krauze-230-230.jpg',
            'profile'   => '/zespol/mgr-agnieszka-krauze/',
        ],
        'karolina-lisiecka' => [
            'name'      => 'lek. Karolina Lisiecka',
            'specialty' => 'Ortopedia dziecieca',
            'photo'     => '/wp-content/uploads/2025/03/specialistka-23-230.jpg',
            'profile'   => '/zespol/lek-karolina-lisiecka/',
        ],
        'magdalena-uszynska-jast' => [
            'name'      => 'lek. Magdalena Uszynska-Jast',
            'specialty' => 'Dermatologia',
            'photo'     => '/wp-content/uploads/2025/03/lek-magdalena-uszynska-jast-230-230.jpg',
            'profile'   => '/zespol/lek-magdalena-uszynska-jast/',
        ],
        'anna-chodzinska' => [
            'name'      => 'mgr Anna Chodzinska',
            'specialty' => 'Psychologia',
            'photo'     => '/wp-content/uploads/2026/04/2026_03_31_Przerobienie-zdjecie-lekarza_230x230.jpg',
            'profile'   => '/zespol/mgr-anna-chodzinska/',
        ],
        'anna-mierzynska' => [
            'name'      => 'dr n. med. i n. o zdr. Anna Mierzynska',
            'specialty' => 'Psychologia',
            'photo'     => '/wp-content/uploads/2024/12/dr-n-med-i-n-o-zdr-anna-mierzynnska-230-230.jpg',
            'profile'   => '/zespol/dr-n-med-i-n-o-zdr-anna-mierzynska/',
        ],
        'jan-sala' => [
            'name'      => 'mgr Jan Sala',
            'specialty' => 'Fizjoterapia',
            'photo'     => '/wp-content/uploads/2025/01/230-jan-sala.jpeg',
            'profile'   => '/zespol/mgr-jan-sala/',
            'bio'       => 'Fizjoterapeuta, absolwent Warszawskiego Uniwersytetu Medycznego. Pracuje z pacjentami z chorobami narzadu ruchu, po urazach i operacjach ortopedycznych. Laczy terapie manualna, terapie ruchem i plastrowanie, kladac nacisk na edukacje pacjenta.',
        ],
        'bruno-krauze' => [
            'name'      => 'mgr Bruno Krauze',
            'specialty' => 'Fizjoterapia',
            'photo'     => '/wp-content/uploads/2020/03/mgr-bruno-krauze-230-230.jpg',
            'profile'   => '/zespol/bruno-krauze/',
        ],
        'jaroslaw-zoladek' => [
            'name'      => 'mgr Jaroslaw Zoladek',
            'specialty' => 'Fizjoterapia',
            'photo'     => '/wp-content/uploads/2020/03/mgr-jaroslaw-zoladek-230-230.jpg',
            'profile'   => '/zespol/jaroslaw-zoladek/',
        ],
        'magdalena-marsicka' => [
            'name'      => 'mgr Magdalena Marsicka',
            'specialty' => 'Fizjoterapia',
            'photo'     => '/wp-content/uploads/2025/06/freepik-20250703085626NZ7n.jpeg',
            'profile'   => '/zespol/mgr-magdalena-marsicka/',
        ],
    ];
}

/* -----------------------------------------------
   META BOX - Weryfikacja medyczna (sidebar)
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
    add_meta_box(
        'fitmedica_faq',
        'FAQ - Najczesciej zadawane pytania',
        'fitmedica_faq_meta_box_html',
        'post',
        'normal',
        'default'
    );
    add_meta_box(
        'fitmedica_sources',
        'Zrodla naukowe',
        'fitmedica_sources_meta_box_html',
        'post',
        'normal',
        'default'
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
        echo '<option value="' . esc_attr($slug) . '"' . $sel . '>' . esc_html($doc['name']) . ' (' . esc_html($doc['specialty']) . ')</option>';
    }
    echo '</select>';

    echo '<p style="margin-top:10px"><label for="medical_review_date"><strong>Data weryfikacji (YYYY-MM):</strong></label></p>';
    echo '<input type="month" id="medical_review_date" name="medical_review_date" '
       . 'value="' . esc_attr($current_date) . '" style="width:100%">';
}

/* -----------------------------------------------
   META BOX - FAQ repeater
   ----------------------------------------------- */

function fitmedica_faq_meta_box_html($post) {
    $faq = get_post_meta($post->ID, '_fitmedica_faq', true);
    if (!is_array($faq)) $faq = [];
    ?>
    <div id="fitmedica-faq-repeater">
        <div id="fitmedica-faq-items">
            <?php foreach ($faq as $i => $item): ?>
            <div class="fitmedica-faq-row" style="border:1px solid #ddd;padding:10px;margin-bottom:8px;background:#f9f9f9;border-radius:4px">
                <p style="margin:0 0 6px"><strong>Pytanie:</strong></p>
                <input type="text" name="fitmedica_faq[<?php echo $i; ?>][question]" value="<?php echo esc_attr($item['question'] ?? ''); ?>" style="width:100%;margin-bottom:8px" />
                <p style="margin:0 0 6px"><strong>Odpowiedz:</strong></p>
                <textarea name="fitmedica_faq[<?php echo $i; ?>][answer]" rows="3" style="width:100%"><?php echo esc_textarea($item['answer'] ?? ''); ?></textarea>
                <button type="button" class="button fitmedica-remove-row" style="margin-top:6px;color:#a00">Usun</button>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="button button-primary" id="fitmedica-add-faq">+ Dodaj pytanie</button>
    </div>
    <script>
    (function(){
        var container = document.getElementById('fitmedica-faq-items');
        var idx = container.querySelectorAll('.fitmedica-faq-row').length;

        document.getElementById('fitmedica-add-faq').addEventListener('click', function(){
            var row = document.createElement('div');
            row.className = 'fitmedica-faq-row';
            row.style.cssText = 'border:1px solid #ddd;padding:10px;margin-bottom:8px;background:#f9f9f9;border-radius:4px';
            row.innerHTML = '<p style="margin:0 0 6px"><strong>Pytanie:</strong></p>'
                + '<input type="text" name="fitmedica_faq['+idx+'][question]" style="width:100%;margin-bottom:8px" />'
                + '<p style="margin:0 0 6px"><strong>Odpowiedz:</strong></p>'
                + '<textarea name="fitmedica_faq['+idx+'][answer]" rows="3" style="width:100%"></textarea>'
                + '<button type="button" class="button fitmedica-remove-row" style="margin-top:6px;color:#a00">Usun</button>';
            container.appendChild(row);
            idx++;
        });

        container.addEventListener('click', function(e){
            if(e.target.classList.contains('fitmedica-remove-row')){
                e.target.closest('.fitmedica-faq-row').remove();
            }
        });
    })();
    </script>
    <?php
}

/* -----------------------------------------------
   META BOX - Zrodla repeater
   ----------------------------------------------- */

function fitmedica_sources_meta_box_html($post) {
    $sources = get_post_meta($post->ID, '_fitmedica_sources', true);
    if (!is_array($sources)) $sources = [];
    ?>
    <div id="fitmedica-sources-repeater">
        <p style="color:#666;margin-top:0">Format: Autorzy, Tytul, Wydawnictwo/Czasopismo, Notatka (np. rok, DOI)</p>
        <div id="fitmedica-sources-items">
            <?php foreach ($sources as $i => $item): ?>
            <div class="fitmedica-source-row" style="border:1px solid #ddd;padding:10px;margin-bottom:8px;background:#f9f9f9;border-radius:4px;display:grid;grid-template-columns:1fr 1fr;gap:6px">
                <input type="text" name="fitmedica_sources[<?php echo $i; ?>][authors]" value="<?php echo esc_attr($item['authors'] ?? ''); ?>" placeholder="Autorzy" style="width:100%" />
                <input type="text" name="fitmedica_sources[<?php echo $i; ?>][title]" value="<?php echo esc_attr($item['title'] ?? ''); ?>" placeholder="Tytul publikacji" style="width:100%" />
                <input type="text" name="fitmedica_sources[<?php echo $i; ?>][publisher]" value="<?php echo esc_attr($item['publisher'] ?? ''); ?>" placeholder="Wydawnictwo / Czasopismo" style="width:100%" />
                <input type="text" name="fitmedica_sources[<?php echo $i; ?>][note]" value="<?php echo esc_attr($item['note'] ?? ''); ?>" placeholder="Rok, DOI, uwagi" style="width:100%" />
                <button type="button" class="button fitmedica-remove-source" style="color:#a00;grid-column:span 2;width:fit-content">Usun</button>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="button button-primary" id="fitmedica-add-source">+ Dodaj zrodlo</button>
    </div>
    <script>
    (function(){
        var container = document.getElementById('fitmedica-sources-items');
        var idx = container.querySelectorAll('.fitmedica-source-row').length;

        document.getElementById('fitmedica-add-source').addEventListener('click', function(){
            var row = document.createElement('div');
            row.className = 'fitmedica-source-row';
            row.style.cssText = 'border:1px solid #ddd;padding:10px;margin-bottom:8px;background:#f9f9f9;border-radius:4px;display:grid;grid-template-columns:1fr 1fr;gap:6px';
            row.innerHTML = '<input type="text" name="fitmedica_sources['+idx+'][authors]" placeholder="Autorzy" style="width:100%" />'
                + '<input type="text" name="fitmedica_sources['+idx+'][title]" placeholder="Tytul publikacji" style="width:100%" />'
                + '<input type="text" name="fitmedica_sources['+idx+'][publisher]" placeholder="Wydawnictwo / Czasopismo" style="width:100%" />'
                + '<input type="text" name="fitmedica_sources['+idx+'][note]" placeholder="Rok, DOI, uwagi" style="width:100%" />'
                + '<button type="button" class="button fitmedica-remove-source" style="color:#a00;grid-column:span 2;width:fit-content">Usun</button>';
            container.appendChild(row);
            idx++;
        });

        container.addEventListener('click', function(e){
            if(e.target.classList.contains('fitmedica-remove-source')){
                e.target.closest('.fitmedica-source-row').remove();
            }
        });
    })();
    </script>
    <?php
}

/* -----------------------------------------------
   SAVE - wszystkie meta boxy
   ----------------------------------------------- */

add_action('save_post', function ($post_id) {
    if (!isset($_POST['_fitmedica_nonce'])) return;
    if (!wp_verify_nonce($_POST['_fitmedica_nonce'], 'fitmedica_reviewer_save')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    // Reviewer
    $reviewer = sanitize_text_field($_POST['medical_reviewer'] ?? '');
    $date     = sanitize_text_field($_POST['medical_review_date'] ?? '');
    update_post_meta($post_id, '_medical_reviewer', $reviewer);
    update_post_meta($post_id, '_medical_review_date', $date);

    // FAQ
    $faq_raw = $_POST['fitmedica_faq'] ?? [];
    $faq = [];
    if (is_array($faq_raw)) {
        foreach ($faq_raw as $item) {
            $q = sanitize_text_field($item['question'] ?? '');
            $a = wp_kses_post($item['answer'] ?? '');
            if ($q && $a) {
                $faq[] = ['question' => $q, 'answer' => $a];
            }
        }
    }
    update_post_meta($post_id, '_fitmedica_faq', $faq);

    // Sources
    $src_raw = $_POST['fitmedica_sources'] ?? [];
    $sources = [];
    if (is_array($src_raw)) {
        foreach ($src_raw as $item) {
            $authors   = sanitize_text_field($item['authors'] ?? '');
            $title     = sanitize_text_field($item['title'] ?? '');
            $publisher = sanitize_text_field($item['publisher'] ?? '');
            $note      = sanitize_text_field($item['note'] ?? '');
            if ($title) {
                $sources[] = compact('authors', 'title', 'publisher', 'note');
            }
        }
    }
    update_post_meta($post_id, '_fitmedica_sources', $sources);
});

/* -----------------------------------------------
   FRONT - FAQ + Zrodla + Badge pod trescia
   ----------------------------------------------- */

add_filter('the_content', function ($content) {
    if (!is_singular('post') || !in_the_loop() || !is_main_query()) {
        return $content;
    }

    $post_id = get_the_ID();

    // --- Zrodla (PRZED FAQ - zachowanie kolejnosci z istniejacych artykulow) ---
    $sources = get_post_meta($post_id, '_fitmedica_sources', true);
    if (is_array($sources) && !empty($sources)) {
        $count = count($sources);
        $src_html = '<div class="sources-container netim">';
        $src_html .= '<div class="sources-header">';
        $src_html .= '<span class="sources-label">Zrodla</span>';
        $src_html .= '<span class="sources-count">' . $count . ' ' . ($count === 1 ? 'pozycja' : ($count < 5 ? 'pozycje' : 'pozycji')) . '</span>';
        $src_html .= '</div>';
        $src_html .= '<ol class="sources-list">';
        foreach ($sources as $src) {
            $src_html .= '<li class="source-item"><span class="source-content">';
            $parts = [];
            if (!empty($src['authors'])) $parts[] = '<span class="source-authors">' . esc_html($src['authors']) . '</span>';
            if (!empty($src['title']))   $parts[] = '<span class="source-title">' . esc_html($src['title']) . '</span>';
            if (!empty($src['publisher'])) $parts[] = '<span class="source-publisher">' . esc_html($src['publisher']) . '</span>';
            if (!empty($src['note']))    $parts[] = '<span class="source-note">' . esc_html($src['note']) . '</span>';
            $src_html .= implode(', ', $parts);
            $src_html .= '</span></li>';
        }
        $src_html .= '</ol></div>';
        $content .= $src_html;
    }

    // --- FAQ ---
    $faq = get_post_meta($post_id, '_fitmedica_faq', true);
    if (is_array($faq) && !empty($faq)) {
        $faq_html = '<div class="faq-container netim">';
        $faq_html .= '<div class="faq-accordion">';
        foreach ($faq as $item) {
            $q = esc_html($item['question']);
            $a = wp_kses_post($item['answer']);
            $faq_html .= '<div class="faq-item">';
            $faq_html .= '<button class="faq-question">' . $q . '</button>';
            $faq_html .= '<div class="faq-answer"><div><p>' . $a . '</p></div></div>';
            $faq_html .= '</div>';
        }
        $faq_html .= '</div></div>';
        $content .= $faq_html;
    }

    // --- Badge lekarza ---
    $slug = get_post_meta($post_id, '_medical_reviewer', true);
    if (!empty($slug)) {
        $doctors = fitmedica_get_doctors();
        if (isset($doctors[$slug])) {
            $doc      = $doctors[$slug];
            $date_raw = get_post_meta($post_id, '_medical_review_date', true);

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

            $content .= <<<HTML
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
        }
    }

    return $content;
}, 20);

/* -----------------------------------------------
   CSS
   ----------------------------------------------- */

add_action('wp_footer', function () {
    if (!is_singular('post')) return;
    ?>
<style>
/* --- Zrodla --- */
.sources-container.netim{margin:32px 0;padding:20px 24px;background:#f8fafc;border-radius:10px;border-left:3px solid #2563eb}
.sources-container.netim .sources-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;padding-bottom:10px;border-bottom:1px solid #e2e8f0}
.sources-container.netim .sources-label{font-size:15px;font-weight:700;color:#1e3a8a;letter-spacing:.04em;text-transform:uppercase}
.sources-container.netim .sources-count{font-size:12px;color:#64748b;font-weight:500}
.sources-container.netim .sources-list{list-style:none;counter-reset:source-counter;padding:0;margin:0;display:flex;flex-direction:column;gap:8px}
.sources-container.netim .source-item{counter-increment:source-counter;position:relative;padding:10px 14px 10px 42px;background:#fff;border-radius:6px;border:1px solid #e2e8f0;font-size:13.5px;line-height:1.5;transition:border-color .2s ease}
.sources-container.netim .source-item:hover{border-color:#93c5fd}
.sources-container.netim .source-item::before{content:counter(source-counter);position:absolute;left:10px;top:50%;transform:translateY(-50%);width:24px;height:24px;background:#2563eb;color:#fff;border-radius:5px;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px}
.sources-container.netim .source-content{color:#334155}
.sources-container.netim .source-authors{font-weight:700;color:#0f172a}
.sources-container.netim .source-title{font-style:italic;color:#1e40af}
.sources-container.netim .source-publisher{color:#64748b}
.sources-container.netim .source-note{color:#64748b;font-size:12.5px}
/* --- FAQ --- */
.faq-container.netim{margin:40px 0}
.faq-container.netim .faq-accordion{display:flex;flex-direction:column;gap:12px}
.faq-container.netim .faq-item{background:#fff;border:1px solid #e2e8f0;border-radius:10px;overflow:hidden;transition:all .25s ease}
.faq-container.netim .faq-item:hover{border-color:#93c5fd;box-shadow:0 4px 16px rgba(37,99,235,.06)}
.faq-container.netim .faq-question{width:100%;text-align:left;padding:20px 56px 20px 24px;background:transparent;border:none;font-size:16px;font-weight:600;color:#0f172a;cursor:pointer;position:relative;line-height:1.5;transition:background .2s ease;font-family:inherit}
.faq-container.netim .faq-question:hover{background:#f8fafc}
.faq-container.netim .faq-question::after{content:'+';position:absolute;right:20px;top:50%;transform:translateY(-50%);width:28px;height:28px;background:#2563eb;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:400;line-height:1;transition:transform .3s ease,background .2s ease}
.faq-container.netim .faq-question.active::after{content:'\2212';transform:translateY(-50%) rotate(180deg);background:#1e3a8a}
.faq-container.netim .faq-question.active{background-color:#ff6b35;color:#fff}
.faq-container.netim .faq-answer{max-height:0;overflow:hidden;transition:max-height .35s ease}
.faq-container.netim .faq-answer.active{max-height:1000px}
.faq-container.netim .faq-answer>div{padding:0 24px 22px;border-top:1px solid #f1f5f9;padding-top:18px}
.faq-container.netim .faq-answer p{margin:0;font-size:15px;line-height:1.7;color:#475569}
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
@media(max-width:640px){
    .sources-container.netim{padding:16px 18px}
    .sources-container.netim .source-item{padding:10px 12px 10px 38px;font-size:13px}
    .faq-container.netim .faq-question{padding:16px 48px 16px 18px;font-size:15px}
    .faq-container.netim .faq-answer>div{padding:16px 18px 18px}
}
@media(max-width:480px){
    .medical-verification{flex-direction:column;text-align:center;gap:14px;padding:22px}
    .medical-verification .mv-photo{width:80px;height:80px;min-width:80px}
    .medical-verification .mv-badge{margin:0 auto 4px}
}
</style>
    <?php
});

/* -----------------------------------------------
   JS - FAQ accordion
   ----------------------------------------------- */

add_action('wp_footer', function () {
    if (!is_singular('post')) return;
    $faq = get_post_meta(get_the_ID(), '_fitmedica_faq', true);
    if (!is_array($faq) || empty($faq)) return;
    ?>
<script>
(function(){
    document.querySelectorAll('.faq-container.netim .faq-question').forEach(function(btn){
        btn.addEventListener('click', function(){
            var isActive = this.classList.contains('active');
            this.classList.toggle('active');
            this.nextElementSibling.classList.toggle('active');
        });
    });
})();
</script>
    <?php
});

/* -----------------------------------------------
   REST API - zapis FAQ i zrodel programowo
   ----------------------------------------------- */

add_action('rest_api_init', function () {
    register_rest_route('fitmedica/v1', '/update-meta/(?P<id>\d+)', [
        'methods'  => 'POST',
        'callback' => 'fitmedica_rest_update_meta',
        'permission_callback' => function () {
            return current_user_can('edit_posts');
        },
    ]);
});

function fitmedica_rest_update_meta($request) {
    $post_id = (int) $request['id'];
    if (!get_post($post_id)) {
        return new WP_Error('not_found', 'Post not found', ['status' => 404]);
    }

    $result = [];

    if (isset($request['faq'])) {
        $faq = [];
        foreach ($request['faq'] as $item) {
            $q = sanitize_text_field($item['question'] ?? '');
            $a = wp_kses_post($item['answer'] ?? '');
            if ($q && $a) {
                $faq[] = ['question' => $q, 'answer' => $a];
            }
        }
        update_post_meta($post_id, '_fitmedica_faq', $faq);
        $result['faq_count'] = count($faq);
    }

    if (isset($request['sources'])) {
        $sources = [];
        foreach ($request['sources'] as $item) {
            $title = sanitize_text_field($item['title'] ?? '');
            if ($title) {
                $sources[] = [
                    'authors'   => sanitize_text_field($item['authors'] ?? ''),
                    'title'     => $title,
                    'publisher' => sanitize_text_field($item['publisher'] ?? ''),
                    'note'      => sanitize_text_field($item['note'] ?? ''),
                ];
            }
        }
        update_post_meta($post_id, '_fitmedica_sources', $sources);
        $result['sources_count'] = count($sources);
    }

    if (isset($request['reviewer'])) {
        update_post_meta($post_id, '_medical_reviewer', sanitize_text_field($request['reviewer']));
        $result['reviewer'] = $request['reviewer'];
    }

    if (isset($request['review_date'])) {
        update_post_meta($post_id, '_medical_review_date', sanitize_text_field($request['review_date']));
        $result['review_date'] = $request['review_date'];
    }

    return ['success' => true, 'post_id' => $post_id] + $result;
}

/* -----------------------------------------------
   Schema.org - MedicalWebPage + FAQPage
   ----------------------------------------------- */

add_action('wp_head', function () {
    if (!is_singular('post')) return;

    global $post;
    $slug = get_post_meta($post->ID, '_medical_reviewer', true);

    // MedicalWebPage schema (jesli jest reviewer)
    if (!empty($slug)) {
        $doctors = fitmedica_get_doctors();
        if (isset($doctors[$slug])) {
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
        }
    }

    // FAQPage schema (jesli sa FAQ)
    $faq = get_post_meta($post->ID, '_fitmedica_faq', true);
    if (is_array($faq) && !empty($faq)) {
        $faq_entities = [];
        foreach ($faq as $item) {
            $faq_entities[] = [
                '@type' => 'Question',
                'name'  => $item['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => wp_strip_all_tags($item['answer']),
                ],
            ];
        }

        $faq_schema = [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => $faq_entities,
        ];

        echo '<script type="application/ld+json">'
           . wp_json_encode($faq_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
           . "</script>\n";
    }
});
