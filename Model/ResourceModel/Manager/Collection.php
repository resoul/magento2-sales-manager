<?php
namespace MRYM\SalesManager\Model\ResourceModel\Manager;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'manager_id';
    /**
     * Constructor
     * Configures collection
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('MRYM\SalesManager\Model\Manager', 'MRYM\SalesManager\Model\ResourceModel\Manager');
    }

    public function addPositionFilter($position)
    {
        return $this->addFieldToFilter('position', $position);
    }

    protected function _afterLoad()
    {
        foreach ($this as $item) {
            $position = explode(':', $item->getData('position'));

            $item->setData('country_id', $position[0]);
            if (isset($position[1])) {
                $item->setData('region_id', $position[1]);
            }
        }

        return parent::_afterLoad();
    }
}