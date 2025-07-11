<?php
namespace APP\plugins\generic\metadataCheck\classes\services;

use APP\core\Request;
use APP\plugins\generic\metadataCheck\classes\dto\PublicationMetadata;
use APP\plugins\generic\metadataCheck\classes\MetadataCheck;
use APP\plugins\generic\metadataCheck\classes\MetadataValidatorInterface;

class ServiceOpenAire extends MetadataCheck implements MetadataValidatorInterface
{
	protected function validateMetadata(PublicationMetadata $metadata): void {
        $rules = $this->getValidationRules();
        $messages = $this->getValidationMessages($metadata);
        $this->checkRequiredFields($metadata, $rules,$messages);
    }

    /**
     * @return array[]
     */
    public function getValidationRules(): array
    {
        return [
            "publisherInstitution" => [
                'required',
                'string',
            ],
            "printIssn" => [
                'required_without:onlineIssn',
                'string',
            ],
            "onlineIssn" => [
                'required_without:printIssn',
                'string',
            ],
            "rights" => [
                'required',
                'string',
            ],
            "subjects" => [
                'required',
                'array',
            ],
            "contributors" => [
                'required',
                'array',
            ],
        ];
    }

    public function getValidationMessages(PublicationMetadata $metadata): array
    {
        return [];
    }
}
