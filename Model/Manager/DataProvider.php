<?php
namespace MRYM\SalesManager\Model\Manager;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use MRYM\SalesManager\Model\Manager;
use MRYM\SalesManager\Model\ResourceModel\Manager\CollectionFactory as CollectionManager;

class DataProvider extends ModifierPoolDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;

    protected $request;

    protected $collection;

    protected $registry;

    protected $dataPersistor;

    public function __construct($name, $primaryFieldName,DataPersistorInterface $dataPersistor, \Magento\Framework\Registry $registry, CollectionManager $collection, RequestInterface $request, $requestFieldName, array $meta = [], array $data = [], PoolInterface $pool = null)
    {
        $this->request = $request;
        $this->registry = $registry;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
        $this->collection = $collection->create();
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        /** @var \Magento\Cms\Model\Block $block */
        foreach ($items as $block) {
            $this->loadedData[$block->getId()] = $block->getData();
        }

        $data = $this->dataPersistor->get('sales_manager');
        if (!empty($data)) {
            $block = $this->collection->getNewEmptyItem();
            $block->setData($data);
            $this->loadedData[$block->getId()] = $block->getData();
            $this->dataPersistor->clear('sales_manager');
        }

        return $this->loadedData;
    }
}