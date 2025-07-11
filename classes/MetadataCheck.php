<?php

namespace APP\plugins\generic\metadataCheck\classes;

use APP\plugins\generic\metadataCheck\classes\dto\PublicationMetadata;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator;
use PKP\core\PKPApplication;
use PKP\validation\ValidatorFactory;

abstract class MetadataCheck
{
    private ?Validator $validator = null;

    /**
     * validate
     */
    abstract protected function validateMetadata(PublicationMetadata $metadata);

    /**
     * Validate publication meta-data
     * @param PublicationMetadata $metadata
     */
    public function validate(PublicationMetadata $metadata) : void
    {
        $this->validateMetadata($metadata);
    }

    protected function checkRequiredFields(PublicationMetadata $metadata, array $rules, array $messages): void
    {
        $data = $metadata->toArray();
        $this->validator = ValidatorFactory::make(
            $data,
            $rules,
            $this->getValidationMessages($metadata,$messages)
        );
    }

    private function getValidationMessages(PublicationMetadata $metadata,$messages): array
    {
        $context = PKPApplication::get()->getRequest()->getContext();
        $primaryLocale = $context->getPrimaryLocale();
        return [
            ...$messages,
            'publisherInstitution.required' => __('plugins.generic.metadataCheck.publisherInstitution.required',['publicationTitle'=>$metadata->title[$primaryLocale]]),
            'doi.required' => __('plugins.generic.metadataCheck.doi.required',['publicationTitle'=>$metadata->title[$primaryLocale]]),
            'citations.required' => __('plugins.generic.metadataCheck.citations.required',['publicationTitle'=>$metadata->title[$primaryLocale]]),
            'rights.required' => __('plugins.generic.metadataCheck.rights.required',['publicationTitle'=>$metadata->title[$primaryLocale]]),
            'subjects.required' => __('plugins.generic.metadataCheck.subjects.required',['publicationTitle'=>$metadata->title[$primaryLocale]]),
            'doi.url' => __('plugins.generic.metadataCheck.doi.url',['publicationTitle'=>$metadata->title[$primaryLocale]]),
            'licenseUrl.required' => __('plugins.generic.metadataCheck.licenseUrl.required',['publicationTitle'=>$metadata->title[$primaryLocale]]),
            'licenseUrl.url' => __('plugins.generic.metadataCheck.licenseUrl.url',['publicationTitle'=>$metadata->title[$primaryLocale]]),
            'contributors.required' => __('plugins.generic.metadataCheck.contributors.required',['publicationTitle'=>$metadata->title[$primaryLocale]]),
            'onlineIssn.required_without' => __('plugins.generic.metadataCheck.onlineIssn.required_without',['publicationTitle'=>$metadata->title[$primaryLocale]]),
            'printIssn.required_without' => __('plugins.generic.metadataCheck.printIssn.required_without',['publicationTitle'=>$metadata->title[$primaryLocale]]),
        ];
    }

    public function isValid(): bool
    {
        return !$this->validator->fails();
    }

    public function getErrors(): MessageBag
    {
        return $this->validator->errors();
    }

}
