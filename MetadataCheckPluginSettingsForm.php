<?php
namespace APP\plugins\generic\metadataCheck;

use APP\core\Application;
use APP\notification\NotificationManager;
use APP\template\TemplateManager;
use PKP\form\Form;
use PKP\form\validation\FormValidatorCSRF;
use PKP\form\validation\FormValidatorPost;
use PKP\notification\Notification;

class MetadataCheckPluginSettingsForm extends Form
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
		parent::initData();
	}

	/**
	 * Load data that was submitted with the form
	 */
	public function readInputData() {
		$this->readUserVars(['enableOpenAire', 'enableDoaj',]);
		parent::readInputData();
	}

    /**
     * create a message which fields will be
     * validated before publish when enabled OpenAire
     * @return string
     */
    public function validateOpenAireFields(): string
    {
        return __('plugins.generic.metadataCheck.field.abstract') . ' ,' .
            __('plugins.generic.metadataCheck.field.authors') . ' ,' .
            __('plugins.generic.metadataCheck.field.authorAffiliation') . ' ,' .
            __('plugins.generic.metadataCheck.field.articleTitle') . ' ,' .
            __('plugins.generic.metadataCheck.field.locale') . ' ,' .
            __('plugins.generic.metadataCheck.field.publisher') . ' ,' .
            __('plugins.generic.metadataCheck.field.doi') . ' ,' .
            __('plugins.generic.metadataCheck.field.issn') . ' ,' .
            __('plugins.generic.metadataCheck.field.subjects') . ' ,' .
            __('plugins.generic.metadataCheck.field.licenseUrl') . ' ,' .
            __('plugins.generic.metadataCheck.field.rights') . ' ,' .
            __('plugins.generic.metadataCheck.field.common');
    }

    /**
     * create a message which fields will be
     * validated before publish when enabled DOAJ
     * @return string
     */
    public function validateDoajFields(): string
    {
        return __('plugins.generic.metadataCheck.field.abstract') . ' ,' .
            __('plugins.generic.metadataCheck.field.articleTitle') . ' ,' .
            __('plugins.generic.metadataCheck.field.locale') . ' ,' .
            __('plugins.generic.metadataCheck.field.publisher') . ' ,' .
            __('plugins.generic.metadataCheck.field.doi') . ' ,' .
            __('plugins.generic.metadataCheck.field.issn') . ' ,' .
            __('plugins.generic.metadataCheck.field.common');
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
		// Pass the plugin name to the template so that it can be
		// used in the URL that the form is submitted to
		$templateMgr = TemplateManager::getManager($request);
		$templateMgr->assign('pluginName', $this->plugin->getName());
		$templateMgr->assign('disableOpenAire', $this->plugin->isGloballyConfigured('openair'));
		$templateMgr->assign('disableDoaj', $this->plugin->isGloballyConfigured('doaj'));
		$templateMgr->assign('validateOpenAireFields', $this->validateOpenAireFields());
		$templateMgr->assign('validateDoajFields', $this->validateDoajFields());
		$templateMgr->assign(
			'metadataCheckJsUrl',
			$request->getBaseUrl() . '/' . $this->plugin->getPluginPath() . '/js/metadata.js',
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

		// Tell the user that the save was successful.
		$notificationMgr = new NotificationManager();
		$notificationMgr->createTrivialNotification(
			Application::get()->getRequest()->getUser()->getId(),
            Notification::NOTIFICATION_TYPE_SUCCESS,
			['contents' => __('common.changesSaved')]
		);

		return parent::execute(...$functionArgs);
	}
}
