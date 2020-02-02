<?php
namespace MRYM\SalesManager\Controller\Adminhtml\Manager;

use MRYM\SalesManager\Controller\Adminhtml\Manager;
use Magento\Framework\App\Action\HttpGetActionInterface;

class Index extends Manager implements HttpGetActionInterface
{
    /**
     * @return void
     */
    public function execute()
    {
        $this->_initAction()->_addBreadcrumb(__('Sales'), __('Manager'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Sales Manager'));
        $this->_view->renderLayout();
    }
}