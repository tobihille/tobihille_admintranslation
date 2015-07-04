<?php
/**
 * Created by PhpStorm.
 * User: neo
 * Date: 28.06.15
 * Time: 09:33
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$tableName = Mage::getSingleton('core/resource')->getTableName('tobihille_admintranslation');

$dbname = (string) Mage::getConfig()->getNode('global/resources/default_setup/connection/dbname');

$storeTableName = Mage::getSingleton('core/resource')->getTableName('core/store');

$modify = <<<SQL
alter table $tableName modify store_id SMALLINT UNSIGNED;
SQL;

$installer->run($modify);

$SQL = <<<SQL
select
  CONSTRAINT_NAME
from INFORMATION_SCHEMA.KEY_COLUMN_USAGE
where
  CONSTRAINT_SCHEMA = '$dbname' and
  TABLE_NAME = '$tableName' and
  CONSTRAINT_NAME <> 'PRIMARY'
SQL;

$fkName = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($SQL);

$drop = <<<SQL
alter table $tableName drop foreign key {$fkName[0]['CONSTRAINT_NAME']};

alter table $tableName add foreign key {$tableName}_fk_core_store (store_id) REFERENCES {$storeTableName} (store_id) ON DELETE CASCADE;

SQL;

if ( count($fkName) == 0 )
{
  $drop = <<<SQL
alter table $tableName add constraint {$tableName}_fk_core_store foreign key (store_id)
  references {$storeTableName} (store_id) on delete cascade;
SQL;
}

$installer->run($drop);

$installer->endSetup();