<?php
namespace MRYM\SalesManager\Api;

interface SalesManagerRepositoryInterface
{
    public function save(SalesManagerInterface $manager);

    public function get($managerId);

    public function delete(SalesManagerInterface $manager);
}
