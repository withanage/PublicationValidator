<?php

namespace APP\plugins\generic\metadataCheck\classes;

enum MetadataService: string {
    case DOAJ = 'doaj';
    case OPENAIRE = 'openaire';
}
