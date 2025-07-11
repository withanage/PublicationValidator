{**
 * plugins/generic/publicationValidator/templates/settings.tpl
 *
 * Copyright (c) 2014-2019 Simon Fraser University
 * Copyright (c) 2003-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Settings form for the metadataCheck plugin.
 *}
<script>
	$(function() {ldelim}
		$('#metadataCheckSettings').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});
</script>

<form
	class="pkp_form"
	id="metadataCheckSettings"
	method="POST"
	action="{url router=$smarty.const.ROUTE_COMPONENT op="manage" category="generic" plugin=$pluginName verb="settings" save=true}"
>
	<!-- Always add the csrf token to secure your form -->
	{csrf}

	{fbvFormArea}
		{fbvFormSection label="plugins.generic.metadataCheck.setting.description" for="description" list=true}
			{fbvElement
				type="checkbox"
				name="enableOpenAire"
				id="enableOpenAire"
				checked=$enableOpenAire
				value=true
				label="plugins.generic.metadataCheck.setting.enableOpenAire.description"
				disabled=$disableOpenAire
				translate="true"
			}
			<ul id='openAire-list'>
				<li>{$validateOpenAireFields}</li>
			</ul>
			{fbvElement
				type="checkbox"
				name="enableDoaj"
				id="enableDoaj"
				checked=$enableDoaj
				value=true
				label="plugins.generic.metadataCheck.setting.enableDoaj.description"
            	disabled=$disableDoaj
				translate="true"
			}
			<ul id='doaj-list'>
				<li>{$validateDoajFields}</li>
			</ul>
		{/fbvFormSection}
	{/fbvFormArea}
	{fbvFormButtons submitText="common.save"}
</form>
<script src="{$metadataCheckJsUrl}"></script>
