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

use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Lof\Faq\Api\CategoriesInterface;

/**
 * Class to resolve custom attribute_set_name field in faq question GraphQL query
 */
class QuestionCategoryResolver implements ResolverInterface
{

    /**
     * @var CategoriesInterface
     */
    private $categoryInterface;

    public function __construct(
        CategoriesInterface $categoryInterface
    ) {
        $this->categoryInterface = $categoryInterface;
    }

    /**
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|Value|mixed
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (isset($value['category_id']) && $value['category_id']) {
            $items = [];
            foreach ($value['category_id'] as $categoryId) {
                $items[] = $this->categoryInterface->getById($categoryId);
            }
            return [
                'total_count' => count($items),
                'items' => $items
            ];
        } else {
            return [];
        }
    }
}
