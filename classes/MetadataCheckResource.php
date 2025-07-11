<?php
namespace APP\plugins\generic\metadataCheck\classes;

use APP\facades\Repo;
use APP\publication\Publication;
use APP\submission\Submission;
use PKP\context\Context;
use APP\plugins\generic\metadataCheck\classes\dto\PublicationMetadata;

final class MetadataCheckResource
{
    public function transformSubmissionMetadata(Submission $submission, Context $context): PublicationMetadata
    {
        $publication = $submission->getCurrentPublication();

        return  new PublicationMetadata(
            title: $publication->getData('title'),
            authors: $publication->getData('authors')->toArray(),
            printIssn: $context->getData('printIssn'),
            onlineIssn: $context->getData('onlineIssn'),
            doi: $publication->getDoi(),
            licenseUrl: $context->getData('licenseUrl'),
            subjects: $publication->getData('subjects'),
            rights: $publication->getData('rights'),
            citations: $publication->getData('citations'),
            publisherInstitution: $context->getData('publisherInstitution'),
            contributors:$this->getContributors($publication),
        );
    }

    /**
     * get contributors
     * @param Publication $publication
     * @return array
     */
    private function getContributors(Publication $publication):array
    {
        $collector = Repo::author()->getCollector()
            ->filterByPublicationIds([$publication->getId()]);
        $authors = $collector->getMany();
        return  Repo::author()->getSchemaMap()->summarizeMany($authors)->values()->toArray();
    }
}
