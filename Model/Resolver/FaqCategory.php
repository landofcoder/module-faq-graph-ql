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

namespace Lof\FaqGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * Class FaqCategory
 * @package Lof\FaqGraphQl\Model\Resolver
 */
class FaqCategory implements ResolverInterface
{

    /**
     * @var DataProvider\FaqCategory
     */
    private $faqCategoryDataProvider;

    /**
     * @param DataProvider\FaqCategory $faqCategoryRepository
     */
    public function __construct(
        DataProvider\FaqCategory $faqCategoryDataProvider
    ) {
        $this->faqCategoryDataProvider = $faqCategoryDataProvider;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        return $this->faqCategoryDataProvider->getFaqCategory($args['category_id']);
    }
}
