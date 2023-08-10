<?php


import('lib.pkp.classes.plugins.GenericPlugin');

class PublicationValidatorPlugin extends GenericPlugin
{
	public function register($category, $path, $mainContextId = NULL)
	{
		// Register the plugin even when it is not enabled
		$success = parent::register($category, $path);

		if ($success && $this->getEnabled()) {
			// Do something when the plugin is enabled
		}

		return $success;
	}

	/**
	 * @copydoc Plugin::getDisplayName()
	 */
	public function getDisplayName()
	{
		return __('plugins.generic.publicationValidator.displayName');
	}

	/**
	 * @copydoc Plugin::getDescription()
	 */
	public function getDescription()
	{
		return __('plugins.generic.publicationValidator.description');
	}
    /**
     * Add a settings action to the plugin's entry in the
     * plugins list.
     *
     * @param Request $request
     * @param array $actionArgs
     * @return array
     */
    public function getActions($request, $actionArgs) {

        // Get the existing actions
        $actions = parent::getActions($request, $actionArgs);

        // Only add the settings action when the plugin is enabled
        if (!$this->getEnabled()) {
            return $actions;
        }

        // Create a LinkAction that will make a request to the
        // plugin's `manage` method with the `settings` verb.
        $router = $request->getRouter();
        import('lib.pkp.classes.linkAction.request.AjaxModal');
        $linkAction = new LinkAction(
            'settings',
            new AjaxModal(
                $router->url(
                    $request,
                    null,
                    null,
                    'manage',
                    null,
                    [
                        'verb' => 'settings',
                        'plugin' => $this->getName(),
                        'category' => 'generic'
                    ]
                ),
                $this->getDisplayName()
            ),
            __('manager.plugins.settings'),
            null
        );

        // Add the LinkAction to the existing actions.
        // Make it the first action to be consistent with
        // other plugins.
        array_unshift($actions, $linkAction);

        return $actions;
    }

    /**
     * Show and save the settings form when the settings action
     * is clicked.
     *
     * @param array $args
     * @param Request $request
     * @return JSONMessage
     */
    public function manage($args, $request) {
        switch ($request->getUserVar('verb')) {
            case 'settings':

                // Load the custom form
                $this->import('PublicationValidatorPluginSettingsForm');
                $form = new PublicationValidatorPluginSettingsForm($this);

                // Fetch the form the first time it loads, before
                // the user has tried to save it
                if (!$request->getUserVar('save')) {
                    $form->initData();
                    return new JSONMessage(true, $form->fetch($request));
                }

                // Validate and save the form data
                $form->readInputData();
                if ($form->validate()) {
                    $form->execute();
                    return new JSONMessage(true);
                }
        }
        return parent::manage($args, $request);
    }

	/**
	 * Load a setting for a specific journal or load it from the config.inc.php if it is specified there.
	 *
	 * @param  $contextId int The id of the journal from which the plugin settings should be loaded.
	 * @param  $name string   Name of the setting.
	 * @return mixed          The setting value, either from the database for this context
	 *                        or from the global configuration file.
	 */
	function getSetting($contextId, $name) {
		switch ($name) {
			case 'enableOpenAire':
				$config_value = Config::getVar('publicationValidator', 'openair');
				break;
			case 'enableDoaj':
				$config_value = Config::getVar('publicationValidator', 'doaj');
				break;
			case 'enableBase':
				$config_value = Config::getVar('publicationValidator', 'base');
				break;
			case 'enableWebOfScience':
				$config_value = Config::getVar('publicationValidator', 'web_of_science');
				break;
			case 'enableCrossref':
				$config_value = Config::getVar('publicationValidator', 'crossref');
				break;
			case 'enableJGate':
				$config_value = Config::getVar('publicationValidator', 'jgate');
				break;
			default:
				return parent::getSetting($contextId, $name);
		}

		return $config_value ?: parent::getSetting($contextId, $name);
	}

	/**
	 * Check if there exist a valid publication validator configuration section in the global config.inc.php of OJS.
	 * @return boolean True, if the config file has openair, doaj, base, web_of_science, crossref, jgate set in an [publicationValidator] section
	 */
	public function isGloballyConfigured($key)
	{
		$configValue = Config::getVar('publicationValidator', $key);
		return isset($configValue) && $configValue === 1;
	}
}
