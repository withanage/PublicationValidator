<?php
import('plugins.generic.publicationValidator.classes.PublicationValidator');

class ServiceDOAJ extends PublicationValidator
{
	/**
	 * validate publication fields for DOAJ service
	 * @param Publication $publication
	 * @param Submission $submission
	 * @param $context
	 * @param $service
	 * @return $this
	 */
	public function validate(Publication $publication, Submission $submission, $context,$service)
	{
		$this->errors = [];
		$authorErrors = $this->validateAuthor($publication,$service);
		$localeErrors = $this->validateLocale($publication,$service);
		$abstractErrors = $this->validateAbstract($publication,$publication->getData('locale'),$service);
		$publisherErrors = $this->validatePublisher($context,$service);
		$issnErrors = $this->validateIssn($context,$service);
		$identifierErrors = $this->validateIdentifier($submission,$service);
		array_push(
			$this->errors,
			$authorErrors,
			$localeErrors,
			$abstractErrors,
			$publisherErrors,
			$issnErrors,
			$identifierErrors
		);
		$this->errors=array_filter($this->errors);
		return $this;
	}
}
