<?php
namespace Lof\FaqGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Lof\Faq\Api\CategoriesInterface;

/**
 * Class to resolve custom attribute_set_name field in faq question GraphQL query
 */
class QuestionCategoryResolver implements ResolverInterface
{

    /**
     * @var CategoriesInterface
     */
    private $categoryInterface;

    public function __construct(
        CategoriesInterface $categoryInterface
    ) {
        $this->categoryInterface = $categoryInterface;
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
        if (isset($value['category_id']) && $value['category_id']) {
            $items = [];
            foreach ($value['category_id'] as $categoryId) {
                $items[] = $this->categoryInterface->getById($categoryId);
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
