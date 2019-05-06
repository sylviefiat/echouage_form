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

JHtml::_('jquery.framework',  true, true);
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_stranding_forms', JPATH_ADMINISTRATOR);

$user = JFactory::getUser();
$nanimals=1;
?>

<style>
  .show_tail_fin_image {
    position: relative;
    display: inline-block !important;
    border-bottom: 1px dotted black;
    cursor: help;
  }
  .show_tail_fin_image .tail_fin_image {
    visibility: hidden;
    width: 288px;
    max-width: unset;
    background-color: #fff;
    color: #fff;
    text-align: center;
    padding: 5px 0;
    border: 1px solid #000;
    border-radius: 6px;   
    /* Position the tooltip text - see examples below! */
    position: absolute;
    z-index: 1;
  }
  .show_tail_fin_image:hover .tail_fin_image {
    visibility: visible;    
  }
  .form-group ul {
    list-style:none;
  }
  .label_icon {
    padding:0px !important;
  }
  .mesure_important label {
    background-color: #F68E76 !important;
    border: 2px solid #F36166 !important;
  }
  /* Style the tab */
  .tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
    display: flex;
    justify-content: space-between;
  }

  /* Style the buttons that are used to open the tab content */
  .tab button {
    background-color: inherit;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
  }

  /* Change background color of buttons on hover */
  .tab button:hover {
    background-color: #ddd;
  }

  /* Create an active/current tablink class */
  .tab button.active {
    background-color: #ccc;
  }

  /* Style the tab content */
  .tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
  }
  .tab1 {
    display:block;
  }
  .hidden {
    display:none;
  }
  .mesures_div {
    display: flex;
    flex-flow: wrap;
  }
  .mesures_div label {
    width: 40px;
    padding: 8px 12px;
    font-size: 14px;
    font-weight: normal;
    line-height: 1;
    color: #555555;
    text-align: center;
    background-color: #eeeeee;
    border: 1px solid #cccccc;
    border-radius: 4px;
    vertical-align: middle;
    margin-top:0;
  }
  .mesure_middle {
    align-items:center;
  }
  .mesures {
    float:right;
    width: auto !important;
  }

</style>

<script type="text/javascript">
  var nanimals = 1;
  var animals = [];
  var species = [
        ['inconnu','','',''],
        ['inconnu','inconnu','',''],
        ['cetace','Cachalot','Physeter','macrocephalus'],
        ['cetace','Cachalot pygmée','Kogia','breviceps'],
        ['cetace','Cachalot nain','Kogia','sima'],
        ['cetace','Baleine à bec de Blainville','Mesoplodon','densirostris'],
        ['cetace','Baleine à bec de longman','Indopacetus','pacificus'],
        ['cetace','Baleine à bec de Cuvier','Ziphius','cavirostris'],
        ['cetace','Orque','Orcinus','orca'], 
        ['cetace','Fausse orque','Pseudorca','crassidens'],
        ['cetace','Globicéphale tropical','Globicephala','macrorhynchus'],
        ['cetace','Dauphin de Risso','Grampus','griseus'] , 
        ['cetace','Orque Pygmée','Feresa','attenuata'], 
        ['cetace','Péponocéphale ou dauphin d’Electre','Peponocephala','electra'] , 
        ['cetace','Sténo ou dauphin à bec étroit','Steno','bredanensis'],
        ['cetace','Grand dauphin commun','Delphinus','delphis'],
        ['cetace','Grand dauphin de l’Indo-Pacifique','Tursiops','aduncus'],
        ['cetace','Dauphin commun','Tursiops','truncatus'], 
        ['cetace','Dauphin à long bec','Stenella','longirostris'],
        ['cetace','Dauphin tacheté pantropical','Stenella','attenuata'],
        ['cetace','Dauphin de Fraser','Lagenodelphis','hosei'],
        ['cetace','Baleine bleue pygmée','Balaenoptera','Musculus brevicauda'],
        ['cetace','Rorqual commun','Balaenoptera','physalus'],
        ['cetace','Rorqual boréal ou rorqual de Rudolphi','Balaenoptera','borealis'],
        ['cetace','Rorqual tropical ou rorqual de Bryde','Balaenoptera','edeni'],
        ['cetace','Rorqual de Omura','Balaenoptera','omurai'],
        ['cetace','Petit rorqual antarctique','Balaenoptera','bonaerensis'],
        ['cetace','Petit rorqual pygmée','Balaenoptera','acutorostrata subspecies'],
        ['cetace','Baleine à bosse','Megaptera','novaeangliae'],
        ['dugong','Dugong ou vache marine','Dugong','Dugong'],
        ['dugong','Otarie à fourrure de Nouvelle-Zélande','Arctophoca','Australis forsteri']
  ];

  /*function getScript(url,success) {
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
  }*/

  //getScript('https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js',function() {
    js = jQuery.noConflict();   
    
    js(document).ready(function() {
      // fix tooltip conflict with mootools
      js('.hasTooltip').each(function(){this.show = null; this.hide = null;});
      js('.hasPopover').each(function(){this.show = null; this.hide = null;});
     
      addMainListeners();
      addAnimalListeners();
      
      var subformNode = document.getElementsByClassName('subform-repeatable')[0];
      // Options for the observer (which mutations to observe)
      var config = { attributes: false, childList: true, subtree: false };
      // Create an observer instance linked to the callback function
      var observer = new MutationObserver(suformCallback);
      // Start observing the target node for configured mutations
      observer.observe(subformNode, config);

      // Later, you can stop observing
      //observer.disconnect();
     
    });
  //});

  // Callback function to execute when mutations are observed
  var suformCallback = function(mutationsList, observer) {
    for(var mutation of mutationsList) {      
      if (mutation.type == 'childList') {
        addAnimalListeners();
      }
    }
  }

function addMainListeners(){  
  // Add listener to change number of animals depending on stranding type
  document.getElementById('jform_observation_stranding_type').addEventListener("change", selectStrandingType, false);
  // Add observer on latitude and longitude hidden field setted by adresspicker plugin to display DMD values
  // latitude
  var observerLat = new MutationObserver(function(mutationsList, observer){
    document.getElementById('jform_observation_latitude_dmd').value=convert_Lat_DMD(document.getElementById('jform_observation_latitude').value);
  });
  observerLat.observe(document.getElementById('jform_observation_latitude'), { attributes: true, childList: false, subtree: false });
  // longitude
  var observerLng = new MutationObserver(function(mutationsList, observer){
    document.getElementById('jform_observation_longitude_dmd').value=convert_Lng_DMD(document.getElementById('jform_observation_longitude').value);
  });
  observerLng.observe(document.getElementById('jform_observation_longitude'), { attributes: true, childList: false, subtree: false });
}

function addAnimalListeners(){
  // Add listener to set genus and species on common name selection
  jQuery("select[name*='observation_species_common_name']").on('change',function(){
    let animalID = this.id.replace( /[^\d.]/g, '' );
    selectSpecies(animalID,this.value);
  });
  // Set image tooltip on caudal 
  jQuery("label[id*='observation_caudal_label']").each(function(){
    if(jQuery(this).find('.show_tail_fin_image').length<=0){
      var str = "<p class='show_tail_fin_image' name='Tail_Fin_Btn' value='Tail-Fin'>&nbsp;<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_SEE_TF_IMAGE'); ?><img class='tail_fin_image' src='http://"+window.location.hostname+"/administrator/components/com_stranding_forms/assets/images/s_slot_tail_fin.png' title='<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_TAIL_FIN')?>'/></p>";
      jQuery(this).append(str);
    }
  });
}

function selectStrandingType(){
  document.getElementById('jform_observation_number').disabled=event.target.value==='en groupe'?false:true;
  document.getElementById('jform_observation_number').value=1;
}

function selectSpecies(animalID,commonName) {
  //console.log(value);
  let value = species.filter(val => val[1]===commonName) ? species.filter(val => val[1]===commonName)[0]:null;
  if(value){
    // set genus and species values       
    document.getElementById('jform_animal_form__animal_form'+animalID+'__observation_species_genus').value = value[2];
    document.getElementById('jform_animal_form__animal_form'+animalID+'__observation_species').value = value[3];

    // set mesurements images depending on animal type
    var image1 = document.getElementById('jform_animal_form__animal_form'+animalID+'__observation_mesurements_image1');
    var image2 = document.getElementById('jform_animal_form__animal_form'+animalID+'__observation_mesurements_image2');
    var image3 = document.getElementById('jform_animal_form__animal_form'+animalID+'__observation_mesurements_image3');
    var image4 = document.getElementById('jform_animal_form__animal_form'+animalID+'__observation_mesurements_image4');
    var image5 = document.getElementById('jform_animal_form__animal_form'+animalID+'__observation_mesurements_image5');
    // group mesurements div to display next to corresponding image
    var maindiv = image1.parentElement.parentElement;
    jQuery(maindiv).find('.mesures_group1').wrapAll("<div class='col-lg-6 col-md-6 col-xs-12 mesures_div'/>");
    jQuery(maindiv).find('.mesures_group2').wrapAll("<div class='col-lg-6 col-md-6 col-xs-12 mesures_div mesure_middle'/>");
    jQuery(maindiv).find('.mesures_group3').wrapAll("<div class='col-lg-6 col-md-6 col-xs-12 mesures_div mesure_middle'/>");
    jQuery(maindiv).find('.mesures_group4').wrapAll("<div class='col-lg-6 col-md-6 col-xs-12 mesures_div mesure_middle'/>");
    jQuery(maindiv).find('.mesures_group5').wrapAll("<div class='col-lg-6 col-md-6 col-xs-12 mesures_div mesure_middle'/>");

    if((species.filter(val=>val[0]==='inconnu').map(val => val[1]).includes(value[1]) ) ||
     (species.filter(val=>val[0]==='cetace').map(val => val[1]).includes(value[1]))) {
      image1.parentElement.innerHTML="<img id='jform_animal_form__animal_form"+animalID+"__observation_mesurements_image1' src='http://"+window.location.hostname+"/administrator/components/com_stranding_forms/assets/images/dolphin/large/l_dolphin_body.png' alt='Mesures sur cétacés' title='<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_CETACE_IMAGE_DESC'); ?>' />";
      image2.parentElement.innerHTML="<img id='jform_animal_form__animal_form"+animalID+"__observation_mesurements_image2' src='http://"+window.location.hostname+"/administrator/components/com_stranding_forms/assets/images/dolphin/large/l_dolphin_pectoral_fin.png' alt='Mesures sur cétacés' title='<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_CETACE_IMAGE_DESC'); ?>' />";
      image3.parentElement.innerHTML="<img id='jform_animal_form__animal_form"+animalID+"__observation_mesurements_image2' src='http://"+window.location.hostname+"/administrator/components/com_stranding_forms/assets/images/dolphin/large/l_dolphin_dorsal_fin.png' alt='Mesures sur cétacés' title='<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_CETACE_IMAGE_DESC'); ?>' />";
      image4.parentElement.innerHTML="<img id='jform_animal_form__animal_form"+animalID+"__observation_mesurements_image2' src='http://"+window.location.hostname+"/administrator/components/com_stranding_forms/assets/images/dolphin/large/l_dolphin_tail_fin.png' alt='Mesures sur cétacés' title='<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_CETACE_IMAGE_DESC'); ?>' />";
      image5.parentElement.innerHTML="<img id='jform_animal_form__animal_form"+animalID+"__observation_mesurements_image2' src='http://"+window.location.hostname+"/administrator/components/com_stranding_forms/assets/images/dolphin/large/l_dolphin_bacon_thickness.png' alt='Mesures sur cétacés' title='<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_CETACE_IMAGE_DESC'); ?>' />";
    }
    else if(species.filter(val=>val[0]==='dugong').map(val => val[1]).includes(value[1]) ) {
      image1.parentElement.innerHTML="<img id='jform_animal_form__animal_form"+animalID+"__observation_mesurements_image1' src='http://"+window.location.hostname+"/administrator/components/com_stranding_forms/assets/images/dugong/large/l_dugong_body.png' alt='Mesures sur Dugong' title='<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_DUGONG_IMAGE_DESC'); ?>' />";
      image2.parentElement.innerHTML="<img id='jform_animal_form__animal_form"+animalID+"__observation_mesurements_image1' src='http://"+window.location.hostname+"/administrator/components/com_stranding_forms/assets/images/dugong/large/l_dugong_facial_disck.png' alt='Mesures sur Dugong' title='<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_DUGONG_IMAGE_DESC'); ?>' />";
      image3.parentElement.innerHTML="<img id='jform_animal_form__animal_form"+animalID+"__observation_mesurements_image1' src='http://"+window.location.hostname+"/administrator/components/com_stranding_forms/assets/images/dugong/large/l_dugong_pectoral_fin.png' alt='Mesures sur Dugong' title='<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_DUGONG_IMAGE_DESC'); ?>' />";
      image4.parentElement.innerHTML="<img id='jform_animal_form__animal_form"+animalID+"__observation_mesurements_image1' src='http://"+window.location.hostname+"/administrator/components/com_stranding_forms/assets/images/dugong/large/l_dugong_tail_fin.png' alt='Mesures sur Dugong' title='<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_DUGONG_IMAGE_DESC'); ?>' />";
      image5.parentElement.innerHTML="<img id='jform_animal_form__animal_form"+animalID+"__observation_mesurements_image1' src='http://"+window.location.hostname+"/administrator/components/com_stranding_forms/assets/images/dugong/large/l_dugong_bacon_thickness.png' alt='Mesures sur Dugong' title='<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_DUGONG_IMAGE_DESC'); ?>' />";
    }

  }
}


function displayBlock(div, affiche) { 
  document.getElementById(div).style.display = affiche ? 'block' : 'none';
}

function toggleContainer(name) {
  var e = document.getElementById(name);// MooTools might not be available ;)
  e.style.display = e.style.display === 'none' ? 'block' : 'none';
}

// Fonction de conversion latitude en degré minute décimal
function convert_Lat_DMD(lat) {
  var lat_dir, lat_deg, lat_min;
  lat_dir = lat >= 0 ? 'N' : 'S';
  // Garde la partie entière
  lat_deg = ( Math.abs( parseInt( lat ) ) );
  lat_min = ( Math.abs( ( Math.abs( lat ) - lat_deg ) * 60 ) );
  //    176 code ascci du degré. Ne garde que 3 décimales
  return lat_deg +  '°' + lat_min.toFixed(3) + '\'' + lat_dir;
}

// Fonction de conversion longitude en degré minute décimal
function convert_Lng_DMD(long){
  var long_dir, long_deg, long_min;
  long_dir = long >= 0 ? 'E' : 'W';
  // Garde la partie entière
  long_deg = ( Math.abs( parseInt( long ) ) );
  long_min = ( Math.abs( ( Math.abs( long ) - long_deg ) * 60 ) );
  //    176 code ascci du degré. Ne garde que 3 décimales
  return long_deg + '°' + long_min.toFixed(3) +  '\'' + long_dir;
}

function toggleInformant() {
  event.preventDefault();
  toggleContainer('informant_field');
  toggleContainer('informantShow');
  toggleContainer('informantHide');
}


</script>

<div class="stranding_admin-edit front-end-edit">
  <?php if (!empty($this->item->id)): ?>
    <h1 class="fa fa-eye fa-3x"> <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_TITLE'); ?> <?php echo $this->item->id; ?></h1>
    <?php else: ?>
      <h1 class="fa fa-eye fa-3x"> <?php echo JText::_('COM_STRANDING_FORMS_STRANDING_ADMIN_ADD_ITEM_TITLE'); ?></h1>
      <p class="card-subtitle mb-2 text-muted"> <?php echo JText::_('COM_STRANDING_FORMS_STRANDING_ADMIN_ADD_ITEM_DESC'); ?></p>
    <?php endif; ?>

    <form id="formStrandingAdmin" name="formStrandingAdmin" action="<?php echo JRoute::_('index.php?option=com_stranding_forms&task=stranding_admin.save'); ?>" method="post" class="form-validate" enctype="multipart/form-data">

      <!--Contacts-->
      <div class="row labels">
        <div class="col-12"><h4 class="fa fa-user fa-2x"> <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW1'); ?></h4></div>
      </div>
      <!--Observer contacts-->
      <div class="row groups">
        <div class="col-12"><?php echo $this->form->getLabel('observer_name'); ?></div>
        <div class="col-12">
          <div class="input-group">
            <span class="input-group-addon exergue"><span class="fa fa-user"></span></span>
            <?php echo $this->form->getInput('observer_name'); ?>
          </div>
        </div>
        <div class="col-12">
          <div class="input-group">
            <span class="input-group-addon exergue"><span class="fa fa-home"></span></span>
            <?php echo $this->form->getInput('observer_address'); ?>
          </div>
        </div>
        <div class="col-lg-9 col-md-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon exergue"><span class="fa fa-envelope"></span></span>
            <?php echo $this->form->getInput('observer_email'); ?>          
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-xs-12 minus-padding-left">
          <div class="input-group">
            <span class="input-group-addon exergue"><span class="fa fa-phone"></span></span>
            <?php echo $this->form->getInput('observer_tel'); ?>
          </div>
        </div>
        
        <!--Informant contacts-->
        <span id="informant_field" style="display: none;flex:1">
          <div class="col-12"><?php echo $this->form->getLabel('informant_name'); ?></div>
          <div class="col-12">
            <div class="input-group">
              <span class="input-group-addon exergue"><span class="fa fa-user"></span></span>
              <?php echo $this->form->getInput('informant_name'); ?>
            </div>
          </div>
          <div class="col-12">
            <div class="input-group">
              <span class="input-group-addon exergue"><span class="fa fa-home"></span></span>
              <?php echo $this->form->getInput('informant_address'); ?>
            </div>
          </div>
          <div class="col-lg-9 col-md-6 col-xs-12">
            <div class="input-group">
              <span class="input-group-addon exergue"><span class="fa fa-envelope"></span></span>
              <?php echo $this->form->getInput('informant_email'); ?>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-xs-12">
            <div class="input-group">
              <span class="input-group-addon exergue"><span class="fa fa-phone"></span></span>
              <?php echo $this->form->getInput('informant_tel'); ?>
            </div>
          </div>
        </span>

        <!--Bouton pour afficher les champs de l'informateur-->
        <div class="col-12">
          <button onclick="toggleInformant();">
            <label id="informantShow"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_INFORMANT_CONTACT_SHOW');?></label>
            <label id="informantHide" style="display: none !important;"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_INFORMANT_CONTACT_HIDE');?></label>
          </button>          
        </div>
      </div>
      
      <!--Circonstance de l'échouage-->
      <div class="row labels">
        <div class="col-12"><h4 class="fa fa-flag fa-2x"> <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW2'); ?></h4></div>
      </div>
      <!--Date-->
      <div class="row groups">
        <div class="col-lg-12 col-md-12 col-xs-12"><?php echo $this->form->getLabel('observation_datetime'); ?></div>
        <div class="col-lg-4 col-md-6 col-xs-12">
          <div class="input-group">
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
        <div class="col-12"><?php echo $this->form->getLabel('observation_localisation'); ?></div>
        <div class="col-12">
          <div class="input-group included com_stranding_forms_localisation">
            <span class="input-group-addon exergue"><span class="fa fa-map-marker"></span></span>
            <?php echo $this->form->getInput('observation_localisation'); ?>
          </div>
        </div>

        <div class="col-md-6 col-md-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-location-arrow"></span></span>
            <?php echo $this->form->getInput('observation_region'); ?>
          </div>
        </div>
        <div id="lat" class="col-md-6 col-md-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon">Lat</span>
            <?php echo $this->form->getInput('observation_latitude'); ?>
            <?php echo $this->form->getInput('observation_latitude_dmd'); ?>            
          </div>
        </div>
        <div class="col-md-6 col-md-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-flag"></span></span>
            <?php echo $this->form->getInput('observation_country'); ?>
          </div>
        </div>
        <div id="lng" class="col-md-6 col-md-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon">Lon</span>
            <?php echo $this->form->getInput('observation_longitude'); ?>
            <?php echo $this->form->getInput('observation_longitude_dmd'); ?>
          </div>
        </div>
        <hr class="col12"/>
        <!--Stranding type-->
        <div class="col-lg-6 col-md-6 col-xs-12">
          <div class="form-group">
            <?php echo $this->form->getLabel('observation_stranding_type'); ?>
            <br/>
            <?php echo $this->form->getInput('observation_stranding_type'); ?>         
          </div>
        </div>
        <!--Number-->
        <div class="col-lg-6 col-md-6 col-xs-12">
          <?php echo $this->form->getLabel('observation_number'); ?>
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-tachometer"></span></span>
            <?php echo $this->form->getInput('observation_number'); ?>
            <span style="display:none;" ><?php echo $this->form->getInput('id'); ?></span>
          </div>
        </div>
      </div>
      <!------------FOR LOOP ON ANIMALS--------------->
      
      <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
          <?php echo $this->form->renderField('animal_form'); ?>
        </div>
      </div>
     
      
        <!------------END OF FOR LOOP--------------->
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
  <div class="col-lg-12 col-md-12 col-xs-12"><?php //echo $this->form->getLabel('captcha'); ?></div>
  <div class="col-lg-12 col-md-12 col-xs-12">
    <div class="input-group">
      <?php //echo $this->form->getInput('captcha'); ?>
    </div>
  </div>
</div>-->
      <button type="submit" class="validate"><span><?php echo JText::_('JSUBMIT'); ?></span></button>
      <label><?php echo JText::_('OR'); ?></label>
      <a href="<?php echo JRoute::_('index.php?option=com_stranding_forms&task=stranding_adminform.cancel'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
      <input type="hidden" name="option" value="com_stranding_forms" />
      <input type="hidden" name="task" value="stranding_adminform.save" />
      <?php echo JHtml::_('form.token'); ?>
  </form>
</div>

