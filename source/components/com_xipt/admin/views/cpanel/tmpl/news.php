<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
echo $this->pane->startPanel( JText::_('JOOMLAXI UPDATES') , 'xipt' );

?>
	<script src="http://widgets.twimg.com/j/2/widget.js"></script>
	<script>
new TWTR.Widget({
version: 2,
type: 'search',
search: 'JoomlaXiNews',
interval: 6000,
title: '',
subject: '',
width: 'auto',
height: 300,
theme: {
shell: {
background: '#ffffff',
color: '#fa761e'
},
tweets: {
background: '#ffffff',
color: '#444444',
links: '#1985b5'
}
},
features: {
scrollbar: false,
loop: false,
live: false,
hashtags: true,
timestamp: true,
avatars: false,
behavior: 'all'
}
}).render().start();
</script>

<?php 
echo $this->pane->endPanel();