<?php


namespace Lof\FaqGraphQl\Model\Resolver;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class FaqTag implements ResolverInterface
{

    private $faqTagDataProvider;

    /**
     * @param DataProvider\FaqTag $faqTagRepository
     */
    public function __construct(DataProvider\FaqTag $faqTagDataProvider)
    {
        $this->faqTagDataProvider = $faqTagDataProvider;
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
        $faqTagData = $this->faqTagDataProvider->getFaqTag();
        return $faqTagData;
    }
}
