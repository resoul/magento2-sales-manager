<?php
namespace MRYM\SalesManager\Block\Adminhtml\Manager;

use Magento\Backend\Block\Widget\Grid\Container;

class Manager extends Container
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'MRYM_SalesManager';
        $this->_controller = 'adminhtml_manager_index';
        $this->_headerText = __('Sales Manager');
        $this->_addButtonLabel = __('Add New Manager');
        parent::_construct();
    }
}