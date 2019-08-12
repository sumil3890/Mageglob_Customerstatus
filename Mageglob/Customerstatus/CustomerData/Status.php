<?php
namespace Mageglob\Customerstatus\CustomerData;
 
use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Model\CustomerFactory as CustomerFactory;
 
/**
 * Status data source
 */
class Status extends \Magento\Framework\DataObject implements SectionSourceInterface
{
    protected $currentCustomer;

     /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * Initialize dependencies.
     *
     * @param CustomerFactory $CustomerFactory
     */
    public function __construct(
        CurrentCustomer $currentCustomer,
        CustomerFactory $customerFactory,
        \Magento\Customer\Model\Session $_customerSession
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->customerFactory = $customerFactory->create();
        $this->_customerSession = $_customerSession;
    }

    public function getSectionData() {
        if ($this->_customerSession->isLoggedIn()) {
            $customerId = $this->currentCustomer->getCustomer()->getId();
            if ($customerId === null) {
                return [
                    'active' => ''
                ];
            } else {
                $customer = $this->customerFactory->load($customerId);
                return [
                    'active' => $customer->getNewStatus()
                ];
            }
        } else{
            return [
                'active' => ''
            ];
        }
           
    }
}