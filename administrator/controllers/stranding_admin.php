<?php
/**
 * @version     0.0.0
 * @package     com_stranding_forms
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Sylvie Fiat <sylvie.fiat@ird.fr>
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Stranding admin controller class.
 */
class Stranding_formsControllerStranding_admin extends JControllerForm
{

    function __construct() {
        $this->view_list = 'stranding_admins';
        parent::__construct();
    }

}
