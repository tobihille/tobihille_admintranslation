<?php
/**
 * Created by PhpStorm.
 * User: neo
 * Date: 28.06.15
 * Time: 10:03
 */
class Tobihille_AdminTranslation_Block_Admintranslation extends Mage_Adminhtml_Block_Widget_Grid_Container
{

  public function __construct()
  {
    $this->_blockGroup      = 'tobihille_admintranslation';
    $this->_controller      = 'admintranslation';
    $this->_headerText      = Mage::helper('admtrans')->___('Maintain prepared translations');
    $this->_addButtonLabel  = Mage::helper('admtrans')->___('add new translation');

    parent::__construct();
  }

  public function getCreateUrl()
  {
    return $this->getUrl('*/*/new');
  }

}

