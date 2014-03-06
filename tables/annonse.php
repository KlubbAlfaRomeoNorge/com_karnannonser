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
 *
 * Annonse table
 */
defined('_JEXEC') or die('Restricted access');

class TableAnnonse extends JTable
{
	var $ad_id = null;
	var $title = null;
	var $email = null;
	var $name = null;
	var $catid = null;
	var $published = 0;
	var $phone = null;
	var $image_url = null;
	var $editkey = null;
	var $admodified = null;
	var $adcreated = null;
	var $description = null;


	function TableAnnonse(& $db) {
		parent::__construct('#__karn_ads', 'ad_id', $db);
	}
}
?>
