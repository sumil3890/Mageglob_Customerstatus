<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Mageglob\Customerstatus\Block;

use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Model\CustomerFactory as CustomerFactory;

/**
 * Customer front Status manage block
 *
 */
class UpdateStatus extends \Magento\Framework\View\Element\Template
{
    /**
     * @var string
     */
    protected $_template = 'Mageglob_Customerstatus::form/status.phtml';

	/**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    protected $currentCustomer;

     /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * Initialize dependencies.
     *
     * @param CustomerFactory $CustomerFactory
     */
    public function __construct(
    	\Magento\Framework\View\Element\Template\Context $context,
        CurrentCustomer $currentCustomer,
        CustomerFactory $customerFactory,
        array $data = []
    ) {
    	parent::__construct($context, $data);
        $this->currentCustomer = $currentCustomer;
        $this->customerFactory = $customerFactory->create();
    }

    /**
     * Return the save action Url.
     *
     * @return string
     */
    public function getAction() {
        return $this->getUrl('customerstatus/manage/save');
    }

    public function getCurrentStatus() {
    	$customerId = $this->currentCustomer->getCustomer()->getId();
        return $this->customerFactory->load($customerId)->getNewStatus();
    }
}
