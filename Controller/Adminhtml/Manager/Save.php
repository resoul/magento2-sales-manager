<?php
namespace MRYM\SalesManager\Controller\Adminhtml\Manager;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Registry;
use MRYM\SalesManager\Controller\Adminhtml\Manager;
use MRYM\SalesManager\Model\ManagerFactory;
use MRYM\SalesManager\Model\SalesManager;
use MRYM\SalesManager\Model\SalesManagerRepository;

class Save extends Manager implements HttpPostActionInterface
{
    protected $manager;
    protected $repository;

    public function __construct(Action\Context $context, SalesManagerRepository $saleManager, Registry $coreRegistry, ManagerFactory $factory)
    {
        parent::__construct($context, $coreRegistry);
        $this->manager = $factory;
        $this->repository = $saleManager;
    }

    public function execute()
    {
        if ($this->getRequest()->getPostValue()) {
            $data = $this->getRequest()->getPostValue();

            $manager = $this->manager->create();
            $id = $this->getRequest()->getParam('manager_id');
            if ($id) {
                $manager = $this->repository->getById($id);
            }

            $manager->addData([
                'email' => $data['email'],
                'position' => $data['country_id'] . ':' . $data['region_id'],
                'name' => $data['country'] . ', ' . $data['region']
            ]);

            $this->repository->save($manager);
        }

        $this->_redirect('sales_manager/*/');
    }
}