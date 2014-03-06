# com_karnannonser

This is a simple classified ads component for Joomla 1.x-something (can't remember - the code was written quite a few years ago but this component works on fairly recent versions of Joomla) that doesn't require registration or much administration.

The submit form is open to everyone on the 'net and registration works as follows:
* The submitter fills out the online form online.
* A confirmation email is sent to the submitter with links to activate, edit and delete the ad.
* Once the submitter activates the ad through the link it is shown on the site.
* The ad will time out after a given number of days and the ad will be unpublished.
* Some time after the ad is unpublished it is deleted.

This component was written since I couldn't find any suitable classifieds component for Joomla and I needed something that could be used without registering while at the same time preventing spam appearing on the site.

The spam problem is fairly simple to circumvent since the automated spambots POSTs forms without caring about the inputs and most of the spam submissions are rejected at the gate. If the spambot manages to submit an ad it will not be activated unless someone clicks on the activation link and - fortunately - spam bots are not good at reading mail yet.

If, however, a spammer gets through to the end it is fairly simple to deactivate an ad through the management interface.

The ads will time out automatically after a preset time and they'll be unpublished. If the owner edits the ad it will reapper on the site.

## Translations
There's only one language for now -- norwegian -- but it should be fairly easy to translate it to another language. Adding support for more languages should be doable in a few hours but since I don't need it I won't do it. Feel free to fork and edit the code though. :)

## Custom styles

Everything's controlled by the com_karnannonser.css file so it should be relatively straightforward to get the look you want.


## Custom emails

...it's all in the models/annonse.php file!