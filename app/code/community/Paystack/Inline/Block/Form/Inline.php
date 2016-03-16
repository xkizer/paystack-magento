<?php
class Paystack_Inline_Block_Form_Inline extends Mage_Payment_Block_Form
{
  protected function _construct()
  {
    parent::_construct();
    $this->setTemplate('paystack/form/paystack_inline.phtml');
  }
}