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
  .mesure_important {
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
     
      //addMainListeners();
      //addAnimalListeners(1);  
      /*js('#jform_observation_number').change(function() {
        maxN = nanimals < this.value ? nanimals : this.value;
        nanimals = this.value;
        saveAnimals(maxN);
        js('#global_animals').load(document.URL +  ' #global_animals',{"nanimals":""+this.value+""}, function() {
          for(var i=1;i<=nanimals;i++){
            addAnimalListeners(i);
            if(i<=maxN){
              loadAnimal(i);
            }
          }          
        });      
      });*/
     
    });
  //});


/*
function addMainListeners(){
  document.getElementById('jform_observation_stranding_type').addEventListener("change", selectStrandingType, false);
  document.getElementById('jform_observation_latitude').addEventListener("change", function(){convert_Lat_DMD(this.value);}, false);
  document.getElementById('jform_observation_latitude').addEventListener("change", function(){convert_Lng_DMD(this.value);}, false);
}

function addAnimalListeners(animalID){
  if(animalID===1){
    document.getElementById('div_observation_clone1').querySelector('#observation_sp_always_the_same').addEventListener("change", function(){toogleSpeciesChoice();}, false);
  } 
  document.getElementById('div_observation_clone'+animalID).querySelector('#jform_observation_dead_or_alive').addEventListener("change", function(){selectDeadOrAlive(animalID);}, false);
  document.getElementById('div_observation_clone'+animalID).querySelector('#jform_observation_alive').addEventListener("change", function(value){selectAlive(value,animalID);}, false);
  document.getElementById('div_observation_clone'+animalID).querySelector('#jform_observation_tooth_or_baleen_or_defenses').addEventListener("change", function(value){selectToothOrBaleenOrDefenses(animalID);}, false);
  document.getElementById('div_observation_clone'+animalID).querySelector('#jform_sampling').addEventListener("change", function(){selectSampling(animalID);}, false);
  document.getElementById('div_observation_clone'+animalID).querySelector('#jform_photos').addEventListener("change", function(){selectPhotos(animalID);}, false);
  document.getElementById('div_observation_clone'+animalID).querySelector('#jform_observation_species_common_name').addEventListener("change", function(){selectSpecies(animalID,this.value);}, false);
}

function selectStrandingType(){
  document.getElementById('jform_observation_number').disabled=event.target.value==='en groupe'?false:true;
  document.getElementById('jform_observation_number').value=1;
}

function toogleSpeciesChoice(){
  var isChecked = document.getElementById('div_observation_clone1').querySelector('#observation_sp_always_the_same').checked;
  var cname = document.getElementById('div_observation_clone1').querySelector('#jform_observation_species_common_name').value;
  var genus = document.getElementById('div_observation_clone1').querySelector('#jform_observation_species_genus').value;
  var species = document.getElementById('div_observation_clone1').querySelector('#jform_observation_species').value;

  for(var i=2;i<=nanimals;i++){
    document.getElementById('div_observation_clone'+i).querySelector('#jform_observation_species_common_name').disabled=isChecked?true:false;
    if(isChecked){
      document.getElementById('div_observation_clone'+i).querySelector('#jform_observation_species_common_name').value=cname;
      selectSpecies(i,cname);
    }
  }
}

function selectDeadOrAlive(animalID){
  displayBlock('dead_field_'+animalID, event.target.value==='Mort'?true:false); 
  displayBlock('alive_field_'+animalID, event.target.value==='Mort'?false:true);
}

function selectAlive(value,animalID){
  if(value.target.checked !==undefined){
    displayBlock('released_field_'+animalID, value.target.checked); 
  }
}

function selectToothOrBaleenOrDefenses(animalID){
  displayBlock('tooth_field_'+animalID, event.target.value==='Dents'?true:false);
  displayBlock('baleen_field_'+animalID, event.target.value==='Fanons'?true:false);
}

function selectSampling(animalID){
  displayBlock('stockage_location_field_'+animalID, event.target.value==='Oui'?true:false); 
  displayBlock('label_references_field_'+animalID, event.target.value==='Oui'?true:false);
}

function selectPhotos(animalID){
  displayBlock('upload_photos_field_'+animalID, event.target.value==='Oui'?true:false); 
}

function selectSpecies(animalID,commonName) {
  let value = species.filter(val => val[1]===commonName) ? species.filter(val => val[1]===commonName)[0]:null;
  if(value){          
    document.getElementById('div_observation_clone'+animalID).querySelector('#jform_observation_species_genus').value = value[2];
    document.getElementById('div_observation_clone'+animalID).querySelector('#jform_observation_species').value = value[3];

    if((species.filter(val=>val[0]==='inconnu').map(val => val[1]).includes(value[1]) ) ||
     (species.filter(val=>val[0]==='cetace').map(val => val[1]).includes(value[1]))) {
      displayBlock('no_sp_selected_'+animalID,false);
      displayBlock('cetace_measures_'+animalID, true);
      displayBlock('dugong_measures_'+animalID, false);
    }
    else if(species.filter(val=>val[0]==='dugong').map(val => val[1]).includes(value[1]) ) {
      displayBlock('no_sp_selected_'+animalID,false);
      displayBlock('cetace_measures_'+animalID, false);
      displayBlock('dugong_measures_'+animalID, true);
    }

    if(animalID===1 && document.getElementById('div_observation_clone1').querySelector('#observation_sp_always_the_same').checked){
      toogleSpeciesChoice();
    }

  }
}

function saveAnimals(nanimals){
  for(i=1;i<=nanimals;i++){
    saveAnimal(i,nanimals);
  }
}

function saveAnimal(id,nanimals){
  if(!animals[id]){
    animals[id]=[];
  }
  if(id===1 && nanimals>1){
    animals[id]['sp_same']=document.getElementById('div_observation_clone'+id).querySelector('#observation_sp_always_the_same').checked;
  }    
  console.log('div_observation_clone'+id);

  animals[id]['species_common_name']=document.getElementById('div_observation_clone'+id).querySelector('#jform_observation_species_common_name').value;
  animals[id]['species_genus']=document.getElementById('div_observation_clone'+id).querySelector('#jform_observation_species_genus').value;
  animals[id]['species_species']=document.getElementById('div_observation_clone'+id).querySelector('#jform_observation_species').value;
  console.log(document.getElementById('div_observation_clone'+id).querySelector('#jform_observation_species_identification'));
  animals[id]['species_species']=document.getElementById('div_observation_clone'+id).querySelector('#jform_observation_species_identification').value;
  console.log(animals);
}

function loadAnimal(id){
  if(id===1 && nanimals>1){    
    document.getElementById('div_observation_clone'+id).querySelector('#observation_sp_always_the_same').checked = animals[id]['sp_same'] ? animals[id]['sp_same'] : false;
  }
  document.getElementById('div_observation_clone'+id).querySelector('#jform_observation_species_common_name').value = animals[id]['species_common_name'];
  document.getElementById('div_observation_clone'+id).querySelector('#jform_observation_species_genus').value = animals[id]['species_genus'];
  document.getElementById('div_observation_clone'+id).querySelector('#jform_observation_species').value = animals[id]['species_species'];
  document.getElementById('div_observation_clone'+id).querySelector('#jform_observation_species_identification').value=animals[id]['species_species'];
}

function displayBlock(div, affiche) { 
  document.getElementById(div).style.display = affiche ? 'block' : 'none';
}

function toggleContainer(name) {
  var e = document.getElementById(name);// MooTools might not be available ;)
  e.style.display = e.style.display === 'none' ? 'block' : 'none';
}

// Créer un(e) élément/balise dans un bloc
function create_element(element, parent) {
  var x = document.createElement(element);
  x.className = "block_indices";
  var x1 = document.getElementById(parent);
  x1.appendChild(x);  
}

// Change la valeur présente dans l'élément
function change_node_value(element, node) {
  var e = document.getElementsByClassName(element);
  for(var i = 0; i < e.length; i++) {
    e[i].html(node);
  }
}

// Fonction de conversion latitude en degré minute décimal
function convert_Lat_DMD(lat) {
  var lat_dir, lat_deg, lat_min;
  lat_dir = lat >= 0 ? 'N' : 'S';
  // Garde la partie entière
  lat_deg = ( Math.abs( parseInt( lat ) ) );
  lat_min = ( Math.abs( ( Math.abs( lat ) - lat_deg ) * 60 ) );
  //    176 code ascci du degré. Ne garde que 3 décimales
  return lat_deg +  '&deg;' + lat_min.toFixed(3) + '&apos;' + lat_dir;
}

// Fonction de conversion longitude en degré minute décimal
function convert_Lng_DMD(long){
  var long_dir, long_deg, long_min;
  long_dir = long >= 0 ? 'E' : 'W';
  // Garde la partie entière
  long_deg = ( Math.abs( parseInt( long ) ) );
  long_min = ( Math.abs( ( Math.abs( long ) - long_deg ) * 60 ) );
  //    176 code ascci du degré. Ne garde que 3 décimales
  return long_deg + '&deg;' + long_min.toFixed(3) +  '&apos;' + long_dir;
}

function toogleInformant() {
  event.preventDefault();
  toggleContainer('informant_field');
  toggleContainer('informantShow');
  toggleContainer('informantHide');
}

function toogleAnimal(tabId,idn) {
  event.preventDefault();
  if(document.getElementById('caret_'+idn).className.contains('fa-caret-right')){
    displayTab(tabId,idn);
    document.getElementById('caret_'+idn).className="fa fa-caret-down";
  } else {
    displayBlock("div_identification_"+idn, false);
    displayBlock("div_animal_"+idn, false);
    displayBlock("div_mesurements_"+idn, false);
    document.getElementById('caret_'+idn).className="fa fa-caret-right";
    document.getElementById('identification_'+idn).disabled = false;
    document.getElementById('animal_'+idn).disabled = false;
    document.getElementById('mesurements_'+idn).disabled = false;
  }
}
function checkTab(tab,tabId,idn){
  event.preventDefault(); 
  var isValide = document.formvalidator.isValid(document.getElementById('div_'+tab+'_'+idn));
  return isValide && tabId ? displayTab(tabId,idn):(isValide ? toogleAnimal(tab,idn):null);
}
function displayTab(tabId) {
  event.preventDefault(); 
  console.log(tabId);
  var tabs=['identification','animal','mesurements'];
  /*if(document.getElementById('caret_'+idn).className.contains('fa-caret-right')){
    document.getElementById('caret_'+idn).className="fa fa-caret-down";
  }
  tabs.forEach(function(tab){
    displayBlock("div_"+tab+'_'+idn, tabId===tab ? true:false);
    document.getElementById(tab+'_'+idn).disabled = tabId===tab ? true:false;
  });
}
/*function showMe(value){
  event.preventDefault(); 
  console.log("toto");
  console.log(value);
}*/

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
          </div>
        </div>
        <div id="lat_dmd" class="col-md-6 col-md-6 col-xs-12" style="display: none;">
          <div class="input-group">
            <span class="input-group-addon"></span>
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
          </div>
        </div>
        <div id="lng_dmd" class="col-md-6 col-md-6 col-xs-12" style="display: none;">
          <div class="input-group">
            <span class="input-group-addon"></span>
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
      <div id="global_animals">         
          <?php include 'observation.php' ?>
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

