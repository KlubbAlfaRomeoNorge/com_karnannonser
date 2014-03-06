<?php
/**
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
class KarnModelAnnonse extends JModel
{
	function __construct()
	{
		parent::__construct();
		$array = JRequest::getVar('cid', 0, '', 'array');
		if ($array)
		{
			$this->setAdId((int) $array[0]);
		}
		else
		{
			$this->setAdId(0);
		}
	}

	function setAdId($id)
	{
		$this->_ad_id = $id;
		$this->_annonse = null;
	}

	function &getData()
	{
		if (empty($this->_annonse))
		{
			$query = 'SELECT * from #__karn_ads WHERE ad_id = '.$this->_ad_id;
			$this->_db->setQuery($query);
			$this->_annonse = $this->_db->loadObject();
		}

		if (!$this->_annonse)
		{
			$this->_annonse = new stdClass();
			$this->_annonse->ad_id = 0;
			$this->_annonse->title = '';
			$this->_annonse->email = '';
			$this->_annonse->name = '';
			$this->_annonse->description = '';
			$this->_annonse->published = 0;
			$this->_annonse->catid = 0;
			$this->_annonse->adcreated = JFactory::getDate()->toMySQL();
			$this->_annonse->admodified = JFactory::getDate()->toMySQL();
			$this->_annonse->editkey = $this->generateEditKey();
		}

		return $this->_annonse;
	}

	function generateEditKey()
	{
		return sprintf("%06X%06X%06X", rand(0, 0xffffff), rand(0, 0xffffff), rand(0, 0xffffff));
	}


	function store($new)
	{
		$row =& $this->getTable();

		if ($new)
		{
			JRequest::setVar('editkey', $this->generateEditKey());
			JRequest::setVar('published', '0');
		}
		else
		{
			JRequest::setVar('published', '1');
		}
		$data = JRequest::get('post');

		if (!$row->bind($data))
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$row->check())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		$row->admodified = JFactory::getDate()->toMySQL();
		if ($row->ad_id < 1)
		{
			$row->adcreated = JFactory::getDate()->toMySQL();
		}

		if (!$row->store())
		{
			$this->setError($row->getErrorMsg());
			return false;
		}

		return true;
	}

	function delete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$row =& $this->getTable();

		if (count( $cids )) {
			foreach($cids as $cid) {
				if (!$row->delete( $cid )) {
					$this->setError( $row->getErrorMsg() );
					return false;
				}
			}
		}
		return true;
	}

	function _setPublished($cid, $published)
	{
		if (count( $cid ))
		{
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );

			$query = 'UPDATE #__karn_ads'
				. ' SET published = '.(int) $published
				. ' WHERE ad_id IN ( '.$cids.' )';
			$this->_db->setQuery( $query );
			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}

	function publish()
	{
		return $this->_setPublished(JRequest::getVar( 'cid', array(0), 'post', 'array' ), 1);
	}

	function unpublish()
	{
		return $this->_setPublished(JRequest::getVar( 'cid', array(0), 'post', 'array' ), 0);
	}

	function check()
	{
		if (!JRequest::getInt('catid') || !JRequest::getString('title') || !JRequest::getString('name') ||
		!JRequest::getString('description'))
		{
			return false;
		}
		return true;
	}

	function sendNewAdMail($name, $email, $editkey)
	{
  		$message =& JFactory::getMailer();
  		$message->addRecipient(array($email, $name));
  		$message->setSubject('Annonse på klubbalfaromeo.no');

		$body = "Annonsen din på http://www.klubbalfaromeo.no/ er registrert men ikke\n".
				"aktivert. For å aktivere annonsen må du klikke på denne lenken: \n".
				"http://www.klubbalfaromeo.no/index.php?option=com_karnannonser&task=activate&editkey=".$editkey."\n".
				"\n".
				"Dersom du ønsker å redigere eller å slette annonsen kan du klikke på\n".
				"denne lenken: \n".
				"http://www.klubbalfaromeo.no/index.php?option=com_karnannonser&task=edit&editkey=".$editkey."\n".
				"\n".
				"Dersom du har noen spørsmål kan du sende en epost til webmaster@klubbalfaromeo.no\n".
				"\n".
				"Vennlig hilsen\nWebmaster KARN\nwebmaster@klubbalfaromeo.no";

  		$message->setBody($body);
  		$sender = array( 'webmaster@klubbalfaromeo.no', 'Webmaster KARN' );
  		$message->setSender($sender);
  		$sent = $message->send();
  		if ($sent != 1)
  		{
			$msg = 'Kunne ikke sende epost til '.$email.'!';
			JRequest::setVar('message', $msg);
		}
	}

	function sendEditAdMail($name, $email, $editkey)
	{
  		$message =& JFactory::getMailer();
  		$message->addRecipient(array($email, $name));
  		$message->setSubject('Redigeringslenke til annonse på klubbalfaromeo.no');

		$body = "For å redigere eller slette annonsen klikker du på denne lenken: \n".
				"http://www.klubbalfaromeo.no/index.php?option=com_karnannonser&task=edit&editkey=".$editkey."\n".
				"\n".
				"Dersom du har noen spørsmål kan du sende en epost til webmaster@klubbalfaromeo.no\n".
				"\n".
				"Vennlig hilsen\nWebmaster KARN\nwebmaster@klubbalfaromeo.no";

  		$message->setBody($body);
  		$sender = array( 'webmaster@klubbalfaromeo.no', 'Webmaster KARN' );
  		$message->setSender($sender);
  		$sent = $message->send();
  		if ($sent != 1)
  		{
			$msg = 'Kunne ikke sende epost til '.$email.'!';
			JRequest::setVar('message', $msg);
		}
	}

	function activate($editkey)
	{
		if (!$this->isValidEditkey($editkey)) return;

		$query = 'UPDATE #__karn_ads SET published = 1 WHERE editkey = \''.$this->_db->getEscaped($editkey).'\'';
		$this->_db->setQuery($query);
		if (!$this->_db->query()) return false;

		return $this->getAdId($editkey);
	}
	function getEditKey($ad_id)
	{
		$query = 'SELECT editkey FROM #__karn_ads WHERE ad_id = \''.$this->_db->getEscaped($ad_id).'\'';
		$this->_db->setQuery($query);
		return $this->_db->loadResult();
	}

	function getAdId($editkey)
	{
		if (!$this->isValidEditKey($editkey)) return false;

		$query = 'SELECT ad_id FROM #__karn_ads WHERE editkey = \''.$this->_db->getEscaped($editkey).'\'';
		$this->_db->setQuery($query);
		return $this->_db->loadResult();
	}

	function getCategories()
	{
		if (empty($this->_kategorier))
		{
			$this->_kategorier = $this->_getList('select id, title from #__categories where section = "com_karnannonser" order by ordering');
		}
		return $this->_kategorier;
	}

	function deleteAd($ad_id)
	{
		if (!$ad_id) return false;
		$query = 'DELETE FROM #__karn_ads WHERE ad_id = '.$ad_id;
		$this->_db->setQuery($query);
		return $this->_db->query();
	}

	function isValidEditkey($editkey)
	{
		if (!$editkey || strlen(trim($editkey)) < 8) return false;
		return true;
	}

	function getEmailForEditkey($editkey)
	{
		if (!$this->isValidEditkey($editkey)) return false;

		$query = 'SELECT email FROM #__karn_ads WHERE editkey = \''.$this->_db->getEscaped($editkey).'\'';
		$this->_db->setQuery($query);
		return $this->_db->loadResult();
	}
	function getNameForEditKey($editkey)
	{
		if (!$this->isValidEditkey($editkey)) return false;

		$query = 'SELECT name FROM #__karn_ads WHERE editkey = \''.$this->_db->getEscaped($editkey).'\'';
		$this->_db->setQuery($query);
		return $this->_db->loadResult();
	}
}
?>
