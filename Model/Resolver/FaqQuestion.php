<?php


namespace Lof\FaqGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class FaqQuestion implements ResolverInterface
{

    private $faqQuestionDataProvider;

    /**
     * @param DataProvider\FaqQuestion $faqQuestionDataProvider
     */
    public function __construct(
        DataProvider\FaqQuestion $faqQuestionDataProvider
    ) {
        $this->faqQuestionDataProvider = $faqQuestionDataProvider;
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
        return $this->faqQuestionDataProvider->getFaqQuestion($args['question_id']);
    }
}
