<?php


namespace Lof\FaqGraphQl\Model\Resolver\DataProvider;

class FaqCategory
{

    private $categories;

    /**
     * @param Lof\Faq\Api\CategoriesInterface $categories
     */
    public function __construct(
        Lof\Faq\Api\CategoriesInterface $categories
    ) {
        $this->categories = $categories;
    }

    public function getFaqCategory()
    {
        return 'proviced data';
    }
}
