# Fitmedica - status FAQ + zrodla pod artykulami

Rejestr artykulow blogowych obrobionych pluginem `fitmedica-weryfikacja-medyczna.php`.

## Workflow (zasada per artykul)
1. Wejdz na artykul, sprawdz czy ma FAQ i zrodla. UWAGA: sprawdzaj tez sam markup `faq-container` w tresci (Elementor HTML widget), nie tylko naglowek "FAQ" i schema - bywa wklejony staticznie bez naglowka.
2. **Ma (stary lub wklejony wyglad)** -> przerob na nasz system (NIE dodawaj drugiego, bo duplikat FAQ + duplikat schemy FAQPage = kara SEO).
3. **Nie ma nic** -> dodaj FAQ + zrodla (zakorzenione w tresci + zweryfikowane zrodla naukowe).
4. Weryfikatora medycznego (badge) dodaje TYLKO Marcin recznie. Claude NIE przypisuje lekarza.

## ZROBIONE - NIE DOTYKAC

### W naszym pluginie, na produkcji
| Artykul (slug) | FAQ | Zrodla | Badge | Deploy |
|---|---|---|---|---|
| zerwany-biceps-przyczyny-leczenie-i-rehabilitacja | tak (6) | tak (4) | Jan Sala (dodal Marcin) | PROD |
| bol-achillesa-czym-dokladnie-jest-skad-sie-bierze-i-jakie-istnieja-mozliwosci-leczenia | tak (6) | tak (4) | Jan Sala (dodal Marcin) | PROD |
| zapalenie-rozciegna-podeszwowego-stopy-przyczyny-objawy-i-leczenie | nie | nie | Maciej Langner (dodal Marcin) | PROD |
| stenoza-kanalu-kregowego-przyczyny-objawy-i-leczenie | nie | nie | Maciej Langner (dodal Marcin) | PROD |
| skrecenie-stawu-skokowego-definicja-objawy-leczenie | tak (6) | tak (3) | brak | PROD (2026-06-05) |
| chondromalacja-rzepki-kolana-leczenie-przyczyny-objawy | tak (6) | tak (3) | brak | PROD (2026-06-05) |
| lakotka-lekotka-czyli-najczestsze-uszkodzenia-powodujace-bol-kolana | tak (6) | tak (2) | brak | PROD (2026-06-05) |
| korzonki-co-to-jest-i-jak-skutecznie-leczyc-bol-korzeni-nerwowych | tak (6) | tak (3) | brak | PROD (2026-06-05) |
| dyskopatia-diagnoza-i-leczenie | tak (6) | tak (3) | brak | PROD (2026-06-05) |
| palec-zatrzaskujacy-czym-jest-i-dlaczego-dochodzi-do-blokowania-palca | tak (6) | tak (2) | brak | PROD (2026-06-05) |
| czym-jest-osteoporoza | tak (6) | tak (2) | brak | PROD (2026-06-05) |
| choroba-zwyrodnieniowa-stawow | tak (6) | tak (2) | brak | PROD (2026-06-05) |
| skolioza-objawy-diagnostyka-i-leczenie-od-a-do-z | tak (6) | tak (2) | brak | PROD (2026-06-05) |
| uszkodzenie-wiezadla-krzyzowego-przedniego-wkp-acl-czyli-ze-sportem | tak (6) | tak (2) | brak | PROD (2026-06-05) |
| choroba-duputryena-przykurcz-rozciegna-dloniowego | tak (6) | tak (2) | brak | PROD (2026-06-05) |
| choroba-zwyrodnieniowa-stawow-kregoslupa-szyjnego | tak (6) | tak (2) | brak | PROD (2026-06-05) |
| wdowi-garb-co-to-jest-i-jak-skutecznie-go-leczyc | tak (6) | tak (2) | brak | PROD (2026-06-05) |
| choroba-scheuermanna-objawy-i-leczenie-kregoslupa | tak (6) | tak (2) | brak | PROD (2026-06-05) |
| osteotomia-na-czym-polega-i-co-warto-wiedziec-przed-zabiegiem | tak (6) | tak (1) | brak | PROD (2026-06-05) |
| bol-glowy-a-schorzenia-stawu-skroniowo-zuchwowego | tak (6) | tak (2) | brak | PROD (2026-06-05) |
| nadcisnienie-tetnicze-2 | tak (6) | tak (2) | brak | PROD (2026-06-05) |
| niedoczynnosc-tarczycy | tak (6) | tak (2) | brak | PROD (2026-06-05) |
| co-trzeba-wiedziec-o-cukrzycy-przyczyny-objawy-i-leczenie | tak (6) | tak (2) | brak | PROD (2026-06-05) |
| czym-jest-depresja-jak-ja-leczyc | tak (6) | tak (2) | brak | PROD (2026-06-05) |
| choroba-niedokrwienna-serca | tak (6) | tak (2) | brak | PROD (2026-06-05) |
| niewydolnosc-serca-przyczyny-objawy-leczenie | tak (6) | tak (2) | brak | PROD (2026-06-05) |
| zaburzenia-rytmu-serca-arytmia | tak (6) | tak (2) | brak | PROD (2026-06-05) |
| miazdzyca-naczyn-krwionosnych | tak (6) | tak (2) | brak | PROD (2026-06-05) |
| nadczynnosc-tarczycy | tak (6) | tak (2) | brak | PROD (2026-06-05) |
| choroba-hashimoto | tak (6) | tak (2) | brak | PROD (2026-06-06) |
| zawal-serca | tak (6) | tak (2) | brak | PROD (2026-06-06) |
| otylosc | tak (6) | tak (2) | brak | PROD (2026-06-06) |
| czym-sa-zaburzenia-lekowe-jak-je-diagnozowac-i-leczyc | tak (6) | tak (2) | brak | PROD (2026-06-06) |
| bezsennosc-przyczyny-objawy-i-sprawdzone-sposoby-na-poprawe-jakosci-snu | tak (6) | tak (2) | brak | PROD (2026-06-06) |
| kardiomiopatia | tak (6) | tak (2) | brak | PROD (2026-06-07) |
| tetniak-aorty-piersiowej | tak (6) | tak (2) | brak | PROD (2026-06-07) |
| czym-jest-dwubiegunowosc-jak-ja-rozpoznac-i-jakie-sa-mozliwosci-leczenia | tak (6) | tak (2) | brak | PROD (2026-06-07) |
| czym-jest-adhd-u-doroslych-objawy-diagnostyka-i-leczenie | tak (6) | tak (2) | brak | PROD (2026-06-07) |
| spektrum-autyzmu-co-to-jest-i-jak-rozpoznac-objawy | tak (6) | tak (2) | brak | PROD (2026-06-07) |
| bradykardia-przyczyny-objawy-i-leczenie | tak (6) | tak (2) | brak | PROD (2026-06-08) |
| kolatania-serca-przyczyny-i-objawy-jak-wyglada-leczenie | tak (6) | tak (2) | brak | PROD (2026-06-08) |
| jakie-badania-na-prostate-wykonac | tak (6) | tak (2) | brak | PROD (2026-06-08) |
| otylosc-u-dzieci | tak (6) | tak (2) | brak | PROD (2026-06-08) |
| nietolerancja-pokarmowa-przyczyny-objawy-i-leczenie | tak (6) | tak (1) | brak | PROD (2026-06-08) |
| kolano-biegacza | tak (6) | tak (4) | brak | PROD (2026-06-29, v12 - migracja z Elementora) |
| zespol-ciesni-nadgarstka | tak (6) | tak (4) | brak | PROD (2026-06-29, v13 - migracja z Elementora) |

### Maja FAQ wklejony w tresc (Elementor HTML widget) - NIE nasz plugin
~~Te artykuly mialy FAQ jako widget Elementora.~~ OBA zmigrowane 2026-06-29:
- ~~kolano-biegacza (ID 3349)~~ -> ZMIGROWANE (blok v12). FAQ jako 2 widgety HTML (sekcja id d044621: nag d9ad28d + faq-container 6c23b82). Usunieto cala sekcje, backup `_elementor_data_bak_faqmig12`.
- ~~zespol-ciesni-nadgarstka (ID 4902)~~ -> ZMIGROWANE (blok v13). FAQ jako 1 widget HTML (719e990) w sekcji z tekstem artykulu (nagl + faq-container + microdata + ld+json w jednym widgecie). Usunieto sam widget, backup `_elementor_data_bak_faqmig13`. Plugin przejal FAQ (6) + zrodla (4).

UWAGA wspolna: FAQ+zrodla z pluginu renderuja sie pod blokiem "Dowiedz sie wiecej" (the_content docina na koncu).

## DO PRZEROBIENIA - stan po AUDYCIE 2026-06-29 (stara lista byla nieaktualna!)
Audyt bazy (body vs plugin vs editor) pokazal realny stan. NOWA ZASADA (Marcin 2026-06-29): nie migrowac FAQ 1:1 - do KAZDEGO robic research SERP/People Also Ask i pisac IDEALNY FAQ + zweryfikowane zrodla. Patrz memory [[feedback-faq-research-driven]].

### Juz w pluginie, body czyste, zero duplikatu - NIE DOTYKAC (audyt potwierdzil)
- lokiec-tenisisty (16224) - plugin 6+4
- czym-jest-lokiec-golfisty (16320) - plugin 6+4
- szpotawosc-kolan (15725) - plugin 6+4
- torbiel-nad-kolanem (16323) - plugin 6+4

### ZROBIONE 2026-06-29 (research-driven, nowy FAQ)
- zespol-zamrozonego-barku (4896) -> v14. UWAGA: na zywej stronie byl BLEDNY FAQ (o ZLAMANIACH!), usuniety widget 4e015e11, backup `_elementor_data_bak_faqmig14`. Napisany nowy FAQ barkowy (6) + 3 zrodla (Neviaser/Hannafin 2010, Le 2017, AAOS).
- jak-wyglada-czerniak (13730) -> v15. Nie mial FAQ, napisany od zera (6) + 3 zrodla (Schadendorf Lancet 2018, wytyczne PTOK Rutkowski, AAD). Builder bez widgetu, samo wpiecie pluginem.

### ZROBIONE 2026-06-29 - blok v16 (research-driven, 6 wpisow, zweryfikowane zrodla)
Nowy idealny FAQ z PAA/SERP, stare widgety FAQ usuniete (backup `_elementor_data_bak_faqmig16`), plugin przejal 6 pyt + 2 zrodla kazdy:
- dna-moczanowa (4903) - widget 1b30d7f. Zrodla: EULAR/Richette 2017, Dalbeth Gout Lancet 2016
- reumatoidalne-zapalenie-stawow (3323) - widget 992e5cd. Zrodla: Smolen RA Lancet 2016, ACR
- lordoza-szyjna (4244) - widget 4967ac8. Zrodla: Scheer J Neurosurg Spine 2013, AAOS Neck Pain
- krecz-szyi (4476) - widget f04f525. Zrodla: Kaplan CMT CPG 2018, AAOS Congenital Muscular Torticollis
- bole-bioder (10367) - widget a0b39d3. Zrodla: Kolasinski ACR OA 2019/2020, AAOS Osteoarthritis of the Hip
- zlamanie-kosci-srodstopia (4270) - widget cb8f1e5. Zrodla: AAOS Metatarsal Fractures, EFORT Open Reviews 2022

### ZROBIONE 2026-06-29 - blok v17 (ostatni z listy)
- rekonstrukcja-wiezadla-krzyzowego (14127) - CLASSIC editor. FAQ siedzial w post_content jako blok wp:html (naglowek + faq-container microdata + osobny skrypt ld+json = 2x FAQPage). Wyciety z post_content (backup w meta `_post_content_bak_faqmig17`), plugin przejal FAQ (6) + zrodla (3: Filbay/Grindem 2019, Musahl/Karlsson NEJM 2019, AAOS ACL). FAQPage teraz 1.
  - FLAGA: w body zostala STARA bibliografia (Acta Clinica 1/2002, Zabek A. itd.) - wspolistnieje z nowa sekcja Zrodla z pluginu (2 listy zrodel). Do decyzji czy usunac stara bibliografie.

## AUDYT CALEGO BLOGA 2026-06-29 (155 wpisow)
- z FAQ w pluginie: 60 | z FAQ w body/elementor: 13 | BEZ FAQ: 82
- z 82 bez FAQ: ~28 realnych poradnikow (reszta = strony ofertowe/USG/newsy - NIE ruszac, decyzja Marcina)

### ZROBIONE 2026-06-29 - blok v18 (poradniki bez FAQ, partia 1, czyste dodanie)
research-driven FAQ + zweryfikowane zrodla, wpisy nie mialy FAQ (samo wpiecie):
- bole-glowy (2943) - ICHD-3 Cephalalgia 2018, mp.pl
- bol-kregoslupa-kiedy-do-lekarza (2935) - Maher LBP Lancet 2017, mp.pl
- szmery-w-sercu (10207) - Frank Am Fam Physician 2011, mp.pl
- reaktywne-zapalenie-stawow (3316) - Selmi Autoimmun Rev 2014, mp.pl
- zapalenie-gesiej-stopy (3356) - AAOS OrthoInfo, StatPearls
- czym-jest-nerwica-zoladka (14019) - Ford Functional dyspepsia Lancet 2020, mp.pl

### ZROBIONE 2026-06-29 - blok v19 (poradniki bez FAQ, partia 2)
- niewydolnosc-serca (909) - McDonagh ESC HF 2021, mp.pl. UWAGA: drugi artykul o niewydolnosci (niewydolnosc-serca-przyczyny-objawy-leczenie) tez ma FAQ - Marcin: oba sensowne, NIE kanibalizacja
- czy-komorki-macierzyste-serce (3563) - Banerjee Circ Res 2018, Kardiologia po Dyplomie. FAQ ostrozny (terapia eksperymentalna)
- niedoczynnosc-tarczycy-u-niemowlat (4898) - van Trotsenburg Thyroid 2021, IMiD przesiew
- wrastajace-paznokcie (3434) - Mayeaux AAFP 2019, mp.pl
- oparzenia-sloneczne (5156) - AAD, mp.pl
- co-to-jest-dermatoskopia (8284) - Vestergaard Br J Dermatol 2008, mp.pl

ZASADA Marcina 2026-06-29: KAZDY wpis blogowy dostaje FAQ (opr. czystych ogloszen typu "Wesolych Swiat"). Stron ofertowych /oferta/ (CPT) nie ruszac - maja FAQ osobno.

### ZROBIONE 2026-06-29 - blok v20 (poradniki bez FAQ, partia 3)
- artroskopia (2500) - AAOS Knee Arthroscopy, Thorlund BMJ 2015
- rehabilitacja-po-artroskopii-kolana (10410) - AAOS Knee Arthroscopy, mp.pl
- gips-czy-orteza (12373) - AAOS Care of Casts and Splints, mp.pl
- wady-postawy-u-dzieci (3398) - Negrini SOSORT 2018, mp.pl
- dolegliwosci-miesni-i-stawow-u-starszych (3369) - Kolasinski ACR OA 2019, mp.pl
- barefooting (16187) - Ridge MSSE 2019, Scientific Reports 2021

### ZROBIONE 2026-06-29 - blok v21 (poradniki bez FAQ, partia 4)
- sezon-bez-kontuzji (8342) - Lauersen BJSM 2014, mp.pl
- cwiczenia-na-zdrowy-kregoslup (8352) - Maher LBP Lancet 2017, mp.pl
- dziecko-z-niedoborem-masy-ciala (3291) - Homan FTT AAFP 2016, mp.pl
- badania-dzieci-w-kierunku-wad-postawy (3344) - Negrini SOSORT 2018, mp.pl
- testy-na-nietolerancje-pokarmowa (8348) - Stapel/EAACI Allergy 2008, AAAAI (testy IgG NIE zalecane)
- co-warto-wiedziec-o-psychoterapii (12942) - David CBT gold standard Front Psychiatry 2018, mp.pl

### POZOSTALE poradniki bez FAQ (partie 5+, do zrobienia tym samym trybem)
niewydolnosc-serca(909, UWAGA duplikat tematu z niewydolnoscia juz w pluginie - sprawdzic), czy-komorki-macierzyste-serce(3563), niedoczynnosc-tarczycy-u-niemowlat(4898), wrastanie-paznokci(3434), oparzenia-sloneczne(5156), co-to-jest-dermatoskopia(8284), psychoterapia-rodzaje(12942), testy-na-nietolerancje(8348), wady-postawy-u-dzieci(3398), badania-dzieci-wady-postawy(3344), dolegliwosci-miesni-u-starszych(3369), gips-czy-orteza(12373), barefooting(16187), artroskopia(2500), rehabilitacja-po-artroskopii-kolana(10410), cwiczenia-na-kregoslup(8352), dziecko-z-niedoborem-masy(3291), sezon-bez-kontuzji(8342). Borderline-lifestyle (do decyzji): spacer(11659), dieta-a-sport(11650), biegasz-na-zdrowie(5756).

## STATUS KONCOWY (2026-06-29): wszystkie 15 wpisow z listy FAQ ogarniete
- 4 byly juz w pluginie (lokiec-tenisisty, lokiec-golfisty, szpotawosc-kolan, torbiel-nad-kolanem)
- 11 zmigrowanych/napisanych dzis: kolano(v12), ciesn(v13), bark(v14, byl bledny FAQ), czerniak(v15, od zera), dna+RZS+lordoza+krecz+biodra+srodstopie(v16), ACL(v17)

## Zrodla - zasada
Kazde zrodlo naukowe zweryfikowane (PubMed/PMID/DOI) przed wpisaniem. Zero zmyslonych cytowan.

## Lekcja 2026-06-05
Rekonesans przed dodaniem MUSI grepowac sam `faq-container` w body, nie tylko naglowek FAQ i schema. kolano i ciesn mialy FAQ wklejony jako Elementor HTML widget (bez naglowka), recon to przeoczyl, plugin dolozyl duplikat na prodzie. Naprawione delete_post_meta + usuniecie z bloku v3.

## Lekcja 2026-06-29 (migracja kolana)
Wpisy blogowe fitmedica sa budowane ELEMENTOREM (`_elementor_edit_mode=builder`). Recon czytajacy `post_content` MYLI - to nieaktualny cache, front renderuje z `_elementor_data`. Realny FAQ/schema siedzi w widgetach HTML w `_elementor_data` (JSON). Migracja = znalezc widgety FAQ po id, usunac cala sekcje przez array_splice (z backupem _elementor_data do meta + walidacja ze ruszamy tylko widgety FAQ), wyczyscic Elementor CSS cache, potem plugin (blok vN) przejmuje FAQ+zrodla. Wzorzec skryptu migracji dziala - reuzyc dla ciesni-nadgarstka (4902) i listy DO PRZEROBIENIA.
