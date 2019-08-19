<?php


namespace Lof\FaqGraphQl\Model\Resolver;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class FaqCategory implements ResolverInterface
{

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
        $faqCategoryData = $this->faqCategoryDataProvider->getFaqCategory();
        return $faqCategoryData;
    }
}
