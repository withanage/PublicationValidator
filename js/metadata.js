/**
 * @file plugins/generic/publicationValidator/js/metadata.js
 *
 * Copyright (c) 2014-2020 Simon Fraser University
 * Copyright (c) 2000-2020 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 */

$(document).ready(function() {
	if ($('#enableOpenAire').is(':checked')) {
		$('#openAire-list').show();
	} else {
		$('#openAire-list').hide();
	}

	if ($('#enableDoaj').is(':checked')) {
		$('#doaj-list').show();
	} else {
		$('#doaj-list').hide();
	}

	$('#enableOpenAire').click(function() {
		if ($('#enableOpenAire').is(':checked')) {
			$('#openAire-list').show();
		} else {
			$('#openAire-list').hide();
		}
	});
	$('#enableDoaj').click(function() {
		if ($('#enableDoaj').is(':checked')) {
			$('#doaj-list').show();
		} else {
			$('#doaj-list').hide();
		}
	});
});
