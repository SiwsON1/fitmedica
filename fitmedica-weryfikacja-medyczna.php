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

/* -----------------------------------------------
   AUTO-SETUP FAQ + ZRODLA - partia ortopedyczna v4
   (chondromalacja rzepki, lakotka, korzonki,
   dyskopatia, palec zatrzaskujacy). Bez weryfikatora.
   Uruchamia sie raz.
   ----------------------------------------------- */

add_action('init', function () {
    if (get_option('fitmedica_faq_setup_v4')) return;

    $articles = [
        'chondromalacja-rzepki-kolana-leczenie-przyczyny-objawy' => [
            'faq' => [
                [
                    'question' => 'Czym jest chondromalacja rzepki?',
                    'answer'   => 'To rozmiękanie i uszkodzenie chrząstki pokrywającej tylną powierzchnię rzepki, które prowadzi do bólu z przodu kolana. Chrząstka traci gładkość, pojawiają się szczeliny i ubytki. Problem częściej dotyczy młodych, aktywnych osób i kobiet. Stopień uszkodzenia ocenia się w czterostopniowej skali Outerbridge, od rozmiękania po ubytek z odsłonięciem kości.',
                ],
                [
                    'question' => 'Jakie są objawy chondromalacji rzepki?',
                    'answer'   => 'Typowy jest tępy ból z przodu kolana, nasilający się przy wchodzeniu i schodzeniu po schodach, kucaniu oraz długim siedzeniu ze zgiętym kolanem. Częste są trzeszczenia i przeskakiwania podczas ruchu, uczucie sztywności po dłuższym bezruchu, czasem obrzęk. Dolegliwości narastają przy przeciążeniu stawu.',
                ],
                [
                    'question' => 'Jak rozpoznaje się chondromalację rzepki?',
                    'answer'   => 'Podstawą jest badanie kolana i wywiad, uzupełnione badaniami obrazowymi. Najwięcej informacji o stanie chrząstki daje rezonans magnetyczny (MRI). RTG i USG bywają pomocnicze, a najdokładniejszą, bezpośrednią ocenę umożliwia artroskopia, stosowana jednak głównie przy planowaniu zabiegu.',
                ],
                [
                    'question' => 'Czy chondromalacja rzepki się cofa?',
                    'answer'   => 'Sama chrząstka nie regeneruje się samoistnie, bo nie ma własnego ukrwienia ani unerwienia. Dlatego celem leczenia nie jest odbudowa chrząstki, ale zatrzymanie postępu, zmniejszenie bólu i poprawa funkcji kolana. We wczesnych stopniach konsekwentna rehabilitacja często pozwala wrócić do aktywności bez dolegliwości.',
                ],
                [
                    'question' => 'Jak leczy się chondromalację i czy potrzebna jest operacja?',
                    'answer'   => 'W stopniach I-II podstawą jest leczenie zachowawcze: fizjoterapia, wzmacnianie mięśni uda (zwłaszcza czworogłowego) i biodra, korekta wzorców ruchowych, czasem taping czy orteza. Operację, na przykład chondroplastykę artroskopową, rozważa się przy zaawansowanych uszkodzeniach lub gdy leczenie zachowawcze nie pomaga.',
                ],
                [
                    'question' => 'Czy z chondromalacją rzepki można ćwiczyć?',
                    'answer'   => 'Tak, ruch jest wręcz potrzebny, ale dobrany tak, by nie przeciążać rzepki. Unika się głębokich przysiadów i ćwiczeń z dużym zgięciem pod obciążeniem, a stawia na wzmacnianie mięśni i aktywności o niskim nacisku na staw, jak jazda na rowerze w umiarkowanym zakresie ruchu czy pływanie. Plan najlepiej ułożyć z fizjoterapeutą.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Willy R.W., Hoglund L.T., Barton C.J. i wsp.',
                    'title'     => 'Patellofemoral Pain: Clinical Practice Guidelines Revision 2019',
                    'publisher' => 'Journal of Orthopaedic & Sports Physical Therapy',
                    'note'      => '2019; 49(9): CPG1-CPG95',
                ],
                [
                    'authors'   => 'Collins N.J., Barton C.J., van Middelkoop M. i wsp.',
                    'title'     => '2018 Consensus statement on exercise therapy and physical interventions to treat patellofemoral pain',
                    'publisher' => 'British Journal of Sports Medicine',
                    'note'      => '2018; 52(18): 1170-1178',
                ],
                [
                    'authors'   => 'American Academy of Orthopaedic Surgeons',
                    'title'     => 'Patellofemoral Pain Syndrome',
                    'publisher' => 'OrthoInfo (AAOS)',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'lakotka-lekotka-czyli-najczestsze-uszkodzenia-powodujace-bol-kolana' => [
            'faq' => [
                [
                    'question' => 'Czym jest łąkotka i jaką pełni rolę?',
                    'answer'   => 'Łąkotki to dwa chrzęstne amortyzatory w kolanie (przyśrodkowa i boczna), leżące między kością udową a piszczelą. Rozkładają obciążenia, stabilizują staw i chronią chrząstkę. Przenoszą znaczną część nacisku w kolanie, dlatego ich uszkodzenie odbija się na całym stawie.',
                ],
                [
                    'question' => 'Jak dochodzi do uszkodzenia łąkotki?',
                    'answer'   => 'U młodszych zwykle podczas urazu skrętnego, gdy zgięte kolano obraca się przy ustabilizowanej stopie, na przykład w sporcie. U osób starszych łąkotka bywa osłabiona zmianami zwyrodnieniowymi i pęka przy codziennych czynnościach, jak wstawanie czy schodzenie po schodach. Uszkodzenie może być nagłe albo narastać z mikrourazów.',
                ],
                [
                    'question' => 'Po czym poznać uszkodzoną łąkotkę?',
                    'answer'   => 'Charakterystyczny jest ból w szparze stawu, uczucie blokowania lub zacinania kolana, czasem przeskakiwanie i niestabilność. Często pojawia się obrzęk i ograniczenie pełnego wyprostu lub zgięcia. Objawy nasilają się przy skręcaniu i kucaniu.',
                ],
                [
                    'question' => 'Jakie badanie potwierdza uszkodzenie łąkotki?',
                    'answer'   => 'Po badaniu kolana z testami prowokacyjnymi najwięcej wnosi rezonans magnetyczny (MRI), który pokazuje rodzaj i lokalizację pęknięcia oraz inne uszkodzenia, na przykład więzadeł. USG bywa pomocnicze. Dokładną ocenę i jednoczesne leczenie umożliwia artroskopia.',
                ],
                [
                    'question' => 'Czy uszkodzoną łąkotkę zawsze trzeba operować?',
                    'answer'   => 'Nie. Część uszkodzeń, zwłaszcza degeneracyjnych i bez blokowania kolana, leczy się zachowawczo: odciążeniem, lekami i rehabilitacją. Gdy potrzebny jest zabieg, dąży się dziś do zachowania łąkotki przez jej zeszycie, jeśli rodzaj i lokalizacja pęknięcia na to pozwalają, a usunięcie fragmentu ogranicza do koniecznego minimum.',
                ],
                [
                    'question' => 'Ile trwa powrót do sprawności po urazie łąkotki?',
                    'answer'   => 'Przy niewielkich uszkodzeniach leczonych zachowawczo zwykle kilka tygodni, przy poważniejszych i po zabiegu kilka miesięcy. Tempo zależy od rodzaju uszkodzenia oraz tego, czy łąkotkę zszyto, czy usunięto jej fragment. Kluczowa dla pełnego powrotu jest rehabilitacja.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Beaufils P., Becker R., Kopf S., Pujol N. i wsp.',
                    'title'     => 'The knee meniscus: management of traumatic tears and degenerative lesions',
                    'publisher' => 'EFORT Open Reviews',
                    'note'      => '2017; 2(5): 195-203',
                ],
                [
                    'authors'   => 'American Academy of Orthopaedic Surgeons',
                    'title'     => 'Meniscus Tears',
                    'publisher' => 'OrthoInfo (AAOS)',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'korzonki-co-to-jest-i-jak-skutecznie-leczyc-bol-korzeni-nerwowych' => [
            'faq' => [
                [
                    'question' => 'Co to są korzonki?',
                    'answer'   => 'To potoczna nazwa bólu wynikającego z podrażnienia lub ucisku korzeni nerwowych wychodzących z rdzenia kręgowego, czyli radikulopatii. Ponieważ korzenie przewodzą impulsy do kończyn, ból promieniuje poza sam kręgosłup, na przykład do nogi (rwa kulszowa) lub ręki.',
                ],
                [
                    'question' => 'Jakie są objawy korzonków?',
                    'answer'   => 'Najczęściej silny ból promieniujący wzdłuż kończyny, któremu towarzyszą mrowienie, drętwienie, czasem osłabienie siły mięśni i ograniczona ruchomość kręgosłupa. Ból bywa ostry, nasila się przy ruchu, kaszlu czy kichaniu. Rozkład objawów wskazuje, który korzeń jest uciśnięty.',
                ],
                [
                    'question' => 'Co najczęściej wywołuje ból korzonków?',
                    'answer'   => 'Zwykle przyczyny mechaniczne: przepuklina krążka międzykręgowego uciskająca korzeń, zmiany zwyrodnieniowe kręgosłupa, przeciążenia i urazy. Rzadziej stoją za tym infekcje, choroby ogólnoustrojowe czy zmiany nowotworowe, dlatego utrzymujący się ból warto zdiagnozować.',
                ],
                [
                    'question' => 'Jak diagnozuje się korzonki?',
                    'answer'   => 'Podstawą jest badanie neurologiczne i wywiad, które lokalizują uciśnięty korzeń. Przy nasilonych lub utrzymujących się objawach wykonuje się rezonans magnetyczny (MRI), najlepiej pokazujący krążki i korzenie nerwowe. RTG i tomografia bywają uzupełnieniem.',
                ],
                [
                    'question' => 'Jak leczy się ból korzonków?',
                    'answer'   => 'U większości pacjentów wystarcza leczenie zachowawcze: leki przeciwbólowe i przeciwzapalne, utrzymanie aktywności w miarę możliwości zamiast leżenia, fizjoterapia i nauka ergonomii. Operację rozważa się głównie przy nasilających się objawach neurologicznych lub gdy leczenie zachowawcze nie pomaga.',
                ],
                [
                    'question' => 'Kiedy z bólem korzonków zgłosić się pilnie do lekarza?',
                    'answer'   => 'Niepokojące są: narastające osłabienie nogi lub ręki, drętwienie okolicy krocza, zaburzenia oddawania moczu lub stolca oraz silny ból po urazie. Takie objawy mogą oznaczać poważny ucisk i wymagają szybkiej konsultacji, a nie czekania, aż samo przejdzie.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'National Institute for Health and Care Excellence (NICE)',
                    'title'     => 'Low back pain and sciatica in over 16s: assessment and management (NG59)',
                    'publisher' => 'NICE',
                    'note'      => '2016, aktualizacja 2020',
                ],
                [
                    'authors'   => 'Kreiner D.S. i wsp.',
                    'title'     => 'An evidence-based clinical guideline for the diagnosis and treatment of lumbar disc herniation with radiculopathy',
                    'publisher' => 'The Spine Journal',
                    'note'      => '2014; 14(1): 180-191',
                ],
                [
                    'authors'   => 'American Academy of Orthopaedic Surgeons',
                    'title'     => 'Herniated Disk in the Lower Back',
                    'publisher' => 'OrthoInfo (AAOS)',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'dyskopatia-diagnoza-i-leczenie' => [
            'faq' => [
                [
                    'question' => 'Czym jest dyskopatia?',
                    'answer'   => 'To choroba krążków międzykręgowych, w której krążek ulega degeneracji lub przemieszczeniu i może uciskać struktury nerwowe. Potocznie mówi się o wypadnięciu dysku lub przepuklinie. Najczęściej dotyczy odcinka lędźwiowego, zwłaszcza poziomu L5-S1, który dźwiga największe obciążenia.',
                ],
                [
                    'question' => 'Czy dyskopatia to to samo co przepuklina?',
                    'answer'   => 'Nie do końca. Dyskopatia to szersze pojęcie obejmujące zmiany w krążku, a przepuklina to jeden z jej etapów. Zmiany dzieli się zwykle na degenerację, protruzję (uwypuklenie), ekstruzję (przerwanie pierścienia) i sekwestrację (oderwanie fragmentu jądra). Im dalszy etap, tym większe ryzyko ucisku na nerw.',
                ],
                [
                    'question' => 'Jakie objawy daje dyskopatia?',
                    'answer'   => 'Objawy zależą od odcinka i tego, czy uciskany jest nerw. Typowy jest ból kręgosłupa, często promieniujący do kończyny, z mrowieniem, drętwieniem i osłabieniem siły. W odcinku lędźwiowym ból schodzi do nogi, w szyjnym do ręki. Część zmian przebiega długo bez wyraźnych dolegliwości.',
                ],
                [
                    'question' => 'Jak diagnozuje się dyskopatię?',
                    'answer'   => 'Najwięcej pokazuje rezonans magnetyczny (MRI), który dobrze obrazuje krążki, ich przemieszczenie i ucisk na korzenie. Tomografia komputerowa ocenia struktury kostne, a badanie EMG pomaga ocenić funkcję nerwów. Wynik badania zawsze zestawia się z objawami pacjenta.',
                ],
                [
                    'question' => 'Jak leczy się dyskopatię i kiedy potrzebna jest operacja?',
                    'answer'   => 'U większości pacjentów podstawą jest leczenie zachowawcze: farmakoterapia, fizjoterapia i kinezyterapia, terapia manualna, czasem iniekcje, oraz nauka prawidłowych obciążeń. Operację rozważa się głównie przy nasilonych, utrzymujących się objawach neurologicznych lub gdy leczenie zachowawcze zawodzi, a nie rutynowo na sam obraz z MRI.',
                ],
                [
                    'question' => 'Jak zapobiegać dyskopatii i jej nawrotom?',
                    'answer'   => 'Najwięcej daje regularny, rozsądny ruch wzmacniający mięśnie tułowia (pomocne jest pływanie), dbanie o prawidłową postawę i ergonomię przy pracy oraz unikanie dźwigania z okrągłymi plecami. Pomaga też utrzymanie prawidłowej masy ciała i odpowiednie miejsce do spania.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Kreiner D.S. i wsp.',
                    'title'     => 'An evidence-based clinical guideline for the diagnosis and treatment of lumbar disc herniation with radiculopathy',
                    'publisher' => 'The Spine Journal',
                    'note'      => '2014; 14(1): 180-191',
                ],
                [
                    'authors'   => 'National Institute for Health and Care Excellence (NICE)',
                    'title'     => 'Low back pain and sciatica in over 16s: assessment and management (NG59)',
                    'publisher' => 'NICE',
                    'note'      => '2016, aktualizacja 2020',
                ],
                [
                    'authors'   => 'American Academy of Orthopaedic Surgeons',
                    'title'     => 'Herniated Disk in the Lower Back',
                    'publisher' => 'OrthoInfo (AAOS)',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'palec-zatrzaskujacy-czym-jest-i-dlaczego-dochodzi-do-blokowania-palca' => [
            'faq' => [
                [
                    'question' => 'Czym jest palec zatrzaskujący?',
                    'answer'   => 'To schorzenie ścięgien zginaczy palca, w którym ścięgno z trudem przesuwa się pod troczkiem A1 u podstawy palca. Powstaje zwężenie i stan zapalny, przez co palec blokuje się i przeskakuje przy zginaniu oraz prostowaniu. Stąd nazwa palec zatrzaskujący lub trzaskający.',
                ],
                [
                    'question' => 'Jakie są objawy palca zatrzaskującego?',
                    'answer'   => 'Typowy jest ból i tkliwość u podstawy palca po stronie dłoniowej, uczucie blokowania oraz trzask lub kliknięcie podczas ruchu. Często dochodzi sztywność po odpoczynku, zwłaszcza rano. W zaawansowanym stadium palec potrafi zablokować się w zgięciu i trudno go wyprostować.',
                ],
                [
                    'question' => 'Kto jest najbardziej narażony na palec zatrzaskujący?',
                    'answer'   => 'Częściej dotyczy kobiet oraz osób między 40. a 60. rokiem życia. Ryzyko zwiększają powtarzalne, silne chwyty i przeciążenia dłoni, a także cukrzyca, choroby tarczycy oraz schorzenia reumatyczne. U osób z cukrzycą problem bywa bardziej oporny na leczenie.',
                ],
                [
                    'question' => 'Jak rozpoznaje się palec zatrzaskujący?',
                    'answer'   => 'Rozpoznanie stawia się zwykle na podstawie badania dłoni i wywiadu, bez konieczności badań obrazowych. Lekarz ocenia bolesność troczka, wyczuwalne przeskakiwanie ścięgna i zakres ruchu palca. USG bywa pomocne w sytuacjach wątpliwych lub przed zabiegiem.',
                ],
                [
                    'question' => 'Jak leczy się palec zatrzaskujący bez operacji?',
                    'answer'   => 'We wczesnym stadium pomaga odciążenie, unieruchomienie palca w szynie, leki przeciwzapalne i fizjoterapia. Skuteczną metodą jest iniekcja sterydu do pochewki ścięgna, która zmniejsza obrzęk i poprawia ślizg. Część pacjentów wymaga powtórzenia zastrzyku, a efekt bywa trwalszy w łagodniejszych przypadkach.',
                ],
                [
                    'question' => 'Na czym polega operacja palca zatrzaskującego?',
                    'answer'   => 'Gdy leczenie zachowawcze nie pomaga, wykonuje się drobny zabieg przecięcia troczka A1 w znieczuleniu miejscowym, zwykle bez hospitalizacji. Uwolnione ścięgno odzyskuje swobodny ślizg, a blokowanie ustępuje. Po zabiegu zaleca się wczesne ruchy palca, by zapobiec zrostom.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Makkouk A.H., Oetgen M.E., Swigart C.R., Dodds S.D.',
                    'title'     => 'Trigger finger: etiology, evaluation, and treatment',
                    'publisher' => 'Current Reviews in Musculoskeletal Medicine',
                    'note'      => '2008; 1(2): 92-96',
                ],
                [
                    'authors'   => 'American Academy of Orthopaedic Surgeons',
                    'title'     => 'Trigger Finger',
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

    update_option('fitmedica_faq_setup_v4', true);
});

/* -----------------------------------------------
   AUTO-SETUP FAQ + ZRODLA - partia v5
   (osteoporoza, choroba zwyrodnieniowa stawow,
   skolioza, ACL, choroba Dupuytrena). Bez weryfikatora.
   Uruchamia sie raz.
   ----------------------------------------------- */

add_action('init', function () {
    if (get_option('fitmedica_faq_setup_v5')) return;

    $articles = [
        'czym-jest-osteoporoza' => [
            'faq' => [
                [
                    'question' => 'Czym jest osteoporoza?',
                    'answer'   => 'To przewlekła choroba kości, w której postępuje ubytek masy kostnej, a kości stają się słabsze i bardziej podatne na złamania. Przez długi czas przebiega bezobjawowo, dlatego bywa nazywana cichą chorobą. Często pierwszym sygnałem jest dopiero złamanie po niewielkim urazie.',
                ],
                [
                    'question' => 'Jakie są czynniki ryzyka osteoporozy?',
                    'answer'   => 'Najwięcej zachorowań dotyczy kobiet po menopauzie, kiedy spada poziom estrogenów, oraz osób po 65-70 roku życia. Ryzyko zwiększają też obciążenia rodzinne, mała aktywność fizyczna, palenie i nadużywanie alkoholu, a także niedobory wapnia i witaminy D. Część leków, na przykład sterydów, również osłabia kości.',
                ],
                [
                    'question' => 'Jak rozpoznaje się osteoporozę?',
                    'answer'   => 'Podstawowym badaniem jest densytometria (DXA), która ocenia gęstość mineralną kości i trwa kilka minut. Wynik zestawia się z czynnikami ryzyka i ewentualnymi przebytymi złamaniami. Lekarz może zlecić też badania krwi, by wykluczyć inne przyczyny osłabienia kości.',
                ],
                [
                    'question' => 'Jak leczy się osteoporozę?',
                    'answer'   => 'Leczenie łączy farmakoterapię z modyfikacją stylu życia. Stosuje się między innymi bisfosfoniany i denosumab, które hamują utratę kości, a w cięższych przypadkach leki anaboliczne pobudzające jej tworzenie. Podstawą pozostają odpowiednia podaż wapnia i witaminy D oraz regularna aktywność fizyczna. Dobór leku należy do lekarza.',
                ],
                [
                    'question' => 'Jak zapobiegać osteoporozie i złamaniom?',
                    'answer'   => 'Najwięcej daje ruch obciążający kości (spacery, trening siłowy), dieta bogata w wapń, odpowiedni poziom witaminy D oraz rezygnacja z palenia i nadmiaru alkoholu. U osób starszych ważne jest też zapobieganie upadkom, na przykład usuwanie progów i śliskich dywaników oraz dbanie o wzrok i równowagę.',
                ],
                [
                    'question' => 'Czym grozi nieleczona osteoporoza?',
                    'answer'   => 'Głównym zagrożeniem są złamania, najczęściej szyjki kości udowej, nadgarstka i kręgów, do których dochodzi nawet przy niewielkim urazie. Złamania kręgów prowadzą do bólu pleców, obniżenia wzrostu i pochylenia sylwetki. Takie urazy obniżają sprawność, dlatego osteoporozę warto wykryć i leczyć wcześnie.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Kanis J.A., Cooper C., Rizzoli R., Reginster J.Y.',
                    'title'     => 'European guidance for the diagnosis and management of osteoporosis in postmenopausal women',
                    'publisher' => 'Osteoporosis International',
                    'note'      => '2019; 30(1): 3-44',
                ],
                [
                    'authors'   => 'American Academy of Orthopaedic Surgeons',
                    'title'     => 'Osteoporosis',
                    'publisher' => 'OrthoInfo (AAOS)',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'choroba-zwyrodnieniowa-stawow' => [
            'faq' => [
                [
                    'question' => 'Czym jest choroba zwyrodnieniowa stawów?',
                    'answer'   => 'To przewlekłe, stopniowe niszczenie chrząstki stawowej, która w zdrowym stawie pozwala kościom poruszać się niemal bez tarcia. Gdy chrząstka się zużywa, dochodzi do bólu, sztywności i ograniczenia ruchu. Najczęściej dotyczy kolan, bioder i kręgosłupa.',
                ],
                [
                    'question' => 'Jakie są objawy choroby zwyrodnieniowej?',
                    'answer'   => 'Typowy jest ból stawu nasilający się przy ruchu i obciążeniu, sztywność poranna ustępująca po rozruszaniu, trzeszczenia oraz stopniowe ograniczenie zakresu ruchu. Z czasem dochodzi osłabienie mięśni wokół stawu. Dolegliwości zwykle narastają powoli, przez lata.',
                ],
                [
                    'question' => 'Co zwiększa ryzyko choroby zwyrodnieniowej stawów?',
                    'answer'   => 'Najważniejsze czynniki to wiek, nadwaga i otyłość obciążające stawy, przebyte urazy oraz ciężka praca fizyczna. Znaczenie mają też predyspozycje genetyczne, płeć i wady budowy lub osi kończyn. Nadmierne, jednostronne przeciążenia przyspieszają zużycie chrząstki.',
                ],
                [
                    'question' => 'Jak leczy się chorobę zwyrodnieniową bez operacji?',
                    'answer'   => 'Podstawą jest leczenie zachowawcze: regularne ćwiczenia wzmacniające i poprawiające ruchomość, redukcja masy ciała przy nadwadze oraz edukacja o właściwym obciążaniu stawu. Pomagają fizjoterapia, leki przeciwbólowe i przeciwzapalne, czasem iniekcje dostawowe. Ruch i kontrola wagi to fundament, na którym opierają się pozostałe metody.',
                ],
                [
                    'question' => 'Kiedy potrzebna jest operacja stawu?',
                    'answer'   => 'Operację rozważa się, gdy ból i ograniczenie sprawności utrzymują się mimo konsekwentnego leczenia zachowawczego i utrudniają codzienne funkcjonowanie. W zależności od stawu i zaawansowania zmian stosuje się artroskopię, osteotomię korygującą oś kończyny lub wymianę stawu (endoprotezoplastykę). Decyzję podejmuje się indywidualnie.',
                ],
                [
                    'question' => 'Czy chorobie zwyrodnieniowej można zapobiegać?',
                    'answer'   => 'Nie da się jej całkowicie wykluczyć, ale można spowolnić jej rozwój. Pomaga utrzymanie prawidłowej masy ciała, regularna aktywność wzmacniająca mięśnie, unikanie przeciążeń i urazów oraz dbanie o prawidłową postawę. Wczesna reakcja na ból stawu pozwala działać, zanim zmiany się utrwalą.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Bannuru R.R., Osani M.C., Vaysbrot E.E. i wsp.',
                    'title'     => 'OARSI guidelines for the non-surgical management of knee, hip, and polyarticular osteoarthritis',
                    'publisher' => 'Osteoarthritis and Cartilage',
                    'note'      => '2019; 27(11): 1578-1589',
                ],
                [
                    'authors'   => 'American Academy of Orthopaedic Surgeons',
                    'title'     => 'Arthritis of the Knee',
                    'publisher' => 'OrthoInfo (AAOS)',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'skolioza-objawy-diagnostyka-i-leczenie-od-a-do-z' => [
            'faq' => [
                [
                    'question' => 'Czym jest skolioza?',
                    'answer'   => 'To trójwymiarowa deformacja kręgosłupa, w której boczne skrzywienie wynosi co najmniej 10 stopni w pomiarze metodą Cobba i współistnieje z rotacją kręgów. Najczęstsza jest postać idiopatyczna, o nieznanej przyczynie, która stanowi około 80 procent przypadków i ujawnia się zwykle w okresie wzrostu.',
                ],
                [
                    'question' => 'Jak rozpoznać skoliozę?',
                    'answer'   => 'Pierwszym sygnałem bywa asymetria sylwetki: nierówne barki, łopatki, talia, a w skłonie do przodu widoczny garb żebrowy. W badaniu stosuje się test Adamsa (skłon w przód), a rozpoznanie i wielkość skrzywienia potwierdza zdjęcie RTG całego kręgosłupa wykonane na stojąco, na którym mierzy się kąt Cobba.',
                ],
                [
                    'question' => 'Czy każda skolioza wymaga leczenia?',
                    'answer'   => 'Nie każda. Niewielkie skrzywienia, zwykle poniżej 20 stopni, często wymagają jedynie obserwacji i okresowej kontroli, zwłaszcza by wychwycić pogłębianie się skrzywienia w okresie szybkiego wzrostu. O sposobie postępowania decydują wielkość kąta, wiek i dynamika zmian.',
                ],
                [
                    'question' => 'Na czym polega leczenie gorsetem?',
                    'answer'   => 'Gorset ortopedyczny stosuje się zwykle przy kątach około 20-40 stopni u pacjentów, którzy wciąż rosną, by zahamować pogłębianie się skrzywienia. Aby był skuteczny, trzeba go nosić przez większą część doby, zgodnie z zaleceniem. Leczenie prowadzi się pod kontrolą specjalisty, który ocenia postęp.',
                ],
                [
                    'question' => 'Czy ćwiczenia pomagają w skoliozie?',
                    'answer'   => 'Tak, pomocne są specjalistyczne ćwiczenia korekcyjne, na przykład metoda Schroth, ucząca trójwymiarowego oddychania i aktywnej autokorekty postawy. Wzmacniają mięśnie i wspierają leczenie, ale dobiera się je do rodzaju i wielkości skrzywienia. Plan powinien ułożyć fizjoterapeuta doświadczony w pracy ze skoliozą.',
                ],
                [
                    'question' => 'Kiedy skolioza wymaga operacji?',
                    'answer'   => 'Leczenie operacyjne rozważa się przy dużych skrzywieniach, zwykle powyżej 45-50 stopni, zwłaszcza gdy nadal się pogłębiają u rosnącego dziecka lub gdy u dorosłego powodują ból i pogorszenie funkcji. Decyzja jest indywidualna i zależy od wielkości kąta, wieku oraz dynamiki zmian.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Negrini S., Donzelli S., Aulisa A.G. i wsp.',
                    'title'     => '2016 SOSORT guidelines: orthopaedic and rehabilitation treatment of idiopathic scoliosis during growth',
                    'publisher' => 'Scoliosis and Spinal Disorders',
                    'note'      => '2018; 13: 3',
                ],
                [
                    'authors'   => 'American Academy of Orthopaedic Surgeons',
                    'title'     => 'Idiopathic Scoliosis in Children and Adolescents',
                    'publisher' => 'OrthoInfo (AAOS)',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'uszkodzenie-wiezadla-krzyzowego-przedniego-wkp-acl-czyli-ze-sportem' => [
            'faq' => [
                [
                    'question' => 'Czym jest więzadło krzyżowe przednie i co je uszkadza?',
                    'answer'   => 'Więzadło krzyżowe przednie (ACL) to jedno z głównych więzadeł stabilizujących kolano, które kontroluje przesuwanie i rotację stawu. Najczęściej ulega uszkodzeniu podczas nagłego skrętu kolana przy ustabilizowanej stopie, często bez kontaktu z przeciwnikiem, na przykład przy zmianie kierunku biegu lub lądowaniu.',
                ],
                [
                    'question' => 'Jak rozpoznać zerwanie ACL?',
                    'answer'   => 'Charakterystyczne jest uczucie pęknięcia lub strzału w kolanie w chwili urazu, szybki obrzęk, ból i poczucie niestabilności, jakby kolano uciekało. Lekarz potwierdza uszkodzenie testami (test Lachmana, test szuflady przedniej, pivot shift), a obraz uzupełnia rezonans magnetyczny, który pokazuje też ewentualne uszkodzenia łąkotek i chrząstki.',
                ],
                [
                    'question' => 'Czy zerwane ACL trzeba operować?',
                    'answer'   => 'Nie zawsze. Leczenie zachowawcze bywa wystarczające u osób mniej aktywnych, które nie uprawiają sportów z gwałtownymi zwrotami i u których kolano pozostaje stabilne. Rekonstrukcję zaleca się zwykle osobom aktywnym sportowo oraz przy utrzymującej się niestabilności. Część pacjentów leczonych zachowawczo z czasem i tak decyduje się na zabieg.',
                ],
                [
                    'question' => 'Na czym polega rekonstrukcja ACL?',
                    'answer'   => 'Zabieg polega na odtworzeniu więzadła z przeszczepu, najczęściej z własnych ścięgien pacjenta (ścięgno rzepki, ścięgna mięśni tylnej części uda lub mięśnia czworogłowego). Wykonuje się go artroskopowo. Badania pokazują podobne efekty niezależnie od wybranego rodzaju przeszczepu, a o doborze decyduje chirurg.',
                ],
                [
                    'question' => 'Ile trwa powrót do sportu po rekonstrukcji ACL?',
                    'answer'   => 'To zwykle wiele miesięcy konsekwentnej rehabilitacji, a nie kwestia tygodni. O powrocie decyduje nie sama data, ale odzyskanie siły, stabilności i kontroli ruchu, ocenianych testami. Zbyt wczesny powrót zwiększa ryzyko ponownego urazu, dlatego progresję ustala się indywidualnie z fizjoterapeutą.',
                ],
                [
                    'question' => 'Po co rehabilitacja przed operacją ACL?',
                    'answer'   => 'Dobre przygotowanie kolana przed zabiegiem poprawia wyniki leczenia. Celem jest zmniejszenie obrzęku, odzyskanie pełnego wyprostu i dobrego zgięcia oraz wzmocnienie mięśni, tak by siła chorej nogi zbliżyła się do zdrowej. Wprowadza się też ćwiczenia czucia głębokiego. Kolano lepiej przygotowane szybciej wraca do formy po rekonstrukcji.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Diermeier T., Rothrauff B.B., Engebretsen L. i wsp.',
                    'title'     => 'Treatment after anterior cruciate ligament injury: Panther Symposium ACL Treatment Consensus Group',
                    'publisher' => 'Knee Surgery, Sports Traumatology, Arthroscopy',
                    'note'      => '2020; 28(8): 2390-2402',
                ],
                [
                    'authors'   => 'American Academy of Orthopaedic Surgeons',
                    'title'     => 'Anterior Cruciate Ligament (ACL) Injuries',
                    'publisher' => 'OrthoInfo (AAOS)',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'choroba-duputryena-przykurcz-rozciegna-dloniowego' => [
            'faq' => [
                [
                    'question' => 'Czym jest choroba Dupuytrena?',
                    'answer'   => 'To łagodna, przewlekła choroba, w której dochodzi do nieprawidłowego rozrostu rozcięgna dłoniowego, czyli tkanki łącznej pod skórą dłoni. Powstają guzki i pasma, które stopniowo przykurczają palce w stronę dłoni. Najczęściej zajmuje palec serdeczny i mały.',
                ],
                [
                    'question' => 'Jakie są objawy choroby Dupuytrena?',
                    'answer'   => 'Na początku pojawiają się wyczuwalne guzki w dłoni, czasem tkliwe, później powrózkowate pasma pod skórą. Z czasem rozwija się przykurcz zgięciowy palca, który coraz trudniej wyprostować. Utrudnia to codzienne czynności, jak płaskie położenie dłoni na stole czy wkładanie ręki do kieszeni.',
                ],
                [
                    'question' => 'Co zwiększa ryzyko choroby Dupuytrena?',
                    'answer'   => 'Najważniejsze jest podłoże genetyczne, dlatego choroba często występuje rodzinnie. Częściej dotyczy mężczyzn po 50 roku życia. Ryzyko zwiększają też cukrzyca, nadużywanie alkoholu, palenie oraz powtarzalne mikrourazy dłoni. U kobiet przebieg bywa szybszy i trudniejszy.',
                ],
                [
                    'question' => 'Czy chorobę Dupuytrena da się wyleczyć zachowawczo?',
                    'answer'   => 'Leczenie zachowawcze nie cofa już powstałego przykurczu. We wczesnym okresie, przy małych, bolesnych guzkach, stosuje się czasem iniekcje sterydowe, ale nie zatrzymują one choroby na stałe. Gdy przykurcz utrudnia funkcję ręki, potrzebne są metody zabiegowe.',
                ],
                [
                    'question' => 'Jakie są metody zabiegowe w chorobie Dupuytrena?',
                    'answer'   => 'Stosuje się igłową aponeurotomię (przezskórne przecięcie pasma), wstrzyknięcie kolagenazy rozpuszczającej zmienione pasmo oraz operacyjne wycięcie rozcięgna (fasciektomię), które jest najczęściej stosowane. Metody polegające na samym przecięciu pasma dają szybki efekt, ale wiążą się z większym ryzykiem nawrotu niż wycięcie.',
                ],
                [
                    'question' => 'Czy choroba Dupuytrena nawraca?',
                    'answer'   => 'Tak, ma charakter postępujący i bywa nawrotowa, niezależnie od metody leczenia. Ryzyko nawrotu jest większe po zabiegach polegających na przecięciu pasma niż po jego wycięciu oraz u osób z silnym obciążeniem rodzinnym i wczesnym początkiem choroby. Dlatego potrzebna bywa obserwacja i czasem powtórne leczenie.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Shih B., Bayat A.',
                    'title'     => 'Scientific understanding and clinical management of Dupuytren disease',
                    'publisher' => 'Nature Reviews Rheumatology',
                    'note'      => '2010; 6(12): 715-726',
                ],
                [
                    'authors'   => 'American Academy of Orthopaedic Surgeons',
                    'title'     => 'Dupuytrens Disease (Dupuytrens Contracture)',
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

    update_option('fitmedica_faq_setup_v5', true);
});

/* -----------------------------------------------
   AUTO-SETUP FAQ + ZRODLA - partia v6
   (zwyrodnienie kregoslupa szyjnego, wdowi garb,
   choroba Scheuermanna, osteotomia, bol glowy a TMD).
   Bez weryfikatora. Uruchamia sie raz.
   ----------------------------------------------- */

add_action('init', function () {
    if (get_option('fitmedica_faq_setup_v6')) return;

    $articles = [
        'choroba-zwyrodnieniowa-stawow-kregoslupa-szyjnego' => [
            'faq' => [
                [
                    'question' => 'Czym jest zwyrodnienie kręgosłupa szyjnego?',
                    'answer'   => 'To związane głównie z wiekiem zużywanie się struktur odcinka szyjnego kręgosłupa: chrząstki stawowej, krążków i kości, czemu towarzyszy powstawanie wyrośli kostnych (osteofitów). Z czasem może to drażnić lub uciskać korzenie nerwowe, a w cięższych przypadkach rdzeń kręgowy. Zmiany te są bardzo częste po 60 roku życia, choć nie zawsze dają objawy.',
                ],
                [
                    'question' => 'Jakie są objawy zwyrodnienia szyjnego?',
                    'answer'   => 'Najczęściej ból i sztywność karku, ból między łopatkami oraz ograniczenie ruchomości szyi. Gdy dochodzi do ucisku nerwu, pojawiają się mrowienie, drętwienie i osłabienie siły w ręce. Częste są też bóle głowy, zwłaszcza w okolicy potylicznej. Objawy nasilają się przy długim utrzymywaniu jednej pozycji głowy.',
                ],
                [
                    'question' => 'Kiedy ból szyi wymaga pilnej konsultacji?',
                    'answer'   => 'Niepokojące jest narastające osłabienie lub drętwienie rąk, zaburzenia precyzji ruchów dłoni, problemy z chodzeniem i równowagą oraz zaburzenia kontroli pęcherza. Mogą wskazywać na ucisk rdzenia kręgowego i wymagają szybkiej oceny lekarskiej. Zwykły ból karku bez tych objawów nie jest stanem nagłym, ale też warto go zdiagnozować.',
                ],
                [
                    'question' => 'Jak diagnozuje się zwyrodnienie kręgosłupa szyjnego?',
                    'answer'   => 'Podstawą jest badanie lekarskie i ocena objawów neurologicznych. Obrazowanie zaczyna się zwykle od RTG, które pokazuje zmiany kostne i osteofity, a przy podejrzeniu ucisku nerwów lub rdzenia wykonuje się rezonans magnetyczny (MRI). Wynik badania zawsze zestawia się z dolegliwościami pacjenta.',
                ],
                [
                    'question' => 'Jak leczy się zwyrodnienie szyjne?',
                    'answer'   => 'U większości pacjentów wystarcza leczenie zachowawcze: rehabilitacja i fizjoterapia, ćwiczenia poprawiające ruchomość i wzmacniające mięśnie, zabiegi fizykalne, terapia manualna oraz doraźnie leki przeciwbólowe i przeciwzapalne. Operację rozważa się głównie przy nasilonym ucisku na nerwy lub rdzeń z objawami neurologicznymi, gdy leczenie zachowawcze nie pomaga.',
                ],
                [
                    'question' => 'Jak dbać o szyję przy zmianach zwyrodnieniowych?',
                    'answer'   => 'Pomaga regularny ruch i ćwiczenia wzmacniające mięśnie karku i obręczy barkowej, a także ergonomia pracy: ustawienie monitora na wysokości oczu, przerwy i unikanie długiego patrzenia w dół na telefon. Warto zadbać o dobrą pozycję snu i unikać gwałtownych przeciążeń szyi. Takie nawyki ograniczają nasilanie się objawów.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Theodore N.',
                    'title'     => 'Degenerative Cervical Spondylosis',
                    'publisher' => 'New England Journal of Medicine',
                    'note'      => '2020; 383(2): 159-168',
                ],
                [
                    'authors'   => 'American Academy of Orthopaedic Surgeons',
                    'title'     => 'Cervical Spondylosis (Arthritis of the Neck)',
                    'publisher' => 'OrthoInfo (AAOS)',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'wdowi-garb-co-to-jest-i-jak-skutecznie-go-leczyc' => [
            'faq' => [
                [
                    'question' => 'Czym jest wdowi garb?',
                    'answer'   => 'To potoczna nazwa nadmiernej kifozy piersiowej, czyli pogłębionego zaokrąglenia górnej części pleców, często z wyraźnym zgrubieniem w okolicy przejścia między odcinkiem szyjnym a piersiowym kręgosłupa. Towarzyszy mu zwykle wysunięcie głowy do przodu i przygarbiona sylwetka.',
                ],
                [
                    'question' => 'Skąd bierze się wdowi garb?',
                    'answer'   => 'Najczęściej z długotrwale nieprawidłowej postawy, na przykład pochylania się nad komputerem i telefonem, co osłabia mięśnie grzbietu i skraca mięśnie klatki piersiowej. Sprzyjają mu też zmiany zwyrodnieniowe i osteoporoza osłabiająca kręgi, a czasem zaburzenia hormonalne. Z wiekiem ryzyko rośnie.',
                ],
                [
                    'question' => 'Jakie objawy daje wdowi garb?',
                    'answer'   => 'Poza widocznym zaokrągleniem pleców i wysuniętą głową często pojawiają się ból i sztywność szyi, napięcie mięśni karku, ból między łopatkami oraz nawracające bóle głowy. Sylwetka staje się bardziej przygarbiona, a dłuższe utrzymanie wyprostowanej pozycji bywa męczące.',
                ],
                [
                    'question' => 'Czy wdowi garb można cofnąć?',
                    'answer'   => 'Jeśli wynika głównie z postawy i osłabienia mięśni, to konsekwentne ćwiczenia i praca nad nawykami często wyraźnie poprawiają sylwetkę. Gdy u podłoża leżą utrwalone zmiany kostne, na przykład po złamaniach w przebiegu osteoporozy, pełne wyprostowanie bywa niemożliwe, ale leczenie i tak zmniejsza dolegliwości i hamuje pogłębianie się garbu.',
                ],
                [
                    'question' => 'Jak leczy się wdowi garb?',
                    'answer'   => 'Podstawą jest postępowanie zachowawcze: ćwiczenia wzmacniające mięśnie grzbietu, rozciąganie mięśni klatki piersiowej, nauka prawidłowej postawy oraz terapia manualna, a doraźnie leki przeciwbólowe. Pomocne są proste ćwiczenia, jak cofanie brody i ściąganie łopatek. Zabieg chirurgiczny jest potrzebny rzadko.',
                ],
                [
                    'question' => 'Jak zapobiegać wdowiemu garbowi?',
                    'answer'   => 'Najwięcej daje dbanie o postawę na co dzień, regularny ruch wzmacniający plecy oraz przerwy i ergonomia przy pracy siedzącej i korzystaniu z telefonu. U osób starszych ważna jest też profilaktyka osteoporozy, bo złamania kręgów pogłębiają garb. Wcześnie wprowadzone nawyki działają najlepiej.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Katzman W.B., Wanek L., Shepherd J.A., Sellmeyer D.E.',
                    'title'     => 'Age-Related Hyperkyphosis: Its Causes, Consequences, and Management',
                    'publisher' => 'Journal of Orthopaedic & Sports Physical Therapy',
                    'note'      => '2010; 40(6): 352-360',
                ],
                [
                    'authors'   => 'American Academy of Orthopaedic Surgeons',
                    'title'     => 'Kyphosis (Roundback) of the Spine',
                    'publisher' => 'OrthoInfo (AAOS)',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'choroba-scheuermanna-objawy-i-leczenie-kregoslupa' => [
            'faq' => [
                [
                    'question' => 'Czym jest choroba Scheuermanna?',
                    'answer'   => 'To młodzieńcza kifoza piersiowa, czyli nadmierne, sztywne zaokrąglenie pleców rozwijające się w okresie dojrzewania na skutek zaburzeń wzrostu trzonów kręgów. Kręgi przyjmują klinowaty kształt, przez co kręgosłup wygina się ku tyłowi bardziej niż prawidłowo. Częściej dotyczy chłopców i ujawnia się zwykle między 13 a 18 rokiem życia.',
                ],
                [
                    'question' => 'Jak odróżnić chorobę Scheuermanna od zwykłego garbienia się?',
                    'answer'   => 'Przy zwykłej, nawykowej wadzie postawy plecy da się aktywnie wyprostować, a krzywizna znika przy skłonie i wyproście. W chorobie Scheuermanna kifoza jest sztywna i utrwalona, bo wynika ze zmian w budowie kręgów, dlatego nie koryguje się samym napięciem mięśni. Różnicę potwierdza badanie i zdjęcie RTG.',
                ],
                [
                    'question' => 'Jak rozpoznaje się chorobę Scheuermanna?',
                    'answer'   => 'Podstawą jest badanie i boczne zdjęcie RTG kręgosłupa. Rozpoznanie potwierdza klinowate zniekształcenie co najmniej trzech sąsiednich kręgów oraz pogłębiona kifoza piersiowa, zwykle powyżej 45-50 stopni w pomiarze kąta. Lekarz ocenia też dynamikę zmian i stopień dojrzałości kostnej.',
                ],
                [
                    'question' => 'Czy choroba Scheuermanna boli?',
                    'answer'   => 'Często tak, zwłaszcza ból zmęczeniowy pleców nasilający się po długim siedzeniu, staniu lub wysiłku, który ustępuje w spoczynku. W większości przypadków nie ma objawów neurologicznych. Nasilenie dolegliwości bywa różne i nie zawsze idzie w parze z wielkością skrzywienia.',
                ],
                [
                    'question' => 'Jak leczy się chorobę Scheuermanna?',
                    'answer'   => 'U większości pacjentów podstawą jest leczenie zachowawcze: kinezyterapia i ćwiczenia, fizykoterapia, dbanie o higienę kręgosłupa, a u rosnących dzieci z większym skrzywieniem gorset noszony przez wiele miesięcy. Wcześnie rozpoczęte leczenie daje lepsze efekty. Operację rozważa się przy bardzo dużych, postępujących skrzywieniach lub nasilonym bólu mimo leczenia.',
                ],
                [
                    'question' => 'Czy z chorobą Scheuermanna można uprawiać sport?',
                    'answer'   => 'Tak, ruch jest wskazany, ale dobrany rozsądnie. Zaleca się aktywności odciążające i wzmacniające plecy, na przykład pływanie, zwłaszcza na grzbiecie. Unika się natomiast forsownych ćwiczeń mocno obciążających kręgosłup i gwałtownych przeciążeń. Plan najlepiej ustalić z fizjoterapeutą, dostosowując go do etapu choroby.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Palazzo C., Sailhan F., Revel M.',
                    'title'     => 'Scheuermann disease: an update',
                    'publisher' => 'Joint Bone Spine',
                    'note'      => '2014; 81(3): 209-214',
                ],
                [
                    'authors'   => 'American Academy of Orthopaedic Surgeons',
                    'title'     => 'Kyphosis (Roundback) of the Spine',
                    'publisher' => 'OrthoInfo (AAOS)',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'osteotomia-na-czym-polega-i-co-warto-wiedziec-przed-zabiegiem' => [
            'faq' => [
                [
                    'question' => 'Czym jest osteotomia?',
                    'answer'   => 'To zabieg chirurgiczny polegający na celowym przecięciu kości i zmianie jej ustawienia, osi lub długości, a następnie stabilizacji w nowej pozycji, najczęściej płytką i śrubami. Celem jest poprawa biomechaniki i odciążenie zużytej części stawu lub korekta deformacji.',
                ],
                [
                    'question' => 'Przy jakich problemach wykonuje się osteotomię?',
                    'answer'   => 'Najczęściej dotyczy kolana, gdy zwyrodnienie obejmuje głównie jeden przedział stawu, a oś kończyny jest szpotawa lub koślawa. Stosuje się ją też przy deformacjach pourazowych, niektórych wadach wrodzonych oraz w innych okolicach, na przykład w chirurgii szczęki czy biodra. Pozwala odsunąć w czasie konieczność wszczepienia endoprotezy.',
                ],
                [
                    'question' => 'Na czym polega osteotomia kolana?',
                    'answer'   => 'Chirurg przecina kość (zwykle piszczel lub kość udową) i koryguje oś kończyny tak, by przenieść obciążenie ze zużytego przedziału stawu na zdrowszy. Kość ustawia się w nowej pozycji i stabilizuje implantem do czasu zrostu. Dzięki temu zmniejsza się ból i poprawia funkcja kolana.',
                ],
                [
                    'question' => 'Kto jest dobrym kandydatem do osteotomii?',
                    'answer'   => 'Zwykle są to młodsze, aktywne osoby ze zwyrodnieniem obejmującym jeden przedział stawu i z nieprawidłową osią kończyny, które chcą zachować własny staw. U pacjentów z zaawansowanym, wieloprzedziałowym zwyrodnieniem częściej rozważa się endoprotezę. Ostateczną kwalifikację ustala ortopeda na podstawie badania i zdjęć.',
                ],
                [
                    'question' => 'Jak wygląda rekonwalescencja po osteotomii?',
                    'answer'   => 'Powrót do pełnej sprawności trwa zwykle od 3 do 6 miesięcy, bo kość musi się zrosnąć. Na początku kończynę się odciąża, korzystając z kul, czasem z ortezy lub unieruchomienia, a obciążanie zwiększa stopniowo według zaleceń. Ważna jest rehabilitacja, która przywraca zakres ruchu i siłę mięśni. Powrót do pracy fizycznej bywa odległy o kilka miesięcy.',
                ],
                [
                    'question' => 'Czym osteotomia różni się od endoprotezy?',
                    'answer'   => 'Osteotomia zachowuje własny staw i koryguje jego obciążenie przez zmianę osi kości, dlatego stosuje się ją głównie przy zmianach w jednym przedziale i u młodszych, aktywnych osób. Endoproteza to wymiana zniszczonego stawu na sztuczny, rozważana przy zaawansowanym, rozległym zwyrodnieniu. Wybór zależy od wieku, aktywności i stopnia zużycia stawu.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Brouwer R.W., Huizinga M.R., Duivenvoorden T. i wsp.',
                    'title'     => 'Osteotomy for treating knee osteoarthritis',
                    'publisher' => 'Cochrane Database of Systematic Reviews',
                    'note'      => '2014; CD004019',
                ],
            ],
        ],
        'bol-glowy-a-schorzenia-stawu-skroniowo-zuchwowego' => [
            'faq' => [
                [
                    'question' => 'Czy ból głowy może pochodzić od stawu skroniowo-żuchwowego?',
                    'answer'   => 'Tak. Zaburzenia stawu skroniowo-żuchwowego i mięśni żucia (TMD) mogą dawać ból promieniujący do skroni, okolicy za uchem, twarzy i karku, łatwo mylony ze zwykłym bólem głowy. Dzieje się tak, bo napięte mięśnie żucia i przeciążony staw przenoszą ból na sąsiednie okolice. Dlatego nawracający ból głowy z dolegliwościami szczęki warto skojarzyć z TMD.',
                ],
                [
                    'question' => 'Jakie objawy wskazują na zaburzenia stawu skroniowo-żuchwowego?',
                    'answer'   => 'Typowe są ból twarzy i okolicy stawu, klikanie lub przeskakiwanie przy otwieraniu ust, uczucie blokowania żuchwy oraz trudność z szerokim otwarciem. Często towarzyszą im ból głowy, napięcie mięśni karku, czasem szumy w uszach lub zawroty głowy. Objawy nasilają się przy żuciu i zaciskaniu zębów.',
                ],
                [
                    'question' => 'Co wywołuje zaburzenia stawu skroniowo-żuchwowego?',
                    'answer'   => 'Przyczyny zwykle nakładają się na siebie. Znaczenie ma stres prowadzący do zaciskania i zgrzytania zębami (bruksizm), nieprawidłowy zgryz, utrata zębów lub źle dopasowane uzupełnienia protetyczne, a także przeciążenia i urazy. Często to połączenie czynników, a nie jedna konkretna wada.',
                ],
                [
                    'question' => 'Czym jest bruksizm i jak wiąże się z TMD?',
                    'answer'   => 'Bruksizm to mimowolne zaciskanie i zgrzytanie zębami, najczęściej w nocy lub w stresie. Powtarzane, silne napięcie przeciąża mięśnie żucia i staw skroniowo-żuchwowy, co sprzyja bólowi głowy, szczęki i ścieraniu zębów. Dlatego leczenie TMD często obejmuje też ograniczanie bruksizmu.',
                ],
                [
                    'question' => 'Jak leczy się zaburzenia stawu skroniowo-żuchwowego?',
                    'answer'   => 'Leczenie jest zwykle wielodyscyplinarne i zachowawcze. Stomatolog ocenia zgryz i często zaleca szynę (nakładkę) odciążającą staw oraz chroniącą zęby, a fizjoterapeuta pracuje nad mięśniami żucia, szyją i ruchomością stawu technikami manualnymi. Pomaga też redukcja stresu i ograniczenie nawyku zaciskania zębów. Plan dobiera się indywidualnie.',
                ],
                [
                    'question' => 'Do kogo zgłosić się z podejrzeniem TMD?',
                    'answer'   => 'Dobrym punktem wyjścia jest stomatolog, który oceni zgryz, staw i ewentualny bruksizm, oraz fizjoterapeuta zajmujący się stawem skroniowo-żuchwowym. Przy nasilonych lub przewlekłych bólach głowy warto skonsultować się także z lekarzem, by wykluczyć inne przyczyny. Współpraca tych specjalistów daje najlepsze efekty.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Schiffman E., Ohrbach R., Truelove E. i wsp.',
                    'title'     => 'Diagnostic Criteria for Temporomandibular Disorders (DC/TMD) for Clinical and Research Applications',
                    'publisher' => 'Journal of Oral & Facial Pain and Headache',
                    'note'      => '2014; 28(1): 6-27',
                ],
                [
                    'authors'   => 'List T., Jensen R.H.',
                    'title'     => 'Temporomandibular disorders: old ideas and new concepts',
                    'publisher' => 'Cephalalgia',
                    'note'      => '2017; 37(7): 692-704',
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

    update_option('fitmedica_faq_setup_v6', true);
});

/* -----------------------------------------------
   AUTO-SETUP FAQ + ZRODLA - partia v7
   (nadcisnienie, niedoczynnosc tarczycy, cukrzyca,
   depresja). Bez weryfikatora. Uruchamia sie raz.
   ----------------------------------------------- */

add_action('init', function () {
    if (get_option('fitmedica_faq_setup_v7')) return;

    $articles = [
        'nadcisnienie-tetnicze-2' => [
            'faq' => [
                [
                    'question' => 'Kiedy mówimy o nadciśnieniu tętniczym?',
                    'answer'   => 'O nadciśnieniu mówimy, gdy ciśnienie krwi utrzymuje się na poziomie co najmniej 140 mmHg dla wartości skurczowej lub 90 mmHg dla rozkurczowej, potwierdzonym w kilku pomiarach. Jednorazowo podwyższony wynik, na przykład po stresie czy wysiłku, nie wystarcza do rozpoznania. Dlatego diagnozę stawia się na podstawie powtarzanych pomiarów.',
                ],
                [
                    'question' => 'Jakie są objawy nadciśnienia?',
                    'answer'   => 'Nadciśnienie przez długi czas bywa bezobjawowe, dlatego nazywa się je cichym zabójcą. Gdy objawy się pojawiają, są to najczęściej bóle i zawroty głowy, kołatanie serca, duszność, a czasem krwawienia z nosa. Brak dolegliwości nie oznacza, że choroby nie ma, stąd znaczenie regularnych pomiarów.',
                ],
                [
                    'question' => 'Jak prawidłowo zmierzyć ciśnienie?',
                    'answer'   => 'Ciśnienie mierzy się w spoczynku, po kilku minutach odpoczynku, na podpartym ramieniu na wysokości serca, bez rozmowy w trakcie pomiaru. Warto wykonać kilka pomiarów w różne dni i pory, a w razie wątpliwości lekarz zleca całodobowe monitorowanie (Holter ciśnieniowy). Pojedynczy pomiar w gabinecie bywa zawyżony.',
                ],
                [
                    'question' => 'Czym grozi nieleczone nadciśnienie?',
                    'answer'   => 'Długotrwale podwyższone ciśnienie uszkadza naczynia i narządy, zwiększając ryzyko zawału serca, udaru mózgu, niewydolności serca i nerek oraz pogorszenia wzroku. Powikłania rozwijają się latami, często bez wyraźnych objawów. Dlatego leczenie ma sens nawet wtedy, gdy pacjent czuje się dobrze.',
                ],
                [
                    'question' => 'Jak leczy się nadciśnienie?',
                    'answer'   => 'Podstawą jest zmiana stylu życia: ograniczenie soli, redukcja masy ciała, aktywność fizyczna, rzucenie palenia i ograniczenie alkoholu oraz dieta bogata w warzywa i owoce. Gdy to nie wystarcza, lekarz dobiera leki (między innymi inhibitory ACE, blokery kanału wapniowego, leki moczopędne czy beta-blokery). Leczenie zwykle jest długotrwałe.',
                ],
                [
                    'question' => 'Czy leki na nadciśnienie bierze się do końca życia?',
                    'answer'   => 'U większości pacjentów leczenie jest przewlekłe, bo leki kontrolują ciśnienie, ale nie usuwają przyczyny. Nie należy odstawiać ich samodzielnie po uzyskaniu prawidłowych wartości, bo ciśnienie zwykle wraca. U części osób zdrowy styl życia pozwala zmniejszyć dawki, ale o każdej zmianie decyduje lekarz.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Mancia G., Kreutz R., Brunström M. i wsp.',
                    'title'     => '2023 ESH Guidelines for the management of arterial hypertension',
                    'publisher' => 'Journal of Hypertension',
                    'note'      => '2023; 41(12): 1874-2071',
                ],
                [
                    'authors'   => 'World Health Organization',
                    'title'     => 'Hypertension',
                    'publisher' => 'WHO',
                    'note'      => 'Materiał informacyjny dla pacjentów',
                ],
            ],
        ],
        'niedoczynnosc-tarczycy' => [
            'faq' => [
                [
                    'question' => 'Czym jest niedoczynność tarczycy?',
                    'answer'   => 'To stan, w którym tarczyca produkuje zbyt mało hormonów (T3 i T4) potrzebnych do prawidłowej pracy organizmu. Spowalnia to wiele procesów w ciele, od metabolizmu po pracę serca. Najczęstszą przyczyną jest autoimmunologiczne zapalenie tarczycy, czyli choroba Hashimoto.',
                ],
                [
                    'question' => 'Jakie są objawy niedoczynności tarczycy?',
                    'answer'   => 'Typowe są przewlekłe zmęczenie i senność, przyrost masy ciała mimo niezmienionej diety, marznięcie, sucha skóra, wypadanie włosów, zaparcia oraz obniżony nastrój i problemy z pamięcią. U kobiet bywają zaburzenia miesiączkowania. Objawy często narastają powoli i bywają mylone ze zmęczeniem czy stresem.',
                ],
                [
                    'question' => 'Jakie badania wykrywają niedoczynność tarczycy?',
                    'answer'   => 'Podstawą jest oznaczenie stężenia TSH, zwykle uzupełnione o wolną tyroksynę (FT4). Przy podejrzeniu Hashimoto bada się też przeciwciała przeciwtarczycowe (anty-TPO). Wyniki interpretuje lekarz w odniesieniu do objawów, bo same liczby nie zawsze przekładają się na dolegliwości.',
                ],
                [
                    'question' => 'Jak leczy się niedoczynność tarczycy?',
                    'answer'   => 'Leczenie polega na uzupełnianiu brakującego hormonu, czyli regularnym przyjmowaniu lewotyroksyny w dawce dobranej przez lekarza. Lek przyjmuje się zwykle rano, na czczo. Dawkę ustala się i koryguje na podstawie kontrolnych badań TSH, dlatego ważne są okresowe wizyty.',
                ],
                [
                    'question' => 'Czy niedoczynność tarczycy leczy się do końca życia?',
                    'answer'   => 'W większości przypadków, zwłaszcza przy chorobie Hashimoto, leczenie jest stałe, bo tarczyca trwale produkuje za mało hormonów. Dobrze prowadzona terapia pozwala jednak normalnie funkcjonować i cofa objawy. Nie wolno odstawiać leku na własną rękę po poprawie samopoczucia.',
                ],
                [
                    'question' => 'Czym grozi nieleczona niedoczynność tarczycy?',
                    'answer'   => 'Nieleczona lub źle wyrównana niedoczynność może prowadzić do powiększenia tarczycy (wola), zaburzeń pracy serca, podwyższonego cholesterolu, problemów z płodnością, a w ciąży do powikłań u dziecka. Dlatego objawów nie warto bagatelizować i lepiej je zdiagnozować.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Chaker L., Bianco A.C., Jonklaas J., Peeters R.P.',
                    'title'     => 'Hypothyroidism',
                    'publisher' => 'The Lancet',
                    'note'      => '2017; 390(10101): 1550-1562',
                ],
                [
                    'authors'   => 'American Thyroid Association',
                    'title'     => 'Hypothyroidism (Underactive Thyroid)',
                    'publisher' => 'ATA',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'co-trzeba-wiedziec-o-cukrzycy-przyczyny-objawy-i-leczenie' => [
            'faq' => [
                [
                    'question' => 'Czym jest cukrzyca?',
                    'answer'   => 'To grupa chorób metabolicznych, w których we krwi utrzymuje się zbyt wysoki poziom glukozy z powodu zaburzeń wydzielania lub działania insuliny. Insulina pozwala komórkom wykorzystywać glukozę jako paliwo, a jej niedobór lub nieskuteczność prowadzi do hiperglikemii. Nieleczona, z czasem uszkadza naczynia i narządy.',
                ],
                [
                    'question' => 'Czym różni się cukrzyca typu 1 od typu 2?',
                    'answer'   => 'Cukrzyca typu 1 to choroba autoimmunologiczna, w której organizm niszczy komórki trzustki produkujące insulinę, dlatego od początku konieczne jest jej podawanie. Typ 2, stanowiący większość przypadków, rozwija się stopniowo, najczęściej na tle nadwagi i stylu życia, gdy komórki przestają prawidłowo reagować na insulinę (insulinooporność).',
                ],
                [
                    'question' => 'Jakie są objawy cukrzycy?',
                    'answer'   => 'Typowe są wzmożone pragnienie i częste oddawanie moczu, zmęczenie, senność po posiłkach, a w bardziej zaawansowanej chorobie gorsze gojenie się ran, nawracające infekcje, mrowienie kończyn i zaburzenia wzroku. W typie 2 objawy bywają długo niezauważalne. U dzieci z typem 1 narastają szybko, w ciągu tygodni.',
                ],
                [
                    'question' => 'Jak rozpoznaje się cukrzycę?',
                    'answer'   => 'Podstawą są badania poziomu glukozy we krwi, w tym pomiar na czczo oraz doustny test obciążenia glukozą (krzywa cukrowa). Pomocne jest też oznaczenie hemoglobiny glikowanej (HbA1c), która odzwierciedla średni poziom cukru z ostatnich tygodni. Rozpoznanie potwierdza lekarz, zwykle po powtórzeniu nieprawidłowego wyniku.',
                ],
                [
                    'question' => 'Jak leczy się cukrzycę typu 2?',
                    'answer'   => 'Podstawą jest zmiana stylu życia: zdrowa dieta, redukcja masy ciała i regularna aktywność fizyczna, które poprawiają wrażliwość na insulinę. Gdy to nie wystarcza, lekarz włącza leki przeciwcukrzycowe, a w części przypadków insulinę. Leczenie dobiera się indywidualnie i monitoruje badaniami.',
                ],
                [
                    'question' => 'Czy cukrzycy typu 2 można zapobiec?',
                    'answer'   => 'Ryzyko można znacznie zmniejszyć, bo typ 2 silnie wiąże się ze stylem życia. Najwięcej daje utrzymanie prawidłowej masy ciała, regularny ruch, ograniczenie cukrów prostych i przetworzonej żywności oraz kontrola czynników ryzyka. Osoby z nadwagą i obciążeniem rodzinnym powinny okresowo sprawdzać poziom glukozy.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'American Diabetes Association',
                    'title'     => 'Standards of Care in Diabetes - 2024',
                    'publisher' => 'Diabetes Care',
                    'note'      => '2024; 47(Suppl 1)',
                ],
                [
                    'authors'   => 'World Health Organization',
                    'title'     => 'Diabetes',
                    'publisher' => 'WHO',
                    'note'      => 'Materiał informacyjny dla pacjentów',
                ],
            ],
        ],
        'czym-jest-depresja-jak-ja-leczyc' => [
            'faq' => [
                [
                    'question' => 'Czym jest depresja?',
                    'answer'   => 'To choroba, a nie chwilowe gorsze samopoczucie ani oznaka słabości. Charakteryzuje się utrzymującym się obniżeniem nastroju, utratą zainteresowań i radości oraz spadkiem energii, które trwają zwykle co najmniej dwa tygodnie i utrudniają codzienne funkcjonowanie. Wymaga leczenia, podobnie jak inne choroby.',
                ],
                [
                    'question' => 'Jakie są objawy depresji?',
                    'answer'   => 'Poza obniżonym nastrojem typowe są utrata zainteresowań i przyjemności, zaburzenia snu (bezsenność lub nadmierna senność), zmęczenie, problemy z koncentracją, obniżone poczucie własnej wartości oraz poczucie bezsensu. Mogą pojawić się też dolegliwości fizyczne, na przykład bóle, oraz myśli o śmierci lub samobójstwie.',
                ],
                [
                    'question' => 'Co wywołuje depresję?',
                    'answer'   => 'Depresja zwykle nie ma jednej przyczyny. Składają się na nią czynniki biologiczne i genetyczne, przewlekły stres, trudne wydarzenia życiowe i trauma, a także choroby współistniejące czy zaburzenia hormonalne. U różnych osób przeważają różne czynniki, dlatego leczenie dobiera się indywidualnie.',
                ],
                [
                    'question' => 'Jak rozpoznaje się depresję?',
                    'answer'   => 'Diagnozę stawia lekarz, najczęściej psychiatra, na podstawie rozmowy i oceny objawów oraz ich czasu trwania. Pomocne bywają kwestionariusze, na przykład PHQ-9 czy skala Becka, ale służą one wsparciu oceny, a nie samodzielnemu rozpoznawaniu. Warto też wykluczyć przyczyny somatyczne, na przykład chorobę tarczycy.',
                ],
                [
                    'question' => 'Jak leczy się depresję?',
                    'answer'   => 'Skuteczne jest połączenie psychoterapii i, w razie potrzeby, farmakoterapii. Najczęściej stosuje się leki z grupy SSRI i SNRI, dobierane przez lekarza, których efekt pojawia się zwykle po kilku tygodniach. Psychoterapia pomaga zrozumieć i zmienić wzorce myślenia oraz radzić sobie z trudnościami. Leczenie dobiera się do nasilenia objawów.',
                ],
                [
                    'question' => 'Kiedy pilnie szukać pomocy w depresji?',
                    'answer'   => 'Natychmiastowej pomocy wymagają myśli samobójcze lub poczucie, że życie traci sens. W takiej sytuacji nie należy zostawać samemu i warto skontaktować się z lekarzem, zgłosić na ostry dyżur psychiatryczny lub zadzwonić na całodobowy telefon zaufania. W Polsce działa bezpłatne Centrum Wsparcia pod numerem 116 123. Po pomoc warto sięgnąć też, gdy objawy utrzymują się ponad dwa tygodnie.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Malhi G.S., Mann J.J.',
                    'title'     => 'Depression',
                    'publisher' => 'The Lancet',
                    'note'      => '2018; 392(10161): 2299-2312',
                ],
                [
                    'authors'   => 'World Health Organization',
                    'title'     => 'Depressive disorder (depression)',
                    'publisher' => 'WHO',
                    'note'      => 'Materiał informacyjny dla pacjentów',
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

    update_option('fitmedica_faq_setup_v7', true);
});

/* -----------------------------------------------
   AUTO-SETUP FAQ + ZRODLA - partia v8 (kardio + endo)
   (choroba niedokrwienna serca, niewydolnosc serca,
   arytmia, miazdzyca, nadczynnosc tarczycy).
   Bez weryfikatora. Uruchamia sie raz.
   ----------------------------------------------- */

add_action('init', function () {
    if (get_option('fitmedica_faq_setup_v8')) return;

    $articles = [
        'choroba-niedokrwienna-serca' => [
            'faq' => [
                [
                    'question' => 'Czym jest choroba niedokrwienna serca?',
                    'answer'   => 'To stan, w którym mięsień sercowy otrzymuje za mało tlenu, bo zwężone tętnice wieńcowe dostarczają zbyt mało krwi. Najczęstszą przyczyną jest miażdżyca tych tętnic. Choroba może mieć postać stabilną, z dolegliwościami przy wysiłku, lub ostrą, gdy dochodzi do nagłego zamknięcia naczynia i zawału.',
                ],
                [
                    'question' => 'Jakie są objawy choroby wieńcowej?',
                    'answer'   => 'Typowy jest ból lub ucisk w klatce piersiowej, czasem promieniujący do barku, ramienia czy żuchwy, pojawiający się przy wysiłku lub stresie i ustępujący w spoczynku. Towarzyszyć mu mogą duszność i szybkie męczenie się. Silny, długotrwały ból w klatce, zwłaszcza w spoczynku, może oznaczać zawał i wymaga pilnej pomocy.',
                ],
                [
                    'question' => 'Kiedy ból w klatce piersiowej wymaga wezwania pogotowia?',
                    'answer'   => 'Natychmiastowej pomocy wymaga silny, długo niemijający ból lub ucisk w klatce, zwłaszcza promieniujący do ramienia czy żuchwy, z dusznością, potami i lękiem. To możliwe objawy zawału serca. W takiej sytuacji nie należy czekać ani prowadzić samochodu, tylko zadzwonić pod numer alarmowy 112 lub 999.',
                ],
                [
                    'question' => 'Jak diagnozuje się chorobę niedokrwienną serca?',
                    'answer'   => 'Podstawą jest ocena objawów i czynników ryzyka oraz EKG, w tym próby obciążeniowe. Pomocne są badania obrazowe serca, a stan tętnic wieńcowych najlepiej obrazuje koronarografia lub tomografia tętnic wieńcowych. Wybór badań zależy od objawów i ryzyka, a o nich decyduje kardiolog.',
                ],
                [
                    'question' => 'Jak leczy się chorobę wieńcową?',
                    'answer'   => 'Leczenie łączy zmianę stylu życia, leki i, w razie potrzeby, zabiegi. Stosuje się między innymi leki obniżające cholesterol, przeciwpłytkowe i poprawiające pracę serca. Przy istotnych zwężeniach wykonuje się zabieg poszerzenia tętnicy ze stentem (angioplastykę) lub pomostowanie (by-passy). Decyzję dobiera się indywidualnie.',
                ],
                [
                    'question' => 'Jak zmniejszyć ryzyko choroby wieńcowej?',
                    'answer'   => 'Najwięcej daje kontrola czynników ryzyka: niepalenie, leczenie nadciśnienia, cukrzycy i wysokiego cholesterolu, utrzymanie prawidłowej masy ciała, zdrowa dieta i regularna aktywność fizyczna. Te same działania spowalniają miażdżycę i chronią przed zawałem oraz udarem.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Knuuti J., Wijns W., Saraste A. i wsp.',
                    'title'     => '2019 ESC Guidelines for the diagnosis and management of chronic coronary syndromes',
                    'publisher' => 'European Heart Journal',
                    'note'      => '2020; 41(3): 407-477',
                ],
                [
                    'authors'   => 'American Heart Association',
                    'title'     => 'Coronary Artery Disease',
                    'publisher' => 'AHA',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'niewydolnosc-serca-przyczyny-objawy-leczenie' => [
            'faq' => [
                [
                    'question' => 'Czym jest niewydolność serca?',
                    'answer'   => 'To stan, w którym serce nie pompuje krwi w ilości pokrywającej zapotrzebowanie organizmu. Nie oznacza, że serce się zatrzymuje, tylko że pracuje mniej wydolnie. Może rozwijać się powoli (przewlekła) lub gwałtownie (ostra), i dotyczyć lewej, prawej albo obu części serca.',
                ],
                [
                    'question' => 'Jakie są objawy niewydolności serca?',
                    'answer'   => 'Najczęstsze to duszność, zwłaszcza przy wysiłku i w pozycji leżącej, zmęczenie i spadek sił, obrzęki nóg, stóp i kostek oraz zwiększone oddawanie moczu w nocy. Bywa też kołatanie serca i powiększenie obwodu brzucha. Narastanie tych objawów warto skonsultować z lekarzem.',
                ],
                [
                    'question' => 'Co prowadzi do niewydolności serca?',
                    'answer'   => 'Najczęstsze przyczyny to nieleczone nadciśnienie i choroba wieńcowa, a także kardiomiopatie, wady i zaburzenia rytmu serca, przebyte zapalenie mięśnia sercowego oraz cukrzyca i otyłość. Często działa kilka czynników naraz, które przez lata przeciążają serce.',
                ],
                [
                    'question' => 'Jak diagnozuje się niewydolność serca?',
                    'answer'   => 'Podstawą jest badanie, EKG oraz echokardiografia (USG serca), która ocenia kurczliwość i budowę serca. Pomocne są badania krwi, w tym oznaczenie peptydów natriuretycznych. Lekarz zestawia wyniki z objawami, by ocenić rodzaj i zaawansowanie niewydolności.',
                ],
                [
                    'question' => 'Jak leczy się niewydolność serca?',
                    'answer'   => 'Leczenie łączy leki i zmianę stylu życia, a w wybranych przypadkach zabiegi. Stosuje się między innymi inhibitory ACE lub ich odpowiedniki, beta-blokery, leki moczopędne i antagonistów aldosteronu. Ważne są kontrola masy ciała, ograniczenie soli i regularne przyjmowanie leków. W zaawansowanych przypadkach rozważa się wszczepialne urządzenia lub przeszczep.',
                ],
                [
                    'question' => 'Czy z niewydolnością serca można normalnie żyć?',
                    'answer'   => 'Wielu pacjentów przy dobrze prowadzonym leczeniu funkcjonuje aktywnie przez długi czas. Kluczowe są regularne przyjmowanie leków, kontrola masy ciała i ciśnienia, ograniczenie soli, rozsądna aktywność fizyczna i szybkie reagowanie na nasilenie objawów. Niewydolność serca jest chorobą przewlekłą, którą trzeba systematycznie kontrolować.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'McDonagh T.A., Metra M., Adamo M. i wsp.',
                    'title'     => '2021 ESC Guidelines for the diagnosis and treatment of acute and chronic heart failure',
                    'publisher' => 'European Heart Journal',
                    'note'      => '2021; 42(36): 3599-3726',
                ],
                [
                    'authors'   => 'American Heart Association',
                    'title'     => 'Heart Failure',
                    'publisher' => 'AHA',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'zaburzenia-rytmu-serca-arytmia' => [
            'faq' => [
                [
                    'question' => 'Czym jest arytmia?',
                    'answer'   => 'To zaburzenie rytmu serca, które powstaje, gdy impulsy elektryczne sterujące jego pracą nie tworzą się lub nie rozchodzą prawidłowo. Serce bije wtedy za szybko, za wolno lub nieregularnie. Niektóre arytmie są niegroźne, inne wymagają leczenia, dlatego warto je ocenić.',
                ],
                [
                    'question' => 'Jakie są objawy arytmii?',
                    'answer'   => 'Często odczuwa się kołatanie serca, uczucie szybkiego bicia lub zamierania serca, a także zawroty głowy, osłabienie, duszność czy ból w klatce piersiowej. W cięższych przypadkach może dojść do omdlenia. Część arytmii przebiega jednak bez wyraźnych objawów i wykrywa się je dopiero w badaniu.',
                ],
                [
                    'question' => 'Jak diagnozuje się arytmię?',
                    'answer'   => 'Podstawą jest EKG, które rejestruje rytm serca. Ponieważ arytmia bywa napadowa, często stosuje się monitorowanie Holter EKG przez dobę lub dłużej, by uchwycić zaburzenia w codziennych warunkach. W zależności od sytuacji lekarz może zlecić dodatkowe badania serca.',
                ],
                [
                    'question' => 'Czy arytmia jest groźna?',
                    'answer'   => 'To zależy od rodzaju. Wiele arytmii jest łagodnych, ale niektóre, jak migotanie przedsionków, zwiększają ryzyko powikłań, w tym udaru mózgu, lub mogą upośledzać pracę serca. Dlatego nawracające kołatania, omdlenia czy ból w klatce piersiowej warto zdiagnozować, a nie lekceważyć.',
                ],
                [
                    'question' => 'Jak leczy się zaburzenia rytmu serca?',
                    'answer'   => 'Leczenie dobiera się do rodzaju arytmii i jej przyczyny. Stosuje się leki kontrolujące rytm i częstość pracy serca, a przy arytmiach zatorowych, jak migotanie przedsionków, także leczenie przeciwkrzepliwe zmniejszające ryzyko udaru. W wybranych przypadkach wykonuje się ablację, kardiowersję lub wszczepia się urządzenia, na przykład rozrusznik.',
                ],
                [
                    'question' => 'Co może wywoływać lub nasilać arytmię?',
                    'answer'   => 'Sprzyjają jej choroby serca (zawał, niewydolność, nadciśnienie), cukrzyca i choroby tarczycy, zaburzenia elektrolitowe oraz używki: alkohol, nikotyna i nadmiar kofeiny. Znaczenie mają też stres i niedobór snu. Ograniczenie tych czynników wspiera leczenie i zmniejsza nawroty.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Hindricks G., Potpara T., Dagres N. i wsp.',
                    'title'     => '2020 ESC Guidelines for the diagnosis and management of atrial fibrillation',
                    'publisher' => 'European Heart Journal',
                    'note'      => '2021; 42(5): 373-498',
                ],
                [
                    'authors'   => 'American Heart Association',
                    'title'     => 'Arrhythmia',
                    'publisher' => 'AHA',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'miazdzyca-naczyn-krwionosnych' => [
            'faq' => [
                [
                    'question' => 'Czym jest miażdżyca?',
                    'answer'   => 'To przewlekła choroba tętnic, w której w ścianach naczyń odkładają się blaszki z cholesterolu i tłuszczów, stopniowo zwężając ich światło. Z czasem blaszki włóknieją i wapnieją, a na ich powierzchni mogą tworzyć się zakrzepy. Ogranicza to dopływ krwi do narządów i jest główną przyczyną zawałów i udarów.',
                ],
                [
                    'question' => 'Jakie są objawy miażdżycy?',
                    'answer'   => 'Przez długi czas miażdżyca rozwija się bezobjawowo, a dolegliwości zależą od zajętej tętnicy. W naczyniach serca daje ból w klatce piersiowej, w tętnicach mózgu objawy niedokrwienia i ryzyko udaru, w nogach ból przy chodzeniu, a w nerkach nadciśnienie. Często pierwszym sygnałem jest dopiero poważne powikłanie.',
                ],
                [
                    'question' => 'Co zwiększa ryzyko miażdżycy?',
                    'answer'   => 'Najważniejsze czynniki to wysoki cholesterol, palenie tytoniu, nadciśnienie, cukrzyca, nadwaga i otyłość, mała aktywność fizyczna oraz nieprawidłowa dieta. Znaczenie mają też wiek i obciążenia rodzinne. Większość z tych czynników można kontrolować, co realnie spowalnia chorobę.',
                ],
                [
                    'question' => 'Czym grozi miażdżyca?',
                    'answer'   => 'Najpoważniejsze powikłania to zawał mięśnia sercowego i udar niedokrwienny mózgu, do których dochodzi, gdy blaszka zamyka tętnicę lub powstaje na niej zakrzep. Miażdżyca tętnic kończyn może prowadzić do niedokrwienia nóg. Dlatego tak ważne jest wczesne ograniczanie czynników ryzyka.',
                ],
                [
                    'question' => 'Jak leczy się i hamuje miażdżycę?',
                    'answer'   => 'Podstawą jest zmiana stylu życia: niepalenie, zdrowa dieta, aktywność fizyczna i redukcja masy ciała, a także leczenie nadciśnienia, cukrzycy i wysokiego cholesterolu, często z użyciem leków obniżających lipidy. Przy istotnych zwężeniach stosuje się zabiegi udrażniające tętnicę. Celem jest spowolnienie choroby i zapobieganie powikłaniom.',
                ],
                [
                    'question' => 'Czy miażdżycy można zapobiec?',
                    'answer'   => 'Rozwój miażdżycy można znacznie spowolnić, a u wielu osób w dużej mierze jej zapobiec, działając na czynniki ryzyka. Najwięcej daje niepalenie, zdrowa dieta uboga w tłuszcze nasycone, regularny ruch, prawidłowa masa ciała oraz kontrola ciśnienia, cukru i cholesterolu. Im wcześniej, tym lepszy efekt.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Mach F., Baigent C., Catapano A.L. i wsp.',
                    'title'     => '2019 ESC/EAS Guidelines for the management of dyslipidaemias: lipid modification to reduce cardiovascular risk',
                    'publisher' => 'European Heart Journal',
                    'note'      => '2020; 41(1): 111-188',
                ],
                [
                    'authors'   => 'American Heart Association',
                    'title'     => 'Atherosclerosis',
                    'publisher' => 'AHA',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'nadczynnosc-tarczycy' => [
            'faq' => [
                [
                    'question' => 'Czym jest nadczynność tarczycy?',
                    'answer'   => 'To stan, w którym tarczyca produkuje nadmiar hormonów (T3 i T4), co przyspiesza wiele procesów w organizmie. Przemiana materii, praca serca i układu nerwowego ulegają pobudzeniu. Najczęstszą przyczyną jest choroba Gravesa-Basedowa, czyli zaburzenie autoimmunologiczne.',
                ],
                [
                    'question' => 'Jakie są objawy nadczynności tarczycy?',
                    'answer'   => 'Typowe są chudnięcie mimo dobrego apetytu, przyspieszone i mocne bicie serca, nerwowość, drażliwość i niepokój, nadmierne pocenie się oraz nietolerancja ciepła. Częste są też drżenie rąk, bezsenność, biegunki i osłabienie mięśni. Objawy bywają mylone ze stresem czy przemęczeniem.',
                ],
                [
                    'question' => 'Co wywołuje nadczynność tarczycy?',
                    'answer'   => 'Najczęstszą przyczyną jest choroba Gravesa-Basedowa, w której układ odpornościowy pobudza tarczycę do nadprodukcji hormonów. Nadczynność mogą też wywołać nadczynne guzki tarczycy oraz niektóre stany zapalne gruczołu. Ustalenie przyczyny jest ważne, bo wpływa na wybór leczenia.',
                ],
                [
                    'question' => 'Jak rozpoznaje się nadczynność tarczycy?',
                    'answer'   => 'Podstawą są badania krwi: obniżone TSH przy podwyższonych hormonach tarczycy (FT3 i FT4) wskazują na nadczynność. Przy podejrzeniu choroby Gravesa-Basedowa oznacza się przeciwciała, a obraz uzupełnia USG tarczycy, czasem badanie izotopowe. Wyniki interpretuje lekarz w odniesieniu do objawów.',
                ],
                [
                    'question' => 'Jak leczy się nadczynność tarczycy?',
                    'answer'   => 'Są trzy główne drogi: leki przeciwtarczycowe (tyreostatyki) hamujące produkcję hormonów, leczenie jodem radioaktywnym oraz operacja usunięcia części lub całości tarczycy. Wybór zależy od przyczyny, nasilenia choroby, wieku i sytuacji pacjenta, na przykład ciąży. Decyzję podejmuje lekarz wspólnie z pacjentem.',
                ],
                [
                    'question' => 'Czy nieleczona nadczynność tarczycy jest groźna?',
                    'answer'   => 'Tak. Długotrwały nadmiar hormonów obciąża serce i może prowadzić do zaburzeń rytmu, w tym migotania przedsionków, a także do osłabienia kości i osteoporozy. Bardzo nasilona nadczynność grozi groźnym przełomem tarczycowym. Dlatego objawów nie warto bagatelizować i należy je zdiagnozować.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Ross D.S., Burch H.B., Cooper D.S. i wsp.',
                    'title'     => '2016 American Thyroid Association Guidelines for Diagnosis and Management of Hyperthyroidism and Other Causes of Thyrotoxicosis',
                    'publisher' => 'Thyroid',
                    'note'      => '2016; 26(10): 1343-1421',
                ],
                [
                    'authors'   => 'American Thyroid Association',
                    'title'     => 'Hyperthyroidism (Overactive)',
                    'publisher' => 'ATA',
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

    update_option('fitmedica_faq_setup_v8', true);
});

/* -----------------------------------------------
   AUTO-SETUP FAQ + ZRODLA - partia v9
   (Hashimoto, zawal serca, otylosc, zaburzenia
   lekowe, bezsennosc). Bez weryfikatora.
   Uruchamia sie raz.
   ----------------------------------------------- */

add_action('init', function () {
    if (get_option('fitmedica_faq_setup_v9')) return;

    $articles = [
        'choroba-hashimoto' => [
            'faq' => [
                [
                    'question' => 'Czym jest choroba Hashimoto?',
                    'answer'   => 'To autoimmunologiczne zapalenie tarczycy, w którym układ odpornościowy stopniowo niszczy komórki gruczołu. Z czasem prowadzi to najczęściej do niedoczynności tarczycy, czyli niedoboru jej hormonów. Jest to jedna z najczęstszych przyczyn niedoczynności tarczycy, zwłaszcza u kobiet.',
                ],
                [
                    'question' => 'Jakie są objawy choroby Hashimoto?',
                    'answer'   => 'Objawy wynikają głównie z niedoczynności tarczycy: przewlekłe zmęczenie i senność, przyrost masy ciała, marznięcie, sucha skóra, wypadanie włosów, zaparcia, obniżony nastrój i problemy z pamięcią. U kobiet bywają zaburzenia miesiączkowania. Na wczesnym etapie choroba może przebiegać skąpoobjawowo.',
                ],
                [
                    'question' => 'Jakie badania potwierdzają Hashimoto?',
                    'answer'   => 'Podstawą jest oznaczenie przeciwciał przeciwtarczycowych, przede wszystkim anty-TPO, a często też anty-TG, oraz ocena czynności tarczycy przez TSH i hormony (FT4). Obraz uzupełnia USG tarczycy, które pokazuje typowe dla zapalenia zmiany. Wyniki interpretuje lekarz w odniesieniu do objawów.',
                ],
                [
                    'question' => 'Jak leczy się chorobę Hashimoto?',
                    'answer'   => 'Nie ma leczenia usuwającego przyczynę, dlatego terapia polega na wyrównywaniu niedoboru hormonów, gdy rozwinie się niedoczynność. Stosuje się lewotyroksynę w dawce dobranej przez lekarza i korygowanej na podstawie kontrolnych badań TSH. Sama obecność przeciwciał bez niedoczynności nie zawsze wymaga leczenia hormonalnego.',
                ],
                [
                    'question' => 'Czy dieta ma znaczenie w Hashimoto?',
                    'answer'   => 'Dieta nie zastępuje leczenia, ale wspiera samopoczucie i ogólne zdrowie. Zaleca się regularne, zbilansowane posiłki, dużo warzyw, ograniczenie cukrów prostych i wysoko przetworzonej żywności oraz zadbanie o odpowiednią podaż jodu, selenu i witaminy D zgodnie z zaleceniami lekarza. Restrykcyjne diety eliminacyjne warto konsultować ze specjalistą.',
                ],
                [
                    'question' => 'Czy z chorobą Hashimoto można normalnie żyć?',
                    'answer'   => 'Tak. Dobrze wyrównana niedoczynność tarczycy pozwala normalnie funkcjonować, pracować i zachodzić w ciążę. Kluczowe są regularne przyjmowanie leku oraz okresowa kontrola TSH, zwłaszcza przy planowaniu ciąży. Nieleczona lub źle kontrolowana choroba może natomiast obciążać serce i wpływać na płodność.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Caturegli P., De Remigis A., Rose N.R.',
                    'title'     => 'Hashimoto thyroiditis: clinical and diagnostic criteria',
                    'publisher' => 'Autoimmunity Reviews',
                    'note'      => '2014; 13(4-5): 391-397',
                ],
                [
                    'authors'   => 'American Thyroid Association',
                    'title'     => 'Hashimotos Thyroiditis (Lymphocytic Thyroiditis)',
                    'publisher' => 'ATA',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'zawal-serca' => [
            'faq' => [
                [
                    'question' => 'Czym jest zawał serca?',
                    'answer'   => 'To ostry stan, w którym fragment mięśnia sercowego obumiera z powodu nagłego odcięcia dopływu krwi. Najczęściej dochodzi do niego, gdy pęka blaszka miażdżycowa w tętnicy wieńcowej i tworzy się na niej zakrzep zamykający naczynie. Im szybciej przywróci się przepływ, tym mniejsze uszkodzenie serca.',
                ],
                [
                    'question' => 'Jakie są objawy zawału serca?',
                    'answer'   => 'Typowy jest silny ból lub ucisk w klatce piersiowej, często promieniujący do ramienia, barku, szyi lub żuchwy, trwający dłużej niż kilka minut i nieustępujący w spoczynku. Towarzyszą mu duszność, zimne poty, nudności, osłabienie i lęk. U kobiet, osób starszych i chorych na cukrzycę objawy bywają mniej typowe, na przykład samo zmęczenie i duszność.',
                ],
                [
                    'question' => 'Co robić przy podejrzeniu zawału serca?',
                    'answer'   => 'Należy natychmiast wezwać pogotowie (112 lub 999), bo liczy się każda minuta. Chorego układa się w pozycji półsiedzącej, zapewnia spokój i dostęp powietrza oraz rozluźnia ciasne ubranie. Jeśli nie ma przeciwwskazań i pozwala na to stan, można podać aspirynę. Przy zatrzymaniu krążenia rozpoczyna się resuscytację (30 uciśnięć na 2 oddechy). Nie wolno samemu jechać do szpitala za kierownicą.',
                ],
                [
                    'question' => 'Jak rozpoznaje się zawał serca?',
                    'answer'   => 'Podstawą są EKG oraz badania krwi oznaczające troponiny, czyli białka uwalniane z uszkodzonego serca. EKG może pokazać charakterystyczne zmiany, a w razie potrzeby wykonuje się koronarografię, która lokalizuje zamknięte naczynie i umożliwia jego udrożnienie. Rozpoznanie stawia się szybko, bo decyduje o pilnym leczeniu.',
                ],
                [
                    'question' => 'Jak leczy się zawał serca?',
                    'answer'   => 'Najważniejsze jest jak najszybsze przywrócenie przepływu w zamkniętej tętnicy. Najczęściej wykonuje się pilną angioplastykę wieńcową, czyli poszerzenie naczynia i wszczepienie stentu. W części przypadków potrzebne jest pomostowanie (by-passy). Po zawale stosuje się leki i rehabilitację kardiologiczną, które zmniejszają ryzyko kolejnego incydentu.',
                ],
                [
                    'question' => 'Jak zmniejszyć ryzyko zawału serca?',
                    'answer'   => 'Najwięcej daje kontrola czynników ryzyka: niepalenie, leczenie nadciśnienia, cukrzycy i wysokiego cholesterolu, utrzymanie prawidłowej masy ciała, zdrowa dieta i regularna aktywność fizyczna. Ważne jest też ograniczenie stresu i regularne badania profilaktyczne, zwłaszcza przy obciążeniu rodzinnym.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Byrne R.A., Rossello X., Coughlan J.J. i wsp.',
                    'title'     => '2023 ESC Guidelines for the management of acute coronary syndromes',
                    'publisher' => 'European Heart Journal',
                    'note'      => '2023; 44(38): 3720-3826',
                ],
                [
                    'authors'   => 'American Heart Association',
                    'title'     => 'Heart Attack (Myocardial Infarction)',
                    'publisher' => 'AHA',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'otylosc' => [
            'faq' => [
                [
                    'question' => 'Czym jest otyłość?',
                    'answer'   => 'To przewlekła choroba, w której nadmiar tkanki tłuszczowej szkodzi zdrowiu. Nie jest kwestią samej estetyki ani braku silnej woli, lecz złożonym zaburzeniem, na które wpływają nawyki, genetyka, hormony i czynniki środowiskowe. Jak każda choroba przewlekła, wymaga leczenia i długoterminowej opieki.',
                ],
                [
                    'question' => 'Jak ocenia się otyłość i co oznacza BMI?',
                    'answer'   => 'Pomocniczo używa się wskaźnika masy ciała (BMI). Wartość powyżej 25 oznacza nadwagę, a 30 i więcej otyłość, którą dzieli się na trzy stopnie (I: 30-34,9, II: 35-39,9, III: 40 i więcej). BMI nie uwzględnia jednak budowy ciała ani rozmieszczenia tłuszczu, dlatego ocenę uzupełnia się o obwód talii i ogólny stan zdrowia.',
                ],
                [
                    'question' => 'Czym grozi otyłość?',
                    'answer'   => 'Otyłość zwiększa ryzyko wielu poważnych chorób: cukrzycy typu 2, nadciśnienia, zawału serca i udaru, niektórych nowotworów, chorób stawów oraz bezdechu sennego. Obciąża też samopoczucie i zdrowie psychiczne. Ryzyko rośnie zwłaszcza przy otyłości brzusznej, gdy tłuszcz gromadzi się wokół narządów.',
                ],
                [
                    'question' => 'Co powoduje otyłość?',
                    'answer'   => 'Najczęściej dodatni bilans energetyczny, czyli przewaga przyjmowanych kalorii nad wydatkowanymi, w połączeniu z małą aktywnością fizyczną. Znaczenie mają jednak także predyspozycje genetyczne, zaburzenia hormonalne, niektóre leki, stres, niedobór snu i czynniki środowiskowe. U różnych osób przeważają różne przyczyny.',
                ],
                [
                    'question' => 'Jak leczy się otyłość?',
                    'answer'   => 'Podstawą jest trwała zmiana stylu życia: zbilansowana dieta, większa aktywność fizyczna i wsparcie nawyków, najlepiej pod okiem dietetyka i lekarza. W zależności od stopnia otyłości i chorób towarzyszących stosuje się też farmakoterapię, a przy otyłości dużego stopnia rozważa leczenie chirurgiczne (operacje bariatryczne). Plan dobiera się indywidualnie.',
                ],
                [
                    'question' => 'Czy warto chudnąć nawet niewiele?',
                    'answer'   => 'Tak. Już umiarkowana redukcja masy ciała poprawia ciśnienie, poziom cukru i cholesterolu, jakość snu oraz samopoczucie i zmniejsza obciążenie stawów. Nie chodzi o szybką, drastyczną dietę, lecz o trwałą, stopniową zmianę, którą da się utrzymać. Nawet kilka procent mniejszej masy ciała przynosi realne korzyści zdrowotne.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Wharton S., Lau D.C.W., Vallis M. i wsp.',
                    'title'     => 'Obesity in adults: a clinical practice guideline',
                    'publisher' => 'CMAJ',
                    'note'      => '2020; 192(31): E875-E891',
                ],
                [
                    'authors'   => 'World Health Organization',
                    'title'     => 'Obesity and overweight',
                    'publisher' => 'WHO',
                    'note'      => 'Materiał informacyjny dla pacjentów',
                ],
            ],
        ],
        'czym-sa-zaburzenia-lekowe-jak-je-diagnozowac-i-leczyc' => [
            'faq' => [
                [
                    'question' => 'Czym są zaburzenia lękowe?',
                    'answer'   => 'To grupa zaburzeń psychicznych, których wspólną cechą jest nadmierny, długotrwały lęk nieadekwatny do sytuacji, który utrudnia codzienne funkcjonowanie. Lęk jest naturalną reakcją na zagrożenie, ale w zaburzeniach lękowych pojawia się zbyt często, zbyt silnie lub bez realnej przyczyny. To choroba, którą można skutecznie leczyć.',
                ],
                [
                    'question' => 'Jakie są rodzaje zaburzeń lękowych?',
                    'answer'   => 'Do najczęstszych należą zespół lęku uogólnionego (przewlekły, rozlany niepokój), zespół lęku napadowego z atakami paniki oraz fobie, czyli silny lęk przed konkretnymi sytuacjami lub bodźcami, na przykład fobia społeczna. Różnią się przebiegiem, ale łączy je nadmierny, utrudniający życie lęk.',
                ],
                [
                    'question' => 'Jakie objawy dają zaburzenia lękowe?',
                    'answer'   => 'Objawy są zarówno psychiczne, jak i fizyczne. Pojawiają się napięcie, niepokój, drażliwość, trudności z koncentracją i zaburzenia snu, a także objawy z ciała: kołatanie serca, ucisk w klatce piersiowej, duszność, drżenie, pocenie się i dolegliwości żołądkowe. Objawy somatyczne bywają tak silne, że przypominają chorobę serca.',
                ],
                [
                    'question' => 'Czym napad paniki różni się od zwykłego stresu?',
                    'answer'   => 'Napad paniki to nagły, bardzo intensywny atak lęku z silnymi objawami z ciała: przyspieszonym biciem serca, dusznością, zawrotami głowy i uczuciem utraty kontroli lub zagrożenia życia. Pojawia się gwałtownie i zwykle szybko narasta, w odróżnieniu od stopniowego napięcia, jakie daje zwykły stres. Powtarzające się napady wymagają konsultacji.',
                ],
                [
                    'question' => 'Jak leczy się zaburzenia lękowe?',
                    'answer'   => 'Skuteczna jest psychoterapia, zwłaszcza poznawczo-behawioralna (CBT), często z elementami ekspozycji. W razie potrzeby dołącza się farmakoterapię, najczęściej leki z grupy SSRI lub SNRI, dobierane przez lekarza. Leki uspokajające z grupy benzodiazepin stosuje się tylko krótko, doraźnie, bo grożą uzależnieniem. Pomaga też higiena snu, aktywność fizyczna i techniki relaksacyjne.',
                ],
                [
                    'question' => 'Kiedy zgłosić się po pomoc z powodu lęku?',
                    'answer'   => 'Warto sięgnąć po pomoc, gdy lęk jest silny, utrzymuje się tygodniami, ogranicza pracę, relacje czy codzienne czynności albo gdy pojawiają się napady paniki lub unikanie wielu sytuacji. Pomoc oferują psycholog i psychiatra. Im wcześniej rozpocznie się leczenie, tym zwykle łatwiej opanować objawy.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Craske M.G., Stein M.B.',
                    'title'     => 'Anxiety',
                    'publisher' => 'The Lancet',
                    'note'      => '2016; 388(10063): 3048-3059',
                ],
                [
                    'authors'   => 'World Health Organization',
                    'title'     => 'Anxiety disorders',
                    'publisher' => 'WHO',
                    'note'      => 'Materiał informacyjny dla pacjentów',
                ],
            ],
        ],
        'bezsennosc-przyczyny-objawy-i-sprawdzone-sposoby-na-poprawe-jakosci-snu' => [
            'faq' => [
                [
                    'question' => 'Czym jest bezsenność?',
                    'answer'   => 'To zaburzenie snu polegające na trudnościach z zasypianiem, częstym wybudzaniu się w nocy lub zbyt wczesnym budzeniu, mimo odpowiednich warunków do snu. Skutkuje uczuciem niewyspania i gorszym funkcjonowaniem w ciągu dnia. Bywa krótkotrwała, związana z przejściową sytuacją, lub przewlekła, gdy utrzymuje się tygodniami.',
                ],
                [
                    'question' => 'Jakie są przyczyny bezsenności?',
                    'answer'   => 'Najczęściej stoi za nią stres i napięcie, zaburzenia rytmu dobowego (na przykład praca zmianowa), nadużywanie kofeiny i alkoholu oraz korzystanie z ekranów przed snem. Bezsenność towarzyszy też chorobom somatycznym, zaburzeniom hormonalnym (w tym tarczycy) oraz depresji i zaburzeniom lękowym. Często działa kilka czynników naraz.',
                ],
                [
                    'question' => 'Kiedy bezsenność wymaga konsultacji z lekarzem?',
                    'answer'   => 'Warto skonsultować się, gdy problemy ze snem utrzymują się dłużej niż około trzy, cztery tygodnie, nawracają lub wyraźnie pogarszają funkcjonowanie w ciągu dnia. Konsultacja jest też wskazana, gdy bezsenności towarzyszą objawy depresji, lęku, chrapanie z bezdechami albo choroby przewlekłe. Lekarz pomoże ustalić przyczynę.',
                ],
                [
                    'question' => 'Na czym polega higiena snu?',
                    'answer'   => 'To zestaw nawyków sprzyjających dobremu snu: stałe pory kładzenia się i wstawania, ciemna, cicha i chłodna sypialnia, unikanie ekranów, kofeiny i obfitych posiłków przed snem oraz ograniczenie drzemek w ciągu dnia. Łóżko warto kojarzyć ze snem, a nie z pracą czy oglądaniem telefonu. Te zasady są podstawą leczenia.',
                ],
                [
                    'question' => 'Jak leczy się przewlekłą bezsenność?',
                    'answer'   => 'Metodą pierwszego wyboru jest terapia poznawczo-behawioralna bezsenności (CBT-I), która pracuje nad nawykami i myślami utrudniającymi sen. Leki nasenne stosuje się raczej krótkotrwale i pod kontrolą lekarza, bo nie usuwają przyczyny i mogą uzależniać. Ważne jest też leczenie chorób, które bezsenność podtrzymują.',
                ],
                [
                    'question' => 'Czym grozi przewlekły niedobór snu?',
                    'answer'   => 'Utrzymujący się niedobór snu pogarsza koncentrację, pamięć i nastrój, zwiększa drażliwość i ryzyko błędów, na przykład za kierownicą. W dłuższej perspektywie sprzyja nadciśnieniu, chorobom serca, cukrzycy i otyłości oraz nasila zaburzenia lękowe i depresję. Dlatego przewlekłej bezsenności nie warto lekceważyć.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Riemann D., Baglioni C., Bassetti C. i wsp.',
                    'title'     => 'European guideline for the diagnosis and treatment of insomnia',
                    'publisher' => 'Journal of Sleep Research',
                    'note'      => '2017; 26(6): 675-700',
                ],
                [
                    'authors'   => 'American Academy of Sleep Medicine',
                    'title'     => 'Insomnia',
                    'publisher' => 'AASM (Sleep Education)',
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

    update_option('fitmedica_faq_setup_v9', true);
});

/* -----------------------------------------------
   AUTO-SETUP FAQ + ZRODLA - partia v10
   (kardiomiopatia, tetniak aorty piersiowej,
   dwubiegunowosc, ADHD u doroslych, spektrum autyzmu).
   Bez weryfikatora. Uruchamia sie raz.
   ----------------------------------------------- */

add_action('init', function () {
    if (get_option('fitmedica_faq_setup_v10')) return;

    $articles = [
        'kardiomiopatia' => [
            'faq' => [
                [
                    'question' => 'Czym jest kardiomiopatia?',
                    'answer'   => 'To choroba samego mięśnia sercowego, w której jego budowa i praca są nieprawidłowe, przez co sercu trudniej skutecznie tłoczyć krew. Nie jest to to samo co choroba wieńcowa, choć też może prowadzić do niewydolności serca. Część kardiomiopatii ma podłoże genetyczne i występuje rodzinnie.',
                ],
                [
                    'question' => 'Jakie są rodzaje kardiomiopatii?',
                    'answer'   => 'Najczęstsza jest postać rozstrzeniowa, w której serce się powiększa i słabiej kurczy. Kardiomiopatia przerostowa polega na nadmiernym pogrubieniu mięśnia, często uwarunkowanym genetycznie. Rzadsza postać restrykcyjna oznacza usztywnienie ścian i upośledzone napełnianie serca. Rodzaj choroby wpływa na objawy i leczenie.',
                ],
                [
                    'question' => 'Jakie są objawy kardiomiopatii?',
                    'answer'   => 'Często pojawiają się duszność przy wysiłku, zmęczenie, obrzęki nóg, kołatanie serca i zaburzenia rytmu, czasem ból w klatce piersiowej oraz zawroty głowy lub omdlenia. Część osób długo nie ma objawów, a chorobę wykrywa się przypadkowo. Omdlenia i groźne arytmie wymagają pilnej oceny kardiologa.',
                ],
                [
                    'question' => 'Jak diagnozuje się kardiomiopatię?',
                    'answer'   => 'Podstawą jest badanie, EKG i echokardiografia (USG serca), która ocenia budowę i kurczliwość. Pomocny bywa rezonans magnetyczny serca, a przy podejrzeniu podłoża dziedzicznego rozważa się badania genetyczne i diagnostykę u krewnych. W wybranych przypadkach wykonuje się biopsję mięśnia sercowego.',
                ],
                [
                    'question' => 'Jak leczy się kardiomiopatię?',
                    'answer'   => 'Leczenie zależy od typu i objawów. Stosuje się leki wspierające pracę serca i kontrolujące rytm oraz leczenie niewydolności serca, jeśli się rozwija. U osób z podwyższonym ryzykiem groźnych arytmii rozważa się wszczepialny kardiowerter-defibrylator (ICD), a w zaawansowanych przypadkach inne zabiegi lub przeszczep. Plan ustala kardiolog.',
                ],
                [
                    'question' => 'Czy kardiomiopatia jest dziedziczna i co to oznacza dla rodziny?',
                    'answer'   => 'Część kardiomiopatii, zwłaszcza przerostowa, ma podłoże genetyczne i może występować u krewnych. Dlatego po rozpoznaniu u jednej osoby lekarz często zaleca badania kardiologiczne najbliższej rodziny, by wcześnie wykryć chorobę u kolejnych członków. Wczesne wykrycie pozwala lepiej chronić serce i ograniczyć ryzyko powikłań.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Arbelo E., Protonotarios A., Gimeno J.R. i wsp.',
                    'title'     => '2023 ESC Guidelines for the management of cardiomyopathies',
                    'publisher' => 'European Heart Journal',
                    'note'      => '2023; 44(37): 3503-3626',
                ],
                [
                    'authors'   => 'American Heart Association',
                    'title'     => 'Cardiomyopathy',
                    'publisher' => 'AHA',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'tetniak-aorty-piersiowej' => [
            'faq' => [
                [
                    'question' => 'Czym jest tętniak aorty piersiowej?',
                    'answer'   => 'To miejscowe poszerzenie aorty w odcinku piersiowym, powstające tam, gdzie jej ściana traci wytrzymałość i rozciąga się pod naporem krwi. O tętniaku mówi się, gdy średnica aorty istotnie przekracza normę. Powiększający się tętniak grozi groźnymi powikłaniami, dlatego wymaga kontroli.',
                ],
                [
                    'question' => 'Jakie są przyczyny i czynniki ryzyka tętniaka aorty?',
                    'answer'   => 'Najczęstsze przyczyny to miażdżyca i nadciśnienie osłabiające ścianę naczynia oraz choroby tkanki łącznej i uwarunkowania genetyczne (na przykład zespół Marfana). Ryzyko zwiększają wiek powyżej 65 lat, płeć męska, palenie tytoniu, nadciśnienie oraz tętniaki w rodzinie. Znaczenie ma też wrodzona dwupłatkowa zastawka aortalna.',
                ],
                [
                    'question' => 'Czy tętniak aorty piersiowej daje objawy?',
                    'answer'   => 'Najczęściej przez długi czas nie daje żadnych objawów i bywa wykrywany przypadkowo w badaniach obrazowych. Gdy jest duży, może powodować ból w klatce piersiowej lub plecach, chrypkę, kaszel czy uczucie braku powietrza. Nagły, bardzo silny ból może oznaczać groźne powikłanie i wymaga natychmiastowej pomocy.',
                ],
                [
                    'question' => 'Jak wykrywa się tętniaka aorty?',
                    'answer'   => 'Tętniaka uwidaczniają badania obrazowe: tomografia komputerowa, rezonans magnetyczny oraz echokardiografia, a w niektórych lokalizacjach USG. Pozwalają zmierzyć średnicę aorty i obserwować, czy tętniak się powiększa. Regularne kontrole są podstawą bezpiecznego prowadzenia pacjenta.',
                ],
                [
                    'question' => 'Jak leczy się tętniaka aorty piersiowej?',
                    'answer'   => 'Małe, stabilne tętniaki zwykle się obserwuje, kontrolując średnicę i lecząc nadciśnienie oraz inne czynniki ryzyka, w tym zalecając rzucenie palenia. Gdy tętniak osiąga większe rozmiary lub szybko rośnie, rozważa się leczenie zabiegowe: operację naprawczą lub wewnątrznaczyniowe wszczepienie stentgraftu. Decyzję podejmuje się indywidualnie.',
                ],
                [
                    'question' => 'Czym grozi nieleczony tętniak aorty?',
                    'answer'   => 'Najpoważniejsze powikłania to pęknięcie tętniaka oraz rozwarstwienie aorty, które są bezpośrednim zagrożeniem życia. Ryzyko rośnie wraz ze średnicą i tempem powiększania się tętniaka. Dlatego tak ważne są regularne kontrole i kontrola czynników ryzyka, zwłaszcza ciśnienia i palenia.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Erbel R., Aboyans V., Boileau C. i wsp.',
                    'title'     => '2014 ESC Guidelines on the diagnosis and treatment of aortic diseases',
                    'publisher' => 'European Heart Journal',
                    'note'      => '2014; 35(41): 2873-2926',
                ],
                [
                    'authors'   => 'American Heart Association',
                    'title'     => 'Aortic Aneurysm',
                    'publisher' => 'AHA',
                    'note'      => 'Materiał edukacyjny dla pacjentów',
                ],
            ],
        ],
        'czym-jest-dwubiegunowosc-jak-ja-rozpoznac-i-jakie-sa-mozliwosci-leczenia' => [
            'faq' => [
                [
                    'question' => 'Czym jest choroba afektywna dwubiegunowa?',
                    'answer'   => 'To przewlekła choroba psychiczna, w której nastrój zmienia się w skrajnych zakresach: od epizodów podwyższonego nastroju i energii (mania lub łagodniejsza hipomania) po epizody depresji. Między epizodami często występują okresy względnej równowagi. Choroba istotnie wpływa na życie, ale można ją skutecznie leczyć.',
                ],
                [
                    'question' => 'Czym różni się typ I od typu II?',
                    'answer'   => 'W typie I występują pełne epizody manii, często bardzo nasilone, na przemian z epizodami depresji. W typie II zamiast pełnej manii pojawia się łagodniejsza hipomania, ale epizody depresji bywają długie i ciężkie. Rozróżnienie jest ważne, bo wpływa na dobór leczenia.',
                ],
                [
                    'question' => 'Jak rozpoznać epizod manii i hipomanii?',
                    'answer'   => 'Typowe są podwyższony lub drażliwy nastrój, wyraźnie zwiększona energia, zmniejszona potrzeba snu, gadatliwość, gonitwa myśli oraz impulsywne, ryzykowne decyzje, na przykład nieprzemyślane wydatki. W manii objawy są na tyle silne, że poważnie zaburzają funkcjonowanie, a w hipomanii łagodniejsze. Takie zmiany warto skonsultować ze specjalistą.',
                ],
                [
                    'question' => 'Co powoduje chorobę dwubiegunową?',
                    'answer'   => 'Nie ma jednej przyczyny. Dużą rolę odgrywają czynniki genetyczne, dlatego choroba często występuje rodzinnie, a do ujawnienia się przyczyniają stres, trudne wydarzenia życiowe, zaburzenia snu czy używki. To połączenie podatności biologicznej i czynników środowiskowych.',
                ],
                [
                    'question' => 'Jak leczy się chorobę dwubiegunową?',
                    'answer'   => 'Podstawą jest farmakoterapia stabilizująca nastrój, w tym lit oraz niektóre leki przeciwpadaczkowe i przeciwpsychotyczne, dobierane przez psychiatrę. Leczenie jest zwykle długoterminowe i ma zapobiegać kolejnym epizodom. Uzupełnia je psychoterapia, psychoedukacja, dbanie o regularny sen i rytm dnia oraz wsparcie bliskich.',
                ],
                [
                    'question' => 'Czy z chorobą dwubiegunową można normalnie żyć?',
                    'answer'   => 'Tak. Przy regularnym leczeniu i stabilnym trybie życia wiele osób funkcjonuje na co dzień, pracuje i utrzymuje relacje. Kluczowe są systematyczne przyjmowanie leków, kontakt z psychiatrą oraz szybkie reagowanie na wczesne sygnały nawrotu. Samodzielne odstawianie leków po poprawie często prowadzi do nawrotu epizodu.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Grande I., Berk M., Birmaher B., Vieta E.',
                    'title'     => 'Bipolar disorder',
                    'publisher' => 'The Lancet',
                    'note'      => '2016; 387(10027): 1561-1572',
                ],
                [
                    'authors'   => 'World Health Organization',
                    'title'     => 'Bipolar disorder',
                    'publisher' => 'WHO',
                    'note'      => 'Materiał informacyjny dla pacjentów',
                ],
            ],
        ],
        'czym-jest-adhd-u-doroslych-objawy-diagnostyka-i-leczenie' => [
            'faq' => [
                [
                    'question' => 'Czym jest ADHD u dorosłych?',
                    'answer'   => 'ADHD to zaburzenie neurorozwojowe rozpoczynające się w dzieciństwie, którego objawy u części osób utrzymują się w dorosłości. Dotyczą głównie uwagi, nadmiernej ruchliwości i impulsywności, choć u dorosłych obraz bywa inny niż u dzieci. To nie kwestia lenistwa czy braku charakteru, lecz sposobu, w jaki funkcjonuje mózg.',
                ],
                [
                    'question' => 'Jak ADHD objawia się u dorosłych?',
                    'answer'   => 'Częste są trudności ze skupieniem i organizacją, odkładanie i niekończenie zadań, chroniczne spóźnianie się, zapominanie o zobowiązaniach oraz szybka utrata motywacji. Nadruchliwość bywa mniej widoczna niż u dzieci, częściej jako wewnętrzny niepokój. Dochodzi też impulsywność i trudności w regulacji emocji.',
                ],
                [
                    'question' => 'Czym ADHD u dorosłych różni się od ADHD u dzieci?',
                    'answer'   => 'U dorosłych wyraźna nadruchliwość zwykle słabnie lub zmienia się w wewnętrzne napięcie, a na pierwszy plan wysuwają się problemy z koncentracją, organizacją i regulacją emocji. Objawy odbijają się głównie na pracy, nauce i relacjach. Aby rozpoznać ADHD u dorosłego, ich ślady muszą sięgać dzieciństwa.',
                ],
                [
                    'question' => 'Jak diagnozuje się ADHD u dorosłych?',
                    'answer'   => 'Nie ma jednego testu na ADHD. Diagnozę stawia specjalista na podstawie szczegółowego wywiadu, w tym z dzieciństwa, oraz kwestionariuszy i oceny wpływu objawów na codzienne życie. Według kryteriów objawy powinny być obecne już przed okresem dorastania i istotnie utrudniać funkcjonowanie w więcej niż jednym obszarze. Ważne jest też wykluczenie innych przyczyn.',
                ],
                [
                    'question' => 'Jak leczy się ADHD u dorosłych?',
                    'answer'   => 'Leczenie zwykle łączy kilka metod. Stosuje się farmakoterapię wpływającą na działanie neuroprzekaźników, dobieraną przez lekarza, oraz psychoterapię, zwłaszcza poznawczo-behawioralną. Dużą rolę odgrywa nauka praktycznych strategii: zarządzania czasem, organizacji i radzenia sobie z emocjami. Plan dobiera się indywidualnie.',
                ],
                [
                    'question' => 'Czy warto diagnozować ADHD w dorosłości?',
                    'answer'   => 'Tak, bo trafne rozpoznanie pozwala zrozumieć dotychczasowe trudności i wdrożyć skuteczne wsparcie. Leczenie i odpowiednie strategie często wyraźnie poprawiają funkcjonowanie w pracy, nauce i relacjach oraz samopoczucie. Nierozpoznane ADHD bywa natomiast źródłem przewlekłego stresu, a czasem współwystępuje z depresją czy lękiem.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Posner J., Polanczyk G.V., Sonuga-Barke E.',
                    'title'     => 'Attention-deficit hyperactivity disorder',
                    'publisher' => 'The Lancet',
                    'note'      => '2020; 395(10222): 450-462',
                ],
                [
                    'authors'   => 'National Institute for Health and Care Excellence (NICE)',
                    'title'     => 'Attention deficit hyperactivity disorder: diagnosis and management (NG87)',
                    'publisher' => 'NICE',
                    'note'      => '2018, aktualizacja 2019',
                ],
            ],
        ],
        'spektrum-autyzmu-co-to-jest-i-jak-rozpoznac-objawy' => [
            'faq' => [
                [
                    'question' => 'Czym jest spektrum autyzmu?',
                    'answer'   => 'To grupa zaburzeń neurorozwojowych wpływających na komunikację, relacje społeczne oraz sposób odbierania świata, którym towarzyszą powtarzalne zachowania i wąskie, intensywne zainteresowania. Mówi się o spektrum, bo objawy i ich nasilenie są bardzo różne u różnych osób. To nie choroba, lecz odmienny sposób funkcjonowania mózgu.',
                ],
                [
                    'question' => 'Jakie są objawy spektrum autyzmu?',
                    'answer'   => 'U dzieci zwracają uwagę ograniczony kontakt wzrokowy, słabsza reakcja na imię, opóźniony lub nietypowy rozwój mowy, powtarzalne zachowania oraz silne przywiązanie do rutyny. U dorosłych częste są trudności w relacjach i rozumieniu niuansów społecznych, jak ironia, potrzeba przewidywalności oraz intensywne zainteresowania. Obraz bywa bardzo zróżnicowany.',
                ],
                [
                    'question' => 'Kiedy ujawnia się autyzm?',
                    'answer'   => 'Pierwsze sygnały pojawiają się zwykle we wczesnym dzieciństwie, choć u części osób, zwłaszcza bez niepełnosprawności intelektualnej, diagnozę stawia się dopiero w wieku szkolnym lub w dorosłości. Bywa, że trudności stają się wyraźne, gdy rosną wymagania społeczne. Wczesne rozpoznanie ułatwia dobranie wsparcia.',
                ],
                [
                    'question' => 'Dlaczego autyzm bywa później rozpoznawany u kobiet?',
                    'answer'   => 'Kobiety i dziewczęta częściej maskują trudności, naśladując zachowania społeczne otoczenia, przez co objawy są mniej widoczne. Takie maskowanie bywa wyczerpujące i opóźnia rozpoznanie, a nierozpoznane trudności mogą prowadzić do przeciążenia, lęku czy obniżonego nastroju. Dlatego warto brać pod uwagę autyzm także u kobiet.',
                ],
                [
                    'question' => 'Jak diagnozuje się spektrum autyzmu?',
                    'answer'   => 'Diagnoza opiera się na szczegółowym wywiadzie obejmującym rozwój od dzieciństwa, obserwacji oraz testach psychologicznych, często z udziałem zespołu specjalistów. Nie ma pojedynczego badania laboratoryjnego, które potwierdza autyzm. Ocena uwzględnia też wykluczenie lub rozpoznanie współwystępujących trudności.',
                ],
                [
                    'question' => 'Jakie wsparcie pomaga osobom w spektrum autyzmu?',
                    'answer'   => 'Pomaga indywidualnie dobrane wsparcie: terapia rozwijająca umiejętności komunikacyjne i społeczne, dostosowanie otoczenia i rutyny, a w razie potrzeby pomoc psychologiczna przy współwystępującym lęku czy obniżonym nastroju. Celem nie jest zmiana osobowości, lecz ułatwienie codziennego funkcjonowania i wykorzystanie mocnych stron.',
                ],
            ],
            'sources' => [
                [
                    'authors'   => 'Lord C., Elsabbagh M., Baird G., Veenstra-Vanderweele J.',
                    'title'     => 'Autism spectrum disorder',
                    'publisher' => 'The Lancet',
                    'note'      => '2018; 392(10146): 508-520',
                ],
                [
                    'authors'   => 'World Health Organization',
                    'title'     => 'Autism',
                    'publisher' => 'WHO',
                    'note'      => 'Materiał informacyjny dla pacjentów',
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

    update_option('fitmedica_faq_setup_v10', true);
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
