app.controller(
	'vehicle_brand_ctrl', [
	'$scope'
	, 'Factory'
	, 'Services'
	, function ($scope, Factory, Services){
		
		$scope.header = 'Vehicle Brand';
		$scope.add = function(){			
			$scope.vehicle = '';
		};

		$scope.init = function(){
			Factory.getVehicles({Type: 'brand'}).success(function(data){
				$scope.vehicle_brand = data;console.log(data);
			});
		};
		$scope.init();
		
		$scope.edit = function(params){
			$scope.vehicle = params;
		};
		
		$scope.save = function(params){
			console.log($scope.vehicle);
		};
		
		$scope.remove = function($index, id){
			console.log(id);
			$scope.vehicle_brand.elements.splice($index, 1);
		};
		
	}
]);