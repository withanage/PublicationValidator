<?php
import('plugins.generic.publicationValidator.classes.PublicationValidator');

class ServiceDOAJ extends PublicationValidator
{
	/**
	 * @param Publication $publication
	 * @param Submission $submission
	 * @return $this
	 */
	public function validate(Publication $publication, Submission $submission, $context)
	{
		$sectionDao = DAORegistry::getDAO('SectionDAO');
		/* @var $sectionDao SectionDAO */
		$section = $sectionDao->getById($publication->getData('sectionId'));
		$authorErrors = $this->validateAuthor($publication);
		$localeErrors = $this->validateLocale($publication);
		$abstractErrors = $this->validateAbstract($publication);
		$publisherErrors = $this->validatePublisher($context);
		$issnErrors = $this->validateIssn($context);
		$identifierErrors = $this->validateIdentifier($submission);
		$resourceTypeErrors = $this->validateResourceType($section, $publication->getData('locale'));
		$this->errors = array_merge(
			$authorErrors,
			$localeErrors,
			$abstractErrors,
			$publisherErrors,
			$issnErrors,
			$identifierErrors,
			$resourceTypeErrors
		);
		return $this;
	}
}
