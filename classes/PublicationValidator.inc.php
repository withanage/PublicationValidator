<?php

abstract class PublicationValidator
{

	protected array $errors;

	/**
	 * validate
	 * @param Publication $publication
	 * @param Submission $submission
	 */
	abstract public function validate(Publication $publication, Submission $submission, $context);

	/**
	 * validate author and author affiliation
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
	 * validate locale
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
	 * validate abstract
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
	 * validate publisher
	 * @param $context
	 * @return array
	 */
	public function validatePublisher($context) : array
	{
		$validationErrors = [];
		if (empty($context->getData('publisherInstitution'))) {
			$validationErrors[] = __('plugins.generic.publicationValidator.publication.publisher');
		}
		return $validationErrors;
	}

	/**
	 * validate printIssn and onlineIssn
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
	 * validate identifier
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
	 * get all validation errors
	 * @return array
	 */
	public function getErrors(): array
	{
		return $this->errors;
	}

}
