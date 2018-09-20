<?php
/**
 * @version     2.0.7
 * @package     com_cot_forms
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Sylvie Fiat <sylvie.fiat@ird.fr>
 */

// No direct access
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';
require_once JPATH_COMPONENT.'/helpers/cot_forms.php';

/**
 * Cot Admin controller class.
 */
class Cot_formsControllerCot_adminForm extends Cot_formsController
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
		$previousId = (int) $app->getUserState('com_cot_forms.edit.cot_admin.id');
		$editId	= JFactory::getApplication()->input->getInt('id', null, 'array');

		// Set the user id for the user to edit in the session.
		$app->setUserState('com_cot_forms.edit.cot_admin.id', $editId);

		// Get the model.
		$model = $this->getModel('Cot_adminForm', 'Cot_formsModel');

		// Check out the item
		if ($editId) {
            $model->checkout($editId);
		}

		// Check in the previous user.
		if ($previousId) {
            $model->checkin($previousId);
		}

		// Redirect to the edit screen.
		$this->setRedirect(JRoute::_('index.php?option=com_cot_forms&view=cot_admin&layout=edit', false));
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
		$model = $this->getModel('Cot_adminForm', 'Cot_formsModel');

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
			$app->setUserState('com_cot_forms.edit.cot_admin.data', JRequest::getVar('jform'),array());

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_cot_forms.edit.cot_admin.id');
			$this->setRedirect(JRoute::_('index.php?option=com_cot_forms&view=cot_adminform&layout=edit&id='.$id, false));
			return false;
		}

		// Attempt to save the data.
		$return	= $model->save($data);

		// Check for errors.
		if ($return === false) {
			// Save the data in the session.
			$app->setUserState('com_cot_forms.edit.cot_admin.data', $data);

			// Redirect back to the edit screen.
			$id = (int)$app->getUserState('com_cot_forms.edit.cot_admin.id');
			$this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_cot_forms&view=cot_adminform&layout=edit&id='.$id, false));
			return false;
		} else {
			$data['id'] = $return;
		}
	if($editId == null){
	    // Send Email to COT Admin	
	    $email_admin = $app->getParams('com_cot_forms')->get('email_admin');
	    $email=Cot_formsHelper::sendMail($data,$email_admin);			
        }
        // Check in the profile.
        if ($return) {
            $model->checkin($return);
        }	

        // Clear the profile id from the session.
        $app->setUserState('com_cot_forms.edit.cot_admin.id', null);

        // Redirect to the list screen.
        $this->setMessage(JText::_('COM_COT_FORMS_ITEM_COT_ADMIN_SAVED_SUCCESSFULLY'));
	//$this->setMessage($email);
	
        $menu = & JSite::getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));

		// Flush the data from the session.
		$app->setUserState('com_cot_forms.edit.cot_admin.data', null);
	}
    
    
    function cancel() {
		$menu = & JSite::getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));
    }
    
	public function remove()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app	= JFactory::getApplication();
		$model = $this->getModel('Cot_adminForm', 'Cot_formsModel');

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
			$app->setUserState('com_cot_forms.edit.cot_admin.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_cot_forms.edit.cot_admin.id');
			$this->setRedirect(JRoute::_('index.php?option=com_cot_forms&view=cot_admin&layout=edit&id='.$id, false));
			return false;
		}

		// Attempt to save the data.
		$return	= $model->delete($data);

		// Check for errors.
		if ($return === false) {
			// Save the data in the session.
			$app->setUserState('com_cot_forms.edit.cot_admin.data', $data);

			// Redirect back to the edit screen.
			$id = (int)$app->getUserState('com_cot_forms.edit.cot_admin.id');
			$this->setMessage(JText::sprintf('Delete failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_cot_forms&view=cot_admin&layout=edit&id='.$id, false));
			return false;
		}

            
        // Check in the profile.
        if ($return) {
            $model->checkin($return);
        }
        
        // Clear the profile id from the session.
        $app->setUserState('com_cot_forms.edit.cot_admin.id', null);

        // Redirect to the list screen.
        $this->setMessage(JText::_('COM_COT_FORMS_ITEM_DELETED_SUCCESSFULLY'));
        $menu = & JSite::getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));

		// Flush the data from the session.
		$app->setUserState('com_cot_forms.edit.cot_admin.data', null);
	}
    
    
}
