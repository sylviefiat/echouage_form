<?php
/**
 * @version     0.0.0
 * @package     com_stranding_forms
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Sylvie Fiat <sylvie.fiat@ird.fr>
 */

defined('_JEXEC') or die;

abstract class Stranding_formsHelper
{
	public static function sendMail($data,$email_admin)
	{
		// Get JMail helper
		$mailer =& JFactory::getMailer();

		// Set the sender (from joomla configuration)
		$config = JFactory::getConfig();
		$from =& $config->get( 'mailfrom' );
		$fromname = $config->get( 'fromname' );
		$sender = array(
			$config->get( 'mailfrom' ),
			$config->get( 'fromname' ) );
		$mailer->setSender($sender);

		// Set the recipient
		$recipient = $email_admin;
		$mailer->addRecipient($email_admin);

		$valid = "<a href='".JURI::base()."index.php/administrer-les-observations/".$data['id']."?view=stranding_admin'>Aller sur le site pour valider</a>";

		$body   = "<h4>Un nouveau report d'échouage a été effectué:</h4>"
		."<div>Observateur: ".$data['observer_name']."</div>"
		.($data['observer_tel']!== ''?"<div>Téléphone: ".$data['observer_tel']."</div>":"")
		.($data['observer_email']!== ''?"<div>Mail: ".$data['observer_email']."</div>":"")

		."<div>Informateur: ".$data['informant_name']."</div>"
		.($data['informant_tel']!== ''?"<div>Téléphone: ".$data['informant_tel']."</div>":"")
		.($data['informant_email']!== ''?"<div>Mail: ".$data['informant_email']."</div>":"")

		."<div>Date de l'observation: ".($data['observation_datetime'])."</div>"
		."<div>Détails sur la position de l'observation: ".$data['observation_location']."</div>"
		."<div>Position: ".$data['observation_localisation']."</div>"
		.($data['observation_region']!== ''?"<div>Région: ".$data['observation_region']."</div>":"")
		.($data['observation_country']!== ''?"<div>Pays: ".$data['observation_country']."</div>":"")
		."<div>Type d’échouage: ".$data['observation_stranding_type']."</div>"
		."<div>Nombre: ".$data['observation_number']."</div>"
		."<div>Espèces: ".$data['observation_species']."</div>"
		."<div>Taille:".$data['observation_size']."</div>"
		."<div>Sex:".$data['observation_sex']."</div>"
		."<div>Présence de bléssures, morssures:".$data['observation_abnormalities']."</div>"
		."<div>Présence de traces de capture:".$data['observation_capture_traces']."</div>"
		.($data['catch_indices']!== ''?"<div>Indices de capture: ".$data['catch_indices']."</div>":"")
		."<div>Etat: </div>"
		.($data['observation_alive']!==''?"<div>Animal: ".$data['observation_alive']."</div>":"")
		.($data['observation_datetime_release']!==''?"<div>Date le remise à l'eau: ".$data['observation_datetime_release']."</div>":"")
		.($data['observation_death']!==''?"<div>Animal: ".$data['observation_death']."</div>":"")
		.($data['observation_datetime_death']!==''?"<div>Date de la mort: ".$data['observation_datetime_death']."</div>":"")
		.($data['remarks']!== ''?"<div>Remarques: ".$data['remarks']."</div>":"")
		."<div>Observation validation: ".$valid." </div>";


		$subject = "Echouage NC: nouveau report d'échouage en Nouvelle-Calédonie";
		$mailer->setSubject("Echouage NC: nouveau report d'échouage en Nouvelle-Calédonie");
		$mailer->setBody($body);
		$mailer->AltBody =JMailHelper::cleanText( strip_tags( $body));

		$mailer->isHTML(true);

		// Send email
		$send = $mailer->Send();
		if ( $send !== true ) {
			return 'Error sending email: ' . $send->__toString();
		} else {
			return 'Mail sent';
		}
	}



}
