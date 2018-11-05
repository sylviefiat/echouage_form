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
  js(document).ready(function() {
    js('#form-stranding_admin').submit(function(event) {

      //add_new_identification_field(document.getElementById("jform_observation_number").value>0?true:false); 
    }); 
  });
  
  /*jQuery(document).ready(function() {
    jQuery('input:radio').on('click', function() {
      if(jQuery(this).attr('id') === 'jform_observation_dead_or_alive0') {
        jQuery('#dead_field').style.display = 'block'
        jQuery('#alive_field').style.display = 'none'
        //display('#dead_field', true);
        //display('#alive_field', false);
      }
      else if(jQuery(this).attr('id') === 'jform_observation_dead_or_alive1') {
        jQuery('#dead_field').style.display = 'none'
        jQuery('#alive_field').style.display = 'block'
        //display('#dead_field', false);
        //display('#alive_field', true);
      }
    })
  })*/

});


var cloneId = 0;

$(document).ready(function()
{
  $("#new_identification").click(function()
  {
    var clone = $(".sp_id").clone(true);
    clone.find("input").prop("name", "jform" + cloneId);
    cloneId++;
    clone.appendTo(".row");
  });
});

// affiche ou pas le block en focntion du choix du user
function choixUser(btn,champ1,champ2) { 
  if (btn.id == "jform_observation_dead_or_alive0") { 
    display(champ1,true); 
    display(champ2,false);  
  } 
  else if (btn.id == "jform_observation_dead_or_alive1") { 
    display(champ2,true); 
    display(champ1,false); 
  }
  if(btn.id == "jform_observation_tooth_or_baleen_or_defenses0") {
    display(champ1,true); 
    display(champ2,false);
  }
  else if(btn.id == "jform_observation_tooth_or_baleen_or_defenses1") {
    display(champ2,true); 
    display(champ1,false);
  }
  else if(btn.id == "jform_observation_tooth_or_baleen_or_defenses2") {
    display(champ2,false); 
    display(champ1,false);
  }
}

// si affiche=true alors on affiche le block choisi, sinon pas d'affichage
function display(div, affiche) { 
  if (affiche) 
    document.getElementById(div).style.display="block"; 
  else 
    document.getElementById(div).style.display="none";  
}

// affiche et masque le block au click
function toggleContainer(name) {
      var e = document.getElementById(name);// MooTools might not be available ;)
      e.style.display = e.style.display === 'none' ? 'block' : 'none';
}


// cloner le bloc identification
function add_new_identification_field() {
  var new_identification = document.getElementById("identification").innerHTML;
  document.getElementById("demo").innerHTML = new_identification;
}

// ajoute des boutons en fonction du nombre d'animals échoués
function add_new_btn(div, text, nbr) {
    if(nbr > 1) {
      // même nombre de boutons que d'animals échoués
      for(var i=2; i<=nbr; i++) {
        var btn = document.createElement("BUTTON");
        var t = document.createTextNode(text+" "+i);
        // incrémentation de l'id_location
        document.getElementById("jform_id_location").value = i;
        btn.appendChild(t);
        document.getElementById(div).appendChild(btn);
      }
    }
    else if(nbr == 1) {
      document.getElementById("jform_id_location").value = 1;
    }
}

function delete_new_btn(div, text) {

}

function add_new_mammal_field(div) {

}

function add_new_measurements_field(div) {

}

  /*function duplic(element) {
    clone01 = document.getElementById("spaces_title").cloneNode(true);
    clone01.id="spaces_title_1";
    document.getElementById(element).appendChild (clone01);
    clone1 = document.getElementById("spaces").cloneNode(true);
    clone1.id="spaces1";
    document.getElementById(element).appendChild (clone1);
    clone02 = document.getElementById("spaces_identification_title").cloneNode(true);
    clone02.id = "spaces_identification_title_1";
    document.getElementById(element).appendChild (clone02);
  }*/


  function enable_measures($status) {

  }

  /*Fonction ajout et suppression de champs version 2*/
  function addDiv(name, field) {
    var div = document.createElement("div");
    div.name = name;
    field.appendChild(div);
  }

  function addField(name, field) {
    var div = document.getElementById('identification');
    addDiv(name, field);
  }

  function supr_field(i) { 
    var Parent; 
    var Obj = document.getElementById ( 'input_'+i); 

    if(Obj)      
      Parent = Obj.parentNode;      
    if(Parent) 
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
      <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12"><span class="stranding_admin-title_row"><span class="fa fa-user fa-2x"><h4><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW1'); ?></h4></span></span></div>
      </div>
      <!--Observer contacts-->
      <div class="row">
       <div class="col-lg-12 col-md-12 col-xs-12"><?php echo $this->form->getLabel('observer_name'); ?></div>
       <div class="col-lg-3 col-md-6 col-xs-12">
        <div class="input-group">
          <span class="input-group-addon exergue"><span class="fa fa-user"></span></span>
          <?php echo $this->form->getInput('observer_name'); ?>
          <span style="display:none;" ><?php echo $this->form->getInput('id'); ?></span>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-xs-12">
        <div class="input-group">
          <span class="input-group-addon exergue"><span class="fa fa-home"></span></span>
          <?php echo $this->form->getInput('observer_address'); ?>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-xs-12">
        <div class="input-group">
          <span class="input-group-addon exergue"><span class="fa fa-phone"></span></span>
          <?php echo $this->form->getInput('observer_tel'); ?>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-xs-12">
        <div class="input-group">
          <span class="input-group-addon exergue"><span class="fa fa-envelope"></span></span>
          <?php echo $this->form->getInput('observer_email'); ?>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-xs-12">
        <label><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_INFORMANT_CONTACT');?></label>
        <button type="button" name="informantBtn" class="btn btn-primary" value="informateur" onclick="toggleContainer('informant_field')"><label><?php echo JText::_('RIGHT_HERE'); ?></label></button>
      </div>
    </div>
    <!--Informant contacts-->
    <div class="row" id="informant_field" style="display: none;">
      <div class="col-lg-12 col-md-12 col-xs-12"><?php echo $this->form->getLabel('informant_name'); ?></div>
      <div class="col-lg-3 col-md-6 col-xs-12">
        <div class="input-group">
          <span class="input-group-addon exergue"><span class="fa fa-user"></span></span>
          <?php echo $this->form->getInput('informant_name'); ?>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-xs-12">
        <div class="input-group">
          <span class="input-group-addon exergue"><span class="fa fa-home"></span></span>
          <?php echo $this->form->getInput('informant_address'); ?>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-xs-12">
        <div class="input-group">
          <span class="input-group-addon exergue"><span class="fa fa-phone"></span></span>
          <?php echo $this->form->getInput('informant_tel'); ?>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-xs-12">
        <div class="input-group">
          <span class="input-group-addon exergue"><span class="fa fa-envelope"></span></span>
          <?php echo $this->form->getInput('informant_email'); ?>
        </div>
      </div>
    </div>
    <!--Circonstance de l'échouage-->
    <div class="row">
      <div class="col-lg-12 col-md-12 col-xs-12"><span class="stranding_admin-title_row"><span class="fa fa-flag fa-2x"><h4><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW2'); ?></h4></span></span></div>
    </div>
    <!--Date-->
    <div class="row">
      <div class="col-lg-12 col-md-12 col-xs-12"><?php echo $this->form->getLabel('observation_datetime'); ?></div>
      <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="input-group included">
          <span class="input-group-addon exergue com_stranding_forms_date"><span class="fa fa-calendar"></span></span>
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
     <div class="col-lg-12 col-md-12 col-xs-12"><?php echo $this->form->getLabel('observation_localisation'); ?></div>
     <div class="col-md-12 col-md-12 col-xs-12">
      <div class="input-group included com_stranding_forms_localisation">
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
    <?php echo $this->form->getLabel('observation_number'); ?>
    <div class="input-group">
      <span class="input-group-addon"><span class="fa fa-tachometer"></span></span>
      <?php echo $this->form->getInput('observation_number'); ?>
      <span style="display:none;" ><?php echo $this->form->getInput('id_location'); ?></span>
    </div>
  </div>
</div>

<!--Identification-->
<div class="row">
  <div class="col-lg-12 col-md-12 col-xs-12" id="title_R3"><span class="stranding_admin-title_row"><span class="fa fa-eye fa-2x"><h4><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW3'); ?></h4></span></span></div>
</div>
<div class="row" id="identification">
  <!--Spaces-->
  <div class="col-lg-6 col-md-6 col-xs-12" id="spaces" name="espece[]">
    <?php echo $this->form->getLabel('observation_spaces'); ?>
    <div class="input-group">
      <span class="input-group-addon"><span class="fa fa-eye"></span></span>
      <?php echo $this->form->getInput('observation_spaces'); ?>
    </div>
  </div>
  <!--Spaces identification-->
  <div class="col-lg-6 col-md-6 col-xs-12 sp_id" id="spaces_identification" name="id_espece[]">
    <div class="form-group">
      <?php echo $this->form->getLabel('observation_spaces_identification'); ?>
      <div class="col-xs-offset-6 col-xs-12">
        <div class="radio">
          <label><?php echo $this->form->getInput('observation_spaces_identification'); ?></label>
        </div>
      </div>
    </div>
  </div>
  <!--Color-->
  <div class="col-lg-6 col-md-6 col-xs-12" id="color" name="couleur[]">
    <?php echo $this->form->getLabel('observation_color'); ?>
    <div class="input-group">
      <span class="input-group-addon"><span class="fa fa-adjust"></span><stpan></span>
        <?php echo $this->form->getInput('observation_color'); ?>
      </div>
    </div>
    <!--Tail fin-->
    <div class="col-lg-6 col-md-6 col-xs-12" id="tail_fin" name="tail[]">
      <div class="form-group">
        <?php echo $this->form->getLabel('observation_caudal'); ?>
        <button type="button" name="Tail_Fin_Btn" class="btn btn-light" value="Tail-Fin"onclick="toggleContainer('tail_fin_image')"><label><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_SEE_TF_IMAGE'); ?></label></button>
        <div class="col-xs-offset-2 col-xs-10">
          <div class="radio">
            <label><?php echo $this->form->getInput('observation_caudal'); ?></label>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8 col-lg-8 col-xs-12" id="tail_fin_image" style="display: none;">
     <p>
      <img src="administrator/components/com_stranding_forms/assets/images/s_slot_tail_fin.png" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_TAIL_FIN')?>" />
    </p>
  </div>
  <!--Beak or furrows-->
  <div class="col-lg-12 col-md-12 col-xs-12" id="tail_fin" name="tail[]">
    <div class="form-group">
      <?php echo $this->form->getLabel('observation_beak_or_furrows'); ?>
      <div class="col-xs-offset-6 col-xs-12">
        <div class="checkbox beak_or_furrows">
          <label><?php echo $this->form->getInput('observation_beak_or_furrows'); ?></label>
        </div>
      </div>
    </div>
  </div>
  <!--Other caracteristques-->
  <div class="col-lg-12 col-md-12 col-xs-12" id="other_caracts" name="other_crctrstk[]">
    <div class="form-group">
      <?php echo $this->form->getLabel('observation_tooth_or_baleen_or_defenses'); ?>
      <div class="col-xs-offset-2 col-xs-10">
        <div class="radio">
          <label><?php echo $this->form->getInput('observation_tooth_or_baleen_or_defenses'); ?></label>
        </div>
      </div>
    </div>
  </div>
  <!--Tooth-->
  <div class="tooth_f" id="tooth_field" style="display: none;" name="dents[]">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <label id="" class="hasTooltip" title="<?php echo JText::_('OBSERVATION_TOOTH_NUMBER_DESC');?>">
        <?php echo JText::_('OBSERVATION_TOOTH_NUMBER_LBL');?>
      </label>
    </div>
    <div class="col-lg-12 col-md-12 col-xs-12">
        <?php echo $this->form->getLabel('nb_teeth_upper_right'); ?>
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-tachometer"></span></span>
            <?php echo $this->form->getInput('nb_teeth_upper_right'); ?>
          </div>
    </div>
    <div class="col-lg-12 col-md-12 col-xs-12">
        <?php echo $this->form->getLabel('nb_teeth_upper_left'); ?>
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-tachometer"></span></span>
            <?php echo $this->form->getInput('nb_teeth_upper_left'); ?>
          </div>
    </div>
    <div class="col-lg-12 col-md-12 col-xs-12">
        <?php echo $this->form->getLabel('nb_teeth_lower_right'); ?>
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-tachometer"></span></span>
            <?php echo $this->form->getInput('nb_teeth_lower_right'); ?>
          </div>
    </div>
    <div class="col-lg-12 col-md-12 col-xs-12">
        <?php echo $this->form->getLabel('nb_teeth_lower_left'); ?>
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-tachometer"></span></span>
            <?php echo $this->form->getInput('nb_teeth_lower_left'); ?>
          </div>
    </div>
    <div class="col-lg-12 col-md-12 col-xs-12">
        <?php echo $this->form->getLabel('observation_teeth_base_diametre'); ?>
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-arrows-h"></span></span>
            <?php echo $this->form->getInput('observation_teeth_base_diametre'); ?>
          </div>
    </div>
  </div>
  <!--Baleen-->
  <div class="baleen_f" id="baleen_field" style="display: none;" name="fanons[]">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <label id="" class="hasTooltip" title="<?php echo JText::_('OBSERVATION_BALEEN_DESC');?>">
        <?php echo JText::_('OBSERVATION_BALEEN');?>
      </label>
    </div>&nbsp;
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="form-group">
        <?php echo $this->form->getLabel('observation_baleen_color'); ?>
        <div class="col-xs-offset-6 col-xs-12">
          <div class="input-group">
           <span class="input-group-addon"><span class="fa fa-adjust"></span></span>
           <?php echo $this->form->getInput('observation_baleen_color'); ?>
         </div>
       </div>
     </div>
   </div>
   <div class="col-lg-12 col-md-12 col-xs-12">
    <label id="" class="hasTooltip" title="<?php echo JText::_('OBSERVATION_BALEEN_MEASURES_DESC');?>">
      <?php echo JText::_('OBSERVATION_BALEEN_MEASURES_LBL');?>
    </label>
  </div>
  <div class="col-lg-12 col-md-12 col-xs-12">
    <div class="form-group">
      <?php echo $this->form->getLabel('observation_baleen_height'); ?>
      <div class="col-xs-offset-6 col-xs-12">
        <div class="input-group">
          <span class="input-group-addon"><span class="fa fa-arrows-v"></span></span>
          <?php echo $this->form->getInput('observation_baleen_height'); ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-12 col-md-12 col-xs-12">
    <div class="form-group">
      <?php echo $this->form->getLabel('observation_baleen_base_height'); ?>
      <div class="col-xs-offset-6 col-xs-12">
        <div class="input-group">
          <span class="input-group-addon"><span class="fa fa-arrows-h"></span></span>
          <?php echo $this->form->getInput('observation_baleen_base_height'); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!--<div class="col-lg-12 col-md-12 col-xs-12" id="news_identification_btns">
  
</div>-->
</div>

<!--<div class="row" id="demo">
  
</div>-->

<!--<div class="row">
  <div class="col-lg-12 col-md-12 col-xs-12">
    <button type="button" id="new_identification" class="btn btn-primary" onclick="add_new_identification_field()"><label><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ADD_FIELDS'); ?></label></button>
  </div>
</div>
<div class="row" id="demo">
  
</div>-->

<!--Animal-->
<div class="row">
  <div class="col-lg-12 col-md-12 col-xs-12" id="title_R4"><span class="stranding_admin-title_row"><span class="fa fa-shield fa-2x"><h4><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW4'); ?></h4></span></span></div>
</div>
<div class="row" id="animal">
  <!--Size-->
  <div class="col-lg-6 col-md-6 col-xs-12">
    <?php echo $this->form->getLabel('observation_size'); ?>
    <div class="input-group">
      <span class="input-group-addon"><span class="fa fa-arrows-h"></span></span>
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
  <div class="col-lg-6 col-md-6 col-xs-12">
    <?php echo $this->form->getLabel('catch_indices'); ?>
    <div class="input-group"> 
      <span class="input-group-addon"><span class="fa fa-comment "></span></span>
      <?php echo $this->form->getInput('catch_indices'); ?>
    </div>
  </div>
  <!--Levies & photos-->
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
  <!--Dead or Alive-->
  <div class="col-lg-6 col-md-6 col-xs-12">
    <div class="form-group">
      <?php echo $this->form->getLabel('observation_dead_or_alive'); ?>
      <div class="col-xs-offset-2 col-xs-10">
        <div class="radio">
          <label><?php echo $this->form->getInput('observation_dead_or_alive'); ?></label>
        </div>
      </div>
    </div>
  </div>
  <!--Dead animal  -->
  <div class="col-xs-12"  id="dead_field" style="display: none;">
    <div class="col-lg-6 col-md-6 col-xs-12">
      <label id="jform_dead_animal_label" class="hasTooltip" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_OBSERVATION_DEAD_ANIMAL_DESC');?>">
        <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_OBSERVATION_DEAD_ANIMAL');?>
      </label>
    </div>
    <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="form-group">
        <div class="col-xs-offset-6 col-xs-12">
          <div class="radio">
            <label><?php echo $this->form->getInput('observation_death'); ?></label>
          </div>
        </div>
      </div>
    </div>
    <!--Death datetime-->
    <div class="death_datetime col-lg-12 col-md-12 col-xs-12">
      <?php echo $this->form->getLabel('observation_datetime_death'); ?>
      <div class="form-inline">
        <div class="input-group included">
          <span class="input-group-addon exergue"><span class="fa fa-calendar"></span></span>
          <?php echo $this->form->getInput('observation_datetime_death'); ?>
        </div>
        <div class="input-group form-inline">
          <span class="input-group-addon"><span class="fa fa-clock-o"></span>
        </span>
        <?php echo $this->form->getInput('observation_hours'); ?>&nbsp;
        <label><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_HM_SEPARATOR'); ?></label>&nbsp;
        <?php echo $this->form->getInput('observation_minutes'); ?>
      </div>
    </div>
  </div>
  &nbsp;&nbsp;&nbsp;
  <!--State decomposition-->
  <div class="col-lg-12 col-md-12 col-xs-12"><?php echo $this->form->getLabel('observation_state_decomposition'); ?></div>
  <div class="col-lg-8 col-md-8 col-xs-12">
   <div class="form-group">
    <div class="col-xs-offset-2 col-xs-10">
      <div class="radio">
        <label><?php echo $this->form->getInput('observation_state_decomposition'); ?></label>
      </div>
    </div>
  </div> 
</div>
<!--Levies protocol-->
<div class="col-lg-12 col-md-12 col-xs-12"><?php echo $this->form->getLabel('levies_protocole'); ?></div>
<div class="col-lg-6 col-md-6 col-xs-12">
  <div class="form-group">
    <div class="col-xs-offset-2 col-xs-10">
      <div class="radio">
        <label><?php echo $this->form->getInput('levies_protocole'); ?></label>
      </div>
    </div>
  </div>
</div>
<!--Label references-->
<div class="col-lg-6 col-md-6 col-xs-12" id="label_ref">
  <?php echo $this->form->getLabel('label_references'); ?>
  <div class="input-group">
    <span class="input-group-addon"><span class="fa fa-tag"></span></span>
    <?php echo $this->form->getInput('label_references'); ?>
  </div>
</div>&nbsp;&nbsp;&nbsp;
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
<!--Living animal  -->
<div class="col-xs-12" id="alive_field" style="display: none;">
  <div class="col-lg-6 col-md-6 col-xs-12">
    <label id="jform_dead_animal_label" class="hasTooltip" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_OBSERVATION_LIVING_ANIMAL_DESC');?>">
      <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_OBSERVATION_LIVING_ANIMAL');?>
    </label>
  </div>
  <div class="col-lg-12 col-md-12 col-xs-12">
    <div class="form-group">
      <div class="col-xs-offset-2 col-xs-10">
        <div class="checkbox">
          <label><?php echo $this->form->getInput('observation_alive'); ?></label>
        </div>
      </div>
    </div>
  </div>
  <!--Release datetime-->
  <div class="release_datetime col-lg-12 col-md-12 col-xs-12">
    <?php echo $this->form->getLabel('observation_datetime_release'); ?>
    <div class="form-inline"> 
      <div class="input-group included">
        <span class="input-group-addon exergue"><span class="fa fa-calendar"></span></span>
        <?php echo $this->form->getInput('observation_datetime_release'); ?>
      </div>
      <div class="input-group form-inline">
        <span class="input-group-addon"><span class="fa fa-clock-o"></span>
      </span>
      <?php echo $this->form->getInput('observation_hours'); ?>&nbsp;
      <label><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_HM_SEPARATOR'); ?></label>&nbsp;
      <?php echo $this->form->getInput('observation_minutes'); ?>
    </div>
  </div>
</div>&nbsp;&nbsp;&nbsp;
<!--Tissue removal alive-->
<div class="col-lg-6 col-md-6 col-xs-12">
  <div class="form-group">
    <?php echo $this->form->getLabel('observation_tissue_removal_alive'); ?>
    <div class="col-xs-offset-6 col-xs-12">
      <div class="checkbox">
        <label><?php echo $this->form->getInput('observation_tissue_removal_alive'); ?></label>
      </div>
    </div>
  </div>
</div>
</div>
<!--<div id="news_animal_btns">
  
</div>-->
</div>
<!--Measurements-->
<div class="row">
  <div class="col-lg-12 col-md-12 col-xs-12" id="title_R5"><span class="stranding_admin-title_row"><span class="fa fa-arrows-h fa-2x"><h4><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW5'); ?></h4></span></span></div>
</div>
<div id="measurements">
  <div class="row" id="com_stranding_forms_measurements_info">
    <div class="col-lg-12 col-md-12 col-xs-12" id="mesures_info">
      <span class="fa fa-info-circle">&nbsp;&nbsp;<label class="info-mesurements"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_INFO_1');?>
      <strong style="color: red;"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_INFO_RED');?></strong>
      <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_INFO_2');?>
    </label></span>
  </div>
</div>
<!--Cetaces measurements-->
<div class="row measurements_title" onclick="toggleContainer('cetace_measures')">
  <div class="col-lg-12 col-md-12 col-xs-12">
       <label class="hasTooltip" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_IMAGE_DESC'); ?>"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_DOLPHIN_MESURES_IMAGE'); ?></label>
  </div>
</div>
<div id="cetace_measures" style="display: none;">
   <!--Dolphin body-->
  <div class="row">
    <div class="col-lg-6 col-md-6 col-xs-12" id="cetace_measures_position0">
      <p>
       <img id="dolphin_image" src="administrator/components/com_stranding_forms/assets/images/dolphin/large/l_dolphin_body.png" alt="Mesures sur cétacés" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_CETACE_IMAGE_DESC'); ?>" />
     </p>
   </div>
    <div class="col-lg-3 col-md-3 col-xs-3">
     <button id="jform_observation_dolphin_mesures_a_btn" type="button" class="btn btn-danger btn-lg btn-block" onclick="toggleContainer('observation_dolphin_mesures_a_field')">
          <?php echo $this->form->getLabel('observation_dolphin_mesures_a'); ?></button>
     <div id="observation_dolphin_mesures_a_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_a'); ?>
    </div>&nbsp;
     <button id="jform_observation_dolphin_mesures_b_btn" type="button" class="btn btn-danger btn-lg btn-block" onclick="toggleContainer('observation_dolphin_mesures_b_field')">
          <?php echo $this->form->getLabel('observation_dolphin_mesures_b'); ?></button>
     <div id="observation_dolphin_mesures_b_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_b'); ?>
    </div>&nbsp;
     <button id="jform_observation_dolphin_mesures_c_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('observation_dolphin_mesures_c_field')">
          <?php echo $this->form->getLabel('observation_dolphin_mesures_c'); ?></button>
     <div id="observation_dolphin_mesures_c_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_c'); ?>
    </div>&nbsp;
     <button id="jform_observation_dolphin_mesures_d_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dolphin_mesures_d_field')">
          <?php echo $this->form->getLabel('observation_dolphin_mesures_d'); ?></button>
     <div id="jform_observation_dolphin_mesures_d_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_d'); ?>
    </div>&nbsp;
     <button id="jform_observation_dolphin_mesures_e_btn" type="button" class="btn btn-danger btn-lg btn-block" onclick="toggleContainer('jform_observation_dolphin_mesures_e_field')"><?php echo $this->form->getLabel('observation_dolphin_mesures_e'); ?></button>
     <div id="jform_observation_dolphin_mesures_e_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_e'); ?>
    </div>&nbsp;
     <button id="jform_observation_dolphin_mesures_f_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dolphin_mesures_f_field')">
          <?php echo $this->form->getLabel('observation_dolphin_mesures_f'); ?></button>
     <div id="jform_observation_dolphin_mesures_f_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_f'); ?>
    </div>&nbsp;
  </div>
<div class="col-lg-3 col-md-3 col-xs-3">
     <button id="jform_observation_dolphin_mesures_g_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dolphin_mesures_g_field')">
          <?php echo $this->form->getLabel('observation_dolphin_mesures_g'); ?></button>
     <div id="jform_observation_dolphin_mesures_g_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_g'); ?>
    </div>&nbsp;
     <button id="jform_observation_dolphin_mesures_h_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dolphin_mesures_h_field')">
          <?php echo $this->form->getLabel('observation_dolphin_mesures_h'); ?></button>
     <div id="jform_observation_dolphin_mesures_h_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_h'); ?>
    </div>&nbsp;
     <button id="jform_observation_dolphin_mesures_a_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dolphin_mesures_i_field')">
          <?php echo $this->form->getLabel('observation_dolphin_mesures_i'); ?></button>
     <div id="jform_observation_dolphin_mesures_i_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_i'); ?>
    </div>&nbsp;
     <button id="jform_observation_dolphin_mesures_j_btn" type="button" class="btn btn-danger btn-lg btn-block" onclick="toggleContainer('jform_observation_dolphin_mesures_j_field')">
          <?php echo $this->form->getLabel('observation_dolphin_mesures_j'); ?></button>
     <div id="jform_observation_dolphin_mesures_j_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_j'); ?>
    </div>&nbsp;
     <button id="jform_observation_dolphin_mesures_k_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dolphin_mesures_k_field')">
          <?php echo $this->form->getLabel('observation_dolphin_mesures_k'); ?></button>
     <div id="jform_observation_dolphin_mesures_k_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_k'); ?>
    </div>&nbsp;
     <button id="jform_observation_dolphin_mesures_l_btn" type="button" class="btn btn-danger btn-lg btn-block" onclick="toggleContainer('jform_observation_dolphin_mesures_l_field')">
          <?php echo $this->form->getLabel('observation_dolphin_mesures_l'); ?></button>
     <div id="jform_observation_dolphin_mesures_l_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_l'); ?>
    </div>&nbsp;
     <button id="jform_observation_dolphin_mesures_m_btn" type="button" class="btn btn-danger btn-lg btn-block" onclick="toggleContainer('jform_observation_dolphin_mesures_m_field')">
          <?php echo $this->form->getLabel('observation_dolphin_mesures_m'); ?></button>
     <div id="jform_observation_dolphin_mesures_m_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_m'); ?>
    </div>&nbsp;
   </div>
 </div>
<!--Dolphin member-->
  <div class="row">
      <div class="col-lg-3 col-md-3 col-xs-12" id="cetace_measures_position1">
      <p>
       <img id="dolphin_image" src="administrator/components/com_stranding_forms/assets/images/dolphin/large/l_dolphin_pectoral_fin.png" alt="Mesures sur cétacés" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_CETACE_IMAGE_DESC'); ?>" />
     </p>
   </div>
   <div class="col-lg-3 col-md-3 col-xs-3">
     <button id="jform_observation_dolphin_mesures_n_btn" type="button" class="btn btn-danger btn-lg btn-block" onclick="toggleContainer('jform_observation_dolphin_mesures_n_field')">
          <?php echo $this->form->getLabel('observation_dolphin_mesures_n'); ?></button>
     <div id="jform_observation_dolphin_mesures_n_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_n'); ?>
    </div>&nbsp;
     <button id="jform_observation_dolphin_mesures_o_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dolphin_mesures_o_field')">
          <?php echo $this->form->getLabel('observation_dolphin_mesures_o'); ?></button>
     <div id="jform_observation_dolphin_mesures_o_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_o'); ?>
    </div>&nbsp;
   </div>
     
   <div class="col-lg-3 col-md-3 col-xs-12" id="cetace_measures_position2">
      <p>
       <img id="dolphin_image" src="administrator/components/com_stranding_forms/assets/images/dolphin/large/l_dolphin_dorsal_fin.png" alt="Mesures sur cétacés" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_CETACE_IMAGE_DESC'); ?>" />
     </p>
   </div>
   <div class="col-lg-3 col-md-3 col-xs-3">
     <button id="jform_observation_dolphin_mesures_p_btn" type="button" class="btn btn-danger btn-lg btn-block" onclick="toggleContainer('jform_observation_dolphin_mesures_p_field')">
          <?php echo $this->form->getLabel('observation_dolphin_mesures_p'); ?></button>
     <div id="jform_observation_dolphin_mesures_p_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_p'); ?>
    </div>&nbsp;
     <button id="jform_observation_dolphin_mesures_q_btn" type="button" class="btn btn-danger btn-lg btn-block" onclick="toggleContainer('jform_observation_dolphin_mesures_q_field')">
          <?php echo $this->form->getLabel('observation_dolphin_mesures_q'); ?></button>
     <div id="jform_observation_dolphin_mesures_q_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_q'); ?>
    </div>&nbsp;
   </div>
   <div class="col-lg-3 col-md-3 col-xs-12" id="cetace_measures_position3">
      <p>
       <img id="dolphin_image" src="administrator/components/com_stranding_forms/assets/images/dolphin/large/l_dolphin_tail_fin.png" alt="Mesures sur cétacés" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_CETACE_IMAGE_DESC'); ?>" />
     </p>
   </div>
   <div class="col-lg-3 col-md-3 col-xs-3">
     <button id="jform_observation_dolphin_mesures_r_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dolphin_mesures_r_field')">
          <?php echo $this->form->getLabel('observation_dolphin_mesures_r'); ?></button>
     <div id="jform_observation_dolphin_mesures_r_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_r'); ?>
    </div>&nbsp;
     <button id="jform_observation_dolphin_mesures_s_btn" type="button" class="btn btn-danger btn-lg btn-block" onclick="toggleContainer('jform_observation_dolphin_mesures_s_field')">
          <?php echo $this->form->getLabel('observation_dolphin_mesures_s'); ?></button>
     <div id="jform_observation_dolphin_mesures_s_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_s'); ?>
    </div>&nbsp;
   </div>
   <div class="col-lg-3 col-md-3 col-xs-12" id="cetace_measures_position4">
      <p>
       <img id="dolphin_image" src="administrator/components/com_stranding_forms/assets/images/dolphin/large/l_dolphin_bacon_thickness.png" alt="Mesures sur cétacés" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_CETACE_IMAGE_DESC'); ?>" />
     </p>
   </div>
   <div class="col-lg-3 col-md-3 col-xs-3">
     <button id="jform_observation_dolphin_mesures_t_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dolphin_mesures_t_field')"><?php echo $this->form->getLabel('observation_dolphin_mesures_t'); ?></button>
     <div id="jform_observation_dolphin_mesures_t_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_t'); ?>
    </div>&nbsp;
     <button id="jform_observation_dolphin_mesures_u_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dolphin_mesures_u_field')"><?php echo $this->form->getLabel('observation_dolphin_mesures_u'); ?></button>
     <div id="jform_observation_dolphin_mesures_u_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_u'); ?>
    </div>&nbsp;
     <button id="jform_observation_dolphin_mesures_v_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dolphin_mesures_v_field')"><?php echo $this->form->getLabel('observation_dolphin_mesures_v'); ?></button>
     <div id="jform_observation_dolphin_mesures_v_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dolphin_mesures_v'); ?>
    </div>&nbsp;
   </div>
 </div>
</div>
<!--Dugongs measurements-->
<div class="row measurements_title" onclick="toggleContainer('dugong_measures')">
  <div class="col-lg-12 col-md-12 col-xs-12">
    <label class="hasTooltip" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_IMAGE_DESC'); ?>"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_DUGONG_MESURES_IMAGE'); ?></label>
  </div>
</div>
<div id="dugong_measures" style="display: none;">
<!--Dugong body-->
<div class="row">
    <div class="col-lg-6 col-md-6 col-xs-12" id="dugong_measures_position0">
      <p>
       <img id="dugong_image" src="administrator/components/com_stranding_forms/assets/images/dugong/large/l_dugong_body.png" alt="Mesures sur dugongs" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_DUGONG_IMAGE_DESC'); ?>" />
     </p>
   </div>
    <div class="col-lg-3 col-md-3 col-xs-3">
     <button id="jform_observation_dugong_mesures_a_btn" type="button" class="btn btn-danger btn-lg btn-block" onclick="toggleContainer('observation_dugong_mesures_a_field')">
          <?php echo $this->form->getLabel('observation_dugong_mesures_a'); ?></button>
     <div id="observation_dugong_mesures_a_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_a'); ?>
    </div>&nbsp;
     <button id="jform_observation_dugong_mesures_b_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('observation_dugong_mesures_b_field')">
          <?php echo $this->form->getLabel('observation_dugong_mesures_b'); ?></button>
     <div id="observation_dugong_mesures_b_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_b'); ?>
    </div>&nbsp;
     <button id="jform_observation_dugong_mesures_c_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('observation_dugong_mesures_c_field')">
          <?php echo $this->form->getLabel('observation_dugong_mesures_c'); ?></button>
     <div id="observation_dugong_mesures_c_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_c'); ?>
    </div>&nbsp;
     <button id="jform_observation_dugong_mesures_d_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dugong_mesures_d_field')">
          <?php echo $this->form->getLabel('observation_dugong_mesures_d'); ?></button>
     <div id="jform_observation_dugong_mesures_d_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_d'); ?>
    </div>&nbsp;
     <button id="jform_observation_dugong_mesures_e_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dugong_mesures_e_field')"><?php echo $this->form->getLabel('observation_dugong_mesures_e'); ?></button>
     <div id="jform_observation_dugong_mesures_e_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_e'); ?>
    </div>&nbsp;
     <button id="jform_observation_dugong_mesures_f_btn" type="button" class="btn btn-danger btn-lg btn-block" onclick="toggleContainer('jform_observation_dugong_mesures_f_field')">
          <?php echo $this->form->getLabel('observation_dugong_mesures_f'); ?></button>
     <div id="jform_observation_dugong_mesures_f_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_f'); ?>
    </div>&nbsp;
  </div>
<div class="col-lg-3 col-md-3 col-xs-3">
     <button id="jform_observation_dugong_mesures_g_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dugong_mesures_g_field')">
          <?php echo $this->form->getLabel('observation_dugong_mesures_g'); ?></button>
     <div id="jform_observation_dugong_mesures_g_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_g'); ?>
    </div>&nbsp;
     <button id="jform_observation_dugong_mesures_h_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dugong_mesures_h_field')">
          <?php echo $this->form->getLabel('observation_dugong_mesures_h'); ?></button>
     <div id="jform_observation_dugong_mesures_h_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_h'); ?>
    </div>&nbsp;
     <button id="jform_observation_dugong_mesures_a_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dugong_mesures_i_field')">
          <?php echo $this->form->getLabel('observation_dugong_mesures_i'); ?></button>
     <div id="jform_observation_dugong_mesures_i_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_i'); ?>
    </div>&nbsp;
     <button id="jform_observation_dugong_mesures_j_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dugong_mesures_j_field')">
          <?php echo $this->form->getLabel('observation_dugong_mesures_j'); ?></button>
     <div id="jform_observation_dugong_mesures_j_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_j'); ?>
    </div>&nbsp;
     <button id="jform_observation_dugong_mesures_k_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dugong_mesures_k_field')">
          <?php echo $this->form->getLabel('observation_dugong_mesures_k'); ?></button>
     <div id="jform_observation_dugong_mesures_k_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_k'); ?>
    </div>&nbsp;
     <button id="jform_observation_dugong_mesures_l_btn" type="button" class="btn btn-danger btn-lg btn-block" onclick="toggleContainer('jform_observation_dugong_mesures_l_field')">
          <?php echo $this->form->getLabel('observation_dugong_mesures_l'); ?></button>
     <div id="jform_observation_dugong_mesures_l_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_l'); ?>
    </div>&nbsp;
     <button id="jform_observation_dugong_mesures_m_btn" type="button" class="btn btn-danger btn-lg btn-block" onclick="toggleContainer('jform_observation_dugong_mesures_m_field')">
          <?php echo $this->form->getLabel('observation_dugong_mesures_m'); ?></button>
     <div id="jform_observation_dugong_mesures_m_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_m'); ?>
    </div>&nbsp;
   </div>
 </div>
<!--Dugong member-->
  <div class="row">
       <div class="col-lg-3 col-md-3 col-xs-12" id="dugong_measures_position2">
      <p>
       <img id="dugong_image" src="administrator/components/com_stranding_forms/assets/images/dugong/large/l_dugong_facial_disck.png" alt="Mesures sur dugongs" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_DUGONG_IMAGE_DESC'); ?>" />
     </p>
   </div>
   <div class="col-lg-3 col-md-3 col-xs-3">
     <button id="jform_observation_dugong_mesures_n_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dugong_mesures_n_field')">
          <?php echo $this->form->getLabel('observation_dugong_mesures_n'); ?></button>
     <div id="jform_observation_dugong_mesures_n_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_n'); ?>
    </div>&nbsp;
     <button id="jform_observation_dugong_mesures_o_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dugong_mesures_o_field')">
          <?php echo $this->form->getLabel('observation_dugong_mesures_o'); ?></button>
     <div id="jform_observation_dugong_mesures_o_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_o'); ?>
    </div>&nbsp;
   </div>
     
     <div class="col-lg-3 col-md-3 col-xs-12" id="dugong_measures_position1">
      <p>
       <img id="dugong_image" src="administrator/components/com_stranding_forms/assets/images/dugong/large/l_dugong_pectoral_fin.png" alt="Mesures sur dugongs" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_DUGONG_IMAGE_DESC'); ?>" />
     </p>
   </div>
   <div class="col-lg-3 col-md-3 col-xs-3">
     <button id="jform_observation_dugong_mesures_p_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dugong_mesures_p_field')">
          <?php echo $this->form->getLabel('observation_dugong_mesures_p'); ?></button>
     <div id="jform_observation_dugong_mesures_p_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_p'); ?>
    </div>&nbsp;
     <button id="jform_observation_dugong_mesures_q_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dugong_mesures_q_field')">
          <?php echo $this->form->getLabel('observation_dugong_mesures_q'); ?></button>
     <div id="jform_observation_dugong_mesures_q_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_q'); ?>
    </div>&nbsp;
   </div>
   <div class="col-lg-3 col-md-3 col-xs-12" id="dugong_measures_position3">
      <p>
       <img id="dugong_image" src="administrator/components/com_stranding_forms/assets/images/dugong/large/l_dugong_tail_fin.png" alt="Mesures sur dugongs" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_DUGONG_IMAGE_DESC'); ?>" />
     </p>
   </div>
   <div class="col-lg-3 col-md-3 col-xs-3">
     <button id="jform_observation_dugong_mesures_r_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dugong_mesures_r_field')">
          <?php echo $this->form->getLabel('observation_dugong_mesures_r'); ?></button>
     <div id="jform_observation_dugong_mesures_r_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_r'); ?>
    </div>&nbsp;
     <button id="jform_observation_dugong_mesures_s_btn" type="button" class="btn btn-danger btn-lg btn-block" onclick="toggleContainer('jform_observation_dugong_mesures_s_field')">
          <?php echo $this->form->getLabel('observation_dugong_mesures_s'); ?></button>
     <div id="jform_observation_dugong_mesures_s_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_s'); ?>
    </div>&nbsp;
   </div>
   <div class="col-lg-3 col-md-3 col-xs-12" id="dugong_measures_position4">
      <p>
       <img id="dugong_image" src="administrator/components/com_stranding_forms/assets/images/dugong/large/l_dugong_bacon_thickness.png" alt="Mesures sur dugongs" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_DUGONG_IMAGE_DESC'); ?>" />
     </p>
   </div>
   <div class="col-lg-3 col-md-3 col-xs-3">
     <button id="jform_observation_dugong_mesures_t_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dugong_mesures_t_field')"><?php echo $this->form->getLabel('observation_dugong_mesures_t'); ?></button>
     <div id="jform_observation_dugong_mesures_t_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_t'); ?>
    </div>&nbsp;
     <button id="jform_observation_dugong_mesures_u_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dugong_mesures_u_field')"><?php echo $this->form->getLabel('observation_dugong_mesures_u'); ?></button>
     <div id="jform_observation_dugong_mesures_u_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_u'); ?>
    </div>&nbsp;
     <button id="jform_observation_dugong_mesures_v_btn" type="button" class="btn btn-secondary btn-lg btn-block" onclick="toggleContainer('jform_observation_dugong_mesures_v_field')"><?php echo $this->form->getLabel('observation_dugong_mesures_v'); ?></button>
     <div id="jform_observation_dugong_mesures_v_field"  style="display: none;">
          <?php echo $this->form->getInput('observation_dugong_mesures_v'); ?>
    </div>&nbsp;
   </div>
 </div>
</div>
<div id="news_measurements_btns">
  
</div>
</div>
<!--Stockage location-->
<div class="row">
 <div class="col-lg-12 col-md-12 col-xs-12">
  <?php echo $this->form->getLabel('observation_location_stock'); ?>
  <div class="input-group">
    <span class="input-group-addon"><span class="fa fa-archive "></span></span>
    <?php echo $this->form->getInput('observation_location_stock'); ?>
  </div>
</div>
</div>
<!--Remarks-->
<div class="row">
 <div class="col-lg-12 col-md-12 col-xs-12">
  <?php echo $this->form->getLabel('remarks'); ?>
  <div class="input-group">
    <span class="input-group-addon"><span class="fa fa-comment "></span></span>
    <?php echo $this->form->getInput('remarks'); ?>
  </div>
</div>
</div>
<!--Admin validation-->
<?php if($user->id != 0){ ?>
 <div class="row">
  <div class="col-lg-12 col-md-12 col-xs-12"><?php echo $this->form->getLabel('admin_validation'); ?></div>
  <div class="col-lg-12 col-md-12 col-xs-12">
    <div class="input-group">
     <span class="input-group-addon"><span class="fa fa-check "></span></span>
     <?php echo $this->form->getInput('admin_validation'); ?>
   </div>
 </div>
</div>
<?php } ?>
<!--Captcha
<div class="row">
  <div class="col-lg-12 col-md-12 col-xs-12"><?php echo $this->form->getLabel('captcha'); ?></div>
  <div class="col-lg-12 col-md-12 col-xs-12">
    <div class="input-group">
      <?php echo $this->form->getInput('captcha'); ?>
    </div>
  </div>
</div>-->
<button type="submit" class="validate"><span><?php echo JText::_('JSUBMIT'); ?></span></button>&nbsp;&nbsp;&nbsp;
<label><?php echo JText::_('OR'); ?></label>&nbsp;&nbsp;&nbsp;
<a href="<?php echo JRoute::_('index.php?option=com_stranding_forms&task=stranding_adminform.cancel'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
<input type="hidden" name="option" value="com_stranding_forms" />
<input type="hidden" name="task" value="stranding_adminform.save" />
<?php echo JHtml::_('form.token'); ?>
</div>
</form>
</div>

