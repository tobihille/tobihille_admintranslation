<?php
/**
 * Created by PhpStorm.
 * User: neo
 * Date: 28.06.15
 * Time: 10:03
 */
class Tobihille_AdminTranslation_Block_Admintranslation_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

  public function __construct()
  {
    parent::__construct();

    $this->_blockGroup      = 'tobihille_admintranslation';
    $this->_controller      = 'admintranslation';
    $this->_mode            = 'edit';

    $modelTitle = $this->_getModelTitle();
    $this->_updateButton( 'save', 'label', $this->_getHelper()->___("Save translation") );
    $this->_addButton('saveandcontinue',
      array(
        'label'     => $this->_getHelper()->___('Save and Continue Edit'),
        'onclick'   => 'saveAndContinueEdit()',
        'class'     => 'save',
      ),
      -100
    );

    $this->_formScripts[] = "
      function saveAndContinueEdit(){
        editForm.submit($('edit_form').action+'back/edit/');
      }
    ";
  }

  protected function _getHelper(){
    return Mage::helper('tobihille_admintranslation');
  }

  protected function _getModel(){
    return Mage::registry('admintranslation_model');
  }

  protected function _getModelTitle(){
    return $this->_getHelper()->___('Maintain translation');
  }

  public function getHeaderText()
  {
    $model = $this->_getModel();
    $modelTitle = $this->_getModelTitle();
    if ( $model && $model->getId() )
    {
      return $this->_getHelper()->___("Edit translation (ID: %s)", $model->getId() );
    }
    else
    {
     return $this->_getHelper()->___("New translation");
    }
  }

  /**
   * Get URL for back (reset) button
   *
   * @return string
   */
  public function getBackUrl()
  {
    return $this->getUrl('*/*/index');
  }

  public function getDeleteUrl()
  {
    return $this->getUrl('*/*/delete',
      array(
        $this->_objectId => $this->getRequest()->getParam($this->_objectId)
      )
    );
  }

  /**
   * Get form save URL
   *
   * @deprecated
   * @see getFormActionUrl()
   * @return string
   */
  public function getSaveUrl()
  {
    $this->setData('form_action_url', 'save');
    return $this->getFormActionUrl();
  }

}
