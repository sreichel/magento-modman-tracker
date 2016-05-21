<?php
class Sr_ModmanTracker_Block_Modules extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->_controller = 'modules';
        $this->_blockGroup = 'modman_tracker';
        $this->_headerText = $this->__('Check Modules');
        parent::__construct();
        $this->_removeButton('add');
    }
}
