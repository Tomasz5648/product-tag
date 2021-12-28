<?php
/**
 * Tomasz Palkiewicz 2021
 */
namespace Palkiewicz\ProductTag\Block\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class Button
 */
class Button extends Field
{
    /**
     * Template
     */
    protected $_template = 'Palkiewicz_ProductTag::system/config/button.phtml';

    public const CONTROLLER_PATH = 'palkiewicz_producttag/upload/uploadfile';

    public function __construct(
        Context $context, 
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Render
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Get Element HTML
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }

    /**
     * Get Ajax Url
     */
    public function getAjaxUrl()
    {
        return $this->getUrl(self::CONTROLLER_PATH);
    }

    /**
     * Get Button HTML
     */
    public function getButtonHtml()
    {
        $button = $this->getLayout()->createBlock(
            'Magento\Backend\Block\Widget\Button'
        )->setData(
            [
                'id' => 'custom_button',
                'label' => __('Import')
            ]
        );
        return $button->toHtml();
    }
}
