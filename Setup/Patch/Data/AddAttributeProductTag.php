<?php
/**
 * Tomasz Palkiewicz 2021
 */

namespace Palkiewicz\ProductTag\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Exception;

/**
 * AddAttributeProductTag class.
 */
class AddAttributeProductTag implements DataPatchInterface
{
    /**
     *  @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /** 
     * @var EavSetupFactory 
     */
    private $eavSetupFactory;

    /**
     * AddAttributeProductTag Constructor
     * @param ModuleDataSetupInterface $moduleDataSetup Data Setup Interface
     * @param EavSetupFactory $eavSetupFactory Eav Factory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * apply
     */
    public function apply()
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        try {
            $eavSetup->addAttribute(Product::ENTITY, 'product_tag_line', [
                'type' => 'text',
                'label' => 'Product Tag Line',
                'input' => 'text',
                'visible_on_front' => true,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'visible_in_grid' => true,
                'used_in_grid' => true,
                'filterable_in_grid' => true,
                'required' => false,
                'user_defined' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'group' => 'Product Details'
            ]);

        } catch (Exception $e) {
            throw new LocalizedException(
                __($e->getMessage())
            );
        }
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies() : array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases() : array
    {
        return [];
    }
}
