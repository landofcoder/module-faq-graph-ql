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

namespace Lof\FaqGraphQl\Model\Resolver;

use Magento\Framework\DataObject;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class FaqCreateQuestion implements ResolverInterface
{

    /**
     * @var \Magento\Framework\View\LayoutInterface
     */
    private $_layout;
    /**
     * @var \Magento\Store\Model\StoreManager
     */
    private $_storeManager;
    /**
     * @var \Lof\Faq\Model\QuestionFactory
     */
    private $questionFactory;
    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    private $inlineTranslation;
    /**
     * @var \Lof\Faq\Helper\Data
     */
    private $_faqHelper;
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    private $_transportBuilder;

    /**
     * FaqCreateQuestion constructor.
     * @param \Magento\Framework\View\LayoutInterface $layout
     * @param \Magento\Store\Model\StoreManager $storeManager
     * @param \Lof\Faq\Model\QuestionFactory $questionFactory
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Lof\Faq\Helper\Data $faqHelper
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     */
    public function __construct(
        \Magento\Framework\View\LayoutInterface $layout,
        \Magento\Store\Model\StoreManager $storeManager,
        \Lof\Faq\Model\QuestionFactory $questionFactory,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Lof\Faq\Helper\Data $faqHelper,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
    ) {
        $this->_layout = $layout;
        $this->_storeManager = $storeManager;
        $this->questionFactory = $questionFactory;
        $this->inlineTranslation = $inlineTranslation;
        $this->_faqHelper = $faqHelper;
        $this->_transportBuilder = $transportBuilder;
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
        $data = $args;
        $custom_form_data = [
            [
                'label' => 'Name',
                'value' => $data['author_name']
            ],
            [
                'label' => 'Email',
                'value' => $data['author_email']
            ],
            [
                'label' => 'Message',
                'value' => $data['title']
            ]
        ];

        $store = $this->_storeManager->getStore();
        $data['is_active'] = 0;
        $data['stores'] = [$store->getId()];
        $data['question_products'][$data['product_id']] = ['position' => 0];
        $model = $this->questionFactory->create();
        $model->setData($data);
        try {
            $model->save();
            $res = [
                'code' => 0,
                'message' => __('Your question has submitted successfully, we will answer that as soon as possible. Thanks you!')
            ];
        } catch (\Exception $e) {
            $res = [
                'code' => 0,
                'message' => $e->getMessage()
            ];
        }
        $this->inlineTranslation->suspend();
        $enable_testmode = $this->_faqHelper->getConfig('email_settings/enable_testmode');
        if (!$enable_testmode && $this->_faqHelper->getConfig('email_settings/email_receive') != '') {
            $data['message'] = $this->_layout->createBlock(\Magento\Framework\View\Element\Template::class)
                ->setTemplate("Lof_Faq::email/items.phtml")
                ->setCustomFormData($custom_form_data)
                ->toHtml();
            $emails = $this->_faqHelper->getConfig('email_settings/email_receive');
            $emails = explode(',', $emails);
            foreach ($emails as $v) {
                try {
                    $postObject = new DataObject();
                    $data['title'] = __('Send Faq');
                    $postObject->setData($data);
                    $transport = $this->_transportBuilder
                        ->setTemplateIdentifier($this->_faqHelper->getConfig('email_settings/email_template'))
                        ->setTemplateOptions(
                            [
                                'area' => \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE,
                                'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                            ]
                        )
                        ->setTemplateVars(['data' => $postObject])
                        ->setFrom($this->_faqHelper->getConfig('email_settings/sender_email_identity'))
                        ->addTo($v)
                        ->setReplyTo($v)
                        ->getTransport();
                    $transport->sendMessage();
                    $this->inlineTranslation->resume();
                } catch (\Exception $e) {
                    $this->inlineTranslation->resume();
                }
            }
        }
        return $res;
    }
}
