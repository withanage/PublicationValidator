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
}
