<?php
namespace LauserMedia\CustomPrice\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AddPrice implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        $basePrice = $product->getPrice();
        $customPrice = $basePrice * 1.1; // 10% Aufschlag
        $product->setData('custom_price', $customPrice);
    }
}
