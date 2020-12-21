<?php


namespace Lof\FaqGraphQl\Model\Resolver\DataProvider;

use Lof\Faq\Api\CategoriesInterface;

/**
 * Class FaqCategory
 * @package Lof\FaqGraphQl\Model\Resolver\DataProvider
 */
class FaqCategory
{

    /**
     * @var CategoriesInterface
     */
    private $categories;

    /**
     * @param CategoriesInterface $categories
     */
    public function __construct(
        CategoriesInterface $categories
    ) {
        $this->categories = $categories;
    }

    /**
     * @param $categoryId
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function getFaqCategory($categoryId)
    {
        return $this->categories->getById($categoryId);
    }
}
