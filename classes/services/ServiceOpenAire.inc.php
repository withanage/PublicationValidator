<?php

class ServiceOpenAire extends PublicationValidator
{

	/**
	 * validate publication fields for OpenAire service
	 * @param Publication $publication
	 * @param Submission $submission
	 * @param $context
	 * @param $service
	 * @return $this
	 */
    public function validate(Publication $publication, Submission $submission, $context, $service)
    {
		$this->errors = [];
		$localeError = $this->validateLocale($publication,$service);
		$abstractError = $this->validateAbstract($publication,$publication->getData('locale'),$service);
		$publisherError = $this->validatePublisher($context,$service);
		$titleError = $this->validateArticleTitle($publication,$publication->getData('locale'),$service);
		$issnError = $this->validateIssn($context,$service);
		$authorsError = $this->validateAuthor($publication,$service);
		$licenseError = $this->validateLicense($publication,$service);
		$subjectsError = $this->validateSubjects($publication,$service);
		$identifierError = $this->validateIdentifier($submission,$service);
		$rightsError = $this->validateRights($submission,$service);
		array_push(
			$this->errors,
			$titleError,
			$localeError,
			$abstractError,
			$publisherError,
			$issnError,
			$identifierError,
			$authorsError,
			$licenseError,
			$subjectsError,
			$rightsError
		);
		$this->errors=array_filter($this->errors);
        return $this;
    }
}
