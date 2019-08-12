<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mageglob\Customerstatus\Controller\Manage;


use Magento\Customer\Model\Customer;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * Customers status save controller
 */
class Save extends \Mageglob\Customerstatus\Controller\Manage implements HttpPostActionInterface, HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $formKeyValidator;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $_customerRepositoryInterface;
    

    /**
     * Initialize dependencies.
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param CustomerRepository $customerRepository
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magento\Customer\Model\CustomerFactory $customerFactory
    ) {
        $this->formKeyValidator = $formKeyValidator;
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->_customerFactory = $customerFactory;
        parent::__construct($context, $customerSession);
    }

    /**
     * Save Status
     *
     * @return void|null
     */
    public function execute()
    { 
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            return $this->_redirect('customer/account/');
        }
        $params = $this->getRequest()->getParams();
        $status = $params['status'];
       
        $customerId = $this->_customerSession->getCustomerId();
        if ($customerId === null) {
            $this->messageManager->addError(__('Something went wrong while saving your status.'));
        } else {
            try {
                $customer = $this->_customerFactory->create()->load($customerId)->getDataModel();
                $customer->setCustomAttribute('new_status', $status);
                $this->_customerRepositoryInterface->save($customer);
                $this->messageManager->addSuccess(__('We have updated your status.'));
            } catch (\Exception $e) {
                $this->messageManager->addError(__('Something went wrong while saving your status.'));
            }
        }
        $this->_redirect('customerstatus/manage/');
    }

    
}
