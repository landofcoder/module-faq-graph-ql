<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/terms
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_GraphQl
 * @copyright  Copyright (c) 2021 Landofcoder (https://www.landofcoder.com/)
 * @license    https://landofcoder.com/terms
 */

namespace Lof\FaqGraphQl\Model\Resolver\DataProvider;

use Lof\Faq\Api\CategoriesInterface;

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
