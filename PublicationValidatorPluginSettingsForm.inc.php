<?php
import('lib.pkp.classes.form.Form');
class PublicationValidatorPluginSettingsForm extends Form
{
	public $plugin;

	/**
	 * @copydoc Form::__construct()
	 */
	public function __construct($plugin) {

		// Define the settings template and store a copy of the plugin object
		parent::__construct($plugin->getTemplateResource('settings.tpl'));
		$this->plugin = $plugin;

		// Always add POST and CSRF validation to secure your form.
		$this->addCheck(new FormValidatorPost($this));
		$this->addCheck(new FormValidatorCSRF($this));
	}

	/**
	 * Load settings already saved in the database
	 *
	 * Settings are stored by context, so that each journal or press
	 * can have different settings.
	 */
	public function initData() {
		$contextId = Application::get()->getRequest()->getContext()->getId();
		$this->setData('enableOpenAire', $this->plugin->getSetting($contextId, 'enableOpenAire'));
		$this->setData('enableDoaj', $this->plugin->getSetting($contextId, 'enableDoaj'));
		$this->setData('enableBase', $this->plugin->getSetting($contextId, 'enableBase'));
		$this->setData('enableWebOfScience', $this->plugin->getSetting($contextId, 'enableWebOfScience'));
		$this->setData('enableCrossref', $this->plugin->getSetting($contextId, 'enableCrossref'));
		$this->setData('enableJGate', $this->plugin->getSetting($contextId, 'enableJGate'));
		parent::initData();
	}

	/**
	 * Load data that was submitted with the form
	 */
	public function readInputData() {
		$this->readUserVars(['enableOpenAire', 'enableDoaj', 'enableBase', 'enableWebOfScience', 'enableCrossref', 'enableJGate']);
		parent::readInputData();
	}

	/**
	 * Fetch any additional data needed for your form.
	 *
	 * Data assigned to the form using $this->setData() during the
	 * initData() or readInputData() methods will be passed to the
	 * template.
	 *
	 * @return string
	 */
	public function fetch($request, $template = null, $display = false) {
		AppLocale::requireComponents(
			LOCALE_COMPONENT_APP_DEFAULT,
			LOCALE_COMPONENT_APP_COMMON,
			LOCALE_COMPONENT_PKP_DEFAULT,
			LOCALE_COMPONENT_PKP_COMMON,
			LOCALE_COMPONENT_PKP_USER
		);

		// Pass the plugin name to the template so that it can be
		// used in the URL that the form is submitted to
		$templateMgr = TemplateManager::getManager($request);
		$templateMgr->assign('pluginName', $this->plugin->getName());
		$templateMgr->assign('disableOpenAire', $this->plugin->isGloballyConfigured('openair'));
		$templateMgr->assign('disableDoaj', $this->plugin->isGloballyConfigured('doaj'));
		$templateMgr->assign('disableBase', $this->plugin->isGloballyConfigured('base'));
		$templateMgr->assign('disableOpenWebOfScience', $this->plugin->isGloballyConfigured('web_of_science'));
		$templateMgr->assign('disableCrossref', $this->plugin->isGloballyConfigured('crossref'));
		$templateMgr->assign('disableJGate', $this->plugin->isGloballyConfigured('jgate'));
		$templateMgr->assign('validateOpenAireFields', $this->plugin->validateOpenAireFields());
		$templateMgr->assign('validateDoajFields', $this->plugin->validateDoajFields());
		$templateMgr->assign(
			'publicationValidatorJsUrl',
			$request->getBaseUrl() . '/' . $this->plugin->getPluginPath() . '/js/publicationValidator.js',
		);
		return parent::fetch($request, $template, $display);
	}

	/**
	 * Save the settings
	 *
	 * @return null|mixed
	 */
	public function execute(...$functionArgs) {
		$contextId = Application::get()->getRequest()->getContext()->getId();
		$this->plugin->updateSetting($contextId, 'enableOpenAire', $this->getData('enableOpenAire'));
		$this->plugin->updateSetting($contextId, 'enableDoaj', $this->getData('enableDoaj'));
		$this->plugin->updateSetting($contextId, 'enableBase', $this->getData('enableBase'));
		$this->plugin->updateSetting($contextId, 'enableWebOfScience', $this->getData('enableWebOfScience'));
		$this->plugin->updateSetting($contextId, 'enableCrossref', $this->getData('enableCrossref'));
		$this->plugin->updateSetting($contextId, 'enableJGate', $this->getData('enableJGate'));

		// Tell the user that the save was successful.
		import('classes.notification.NotificationManager');
		$notificationMgr = new NotificationManager();
		$notificationMgr->createTrivialNotification(
			Application::get()->getRequest()->getUser()->getId(),
			NOTIFICATION_TYPE_SUCCESS,
			['contents' => __('common.changesSaved')]
		);

		return parent::execute(...$functionArgs);
	}
}
