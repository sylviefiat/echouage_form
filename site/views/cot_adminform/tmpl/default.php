<?php
/**
 * @version     2.0.7
 * @package     com_cot_forms
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Sylvie Fiat <sylvie.fiat@ird.fr>
 */
// no direct access
defined('_JEXEC') or die;

JHtml::_('jquery.framework',  true, true);
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_cot_forms', JPATH_ADMINISTRATOR);

$user = JFactory::getUser();
?>

<!-- Styling for making front end forms look OK -->
<!-- This should probably be moved to the template CSS file -->
<style>


#jform_rules-lbl{
  display:none;
}

#access-rules a:hover{
  background:#f5f5f5 url('../images/slider_minus.png') right  top no-repeat;
  color: #444;
}

fieldset.radio label{
  width: 50px !important;
}
</style>
  <div class="cot_admin-edit front-end-edit">
    <?php if (!empty($this->item->id)): ?>
      <h1 class="fa fa-map-marker fa-3x"> <?php echo JText::_('COM_COT_FORMS_EDIT_ITEM_TITLE'); ?> <?php echo $this->item->id; ?></h1>
      <?php else: ?>
        <h1 class="fa fa-map-marker fa-3x"> <?php echo JText::_('COM_COT_FORMS_COT_ADMIN_ADD_ITEM_TITLE'); ?></h1>
        <p class="lead" style="1.3em"> <?php echo JText::_('COM_COT_FORMS_COT_ADMIN_ADD_ITEM_DESC'); ?></p>
      <?php endif; ?>

      <form id="form-cot_admin" action="<?php echo JRoute::_('index.php?option=com_cot_forms&task=cot_admin.save'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
      <!--Contacts-->
        <div class="col-xs-12"><?php echo JText::_('COM_COT_FORMS_EDIT_ITEM_ROW1'); ?></div>
        <!--Observer contacts-->
        <div class="row">
         <div class="col-xs-12"><?php echo $this->form->getLabel('observer_name'); ?></div>
         <div class="col-lg-4 col-md-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon exergue"><span class="fa fa-user"></span></span>
            <?php echo $this->form->getInput('observer_name'); ?>
            <span style="display:none;" ><?php echo $this->form->getInput('id'); ?></span>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon exergue"><span class="fa fa-home"></span></span>
            <?php echo $this->form->getInput('observer_address'); ?>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-phone"></span></span>
            <?php echo $this->form->getInput('observer_tel'); ?>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon exergue"><span class="fa fa-envelope"></span></span>
            <?php echo $this->form->getInput('observer_email'); ?>
          </div>
        </div>
      </div>
      <!--Informant contacts-->
      <div class="row">
        <div class="col-xs-12"><?php echo $this->form->getLabel('informant_name'); ?></div>
        <div class="col-lg-4 col-md-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon exergue"><span class="fa fa-user"></span></span>
            <?php echo $this->form->getInput('informant_name'); ?>
            <!--<span style="display:none;" ><?php //echo $this->form->getInput('id'); ?></span>-->
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon exergue"><span class="fa fa-home"></span></span>
            <?php echo $this->form->getInput('informant_address'); ?>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-phone"></span></span>
            <?php echo $this->form->getInput('informant_tel'); ?>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon exergue"><span class="fa fa-envelope"></span></span>
            <?php echo $this->form->getInput('informant_email'); ?>
          </div>
        </div>
      </div>

      <!--Circonstance de l'échouage-->
      <div class="col-xs-12"><?php echo JText::_('COM_COT_FORMS_EDIT_ITEM_ROW2'); ?></div>
        <!--Date-->
        <div class="row">
         <div class="col-xs-12"><?php echo $this->form->getLabel('observation_datetime'); ?></div>
         <div class="col-lg-4 col-md-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon exergue"><span class="fa fa-calendar"></span></span>
            <?php echo $this->form->getInput('observation_datetime'); ?>
          </div>
        </div>
        <div class="col-lg-8 col-md-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-location-arrow"></span></span>
            <?php echo $this->form->getInput('observation_location'); ?>
          </div>
        </div>
      </div>
      <div class="row">
       <div class="col-xs-12"><?php echo $this->form->getLabel('observation_localisation'); ?></div>
       <div class="col-md-12 col-md-12 col-xs-12">
        <div class="input-group">
          <span class="input-group-addon exergue"><span class="fa fa-map-marker"></span></span>
          <?php echo $this->form->getInput('observation_localisation'); ?>
        </div>
      </div>
    </div>
    <div class="row">
     <div class="col-md-6 col-md-6 col-xs-12">
      <div class="input-group">
        <span class="input-group-addon"></span>
        <?php echo $this->form->getInput('observation_region'); ?>
      </div>
    </div>
    <div class="col-md-6 col-md-6 col-xs-12">
      <div class="input-group">
        <span class="input-group-addon"></span>
        <?php echo $this->form->getInput('observation_latitude'); ?>
      </div>
    </div>
  </div>
  <div class="row">
   <div class="col-md-6 col-md-6 col-xs-12">
    <div class="input-group">
      <span class="input-group-addon"></span>
      <?php echo $this->form->getInput('observation_country'); ?>
    </div>
  </div>
  <div class="col-md-6 col-md-6 col-xs-12">
    <div class="input-group">
      <span class="input-group-addon"></span>
      <?php echo $this->form->getInput('observation_longitude'); ?>
    </div>
  </div>
</div>

<div class="row">
  <!--Stranding type-->
  <div class="col-lg-6 col-md-6 col-xs-12">
    <div class="form-group">
      <?php echo $this->form->getLabel('observation_stranding_type'); ?>
      <div class="col-xs-offset-2 col-xs-10">
        <div class="radio">
          <label><?php echo $this->form->getInput('observation_stranding_type'); ?></label>
        </div>
      </div>
    </div>
  </div>
  <!--Number-->
  <div class="col-lg-6 col-md-6 col-xs-12">
    <div class="input-group">
      <span class="input-group-addon"><span class="fa fa-tachometer"></span></span>
      <?php echo $this->form->getInput('observation_number'); ?>
    </div>
  </div>
</div>

<!--Indentification-->
<div class="col-xs-12"><?php echo JText::_('COM_COT_FORMS_EDIT_ITEM_ROW3'); ?></div>
<!--Spaces-->
<div class="row">
  <div class="col-lg-6 col-md-6 col-xs-12">
    <div class="input-group">
      <span class="input-group-addon"><span class="fa fa-eye-open"></span></span>
      <?php echo $this->form->getInput('observation_spaces'); ?>
    </div>
  </div>
  <!--Spaces identification-->
  <div class="col-lg-6 col-md-6 col-xs-12">
    <div class="form-group">
      <?php echo $this->form->getLabel('observation_spaces_identification'); ?>
      <div class="col-xs-offset-2 col-xs-10">
        <div class="radio">
          <label><?php echo $this->form->getInput('observation_spaces_identification'); ?></label>
        </div>
      </div>
    </div>
  </div>
  <!--Sex-->
  <div class="col-lg-6 col-md-6 col-xs-12">
    <div class="form-group">
      <?php echo $this->form->getLabel('observation_sex'); ?>
      <div class="col-xs-offset-2 col-xs-10">
        <div class="radio">
          <label><?php echo $this->form->getInput('observation_sex'); ?></label>
        </div>
      </div>
    </div>
    <!--Color-->
  </div>
  <div class="col-xs-12"><?php echo $this->form->getLabel('observation_color'); ?></div>
  <div class="col-lg-6 col-md-6 col-xs-12">
    <div class="input-group">
      <span class="input-group-addon"><span class="fa fa-resize-horizontal"></span></span>
      <?php echo $this->form->getInput('observation_color'); ?>
    </div>
  </div>
  <!--Encoche médiane à la caudale-->
  <div class="row">
    <div class="col-lg-6 col-md-6 col-xs-12">
      <div class="form-group">
        <?php echo $this->form->getLabel('observation_caudal'); ?>
        <div class="col-xs-offset-2 col-xs-10">
          <div class="radio">
            <label><?php echo $this->form->getInput('observation_caudal'); ?></label>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!--Size-->
  <div class="col-xs-12"><?php echo $this->form->getLabel('observation_size'); ?></div>
  <div class="col-lg-6 col-md-6 col-xs-12">
    <div class="input-group">
      <span class="input-group-addon"><span class="fa fa-resize-horizontal"></span></span>
      <?php echo $this->form->getInput('observation_size'); ?>
    </div>
  </div>
</div>

<!--Animal-->
<div class="col-xs-12"><?php echo JText::_('COM_COT_FORMS_EDIT_ITEM_ROW4'); ?></div>
<div class="row">
  <div class="row">
    <!--Abnormalities-->
    <div class="col-lg-6 col-md-6 col-xs-12">
      <div class="form-group">
        <?php echo $this->form->getLabel('observation_abnormalities'); ?>
        <div class="col-xs-offset-2 col-xs-10">
          <div class="radio">
            <label><?php echo $this->form->getInput('observation_abnormalities'); ?></label>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <!--Capture traces-->
    <div class="col-lg-6 col-md-6 col-xs-12">
      <div class="form-group">
        <?php echo $this->form->getLabel('observation_capture_traces'); ?>
        <div class="col-xs-offset-2 col-xs-10">
          <div class="radio">
            <label><?php echo $this->form->getInput('observation_capture_traces'); ?></label>
          </div>
        </div>
      </div>
    </div>
    <!--Catch indices-->
    <div class="col-lg-8 col-md-6 col-xs-12">
      <div class="input-group">
        <span class="input-group-addon"><span class="fa fa-comment "></span></span>
        <?php echo $this->form->getInput('catch_indices'); ?>
      </div>
    </div>
  </div>
  <!--Dead animal-->
  <div class="row">
    <div class="col-lg-6 col-md-6 col-xs-12">
      <div class="form-group">
        <?php echo $this->form->getLabel('observation_death'); ?>
        <div class="col-xs-offset-3 col-xs-10">
          <div class="radio">
            <label><?php echo $this->form->getInput('observation_death'); ?></label>
          </div>
        </div>
      </div>
    </div>
    <!--Death date-->
    <div class="col-xs-12"><?php echo $this->form->getLabel('observation_datetime_death'); ?></div>
    <div class="col-lg-4 col-md-6 col-xs-12">
      <div class="input-group">
        <span class="input-group-addon exergue"><span class="fa fa-calendar"></span></span>
        <?php echo $this->form->getInput('observation_datetime_death'); ?>
      </div>
    </div>
    <!--State decomposition-->
    <div class="col-lg-6 col-md-6 col-xs-12">
      <div class="form-group">
        <?php echo $this->form->getLabel('observation_state_decomposition'); ?>
        <div class="col-xs-offset-2 col-xs-10">
          <div class="radio">
            <label><?php echo $this->form->getInput('observation_state_decomposition'); ?></label>
          </div>
        </div>
      </div>
    </div>
    <!--Levies protocol-->
    <div class="col-lg-6 col-md-6 col-xs-12">
      <div class="form-group">
        <?php echo $this->form->getLabel('levies_protocole'); ?>
        <div class="col-xs-offset-2 col-xs-10">
          <div class="radio">
            <label><?php echo $this->form->getInput('levies_protocole'); ?></label>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--Living animal-->
  <div class="row">
    <div class="col-lg-6 col-md-6 col-xs-12">
      <div class="form-group">
        <?php echo $this->form->getLabel('observation_alive'); ?>
        <div class="col-xs-offset-2 col-xs-10">
          <div class="checkbox">
            <label><?php echo $this->form->getInput('observation_alive'); ?></label>
          </div>
        </div>
      </div>
    </div>
    <!--Release date-->
    <div class="col-xs-12"><?php echo $this->form->getLabel('observation_datetime_release'); ?></div>
    <div class="col-lg-4 col-md-6 col-xs-12">
      <div class="input-group">
        <span class="input-group-addon exergue"><span class="fa fa-calendar"></span></span>
        <?php echo $this->form->getInput('observation_datetime_release'); ?>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 col-md-6 col-xs-12">
      <div class="form-group">
        <?php echo $this->form->getLabel('observation_tissue_removal'); ?>
        <div class="col-xs-offset-2 col-xs-10">
          <div class="checkbox">
            <label><?php echo $this->form->getInput('observation_tissue_removal'); ?></label>
          </div>
        </div>
      </div>
    </div>
</div>


<!--
			<div class="row">

			    <div class="col-lg-6 col-md-6 col-xs-12">
				<div class="form-group">
				    <?php /*echo $this->form->getLabel('observation_method'); ?>
				    <div class="col-xs-offset-2 col-xs-10">
					<div class="checkbox">
					    <label><?php echo $this->form->getInput('observation_method'); ?></label>
					</div>
				    </div>
				</div>
			    </div>
			    <div class="col-lg-6 col-md-6 col-xs-12">
				<div class="form-group">
				    <?php echo $this->form->getLabel('depth_range'); ?>
				    <div class="col-xs-offset-2 col-xs-10">
					<div class="checkbox">
					    <label><?php echo $this->form->getInput('depth_range'); ?></label>
					</div>
				    </div>
				</div>
			    </div>
			</div>

			<div class="row">
			    <div class="col-xs-12">
				<label id="jform_counting_method_label" class="hasTooltip" title="<?php echo JText::_('OBSERVATION_COUNTING_METHOD_DESC');?>">
                                    <?php echo JText::_('OBSERVATION_COUNTING_METHOD');?>
                                </label>
			    </div>
			    <div class="col-lg-4 col-md-6 col-xs-12">
			        <div class="input-group">
			           <span class="input-group-addon">
				        <input id="jform_counting_method_timed_swim_chbx" class="control-label" type="checkbox" name="counting_method_timed_swim" onclick="enable_timed_swim(this.checked)">
			           </span>
    			           <?php echo $this->form->getInput('counting_method_timed_swim'); ?>
			        </div>
			    </div>
			    <div class="col-lg-4 col-md-6 col-xs-12">
			        <div class="input-group">
			           <span class="input-group-addon">
				        <input id="jform_counting_method_distance_swim_chbx" class="control-label" type="checkbox" name="counting_method_distance_swim" onclick="enable_distance_swim(this.checked)" >
			           </span>
    			           <?php echo $this->form->getInput('counting_method_distance_swim'); ?>
			        </div>
			    </div>
			    <div class="col-lg-4 col-md-6 col-xs-12">
			        <div class="input-group">
			           <span class="input-group-addon">
				        <input id="jform_counting_method_other_chbx" class="control-label" type="checkbox" name="counting_method_other" onclick="enable_other(this.checked)" >
			           </span>
    			           <?php echo $this->form->getInput('counting_method_other'); */?>
			        </div>
			    </div>
			</div>
    -->
    <div class="row">
     <div class="col-xs-12"><?php echo $this->form->getLabel('remarks'); ?></div>
     <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="input-group">
        <span class="input-group-addon"><span class="fa fa-comment "></span></span>
        <?php echo $this->form->getInput('remarks'); ?>
      </div>
    </div>
  </div>

  <?php if($user->id != 0){ ?>
   <div class="row">
    <div class="col-xs-12"><?php echo $this->form->getLabel('admin_validation'); ?></div>
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="input-group">
       <span class="input-group-addon"><span class="fa fa-check "></span></span>
       <?php echo $this->form->getInput('admin_validation'); ?>
     </div>
   </div>
 </div>
<?php } ?>
<div class="row">
  <div class="col-xs-12"><?php echo $this->form->getLabel('captcha'); ?></div>
  <div class="col-lg-12 col-md-12 col-xs-12">
    <div class="input-group">
      <?php echo $this->form->getInput('captcha'); ?>
    </div>
  </div>
</div>


<button type="submit" class="validate"><span><?php echo JText::_('JSUBMIT'); ?></span></button>
<?php echo JText::_('OR'); ?>
<a href="<?php echo JRoute::_('index.php?option=com_cot_forms&task=cot_adminform.cancel'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>

<input type="hidden" name="option" value="com_cot_forms" />
<input type="hidden" name="task" value="cot_adminform.save" />
<?php echo JHtml::_('form.token'); ?>
</div>
</form>
</div>
