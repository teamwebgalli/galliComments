<?php
	$id = (int) get_input('id');
	if($id){
		echo elgg_list_river(array('id'=>$id, 'limit'=>0, 'list_class'=>"", 'item_class'=>""));
	}
?>	