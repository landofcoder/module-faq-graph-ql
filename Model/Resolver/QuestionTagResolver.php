<?php
namespace Lof\FaqGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Lof\Faq\Model\ResourceModel\Tag\Collection;

/**
 * Class to resolve custom attribute_set_name field in faq question GraphQL query
 */
class QuestionTagResolver implements ResolverInterface
{

    /**
     * @var Collection
     */
    private $tagCollection;

    public function __construct(
        Collection $tagCollection
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
            $collection = $this->tagCollection->addFieldToFilter('question_id', $value['question_id']);
            return [
                'total_count' => $collection->getSize(),
                'items' => $collection->getItems()
            ];
        } else {
            return [];
        }
    }
}
