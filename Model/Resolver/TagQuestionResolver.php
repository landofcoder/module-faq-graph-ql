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
use Lof\Faq\Api\QuestionListByTagInterface;

/**
 * Class to resolve custom attribute_set_name field in faq tag GraphQL query
 */
class TagQuestionResolver implements ResolverInterface
{

    /**
     * @var QuestionListByTagInterface
     */
    private $questionListByTag;

    /**
     * CategoryQuestionResolver constructor.
     * @param QuestionListByTagInterface $questionListByTag
     */
    public function __construct(
        QuestionListByTagInterface $questionListByTag
    ) {
        $this->questionListByTag = $questionListByTag;
    }

    /**
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|Value|mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (isset($value['name']) && $value['name']) {
            $result = $this->questionListByTag->getQuestionByTagForApi($value['name']);
            return $result->getTotalCount();
        } else {
            return 0;
        }
    }
}
