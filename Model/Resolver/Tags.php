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

declare(strict_types=1);

namespace Lof\FaqGraphQl\Model\Resolver;

use Lof\Faq\Model\ResourceModel\Tag\CollectionFactory;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class Tags implements ResolverInterface
{
    /**
     * @var CollectionFactory
     */
    private $tagCollectionFactory;

    /**
     * Tags constructor.
     * @param CollectionFactory $tagCollection
     */
    public function __construct(
        CollectionFactory $tagCollection
    ) {
        $this->tagCollectionFactory = $tagCollection;
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
        if ($args['currentPage'] < 1) {
            throw new GraphQlInputException(__('currentPage value must be greater than 0.'));
        }
        if ($args['pageSize'] < 1) {
            throw new GraphQlInputException(__('pageSize value must be greater than 0.'));
        }
        $collection = $this->tagCollectionFactory->create();
        $collection->getSelect()->group('name');
        $collection->setCurPage($args['currentPage']);
        $collection->setPageSize($args['pageSize']);

        $items = [];
        foreach ($collection as $_item) {
            $items[] = $_item->getdata();
        }
        return [
            'total_count' => $collection->getSize(),
            'items'       => $items,
            'page_info' => [
                'page_size' => $collection->getPageSize(),
                'current_page' => $collection->getCurPage(),
                'total_pages' => $collection->getLastPageNumber()
            ],
        ];
    }
}
