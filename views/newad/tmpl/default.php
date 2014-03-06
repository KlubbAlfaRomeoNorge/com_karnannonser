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

<?php JHTML::_('behavior.formvalidation'); ?>
<script language="javascript">
function myValidate(f) {
        if (document.formvalidator.isValid(f)) {
                f.check.value='<?php echo JUtility::getToken(); ?>';//send token
                return true;
        }
        else {
                alert('Some values are not acceptable.  Please retry.');
        }
        return false;
}
</script>

<script language="JavaScript">
<!--
function validEmail(email)
{
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

	return reg.test(email);
}
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
	if (form.email.value.trim() == '')
	{
		alert('Du må fylle ut en epost-adresse!');
		return false;
	}
	if (!validEmail(form.email.value))
	{
		alert('Du må fylle ut en gyldig epost-adresse!');
		return false;
	}
	form.submit();
	return true;
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


<h1>Opprette ny annonse</h1>

<div class="karnad_info">
	N&aring;r du har sendt inn annonsen s&aring; f&aring;r du en
	epost med en lenke som du m&aring; klikke for &aring; aktivere
	annonsen. Annonsen vil ikke vises p&aring; sidene f&oslash;r
	den er aktivert. Eposten vil ogs&aring; inneholde en lenke
	du kan bruke for &aring; redigere annonsen. Annonsen vil
	st&aring; p&aring; sidene i 30 dager f&oslash;r den fjernes
	automatisk.
</div>

		<!-- Skjema for å opprette ny annonse kommer her. Verifisering av input
		(kontroller sjekksum på edit-kode, kontroller edit-kode) -->

<form name="karnad" method="post" class="karnad form-validate" onSubmit="return myValidate(this);">
	<input type="hidden" name="check" value="post"/>
	<input type="hidden" name="option" value="com_karnannonser"/>
	<input type="hidden" name="task" value="createad" />

	<fieldset>
		<legend>Annonse</legend>
		<div class="karnad_field">
			<label for="catid">Seksjon</label>
			<select name="catid" id="catid" class="inputbox required" size="1">
				<option value="0"   selected="selected">- Velg en kategori -</option>
<?php foreach ($this->categories as $category) { ?>
				<option value=<?php echo $category->id ?>"><?php echo $category->title; ?></option>
<?php } ?>
			</select>
		</div>
		<div class="karnad_field">
			<label for="title">Tittel</label>
			<input type="text" name="title" id="title" size="40" maxlength="80" class="required"/>
		</div>
		<div class="karnad_field">
			<label for="image_url">Link til bilde</label>
			<input type="text" name="image_url" id="image_url" size="40" maxlength="255" />
		</div>
		<div class="karnad_field">
			<label for="description">Beskrivelse</label>
			<textarea name="description" id="description" rows="6" cols="80" class="required"></textarea>
		</div>
	</fieldset>
	<fieldset>
		<legend>Kontaktinformasjon</legend>
		<div class="karnad_field">
			<label for="name">Navn</label>
			<input type="text" name="name" id="name" class="required" size="30" maxlength="60"/>
		</div>
		<div class="karnad_field">
			<label for="phone">Telefon</label>
			<input type="text" name="phone" class="required" id="phone" size="20" maxlength="30"/>
		</div>
		<div class="karnad_field">
			<label for="email">Email</label>
			<input type="text" name="email" class="required validate-email" id="email" size="30" maxlength="80"/>
		</div>
	</fieldset>
	<fieldset>
		<legend>Opprett annonse</legend>
		<input type="submit" id="sendform" value="Opprett annonse"/>
	</fieldset>
</form>

