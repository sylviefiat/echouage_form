<?php
/**
 * @version     1.0.0
 * @package     com_stranding_forms
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
$lang->load('com_stranding_forms', JPATH_ADMINISTRATOR);

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

.radio {
  display: inline-block;
}

</style>

<script type="text/javascript">

 function getScript(url,success) {
  var script = document.createElement('script');
  script.src = url;
  var head = document.getElementsByTagName('head')[0],
  done = false;
    // Attach handlers for all browsers
    script.onload = script.onreadystatechange = function() {
      if (!done && (!this.readyState
        || this.readyState == 'loaded'
        || this.readyState == 'complete')) {
        done = true;
      success();
      script.onload = script.onreadystatechange = null;
      head.removeChild(script);
    }
  };
  head.appendChild(script);
}

getScript('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js',function() {
  js = jQuery.noConflict();
  js(document).ready(function(){
    js('#form-stranding_admin').submit(function(event){

    }); 
    /*document.getElementById("jform_counting_method_timed_swim_chbx").checked = document.getElementById("jform_counting_method_timed_swim").value.length>0?1:0;

    enable_timed_swim(document.getElementById("jform_counting_method_timed_swim").value.length>0?true:false);*/


  });
});

/*function enable_timed_swim(status) {
  if(!status){
    document.getElementById("jform_counting_method_timed_swim").value = "";
    document.getElementById("jform_counting_method_timed_swim").setAttribute('readonly','readonly');
  } else {
    document.getElementById("jform_counting_method_timed_swim").removeAttribute('readonly');
  }
}*/

function toggleContainer(name)
    {
      var e = document.getElementById(name);// MooTools might not be available ;)
      e.style.display = e.style.display === 'none' ? 'block' : 'none';
    }


function choixUser(btn,champ1,champ2, champ3) 
{ 
  if (btn.id == "dead"){ 
    display(champ1,true); 
    display(champ2,false); 
    display(champ3,false); 
  } 
  else if (btn.id == "alive"){ 
    display(champ2,true); 
    display(champ1,false);
    display(champ3,false);  
  }
  if(btn.id == "tooth"){
    display(champ1,true); 
    display(champ2,false);
    display(champ3,false);
  }
  else if(btn.id == "baleen"){
    display(champ2,true); 
    display(champ1,false);
    display(champ3,false);  
  }
  else if (btn.id == "defenses") {
    display(champ3,true);
    display(champ1,false);
    display(champ2,false);
  }
} 

function display(div, affiche) { 
  if (affiche){ 
    document.getElementById(div).style.display="block"; 
  } 
  else { 
    document.getElementById(div).style.display="none"; 
  } 
}

var cloneId = 0;

$(document).ready(function()
{
    $("#num").click(function()
    {
        var clone = $(".form-group:first").clone(true);
        clone.find("input").prop("name", "optionsRadios" + cloneId);
        cloneId++;
        clone.appendTo(".row");
    });
});


function duplic(element)
{
  clone1 = document.getElementById("spaces").cloneNode(true);
  clone1.id="spaces1";
  document.getElementById(element).appendChild (clone1);
  clone2 = document.getElementById("spaces_identification").cloneNode(true);
  clone2.id = "spaces_identification1";
  document.getElementById(element).appendChild (clone2);
  clone3 = document.getElementById("color").cloneNode(true);
  clone3.id="color1";
  document.getElementById(element).appendChild (clone3);
  clone4 = document.getElementById("caudale").cloneNode(true);
  clone4.id="caudale1";
  document.getElementById(element).appendChild (clone4);
  clone5 = document.getElementById("beak").cloneNode(true);
  clone5.id="beak1";
  document.getElementById(element).appendChild (clone5);
  clone6 = document.getElementById("furrows").cloneNode(true);
  clone6.id="furrows1";
  document.getElementById(element).appendChild (clone6);
  clone7 = document.getElementById("other_caracts").cloneNode(true);
  clone7.id="other_caracts1";
  clone7_1 = document.getElementById("tooth").cloneNode(true);
  clone7_1.id = "tooth1";
  document.getElementById(clone7).appendChild(clone7_1);
  clone7_2 = document.getElementById("baleen").cloneNode(true);
  clone7_2.id = "baleen1";
  document.getElementById(clone7).appendChild(clone7_2);
  clone7_3 = document.getElementById("defenses").cloneNode(true);
  clone7_3.id = "defenses1";
  document.getElementById(clone7).appendChild(clone7_3);
  document.getElementById(element).appendChild (clone7);
  clone8 = document.getElementById("levies_photo").cloneNode(true);
  clone8.id="levies_photo1";
  document.getElementById(element).appendChild (clone8);
  clone9 = document.getElementById("tooth_field").cloneNode(true);
  clone9.id="tooth_field1";
  document.getElementById(element).appendChild (clone9);
  clone10 = document.getElementById("baleen_field").cloneNode(true);
  clone10.id = "baleen_field1";
  document.getElementById(element).appendChild (clone10);
  clone11 = document.getElementById("defences_field").cloneNode(true);
  clone11.id = "defences_field1";
  document.getElementById(element).appendChild (clone11);
}

/*Fonction ajout et suppression de champs version 2*/

function addDiv(name, field){
    var div = document.createElement("div");
    div.name = name;
    field.appendChild(div);
}
function addField(name, field) {
  var div = document.getElementById('identification');
    addDiv(name, field);
}

function supr_field(i) 
{ 
  var Parent; 
  var Obj = document.getElementById ( 'input_'+i) ; 

  if( Obj)      
    Parent = Obj.parentNode;      
  if( Parent) 
   Obj.removeChild(Obj.childNodes[0]); 

} 

function transpo(i) { 
  document.getElementById('in_'+i).value = document.getElementById('out_'+(i-1)).value; 
}

</script>

<div class="stranding_admin-edit front-end-edit">
  <?php if (!empty($this->item->id)): ?>
    <h1 class="fa fa-map-marker fa-3x"> <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_TITLE'); ?> <?php echo $this->item->id; ?></h1>
    <?php else: ?>
      <h1 class="fa fa-map-marker fa-3x"> <?php echo JText::_('COM_STRANDING_FORMS_STRANDING_ADMIN_ADD_ITEM_TITLE'); ?></h1>
      <p class="lead" style="1.3em"> <?php echo JText::_('COM_STRANDING_FORMS_STRANDING_ADMIN_ADD_ITEM_DESC'); ?></p>
    <?php endif; ?>

    <form id="form-stranding_admin" action="<?php echo JRoute::_('index.php?option=com_stranding_forms&task=stranding_admin.save'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
      <!--Contacts-->
      <div class="col-xs-12"><h4 class="fa fa-user fa-2x"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW1'); ?></h4></div>
      <!--Observer contacts-->
      <div class="row">
       <div class="col-xs-12"><?php echo $this->form->getLabel('observer_name'); ?></div>
       <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="input-group">
          <span class="input-group-addon exergue"><span class="fa fa-user"></span></span>
          <?php echo $this->form->getInput('observer_name'); ?>
          <span style="display:none;" ><?php echo $this->form->getInput('id'); ?></span>
          <span style="display:none;" ><?php echo $this->form->getInput('id_location'); ?></span>
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
    <label><?php echo JText::_('INFORMANT_CONTACT');?></label>
    <button type="button" name="informantBtn" class="btn btn-primary" value="informateur" onclick="toggleContainer('informant_field')"><?php echo $this->form->getLabel('informant_name'); ?></button>
    <!--Informant contacts-->
    <div class="row" id="informant_field" style="display: none;">
      <div class="col-xs-12"><?php echo $this->form->getLabel('informant_name'); ?></div>
      <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="input-group">
          <span class="input-group-addon exergue"><span class="fa fa-user"></span></span>
          <?php echo $this->form->getInput('informant_name'); ?>
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
    <div class="col-xs-12"><h4 class="fa fa-flag fa-2x"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW2'); ?></h4></div>
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
  <div class="col-xs-12"><?php echo $this->form->getLabel('observation_number'); ?></div>
  <div class="col-lg-6 col-md-6 col-xs-12">
    <div class="input-group">
      <span class="input-group-addon"><span class="fa fa-tachometer"></span></span>
      <?php echo $this->form->getInput('observation_number'); ?>
    </div>
  </div>
</div>
<!--Indentification-->
<div class="col-xs-12"><h4 class="fa fa-eye fa-2x"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW3'); ?></h4></div>

<button type="button" onclick="duplic('identification')" >+</button>
<!--<button type="button" onclick="supr_field('spaces')" >-</button>-->
<div class="row" id="identification">
  <!--Spaces-->
  <div class="col-xs-12"><?php echo $this->form->getLabel('observation_spaces'); ?></div>
  <div class="col-lg-6 col-md-6 col-xs-12" id="spaces" name="espece[]">
    <div class="input-group">
      <span class="input-group-addon"><span class="fa fa-eye-open"></span>
      <!--<input id="field" type="text" class="control-label" name="espece" >-->
    </span>
    <?php echo $this->form->getInput('observation_spaces'); ?>
  </div>
</div>
<!--Spaces identification-->
<div class="col-lg-6 col-md-6 col-xs-12" id="spaces_identification" name="id_espece[]">
  <div class="form-group">
    <?php echo $this->form->getLabel('observation_spaces_identification'); ?>
    <div class="col-xs-offset-2 col-xs-10">
      <div class="radio-list">
        <label><?php echo $this->form->getInput('observation_spaces_identification'); ?></label>
      </div>
    </div>
  </div>
</div>
<!--Color-->
<div class="col-xs-12"><?php echo $this->form->getLabel('observation_color'); ?></div>
<div class="col-lg-6 col-md-6 col-xs-12" id="color">
  <div class="input-group">
    <span class="input-group-addon"><span class="fa fa-resize-horizontal"></span></span>
    <?php echo $this->form->getInput('observation_color'); ?>
  </div>
</div>
<!--Encoche médiane à la caudale-->
  <div class="col-lg-6 col-md-6 col-xs-12" id="caudale">
    <div class="form-group">
      <?php echo $this->form->getLabel('observation_caudal'); ?>
      <div class="col-xs-offset-2 col-xs-10">
        <div class="radio">
          <label><?php echo $this->form->getInput('observation_caudal'); ?></label>
        </div>
      </div>
    </div>
  </div>

  <!--Beak-->
  <div class="col-lg-6 col-md-6 col-xs-12" id="beak">
    <div class="form-group">
      <?php //echo $this->form->getLabel('observation_beak'); ?>
      <div class="col-xs-offset-2 col-xs-10">
        <div class="checkbox">
          <label><?php echo $this->form->getInput('observation_beak'); ?></label>
        </div>
      </div>
    </div>
  </div>
  <!--Furrows-->
  <div class="col-lg-6 col-md-6 col-xs-12" id="furrows">
    <div class="form-group">
      <?php //echo $this->form->getLabel('observation_furrows'); ?>
      <div class="col-xs-offset-2 col-xs-10">
        <div class="checkbox">
          <label><?php echo $this->form->getInput('observation_furrows'); ?></label>
        </div>
      </div>
    </div>
  </div>

<!--Other caracteristques-->
<div class="row" id="other_caracts">
   <div class="col-xs-12">
    <label class="hasTooltip" title="<?php echo JText::_('OBSERVATION_IDENTIFICATION_CARACT_DESC');?>">
      <?php echo JText::_('OBSERVATION_IDENTIFICATION_CARACT');?>
    </label>
  </div>
  <div class="col-lg-12 col-md-12 col-xs-12 form-group">
    <div class="radio-list">
       <div class="custom-control custom-radio custom-control-inline">
        <input id ="tooth" type="radio" name="mammalOther" class="custom-control-input" value="dents" onclick="choixUser(this,'tooth_field','baleen_field', 'defences_field')">
        <label class="custom-control-label" for="tooth"><?php echo JText::_("OBSERVATION_TOOTH")?></label>
      </div>
      <div class="custom-control custom-radio custom-control-inline">
        <input id ="baleen" type="radio" name="mammalOther" class="custom-control-input" value="fanons" onclick="choixUser(this,'tooth_field','baleen_field', 'defences_field')">
        <label class="custom-control-label" for="baleen"><?php echo JText::_("OBSERVATION_BALEEN_LBL")?></label>
      </div>
      <div class="custom-control custom-radio custom-control-inline">
        <input id ="defenses" type="radio" name="mammalOther" class="custom-control-input" value="defense" onclick="choixUser(this,'tooth_field','baleen_field','defences_field')">
        <label class="custom-control-label" for="defenses"><?php echo JText::_("OBSERVATION_DEFENSES_LBL")?></label>
      </div>
    </div>
  </div>
</div>
<!--Tooth-->
<div class="row tooth_f" id="tooth_field" style="display: none;">
  <div class="col-xs-12">
    <label id="" class="hasTooltip" title="<?php echo JText::_('OBSERVATION_TOOTH_NUMBER_DESC');?>">
      <?php echo JText::_('OBSERVATION_TOOTH_NUMBER_LBL');?>
    </label>
  </div>
  <div class="col-lg-3 col-md-3 col-xs-6">
    <div class="form-group">
      <?php echo $this->form->getLabel('nb_teeth_upper_right'); ?>
      <div class="col-xs-offset-3 col-xs-10">
        <div class="input-group">
          <?php echo $this->form->getInput('nb_teeth_upper_right'); ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-3 col-xs-6">
    <div class="form-group">
      <?php echo $this->form->getLabel('nb_teeth_upper_left'); ?>
      <div class="col-xs-offset-3 col-xs-10">
        <div class="input-group">
          <?php echo $this->form->getInput('nb_teeth_upper_left'); ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-3 col-xs-6">
    <div class="form-group">
      <?php echo $this->form->getLabel('nb_teeth_lower_right'); ?>
      <div class="col-xs-offset-3 col-xs-10">
        <div class="input-group">
          <?php echo $this->form->getInput('nb_teeth_lower_right'); ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-3 col-xs-6">
    <div class="form-group">
      <?php echo $this->form->getLabel('nb_teeth_lower_left'); ?>
      <div class="col-xs-offset-3 col-xs-10">
        <div class="input-group">
          <?php echo $this->form->getInput('nb_teeth_lower_left'); ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-3 col-xs-6">
    <div class="form-group">
      <?php echo $this->form->getLabel('observation_teeth_base_diametre'); ?>
      <div class="col-xs-offset-3 col-xs-10">
        <div class="input-group">
          <?php echo $this->form->getInput('observation_teeth_base_diametre'); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Baleen-->
<div class="row baleen_f" id="baleen_field" style="display: none;">
  <div class="col-xs-12">
    <label id="" class="hasTooltip" title="<?php echo JText::_('OBSERVATION_BALEEN_DESC');?>">
      <?php echo JText::_('OBSERVATION_BALEEN_LBL');?>
    </label>
  </div>
  <div class="col-lg-3 col-md-3 col-xs-6">
    <div class="form-group">
      <?php echo $this->form->getLabel('observation_baleen_color'); ?>
      <div class="col-xs-offset-3 col-xs-10">
        <div class="input-group">
          <?php echo $this->form->getInput('observation_baleen_color'); ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xs-12">
    <label id="" class="hasTooltip" title="<?php echo JText::_('OBSERVATION_BALEEN_MEASURES_DESC');?>">
      <?php echo JText::_('OBSERVATION_BALEEN_MEASURES_LBL');?>
    </label>
  </div>
  <div class="col-lg-3 col-md-3 col-xs-6">
    <div class="form-group">
      <?php echo $this->form->getLabel('observation_baleen_height'); ?>
      <div class="col-xs-offset-3 col-xs-10">
        <div class="input-group">
          <?php echo $this->form->getInput('observation_baleen_height'); ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-3 col-xs-6">
    <div class="form-group">
      <?php echo $this->form->getLabel('observation_baleen_base_height'); ?>
      <div class="col-xs-offset-3 col-xs-10">
        <div class="input-group">
          <?php echo $this->form->getInput('observation_baleen_base_height'); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Defense-->
<div class="row defences_f" id="defences_field" style="display: none;">
  <div class="col-lg-6 col-md-6 col-xs-12">
    <div class="form-group">
      <?php //echo $this->form->getLabel('observation_defenses'); ?>
      <div class="col-xs-offset-2 col-xs-10">
        <div class="checkbox">
          <label><?php echo $this->form->getInput('observation_defenses'); ?></label>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Levies & photos-->
<div class="row" id="levies_photo">
  <div class="col-lg-6 col-md-6 col-xs-12">
    <div class="form-group">
      <?php echo $this->form->getLabel('levies'); ?>
      <div class="col-xs-offset-2 col-xs-10">
        <div class="radio">
          <label><?php echo $this->form->getInput('levies'); ?></label>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-md-6 col-xs-12">
    <div class="form-group">
      <?php echo $this->form->getLabel('photos'); ?>
      <div class="col-xs-offset-2 col-xs-10">
        <div class="radio">
          <label><?php echo $this->form->getInput('photos'); ?></label>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<!--Animal-->
<div class="col-xs-12"><h4 class="fa fa-shield fa-2x"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW4'); ?></h4></div>
<div class="row">
  <div class="row">
    <!--Size-->
    <div class="col-xs-12"><?php echo $this->form->getLabel('observation_size'); ?></div>
    <div class="col-lg-6 col-md-6 col-xs-12">
      <div class="input-group">
        <span class="input-group-addon"><span class="fa fa-resize-horizontal"></span></span>
        <?php echo $this->form->getInput('observation_size'); ?>
      </div>
    </div>
    <!--Size précision-->
    <div class="col-lg-6 col-md-6 col-xs-12">
      <div class="form-group">
        <?php echo $this->form->getLabel('observation_size_precision'); ?>
        <div class="col-xs-offset-2 col-xs-10">
          <div class="radio">
            <label><?php echo $this->form->getInput('observation_size_precision'); ?></label>
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
    </div>
  </div>
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
  <!--State-->
  <div class="row">
    <div class="col-xs-12">
      <label id="jform_state_label" class="hasTooltip" title="<?php echo JText::_('OBSERVATION_STATE_DESC');?>">
        <?php echo JText::_('OBSERVATION_STATE');?>
      </label>
    </div>
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="custom-control custom-radio custom-control-inline">   
        <input id ="dead" type="radio" name="mammalState" class="custom-control-input" value="mort" onclick="choixUser(this,'dead_field','alive_field', '')">
        <label class="custom-control-label" for="dead"><?php echo JText::_("OBSERVATION_STATE_A")?></label>
      </div>
      <?php echo JText::_('OR')?>
      <div class="custom-control custom-radio custom-control-inline">
        <input id ="alive" type="radio" name="mammalState" class="custom-control-input" value="vivant" onclick="choixUser(this,'dead_field','alive_field', '')">
        <label class="custom-control-label" for="alive"><?php echo JText::_("OBSERVATION_STATE_B")?></label>
      </div> 
      </div>
    </div>
    <!--Dead animal-->
    <div class="row" id="dead_field" style="display: none;">
      <div class="col-xs-12">
        <label id="jform_dead_animal_label" class="hasTooltip" title="<?php echo JText::_('OBSERVATION_DEAD_ANIMAL_DESC');?>">
          <?php echo JText::_('OBSERVATION_DEAD_ANIMAL');?>
        </label>
      </div>
      <div class="col-lg-6 col-md-6 col-xs-12">
        <div class="form-group">
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
      <!--Label references-->
      <div class="col-lg-6 col-md-6 col-xs-12">
        <div class="form-group">
          <?php echo $this->form->getLabel('label_references'); ?>
          <div class="col-xs-offset-2 col-xs-10">
            <div class="radio">
              <label><?php echo $this->form->getInput('label_references'); ?></label>
            </div>
          </div>
        </div>
      </div>
      <!--Tissue removal dead-->
      <div class="col-lg-6 col-md-6 col-xs-12">
        <div class="form-group">
          <?php echo $this->form->getLabel('observation_tissue_removal_dead'); ?>
          <div class="col-xs-offset-2 col-xs-10">
            <div class="checkbox">
              <label><?php echo $this->form->getInput('observation_tissue_removal_dead'); ?></label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Living animal-->
    <div class="row" id="alive_field" style="display: none;">
      <div class="col-xs-12">
        <label id="jform_dead_animal_label" class="hasTooltip" title="<?php echo JText::_('OBSERVATION_LIVING_ANIMAL_DESC');?>">
          <?php echo JText::_('OBSERVATION_LIVING_ANIMAL');?>
        </label>
      </div>
      <div class="col-lg-6 col-md-6 col-xs-12">
        <div class="form-group">
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
      <!--Tissue removal alive-->
      <div class="col-lg-6 col-md-6 col-xs-12">
        <div class="form-group">
          <?php echo $this->form->getLabel('observation_tissue_removal_alive'); ?>
          <div class="col-xs-offset-2 col-xs-10">
            <div class="checkbox">
              <label><?php echo $this->form->getInput('observation_tissue_removal_alive'); ?></label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Stockage location-->
    <div class="row">
     <div class="col-xs-12"><?php echo $this->form->getLabel('observation_location_stock'); ?></div>
     <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="input-group">
        <?php echo $this->form->getInput('observation_location_stock'); ?>
      </div>
    </div>
  </div>
  <!--Remarks-->
  <div class="row">
   <div class="col-xs-12"><?php echo $this->form->getLabel('remarks'); ?></div>
   <div class="col-lg-12 col-md-12 col-xs-12">
    <div class="input-group">
      <span class="input-group-addon"><span class="fa fa-comment "></span></span>
      <?php echo $this->form->getInput('remarks'); ?>
    </div>
  </div>
</div>
<!--Admin validation-->
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
<!--Captcha-->
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
<a href="<?php echo JRoute::_('index.php?option=com_stranding_forms&task=stranding_adminform.cancel'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
<input type="hidden" name="option" value="com_stranding_forms" />
<input type="hidden" name="task" value="stranding_adminform.save" />
<?php echo JHtml::_('form.token'); ?>
</div>
</form>
</div>
