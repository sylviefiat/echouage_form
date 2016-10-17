<?php
/**
 * @version     2.0.5
 * @package     com_cot_forms
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Sylvie Fiat <sylvie.fiat@ird.fr>
 */

defined('_JEXEC') or die;

abstract class Cot_formsHelper
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

		$valid = "<a href='".JURI::base()."index.php/administrer-les-observations/".$data['id']."?view=cot_admin'>Aller sur le site pour valider</a>";

		$body   = "<h4>Un nouveau report d'acanthasters a été effectué:</h4>"
				."<div>Observateur: ".$data['observer_name']."</div>"
				.($data['observer_tel']!== ''?"<div>Téléphone: ".$data['observer_tel']."</div>":"")
				.($data['observer_email']!== ''?"<div>Mail: ".$data['observer_email']."</div>":"")
				."<div>Date de l'observation: ".($data['observation_day']!== ''?$data['observation_day']."/":"")
												.($data['observation_month']!== ''?$data['observation_month']."/":"")
												.($data['observation_year']!== ''?$data['observation_year']."/":"")."</div>"
				."<div>Détails sur la position de l'observation: ".$data['observation_location']."</div>"
				."<div>Position: ".$data['observation_localisation']."</div>"
				.($data['observation_region']!== ''?"<div>Région: ".$data['observation_region']."</div>":"")
				.($data['observation_country']!== ''?"<div>Pays: ".$data['observation_country']."</div>":"")
				.($data['observation_number']!== ''?"<div>Nombre d'acanthsters: ".$data['observation_number']."</div>":"")
				.($data['observation_culled']!== ''?"<div>Nombre d'acanthsters nettoyés: ".$data['observation_culled']."</div>":"")
				."<div>Méthode d'observation: ".implode( ',', $data['observation_method'])."</div>"
				.($data['depth_range']!== ''?"<div>Tranche de profondeur: ".implode(", ",$data['depth_range'])."</div>":"")
				.($data['counting_method_timed_swim']!== ''&&$data['counting_method_distance_swim']!== ''&&$data['counting_method_other']!== ''?"<div>Méthode(s) de comptage: </div>":"")
				.($data['counting_method_timed_swim']!== ''?"<div>temps de nage: ".$data['counting_method_timed_swim']."</div>":"")
				.($data['counting_method_distance_swim']!== ''?"<div>distance parcourue: ".$data['counting_method_distance_swim']."</div>":"")
				.($data['counting_method_other']!== ''?"<div>autre: ".$data['counting_method_other']."</div>":"")
				.($data['remarks']!== ''?"<div>Remarques: ".$data['remarks']."</div>":"")
				."<div>Observation validation: ".$valid." </div>";

		
		$subject = "Oreanet NC: nouveau report de présence d'acanthasters en Nouvelle-Calédonie";
		$mailer->setSubject("Oreanet NC: nouveau report de présence d'acanthasters en Nouvelle-Calédonie");
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

