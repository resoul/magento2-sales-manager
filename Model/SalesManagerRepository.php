<?php
namespace MRYM\SalesManager\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use MRYM\SalesManager\Api\SalesManagerInterface;
use MRYM\SalesManager\Model\ManagerFactory as ManagerFactory;
use MRYM\SalesManager\Model\ResourceModel\Manager;

class SalesManagerRepository
{
    protected $manager;
    protected $factory;

    public function __construct(Manager $factory, ManagerFactory $manager)
    {
        $this->factory = $factory;
        $this->manager = $manager;
    }

    public function save($manager)
    {
        try {
            $this->factory->save($manager);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the manager: %1', $exception->getMessage()),
                $exception
            );
        }

        return $manager;
    }

    public function get($managerId)
    {
        // TODO: Implement get() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function getById($id)
    {
        $manager = $this->manager->create();
        $manager->load($id);
        if (!$manager->getId()) {
            throw new NoSuchEntityException(__('The Manager with the "%1" ID doesn\'t exist.', $id));
        }
        return $manager;
    }
}