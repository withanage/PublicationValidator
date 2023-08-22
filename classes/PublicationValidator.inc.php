<?php

abstract class PublicationValidator
{

	protected array $errors;

	/**
	 * @param Publication $publication
	 * @param Submission $submission
	 */
	abstract public function validate(Publication $publication, Submission $submission, $context);

	/**
	 * @param $publications
	 * @return array
	 */
	public function validateAuthor($publications) : array
	{
		$validationErrors = [];
		if(empty($publications->getData('authors'))){
			$validationErrors[] = __('plugins.generic.publicationValidator.authors.authorsNotFound');
		} else {
			foreach ($publications->getData('authors') as $author){
				if(empty($author->getAffiliation($publications->getData('locale')))){
					$validationErrors[] = __('plugins.generic.publicationValidator.authors.authorAffiliation');
				}
				break;
			}
		}
		return $validationErrors;
	}

	/**
	 * @param $publications
	 * @return array
	 */
	public function validateLocale($publications) : array
	{
		$validationErrors = [];
		if (empty($publications->getData('locale'))) {
			$validationErrors[] = __('plugins.generic.publicationValidator.publication.locale');
		}
		return $validationErrors;
	}

	/**
	 * @param $publications
	 * @return array
	 */
	public function validateAbstract($publications) : array
	{
		$validationErrors = [];
		if (empty($publications->getData('abstract'))) {
			$validationErrors[] = __('plugins.generic.publicationValidator.publication.abstract');
		}
		return $validationErrors;
	}

	/**
	 * @param $context
	 * @return array
	 */
	public function validatePublisher($context, $service) : array
	{
		$validationErrors = [];
		if (empty($context->getData('publisherInstitution'))) {
			$validationErrors[] = __('plugins.generic.publicationValidator.publication.publisher')+$service;
		}
		return $validationErrors;
	}

	/**
	 * @param $context
	 * @return array
	 */
	public function validateIssn($context) : array
	{
		$validationErrors = [];
		if (empty($context->getData('printIssn')) || empty($context->getData('onlineIssn'))) {
			$validationErrors[] = __('plugins.generic.publicationValidator.publication.issn');
		}
		return $validationErrors;
	}

	/**
	 * @param $submission
	 * @return array
	 */
	public function validateIdentifier($submission) : array
	{
		$validationErrors = [];
		if (empty($submission->getStoredPubId('doi'))) {
			$validationErrors[] = __('plugins.generic.publicationValidator.publication.doi');
		}
		return $validationErrors;
	}

	/**
	 * @param $section
	 * @return array
	 */
	public function validateResourceType($section,$local) : array
	{
		$validationErrors = [];
		if ($section->getData('title',$local) != 'Articles') {
			$validationErrors[] = __('plugins.generic.publicationValidator.publication.resourceType');
		}
		return $validationErrors;
	}

	/**
	 * @return array
	 */
	public function getErrors(): array
	{
		return $this->errors;
	}

}
