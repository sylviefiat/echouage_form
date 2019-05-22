<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Make thing clear
 *
 * @var JForm   $form       The form instance for render the section
 * @var string  $basegroup  The base group name
 * @var string  $group      Current group name
 * @var array   $buttons    Array of the buttons that will be rendered
 */
extract($displayData);
$sublayout = 'renderfield';
?>
<div
	class="subform-repeatable-group subform-repeatable-group-<?php echo $unique_subform_id; ?> <?php echo $basegroup; ?>"
	data-base-name="<?php echo $basegroup; ?>"
	data-group="<?php echo $group; ?>"
>
<style>
.fieldset {
	display:flex;
	width: 100%;
	flex-flow:wrap;
}
.closeTab {
	
	font-size: 1em;
}
</style>
<script type="text/javascript">	
	function displayTab(tabId,id) {
  		event.preventDefault(); 
  		jQuery(".subform-repeatable-group").each(function(index,value){
  			if(getID(value)===id){
  				jQuery(value).find("section").each(function(index,value){
		  			if(value.className.indexOf(tabId)<0){
		  				jQuery(value).hide();
		  			} else {
		  				jQuery(value).show();
		  			}
		  		});
                if(tabId==="none"){
                    if(jQuery(value).find(".fa-caret-down")[0] !== undefined){
                        jQuery(value).find(".closeTab")[0].className="closeTab fa fa-caret-right";
                    } else {
                        jQuery(value).find(".closeTab")[0].className="closeTab fa fa-caret-down";
                        jQuery(value).find(".Identification").show();
                    }
                } else {
                    jQuery(value).find(".closeTab")[0].className="closeTab fa fa-caret-down";
                }
  			}
  		});
	}
	function getID(element) {
		return element.attributes[2].value;
	}
</script>
	<?php if (!empty($buttons)) : ?>
	<div class="tab btn-toolbar">
		<div class="">			
			<button onclick="displayTab('none',getID(this.parentElement.parentElement.parentElement))"><span class="animalID"></span><span class="closeTab fa fa-caret-right"></span></button>
			<?php foreach ($form->getFieldsets() as $fieldset) : ?>		
				<?php if (!empty($fieldset->label)) : ?>			
					<button onclick="displayTab('<?php echo $fieldset->label; ?>',getID(this.parentElement.parentElement.parentElement))"><?php echo JText::_($fieldset->label); ?></button>
				<?php endif; ?>
			<?php endforeach; ?>	
		</div>
	
		<div class="btn-group">
			<?php if (!empty($buttons['add'])) : ?>
				<a class="btn btn-mini button btn-success group-add group-add-<?php echo $unique_subform_id; ?>" aria-label="<?php echo JText::_('JGLOBAL_FIELD_ADD'); ?>">
					<span class="fa fa-plus" aria-hidden="true"></span>
				</a>
			<?php endif; ?>
			<?php if (!empty($buttons['remove'])) : ?>
				<a class="btn btn-mini button btn-danger group-remove group-remove-<?php echo $unique_subform_id; ?>" aria-label="<?php echo JText::_('JGLOBAL_FIELD_REMOVE'); ?>">
					<span class="fa fa-minus" aria-hidden="true"></span>
				</a>
			<?php endif; ?>
			<?php if (!empty($buttons['move'])) : ?>
				<a class="btn btn-mini button btn-primary group-move group-move-<?php echo $unique_subform_id; ?>" aria-label="<?php echo JText::_('JGLOBAL_FIELD_MOVE'); ?>">
					<span class="fa fa-arrows" aria-hidden="true"></span>
				</a>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>
	<div class="panel row-fluid">
<?php foreach ($form->getFieldsets() as $fieldset) : ?>
<section class="fieldset <?php if (!empty($fieldset->class)){ echo $fieldset->class; } ?> <?php if (!empty($fieldset->label)){ echo $fieldset->label; } ?>" style="display:none;">
	<?php if (!empty($fieldset->label)) : ?>
	<legend><?php echo JText::_($fieldset->label); ?></legend>
	<?php endif; ?>
<?php foreach ($form->getFieldset($fieldset->name) as $field) : ?>
	<?php 
		$rel           = $field->getAttribute('showon')? ' data-showon=\'' . json_encode(JFormHelper::parseShowOnConditions($field->getAttribute('showon'), $field->formControl, $field->group)) . '\'':'';
 		$showonEnabled = $field->getAttribute('showon')?true:false;
		 ?>
	<?php echo $this->sublayout(
				$sublayout,
				array(
					'options' => array(
						'class' => $field->class,
						'labelclass' => $field->labelclass,
						'rel' => $rel,
						'hiddenLabel' => $field->type==='Hidden',
						'showonEnabled' => $field->getAttribute('showon')
 					),
					'label' => $field->label,
					'input' => $field->input
				)
			); 
	?>
<?php endforeach; ?>
</section>
<?php endforeach; ?>
	</div>
</div>
