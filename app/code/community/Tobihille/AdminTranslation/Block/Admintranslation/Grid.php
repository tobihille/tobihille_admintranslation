<?php
/**
 * Created by PhpStorm.
 * User: neo
 * Date: 28.06.15
 * Time: 10:03
 */
class Tobihille_AdminTranslation_Block_Admintranslation_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

  public function __construct()
  {
    parent::__construct();
    $this->setId('grid_id');
    $this->setDefaultDir('asc');
    $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
    $collection = Mage::getModel('tobihille_admintranslation/admintranslation')->getCollection();
    $this->setCollection($collection);
    return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
    $this->addColumn('column_id',
      array(
        'header'=> Mage::helper('admtrans')->___('ID'),
        'width' => '50px',
        'index' => 'translation_id'
      )
    );

    $this->addColumn('from_string',
      array(
        'header'=> Mage::helper('admtrans')->___('Source string'),
        'index' => 'from_string'
      )
    );

    $this->addColumn('to_string',
      array(
        'header'=> Mage::helper('admtrans')->___('Translated string'),
        'index' => 'to_string'
      )
    );

    $this->addColumn('store_id',
      array(
        'header'   => Mage::helper('admtrans')->___('Store'),
        'index'     => 'store_id',
        'type'      => 'store',
        'store_view'=> true,
        'display_deleted' => true,
      )
    );

    $this->addExportType('*/*/exportCsv', Mage::helper('admtrans')->___('CSV'));

    $this->addExportType('*/*/exportExcel', Mage::helper('admtrans')->___('Excel XML'));

    return parent::_prepareColumns();
  }

  public function getRowUrl($row)
  {
     return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

  protected function _prepareMassaction()
  {
    $modelPk = Mage::getModel('tobihille_admintranslation/admintranslation')->getResource()->getIdFieldName();
    $this->setMassactionIdField($modelPk);
    $this->getMassactionBlock()->setFormFieldName('ids');
    $this->getMassactionBlock()->addItem('delete',
      array(
        'label'=> Mage::helper('admtrans')->___('Delete'),
        'url'  => $this->getUrl('*/*/massDelete'),
      )
    );
    return $this;
  }

}
