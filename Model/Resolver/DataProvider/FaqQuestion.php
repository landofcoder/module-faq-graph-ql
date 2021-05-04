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

namespace Lof\FaqGraphQl\Model\Resolver\DataProvider;

use Lof\Faq\Api\QuestionManagementInterface;

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
