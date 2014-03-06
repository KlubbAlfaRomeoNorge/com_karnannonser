<?php
/**
 * @package KARN.Classifieds
 * @subpackage Components
 * @license GNU/GPL
 *
 *	KARN Classified ads
 *  Copyright (C) 2014 Klubb Alfa Romeo Norge
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along
 *  with this program; if not, write to the Free Software Foundation, Inc.,
 *  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

/**
 * KARN Classifieds controller
 * @package KARN.Classifieds
 * @subpackage Components
 */

class KarnController extends JController
{
	function display()
	{
		parent::display();
	}

	function showad()
	{
		JRequest::setVar('view', 'showad');
		parent::display();
	}

	function sendEditMail()
	{
		$model = $this->getModel('annonse');
		$editkey = $model->getEditKey(JRequest::getInt('ad_id'));
		JRequest::setVar('view', 'message');
		if ($model->isValidEditkey($editkey))
		{
			$email = $model->getEmailForEditkey($editkey);
			$name = $model->getNameForEditkey($editkey);
			$model->sendEditAdMail($name, $email, $editkey);

			JRequest::setVar('msgtitle', 'Redigerings-epost er sendt');
			JRequest::setVar('message', 'Det er n&aring; sendt en epost til <strong>'.$email.' med en lenke du kan klikke p&aring; for &aring; redigere annonsen.</strong>');
		}
		else
		{
			JRequest::setVar('msgtitle', 'Ugyldig redigeringsnøkkel');
			JRequest::setVar('message', 'Du har oppgitt en ugyldig redigeringsnøkkel eller en redigeringsnøkkel på en annonse som ikke fins.');
		}
		// send mail med redigering via modellen
		parent::display();
	}

	function createad()
	{
		// check ad input
		// insert
		$model = $this->getModel('annonse');

		if ($model->check())
		{
			if ($model->store(true))
			{
				$msg = 'Annonsen er registrert men ikke aktivert. Det er nå sendt en epost til '.
						'<strong>'.JRequest::getVar('email').'</strong> med en aktiveringslenke '.
						'som du må klikke på for at annonsen skal vises på sidene. Det ligger '.
						'også en lenke som du kan klikke på for å redigere annonsen.';
			}
			else
			{
				$msg = JText::_('Feil ved registrering av annonse');
			}
		}
		else
		{
			$msg = JText::_('Ett eller flere felt mangler i annonsen');
		}

		JRequest::setVar('view', 'message');
		JRequest::setVar('msgtitle', 'Annonsen er nå registrert');
		JRequest::setVar('message', $msg);

		// send mail
		$model->sendNewAdMail(JRequest::getString('name'), JRequest::getString('email'), JRequest::getString('editkey'));

		parent::display();
	}


	function activate()
	{

		$model = $this->getModel('annonse');
		$ad_id = $model->activate(JRequest::getString('editkey'));
		if ($ad_id)
		{
			$model->setAdId($ad_id);
			$view  = $this->getView('editad', 'html', 'KarnView');
			$view->setModel($model, true);
			JRequest::setVar('view', 'editad');
		}
		else
		{
			JRequest::setVar('msgtitle', 'Ukjent annonse');
			JRequest::setVar('message', 'Finner ikke annonsen! Dersom den er eldre enn 90 dager så har den blitt slettet.');
			JRequest::setVar('view', 'message');
		}
		parent::display();
	}

	function edit()
	{
		// check code, set ad id
		$model = $this->getModel('annonse');
		$ad_id = $model->getAdId(JRequest::getString('editkey'));

		if ($ad_id)
		{
			$model->setAdId($ad_id);
			$view  = $this->getView('editad', 'html', 'KarnView');
			$view->setModel($model, true);
			JRequest::setVar('view', 'editad');
		}
		else
		{
			JRequest::setVar('msgtitle', 'Ukjent annonse');
			JRequest::setVar('message', 'Finner ikke annonsen! Dersom den er eldre enn 90 dager så har den blitt slettet.');
			JRequest::setVar('view', 'message');
		}
		parent::display();
	}

	function update()
	{
		// check that editcode and id matches
		$model = $this->getModel('annonse');
		$ad_id = $model->getAdId(JRequest::getString('editkey'));
		JRequest::setVar('msgtitle', 'Oppdatere annonse');
		if ($ad_id == JRequest::getInt('ad_id'))
		{
			// save changes, redirect to confirmation
			if ($model->check())
			{
				if ($model->store(false))
				{
					$msg = JText::_('Annonsen er oppdatert');
				}
				else
				{
					$msg = JText::_('Feil ved lagring av annonse');
				}
			}
			else
			{
				$msg = JText::_('Ett eller flere felt mangler i annonsen');
			}
			JRequest::setVar('message', $msg);
		}
		else
		{
			JRequest::setVar('message', 'Ukjent annonse.');
		}
		JRequest::setVar('view', 'message');
		parent::display();
	}

	function delete()
	{
		// check that editcode and id matches
		$model = $this->getModel('annonse');
		$ad_id = $model->getAdId(JRequest::getString('editkey'));
		JRequest::setVar('msgtitle', 'Slette annonse');
		if ($ad_id == JRequest::getInt('ad_id'))
		{
			// delete ad, redirect to confirmation
			if ($model->deleteAd($ad_id))
			{
				JRequest::setVar('message', 'Annonsen er slettet');
			}
			else
			{
				JRequest::setVar('message', 'Feil ved sletting av annonse');
			}
		}
		else
		{
			JRequest::setVar('message', 'Ukjent annonse');
		}
		JRequest::setVar('view', 'message');
		parent::display();
	}
}
?>
