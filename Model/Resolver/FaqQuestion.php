<?php


namespace Lof\FaqGraphQl\Model\Resolver;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class FaqQuestion implements ResolverInterface
{

    private $faqQuestionDataProvider;

    /**
     * @param DataProvider\FaqQuestion $faqQuestionRepository
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
