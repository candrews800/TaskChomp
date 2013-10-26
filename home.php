<?php $page="Home"; ?>
<?php require_once("includes/initialize.php"); ?>
<?php require_once("includes/get_vars.php"); ?>
<?php require_once("layout/header.php"); ?>

<hr />

<div id="content-wrap" class="container">
	<div class="row">
		<div class="col-4">
			<?php require_once("layout/sidebar.php"); ?>
		</div>
		<div class="col-8">
			<?php 
				if(!empty($selected_list)){
					require_once("content/selected_list.php");
				}
				else if(empty($categories)){
					echo "<div class=\"alert alert-info missing\">Click <strong>Create</strong> in the sidebar to make a category for your lists. For example: Personal.</div>";
				}
				else if(empty($selected_list)){
					echo "<div class=\"alert alert-info missing\">Click <strong>Create List</strong> in the sidebar to make a make a list. For example: Shopping List.</div>";
				}
			?>
		</div>
	</div><!-- end body row -->
</div><!-- end body container -->		

<?php require_once("layout/footer.php"); ?>

<script src="js/nanoscroll.js"></script>
<link href="css/scroll.css" rel="stylesheet">
<style>
	.nano{ 
	 	width: 100%; 
	 	min-height: 30px;
		max-height: 200px; 
	}
	.nano .content{
		padding-right: 20px;
	}
	.nano .pane{
		background: #d9edf7; 
	}
	.nano .slider{
		color: #3a87ad;
		background: #3a87ad;
	}
	html {
	    overflow-y: scroll; 
	}
</style>

<script>

  

  $(document).ready(function() {  
  	
  	$(".subitems").hide();
  	
  	$(".see-more").click(function(){
  		var list_id = "#subitem-" + this.id.substr(9);
  		if($(this).html().trim() == "[+] show more"){
  			$(this).html("[-] show less");
  			$(this).addClass("grey");
  		}
  		else{
  			$(this).html("[+] show more");
  			$(this).removeClass("grey");
  		}
  		
		$(list_id).toggle(500);
  	});
  	
  	$(".nano").nanoScroller();	
  	
  	 $('.category-edit').editable('update.php?method=update&class=category&var_attr=title', {
     	 id : 'class_id',
     	 name : 'var_val',
     	 data: this.innerHTML,
         indicator : 'Saving...',
         tooltip   : 'Click to edit...',
		 cssclass : 'category-edit',
		 maxlength: 16,
		 callback : function(value, settings) {
        	 location.reload();
     	 }
     });
  	
     $('.tasklist-edit').editable('update.php?method=update&class=tasklist&var_attr=title', {
     	 id : 'class_id',
     	 name : 'var_val',
     	 data: this.innerHTML,
         indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         cssclass : 'tasklist-edit',
         maxlength: 24,
         callback : function(value, settings) {
        	 $(".selected_list-title").html(value);
     	 }
     });
     
     $('.item-edit').editable('update.php?method=update&class=item&var_attr=title', {
     	 id : 'class_id',
     	 name : 'var_val',
     	 data: this.innerHTML,
     	 maxlength: 52,
         indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         cssclass : 'item-edit'
     });
     
     $('.subitem-edit').editable('update.php?method=update&class=subitem&var_attr=title', {
     	 id : 'class_id',
     	 name : 'var_val',
     	 data: this.innerHTML,
     	 maxlength: 63,
         indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         cssclass : 'subitem-edit'
     });
  	
  	/*
     $('.tasklist-date').editable('update.php?method=update&class=tasklist&var_attr=date', {
     	 id : 'class_id',
     	 name : 'var_val',
     	 data: this.innerHTML,
         indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         height: '120%'
     });
     
     $('.item-date').editable('update.php?method=update&class=item&var_attr=date', {
     	 id : 'class_id',
     	 name : 'var_val',
     	 data: this.innerHTML,
         indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         height: '120%'
     });
	*/
  });
 
 
 	$(".change-status").click(function(){
 		var linkId = this.id;
 		var attributes = (this.id).split("-");
 		var status = attributes[0];
 		var class_type = attributes[1];
 		var class_id = attributes[2];
 		var status_text = "";
 		var status_css = "";
 		var remove_css = "";
 		
 		if(status==0){
 			status_text = "Complete";
 			status_css = "btn-success";
 			remove_css = "btn-info btn-warning";
 		}
		else if(status==1){
			status_text = "In Progress";
			status_css = "btn-info";
			remove_css = "btn-success btn-warning";
		}
		else if(status==2){
			status_text = "Not Started";
			status_css = "btn-warning";
			remove_css = "btn-success btn-info";
		}
 		
 		var url = "update.php?method=update&class="+class_type+"&class_id=status-"+class_type+"-"+class_id+"&var_attr=status";
 		$.post(url, 
 		{
 			"var_val" : status
 		},
 		function(data,status){
      		var buttonId = (linkId).substr(1);
		 	buttonId = "btn" + buttonId;
		 	
		 	$("#"+buttonId).switchClass(remove_css, status_css, 2000, "swing");
		 	
		 	$("#"+buttonId+" strong").html(status_text);
    	});
 	});
 	
 	$(".subitem-status-button").click(function(){
 		// this.id = btn-subitem-id#
 		var attributes = (this.id).split("-");
 		var class_type = attributes[1];
 		var class_id = attributes[2];
 		var btn_id = "btn-subitem-"+class_id;

 		var url = "update.php?method=update&class=subitem&class_id="+class_id+"&var_attr=status";
 		
 		$.post(url, true,
 		function(data, status){
 			if(status){
 				if($("#"+btn_id).hasClass("btn-success")){
 					$("#"+btn_id).switchClass("btn-success", "btn-incomplete");
 					$("#title-subitem-"+class_id).removeClass("complete");
 				}
 				else{
 					$("#"+btn_id).switchClass("btn-incomplete", "btn-success");
 					$("#title-subitem-"+class_id).addClass("complete");
 				}
 			}
 		});
 	});
 	
 	$(".item-status-button").click(function(){
 		// this.id = btn-subitem-id#
 		var attributes = (this.id).split("-");
 		var class_type = attributes[1];
 		var class_id = attributes[2];
 		var btn_id = "btn-item-"+class_id;

 		var url = "update.php?method=update&class=item&class_id="+class_id+"&var_attr=status";
 		
 		$.post(url, true,
 		function(data, status){
 			if(status){
 				if($("#"+btn_id).hasClass("btn-success")){
 					$("#"+btn_id).switchClass("btn-success", "btn-incomplete");
 					$("#"+btn_id).html("Incomplete <span class=\"glyphicon glyphicon-remove\"></span>");
 					$("#title-item-"+class_id).removeClass("complete");
 					$("#item-"+class_id).removeClass("complete");
 					
 					// Add One Unfinished List Item and Category
 					var cat_unfinished = parseInt($(".category-header.active .badge").html());
 					$(".category-header.active .badge").html(cat_unfinished+1);
 					if($.trim($(".category-header.active .badge").html()) == ""){
 						$(".category-header.active .badge").html(1);
 					}
 					
 					var list_unfinished = parseInt($(".list-content .active .badge").html());
 					$(".list-content .active .badge").html(list_unfinished+1);
 					
 					if($.trim($(".list-content .active .badge").html()) == ""){
 						$(".list-content .active .badge").html(1);
 					}
 					
 				}
 				else{
 					$("#"+btn_id).switchClass("btn-incomplete", "btn-success");
 					$("#"+btn_id).html("Complete <span class=\"glyphicon glyphicon-ok\"></span>");
 					$("#title-item-"+class_id).addClass("complete");
 					$("#item-"+class_id).addClass("complete");
 					
 					// Subtract One Unfinished List Item and Category
 					var cat_unfinished = parseInt($(".category-header.active .badge").html());
 					$(".category-header.active .badge").html(cat_unfinished-1);
 					if(cat_unfinished-1 == 0){
 						$(".category-header.active .badge").html("");
 					}
 					
 					var list_unfinished = parseInt($(".list-content .active .badge").html());
 					$(".list-content .active .badge").html(list_unfinished-1);
 					if(list_unfinished-1 == 0){
 						$(".list-content .active .badge").html("");
 					}
 				}
 				
 				if(data == 0){
 					$(".list-header .label").switchClass("label-default label-warning", "label-success");
 					$(".list-header .label").html("Complete");
 					$(".tasklist-title").addClass("complete");
 					$("li.active").addClass("complete");
 					$(".selected_list-title").addClass("complete");
 					$(".active .category-list-status").html("Complete");
 					$(".active .category-list-status").switchClass("text-muted text-warning", "text-success");
 				}
 				
 				else if(data == 1){
 					$(".list-header .label").switchClass("label-default label-success", "label-warning");
 					$(".list-header .label").html("In Progress");
 					$(".tasklist-title").removeClass("complete");
 					$(".selected_list-title").removeClass("complete");
 					$("li.active").removeClass("complete");
 					$(".active .category-list-status").html("In Progress");
 					$(".active .category-list-status").switchClass("text-success text-muted", "text-warning");
 				}
 				
 				else if(data == 2){
 					$(".list-header .label").switchClass("label-warning label-success", "label-default");
 					$(".list-header .label").html("Not Started");
 					$(".tasklist-title").removeClass("complete");
 					$(".selected_list-title").removeClass("complete");
 					$("li.active").removeClass("complete");
 					$(".active .category-list-status").html("Not Started");
 					$(".active .category-list-status").switchClass("text-success text-warning", "text-muted");
 				}
 			}
 		});
 	});
 	
	function updatePosition(itemId, newPosition){
		// Update position through ajax
		var attributes = itemId.split("-");
		var class_type = attributes[0];
		var class_id = attributes[1];
		
		var url ="update.php?method=move&class="+class_type+"&class_id="+class_id+"&position="+newPosition;
		$.post(url, true,
		function(data, status){
			if(status){
				// Update Numbers / Letters
				if(class_type == "item"){
					$('.item-num:not(.item-num-edit)').each(function(i, obj) {
					    $(this).html(i+1);
					});
				}
				else if(class_type == "subitem"){					
					$("#"+itemId).parent().find('.subitem-num:not(.subitem-num-edit)').each(function(i, obj) {
					    $(this).html(String.fromCharCode(97 + i));
					});
					
				}
			}
		});

	}
	
	/*
	$(function() {
	    $( "#category-sortable" ).sortable({
	    	items: "> li",
	    	cursor: "move",
	    	stop: function(event, ui) {
       		 	var itemId = ui.item.attr("id");
       		 	var newPosition = ui.item.index();
       		 	
       		 	updatePosition(itemId, newPosition);
    		}
	    });
	    $( "#item-sortable" ).disableSelection();

	  });
 	*/
 	$(function() {
	    $( "#item-sortable" ).sortable({
	    	items: "> li.item",
	    	axis: "y",
	    	cursor: "move",
	    	handle: ".grab-texture",
	    	helper: "clone",
	    	placeholder: "ui-state-highlight",
	    	forcePlaceholderSize: true,
	    	start: function() {
		        $(".item").css("border","1px solid #3a87ad");
		    },
	    	stop: function(event, ui) {
       		 	var itemId = ui.item.attr("id");
       		 	var newPosition = ui.item.index();       		 	
       		 	updatePosition(itemId, newPosition);
       		 	
       		 	$(".item").css("border","1px solid #3a87ad");
       		 	$(".item").css("border-top","none");
       		 	$(".item:first").css("border-top","1px solid #3a87ad");
    		}
	    });
	    

	  });
	  
	  $(function() {
	    $( ".subitem-sortable" ).sortable({
	    	items: "> li.subitem:not(.subitem-form)",
	    	axis: "y",
	    	cursor: "move",
	    	stop: function(event, ui) {
       		 	var itemId = ui.item.attr("id");
       		 	var newPosition = ui.item.index();
				
				updatePosition(itemId, newPosition);
    		}
	    });
	    
	  });
	  
	 
		
 </script>