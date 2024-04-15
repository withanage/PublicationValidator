{**
 * plugins/generic/publicationValidator/templates/settings.tpl
 *
 * Copyright (c) 2014-2019 Simon Fraser University
 * Copyright (c) 2003-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Settings form for the publicationValidator plugin.
 *}
<script>
	$(function() {ldelim}
		$('#publicationValidatorSettings').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});
</script>

<form
	class="pkp_form"
	id="publicationValidatorSettings"
	method="POST"
	action="{url router=$smarty.const.ROUTE_COMPONENT op="manage" category="generic" plugin=$pluginName verb="settings" save=true}"
>
	<!-- Always add the csrf token to secure your form -->
	{csrf}

	{fbvFormArea}
		{fbvFormSection label="plugins.generic.publicationValidator.setting.description" for="description" list=true}

			{fbvElement
				type="checkbox"
				name="enableDoaj"
				id="enableDoaj"
				checked=$enableDoaj
				value=true
				label="plugins.generic.publicationValidator.setting.enableDoaj.description"
            	disabled=$disableDoaj
				translate="true"
			}
			<ul id='doaj-list'>
				<li>{$validateDoajFields}</li>
			</ul>
			{fbvElement
				type="checkbox"
				name="enableBase"
				id="enableBase"
				checked=$enableBase
				value=true
				label="plugins.generic.publicationValidator.setting.enableBase.description"
            	disabled=$disableBase
				translate="true"
			}
			{fbvElement
				type="checkbox"
				name="enableWebOfScience"
				id="enableWebOfScience"
				checked=$enableWebOfScience
				value=true
				label="plugins.generic.publicationValidator.setting.enableWebOfScience.description"
            	disabled=$disableWebOfScience
				translate="true"
			}
			{fbvElement
				type="checkbox"
				name="enableCrossref"
				id="enableCrossref"
				checked=$enableCrossref
				value=true
				label="plugins.generic.publicationValidator.setting.enableCrossref.description"
            	disabled=$disableCrossref
				translate="true"
			}
			{fbvElement
				type="checkbox"
				name="enableJGate"
				id="enableJGate"
				checked=$enableJGate
				value=true
				label="plugins.generic.publicationValidator.setting.enableJGate.description"
            	disabled=$disableJGate
				translate="true"
			}
		{/fbvFormSection}
	{/fbvFormArea}
	{fbvFormButtons submitText="common.save"}
</form>
<script src="{$publicationValidatorJsUrl}"></script>
