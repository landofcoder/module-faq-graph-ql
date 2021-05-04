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

use Lof\Faq\Api\QuestionListByCategoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class to resolve custom attribute_set_name field in faq category GraphQL query
 */
class CategoryImageResolver implements ResolverInterface
{

    /**
     * @var QuestionListByCategoryInterface
     */
    private $questionListByCategory;
    /**
     * @var StoreManagerInterface
     */
    private $_storeManager;

    /**
     * CategoryQuestionResolver constructor.
     * @param QuestionListByCategoryInterface $questionListByCategory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        QuestionListByCategoryInterface $questionListByCategory,
        StoreManagerInterface $storeManager
    ) {
        $this->questionListByCategory = $questionListByCategory;
        $this->_storeManager = $storeManager;
    }

    /**
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|Value|mixed
     * @throws LocalizedException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (isset($value['image']) && $value['image']) {
            return $this->_storeManager->getStore()->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ) . $value['image'];
        } else {
            return '';
        }
    }
}
