<?php
namespace MRYM\SalesManager\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use MRYM\SalesManager\Model\SalesManager;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()->newTable(
            $installer->getTable(SalesManager::DB_SALES_NAME)
        )->addColumn(
            'manager_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Manager ID'
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Name'
        )->addColumn(
            'position',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Position'
        )->addColumn(
            'email',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Email'
        )->setComment(
            'Sales Manager'
        );
        $installer->getConnection()->createTable($table);

        $table = $installer->getConnection()->newTable(
            $installer->getTable(SalesManager::DB_SALES_ITEMS_NAME)
        )->addColumn(
            'manager_item_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Banner ID'
        )->addColumn(
            'position',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Position'
        )->addColumn(
            'message',
            Table::TYPE_TEXT,
            '64K',
            ['unsigned' => false, 'nullable' => true],
            'Message'
        )->setComment(
            'Sales Manager Items'
        );
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}