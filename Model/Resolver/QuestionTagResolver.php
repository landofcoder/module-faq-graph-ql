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
use Lof\Faq\Model\ResourceModel\Tag\CollectionFactory;

/**
 * Class to resolve custom attribute_set_name field in faq question GraphQL query
 */
class QuestionTagResolver implements ResolverInterface
{

    /**
     * @var CollectionFactory
     */
    private $tagCollection;

    /**
     * QuestionTagResolver constructor.
     * @param CollectionFactory $tagCollection
     */
    public function __construct(
        CollectionFactory $tagCollection
    ) {
        $this->tagCollection = $tagCollection;
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
        if (isset($value['question_id']) && $value['question_id']) {
            $collection = $this->tagCollection->create()->addFieldToFilter('question_id', $value['question_id']);
            $items = [];
            foreach($collection->getItems() as $_item) {
                $items[] = $_item->getData();
            }
            return [
                'total_count' => $collection->getSize(),
                'items' => $items
            ];
        } else {
            return [];
        }
    }
}
