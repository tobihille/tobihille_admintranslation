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

$storeTableName = Mage::getSingleton('core/resource')->getTableName('store');

$SQL = <<<SQL
create table if not exists $tableName (
  translation_id integer not null auto_increment primary key,
  from_string text not null,
  to_string text not null,
  store_id integer,
  FOREIGN KEY (store_id) REFERENCES $storeTableName(store_id) ON DELETE CASCADE
)
SQL;

$installer->run($SQL);

$installer->endSetup();