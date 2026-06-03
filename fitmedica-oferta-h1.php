<?php
/**
 * Plugin Name: Fitmedica Oferta H1 Override
 * Description: Nadpisuje H1 bannera i ostatni okruszek breadcrumb NavXT dla wybranych podstron oferty (CPT medilink_departments). Nie rusza tytulu posta, strony glownej, menu ani listingow.
 * Version: 1.0
 */

if (!defined('ABSPATH')) {
	exit;
}

// CPT oferty w motywie Medilink. Rewrite slug w URL to 'oferta',
// ale rzeczywista nazwa post type (body class single-...) to ponizsza.
if (!defined('FITMEDICA_OFERTA_CPT')) {
	define('FITMEDICA_OFERTA_CPT', 'medilink_departments');
}

/**
 * Mapa post ID => docelowe H1. Klucz to ID wpisu (z body class postid-NNNN),
 * pewniejszy niz slug bo post_name potrafi sie roznic od sluga w URL.
 * Latwa do rozszerzenia o kolejne podstrony.
 *
 * @return array<int, string>
 */
function fitmedica_oferta_h1_map() {
	return array(
		3263  => 'Ortopedia Warszawa',                              // ortopeda (glowna)
		3236  => 'Poradnia Kardiologiczna Warszawa',                // dobry-kardiolog-warszawa-prywatnie
		3254  => 'Poradnia Neurologiczna Warszawa',                 // dobry-neurolog
		3269  => 'Poradnia Reumatologiczna Warszawa',               // dobry-reumatolog-prywatnie
		12578 => 'Poradnia Urologiczna Warszawa',                   // poradnia-urologiczna
		12464 => 'Poradnia Psychologiczna Warszawa',                // poradnia-psychologiczna
		12405 => 'Poradnia Zdrowia Psychicznego Warszawa',          // poradnia-zdrowia-psychicznego
		3248  => 'Poradnia Neurochirurgiczna Warszawa',             // neurochirurg
		13010 => 'Poradnia Dermatologiczna Warszawa',               // poradnia-dermatologiczna
		1145  => 'Poradnia Dietetyczna Warszawa',                   // dobry-dietetyk-warszawa
		7489  => 'Badania USG Warszawa',                            // usg
		7244  => 'Medycyna Sportowa Warszawa',                      // medycyna-sportowa
		15242 => 'Medycyna Sportowa dla dzieci Warszawa',           // medycyna-sportowa-dla-dzieci
		5847  => 'Rehabilitacja i Fizjoterapia Sportowa Warszawa',  // fizjoterapeuta-sportowy
		15231 => 'ECHO serca dziecka Warszawa',                     // eho-serca-dziecka
	);
}

/**
 * Zwraca nadpisane H1 dla danego wpisu albo null gdy brak w mapie.
 *
 * @param int $post_id ID wpisu.
 * @return string|null
 */
function fitmedica_get_oferta_h1_override($post_id) {
	$map = fitmedica_oferta_h1_map();

	return isset($map[(int) $post_id]) ? $map[(int) $post_id] : null;
}

// H1 bannera: Medilink renderuje go przez get_the_title() (odpala filtr the_title)
// na pojedynczej stronie oferty, poza glowna petla. Zawezamy do otwartego wpisu,
// dzieki czemu home, menu, listingi i widget powiazanych ofert pozostaja nietkniete.
add_filter(
	'the_title',
	function ($title, $id) {
		if (!is_singular(FITMEDICA_OFERTA_CPT) || (int) $id !== get_queried_object_id() || in_the_loop()) {
			return $title;
		}

		$override = fitmedica_get_oferta_h1_override((int) $id);

		return null !== $override ? $override : $title;
	},
	10,
	2
);

// Ostatni okruszek breadcrumb (Breadcrumb NavXT) - zeby szedl za nowym H1.
add_filter(
	'bcn_breadcrumb_title',
	function ($title, $type, $id) {
		if (!is_singular(FITMEDICA_OFERTA_CPT)) {
			return $title;
		}

		$post_id = $id ? (int) $id : get_queried_object_id();

		if ($post_id !== get_queried_object_id()) {
			return $title;
		}

		$override = fitmedica_get_oferta_h1_override($post_id);

		return null !== $override ? $override : $title;
	},
	10,
	3
);
