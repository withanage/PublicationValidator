<?php
import('plugins.generic.publicationValidator.classes.PublicationValidator');

class ServiceDOAJ extends PublicationValidator
{
	/**
	 * validate publication fields for DOAJ service
	 * @param Publication $publication
	 * @param Submission $submission
	 * @return $this
	 */
	public function validate(Publication $publication, Submission $submission, $context)
	{
		$authorErrors = $this->validateAuthor($publication);
		$localeErrors = $this->validateLocale($publication);
		$abstractErrors = $this->validateAbstract($publication);
		$publisherErrors = $this->validatePublisher($context);
		$issnErrors = $this->validateIssn($context);
		$identifierErrors = $this->validateIdentifier($submission);
		$this->errors = array_merge(
			$authorErrors,
			$localeErrors,
			$abstractErrors,
			$publisherErrors,
			$issnErrors,
			$identifierErrors
		);
		return $this;
	}
}
