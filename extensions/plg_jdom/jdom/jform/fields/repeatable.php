<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Form Field class for the Joomla Platform.
 * Display a JSON loaded window with a repeatable set of sub fields
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @since       3.2
 */
class JFormFieldRepeatable extends JdomClassFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  3.2
	 */
	protected $type = 'Repeatable';

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   3.2
	 */
	public function getInput()
	{
		// Initialize variables.
		$subForm = new JForm($this->name, array('control' => 'jform'));
		$xml = $this->element->children()->asXML();		
		$subForm->load($xml);

		// Needed for repeating modals in gmaps
		$subForm->repeatCounter = (int) @$this->form->repeatCounter;
		$children = $this->element->children();

		$subForm->setFields($children);
		$modalid = $this->id . '_modal';

		$str = array();
		$str[] = '<div id="' . $modalid . '" style="display:none">';
		$str[] = '<table id="' . $modalid . '_table" class="adminlist ' . $this->element['class'] . ' table table-striped">';
		$str[] = '<thead><tr>';
		$names = array();
		$attributes = $this->element->attributes();

		foreach ($subForm->getFieldset($attributes->name . '_modal') as $field)
		{
			$names[] = (string) $field->element->attributes()->name;
			$str[] = '<th>' . strip_tags($field->getLabel($field->name));
			$str[] = '<br /><span class="small">' . JText::_($field->description) . '</span>';
			$str[] = '</th>';
		}

		$str[] = '<th><a href="#" class="add btn button btn-success btn-mini" onclick="return false;"><span class="icomoon icon-plus"></span></a></th>';
		$str[] = '</tr></thead>';
		$str[] = '<tbody><tr>';

		foreach ($subForm->getFieldset($attributes->name . '_modal') as $field)
		{
			$str[] = '<td>' . $field->getInput() . '</td>';
		}

		$str[] = '<td>';
		$str[] = '<div class="btn-group"><a class="add btn button btn-success btn-mini" href="#" onclick="return false;"><span class="icomoon icon-plus"></span></a>';
		$str[] = '<a class="remove btn button btn-danger btn-mini" href="#" onclick="return false;"><span class="icomoon icon-minus"></span></a></div>';
		$str[] = '</td>';
		$str[] = '</tr></tbody>';
		$str[] = '</table>';
		$str[] = '</div>';

		$names = json_encode($names);

		JDom::_('framework.jquery.joomlarepeatable');

		// If a maximum value isn't set then we'll make the maximum amount of cells a large number
		$maximum = $this->element['maximum'] ? (int) $this->element['maximum'] : '999';

		$script = "(function ($){
			$(document).ready(function (){
				var repeatable = new $.JRepeatable('$modalid', $names, '$this->id', '$maximum');
			});
		})(jQuery);";

		$document = JFactory::getDocument();
		$document->addScriptDeclaration($script);

		$select = (string) $this->element['select'] ? JText::_((string) $this->element['select']) : JText::_('JLIB_FORM_BUTTON_SELECT');
		$icon = $this->element['icon'] ? '<i class="icon-' . $this->element['icon'] . '"></i> ' : '';
		$str[] = '<a class="btn" id="' . $modalid . '_button" data-modal="' . $modalid . '">' . $icon . $select . '</a>';

		if (is_array($this->value))
		{
			$this->value = array_shift($this->value);
		}

		$value = htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8');
		$str[] = '<input type="hidden" name="' . $this->name . '" id="' . $this->id . '" value="' . $value . '" />';

		JText::script('JAPPLY');
		JText::script('JCANCEL');
		return implode("\n", $str);
	}
	
	public function getOutput($tmplEngine = null)
	{
		$html = '';
		if(!isset($this->value)){
			return $html;
		}
	
		$value = json_decode($this->value);
		
		if(!count($value)){
			return $html;
		}
		
		
		// Initialize variables.
		$subForm = new JForm($this->name, array('control' => 'jform'));
		$xml = $this->element->children()->asXML();		
		$subForm->load($xml);

		// Needed for repeating modals in gmaps
		$subForm->repeatCounter = (int) @$this->form->repeatCounter;
		$children = $this->element->children();

		$subForm->setFields($children);
		$attributes = $this->element->attributes();

		$str = array();
		$str[] = '<table class="table table-striped table-bordered table-condensed">';
		$str[] = '<tr>';
		$str[] = '<th style="width: 1%;">N.</th>';
		foreach ($subForm->getFieldset($attributes->name . '_modal') as $field)
		{
			$str[] = '<th>' . strip_tags($field->getLabel($field->name));
			$str[] = '<br /><span class="small">' . JText::_($field->description) . '</span>';
			$str[] = '</th>';
		}	
		$str[] = '</tr>';
		
		foreach($value as $k => $it){
			$str[] = '<tr>';
			$str[] = '<td>'. ($k+1) .'</td>';
			foreach($it as $k => $v){
				$str[] = '<td>'. $v .'</td>';
			}
			$str[] = '</tr>';
		}
		
		$str[] = '</table>';
		
		$html .= implode("\n",$str);
		
		return $html;
	}
}
