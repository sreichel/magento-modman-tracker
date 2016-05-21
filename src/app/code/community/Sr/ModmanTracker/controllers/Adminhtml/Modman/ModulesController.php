<?php

class Sr_ModmanTracker_Adminhtml_Modman_ModulesController extends Mage_Adminhtml_Controller_Action
{
    /**
     * indexAction
     *
     * @return void
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('modman_tracker');
        $this->_title($this->__('Index') . ' / ' . 'modman');
        $this->renderLayout();
    }

    /**
     * ACL checking
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('modman_tracker/modules');
    }
}
