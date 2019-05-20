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
$document = JFactory::getDocument();
$url = JUri::base() . 'components/com_stranding_forms/views/stranding_admin/tmpl/stranding.css';
$document->addStyleSheet($url);
?>
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
    
    var map;
    function initMap(lat,lng,zoom) {
        var div = document.getElementById("map");
        var coord=ol.proj.fromLonLat([lng,lat]);
        var feature = new ol.Feature(
            new ol.geom.Point(coord)
        );
        feature.setStyle(new ol.style.Style({
                image: new ol.style.Icon(({
                  anchor: [0.5, 46],
                    anchorXUnits: 'fraction',
                    anchorYUnits: 'pixels',
                    size: [48, 48],
                    opacity: 1,
                    src: 'http://oreanet.ird.nc/images/map-icon-red.png'
                }))
            }));
        var map = new ol.Map({
            layers: [
              new ol.layer.Tile({
                  source: new ol.source.BingMaps({
                    key: 'AiY3BBonUo3ah7DOGnW3raeuGcP84sw1ekzjCIYHYXRYOEWI73K5tcsGho2EdxEa',
                    imagerySet:'AerialWithLabels'
                  }),
                  title: 'Satellite base',
                  type: 'base',
                }),
              new ol.layer.Vector({
                source: new ol.source.Vector({
                  features: [feature]
                })
              })
            ],
            target: 'map',
            view: new ol.View({
              center: coord,
              zoom: 12
            })
          });
    
    }
     getScript('https://cdnjs.cloudflare.com/ajax/libs/openlayers/3.17.1/ol.js',function() {
        js = jQuery.noConflict();
        js(document).ready(function(){
            var latitude = document.getElementById("latitude").innerText;
            var longitude = document.getElementById("longitude").innerText;
        if(!isNaN(parseFloat(latitude)) && !isNaN(parseFloat(longitude))){
            initMap(parseFloat(latitude),parseFloat(longitude),12);     
        } else {
            initMap(-21.5, 165.5, 5);
        }
        });
    });

    function hideData() {
    	document.getElementById("squeaker").style.visibility = "hidden";
    }

    function display(animal_id,element) {
        jQuery('[class*=animal]').hide();
        jQuery('[class*=animal'+animal_id+']').show();
        jQuery(element).parent().find("button").each(function() {
            jQuery(this).removeClass('selected');
        });
        jQuery(element).addClass('selected');
    }


</script>
<?php
//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_stranding_forms', JPATH_ADMINISTRATOR);

?>
<?php if ($this->item) : ?>
	<div class="col-xs-12" >
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="fa fa-caret-right fa-3x panel-title"><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_ID'); ?>: <?php echo $this->item->id; ?></h3>
			</div>
			<div class="panel-body">
				
				<div class="row">
                    <!--Observer contacts-->
					<div class="groups <?php echo empty($this->item->informant_name) ? 'col-md-12 col-lg-12' : 'col-md-6 col-lg-6'?>">
                        <h5 class="fa fa-user fa-2x"> <?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVER') ?></h5>
                        <div>
                            <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_NAME'); ?></label>
                            <span><?php echo $this->item->observer_name; ?></span>
                        </div>
                        <div style="display:<?php echo empty($this->item->observer_address) ? 'none' : 'flex'; ?>">
                            <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_ADDRESS'); ?></label>
                            <span><?php echo $this->item->observer_address; ?></span>
                        </div>
                       <div style="display:<?php echo empty($this->item->observer_tel) ? 'none' : 'flex'; ?>">
                            <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_TEL'); ?></label>
                            <span><?php echo $this->item->observer_tel; ?></span>
                        </div>
                        <div style="display:<?php echo empty($this->item->observer_email) ? 'none' : 'flex'; ?>">
                            <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_EMAIL'); ?></label>
                            <span><?php echo $this->item->observer_email; ?></span>
                        </div>						
					</div>
                    <!--Informant contacts-->
                    <div class="col-md-6 col-lg-6 groups" style="display:<?php echo empty($this->item->informant_name) ? 'none' : 'flex'; ?>">
                        <h5 class="fa fa-user fa-2x"> <?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_INFORMANT') ?></h5>
                        <div>
                            <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_NAME'); ?></label>
                            <span><?php echo $this->item->informant_name; ?></span>
                        </div>
                        <div style="display:<?php echo empty($this->item->observer_address) ? 'none' : 'flex'; ?>">
                            <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_ADDRESS'); ?></label>
                            <span><?php echo $this->item->informant_address; ?></span>
                        </div>
                        <div style="display:<?php echo empty($this->item->observer_tel) ? 'none' : 'flex'; ?>">
                            <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_TEL'); ?></label>
                            <span><?php echo $this->item->informant_tel; ?></span>
                        </div>
                        <div style="display:<?php echo empty($this->item->observer_email) ? 'none' : 'flex'; ?>">
                            <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_EMAIL'); ?></label>
                            <span><?php echo $this->item->informant_email; ?></span>
                        </div>                      
                    </div>

				</div>
				
				<div class="row">
					<div class=" col-md-6 col-lg-6 groups">
                        <h5 class="fa fa-eye fa-2x"> <?php echo JText::_('COM_STRANDING_FORMS_FORM_DESC_STRANDING_ADMIN_OBSERVATION_LOCATION') ?></h5>
                        <div>
                            <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_DATE'); ?></label>
                            <span><?php echo $this->item->observation_datetime; ?></span>
                        </div>
                        <div style="display:<?php echo empty($this->item->observation_location) ? 'none' : 'flex'; ?>">
                            <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_LOCATION'); ?></label>
                            <span><?php echo $this->item->observation_location; ?></span>
                        </div>
                        <div style="display:<?php echo empty($this->item->observation_localisation) ? 'none' : 'flex'; ?>">
                            <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_DESC_STRANDING_ADMIN_OBSERVATION_LOCATION'); ?></label>
                            <span><?php echo $this->item->observation_localisation; ?></span>
                        </div>
                        <div style="display:<?php echo empty($this->item->observation_region) ? 'none' : 'flex'; ?>">
                            <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_REGION'); ?></label>
                            <span><?php echo $this->item->observation_region; ?></span>
                        </div>
                        <div style="display:<?php echo empty($this->item->observation_country) ? 'none' : 'flex'; ?>">
                            <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_COUNTRY'); ?></label>
                            <span><?php echo $this->item->observation_country; ?></span>
                        </div>
                        <div style="display:<?php echo empty($this->item->observation_latitude) ? 'none' : 'flex'; ?>">
                            <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_LATITUDE'); ?></label>
                            <span id="latitude"><?php echo $this->item->observation_latitude; ?></span>
                        </div>
                        <div style="display:<?php echo empty($this->item->observation_longitude) ? 'none' : 'flex'; ?>">
                            <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_LONGITUDE'); ?></label>
                            <span id="longitude"><?php echo $this->item->observation_longitude; ?></span>
                        </div>
                    </div>
                    <div class=" col-md-6 col-lg-6 groups">
                        <div id="map" style="height:400px"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12 groups">
                        <h5 class="fa fa-ship fa-2x"> <?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_STRANDING_TYPE') ?></h5>
                        <div>
                            <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_STRANDING_TYPE'); ?></label>
                            <span><?php echo $this->item->observation_stranding_type; ?></span>
                        </div>
                        <div style="display:<?php echo empty($this->item->observation_number) ? 'none' : 'flex'; ?>">
                            <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_NUMBER'); ?></label>
                            <span><?php echo $this->item->observation_number; ?></span>
                        </div>
                    </div>
                </div>
                <div class="row tabs">
                    <div class="col-md-12 col-lg-12 tab btn-toolbar">
                    <?php foreach ($this->item->animal_form as $key => $animal) {  ?>                        
                            <button onclick="display(<?php echo $key ?>,this)" class="fa fa-one fa-2x <?php echo ($key===0?'selected':'') ?>"> <?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_ANIMAL') ?> <?php echo intval($key)+1; ?></button>                        
                    <?php } ; ?> 
                    </div>
                    <?php foreach ($this->item->animal_form as $key => $animal) {  ?>
                    <div class="animal<?php echo $key ?>">
                        <div class="col-md-12 col-lg-12 groups">
                            <div>
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_SPECIES'); ?></label>
                                <span><?php echo $animal->observation_species_genus; ?> <?php echo $animal->observation_species; ?></span>
                                <span><?php echo $animal->observation_species_common_name; ?></span>
                            </div>
                            <div style="display:<?php echo empty($animal->observation_species_identification) ? 'none' : 'flex'; ?>">
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_SPECIES_IDENTIFICATION'); ?></label>
                                <span><?php echo $animal->observation_species_identification; ?></span>
                            </div>                      
                            <div>
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_SEX'); ?></label>
                                <span><?php echo $animal->observation_sex; ?></span>
                            </div>
                            <div style="display:<?php echo empty($animal->observation_color) ? 'none' : 'flex'; ?>">
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_COLOR'); ?></label>
                                <span><?php echo $animal->observation_color; ?></span>
                            </div>
                            <div>
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_CAUDAL'); ?></label>
                                <span><?php echo $animal->observation_caudal; ?></span>
                            </div>
                            <div style="display:<?php echo empty($animal->observation_beak_or_furrows) ? 'none' : 'flex'; ?>">
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_BEAK_OR_FURROWS'); ?></label>
                                <span><?php echo $animal->observation_beak_or_furrows; ?></span>
                            </div>
                            <div>
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_TOOTH_OR_BALEEN_OR_DEFENSES'); ?></label>
                                <span><?php echo $animal->observation_tooth_or_baleen_or_defenses; ?></span>
                            </div>
                            <div style="display:<?php echo ($animal->observation_tooth_or_baleen_or_defenses == JText::_('OBSERVATION_TOOTH')) ? 'flex' : 'none'; ?>">
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_TEETH_UPPER_LEFT'); ?></label>
                                <span><?php echo $animal->nb_teeth_upper_left; ?></span>
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_TEETH_UPPER_RIGHT'); ?></label>
                                <span><?php echo $animal->nb_teeth_upper_right; ?></span>
                            </div>
                            <div style="display:<?php echo ($animal->observation_tooth_or_baleen_or_defenses == JText::_('OBSERVATION_TOOTH')) ? 'flex' : 'none'; ?>">
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_TEETH_LOWER_LEFT'); ?></label>
                                <span><?php echo $animal->nb_teeth_lower_left; ?></span>
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_TEETH_LOWER_RIGHT'); ?></label>
                                <span><?php echo $animal->nb_teeth_lower_right; ?></span>
                            </div>
                            <div style="display:<?php echo ($animal->observation_tooth_or_baleen_or_defenses == JText::_('OBSERVATION_TOOTH')) ? 'flex' : 'none'; ?>">
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_TEETH_BASE_DIAMETRE'); ?></label>
                                <span><?php echo $animal->observation_teeth_base_diametre; ?></span>
                            </div>
                            <div style="display:<?php echo ($animal->observation_tooth_or_baleen_or_defenses == JText::_('OBSERVATION_BALEEN')) ? 'flex' : 'none'; ?>">
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_BALEEN_COLOR'); ?></label>
                                <span><?php echo $animal->nb_teeth_lower_left; ?></span>
                            </div>
                            <div style="display:<?php echo ($animal->observation_tooth_or_baleen_or_defenses == JText::_('OBSERVATION_BALEEN')) ? 'flex' : 'none'; ?>">
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_BALEEN_HEIGHT'); ?></label>
                                <span><?php echo $animal->observation_baleen_height; ?></span>
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_BALEEN_BASE_HEIGHT'); ?></label>
                                <span><?php echo $animal->observation_baleen_base_height; ?></span>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12 groups">
                            <div>
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_SIZE'); ?></label>
                                <span><?php echo $animal->observation_size; ?></span>
                                <span><?php echo $animal->observation_size_precision; ?></span>
                            </div>
                            <div>
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_ABNORMALITIES'); ?></label>
                                <span><?php echo $animal->observation_abnormalities; ?></span>
                            </div>
                            <div>
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_CAPTURE_TRACES'); ?></label>
                                <span><?php echo $animal->observation_capture_traces; ?></span>
                            </div>
                            <div style="display:<?php echo empty($animal->catch_indices) ? 'none' : 'flex'; ?>">
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_CATCH_INDICES'); ?></label>
                                <span><?php echo $animal->catch_indices; ?></span>
                            </div>
                            <div>
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_DEAD_OR_ALIVE'); ?></label>
                                <span><?php echo $animal->observation_dead_or_alive; ?></span>
                            </div>
                            <div style="display:<?php echo ($animal->observation_dead_or_alive === 'Mort') ? 'flex' : 'none'; ?>">
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_DEATH'); ?></label>
                                <span><?php echo $animal->observation_datetime_death; ?></span>
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_DEATH_DATE'); ?></label>
                                <span><?php echo $animal->observation_datetime_death; ?></span>
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_DEAD_DECOMPOSITION'); ?></label>
                                <span><?php echo $animal->observation_state_decomposition; ?></span>
                            </div>
                            <div style="display:<?php echo ($animal->observation_dead_or_alive === 'Vivant') ? 'flex' : 'none'; ?>">
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_ALIVE_ALIVE'); ?></label>
                                <span><?php echo $animal->observation_alive; ?></span>
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_ALIVE_DATETIME_RELEASE'); ?></label>
                                <span><?php echo $animal->observation_datetime_release; ?></span>
                            </div>
                            <div style="display:<?php echo empty($animal->sampling) ? 'none' : 'flex'; ?>">
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_SAMPLING'); ?></label>
                                <span><?php echo $animal->sampling; ?></span>
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_SAMPLING_PROTOCOL'); ?></label>
                                <span><?php echo $animal->sampling_protocole; ?></span>
                            </div>
                            <div style="display:<?php echo empty($animal->label_references) ? 'none' : 'flex'; ?>">
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_LABEL_REFERENCES'); ?></label>
                                <span><?php echo $animal->label_references; ?></span>
                            </div>
                            <div>
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_RELEASE_TISSUE_REMOVAL'); ?></label>
                                <span><?php echo $animal->observation_tissue_removal_dead; ?></span>
                                <span><?php echo $animal->observation_tissue_removal_alive; ?></span>
                            </div>
                            <div>
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_OBSERVATION_PHOTOS'); ?></label>
                                <span><?php echo $animal->photos; ?></span>
                                <span><?php echo $animal->upload_photos; ?></span>
                            </div>
                        </div>
                        <div class="hgroups">
                            <div class="col-md-12 col-lg-12" style="display:flex;">
                                <!-- DAUPHINS -->
                                <div class="col-md-6 col-lg-6" style="display:<?php echo ($animal->observation_species_genus=='Dugong' || $animal->observation_species_genus=='Arctophoca') ? 'none' : 'flex'; ?>">
                                    <img src='/administrator/components/com_stranding_forms/assets/images/dolphin/large/l_dolphin_body.png' alt='Mesures sur cétacés' title='<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_CETACE_IMAGE_DESC'); ?>' />
                                </div>
                                <div class="col-md-6 col-lg-6 flex-centre" style="display:<?php echo ($animal->observation_species_genus=='Dugong' || $animal->observation_species_genus=='Arctophoca') ? 'none' : 'flex'; ?>">
                                    <div>
                                        <label class="mesure important"><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_A'); ?></label>
                                        <span><?php echo $animal->observation_mesure_a; ?></span>
                                    </div>
                                    <div>
                                        <label class="mesure important"><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_B'); ?></label>
                                        <span><?php echo $animal->observation_mesure_b; ?></span>
                                    </div>
                                    <div>
                                        <label><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_C'); ?></label>
                                        <span><?php echo $animal->observation_mesure_c; ?></span>
                                    </div>
                                    <div>
                                        <label><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_D'); ?></label>
                                        <span><?php echo $animal->observation_mesure_d; ?></span>
                                    </div>
                                    <div>
                                        <label class="mesure important"><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_E'); ?></label>
                                        <span><?php echo $animal->observation_mesure_e; ?></span>
                                    </div>
                                    <div>
                                        <label><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_F'); ?></label>
                                        <span><?php echo $animal->observation_mesure_f; ?></span>
                                    </div>
                                    <div>
                                        <label class="mesure important"><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_G'); ?></label>
                                        <span><?php echo $animal->observation_mesure_g; ?></span>
                                    </div>
                                    <div>
                                        <label><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_H'); ?></label>
                                        <span><?php echo $animal->observation_mesure_h; ?></span>
                                    </div>
                                    <div>
                                        <label class="mesure important"><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_I'); ?></label>
                                        <span><?php echo $animal->observation_mesure_i; ?></span>
                                    </div>
                                    <div>
                                        <label class="mesure important"><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_J'); ?></label>
                                        <span><?php echo $animal->observation_mesure_j; ?></span>
                                    </div>
                                    <div>
                                        <label><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_K'); ?></label>
                                        <span><?php echo $animal->observation_mesure_k; ?></span>
                                    </div>
                                    <div>
                                        <label><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_L'); ?></label>
                                        <span><?php echo $animal->observation_mesure_l; ?></span>
                                    </div>
                                    <div>
                                        <label><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_M'); ?></label>
                                        <span><?php echo $animal->observation_mesure_m; ?></span>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-12 col-lg-12" style="display:flex;">
                                <!-- dauphin -->                                
                                <div class="col-md-6 col-lg-6" style="display:<?php echo ($animal->observation_species_genus=='Dugong' || $animal->observation_species_genus=='Arctophoca') ? 'none' : 'flex'; ?>">
                                    <img src='/administrator/components/com_stranding_forms/assets/images/dolphin/large/l_dolphin_details.png' alt='Mesures sur cétacés' title='<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_CETACE_IMAGE_DESC'); ?>' />
                                </div>
                                <div class="col-md-6 col-lg-6 flex-centre" style="display:<?php echo ($animal->observation_species_genus=='Dugong' || $animal->observation_species_genus=='Arctophoca') ? 'none' : 'flex'; ?>">
                                    <div>
                                        <label><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_N'); ?></label>
                                        <span><?php echo $animal->observation_mesure_n; ?></span>
                                    </div>
                                    <div>
                                        <label><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_O'); ?></label>
                                        <span><?php echo $animal->observation_mesure_o; ?></span>
                                    </div>
                                    <div>
                                        <label class="mesure important"><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_P'); ?></label>
                                        <span><?php echo $animal->observation_mesure_p; ?></span>
                                    </div>
                                    <div>
                                        <label class="mesure important"><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_Q'); ?></label>
                                        <span><?php echo $animal->observation_mesure_q; ?></span>
                                    </div>
                                    <div>
                                        <label class="mesure important"><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_R'); ?></label>
                                        <span><?php echo $animal->observation_mesure_r; ?></span>
                                    </div>
                                    <div>
                                        <label><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_S'); ?></label>
                                        <span><?php echo $animal->observation_mesure_s; ?></span>
                                    </div>
                                    <div>
                                        <label><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_T'); ?></label>
                                        <span><?php echo $animal->observation_mesure_t; ?></span>
                                    </div>
                                    <div>
                                        <label><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_U'); ?></label>
                                        <span><?php echo $animal->observation_mesure_u; ?></span>
                                    </div>
                                    <div>
                                        <label><?php echo JText::_('OBSERVATION_DOLPHIN_MESURES_V'); ?></label>
                                        <span><?php echo $animal->observation_mesure_v; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12 groups">                            
                            <div>
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_REMARKS'); ?></label>
                                <span><?php echo $animal->remarks; ?></span>
                            </div>
                            <div>
                                <label><?php echo JText::_('COM_STRANDING_FORMS_FORM_LBL_STRANDING_ADMIN_ADMIN_VALIDATION'); ?></label>
                                <span><?php if(!$this->item->admin_validation){ ?><span class="fa fa-square-o"> <?php } else { ?> <span class="fa fa-check"></span><?php } ?></span></span>
                            </div>
                        </div>
                    </div>
                    <?php } ; ?>   
                </div>
					</div>
				</div>
			</div>
		</div>

								<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_stranding_forms&task=stranding_admin.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_STRANDING_FORMS_EDIT_ITEM"); ?></a>


								<a class="btn btn-primary" href="javascript:document.getElementById('form-stranding-admin-delete-<?php echo $this->item->id ?>').submit()"><?php echo JText::_("COM_STRANDING_FORMS_DELETE_ITEM"); ?></a>
								<form id="form-stranding-admin-delete-<?php echo $this->item->id; ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_stranding_forms&task=stranding-admin.remove'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
									<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
									<input type="hidden" name="option" value="com_stranding_forms" />
									<input type="hidden" name="task" value="stranding_admin.remove" />
									<?php echo JHtml::_('form.token'); ?>
								</form>

								<?php if(!$this->item->admin_validation){ ?>
									<a class="btn btn-primary" href="javascript:document.getElementById('form-stranding-admin-validate-<?php echo $this->item->id; ?>').submit()"><?php echo JText::_("COM_STRANDING_FORMS_VALIDATE_ITEM"); ?></a>
									<form id="form-stranding-admin-validate-<?php echo $this->item->id; ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_stranding_forms&task=stranding_admin.validate'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
										<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
										<input type="hidden" name="option" value="com_stranding_forms" />
										<input type="hidden" name="task" value="stranding_admin.validate" />
										<?php echo JHtml::_('form.token'); ?>
									</form>
								<?php } ?>


								<?php
							else:
								echo JText::_('COM_STRANDING_FORMS_ITEM_NOT_LOADED');
							endif;
							?>
