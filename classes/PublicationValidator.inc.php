<?php

abstract class PublicationValidator
{

	protected array $errors;

	/**
	 * validate
	 * @param Publication $publication
	 * @param Submission $submission
	 * @param $context
	 * @param $service
	 */
	abstract public function validate(Publication $publication, Submission $submission, $context, $service);

	/**
	 * validate author and author affiliation
	 * @param $publications
	 * @param $service
	 * @return string
	 */
	public function validateAuthor($publications,$service) : string
	{
		$validationError = '';
		if(empty($publications->getData('authors'))){
			$validationError = __(
				'plugins.generic.publicationValidator.authors.authorsNotFound',
				['service' => $service]
			);
		} else {
			foreach ($publications->getData('authors') as $author){
				if(empty($author->getAffiliation($publications->getData('locale')))){
					$validationError = __(
						'plugins.generic.publicationValidator.authors.authorAffiliation',
						['service' => $service]
					);
				}
				break;
			}
		}
		return $validationError;
	}

	/**
	 * validate locale
	 * @param $publications
	 * @param $service
	 * @return string
	 */
	public function validateLocale($publications,$service) : string
	{
		$validationError = '';
		if (empty($publications->getData('locale'))) {
			$validationError = __(
				'plugins.generic.publicationValidator.publication.locale',
				['service' => $service]
			);
		}
		return $validationError;
	}

	/**
	 * validate abstract
	 * @param $publications
	 * @param $locale
	 * @param $service
	 * @return string
	 */
	public function validateAbstract($publications,$locale,$service) : string
	{
		$validationError = '';
		if (empty($publications->getData('abstract',$locale))) {
			$validationError = __(
				'plugins.generic.publicationValidator.publication.abstract',
				['service' => $service]
			);
		}
		return $validationError;
	}

	/**
	 * validate publisher
	 * @param $context
	 * @param $service
	 * @return string
	 */
	public function validatePublisher($context,$service) : string
	{
		$validationError = '';
		if (empty($context->getData('publisherInstitution'))) {
			$validationError = __(
				'plugins.generic.publicationValidator.publication.publisher',
				['service' => $service]
			);
		}
		return $validationError;
	}

	/**
	 * validate printIssn and onlineIssn
	 * @param $context
	 * @param $service
	 * @return string
	 */
	public function validateIssn($context,$service) : string
	{
		$validationError = '';
		if (empty($context->getData('printIssn')) || empty($context->getData('onlineIssn'))) {
			$validationError = __(
				'plugins.generic.publicationValidator.publication.issn',
				['service' => $service]
			);
		}
		return $validationError;
	}

	/**
	 * validate identifier
	 * @param $submission
	 * @param $service
	 * @return string
	 */
	public function validateIdentifier($submission,$service) : string
	{
		$validationError = '';
		if (empty($submission->getStoredPubId('doi'))) {
			$validationError = __(
				'plugins.generic.publicationValidator.publication.doi',
				['service' => $service]
			);
		}
		return $validationError;
	}

	/**
	 * validate article title
	 * @param $publication
	 * @param $locale
	 * @param $service
	 * @return string
	 */
	public function validateArticleTitle($publication,$locale,$service) : string
	{
		$validationError = '';
		if (empty($publication->getData('title',$locale))) {
			$validationError = __(
				'plugins.generic.publicationValidator.publication.articleTitle',
				['service' => $service]
			);
		}
		return $validationError;
	}

	/**
	 * validate license url
	 * @param $publication
	 * @param $service
	 * @return string
	 */
	public function validateLicense($publication,$service) : string
	{
		$validationError = '';
		if (empty($publication->getData('licenseUrl'))) {
			$validationError = __(
				'plugins.generic.publicationValidator.publication.licenseUrl',
				['service' => $service]
			);
		}
		return $validationError;
	}

	/**
	 * validate subjects
	 * @param $publication
	 * @param $service
	 * @return string
	 */
	public function validateSubjects($publication,$service) : string
	{
		$validationError = '';
		if (empty($publication->getData('subjects'))) {
			$validationError = __(
				'plugins.generic.publicationValidator.publication.subjects',
				['service' => $service]
			);
		}
		return $validationError;
	}

	/**
	 * validate subjects
	 * @param $publication
	 * @param $service
	 * @return string
	 */
	public function validateRights($publication,$service) : string
	{
		$validationError = '';
		if (empty($publication->getData('rights'))) {
			$validationError = __(
				'plugins.generic.publicationValidator.publication.rights',
				['service' => $service]
			);
		}
		return $validationError;
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
