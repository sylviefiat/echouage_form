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
?>

<style>
  #show_tail_fin_image {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
    cursor: help;
  }
  #show_tail_fin_image .tail_fin_image {
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
  #show_tail_fin_image:hover .tail_fin_image {
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
  .tab0 {
    display:block;
  }

</style>

<script type="text/javascript">
  var nanimals = 1;
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
  getScript('https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js',function() {
    js = jQuery.noConflict();
    
    js(document).ready(function() {
      // fix tooltip conflict with mootools
      js('.hasTooltip').each(function(){this.show = null; this.hide = null;}); 
          
      // set dmd value from lat
      js('#jform_observation_latitude').on('change',function() {
        var lat = this.value;
        var lat_dmd = document.getElementById('jform_observation_latitude_dmd').value;
        lat_dmd = convert_Lat_DMD(lat);
      });
      // set dmd value for lon
      js('#jform_observation_longitude').on('change', function() {
        var lng = this.value;
        var lng_dmd = document.getElementById('jform_observation_longitude_dmd').value;
        lng_dmd = convert_Long_DMD(lng);
      });

      js("#jform_observation_stranding_type0").click(function() {
        js('#jform_observation_number').prop('disabled', true);
        js('#jform_observation_number:disabled').val(1);
      });
      js("#jform_observation_stranding_type1").click(function() {
        js('#jform_observation_number').prop('disabled', false);
      });
      js("#jform_observation_dead_or_alive0").on('click', function() {
        displayBlock('dead_field', true); 
        displayBlock('alive_field', false);
      });
      js("#jform_observation_dead_or_alive1").on('click', function() {
        displayBlock('dead_field', false); 
        displayBlock('alive_field', true);
      });
      js("#jform_observation_alive").on('click', function(value) {
        if(value.target.checked !==undefined){
          displayBlock('released_field', value.target.checked); 
        }
      });
      js("#jform_observation_tooth_or_baleen_or_defenses0").on('click', function() {
        displayBlock('tooth_field',true); 
        displayBlock('baleen_field',false);
      });
      js("#jform_observation_tooth_or_baleen_or_defenses1").on('click', function() {
        displayBlock('tooth_field',false); 
        displayBlock('baleen_field',true);
      });
      js("#jform_observation_tooth_or_baleen_or_defenses2").on('click', function() {
        displayBlock('tooth_field',false); 
        displayBlock('baleen_field',false);
      });
      js("#jform_sampling0").on('click', function() {
        displayBlock('stockage_location_field',true); 
        displayBlock('label_references_field',true);
      });
      js("#jform_sampling1").on('click', function() {
        displayBlock('stockage_location_field',false); 
        displayBlock('label_references_field',false);
      });
      js("#jform_photos0").on('click', function() {
        displayBlock('upload_photos_field',true);
      });
      js("#jform_photos1").on('click', function() {
        displayBlock('upload_photos_field',false);
      });
      js("#div_show_cetace_measurements_field").on('click', function() {
        toggleContainer("cetace_measures");
      });
      js("#div_show_dugong_measurements_field").on('click', function() {
        toggleContainer("dugong_measures");
      }); 

      // Démasque le bouton pour le clonage si nombre > 1
      js('#jform_observation_number').change(function() {
        nanimals = this.value;        
      });
      
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

      js('#jform_observation_species_common_name').change(function(event) {
        console.log(event);
        selectSpecies(species,this.value);
      });

      var cloneId = 1;
      
    });
});


// Si 'affiche' est vraie alors on affiche le block choisi, sinon on le masque // Affiche et masque le block au click

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
function convert_Long_DMD(long){
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
  toggleContainer('informantHide')
}

function displayTab(tabId) {
  event.preventDefault();
  var tabs=['identification','animal','mesurements'];
  tabs.forEach(function(tab){
    displayBlock("div_"+tab, tabId===tab ? true:false);
    document.getElementById(tab).disabled = tabId===tab ? true:false;
  })
}

function selectSpecies(species,commonName) {
  let value = species.filter(val => val[1]===commonName) ? species.filter(val => val[1]===commonName)[0]:null;
  if(value){
    document.getElementById('jform_observation_species_genus').value = value[2];
    document.getElementById('jform_observation_species').value = value[3];

    if((species.filter(val=>val[0]==='inconnu').map(val => val[1]).includes(value[1]) ) ||
     (species.filter(val=>val[0]==='cetace').map(val => val[1]).includes(value[1]))) {
      displayBlock('no_sp_selected',false);
      displayBlock('cetace_measures', true);
      displayBlock('dugong_measures', false);
    }
    else if(species.filter(val=>val[0]==='dugong').map(val => val[1]).includes(value[1]) ) {
      displayBlock('no_sp_selected',false);
      displayBlock('cetace_measures', false);
      displayBlock('dugong_measures', true);
    }
  }
}
</script>

<div class="stranding_admin-edit front-end-edit">
  <?php if (!empty($this->item->id)): ?>
    <h1 class="fa fa-eye fa-3x"> <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_TITLE'); ?> <?php echo $this->item->id; ?></h1>
    <?php else: ?>
      <h1 class="fa fa-eye fa-3x"> <?php echo JText::_('COM_STRANDING_FORMS_STRANDING_ADMIN_ADD_ITEM_TITLE'); ?></h1>
      <p class="card-subtitle mb-2 text-muted"> <?php echo JText::_('COM_STRANDING_FORMS_STRANDING_ADMIN_ADD_ITEM_DESC'); ?></p>
    <?php endif; ?>

    <form id="form-stranding_admin" action="<?php echo JRoute::_('index.php?option=com_stranding_forms&task=stranding_admin.save'); ?>" method="post" class="form-validate" enctype="multipart/form-data">

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
      <!--Animals-->
      <?php foreach($this->form->getInput('observation_number') as $animal) { ?>
      <div id="div_observation_clone0">
        <span style="/*display: none;*/"><?php echo $this->form->getInput('id_observation'); ?></span>
        
        <div class="tab">
          <span class="tablinks"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_NUMBER');?>&nbsp;<?php echo $animal; ?></span>
          <button class="tablinks" id="identification" onclick="displayTab('identification')"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW3');?></button>
          <button class="tablinks" id="animal" onclick="displayTab('animal')"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW4'); ?></button>
          <button class="tablinks" id="mesurements" onclick="displayTab('mesurements')"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW5'); ?></button>
        </div>
        
        <div id="div_identification" class="tabcontent tab0">
        <!--Identification-->
          <div class="row labels" id="div_identification_title">
            <div class="col-12 stranding_admin-title_row" id="title_R3">
              <h4 class="fa fa-eye fa-2x" id="identification_title"> 
                <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW3');?> 
              </h4>
            </div>
          </div>
          <div class="row groups" id="identification">
            <!-- species common name-->
            <div class="col-lg-12 col-md-12 col-xs-12">
              <?php echo $this->form->getLabel('observation_species_common_name'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon"><span class="fa fa-eye"></span></span>
                <?php echo $this->form->getInput('observation_species_common_name'); ?>
              </div>
            </div>
            <!--species genus-->
            <div class="col-lg-3 col-md-3 col-xs-3">
              <div class="input-group">
                <span class="input-group-addon"><span class="fa fa-eye"></span></span>
                <?php echo $this->form->getInput('observation_species_genus'); ?>
              </div>
            </div>
            <!--species species-->
            <div class="col-lg-3 col-md-3 col-xs-3" >
              <div class="input-group">
                <span class="input-group-addon"><span class="fa fa-eye"></span></span>
                <?php echo $this->form->getInput('observation_species'); ?>
              </div>
            </div>
            <!--species identification-->
            <div class="col-lg-6 col-md-6 col-xs-12 sp_id">
              <div class="form-group">
                <?php echo $this->form->getLabel('observation_species_identification'); ?>
                <br/>
                <?php echo $this->form->getInput('observation_species_identification'); ?>
              </div>
            </div>
            <!--Color-->
            <div class="col-lg-6 col-md-6 col-xs-12">
              <?php echo $this->form->getLabel('observation_color'); ?>
              <div class="input-group">
                <span class="input-group-addon"><span class="fa fa-adjust"></span></span>
                <?php echo $this->form->getInput('observation_color'); ?>
              </div>
            </div>
            <!--Tail fin-->
            <div class="col-lg-6 col-md-6 col-xs-12">
              <div class="form-group">
                <?php echo $this->form->getLabel('observation_caudal'); ?>
                  &nbsp;
                <p id="show_tail_fin_image" name="Tail_Fin_Btn" value="Tail-Fin">
                  <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_SEE_TF_IMAGE'); ?>
                  <img class="tail_fin_image" src="administrator/components/com_stranding_forms/assets/images/s_slot_tail_fin.png" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_TAIL_FIN')?>" />
                </p>
                <?php echo $this->form->getInput('observation_caudal'); ?>                  
              </div>
            </div>
            <!--Beak or furrows-->
            <div class="col-lg-12 col-md-12 col-xs-12">
              <div class="form-group">
                <?php echo $this->form->getLabel('observation_beak_or_furrows'); ?>
                <?php echo $this->form->getInput('observation_beak_or_furrows'); ?>
              </div>
            </div>
            <!--Other caracteristques-->
            <div class="col-lg-12 col-md-12 col-xs-12">
              <div class="form-group">
                <?php echo $this->form->getLabel('observation_tooth_or_baleen_or_defenses'); ?>
                <?php echo $this->form->getInput('observation_tooth_or_baleen_or_defenses'); ?>
              </div>
            </div>
            <!--Tooth-->
            <div class="jform_tooth_baleen col-lg-12 col-md-12 col-xs-12" id="tooth_field" style="display: none;" name="dents[]">
              <div class="col-lg-12 col-md-12 col-xs-12">
                <label id="" class="hasTooltip" title="<?php echo JText::_('OBSERVATION_TOOTH_NUMBER_DESC');?>">
                  <?php echo JText::_('OBSERVATION_TOOTH_NUMBER_LBL');?>
                </label>
              </div>
              <div class="col-lg-12 col-md-12 col-xs-12" style="display:flex">
                <div class="col-lg-6 col-md-6 col-xs-12">
                  <?php echo $this->form->getLabel('nb_teeth_upper_right'); ?>
                  <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-tachometer"></span></span>
                    <?php echo $this->form->getInput('nb_teeth_upper_right'); ?>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-12">
                  <?php echo $this->form->getLabel('nb_teeth_upper_left'); ?>
                  <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-tachometer"></span></span>
                    <?php echo $this->form->getInput('nb_teeth_upper_left'); ?>
                  </div>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-xs-12" style="display:flex">
                <div class="col-lg-6 col-md-6 col-xs-12">
                  <?php echo $this->form->getLabel('nb_teeth_lower_right'); ?>
                  <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-tachometer"></span></span>
                    <?php echo $this->form->getInput('nb_teeth_lower_right'); ?>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-12">
                  <?php echo $this->form->getLabel('nb_teeth_lower_left'); ?>
                  <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-tachometer"></span></span>
                    <?php echo $this->form->getInput('nb_teeth_lower_left'); ?>
                  </div>
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
            <div class="jform_tooth_baleen col-lg-12 col-md-12 col-xs-12" id="baleen_field" style="display: none;" name="fanons[]">
              <div class="col-lg-12 col-md-12 col-xs-12">
                <label id="" class="hasTooltip" title="<?php echo JText::_('OBSERVATION_BALEEN_DESC');?>">
                  <?php echo JText::_('OBSERVATION_BALEEN');?>
                </label>
              </div>
              <div class="col-lg-12 col-md-12 col-xs-12" style="display:flex;">
                <div class="col-lg-4 col-md-9 col-xs-12">
                  <?php echo $this->form->getLabel('observation_baleen_color'); ?>
                  <div class="input-group">
                   <span class="input-group-addon"><span class="fa fa-adjust"></span></span>
                   <?php echo $this->form->getInput('observation_baleen_color'); ?>
                 </div>
                </div>
                <div class="col-lg-4 col-md-6 col-xs-12">
                  <?php echo $this->form->getLabel('observation_baleen_height'); ?>
                  <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-arrows-v"></span></span>
                    <?php echo $this->form->getInput('observation_baleen_height'); ?>
                  </div>
                </div>
                <div class="col-lg-4 col-md-6 col-xs-12">
                  <?php echo $this->form->getLabel('observation_baleen_base_height'); ?>
                  <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-arrows-h"></span></span>
                    <?php echo $this->form->getInput('observation_baleen_base_height'); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--Animal-->
        <div id="div_animal" class="tabcontent">
          <div class="row labels" id="div_animal_title">
            <div class="col-lg-12 col-md-12 col-xs-12" id="title_R4">
              <h4 class="fa fa-shield fa-2x" id="animal_title"> <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW4'); ?> </h4>
            </div>
          </div>
          <div class="row groups" id="animal">
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
                <?php echo $this->form->getInput('observation_size_precision'); ?>
              </div>
            </div>
            <!--Sex-->
            <div class="col-lg-6 col-md-6 col-xs-12">
              <div class="form-group">
                <?php echo $this->form->getLabel('observation_sex'); ?>
                <?php echo $this->form->getInput('observation_sex'); ?>
              </div>
            </div>
            <!--Abnormalities-->
            <div class="col-lg-6 col-md-6 col-xs-12">
              <div class="form-group">
                <?php echo $this->form->getLabel('observation_abnormalities'); ?>
                <?php echo $this->form->getInput('observation_abnormalities'); ?>
              </div>
            </div>
            <!--Capture traces-->
            <div class="col-lg-6 col-md-6 col-xs-12">
              <div class="form-group">
                <?php echo $this->form->getLabel('observation_capture_traces'); ?>
                <?php echo $this->form->getInput('observation_capture_traces'); ?>
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
            <!--Sampling & photos-->
            <div class="col-lg-12 col-md-12 col-xs-12">
              <div class="form-group">
                <?php echo $this->form->getLabel('sampling'); ?>
                <?php echo $this->form->getInput('sampling'); ?>
              </div>
            </div>        
            <!--Stockage location-->
            <div id="stockage_location_field" class="col-lg-6 col-md-6 col-xs-12 stck_loca_field" style="display: none;">
              <?php echo $this->form->getLabel('observation_location_stock'); ?>
              <div class="input-group">
                <span class="input-group-addon"><span class="fa fa-archive "></span></span>
                <?php echo $this->form->getInput('observation_location_stock'); ?>
              </div>
            </div>
            <!--Label references-->
            <div id="label_references_field" class="col-lg-6 col-md-6 col-xs-12" style="display: none;">
              <?php echo $this->form->getLabel('label_references'); ?>
              <div class="input-group">
                <span class="input-group-addon"><span class="fa fa-tag"></span></span>
                <?php echo $this->form->getInput('label_references'); ?>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
              <div class="form-group">
                <?php echo $this->form->getLabel('photos'); ?>
                <?php echo $this->form->getInput('photos'); ?>
              </div>
            </div>
            <!--Upload photos-->
            <div id="upload_photos_field" class="col-lg-6 col-md-6 col-xs-12" style="display: none;">
              <?php echo $this->form->getLabel('upload_photos'); ?>
              <div class="input-group">
                <span class="input-group-addon"><span class="fa fa-picture-o "></span></span>
                <?php echo $this->form->getInput('upload_photos'); ?>
              </div>
            </div>
            <!--Dead or Alive-->
            <div class="col-lg-12 col-md-12 col-xs-12">
              <div class="form-group">
                <?php echo $this->form->getLabel('observation_dead_or_alive'); ?>
                <?php echo $this->form->getInput('observation_dead_or_alive'); ?>
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
                  <?php echo $this->form->getInput('observation_death'); ?>
                </div>
              </div>
              <!--Death datetime-->
              <div class="death_datetime col-lg-12 col-md-12 col-xs-12">
                <div class="col-lg-12 col-md-12 col-xs-12"><?php echo $this->form->getLabel('observation_datetime_death'); ?></div>
                <div class="col-lg-4 col-md-6 col-xs-12">
                  <div class="input-group">
                    <span class="input-group-addon exergue com_stranding_forms_date"><span class="fa fa-calendar"></span></span>
                    <div class="btn-group">
                      <div class="input-append">
                        <?php echo $this->form->getInput('observation_datetime_death'); ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--State decomposition-->
              <div class="col-lg-12 col-md-12 col-xs-12"><?php echo $this->form->getLabel('observation_state_decomposition'); ?></div>
              <div class="col-lg-8 col-md-8 col-xs-12">
                <div class="form-group">
                  <?php echo $this->form->getInput('observation_state_decomposition'); ?>
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
          <!--Living animal  -->
            <div class="col-xs-12" id="alive_field" style="display: none;">      
              <div style="display:flex">        
                <div class="col-lg-6 col-md-6 col-xs-12">
                  <label id="jform_dead_animal_label" class="hasTooltip" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_OBSERVATION_LIVING_ANIMAL_DESC');?>">
                    <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_OBSERVATION_LIVING_ANIMAL');?>
                  </label>
                  <div class="form-group">
                    <?php echo $this->form->getInput('observation_alive'); ?>
                  </div>
                </div>
                <!--Release datetime-->
                <div class="release_datetime col-lg-6 col-md-6 col-xs-12" id="released_field" style="display:none;">
                  <div class="col-lg-12 col-md-12 col-xs-12">
                    <?php echo $this->form->getLabel('observation_datetime_release'); ?>
                    <div class="input-group">
                      <span class="input-group-addon exergue com_stranding_forms_date"><span class="fa fa-calendar"></span></span>
                      <div class="btn-group">
                        <div class="input-append">
                          <?php echo $this->form->getInput('observation_datetime_release'); ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
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
          </div>
        </div>
        <!--Measurements-->
        <div id="div_mesurements" class="tabcontent">
          <div class="row labels" id="div_measurements_title">
            <div class="col-lg-12 col-md-12 col-xs-12" id="title_R5">
              <h4 class="fa fa-arrows-h fa-2x" id="measurements_title"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW5'); ?> </h4>
            </div>
          </div>
          <div class="groups" style="flex-direction:column;padding:0 10px;">
            <div id="measurements" class="animal_measures_field">
              <div class="row" id="com_stranding_forms_measurements_info">
                <div class="col-lg-12 col-md-12 col-xs-12" id="mesures_info">
                  <span class="fa fa-info-circle">
                    <label class="info-mesurements"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_INFO_1');?>
                      <strong style="color: red;"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_INFO_RED');?></strong>
                      <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_INFO_2');?>
                    </label>
                  </span>
                </div>
              </div>
              <div id="no_sp_selected" class="col-lg-12 col-md-12 col-xs-12">
                   <?php echo JText::_('COM_STRANDING_FORMS_EDIT_NO_SP_SELECTED'); ?>
              </div>
              <!--Cetaces measurements-->
              <div id="cetace_measures" style="display: none;">
                <div class="col-lg-12 col-md-12 col-xs-12">
                  <label class="hasTooltip" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_IMAGE_DESC'); ?>">
                    <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_DOLPHIN_MESURES_IMAGE'); ?>
                  </label>
                </div>
                <!--Dolphin body-->
                <div class="row" style="display: flex;">
                  <div class="col-lg-6 col-md-6 col-xs-12" id="cetace_measures_position0">
                    <p>
                     <img id="dolphin_image" src="administrator/components/com_stranding_forms/assets/images/dolphin/large/l_dolphin_body.png" alt="Mesures sur cétacés" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_CETACE_IMAGE_DESC'); ?>" />
                   </p>
                  </div>
                  <div class="col-lg-6 col-md-6 col-xs-12">
                    <div id="jform_observation_dolphin_mesures_a_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dolphin_mesures_a'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_a'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dolphin_mesures_b_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dolphin_mesures_b'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_b'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dolphin_mesures_c_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dolphin_mesures_c'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_c'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dolphin_mesures_d_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dolphin_mesures_d'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_d'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dolphin_mesures_e_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dolphin_mesures_e'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_e'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dolphin_mesures_f_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dolphin_mesures_f'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_f'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dolphin_mesures_g_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dolphin_mesures_g'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_g'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dolphin_mesures_h_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dolphin_mesures_h'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_h'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dolphin_mesures_i_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dolphin_mesures_i'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_i'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dolphin_mesures_j_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dolphin_mesures_j'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_j'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dolphin_mesures_k_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dolphin_mesures_k'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_k'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dolphin_mesures_l_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dolphin_mesures_l'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_l'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dolphin_mesures_m_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dolphin_mesures_m'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_m'); ?>
                      </div>
                    </div>
                  </div>
                </div>
                <!--Dolphin member-->
                <div class="row" style="display:flex;">
                  <div class="col-lg-3 col-md-3 col-xs-12" id="cetace_measures_position1">
                    <p>
                      <img id="dolphin_image" src="administrator/components/com_stranding_forms/assets/images/dolphin/large/l_dolphin_pectoral_fin.png" alt="Mesures sur cétacés" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_CETACE_IMAGE_DESC'); ?>" />
                    </p>
                    <div id="jform_observation_dolphin_mesures_n_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dolphin_mesures_n'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_n'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dolphin_mesures_o_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dolphin_mesures_o'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_o'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-3 col-xs-12" id="cetace_measures_position2">
                    <p>
                      <img id="dolphin_image" src="administrator/components/com_stranding_forms/assets/images/dolphin/large/l_dolphin_dorsal_fin.png" alt="Mesures sur cétacés" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_CETACE_IMAGE_DESC'); ?>" />
                    </p>
                    <div id="jform_observation_dolphin_mesures_p_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dolphin_mesures_p'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_p'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dolphin_mesures_r_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dolphin_mesures_r'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_r'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-3 col-xs-12" id="cetace_measures_position3">
                    <p>
                      <img id="dolphin_image" src="administrator/components/com_stranding_forms/assets/images/dolphin/large/l_dolphin_tail_fin.png" alt="Mesures sur cétacés" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_CETACE_IMAGE_DESC'); ?>" />
                    </p>
                    <div id="jform_observation_dolphin_mesures_q_field label_icon mesure_important" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dolphin_mesures_q'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_q'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dolphin_mesures_s_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dolphin_mesures_s'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_s'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-3 col-xs-12" id="cetace_measures_position4">
                    <p>
                      <img id="dolphin_image" src="administrator/components/com_stranding_forms/assets/images/dolphin/large/l_dolphin_bacon_thickness.png" alt="Mesures sur cétacés" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_CETACE_IMAGE_DESC'); ?>" />
                    </p>
                    <div id="jform_observation_dolphin_mesures_t_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dolphin_mesures_t'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_t'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dolphin_mesures_u_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dolphin_mesures_u'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_u'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dolphin_mesures_v_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dolphin_mesures_v'); ?></span>
                        <?php echo $this->form->getInput('observation_dolphin_mesures_v'); ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--Dugongs measurements-->
              <div id="dugong_measures" style="display: none;">
                <div class="col-lg-12 col-md-12 col-xs-12">
                  <label class="hasTooltip" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_IMAGE_DESC'); ?>">
                    <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_DUGONG_MESURES_IMAGE'); ?>            
                  </label>
                </div>
                <!--Dugong body-->
                <div class="row" style="display:flex;">
                  <div class="col-lg-6 col-md-6 col-xs-12" id="dugong_measures_position0">
                    <p>
                      <img id="dugong_image" src="administrator/components/com_stranding_forms/assets/images/dugong/large/l_dugong_body.png" alt="Mesures sur dugongs" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_DUGONG_IMAGE_DESC'); ?>" />
                    </p>
                  </div>
                  <div class="col-lg-6 col-md-6 col-xs-12">
                    <div id="jform_observation_dugong_mesures_a_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dugong_mesures_a'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_a'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dugong_mesures_b_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dugong_mesures_b'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_b'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dugong_mesures_c_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dugong_mesures_c'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_c'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dugong_mesures_d_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dugong_mesures_d'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_d'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dugong_mesures_e_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dugong_mesures_e'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_e'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dugong_mesures_f_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dugong_mesures_f'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_f'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dugong_mesures_g_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dugong_mesures_g'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_g'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dugong_mesures_h_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dugong_mesures_h'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_h'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dugong_mesures_i_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dugong_mesures_i'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_i'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dugong_mesures_j_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dugong_mesures_j'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_j'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dugong_mesures_k_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dugong_mesures_k'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_k'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dugong_mesures_l_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dugong_mesures_l'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_l'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dugong_mesures_m_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dugong_mesures_m'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_m'); ?>
                      </div>
                    </div>
                  </div>
                </div>
                <!--Dugong member-->
                <div class="row" style="display: flex;">
                  <div class="col-lg-3 col-md-3 col-xs-12" id="dugong_measures_position2">
                    <p>
                      <img id="dugong_image" src="administrator/components/com_stranding_forms/assets/images/dugong/large/l_dugong_facial_disck.png" alt="Mesures sur dugongs" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_DUGONG_IMAGE_DESC'); ?>" />
                    </p>
                    <div id="jform_observation_dugong_mesures_n_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dugong_mesures_n'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_n'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dugong_mesures_o_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dugong_mesures_o'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_o'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-3 col-xs-12" id="dugong_measures_position1">
                    <p>
                      <img id="dugong_image" src="administrator/components/com_stranding_forms/assets/images/dugong/large/l_dugong_pectoral_fin.png" alt="Mesures sur dugongs" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_DUGONG_IMAGE_DESC'); ?>" />
                    </p>
                    <div id="jform_observation_dugong_mesures_p_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dugong_mesures_p'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_p'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dugong_mesures_r_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dugong_mesures_r'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_r'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-3 col-xs-12" id="dugong_measures_position3">
                    <p>
                      <img id="dugong_image" src="administrator/components/com_stranding_forms/assets/images/dugong/large/l_dugong_tail_fin.png" alt="Mesures sur dugongs" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_DUGONG_IMAGE_DESC'); ?>" />
                    </p>
                    <div id="jform_observation_dugong_mesures_q_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dugong_mesures_q'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_q'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dugong_mesures_s_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dugong_mesures_s'); ?></span>
                          <?php echo $this->form->getInput('observation_dugong_mesures_s'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-3 col-xs-12" id="dugong_measures_position4">
                    <p>
                      <img id="dugong_image" src="administrator/components/com_stranding_forms/assets/images/dugong/large/l_dugong_bacon_thickness.png" alt="Mesures sur dugongs" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_DUGONG_IMAGE_DESC'); ?>" />
                    </p>
                    <div id="jform_observation_dugong_mesures_t_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dugong_mesures_t'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_t'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dugong_mesures_u_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dugong_mesures_u'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_u'); ?>
                      </div>
                    </div>
                    <div id="jform_observation_dugong_mesures_v_field" class="important_measurements">
                      <div class="input-group">
                        <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dugong_mesures_v'); ?></span>
                        <?php echo $this->form->getInput('observation_dugong_mesures_v'); ?>
                      </div>
                    </div>
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
            </div>
          </div>
        </div>
      </div>
    <?php } ?>

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
</div>
</form>
</div>


