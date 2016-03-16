<?php

class Paystack_Inline_PaymentController extends Mage_Core_Controller_Front_Action 
{
    public function cancelAction() 
    {
        Mage::getSingleton('core/session')->addError(
            Mage::helper('paystack_inline')->__("Payment cancelled."));
        Mage_Core_Controller_Varien_Action::_redirect('checkout/cart');
    }

    public function popAction() 
    {
        $this->loadLayout();
        $block = $this->getLayout()->createBlock('Mage_Core_Block_Template','paystack_inline',array('template' => 'paystack/pop.phtml'));
        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
    }

    public function responseAction() 
    {
        $success = false;

        $orderId = $this->getRequest()->get("orderId");
        $trxref = $this->getRequest()->get("trxref");
        
        // Both are required
        if(!$orderId || !$trxref){
            return;
        }
        
        // trxref must start with orderId by design
        if(strpos($trxref, $orderId) !== 0){
            return;
        }

        $order = Mage::getModel('sales/order')->loadByIncrementId($orderId);
        if(!$order){
            return;
        }


        // verify transaction with paystack
        $transactionStatus = Mage::helper('paystack_inline')->verifyTransaction($trxref);
        if($transactionStatus->error)
        {
            Mage::getModel('adminnotification/inbox')->addMajor(
                Mage::helper('paystack_inline')->__("Error while attempting to verify transaction: trxref: " . $trxref),
                Mage::helper('paystack_inline')->__($transactionStatus->error),
                '',
                true
            );
        }
        elseif($transactionStatus->status == 'success')
        {
            $order->setState(Mage_Sales_Model_Order::STATE_PAYMENT_REVIEW, true, 'Payment Success.');
            $order->save();

            Mage::getSingleton('checkout/session')->unsQuoteId();
            Mage_Core_Controller_Varien_Action::_redirect('checkout/onepage/success');
            $success = true;
        }
        else
        {
            $order->setState(Mage_Sales_Model_Order::STATE_PAYMENT_REVIEW, true, $transactionStatus->status);
            $order->save();

            Mage::getSingleton('checkout/session')->unsQuoteId();
            Mage_Core_Controller_Varien_Action::_redirect('checkout/onepage/success');
        }
    
        
        if(!$success){
            Mage::getSingleton('core/session')->addError(
                Mage::helper('paystack_inline')->__("There was an error processing your payment. Please try again."));
            Mage_Core_Controller_Varien_Action::_redirect('checkout/cart');
        }
        
    }
}