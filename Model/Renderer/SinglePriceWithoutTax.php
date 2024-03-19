<?php

namespace LauserMedia\CustomPrice\Model\Renderer;

class SinglePriceWithoutTax extends \Magetrend\PdfTemplates\Model\Pdf\Element\Items\Column\DefaultRenderer
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
        try {
            $product = $this->productRepository->getById($item->getProductId());
        } catch (NoSuchEntityException $e) {
            return '';
        }

        $netPrice = $product->getPrice();

        return number_format($netPrice, 2, '.', '') . ' ' . $product->getOrder()->getOrderCurrencyCode();
    }
}
