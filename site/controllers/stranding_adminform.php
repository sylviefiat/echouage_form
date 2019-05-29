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

require_once JPATH_COMPONENT.'/controller.php';
require_once JPATH_COMPONENT.'/helpers/stranding_forms.php';

/**
 * Stranding Admin controller class.
 */
class Stranding_formsControllerStranding_adminForm extends Stranding_formsController
{

	/**
	 * Method to check out an item for editing and redirect to the edit form.
	 *
	 * @since	1.6
	 */
	public function edit()
	{
		$app			= JFactory::getApplication();

		// Get the previous edit id (if any) and the current edit id.
		$previousId = (int) $app->getUserState('com_stranding_forms.edit.stranding_admin.id');
		$editId	= JFactory::getApplication()->input->getInt('id', null, 'array');

		// Set the user id for the user to edit in the session.
		$app->setUserState('com_stranding_forms.edit.stranding_admin.id', $editId);

		// Get the model.
		$model = $this->getModel('Stranding_adminForm', 'Stranding_formsModel');

		// Check out the item
		if ($editId) {
            $model->checkout($editId);
		}

		// Check in the previous user.
		if ($previousId) {
            $model->checkin($previousId);
		}

		// Redirect to the edit screen.
		$this->setRedirect(JRoute::_('index.php?option=com_stranding_forms&view=stranding_admin&layout=edit', false));
	}

	/**
	 * Method to save a user's profile data.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public function save()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		// Initialise variables.
		$app	= JFactory::getApplication();
		$model = $this->getModel('Stranding_adminForm', 'Stranding_formsModel');
		// Get the user data.
		$data = JFactory::getApplication()->input->get('jform', array(), 'array');

		// Validate the posted data.
		$form = $model->getForm();
		if (!$form) {
			JError::raiseError(500, $model->getError());
			return false;
		}
		//var_dump($data);
		// Validate the posted data.
		$data = $model->validate($form, $data);
		$editId	= JFactory::getApplication()->input->getInt('id', null, 'array');
		// Check for errors.
		if ($data === false) {
			// Get the validation messages.
			$errors	= $model->getErrors();
			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if ($errors[$i] instanceof Exception) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				} else {
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}
			// Save the data in the session.
			$app->setUserState('com_stranding_forms.edit.stranding_admin.data', JRequest::getVar('jform'),array());
			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_stranding_forms.edit.stranding_admin.id');
			$this->setRedirect(JRoute::_('index.php?option=com_stranding_forms&view=stranding_adminform&layout=edit&id='.$id, false));
			return false;
		}
		// save photos
		jimport( 'joomla.filesystem.folder' );
        jimport('joomla.filesystem.file');
        if ( !JFolder::exists( JPATH_SITE . DS . "images" . DS . "strandings" ) ) {
            JFolder::create( JPATH_SITE . DS . "images" . DS . "strandings" );
        }
        // Get the file data array from the request.
        foreach ($data['animal'] as $key => $animal) {
                 
	        $file = $animal['upload_photos'];
	        // Make the file name safe.
	        $filename = JFile::makeSafe($file['name']);	
	        JFactory::getApplication()->enqueueMessage($filename);
	        JFactory::getApplication()->enqueueMessage("blabla");
	        // Move the uploaded file into a permanent location.
	        if ( $filename != '' ) {
	            // Make sure that the full file path is safe.
	            $filepath = JPath::clean( JPATH_SITE . DS . 'images' . DS . 'strandings' . DS . strtolower( $filename ) );
	            // Move the uploaded file.
	            JFile::upload( $file['tmp_name'], $filepath );
	            // Change $data['file'] value before save into the database 
	            $data['animal'][$key]['upload_photos'] = strtolower( $filename );
	        }
	    }
        // ---------------------------- File Upload Ends ------------------------
		// Attempt to save the data.
		$return	= $model->save($data);

		// Check for errors.
		if ($return === false) {
			// Save the data in the session.
			$app->setUserState('com_stranding_forms.edit.stranding_admin.data', $data);
			// Redirect back to the edit screen.
			$id = (int)$app->getUserState('com_stranding_forms.edit.stranding_admin.id');
			$this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_stranding_forms&view=stranding_adminform&layout=edit&id='.$id, false));
			return false;
		} else {
			$data['id'] = $return;
		}
		if($editId == null){
		    // Send Email to STRANDING Admin	
		    $email_admin = $app->getParams('com_stranding_forms')->get('email_admin');
		    $email=Stranding_formsHelper::sendMail($data,$email_admin);			
        }
        // Check in the profile.
        if ($return) {
            $model->checkin($return);
        }	

        // Clear the profile id from the session.
        $app->setUserState('com_stranding_forms.edit.stranding_admin.id', null);

        // Redirect to the list screen.
        $this->setMessage(JText::_('COM_STRANDING_FORMS_ITEM_STRANDING_ADMIN_SAVED_SUCCESSFULLY'));
		//$this->setMessage($email);
	
        //$menu = & JSite::getMenu();
        $menu = & JFactory::getApplication()->getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));

		// Flush the data from the session.
		$app->setUserState('com_stranding_forms.edit.stranding_admin.data', null);
	}
    
    
    function cancel() {
		//$menu = & JSite::getMenu();
		$menu = & JFactory::getApplication()->getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));
    }
    
	public function remove()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app	= JFactory::getApplication();
		$model = $this->getModel('Stranding_adminForm', 'Stranding_formsModel');

		// Get the user data.
		$data = JFactory::getApplication()->input->get('jform', array(), 'array');

		// Validate the posted data.
		$form = $model->getForm();
		if (!$form) {
			JError::raiseError(500, $model->getError());
			return false;
		}

		// Validate the posted data.
		$data = $model->validate($form, $data);

		// Check for errors.
		if ($data === false) {
			// Get the validation messages.
			$errors	= $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if ($errors[$i] instanceof Exception) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				} else {
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			// Save the data in the session.
			$app->setUserState('com_stranding_forms.edit.stranding_admin.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_stranding_forms.edit.stranding_admin.id');
			$this->setRedirect(JRoute::_('index.php?option=com_stranding_forms&view=stranding_admin&layout=edit&id='.$id, false));
			return false;
		}

		// Attempt to save the data.
		$return	= $model->delete($data);

		// Check for errors.
		if ($return === false) {
			// Save the data in the session.
			$app->setUserState('com_stranding_forms.edit.stranding_admin.data', $data);

			// Redirect back to the edit screen.
			$id = (int)$app->getUserState('com_stranding_forms.edit.stranding_admin.id');
			$this->setMessage(JText::sprintf('Delete failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_stranding_forms&view=stranding_admin&layout=edit&id='.$id, false));
			return false;
		}

            
        // Check in the profile.
        if ($return) {
            $model->checkin($return);
        }
        
        // Clear the profile id from the session.
        $app->setUserState('com_stranding_forms.edit.stranding_admin.id', null);

        // Redirect to the list screen.
        $this->setMessage(JText::_('COM_STRANDING_FORMS_ITEM_DELETED_SUCCESSFULLY'));
        //$menu = & JSite::getMenu();
        $menu = & JFactory::getApplication()->getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));

		// Flush the data from the session.
		$app->setUserState('com_stranding_forms.edit.stranding_admin.data', null);
	}

	
    
    
}
