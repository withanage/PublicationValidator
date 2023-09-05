/**
 * @file plugins/generic/publicationValidator/js/publicationValidator.js
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

	if ($('#enableBase').is(':checked')) {
		$('#base-list').show();
	} else {
		$('#base-list').hide();
	}

	if ($('#enableWebOfScience').is(':checked')) {
		$('#webOfScience-list').show();
	} else {
		$('#webOfScience-list').hide();
	}

	if ($('#enableCrossref').is(':checked')) {
		$('#crossref-list').show();
	} else {
		$('#crossref-list').hide();
	}

	if ($('#enableJGate').is(':checked')) {
		$('#jGate-list').show();
	} else {
		$('#jGate-list').hide();
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
	$('#enableBase').click(function() {
		if ($('#enableBase').is(':checked')) {
			$('#base-list').show();
		} else {
			$('#base-list').hide();
		}
	});
	$('#enableWebOfScience').click(function() {
		if ($('#enableWebOfScience').is(':checked')) {
			$('#webOfScience-list').show();
		} else {
			$('#webOfScience-list').hide();
		}
	});
	$('#enableCrossref').click(function() {
		if ($('#enableCrossref').is(':checked')) {
			$('#crossref-list').show();
		} else {
			$('#crossref-list').hide();
		}
	});
	$('#enableJGate').click(function() {
		if ($('#enableJGate').is(':checked')) {
			$('#jGate-list').show();
		} else {
			$('#jGate-list').hide();
		}
	});
});
