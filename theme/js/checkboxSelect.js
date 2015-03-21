$(function(){
	$('#todos').click(function(event) {   
		if(this.checked) {
			$(':checkbox').each(function() {
				this.checked = true;                        
			});
		}
		if(!this.checked) {
			$(':checkbox').each(function() {
				this.checked = false;                        
			});
		}
	});
});