<?php
namespace MRYM\SalesManager\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use MRYM\SalesManager\Model\SalesManager;

class Item extends AbstractDb
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(SalesManager::DB_SALES_ITEMS_NAME, 'manager_item_id');
    }
}