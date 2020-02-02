<?php
namespace MRYM\SalesManager\Controller\Adminhtml\Manager;

use MRYM\SalesManager\Controller\Adminhtml\Manager;
use Magento\Framework\App\Action\HttpGetActionInterface;

class NewAction extends Manager implements HttpGetActionInterface
{
    /**
     * @return void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}