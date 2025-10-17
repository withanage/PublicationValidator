<?php

namespace APP\plugins\generic\metadataCheck;

use APP\core\Request;
use APP\plugins\generic\metadataCheck\classes\MetadataCheckFactory;
use APP\plugins\generic\metadataCheck\classes\MetadataCheckResource;
use APP\plugins\generic\metadataCheck\classes\MetadataService;
use Exception;
use PKP\config\Config;
use PKP\core\JSONMessage;
use PKP\core\PKPApplication;
use PKP\linkAction\LinkAction;
use PKP\linkAction\request\AjaxModal;
use PKP\plugins\GenericPlugin;
use PKP\plugins\Hook;

class MetadataCheckPlugin extends GenericPlugin
{
    public function register($category, $path, $mainContextId = NULL)
    {
        // Register the plugin even when it is not enabled
        $success = parent::register($category, $path);

        if ($success && $this->getEnabled()) {
            // Do something when the plugin is enabled
            Hook::add('Publication::validatePublish', [$this, 'validate']);
        }

        return $success;
    }

    /**
     * @copydoc Plugin::getDisplayName()
     */
    public function getDisplayName()
    {
        return __('plugins.generic.metadataCheck.displayName');
    }

    /**
     * @copydoc Plugin::getDescription()
     */
    public function getDescription()
    {
        return __('plugins.generic.metadataCheck.description');
    }

    /**
     * Add a settings action to the plugin's entry in the
     * plugins list.
     *
     * @param Request $request
     * @param array $actionArgs
     * @return array
     */
    public function getActions($request, $actionArgs)
    {

        // Get the existing actions
        $actions = parent::getActions($request, $actionArgs);

        // Only add the settings action when the plugin is enabled
        if (!$this->getEnabled()) {
            return $actions;
        }

        // Create a LinkAction that will make a request to the
        // plugin's `manage` method with the `settings` verb.
        $router = $request->getRouter();
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
    public function manage($args, $request): JSONMessage
    {
        switch ($request->getUserVar('verb')) {
            case 'settings':
                // Load the custom form
                $form = new MetadataCheckPluginSettingsForm($this);

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
    function getSetting(mixed $contextId, $name): mixed
    {
        $configValue = match ($name) {
            'enableOpenAire' => Config::getVar('metadataCheck', 'openair'),
            'enableDoaj' => Config::getVar('metadataCheck', 'doaj'),
            'enableBase' => Config::getVar('metadataCheck', 'base'),
            'enableWebOfScience' => Config::getVar('metadataCheck', 'web_of_science'),
            'enableCrossref' => Config::getVar('metadataCheck', 'crossref'),
            'enableJGate' => Config::getVar('metadataCheck', 'jgate'),
            default => parent::getSetting($contextId, $name),
        };

        return $configValue ?: parent::getSetting($contextId, $name);
    }

    /**
     * Check if there exist a valid publication validator configuration section in the global config.inc.php of OJS.
     * @return boolean True, if the config file has openair, doaj, base, web_of_science, crossref, jgate set in an [MetadataCheck] section
     */
    public function isGloballyConfigured(string $key): bool
    {
        $configValue = Config::getVar('publicationValidator', $key);
        return isset($configValue) && $configValue === 1;
    }

    /**
     * Make additional validation checks against publishing requirements
     *
     * @param $hookName string
     * @param $args array [
     * @option array Validation errors already identified
     * @option Publication The publication to validate
     * @option Submission The submission of the publication being validated
     * @option array The locales accepted for this object
     * @option string The primary locale for this object
     * ]
     * @throws Exception
     * @see PKPPublicationService::validatePublish()
     */
    public function validate(string $hookName, array $args): void
    {
        try {

            $errors =& $args[0];
            $submission = $args[2];
            $request = PKPApplication::get()->getRequest();
            $context = $request->getContext();
            $services = [];

            if ($this->getSetting($context->getId(), 'enableDoaj') == 1) {
                $services[] = MetadataService::DOAJ->value;
            }
            if ($this->getSetting($context->getId(), 'enableOpenAire') == 1) {
                $services[] = MetadataService::OPENAIRE->value;
            }

            $metadata = (new MetadataCheckResource())->transformSubmissionMetadata($submission, $context);
            foreach ($services as $service) {
                $validator = MetadataCheckFactory::createValidator($service);
                $validator->validate($metadata);
                if (!$validator->isValid()) {
                    $errors = array_unique(array_merge($errors, $this->arrayValuesRecursive($validator->getErrors()->toArray())));
                }
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param $array
     * @return array
     */
    private function arrayValuesRecursive($array): array
    {
        $values = [];
        foreach ($array as $value) {
            if (is_array($value)) {
                $values = array_merge($values, $this->arrayValuesRecursive($value));
            } else {
                $values[] = $value;
            }
        }
        return $values;
    }
}
