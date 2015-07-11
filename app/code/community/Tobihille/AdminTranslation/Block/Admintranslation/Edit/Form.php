<?php
/**
 * Created by PhpStorm.
 * User: neo
 * Date: 28.06.15
 * Time: 10:03
 */
class Tobihille_AdminTranslation_Block_Admintranslation_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

  protected function _getModel()
  {
    return Mage::registry('admintranslation_model');
  }

  protected function _getHelper()
  {
      return Mage::helper('tobihille_admintranslation');
  }

  protected function _prepareForm()
  {
    $model  = $this->_getModel();

    $form   = new Varien_Data_Form(
      array(
        'id'        => 'edit_form',
        'action'    => $this->getUrl('*/*/save'),
        'method'    => 'post'
      )
    );

    $fieldset   = $form->addFieldset('base_fieldset',
      array(
        'legend'    => $this->_getHelper()->___("Edit"),
        'class'     => 'fieldset-wide',
      )
    );

    if ( $model && $model->getId() )
    {
      $modelPk = $model->getResource()->getIdFieldName();
      $fieldset->addField($modelPk, 'hidden',
        array(
          'name' => $modelPk,
        )
      );
    }

    $fieldset->addField('from_string', 'textarea',
      array(
        'name'      => 'from_string',
        'label'     => $this->_getHelper()->___('Source string'),
        'required'  => true,
      )
    );

    $fieldset->addField('to_string', 'textarea',
      array(
        'name'      => 'to_string',
        'label'     => $this->_getHelper()->___('Translated string'),
        'required'  => true,
      )
    );

    $stores = array();
    foreach (Mage::getModel('core/store')->getCollection()->toOptionArray() as $storeOption)
    {
      $stores[] = $storeOption['label'];
    }

    //force add admin. conveniently admin is everywhere '0' so all other start at least with '1' so it should work everywhere
    array_unshift($stores, Mage::helper('admtrans')->___('Global'));

    $fieldset->addField('store_id', 'select',
      array(
        'name'      => 'store_id',
        'label'     => $this->_getHelper()->___('Store'),
        'required'  => true,
        'options'   => $stores,
      )
    );

    if ($model)
    {
      $form->setValues( $model->getData() );
    }

    $form->setUseContainer(true);
    $this->setForm($form);

    return parent::_prepareForm();
  }

}
