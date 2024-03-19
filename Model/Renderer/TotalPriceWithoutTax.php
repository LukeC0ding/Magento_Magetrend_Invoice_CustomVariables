<?php

namespace LauserMedia\CustomPrice\Model\Renderer;

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

    public function getRowValue(): string
    {
        $item = $this->getItem();
        try {
            $product = $this->productRepository->getById($item->getProductId());
        } catch (NoSuchEntityException $e) {
            return '';
        }

        if ($item instanceof \Magento\Sales\Model\Order\Item) {
            $qty = $item->getQtyOrdered();
        } else {
            $qty = $item->getQty();
        }

        $netPrice = $product->getPrice() - $item->getTaxAmount();
        $netTotal = $netPrice * $qty;

        return number_format($netTotal, 2, '.', '') . ' €';
    }
}
