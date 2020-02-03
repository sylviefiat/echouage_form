<?php
/**
 * @version     0.0.0
 * @package     com_stranding_forms
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Sylvie Fiat <sylvie.fiat@ird.fr>
 */
// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_stranding_forms/assets/css/stranding_forms.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function() {
		/*
		document.getElementById("jform_counting_method_timed_swim_chbx").checked = document.getElementById("jform_counting_method_timed_swim").value.length>0?1:0;
		document.getElementById("jform_counting_method_distance_swim_chbx").checked = document.getElementById("jform_counting_method_distance_swim").value.length>0?1:0;
		document.getElementById("jform_counting_method_other_chbx").checked = document.getElementById("jform_counting_method_other").value.length>0?1:0;

		enable_timed_swim(document.getElementById("jform_counting_method_timed_swim").value.length>0?true:false);
		enable_distance_swim(document.getElementById("jform_counting_method_distance_swim").value.length>0?true:false);
		enable_other(document.getElementById("jform_counting_method_other").value.length>0?true:false);*/
	});

	/*function enable_timed_swim(status) {
		if(!status){
			document.getElementById("jform_counting_method_timed_swim").value = "";
			document.getElementById("jform_counting_method_timed_swim").setAttribute('readonly','readonly');
		} else {
			document.getElementById("jform_counting_method_timed_swim").removeAttribute('readonly');
		}
	}

	function enable_distance_swim(status) {
		if(!status){
			document.getElementById("jform_counting_method_distance_swim").value = "";
			document.getElementById("jform_counting_method_distance_swim").setAttribute('readonly','readonly');
		} else {
			document.getElementById("jform_counting_method_distance_swim").removeAttribute('readonly');
		}
	}

	function enable_other(status) {
		if(!status){
			document.getElementById("jform_counting_method_other").value = "";
			document.getElementById("jform_counting_method_other").setAttribute('readonly','readonly');
		} else {
			document.getElementById("jform_counting_method_other").removeAttribute('readonly');
		}
	}*/

	Joomla.submitbutton = function(task)
	{
		if (task == 'stranding_admin.cancel') {
			Joomla.submitform(task, document.getElementById('stranding_admin-form'));
		}
		else {

			if (task != 'stranding_admin.cancel' && document.formvalidator.isValid(document.id('stranding_admin-form'))) {

				Joomla.submitform(task, document.getElementById('stranding_admin-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_stranding_forms&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="stranding_admin-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_STRANDING_FORMS_TITLE_STRANDING_ADMIN', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
					</div>
					<!--References stranding_id-->
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('references'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('references'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('stranding_id'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('stranding_id'); ?></div>
					</diV>
					<!--Observer contacts-->
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('observer_name'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observer_name'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('observer_address'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observer_address'); ?></div>
					</div>

					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('observer_tel'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observer_tel'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('observer_email'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observer_email'); ?></div>
					</div>
					<!--Informant contacts-->
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('informant_name'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('informant_name'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('informant_address'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('informant_address'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('informant_tel'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('informant_tel'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('informant_email'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('informant_email'); ?></div>
					</div>
					<!--Date-->
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('observation_datetime'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observation_datetime'); ?></div>
					</div>
					<!--Localisation-->
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('observation_localisation'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observation_localisation'); ?></div>
					</div>
					<!--Location-->
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('observation_location'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observation_location'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('observation_region'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observation_region'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('observation_country'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observation_country'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('observation_country_code'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observation_country_code'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('observation_latitude'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observation_latitude'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('observation_longitude'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observation_longitude'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('observation_location'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observation_location'); ?></div>
					</div>
					<!--Number-->
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('observation_number'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observation_number'); ?></div>
					</div>
					<!--Species-->
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('observation_species'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observation_species'); ?></div>
					</div>
					<!--Identification species-->
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('observation_species_identification'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observation_species_identification'); ?></div>
					</div>
					<!--Sex-->
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('observation_sex'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observation_sex'); ?></div>
					</div>
					<!--Size-->
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('observation_size'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observation_size'); ?></div>
					</div>
					<!--Alive-->
					<div class="btn-group">
						<div class="control-label"><?php echo $this->form->getLabel('observation_alive'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observation_alive'); ?></div>
					</div>
					<!--Release date-->
					<div class="btn-group">
						<div class="control-label"><?php echo $this->form->getLabel('observation_datetime_release'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observation_datetime_release'); ?></div>
					</div>
					<!--Death-->
					<div class="btn-group">
						<div class="control-label"><?php echo $this->form->getLabel('observation_death'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observation_death'); ?></div>
					</div>
					<!--Death date-->
					<div class="btn-group">
						<div class="control-label"><?php echo $this->form->getLabel('observation_datetime_death'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observation_datetime_death'); ?></div>
					</div>
					<!--Abnormalities-->
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('observation_abnormalities'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observation_abnormalities'); ?></div>
					</div>
					<!--Capture traces-->
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('observation_capture_traces'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('observation_capture_traces'); ?></div>
					</div>
					<!--Catch indices-->
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('catch_indices'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('catch_indices'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('remarks'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('remarks'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('admin_validation'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('admin_validation'); ?></div>
					</div>

	</fieldset>
</div>
</div>
<?php echo JHtml::_('bootstrap.endTab'); ?>



<?php echo JHtml::_('bootstrap.endTabSet'); ?>

<input type="hidden" name="task" value="" />
<?php echo JHtml::_('form.token'); ?>

</div>
</form>
