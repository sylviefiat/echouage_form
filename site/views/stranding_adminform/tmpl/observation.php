<?php 
  if(isset($_POST['nanimals'])){
    $nanimals = $_POST['nanimals'];
  }
  for ($n = 1; $n <= $nanimals; $n++) { ?>
  <span style="display: none;"><?php echo $this->form->getInput('id_observation'); ?></span>
  <script type="text/javascript">
    
  </script>
  <div id="<?php echo 'div_observation_clone'.$n ?>">            
    <div class="tab">
      <button class="tablinks" onclick="toogleAnimal('identification',<?php echo $n ?> )">
        <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_NUMBER');?><?php echo $n; ?>&nbsp;<span id="<?php echo 'caret_'.$n ?>" class="<?php if($n===1){ echo 'fa fa-caret-down';}else{echo 'fa fa-caret-right';} ?>"></span>
      </button>
      <button class="tablinks" <?php if($n===1){ echo "disabled";} ?> id="<?php echo 'identification_'.$n ?>" onclick="displayTab('identification',<?php echo $n ?> )">
        <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW3');?>          
      </button>
      <button class="tablinks" id="<?php echo 'animal_'.$n ?>" onclick="displayTab('animal',<?php echo $n ?> )">
        <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW4'); ?>        
      </button>
      <button class="tablinks" id="<?php echo 'mesurements_'.$n ?>" onclick="displayTab('mesurements',<?php echo $n ?> )"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW5'); ?></button>
    </div>
    <!--Identification-->
    <div id="<?php echo 'div_identification_'.$n ?>" class="<?php echo 'tabcontent tab'.$n ?>">        
      <div class="row labels">
        <div class="col-12 stranding_admin-title_row">
          <h4 class="fa fa-eye fa-2x"> 
            <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW3');?> 
          </h4>
        </div>
      </div>
      <div class="row groups" id="<?php echo 'identification'.$n ?>">
        <!-- species common name-->
        <div class="<?php echo ($n===1 && $nanimals >1)? 'col-lg-4 col-md-4 col-xs-6':'col-lg-12 col-md-12 col-xs-12'; ?>">
          <?php echo $this->form->getLabel('observation_species_common_name'); ?>
        </div>
        <!-- species the same for all animals or not - only for animal one-->
        <div class="<?php echo ($n===1 && $nanimals >1)? 'col-lg-8 col-md-8 col-xs-6':'hidden' ?>">
          <input type="checkbox" id="observation_sp_always_the_same" name="observation_sp_always_the_same" value="<?php echo JText::_('COM_STRANDING_FORMS_VALUE_SP_IS_SAME'); ?>">
          <label for="observation_sp_always_the_same"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_SP_IS_SAME'); ?></label>
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
        <div class="jform_tooth_baleen col-lg-12 col-md-12 col-xs-12" id="<?php echo 'tooth_field_'.$n ?>" style="display: none;" name="dents[]">
          <div class="col-lg-12 col-md-12 col-xs-12">
            <label class="hasTooltip" title="<?php echo JText::_('OBSERVATION_TOOTH_NUMBER_DESC');?>">
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
        <div class="jform_tooth_baleen col-lg-12 col-md-12 col-xs-12" id="<?php echo 'baleen_field_'.$n ?>" style="display: none;" name="fanons[]">
          <div class="col-lg-12 col-md-12 col-xs-12">
            <label class="hasTooltip" title="<?php echo JText::_('OBSERVATION_BALEEN_DESC');?>">
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
        <div class="col-lg-12 col-md-12 col-xs-12 text-center">
          <button onclick="displayTab('animal',<?php echo $n ?>)"><?php echo JText::_('NEXT');?> <span class="fa fa-arrow-right"></span></button>
        </div>
      </div>
    </div>
    <!--Animal-->
    <div id="<?php echo 'div_animal_'.$n ?>" class="tabcontent">
      <div class="row labels">
        <div class="col-lg-12 col-md-12 col-xs-12" id="title_R4">
          <h4 class="fa fa-shield fa-2x"> <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW4'); ?> </h4>
        </div>
      </div>
      <div class="row groups" id="<?php echo 'div_animal'.$n ?>">
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
        <div id="<?php echo 'stockage_location_field_'.$n ?>" class="col-lg-6 col-md-6 col-xs-12 stck_loca_field" style="display: none;">
          <?php echo $this->form->getLabel('observation_location_stock'); ?>
          <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-archive "></span></span>
            <?php echo $this->form->getInput('observation_location_stock'); ?>
          </div>
        </div>
        <!--Label references-->
        <div id="<?php echo 'label_references_field_'.$n ?>" class="col-lg-6 col-md-6 col-xs-12" style="display: none;">
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
        <div id="<?php echo 'upload_photos_field_'.$n ?>" class="col-lg-6 col-md-6 col-xs-12" style="display: none;">
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
        <div class="col-xs-12"  id="<?php echo 'dead_field_'.$n ?>" style="display: none;">
          <div class="col-lg-6 col-md-6 col-xs-12">
            <label class="hasTooltip" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_OBSERVATION_DEAD_ANIMAL_DESC');?>">
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
        <div class="col-xs-12" id="<?php echo 'alive_field_'.$n ?>" style="display: none;">      
          <div style="display:flex">        
            <div class="col-lg-6 col-md-6 col-xs-12">
              <label class="hasTooltip" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_OBSERVATION_LIVING_ANIMAL_DESC');?>">
                <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_OBSERVATION_LIVING_ANIMAL');?>
              </label>
              <div class="form-group">
                <?php echo $this->form->getInput('observation_alive'); ?>
              </div>
            </div>
            <!--Release datetime-->
            <div class="release_datetime col-lg-6 col-md-6 col-xs-12" id="<?php echo 'released_field_'.$n ?>" style="display:none;">
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
        <div class="col-lg-12 col-md-12 col-xs-12 text-center">
          <button onclick="displayTab('mesurements',<?php echo $n ?>)"><?php echo JText::_('NEXT');?> <span class="fa fa-arrow-right"></span></button>
        </div>
      </div>
    </div>
    <!--Measurements-->
    <div id="<?php echo 'div_mesurements_'.$n ?>" class="tabcontent">
      <div class="row labels">
        <div class="col-lg-12 col-md-12 col-xs-12">
          <h4 class="fa fa-arrows-h fa-2x"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_ROW5'); ?> </h4>
        </div>
      </div>
      <div class="groups" style="flex-direction:column;padding:0 10px;">
        <div id="<?php echo 'mesurements'.$n ?>" class="animal_measures_field">
          <div class="row" id="com_stranding_forms_measurements_info">
            <div class="col-lg-12 col-md-12 col-xs-12">
              <span class="fa fa-info-circle">
                <label class="info-mesurements"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_INFO_1');?>
                  <strong style="color: red;"><?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_INFO_RED');?></strong>
                  <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_INFO_2');?>
                </label>
              </span>
            </div>
          </div>
          <div id="<?php echo 'no_sp_selected_'.$n ?>" class="col-lg-12 col-md-12 col-xs-12">
            <?php echo JText::_('COM_STRANDING_FORMS_EDIT_NO_SP_SELECTED'); ?>
          </div>
          <!--Cetaces measurements-->
          <div id="<?php echo 'cetace_measures_'.$n ?>" style="display: none;">
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
          <div id="<?php echo 'dugong_measures_'.$n ?>" style="display: none;">
            <div class="col-lg-12 col-md-12 col-xs-12">
              <label class="hasTooltip" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_IMAGE_DESC'); ?>">
                <?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_DUGONG_MESURES_IMAGE'); ?>            
              </label>
            </div>
            <!--Dugong body-->
            <div class="row" style="display:flex;">
              <div class="col-lg-6 col-md-6 col-xs-12"">
                <p>
                  <img src="administrator/components/com_stranding_forms/assets/images/dugong/large/l_dugong_body.png" alt="Mesures sur dugongs" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_DUGONG_IMAGE_DESC'); ?>" />
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
              <div class="col-lg-3 col-md-3 col-xs-12">
                <p>
                  <img src="administrator/components/com_stranding_forms/assets/images/dugong/large/l_dugong_facial_disck.png" alt="Mesures sur dugongs" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_DUGONG_IMAGE_DESC'); ?>" />
                </p>
                <div class="important_measurements">
                  <div class="input-group">
                    <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dugong_mesures_n'); ?></span>
                    <?php echo $this->form->getInput('observation_dugong_mesures_n'); ?>
                  </div>
                </div>
                <div class="important_measurements">
                  <div class="input-group">
                    <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dugong_mesures_o'); ?></span>
                    <?php echo $this->form->getInput('observation_dugong_mesures_o'); ?>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-xs-12">
                <p>
                  <img src="administrator/components/com_stranding_forms/assets/images/dugong/large/l_dugong_pectoral_fin.png" alt="Mesures sur dugongs" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_DUGONG_IMAGE_DESC'); ?>" />
                </p>
                <div class="important_measurements">
                  <div class="input-group">
                    <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dugong_mesures_p'); ?></span>
                    <?php echo $this->form->getInput('observation_dugong_mesures_p'); ?>
                  </div>
                </div>
                <div class="important_measurements">
                  <div class="input-group">
                    <span class="input-group-addon exergue label_icon"><?php echo $this->form->getLabel('observation_dugong_mesures_r'); ?></span>
                    <?php echo $this->form->getInput('observation_dugong_mesures_r'); ?>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-xs-12">
                <p>
                  <img src="administrator/components/com_stranding_forms/assets/images/dugong/large/l_dugong_tail_fin.png" alt="Mesures sur dugongs" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_DUGONG_IMAGE_DESC'); ?>" />
                </p>
                <div class="important_measurements">
                  <div class="input-group">
                    <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dugong_mesures_q'); ?></span>
                    <?php echo $this->form->getInput('observation_dugong_mesures_q'); ?>
                  </div>
                </div>
                <div class="important_measurements">
                  <div class="input-group">
                    <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dugong_mesures_s'); ?></span>
                    <?php echo $this->form->getInput('observation_dugong_mesures_s'); ?>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-xs-12">
                <p>
                  <img src="administrator/components/com_stranding_forms/assets/images/dugong/large/l_dugong_bacon_thickness.png" alt="Mesures sur dugongs" title="<?php echo JText::_('COM_STRANDING_FORMS_EDIT_ITEM_MESURES_DUGONG_IMAGE_DESC'); ?>" />
                </p>
                <div class="important_measurements">
                  <div class="input-group">
                    <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dugong_mesures_t'); ?></span>
                    <?php echo $this->form->getInput('observation_dugong_mesures_t'); ?>
                  </div>
                </div>
                <div class="important_measurements">
                  <div class="input-group">
                    <span class="input-group-addon exergue label_icon mesure_important"><?php echo $this->form->getLabel('observation_dugong_mesures_u'); ?></span>
                    <?php echo $this->form->getInput('observation_dugong_mesures_u'); ?>
                  </div>
                </div>
                <div class="important_measurements">
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
            <div class="col-lg-12 col-md-12 col-xs-12 text-center">
              <button onclick="toogleAnimal('mesurements',<?php echo $n ?>)"><?php echo JText::_('CLOSE');?> <span class="fa fa-close"></span></button>
            </div>
          </div>

        </div>

        
      </div>
    </div>
  </div>
<?php } ?>