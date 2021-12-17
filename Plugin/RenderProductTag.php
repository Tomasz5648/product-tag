<?php
/**
 * Tomasz Palkiewicz 2021
 */

namespace Palkiewicz\ProductTag\Plugin;

use Magento\Catalog\Block\Product\ListProduct;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Block\Product\Image;

/**
 * Class RenderProductTag
 */
class RenderProductTag
{
    /**
     *   const Product Tag Line
     */
    private const PRODUCT_TAG_LINE = 'product_tag_line';

    /**
     *  @var ProductRepositoryInterface
     */
    protected $productRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository
        ) {
            $this->productRepository = $productRepository;
        }

    /**
     * Display product attribute at a top of product
     */
    public function afterToHtml(Image $image, $result)
    {
        if ($image->getRequest()->getFullActionName() == 'catalog_category_view') {
            $product = $this->productRepository->getById($image->getProductId());

            $additional = '<p class="alert-product-tag">' . $product->getData(self::PRODUCT_TAG_LINE)  . '</p>';        
            return $additional . $result;
        }
        return $result;
    }
}
