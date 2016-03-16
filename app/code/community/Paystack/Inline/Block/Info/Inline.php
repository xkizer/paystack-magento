<?php
class Paystack_Inline_Block_Info_Inline extends Mage_Payment_Block_Info
{
  protected function _prepareSpecificInformation($transport = null)
  {
    if (null !== $this->_paymentSpecificInformation) 
    {
      return $this->_paymentSpecificInformation;
    }
 
    return parent::_prepareSpecificInformation($transport);
  }
}