<?php

/**
 * @file index.php
 *
 * Distributed under the GNU GPL v3. For full terms see the file LICENSE.
 *
 * @brief Wrapper for MetadataCheck plugin.
 */
require_once('MetadataCheckPlugin.php');
return new \APP\plugins\generic\metadataCheck\MetadataCheckPlugin();
