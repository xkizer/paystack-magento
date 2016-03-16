<?php
$installer = $this;
// $installer->startSetup();
// $installer->run("
// ALTER TABLE `{$installer->getTable('sales/quote_payment')}` 
// ADD `custom_field_one` VARCHAR( 255 ) NOT NULL,
// ADD `custom_field_two` VARCHAR( 255 ) NOT NULL;
//   
// ALTER TABLE `{$installer->getTable('sales/order_payment')}` 
// ADD `custom_field_one` VARCHAR( 255 ) NOT NULL,
// ADD `custom_field_two` VARCHAR( 255 ) NOT NULL;
// ");
// $installer->endSetup();

$helper = Mage::helper('paystack_inline');
// if ($isUpdate) {
//     $text = 'The Paystack Inline Extension has been successfully upgraded. New fields are ready to be configured.';
// } else {

$text = 'The Paystack Inline Extension has been successfully installed and is ready to be configured.';

Mage::getModel('adminnotification/inbox')->addMajor(
    $helper->__($text),
    $helper->__($text),
    '',
    true
);
