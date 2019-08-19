<?php


namespace Lof\FaqGraphQl\Model\Resolver\DataProvider;

class FaqQuestion
{

    private $questionManagement;

    /**
     * @param Lof\Faq\Api\QuestionManagementInterface $questionManagement
     */
    public function __construct(
        Lof\Faq\Api\QuestionManagementInterface $questionManagement
    ) {
        $this->questionManagement = $questionManagement;
    }

    public function getFaqQuestion()
    {
        return 'proviced data';
    }
}
