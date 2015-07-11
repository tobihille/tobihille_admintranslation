<?php
/**
 * Created by PhpStorm.
 * User: neo
 * Date: 28.06.15
 * Time: 10:00
 */

class Tobihille_AdminTranslation_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{

  public function indexAction()
  {
    $this->loadLayout();
    $this->_addContent($this->getLayout()->createBlock('tobihille_admintranslation/admintranslation'));
    $this->renderLayout();
  }

  public function exportCsvAction()
  {
    $fileName = 'translations_export.csv';
    $content = $this->getLayout()->createBlock('tobihille_admintranslation/admintranslation_grid')->getCsv();
    $this->_prepareDownloadResponse($fileName, $content);
  }

  public function exportExcelAction()
  {
    $fileName = 'translations_export.xml';
    $content = $this->getLayout()->createBlock('tobihille_admintranslation/admintranslation_grid')->getExcel();
    $this->_prepareDownloadResponse($fileName, $content);
  }

  public function massDeleteAction()
  {
    $ids = $this->getRequest()->getParam('ids');
    if ( !is_array($ids) )
    {
      $this->_getSession()->addError( $this->___('Please select at least one translation.') );
    }
    else
    {
      try
      {
        foreach ($ids as $id)
        {
          $model = Mage::getSingleton('tobihille_admintranslation/admintranslation')->load($id);
          $model->delete();
        }

        $this->_getSession()->addSuccess(
            $this->___( 'Total of %d record(s) have been deleted.', count($ids) )
        );
      }
      catch (Mage_Core_Exception $e)
      {
        $this->_getSession()->addError( $e->getMessage() );
      }
      catch (Exception $e)
      {
        $this->_getSession()->addError(
          Mage::helper('tobihille_admintranslation')->
            ___('An error occurred while mass deleting items. Please review log and try again.')
        );
        Mage::logException($e);
        return;
      }
    }

    $this->_redirect('*/*/index');
  }

  public function editAction()
  {
    $id = $this->getRequest()->getParam('id');
    $model = Mage::getModel('tobihille_admintranslation/admintranslation');

    if ($id)
    {
      $model->load($id);
      if ( !$model->getId() )
      {
        $this->_getSession()->addError(
          Mage::helper('admtrans')->___('This translation no longer exists.')
        );
        $this->_redirect('*/*/');
        return;
      }
    }

    $data = $this->_getSession()->getFormData(true);
    if ( !empty($data) )
    {
      $model->setData($data);
    }

    Mage::register('admintranslation_model', $model);

    $this->loadLayout();
    $this->_addContent( $this->getLayout()->createBlock('tobihille_admintranslation/admintranslation_edit') );
    $this->renderLayout();
  }

  public function newAction()
  {
    $this->_forward('edit');
  }

  public function saveAction()
  {
    $redirectBack = $this->getRequest()->getParam('back', false);

    if ( $data = $this->getRequest()->getPost() )
    {
      $id = $this->getRequest()->getParam('id');
      $model = Mage::getModel('tobihille_admintranslation/admintranslation');

      if ($id)
      {
        $model->load($id);

        if ( !$model->getId() )
        {
          $this->_getSession()->addError(
            Mage::helper('tobihille_admintranslation')->___('This translation no longer exists.')
          );
          $this->_redirect('*/*/index');
          return;
        }
      }

      // save model
      try
      {
        $model->addData($data);
        $this->_getSession()->setFormData($data);
        $model->save();
        $this->_getSession()->setFormData(false);
        $this->_getSession()->addSuccess(
          Mage::helper('tobihille_admintranslation')->___('The translation has been saved.')
        );
      }
      catch (Mage_Core_Exception $e)
      {
        $this->_getSession()->addError( $e->getMessage() );
        $redirectBack = true;
      }
      catch (Exception $e)
      {
        $this->_getSession()->addError(
          Mage::helper('tobihille_admintranslation')->___('Unable to save the translation.')
        );
        $redirectBack = true;
        Mage::logException($e);
      }

      if ($redirectBack)
      {
        $this->_redirect( '*/*/edit', array( 'id' => $model->getId() ) );
        return;
      }
    }

    $this->_redirect('*/*/index');
  }

  public function deleteAction()
  {
    if ( $id = $this->getRequest()->getParam('id') )
    {
      try
      {
        // init model and delete
        $model = Mage::getModel('tobihille_admintranslation/admintranslation');
        $model->load($id);

        if ( !$model->getId() )
        {
          Mage::throwException(
            Mage::helper('tobihille_admintranslation')->___('Unable to find a translation to delete.')
          );
        }

        $model->delete();
        // display success message
        $this->_getSession()->addSuccess(
          Mage::helper('tobihille_admintranslation')->___('The translation has been deleted.')
        );

        // go to grid
        $this->_redirect('*/*/index');
        return;
      }
      catch (Mage_Core_Exception $e)
      {
        $this->_getSession()->addError( $e->getMessage() );
      }
      catch (Exception $e)
      {
        $this->_getSession()->addError(
          Mage::helper('tobihille_admintranslation')->
              ___('An error occurred while deleting translation data. Please review log and try again.')
        );
        Mage::logException($e);
      }
      // redirect to edit form
      $this->_redirect('*/*/edit', array('id' => $id));
      return;
    }

    // display error message
    $this->_getSession()->addError(
      Mage::helper('tobihille_admintranslation')->___('Unable to find a translation to delete.')
    );

    // go to grid
    $this->_redirect('*/*/index');
  }

}