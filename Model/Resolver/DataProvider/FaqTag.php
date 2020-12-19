<?php


namespace Lof\FaqGraphQl\Model\Resolver\DataProvider;

use Lof\Faq\Api\TagsInterface;

class FaqTag
{

    private $tagsManagement;

    /**
     * @param TagsInterface $tagsManagement
     */
    public function __construct(
        TagsInterface $tagsManagement
    ) {
        $this->tagsManagement = $tagsManagement;
    }

    public function getFaqTag()
    {
        return 'proviced data';
    }
}
