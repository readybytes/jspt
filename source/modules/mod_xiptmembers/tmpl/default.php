<?php

?><div>
	<?php
	if(empty($profile_type))
	{
		echo JText::_('No profiletype selected');
	}
	else if( !empty( $row ) )
	{
	?>
		<div>		
			<ul style="list-style:none; margin: 0 0 10px; padding: 0;">
			<?php		
			foreach( $row as $data )
			{
				$user 		= CFactory::getUser($data->id);				
				$userName 	= $user->getDisplayName();
				$userLink 	= CRoute::_('index.php?option=com_community&view=profile&userid='.$data->id);
				
				$html  = '<li style="display: inline; padding: 0 3px 3px 0; background: none;">';
				$html .= '	<a href="'.$userLink.'">';
				if($tooltips)
				{
					$html .= '	<img width="32" src="'.$user->getThumbAvatar().'" class="avatar hasTipLatestMembers" alt="'.$userName.'" title="'.cAvatarTooltip($user).'" style="padding: 2px; border: solid 1px #ccc;" />';
				}
				else
				{
					$html .= '	<img width="32" src="'.$user->getThumbAvatar().'" alt="'.$userName.'" title="'.$userName.'" style="padding: 2px; border: solid 1px #ccc;" />';
				}
				$html .= '	</a>';
				$html .= '</li>';
				echo $html;
			}
			?>
			</ul>
		</div>
		<div>
			<?php  
				$link = 'index.php?field0=XIPT_PROFILETYPE'
						.'&condition0=equal'
						.'&value0='.$profile_type
						.'&fieldType0=profiletypes'
						.'&operator=and&key-list=0'
						.'&option=com_community&view=search&task=advancesearch' ; 
			?>
			<a style='float:right;' href='<?php echo CRoute::_($link); ?>'><?php echo JText::_("Show All"); ?></a>
			
		</div>
	<?php
	}
	else
	{
		echo JText::_('No members yet');
	}
	?>
	<div style='clear:both;'></div>
</div>
