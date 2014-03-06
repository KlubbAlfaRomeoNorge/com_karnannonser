<?php
/**
 * Model for a single ad
 * @package Karn.Classifieds
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

jimport('joomla.application.component.model');
jimport('joomla.application.component');

/**
 * Annnonse-modell
 */
class KarnModelAnnonser extends JModel
{
	var $_items;

	function getCategoryName()
	{
		$db =& JFactory::getDBO();
		$db->setQuery('SELECT title FROM #__categories where id = '.$this->getCatid());
		return $db->loadResult();
	}

	function getCatid()
	{
		$params = &JComponentHelper::getParams( 'com_karnannonser' );
		return $params->get( 'catid' );
	}

	function getTotal()
	{
		$db =& JFactory::getDBO();
		$db->setQuery('SELECT count(*) FROM #__karn_ads where published = 1 and catid = '.$this->getCatid());
		return $db->loadResult();
	}

	function getData()
	{
		if (empty($this->_items))
		{
			$this->cleanupAds();
			$this->_items = $this->_getList('SELECT * FROM #__karn_ads where published = 1 and catid = '.$this->getCatid().' order by adcreated desc');
		}
		return $this->_items;
	}

	function getCategories()
	{
		if (empty($this->_kategorier))
		{
			$this->_kategorier = $this->_getList('select id, title from #__categories where section = "com_karnannonser" order by ordering');
		}
		return $this->_kategorier;
	}

	function cleanupAds()
	{
		$db =& JFactory::getDBO();
		$db->setQuery('UPDATE #__karn_ads SET published = 0 WHERE admodified < (CURDATE() - INTERVAL 90 DAY) ');
		$db->query();
		$db->setQuery('DELETE FROM #__karn_ads WHERE admodified < (CURDATE() - INTERVAL 120 DAY) ');
		$db->query();
	}
}
?>
