app.service("Services", 
	function() {
		
        this.removeObject = function(array, id){
        	
        	var index = -1;
			_.each(array, function(data, idx) {
				if( typeof(data) != 'undefined' ){
					if ( data.title == id ){
						index = idx;
					}
				}
			});
			array.splice(index, 1);
			
        };
        
        this.alertMessage = function(attr){
        	$(attr).show();
			setTimeout(function(){
				$(attr).hide();
			},1000);
        };
        
 	}
);