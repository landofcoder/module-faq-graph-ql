<?php
namespace Lof\FaqGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Lof\Faq\Api\QuestionInfoByIdInterface;

/**
 * Class to resolve custom attribute_set_name field in faq question GraphQL query
 */
class QuestionRelatedResolver implements ResolverInterface
{

    /**
     * @var QuestionInfoByIdInterface
     */
    private $questionRepository;

    public function __construct(
        QuestionInfoByIdInterface $questionRepository
    ) {
        $this->questionRepository = $questionRepository;
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
        if (isset($value['relatedquestions']) && $value['relatedquestions']) {
            $items = [];
            foreach ($value['relatedquestions'] as $relatedquestion) {
                if (isset($relatedquestion['relatedquestion_id']) && $relatedquestion['relatedquestion_id']) {
                    $items[] = $this->questionRepository->getById($relatedquestion['relatedquestion_id']);
                }
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
