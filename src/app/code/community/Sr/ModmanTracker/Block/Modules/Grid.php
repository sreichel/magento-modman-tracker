<?php

class Sr_ModmanTracker_Block_Modules_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('modules_grid');
        $this->setDefaultSort('name');
        $this->setDefaultDir('ASC');
        $this->_filterVisibility = false;
        $this->_pagerVisibility = false;
    }

    /**
     * Prepare grid collection
     *
     * @return Sr_ModmanTracker_Block_Modman_Modules_Grid Grid object
     */
    protected function _prepareCollection()
    {
        $collection = Mage::helper('modman_tracker/modules')->getModulesCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepare grid columns
     *
     * @return Sr_ModmanTracker_Block_Modman_Modules_Grid Grid object
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'name',
            array(
                'header'   => $this->__('Module Name'),
                'align'    => 'left',
                'index'    => 'name',
                'sortable' => true
            )
        );

        $this->addColumn(
            'url',
            array(
                'header'         => $this->__('URL'),
                'align'          => 'left',
                'index'          => 'url',
                'frame_callback' => array($this, 'decorateUrl')
            )
        );

        $this->addColumn(
            'commits',
            array(
                'header'         => $this->__('Diff commits'),
                'align'          => 'left',
                'width'          => '100px',
                'index'          => 'commits',
                'frame_callback' => array($this, 'decorateBehind')
            )
        );

        $this->addColumn(
            'info',
            array(
                'header'         => $this->__('Notice'),
                'align'          => 'left',
                'index'          => 'info',
            )
        );
    }

    /**
     * Decorate the behind column values
     *
     * @param  string        $value Check result
     * @param  Varien_Object $row   Current row
     * @return string        Cell content
     */
    public function decorateBehind($value, $row)
    {
        switch (true) {
            case $value === 'n/a':
                return '<span class="grid-severity-critical"><span>' . $value . '</span></span>';
            break;
            case (int) $value === 0:
                return '<span class="grid-severity-notice"><span>' . $value . '</span></span>';
            break;
            case (int) $value < 0:
                return '<span class="grid-severity-minor"><span>' . $value . '</span></span>';
            break;
            case (int) $value > 0:
                return '<span class="grid-severity-major"><span>' . $value . '</span></span>';
            break;
        }
    }

    /**
     * Decorate the url column values
     *
     * @param  string        $value Check result
     * @param  Varien_Object $row   Current row
     * @return string        Cell content
     */
    public function decorateUrl($value, $row)
    {
        return "<a href='{$value}'>{$value}</a>";
    }
    
    /**
     * Get row edit url
     *
     * @param  Varien_Object $row Current row
     * @return string|boolean Row url | false = no url
     */
    public function getRowUrl($row)
    {
        return false;
    }
}
