<?php


namespace Lof\FaqGraphQl\Model\Resolver\DataProvider;

use Lof\Faq\Api\QuestionManagementInterface;

/**
 * Class FaqQuestion
 * @package Lof\FaqGraphQl\Model\Resolver\DataProvider
 */
class FaqQuestion
{

    /**
     * @var QuestionManagementInterface
     */
    private $questionManagement;

    /**
     * @param QuestionManagementInterface $questionManagement
     */
    public function __construct(
        QuestionManagementInterface $questionManagement
    ) {
        $this->questionManagement = $questionManagement;
    }

    /**
     * @param $questionId
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function getFaqQuestion($questionId)
    {
        return $this->questionManagement->getById($questionId);
    }
}
