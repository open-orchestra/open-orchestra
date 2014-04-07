$(document).ready(function() {
	$('a').click(function(){
		var url = $(this).attr('href');
	    $.ajax({
	        'type': 'POST',
	        'url': url,
	        'success': function(response){
	    		$('#content').html(response);
	        }
	    });
	    return false;
	});
	$('li select').change(function(){
		var url = '';
		if($(this).val()){
			url = $(this).parent('li').find('a').attr('href') + '/' + $(this).val();
		}
		else{
			url = $(this).parent('li').find('a').attr('href');
		}
	    $.ajax({
	        'type': 'POST',
	        'url': url,
	        'success': function(response){
	    		$('[id^="dialog-"]').dialog("destroy");
	    		$('#content').html(response);
	        }
	    });
	    return false;
	});
});