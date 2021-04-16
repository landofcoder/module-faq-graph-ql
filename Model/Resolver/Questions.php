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

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Lof\Faq\Api\QuestionManagementInterface;
use Magento\Framework\GraphQl\Query\Resolver\Argument\SearchCriteria\Builder as SearchCriteriaBuilder;

class Questions implements ResolverInterface
{
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var QuestionManagementInterface
     */
    private $questionRepository;

    /**
     * Questions constructor.
     * @param QuestionManagementInterface $questionManagement
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        QuestionManagementInterface $questionManagement,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->questionRepository = $questionManagement;
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
        $tag = '';
        if (isset($args['filter']['tag']) && $args['filter']['tag']) {
            $tag = $args['filter']['tag'];
            unset($args['filter']['tag']);
        }
        $identifier = '';
        if (isset($args['filter']['category_identifier']) && $args['filter']['category_identifier']) {
            $identifier = $args['filter']['category_identifier'];
            unset($args['filter']['category_identifier']);
        }
        $sku = '';
        if (isset($args['filter']['product_sku']) && $args['filter']['product_sku']) {
            $sku = $args['filter']['product_sku'];
            unset($args['filter']['product_sku']);
        }
        $searchCriteria = $this->searchCriteriaBuilder->build('faqQuestions', $args);
        $searchCriteria->setCurrentPage($args['currentPage']);
        $searchCriteria->setPageSize($args['pageSize']);
        $search = '';
        if (isset($args['search']) && $args['search']) {
            $search = $args['search'];
        }
        $searchResult = $this->questionRepository->getList($searchCriteria, $search, $tag, $identifier, $sku);
        $totalPages = $args['pageSize'] ? ((int)ceil($searchResult->getTotalCount() / $args['pageSize'])) : 0;

        return [
            'total_count' => $searchResult->getTotalCount(),
            'items'       => $searchResult->getItems(),
            'page_info' => [
                'page_size' => $args['pageSize'],
                'current_page' => $args['currentPage'],
                'total_pages' => $totalPages
            ],
        ];
    }
}
