<?php
namespace MRYM\SalesManager\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Item extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = SalesManager::DB_SALES_ITEMS_NAME;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('MRYM\SalesManager\Model\ResourceModel\Item');
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}