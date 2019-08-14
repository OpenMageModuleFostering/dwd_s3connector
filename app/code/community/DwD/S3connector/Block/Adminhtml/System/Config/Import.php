<?php

/**
 *
 * DwD-S3connector - Magento Extension
 *
 * @copyright Copyright (c) 2014 DwDesigner Inc. (http://www.dwdeveloper.com/)
 * @author Damian A. Pastorini - damian.pastorini@dwdeveloper.com
 *
 */

class DwD_S3connector_Block_Adminhtml_System_Config_Import
    extends Mage_Adminhtml_Block_System_Config_Form_Field
    implements Varien_Data_Form_Element_Renderer_Interface
{

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $buttonBlock = Mage::app()->getLayout()->createBlock('adminhtml/widget_button');
        $params = array();
        $data = array(
            'label'     => Mage::helper('adminhtml')->__('Start Import!'),
            'onclick'   => 'setLocation(\''.Mage::helper('adminhtml')->getUrl("*/s3connector/import", $params) . '\' )',
            'class'     => '',
        );
        $html = $buttonBlock->setData($data)->toHtml();
        return $html;
    }

}
