<?php
class Paystack_Inline_Model_Paymentmethod extends Mage_Payment_Model_Method_Abstract {
    protected $_code  = 'paystack_inline';
    protected $_formBlockType = 'paystack_inline/form_inline';
    protected $_infoBlockType = 'paystack_inline/info_inline';

    public function assignData($data)
    {
        $info = $this->getInfoInstance();
 
        return $this;
    }

    public function validate()
    {
        parent::validate();
        $info = $this->getInfoInstance();
 
        return $this;
    }

    public function getOrderPlaceRedirectUrl()
    {
        return Mage::getUrl('paystack/payment/pop');
    }
}