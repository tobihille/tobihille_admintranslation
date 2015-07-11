<?php
/**
 * Created by PhpStorm.
 * User: neo
 * Date: 28.06.15
 * Time: 09:33
 */ 
class Tobihille_AdminTranslation_Helper_Data extends Mage_Core_Helper_Abstract {

  public function ___($string, int $store = null)
  {
    if ( empty($store) )
    {
      $store = 0;
    }
    if ( is_object($store) && $store instanceof Mage_Core_Model_Store)
    {
      $store = $store->getId();
    }

    $args = func_get_args();

    $trColl = Mage::getModel('tobihille_admintranslation/admintranslation')->getCollection()->
      addFieldToFilter('from_string', $args[0])->
      addFieldToFilter('store_id', $store);

    unset($args[1]);

    $trColl->load();

    foreach ($trColl as $translation)
    {
      $translated = $translation->getData('to_string');
      $result = @vsprintf($translated, $args);
      return $result;
    }

    if ( Mage::getStoreConfig('web/general/custom_translation_fallback') )
    {
      //get calling class and extract modulename from it
      $bTrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
      $moduleName = $bTrace[0]['class'];
      $moduleName = substr($moduleName, 0, strpos($moduleName, '_Helper'));

      $this->_moduleName = $moduleName;
      return call_user_func_array(array($this, "__"), $args);
    }
  }

}