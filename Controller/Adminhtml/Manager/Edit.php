<?php
namespace MRYM\SalesManager\Controller\Adminhtml\Manager;

use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use MRYM\SalesManager\Controller\Adminhtml\Manager;
use Magento\Framework\App\Action\HttpGetActionInterface;
use MRYM\SalesManager\Controller\Register;

class Edit extends Manager implements HttpGetActionInterface
{
    private $managerFactory;

    public function __construct(Action\Context $context, Registry $coreRegistry, \MRYM\SalesManager\Model\ManagerFactory $managerFactory)
    {
        parent::__construct($context, $coreRegistry);
        $this->managerFactory = $managerFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        if ($id) {
            try {
                /** @var \MRYM\SalesManager\Model\Manager $model */
                $model = $this->managerFactory->create();
                $model->load($id);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage(__('This rule no longer exists.'));
                $this->_redirect('sales_manager/*');
                return;
            }
        } else {
            /** @var \MRYM\SalesManager\Model\Manager $model */
            $model = $this->managerFactory->create();
        }

        // set entered data if was error when we do save
        $data = $this->_objectManager->get(\Magento\Backend\Model\Session::class)->getPageData(true);
        if (!empty($data)) {
            $model->addData($data);
        }

        $this->coreRegistry->register(Register::CURRENT_MANAGER_ID, $model);

        $this->_initAction();
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Manager'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            $model->getData('manager_id') ? $model->getData('name') : __('New Manager')
        );

        $breadcrumb = $id ? __('Edit Manager') : __('New Manager');
        $this->_addBreadcrumb($breadcrumb, $breadcrumb);
        $this->_view->renderLayout();
    }
}