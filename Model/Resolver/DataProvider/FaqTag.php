<?php


namespace Lof\FaqGraphQl\Model\Resolver\DataProvider;

class FaqTag
{

    private $tagsManagement;

    /**
     * @param Lof\Faq\Api\TagsManagementInterface $tagsManagement
     */
    public function __construct(
        Lof\Faq\Api\TagsManagementInterface $tagsManagement
    ) {
        $this->tagsManagement = $tagsManagement;
    }

    public function getFaqTag()
    {
        return 'proviced data';
    }
}
