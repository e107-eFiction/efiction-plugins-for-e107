$(document).ready(function()
{

$(document).on("click", ".efiction-comment-submit", function(){
			
			var url		= $(this).attr("data-target");
			var sort	= $(this).attr("data-sort");
			var pid 	= parseInt($(this).attr("data-pid"));
			var formid 	= (pid != '0') ? "#efiction-comment-form-reply" : "#efiction-comment-form";
			var data 	= $('form'+formid).serializeArray() ;
			var total 	= parseInt($("#efiction-comment-total").text());
			var container =  '#' + $(this).attr("data-container");
			var input 	=  '#' + $(this).attr("data-input");

			//TODO replace _POST['comment'] with $(input).val() so we can rename 'comment' in the form to something unique. 
			//console.log(formid);

			$.ajax({
			  type: 'POST',
			  url: url + '?ajax_used=1&mode=submit',
			  data: data,
			  success: function(data) {
			  	
			   
			 	//console.log(data);
			  	var a = $.parseJSON(data);

				$(input).val('');
				
				if(pid != 0)
				{
					$('#comment-'+pid).after(a.html).hide().slideDown(800);	
				}
				else if(sort == 'desc')
				{
					$(container).prepend(a.html).hide().slideDown(800);	// FIXME - works in jquery 1.7, not 1.8
				}
				else
				{
					$(container).append(a.html).hide().slideDown(800); // FIXME - works in jquery 1.7, not 1.8
					alert('Thank you for commenting'); // possibly needed as the submission may go unoticed	by the user
				}  
				
				if(!a.error)
				{
					$("#efiction-comment-total").text(total + 1);

					if(pid != '0')
					{
						$(formid).hide();		
					}	
					
				}
				else
				{
					alert(a.msg);	
				}
			  	return false;	
			  }
			});
			
			return false;

		});






    $(document).on("click", ".efiction-comment-reply", function(){
			
			var url 	= $(this).attr("data-target");
			var table 	= $(this).attr("data-type");
			var sp 		= $(this).attr('id').split("-");
			var id 		= "#comment-" + sp[3];

			var present = $('#efiction-comment-form-reply'); 
		//	console.log(present);
			


			if($('.efiction-comment-edit-save').length !== 0 || $('#efiction-comment-form-reply').length !== 0 ) //prevent creating save button twice.
			{
				return false;
			}

			$.ajax({
			  type: 'POST',
			  url: url + '?ajax_used=1&mode=reply',
			  data: { itemid: sp[3], table: table },
			  success: function(data) {

			 // 	alert(url);
			  	var a = $.parseJSON(data);

				if(!a.error)
				{
					// alert(a.html);
					 $(id).after(a.html).hide().slideDown(800);
				}

			  }
			});
		
			return false;		
	});


	$(document).on("click", ".efiction-comment-edit", function(){
			
        var url = $(this).attr("data-target");
        var sp = $(this).attr('id').split("-");
        var id = "#comment-" + sp[3] + "-edit";

        if($('.efiction-comment-edit-save').length != 0) //prevent creating save button twice.
        {
            return false;
        }

        $(id).attr('contentEditable',true);
        $(id).after("<div class='efiction-comment-edit-save'><input data-target='"+url+"' id='efiction-comment-edit-save-"+sp[3]+"' class='button btn btn-success efiction-comment-edit-save' type='button' value='Save' /></div>");
        $('div.efiction-comment-edit-save').hide().fadeIn(800);
        $(id).addClass("efiction-comment-edit-active");
        $(id).focus();
        return false;
	});


    $(document).on("click", "input.efiction-comment-edit-save", function(){
			
			var url 	= $(this).attr("data-target");
			var sp 		= $(this).attr('id').split("-");	
			var id 		= "#comment-" + sp[4] + "-edit";
			var comment = $(id).text();


			$(id).attr('contentEditable',false);
			
		        $.ajax({
		            url: url + '?ajax_used=1&mode=edit',
		            type: 'POST',
		            data: {
		            	comment: comment,
		            	itemid: sp[4]
		            },
		            success:function (data) {
		            
		            	var a = $.parseJSON(data);
		            
		            	if(!a.error)
		            	{
		            	 	$("div.efiction-comment-edit-save")
		            	 	.hide()
		                    .addClass("alert alert-success efiction-comment-edit-success")
		                    .html(a.msg)
		                    .fadeIn('slow')
		                    .delay(1500)
		                    .fadeOut(2000);
		                    
						}
						else
						{
							 $("div.efiction-comment-edit-save")
		                    .addClass("alert alert-danger efiction-comment-edit-error")
		                    .html(a.msg)
		                    .fadeIn('slow')
		                    .delay(1500)
		                    .fadeOut('slow');				
						}
		            	$(id).removeClass("efiction-comment-edit-active");
		            	
		            	setTimeout(function() {
						  $('div.efiction-comment-edit-save').remove();
						}, 2000);

		            //	.delay(1000);
		            //	alert(data);
		            	return;
		            }
		        });
		 
			
		});



    $(document).on("click", ".efiction-comment-delete", function(){
			
			var url 	= $(this).attr("data-target");
			var table 	= $(this).attr("data-type");
			var itemid 	= $(this).attr("data-itemid");
			var sp 		= $(this).attr('id').split("-");	
			var id 		= "#comment-" + sp[3];
			var total 	= parseInt($("#efiction-comment-total").text());
	
			$.ajax({
			  type: 'POST',
			  url: url + '?ajax_used=1&mode=delete',
			  data: { id: sp[3], itemid: itemid, table: table },
			  success: function(data) {
			var a = $.parseJSON(data);
			  
				if(!a.error)
				{
					$(id).hide('slow');
					$("#efiction-comment-total").text(total - 1);	
				}

			  }
			});
			
			return false;

		});

    $(document).on("click", ".efiction-comment-approve", function() {
			
			var url = $(this).attr("data-target");
			var sp = $(this).attr('id').split("-");	
			var id = "#comment-status-" + sp[3];
	
			$.ajax({
			  type: 'POST',
			  url: url + '?ajax_used=1&mode=approve',
			  data: { itemid: sp[3] },
			  success: function(data) {
	
			  
			var a = $.parseJSON(data);
			
	
				if(!a.error)
				{		
					//TODO modify status of html on page 	
					 $(id).text(a.html)
					 .fadeIn('slow')
					 .addClass('efiction-comment-edit-success'); //TODO another class?
					 
					 $('#efiction-comment-approve-'+sp[3]).hide('slow');
				}
				else
				{
					alert(a.msg);	
				}
			  }
			});
			
			return false;

		});
});
