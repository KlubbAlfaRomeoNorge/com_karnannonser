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
<?php
function getFirstWords($string, $words = 1)
	{
		$string = explode(' ', $string);

		if (count($string) > $words)
		{
			return implode(' ', array_slice($string, 0, $words)) . '...';
		}

		return implode(' ', $string);
	}
?>
<h1><?php echo $this->category_name; ?></h1>
<p>
<?php foreach($this->items as $item) { ?>
	<div class="karnads_ad">
		<h2>
			<a href="index.php?option=com_karnannonser&task=showad&ad_id=<?php echo $item->ad_id; ?>" title="Klikk for &aring; se annonsen">
				<?php echo $item->title; ?>
			</a>
		</h2>
		<div class="ka_image">
			<?php if ($item->image_url) { ?>
				<a href="<?php echo $item->image_url; ?>" target="_blank" alt="Klikk for &aring; forst&oslash;rre">
					<img src="<?php echo $item->image_url; ?>" alt="<?php echo $this->category_name;?>: <?php echo $item->title; ?>"/>
				</a>
			<?php } else { ?>
				<img src="<?php echo JUri::root(true)."/components/com_karnannonser/assets/noad.jpg";?>" alt="Bilde ikke tilgjengelig"/>
			<?php } ?>
		</div>
		<div class="ka_text">
			<div class="ka_field_description"><?php echo getFirstWords($item->description, 60); ?></div>
			<div class="ka_field_name">
				<?php echo $item->name; ?>
				<?php if ($item->email) { ?>
				/ <a href="mailto:<?php echo $item->email; ?>"><?php echo $item->email; ?> </a>
				<?php } ?>
				<?php if ($item->phone) { ?>
				/  <?php echo $item->phone; ?>
				<?php } ?>
			</div>
			<a href="index.php?option=com_karnannonser&task=showad&ad_id=<?php echo $item->ad_id; ?>" title="Klikk for &aring; se annonsen">
				Vis &gt;&gt;
			</a>
			<div class="ka_field_modified">Sist endret <?php echo $item->admodified; ?></div>
		</div>
	</div>
<?php } ?>
</p>
<div class="karnads_summary"><p><?php echo $this->total; ?> annonser i denne kategorien </p></div>
