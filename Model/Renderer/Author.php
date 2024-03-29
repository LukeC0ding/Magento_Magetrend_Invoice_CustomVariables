<?php

namespace LauserMedia\CustomPrice\Model\Renderer;

use Magento\Framework\Exception\NoSuchEntityException;

class Author extends \Magetrend\PdfTemplates\Model\Pdf\Element\Items\Column\DefaultRenderer
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

    public function getRowValue()
    {
        try {
            $product = $this->productRepository->getById($item->getProductId());
        } catch (NoSuchEntityException $e) {
            return '';
        }

        return $product->getAuthor();
    }
}
