<?php
/**
 * @version     2.0.7
 * @package     com_cot_forms
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Sylvie Fiat <sylvie.fiat@ird.fr>
 */

// No direct access.
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Cot admins list controller class.
 */
class Cot_formsControllerCot_admins extends Cot_formsController
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Cot_admins', $prefix = 'Cot_formsModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}

	public function export()
	{
		$nom_fichier = "operation_cetace-nc_" . date("d-m-Y");
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=" . $nom_fichier . ".csv");
		//header("Content-type: application/octet-stream");
		//header("Content-Disposition: attachment; filename=" . $nom_fichier . ".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		//header("Lacation: excel.htm?id=yes");
		$this->getModel()->getCsv();
		jexit();
	}
}
