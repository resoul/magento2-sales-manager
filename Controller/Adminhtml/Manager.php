<?php
namespace MRYM\SalesManager\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Framework\Registry;

abstract class Manager extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'MRYM_SalesManager::manager';

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry = null;

    public function __construct(Action\Context $context, Registry $coreRegistry)
    {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
    }

    /**
     * @return void
     */
    public function execute()
    {
        $this->_initAction();
        $this->_view->renderLayout();
    }

    /**
     * Init action
     *
     * @return $this
     */
    protected function _initAction()
    {
        $this->_view->loadLayout();

        $this->_setActiveMenu(
            'MRYM_SalesManager::manager'
        )->_addBreadcrumb(__('Sales Manager'), __('Manager'));

        return $this;
    }
}