<?php
/**
 * @version     1.0.0
 * @package     com_stranding_forms
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Sylvie Fiat <sylvie.fiat@ird.fr>
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

defined('DS') or define("DS", DIRECTORY_SEPARATOR);


/**
* Script file of Stranding_forms component
*
* @package	Stranding_forms
* @subpackage	Installer
*/
class com_stranding_formsInstallerScript
{
	/**
	* Called on installation
	*
	* @access	public
	* @param	JAdapterInstance	$adapter	Installer Component Adapter.
	* @return	void
	*
	* @since	1.6
	*/
	public function install(JAdapterInstance $adapter)
	{
		$adapter->getParent()->setRedirectURL('index.php?option=com_stranding_forms');


	}

	/**
	* Method to install the embedded third extensions.
	*
	* @access	private
	* @param	JAdapterInstance	$adapter	Installer Component Adapter.
	* @return	void
	*
	* @since	Cook 2.6
	*/
	private function installExtensions(JAdapterInstance $adapter)
	{
		$dir = $adapter->getParent()->getPath('source') .DS. 'extensions';

		if(!file_exists($dir)){
			return;	
		}
		
		// to make sure there is no time limit
		set_time_limit(0);
		ignore_user_abort(true);		
		
		$installResults = array();

		jimport('joomla.filesystem.folder');
		$folders = JFolder::folders($dir);

		foreach($folders as $folder)
		{
			$source = $dir .DS. $folder;
		    $installer = new JInstaller;
		    $installResults[] = $installer->install($source);
		}
	}

	/**
	* Called after any type of action.
	*
	* @access	public
	* @param	string	$type	Type.
	* @param	JAdapterInstance	$adapter	Installer Component Adapter.
	* @return	void
	*
	* @since	1.6
	*/
	public function postflight($type, JAdapterInstance $adapter)
	{
		switch($type)
		{
			case 'install':
				$txtAction = JText::_('Installing');
		
				//Install all extensions contained in 'extensions' directory
				$this->installExtensions($adapter);
				
				// set default ACL
				$db = JFactory::getDBO();
				$query = "UPDATE #__assets SET "
					. ' rules=\'{"core.admin":[],"core.manage":[],"core.create":{"1":1},"core.delete":[],"core.edit":[],"core.edit.state":[],"core.view.own":{"2":1},"core.edit.own":[],"core.delete.own":[]}\''
					. " WHERE name='com_stranding_forms'";
				$db->setQuery($query);
				$db->query();
				break;
		
			case 'update':
				$txtAction = JText::_('Updating');

				//Install all extensions contained in 'extensions' directory
				$this->installExtensions($adapter);
				break;
	
			case 'uninstall':
				$txtAction = JText::_('Uninstalling');
		
				//Install all extensions contained in 'extensions' directory
				$this->uninstallExtensions($adapter);
				break;
	
		}

		$app = JFactory::getApplication();
		$txtComponent = JText::_('Stranding Forms');
		$app->enqueueMessage(JText::sprintf('%s %s was successfull.', $txtAction, $txtComponent));
	}

	/**
	* Called before any type of action
	*
	* @access	public
	* @param	string	$type	Type.
	* @param	JAdapterInstance	$adapter	Installer Component Adapter.
	* @return	void
	*
	* @since	1.6
	*/
	public function preflight($type, JAdapterInstance $adapter)
	{

	}

	/**
	* Called on uninstallation
	*
	* @access	public
	* @param	JAdapterInstance	$adapter	Installer Component Adapter.
	* @return	void
	*
	* @since	1.6
	*/
	public function uninstall(JAdapterInstance $adapter)
	{
		// We run postflight also after uninstalling
		self::postflight('uninstall', $adapter);

	}

	/**
	* Method to uninstall the embedded third extensions.
	*
	* @access	private
	* @param	JAdapterInstance	$adapter	Installer Component Adapter.
	* @return	void
	*
	* @since	Cook 2.6
	*/
	private function uninstallExtensions(JAdapterInstance $adapter)
	{

	}

	/**
	* Called on update
	*
	* @access	public
	* @param	JAdapterInstance	$adapter	Installer Component Adapter.
	* @return	void
	*
	* @since	1.6
	*/
	public function update(JAdapterInstance $adapter)
	{
		$this->deleteUnexistingFiles();
		$adapter->getParent()->setRedirectURL('index.php?option=com_stranding_forms');
	}

	/**
	* Delete files that should not exist
	*
	* @return void
	*/
	public function deleteUnexistingFiles()
	{
		$files = array(
			'/administrator/components/com_stranding_forms/controllers/stranding_public.php',
			'/administrator/components/com_stranding_forms/controllers/stranding_publics.php',
			'/administrator/components/com_stranding_forms/models/stranding_public.php',
			'/administrator/components/com_stranding_forms/models/stranding_publics.php',
			'/administrator/components/com_stranding_forms/models/forms/stranding_public.xml',
			'/administrator/components/com_stranding_forms/tables/stranding_public.php',
			'/components/com_stranding_forms/controllers/stranding_public.php',
			'/components/com_stranding_forms/controllers/stranding_publicform.php',
			'/components/com_stranding_forms/controllers/stranding_publics.php',
			'/components/com_stranding_forms/models/stranding_public.php',
			'/components/com_stranding_forms/models/stranding_publicform.php',
			'/components/com_stranding_forms/models/stranding_publics.php',
			'/components/com_stranding_forms/models/forms/stranding_publicform.xml'
		);
		$folders = array(
			'/administrator/components/com_stranding_forms/views/stranding_public',
			'/administrator/components/com_stranding_forms/views/stranding_publics',
			'/components/com_stranding_forms/views/stranding_public',
			'/components/com_stranding_forms/views/stranding_publicform',
			'/components/com_stranding_forms/views/stranding_publics'
		);
		jimport('joomla.filesystem.file');
		foreach ($files as $file){
			if (JFile::exists(JPATH_ROOT . $file) && !JFile::delete(JPATH_ROOT . $file)){
				echo JText::sprintf('FILES_JOOMLA_ERROR_FILE_FOLDER', $file) . '<br />';
			}
		}
		jimport('joomla.filesystem.folder');
		foreach ($folders as $folder){
			if (JFolder::exists(JPATH_ROOT . $folder) && !JFolder::delete(JPATH_ROOT . $folder)){
				echo JText::sprintf('FILES_JOOMLA_ERROR_FILE_FOLDER', $folder) . '<br />';
			}
		}
	}

}

