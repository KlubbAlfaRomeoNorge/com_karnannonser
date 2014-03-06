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
// No direct access

defined('_JEXEC') or die('Restricted access'); ?>

<?php JFactory::getDocument()->addStyleSheet("components/com_karnannonser/assets/com_karnannonser.css"); ?>

<h1><?php echo $this->category_name; ?>: <?php echo $this->ad_item->title; ?></h1>
			<?php if ($this->ad_item->image_url) { ?>
				<img class="karn_singlead" src="<?php echo $this->ad_item->image_url;?>" alt="<?php echo $this->ad_item->title; ?>"/>
			<?php } ?>
<p>
	<div class="karn_singlead">

		<h2>Beskrivelse</h2>
		<div class="karn_singlead_descrition">
			<?php echo $this->ad_item->description; ?>
		</div>

		<h2>Kontaktinformasjon</h2>

		<div class="karn_singlead_contact">

			<?php echo $this->ad_item->name; ?>
			<a href="mailto:<?php echo $this->ad_item->email; ?>" title="Send epost"><?php echo $this->ad_item->email; ?></a>
			<?php if ($this->ad_item->phone) { ?>
				<?php echo $this->ad_item->phone; ?>
			<?php } ?>
		</div>
	</div>
</p>
<p>
<a href="index.php?option=com_karnannonser&view=annonser">&lt;&lt; Tilbake til annonsene</a>
</p>
<p>
	<div class="karn_singlead_editinfo">
		Har dette din annonse? Dersom du ønsker å endre den finner du
		en redigeringslenke i eposten du mottok når du la inn annonsen.
		<a href="index.php?option=com_karnannonser&task=sendeditmail&ad_id=<?php echo $this->ad_item->ad_id; ?>" title="Send ny epost">Klikk her</a> for å få tilsendt en ny
		epost.
	</div>
</p>
