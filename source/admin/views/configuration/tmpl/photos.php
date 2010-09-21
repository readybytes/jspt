<?php 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<fieldset class="adminform">
	<legend><?php echo JText::_( 'Photos' ); ?></legend>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Enable photos' ); ?>::<?php echo JText::_('Enable or disable the photos system'); ?>">
						<?php echo JText::_( 'Enable photos' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'enablephotos' , null ,  $this->config->get('enablephotos') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Photos Path' ); ?>::<?php echo JText::_('Set the path for storing photos'); ?>">
						<?php echo JText::_( 'Path to uploaded photos' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" size="40" name="photospath" value="<?php echo $this->config->get('photospath');?>" />
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Photos creation limit' ); ?>::<?php echo JText::_('Specify how many photos can a user upload. Set it to 0 if you would like to disable this feature'); ?>">
						<?php echo JText::_( 'Photos creation limit' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="photouploadlimit" value="<?php echo $this->config->get('photouploadlimit' );?>" size="10" />
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Maximum photo upload size' ); ?>::<?php echo JText::_('Set the maximum file size for photos upload'); ?>">
						<?php echo JText::_( 'Maximum photo upload size' ); ?>
					</span>
				</td>
				<td valign="top">
					<div><input type="text" size="3" name="maxuploadsize" value="<?php echo $this->config->get('maxuploadsize');?>" /> (MB)</div>
					<div><?php echo JText::sprintf('upload_max_filesize defined in php.ini %1$s', $this->uploadLimit );?></div>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Image Magick Path' ); ?>::<?php echo JText::_('Enter the absolute path to Image magick libraries. If PHP is not compiled with Image Magick, JomSocial will look for the Image Magick library and execute it through the exec method in PHP'); ?>">
						<?php echo JText::_( 'Image Magick Path (optional)' ); ?>
					</span>
				</td>
				<td valign="top">
					<input name="magickPath" type="text" size="60" value="<?php echo $this->config->get('magickPath');?>" />
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Use flash uploader' ); ?>::<?php echo JText::_('Enable this option to enable flash uploader for photos in the photo album. If flash uploader is not enabled, JomSocial will use a normal flash uploader.'); ?>">
						<?php echo JText::_( 'Use flash uploader' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'flashuploader' , null ,  $this->config->get('flashuploader') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Folder Permissions' ); ?>::<?php echo JText::_('Set folder permissions.'); ?>">
						<?php echo JText::_( 'Folder Permissions' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo $this->getFolderPermissionsPhoto( 'folderpermissionsphoto' , $this->config->get('folderpermissionsphoto') ); ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Automatically set album cover' ); ?>::<?php echo JText::_('Enable this option to allow automatic album cover. The first photo uploaded will be the album cover automatically.'); ?>">
						<?php echo JText::_( 'Automatically set album cover' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'autoalbumcover' , null ,  $this->config->get('autoalbumcover' , true ) , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
		</tbody>
	</table>
</fieldset>