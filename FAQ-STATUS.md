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

### Maja FAQ wklejony w tresc (Elementor HTML widget) - NIE nasz plugin
Te artykuly mialy juz FAQ w naszym wygladzie wklejony staticznie w body + wlasna schema FAQPage. NIE dodawac pluginem (byl duplikat 2026-06-05, usuniety przez delete_post_meta). Do ewentualnej migracji do pluginu trzeba najpierw usunac widget z tresci.
- kolano-biegacza (ID 3349) - FAQ w body, 1 schema
- zespol-ciesni-nadgarstka (ID 4902) - FAQ w body, 1 schema

## MAJA FAQ W STARYM WYGLADZIE - DO PRZEROBIENIA (jeszcze nie zrobione)
- lokiec-tenisisty-przyczyny-objawy-profilaktyka-i-mozliwosci-leczenia (FAQ 6 + schema + zrodla w body)
- czym-jest-lokiec-golfisty-i-jak-go-leczyc (schema FAQPage obecna)
- zespol-zamrozonego-barku (schema FAQPage obecna)
- dna-moczanowa (faq-container + schema w body)
- reumatoidalne-zapalenie-stawow (faq-container + schema w body)
- lordoza-szyjna-fizjologia-zaburzenia-sposoby-postepowania (faq + schema w body)
- krecz-szyi-przyczyny-objawy-i-leczenie (faq + schema w body)
- szpotawosc-kolan-przyczyny-objawy-i-skuteczne-metody-leczenia (faq + schema w body)
- bole-bioder-przyczyny-objawy-i-profilaktyka (faq + schema w body)

## Zrodla - zasada
Kazde zrodlo naukowe zweryfikowane (PubMed/PMID/DOI) przed wpisaniem. Zero zmyslonych cytowan.

## Lekcja 2026-06-05
Rekonesans przed dodaniem MUSI grepowac sam `faq-container` w body, nie tylko naglowek FAQ i schema. kolano i ciesn mialy FAQ wklejony jako Elementor HTML widget (bez naglowka), recon to przeoczyl, plugin dolozyl duplikat na prodzie. Naprawione delete_post_meta + usuniecie z bloku v3.
