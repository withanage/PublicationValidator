<?php

namespace APP\plugins\generic\metadataCheck\classes\dto;

class PublicationMetadata
{
    public function __construct(
        public ?array $title,
        public ?array $authors,
        public ?string $printIssn,
        public ?string $onlineIssn,
        public ?string $doi,
        public ?string $licenseUrl,
        public ?array $subjects,
        public ?string $rights,
        public ?array $citations,
        public ?string $publisherInstitution,
        public ?array $contributors,
    ) {}

    /**
     * Convert the instance to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
