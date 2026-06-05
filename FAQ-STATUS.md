# Fitmedica - status FAQ + zrodla pod artykulami

Rejestr artykulow blogowych obrobionych pluginem `fitmedica-weryfikacja-medyczna.php`.

## Workflow (zasada per artykul)
1. Wejdz na artykul, sprawdz czy ma FAQ i zrodla.
2. **Ma (stary wyglad)** -> przerob na nasz nowy wyglad (przenies FAQ + zrodla do pluginu, nasz styl + schema FAQPage).
3. **Nie ma** -> dodaj FAQ + zrodla (zakorzenione w tresci + zweryfikowane zrodla naukowe).
4. Weryfikatora medycznego (badge) dodaje TYLKO Marcin recznie. Claude NIE przypisuje lekarza.

## ZROBIONE - NIE DOTYKAC

### W naszym pluginie, na produkcji
| Artykul (slug) | FAQ | Zrodla | Badge weryfikacji | Deploy |
|---|---|---|---|---|
| zerwany-biceps-przyczyny-leczenie-i-rehabilitacja | tak (6) | tak (4) | Jan Sala (dodal Marcin) | PROD |
| bol-achillesa-czym-dokladnie-jest-skad-sie-bierze-i-jakie-istnieja-mozliwosci-leczenia | tak (6) | tak (4) | Jan Sala (dodal Marcin) | PROD |
| zapalenie-rozciegna-podeszwowego-stopy-przyczyny-objawy-i-leczenie | nie | nie | Maciej Langner (dodal Marcin) | PROD |
| stenoza-kanalu-kregowego-przyczyny-objawy-i-leczenie | nie | nie | Maciej Langner (dodal Marcin) | PROD |

### W naszym pluginie, zacommitowane (deploy osobno)
| Artykul (slug) | FAQ | Zrodla | Badge | Deploy |
|---|---|---|---|---|
| kolano-biegacza | tak (6) | tak (4) | brak | committed, nie wdrozone |
| zespol-ciesni-nadgarstka | tak (6) | tak (4) | brak | committed, nie wdrozone |
| skrecenie-stawu-skokowego-definicja-objawy-leczenie | tak (6) | tak (3) | brak | committed, nie wdrozone |

## MAJA FAQ W STARYM WYGLADZIE - DO PRZEROBIENIA na nasz look (jeszcze nie zrobione)
Te artykuly maja juz FAQ/schema/zrodla wbudowane w tresc (Elementor), NIE w naszym pluginie. Wg workflow do konwersji na nasz wyglad.
- lokiec-tenisisty-przyczyny-objawy-profilaktyka-i-mozliwosci-leczenia (FAQ 6 + schema FAQPage + zrodla w body)
- czym-jest-lokiec-golfisty-i-jak-go-leczyc (schema FAQPage obecna)
- zespol-zamrozonego-barku (schema FAQPage obecna)

## Zrodla - zasada
Kazde zrodlo naukowe zweryfikowane (PubMed/PMID/DOI) przed wpisaniem. Zero zmyslonych cytowan.
