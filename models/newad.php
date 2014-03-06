<?php
/**
 * Modell for annonser
 * @package Karn.Classifieds
 * @subpackage Components
 * @license GNU/GPL
 *
 *  KARN Classified ads
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
include('annonser.php');
/**
 * New ad model
 */
class KarnModelNewAd extends KarnModelAnnonser
{
	function createNewKey()
	{
		return sprintf("%06X%06X%06X", rand(0, 0xffffff), rand(0, 0xffffff), rand(0, 0xffffff));
	}
}
?>
