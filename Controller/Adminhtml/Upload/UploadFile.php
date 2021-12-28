<?php
/**
 * Tomasz Palkiewicz 2021
 */
namespace Palkiewicz\ProductTag\Controller\Adminhtml\Upload;
 
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\Product\Action as ProductAction;
use Magento\Framework\File\Csv;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Upload File
 */
class UploadFile extends Action
{
    /**
     * Product Tag Attribute
     */
    public const PATH_CSV_FILE = 'product_tag/general/custom_file_upload';

    /**
     * Product Tag Attribute
     */
    public const PRODUCT_TAG_ATTRIBUTE = 'product_tag_line';

    /**
     * @var Filesystem
     */
    protected $fileSystem;
 
    /**
     * @var Csv
     */
    protected $csv;

    /**
     * @var ProductAction
     */
    protected $productAction;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig; 

    public function __construct(
        Context $context,
        Filesystem $fileSystem,
        Csv $csv,
        ScopeConfigInterface $scopeConfig,
        ProductAction $action,
        StoreManagerInterface $storeManager,
        ProductRepositoryInterface $productRepository

    ) {
        parent::__construct($context);
        $this->fileSystem = $fileSystem;
        $this->csv = $csv;
        $this->scopeConfig = $scopeConfig;
        $this->productAction = $action;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
    }
 
    /**
     * Execute
     */
    public function execute()
    {
        $file = $this->scopeConfig->getValue(self::PATH_CSV_FILE, 
        \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $destinationPath = $this->getDestinationPath() . $file;

        if (!isset($file)) 
        throw new \Magento\Framework\Exception\LocalizedException(__('Invalid file upload attempt.'));

        $storeId = $this->storeManager->getStore()->getId();
        $csvData = $this->csv->getData($destinationPath);
        foreach ($csvData as $row => $destinationPath) {
            if ($row > 0){
                $product = $this->productRepository->get($destinationPath[0]);
                $this->productAction->updateAttributes([$product->getId()], array(self::PRODUCT_TAG_ATTRIBUTE => $destinationPath[1]), $storeId);
            }
        }
    }

    /**
     * Get Destination Path
     */
    public function getDestinationPath()
    {
        return $this->fileSystem
            ->getDirectoryWrite(DirectoryList::PUB)
            ->getAbsolutePath('/');
    }
}
