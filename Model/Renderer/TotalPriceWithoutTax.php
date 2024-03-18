<?php

namespace LauserMedia\CustomPrice\Model\Renderer;

use Magento\Framework\Exception\NoSuchEntityException;

class TotalPriceWithoutTax extends \Magetrend\PdfTemplates\Model\Pdf\Element\Items\Column\DefaultRenderer
{
    public $productRepository;

    public function __construct(
        \Magetrend\PdfTemplates\Helper\Data $moduleHelper,
        \Magetrend\PdfTemplates\Model\Pdf\Element $element,
        \Magetrend\PdfTemplates\Model\Pdf\Decorator $decorator,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        $this->productRepository = $productRepository;
        parent::__construct($moduleHelper, $element, $decorator, $scopeConfig, $data);
    }

    public function getRowValue($item = null)
    {
        if ($item === null || !$item->getProductId()) {
            return '';
        }

        $qtyOrdered = $item->getQtyOrdered();

        try {
            $product = $this->productRepository->getById($item->getProductId());
            $netPrice = $product->getPriceInfo()->getPrice('final_price')->getAmount()->getBaseAmount();
            $totalNetPrice = $netPrice * $qtyOrdered;
        } catch (NoSuchEntityException $e) {
            return '';
        }

        return number_format($totalNetPrice, 2, '.', '') . ' ' . $item->getOrder()->getOrderCurrencyCode();
    }
}