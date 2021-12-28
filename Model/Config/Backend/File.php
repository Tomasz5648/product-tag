<?php
/**
 * Tomasz Palkiewicz 2021
 */
namespace Palkiewicz\ProductTag\Model\Config\Backend;
  
class File extends \Magento\Config\Model\Config\Backend\File
{
    /**
     * Get Allowed Extensions
     */
    public function getAllowedExtensions() {
        return ['csv', 'xls'];
    }
}
