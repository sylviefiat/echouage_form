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
$animal =  $group;
?>


<div id="suform-<?php echo $group; ?>"
	class="subform-repeatable-group subform-repeatable-group-<?php echo $unique_subform_id; ?>"
	data-base-name="<?php echo $basegroup; ?>"
	data-group="<?php echo $group; ?>"
>
<script type="text/javascript">
	function displayTab(tabId,id) {
  		event.preventDefault(); 
  		jQuery("#panel-"+id+" section").each(function(index,value){
  			if(tabId!==value.id){
  				jQuery("#panel-"+id+" #"+value.id).hide();
  			} else {
  				jQuery("#panel-"+id+" #"+value.id).show();
  			}
  		})
	}
</script>
	<div class="tab">
		<div>			
			<button onclick="displayTab('','<?php echo $animal; ?>')"><?php echo $animal; ?></button>
			<?php foreach ($form->getFieldsets() as $fieldset) : ?>		
				<?php if (!empty($fieldset->label)) : ?>			
					<button onclick="displayTab('<?php echo $fieldset->label; ?>-<?php echo $group; ?>','<?php echo $group; ?>')"><?php echo JText::_($fieldset->label); ?></button>
				<?php endif; ?>
			<?php endforeach; ?>	
		</div>
		<div>
			<?php if (!empty($buttons)) : ?>
	
				<?php if (!empty($buttons['add'])) : ?>
					<a class="btn btn-mini button btn-success group-add group-add-<?php echo $group; ?>" aria-label="<?php echo JText::_('JGLOBAL_FIELD_ADD'); ?>">
						<span class="fa fa-plus" aria-hidden="true"></span>
					</a>
				<?php endif; ?>
				<?php if (!empty($buttons['remove'])) : ?>
					<a class="btn btn-mini button btn-danger group-remove group-remove-<?php echo $group; ?>" aria-label="<?php echo JText::_('JGLOBAL_FIELD_REMOVE'); ?>">
						<span class="fa fa-minus" aria-hidden="true"></span>
					</a>
				<?php endif; ?>
				<?php if (!empty($buttons['move'])) : ?>
					<a class="btn btn-mini button btn-primary group-move group-move-<?php echo $group; ?>" aria-label="<?php echo JText::_('JGLOBAL_FIELD_MOVE'); ?>">
						<span class="fa fa-arrows-alt" aria-hidden="true"></span>
					</a>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
	<div id="panel-<?php echo $group; ?>" class="row-fluid">	
		<?php foreach ($form->getFieldsets() as $fieldset) : ?>
			<section id="<?php echo JText::_($fieldset->label); ?>-<?php echo $group; ?>" class="<?php if (!empty($fieldset->class)){ echo $fieldset->class; } ?> hidden">
				<?php if (!empty($fieldset->label)) : ?>
					<legend><?php echo JText::_($fieldset->label); ?></legend>
				<?php endif; ?>
				<?php foreach ($form->getFieldset($fieldset->name) as $field) : ?>
					<?php echo $field->renderField(); ?>
				<?php endforeach; ?>
			</section>
		<?php endforeach; ?>
	</div>
</div>
