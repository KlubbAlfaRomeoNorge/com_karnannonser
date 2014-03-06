<?php
	/**
	 * @package KARN.Classifieds
	 * @subpackage Components
	 * components/com_karn_classifieds/karn_classifieds.php
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

	require_once(JPATH_COMPONENT.DS.'controller.php');

	if ($controller = JRequest::getVar('controller')) {
		$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
		if (file_exists($path)) {
			require_once $path;
		} else {
			$controller = '';
		}
	}

	$classname = 'KarnController'.$controller;
	$controller = new $classname();

	$controller->execute(JRequest::getVar('task'));
	$controller->redirect();

?>
