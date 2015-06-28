<?php
/**
 * Created by PhpStorm.
 * User: neo
 * Date: 28.06.15
 * Time: 09:54
 */ 
class Tobihille_AdminTranslation_Model_Resource_Admintranslation_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('tobihille_admintranslation/admintranslation');
    }

}