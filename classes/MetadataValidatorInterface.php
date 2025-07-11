<?php

namespace APP\plugins\generic\metadataCheck\classes;

use APP\plugins\generic\metadataCheck\classes\dto\PublicationMetadata;

interface MetadataValidatorInterface {
    public function getValidationRules(): array;
    public function getValidationMessages(PublicationMetadata $metadata): array;
}
