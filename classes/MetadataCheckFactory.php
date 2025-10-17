<?php
namespace APP\plugins\generic\metadataCheck\classes;

use APP\core\Request;
use APP\plugins\generic\metadataCheck\classes\services\ServiceDOAJ;
use APP\plugins\generic\metadataCheck\classes\services\ServiceOpenAire;
use Exception;

class MetadataCheckFactory
{
    /**
     * @throws Exception
     */
    public static function createValidator(string $service): MetadataCheck {
        return match (strtolower($service)) {
            'doaj' => new ServiceDOAJ(),
            'openaire' => new ServiceOpenAire(),
        };
	}
}
