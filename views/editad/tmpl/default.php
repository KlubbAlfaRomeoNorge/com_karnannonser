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

<script language="JavaScript">
<!--
function checkForm()
{
	var form = document.forms['karnad'];
	if (form.catid.value == '0')
	{
		alert('Du må velge en kategori for annonsen');
		return false;
	}
	if (form.title.value.trim() == '')
	{
		alert('Du må oppgi en tittel på annonsen');
		return false;
	}
	if (form.description.value.trim() == '')
	{
		alert('Du må fylle ut en beskrivelse');
		return false;
	}
	if (form.name.value.trim() == '')
	{
		alert('Du må fylle ut navnet ditt!');
		return false;
	}
	form.task.value = 'update';
	form.submit();
	return true;
}
function deleteAd()
{
	if (confirm('Er du sikker på at du vil slette annonsen?'))
	{
		var form = document.forms['karnad'];
		form.task.value = 'delete';
		form.submit();
		return true;
	}
	return false;
}
function showPreview()
{
	var oldpreview = document.getElementById('preview_image');
	if (oldpreview)
	{
		oldpreview.parentNode.removeChild(oldpreview);
	}

	var preview = document.getElementById('imagepreview');
	var image = document.createElement('img');
	image.src = document.getElementById('image_url').value;
	image.width = 100;
	image.id = 'preview_image';
	preview.appendChild(image);
	return true;
}
// -->
</script>


<h1>Redigere annonse</h1>
<form name="karnad" class="karnad" method="post">
	<input type="hidden" name="ad_id" value="<?php echo $this->annonse->ad_id; ?>"/>
	<input type="hidden" name="editkey" value="<?php echo $this->annonse->editkey; ?>"/>
	<input type="hidden" name="option" value="com_karnannonser"/>
	<input type="hidden" name="task" value="" />

	<fieldset>
		<legend>Annonse</legend>
		<div class="karnad_field">
			<label for="catid">Seksjon</label>
			<select name="catid" id="catid" class="inputbox" size="1">
<?php foreach ($this->categories as $category) { ?>
				<option value=<?php echo $category->id ?>" <?php if ($this->annonse->catid == $category->id) { echo ' selected = "selected"'; }?>><?php echo $category->title; ?></option>
<?php } ?>
			</select>
		</div>
		<div class="karnad_field">
			<label for="title">Tittel</label>
			<input type="text" name="title" id="title" size="40" maxlength="80" value="<?php echo $this->annonse->title; ?>"/>
		</div>
		<div class="karnad_field">
			<label for="image_url">Link til bilde</label>
			<input type="text" name="image_url" id="image_url" size="40" maxlength="255" value="<?php echo $this->annonse->image_url; ?>"/>
		</div>
		<div class="karnad_field">
			<label for="description">Beskrivelse</label>
			<textarea name="description" id="description" rows="6" cols="80"><?php echo $this->annonse->description; ?></textarea>
		</div>
	</fieldset>
	<fieldset>
		<legend>Kontaktinformasjon</legend>
		<div class="karnad_field">
			<label for="name">Navn</label>
			<input type="text" name="name" id="name" size="30" maxlength="60" value="<?php echo $this->annonse->name; ?>"/>
		</div>
		<div class="karnad_field">
			<label for="phone">Telefon</label>
			<input type="text" name="phone" id="phone" size="20" maxlength="30" value="<?php echo $this->annonse->phone; ?>"/>
		</div>
	</fieldset>
	<fieldset>
		<legend>Oppdater annonse</legend>
		<input type="button" id="sendform" onClick="javascript:checkForm()" value="Lagre endringer"/>
		<input type="button" id="deletead" onClick="javascript:deleteAd()" value="Slett annonsen"/>
	</fieldset>
</form>

