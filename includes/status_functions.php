<?php

function item_status_button($subitem){
	// Item is Not Complete
	if($subitem->status == 1){
?>

	<button id="btn-item-<?php echo $subitem->id; ?>" type="button" class="item-status-button btn btn-small btn-incomplete">Incomplete <?php icon("remove"); ?></button>
	

<?php } 
	
	// Item is Complete
	else{ ?>
	
	<button id="btn-item-<?php echo $subitem->id; ?>" type="button" class="item-status-button btn btn-small btn-success">Complete <?php icon("ok"); ?></button>

<?php
}}

function subitem_status_button($subitem){
	// Item is Not Complete
	if($subitem->status == 1){
?>

	<button id="btn-subitem-<?php echo $subitem->id; ?>" type="button" class="subitem-status-button btn btn-mini btn-incomplete"><?php icon("ok"); ?></button>
	

<?php } 
	
	// Item is Complete
	else{ ?>
	
	<button id="btn-subitem-<?php echo $subitem->id; ?>" type="button" class="subitem-status-button btn btn-mini btn-success"><?php icon("ok"); ?></button>

<?php
}}

?>