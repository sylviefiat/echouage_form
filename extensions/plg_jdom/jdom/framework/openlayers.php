<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <     JDom Class - Cook Self Service library    |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		2.6.1
* @package		Cook Self Service
* @subpackage	JDom
* @license		GNU General Public License
* @author		Jocelyn HUARD
*
* @addon		OpenLayers API v3
* @author		Girolamo Tomaselli - http://bygiro.com
* @version		0.0.1
*
*             .oooO  Oooo.
*             (   )  (   )
* -------------\ (----) /----------------------------------------------------------- +
*               \_)  (_/
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
class JDomFrameworkOpenLayers extends JDomFramework
{	
	var $assetName = 'OpenLayers';
	
	protected static $loaded = array();	
	
	/*
	 * Constuctor
	 * 	@namespace 	: requested class
	 *  @options	: Configuration
	 *
	 *
	 */
	function __construct($args)
	{
		parent::__construct($args);
	}
	
	function build()
	{
		// Only load once
		if (!empty(static::$loaded[__METHOD__]))
		{
			return;
		}
		
		$doc = JFactory::getDocument();
		$doc->addStyleSheet( 'http://openlayers.org/en/v3.17.1/css/ol.css' );
		$doc->addScript('http://openlayers.org/en/v3.17.1/build/ol.js');
		// fix bootstrap CSS conflict
		$css = '.ol-style img{
			max-width: none !important;
		}';
		$doc->addStyleDeclaration($css);
		
		
		static::$loaded[__METHOD__] = true;
	}
}
