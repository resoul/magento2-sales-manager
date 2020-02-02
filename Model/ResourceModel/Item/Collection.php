<?php
namespace MRYM\SalesManager\Model\ResourceModel\Item;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Constructor
     * Configures collection
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('MRYM\SalesManager\Model\Item', 'MRYM\SalesManager\Model\ResourceModel\Item');
    }
}