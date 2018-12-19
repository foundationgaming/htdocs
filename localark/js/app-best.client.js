

var app = angular.module('ark_calculator', ['ngMaterial']);

app.directive('lineItem', function() {
	return {
		restrict: 'E',
		scope: {},
		templateUrl: 'line-item.html',
		controller: function($rootScope, $scope, $element) {
			$scope.querySearch = $rootScope.querySearch;
			$scope.getImagePath = $rootScope.getImagePath;
			$scope.getResourceAmount = $rootScope.getResourceAmount;
			$scope.resource = $rootScope.resource;
			$scope.amountFormatted = $rootScope.amountFormatted;
			$scope.selectedItem = JSON.parse($element.attr('data-item'));
			$scope.totalResources = [];
			$scope.amount = 1;
			$scope.type = "LineItem";

			$rootScope.updateTotalBaseResources();

			$scope.updateLineItemTotal = function(amount) {
				// console.log(amount);
				$rootScope.updateTotalBaseResources();
				$rootScope.restartLogging();
			}

			$scope.delete = function(e) {
				$element.remove();
				$scope.$destroy();
				$rootScope.updateTotalBaseResources();
				$rootScope.clearLog();
			}

			$scope.showDelete = function(e) {
				console.log(event);
				console.log($($(event).find('.md-btn-img-small')).css('display', 'none'));
			}
		}
	}
});

app.filter('isEmpty', function () {
    return function (obj) {
        for (key in obj) {
            if (obj.hasOwnProperty(key)) {
                return false;
            }
        }
        return true;
    };
});

app.controller('ArkCtrl', ['$rootScope', '$scope', '$compile', '$element', '$filter', '$mdDialog', '$mdMedia', '$mdToast',
function($rootScope, $scope, $compile, $element, $filter, $mdDialog, $mdMedia, $mdToast) {
	$rootScope.totalBaseResources = {};
	$rootScope.items = [];
	$rootScope.resourceItems = [];
	$rootScope.showMoreFiltersOn = false;
	$rootScope.listOn = true;
	$rootScope.balls = [12,12,3,4,5,67,8,85,2,35,2];
	this.balls = [12,12,3,4,5,67,8,85,2,35,2];

	initializeFilters();

	// Loads items at start.
	$.ajax({
		type: 'get',
		url: '/items/getNonResourceItems',
		success: function(results) {
			$rootScope.items = results;
			// console.log(results);
			$.ajax({
				type: 'get',
				url: '/items/getResourceItems',
				success: function(results2) {
					// $rootScope.items = results2;
					$rootScope.resourceItems = results2;
					// console.log(results);
					$('.loading-item').addClass("hidden");
					$rootScope.$apply();
				},
				error: function(err) {
					console.log(err);
				}
			});
		},
		error: function(err) {
			console.log(err);
		}
	});

	

	// $.ajax({
	// 	type: 'get',
	// 	url: '/items/getAllItems',
	// 	async: false,
	// 	success: function(results) {
	// 		console.log(results);
	// 		// $rootScope.items = results;
	// 	},
	// 	error: function(err) {
	// 		console.log(err);
	// 	}
	// });

	$rootScope.numFormatted = function(num) {
		// if (num / )
		// console.log(num);
    	return (num - Math.floor(num) > 0 ? num.toFixed(2) : num);
    }

    // amount is the amount of items the user wants.
    // resAmount is the resource amount needed to craft that item.
    // Yields is how many items will be crafted at one time.
    $rootScope.amountFormatted = function(amount, resAmount, yields) {
		// if (num / )
		// console.log(num);
		var num = amount * resAmount / (yields > 0 ? yields : 1);

    	// return (amount % yields == 0 ? Math.round(num).toFixed(0) : num.toFixed(2));
    	return $rootScope.numFormatted(num);
    }

	$rootScope.getResourceAmount = function(resourceAmount, amount) {
		// console.log('Getting resource amount');
		var total = resourceAmount * amount;

		if(total % 1 != 0) {
			// console.log('Getting resource amount');
			total = total.toFixed(2);

			// console.log(total - Math.floor(total) );
			if( total - Math.floor(total) >= .9 || total - Math.floor(total) == 0 ) {
				total = Math.round(total);
			}
		}
		return total;
	}

	$rootScope.getItem = function(name) {
		for (var i = 0; i < $rootScope.resourceItems.length; i++) {
			let item = $rootScope.resourceItems[i];
			if (item.displayName == name || item.name == name)
				return item;
			for (var j = 0; j < item.altNames.length; j++) {
				if (item.altNames[j] == name)
					return item;
			}
		}
		return null;
	}

	$rootScope.getTotalWeight = function() {
		let total = 0;

		for (var key in $rootScope.totalBaseResources) {
			if ( $rootScope.totalBaseResources.hasOwnProperty(key) ) {
				let item = $rootScope.getItem(key);

				total += $rootScope.totalBaseResources[key] * item.weight;
			}
		}
		return total.toFixed(1);

	}

	/*
	* 	getTotal()
	*
	* 	Gets the total base resources. Mainly for displaying
	*	the total base resources.
	*/
	$rootScope.getTotalBaseResources = function() {
		return $rootScope.totalBaseResources;
	}

	$rootScope.geTotalResources = function() {
		return 
	}

	/*
	* 	getTotalSpecific()
	*
	* 	Gets the total amount of resources of the specified item
	* 	from the totalBaseResources.
	*
	*	object item - item to be added
	*/
	$rootScope.getTotalSpecific = function(itemName) {
		for (var key in $rootScope.totalBaseResources) {
			if ( key == itemName && $rootScope.totalBaseResources.hasOwnProperty(key) ) {
				var total = $rootScope.totalBaseResources[key];

				if(total % 1 != 0 && decimalPlaces(total) > 2) {
					total = total.toFixed(2);

					if( total - Math.floor(total) >= .9 || total - Math.floor(total) == 0 ) {
						total = Math.round(total);
					}
				}
				return total;
			}
		}
		return 0;
	}

	function decimalPlaces(num) {
	  var match = (''+num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
	  if (!match) { return 0; }
	  return Math.max(
	       0,
	       // Number of digits right of decimal point.
	       (match[1] ? match[1].length : 0)
	       // Adjust for scientific notation.
	       - (match[2] ? +match[2] : 0));
	}

	/*
	* 	addLineItem()
	*
	* 	Adds a line item directive, based on the item selected, to the
	*	items section.
	*
	*	object item - item to be added
	*/
	$rootScope.addLineItem = function(item) {
		var ChildHeads = [$scope.$$childHead];
		var currentScope;
		var itemExists = false;
		// console.log(item);
		if (ChildHeads.length) {
			currentScope = ChildHeads.shift();
			while (currentScope) {
				// Do resource calculations
				if( currentScope.selectedItem && currentScope.selectedItem.name == item.name) {

					// console.log('exists');
					itemExists = true;
					currentScope.amount++;
					$rootScope.updateTotalBaseResources();
					break;
				}

				currentScope = currentScope.$$nextSibling;
			}
		}

		if (!itemExists) {
			var divElement = angular.element(document.querySelector('#items'));
			// Creates the line item with a stringify item object so that it can be parsed,
			// and used during initialization of the directive to initialize the selectedItem as
			// the given item.
			var lineItem = $('<line-Item>').attr('data-item', JSON.stringify(item));
			var appendHtml = $compile(lineItem)($scope);
			divElement.append(appendHtml);
		}

		$rootScope.restartLogging();
	};

	/*
	* 	updateTotalBaseResources()
	*
	* 	Traverse through all the items and calculate the total base resources
	*	then update the root scope's total base resources.
	*/
	$rootScope.updateTotalBaseResources = function() {
		// console.log('Root Update Total Base Resources')
		var ChildHeads = [$scope.$$childHead];
		var currentScope;
		var newTotalResources = {};

		if (ChildHeads.length) {
			currentScope = ChildHeads.shift();
			while (currentScope) {

				// Do resource calculations
				if( currentScope.selectedItem ) {
					// console.log(currentScope);
					var curScopeTotalResources = getTotalBaseResources(currentScope.selectedItem, currentScope.amount);
					// console.log(curScopeTotalResources);
					newTotalResources = combineResources(newTotalResources, curScopeTotalResources);
				}

				currentScope = currentScope.$$nextSibling;
			}
		}

		$rootScope.totalBaseResources = newTotalResources;
		// console.log($rootScope.totalBaseResources);
	};

	// $rootScope.updateTotalResources = function() {
	// 	// console.log('Root Update Total Base Resources')
	// 	var ChildHeads = [$scope.$$childHead];
	// 	var currentScope;
	// 	var newTotalResources = {};

	// 	if (ChildHeads.length) {
	// 		currentScope = ChildHeads.shift();
	// 		while (currentScope) {

	// 			// Do resource calculations
	// 			if( currentScope.selectedItem ) {
	// 				// console.log(currentScope);
	// 				var curScopeTotalResources = getTotalBaseResources(currentScope.selectedItem, currentScope.amount);
	// 				var thisResources = currentScope.selectedItem.resources;
	// 				var resources = [];
	// 				console.log("this")
	// 				console.log(thisResources);
	// 				console.log('total');
	// 				console.log(newTotalResources);
	// 				for (var i = thisResources.length - 1; i >= 0; i--) {
	// 					resources.push({
	// 						item: thisResources[i],

	// 				}
	// 				// console.log(curScopeTotalResources);
	// 				newTotalResources = combineResources(newTotalResources, curScopeTotalResources);
	// 			}

	// 			currentScope = currentScope.$$nextSibling;
	// 		}
	// 	}

	// 	$rootScope.totalBaseResources = newTotalResources;
	// 	// console.log($rootScope.totalBaseResources);
	// };

	/*
	* 	combineResources()
	*
	* 	Computes the total of two resources.
	*
	*	array res1 - array of items
	*	array res2 - array of items
	*/
	function combineResources(res1, res2) {
		var combinedResources = {};
		if(res1 && res2) {
			for (var k in res1) {
				if (res1.hasOwnProperty(k)) {
					combinedResources[k] = res1[k];
				}
			}

			for (var k in res2) {
				if (res2.hasOwnProperty(k)) {
					if(combinedResources.hasOwnProperty(k)) {
						combinedResources[k] += res2[k];
					}
					else {
						combinedResources[k] = res2[k];
					}
				}
			}
		}

		return combinedResources;
	}

	/*
	*	querySearch()
	*
	*	For querying a set of data in the autocomplete directive.
	*
	*	string query - a substring that the user wants to find.
	*/
	$rootScope.querySearch = function(query) {
		console.log($rootScope.items);
		var results = query ? $rootScope.items.filter( createFilterFor(query) ) : $rootScope.items,
		  deferred;
		if (self.simulateQuery) {
			deferred = $q.defer();
			$timeout(function () { deferred.resolve( results ); }, Math.random() * 1000, false);
				return deferred.promise;
		} else {
			return results;
		}
	}

	/*
	* 	createFilterFor()
	*
	*	For finding an item base on it's name and the given query.
	*
	*	Returns whether or not the item base on the query exists.
	*/
	function createFilterFor(query) {
		var lowercaseQuery = angular.lowercase(query);

		return function filterFn(item) {
			return (item.name.toLowerCase().indexOf(lowercaseQuery) >= 0);
		};
	}

	/*
	*	nonResourceFilter()
	*
	*	Return whether the item is a non-resource or not.
	*/
	function nonResourceFilter (item) {
    	return ($rootScope.nonResourceFilterOn && item.resources && item.resources.length > 0);
    }

    $rootScope.nonResourceFilter = nonResourceFilter;

    function structureFilter (item) {
    	return ($rootScope.structureFilterOn && item.types.indexOf('Structure') >= 0);
    }

    function equipmentFilter (item) {
    	return ($rootScope.equipmentFilterOn && item.types.indexOf('Equipment') >= 0);
    }

    function weaponFilter (item) {
    	// console.log(item.types);
    	return ($rootScope.weaponFilterOn && item.types.indexOf('Weapon') >= 0);
    }

    function armorFilter (item) {
    	return ($rootScope.armorFilterOn && item.types.indexOf('Armor') >= 0);
    }

    function consumableFilter (item) {
    	return ($rootScope.consumableFilterOn && item.types.indexOf('Consumable') >= 0);
    }





    function ammoFilter (item) {
    	return ($rootScope.ammoFilterOn && item.types.indexOf('Ammo') >= 0);
    }

    function saddleFilter (item) {
    	// console.log(item.types);
    	return ($rootScope.saddleFilterOn && item.types.indexOf('Saddle') >= 0);
    }

    function farmFilter (item) {
    	return ($rootScope.farmFilterOn && item.types.indexOf('Farming') >= 0);
    }

    function recipeFilter (item) {
    	return ($rootScope.recipeFilterOn
    		&& (item.types.indexOf('Recipe') >= 0 || item.types.indexOf('Dish') >= 0));
    }

    function attachmentFilter (item) {
    	return ($rootScope.attachmentFilterOn && item.types.indexOf('Attachment') >= 0);
    }

    function toolFilter (item) {
    	// console.log(item.types);
    	return ($rootScope.toolFilterOn && item.types.indexOf('Tool') >= 0);
    }

    function dyeFilter (item) {
    	return ($rootScope.dyeFilterOn && item.types.indexOf('Dye') >= 0);
    }

    function questFilter (item) {
    	return ($rootScope.questFilterOn && item.types.indexOf('Quest') >= 0);
    }

    $rootScope.getItems = function() {
    	// console.log('getting items');
    	return $rootScope.items.filter(function(item) {
    		var valid = nonResourceFilter(item)
    			|| structureFilter(item)
				|| armorFilter(item)
				|| weaponFilter(item)
				|| consumableFilter(item)
				|| ammoFilter (item)
				|| saddleFilter (item)
				|| farmFilter (item)
				|| recipeFilter (item)
				|| attachmentFilter (item)
				|| toolFilter (item)
				|| dyeFilter (item)
				|| questFilter (item)
				|| ( allFilterIsOff() );

			// console.log(filterIsOff());
    		return valid;
    	});
    }

    function allFilterIsOff() {
    	return !$rootScope.structureFilterOn
				&& !$rootScope.armorFilterOn
				&& !$rootScope.weaponFilterOn
				&& !$rootScope.consumableFilterOn
				&& !$rootScope.ammoFilterOn
				&& !$rootScope.saddleFilterOn
				&& !$rootScope.farmFilterOn
				&& !$rootScope.recipeFilterOn
				&& !$rootScope.attachmentFilterOn
				&& !$rootScope.toolFilterOn
				&& !$rootScope.dyeFilterOn
				&& !$rootScope.questFilterOn;
    }

	/*
	* 	getImagePath()
	*
	* 	Gets the full image path of the item, given the image name and size.
	*
	*	string imgName - the name of the image.
	*	int imgSize - the pixel size of the image.
	*/
	$rootScope.getImagePath = function(imgName, imgSize) {
		if(imgName) {
			var imgNameActual = '';

			if(imgSize) {
				imgNameActual = imgSize+'px-';
			}

			if(imgName.indexOf('Kibble') >= 0) {
				imgNameActual = imgSize+'px-' + 'Kibble';
			}
			else if(imgName.indexOf(' Dye') >= 0) {
				var nameSplit = imgName.split(' ');
				imgNameActual = imgSize+'px-' + nameSplit[0] + '_Coloring';
			}
			else {
				for(var i = 0; i < imgName.length; i++) {
					if(imgName[i] == ' ') {
						imgNameActual += '_';
					}
					else {
						imgNameActual += imgName[i];
					}
				}
			}

			return 'images/'+imgNameActual+'.png';
		}
		return '';
	};


	/*
	* 	getTotalBaseResources()
	*
	* 	Gets the total base resources of an item.
	*
	*	object item - the item to find the base resource for.
	*	int amount - the amount of the item the user wants.
	*/
	function getTotalBaseResources(item, amount) {
		var totalBaseResources = {};
		// console.log(item);
		// console.log(amount);
		if( !amount || amount < 0) {
			amount = 0;
		}
		if(item && item.resources && item.resources.length > 0) {
			// console.log(item.resources);
			for(var idx = 0; idx < item.resources.length; idx++ ) {
				// Add to total
				// console.log(item.resources[idx].item);
				let yields = item.resources[idx].item.yields || 1;
				var baseResources = getTotalBaseResources(item.resources[idx].item, item.resources[idx].amount / yields);
				// console.log('done');
				// console.log(baseResources);
				for (var k in baseResources){
				    if (typeof baseResources[k] !== 'function' && typeof baseResources[k] !== undefined) {
				    	if( totalBaseResources[k] ) {
				    		totalBaseResources[k] += baseResources[k] * amount;
				    	}
				    	else {
				    		totalBaseResources[k] = baseResources[k] * amount;	
				    	}
				    }
				}
			}
		}
		// If the last item, which doesn't have an amount.
		else if( item ) {
			if( item.name )
				totalBaseResources[item.name] = amount / (item.yields || 1);
		}
		else {
			// console.log("wtf");
			// console.log(item);
		}
		// console.log(totalBaseResources);
		return totalBaseResources;
	}

	$rootScope.totalBaseResourcesEmpty = function() {
		return $rootScope.totalBaseResources.length == 0;
	}

	$rootScope.toggleListView = function() {
		$rootScope.listOn = !$rootScope.listOn;
	}

	$rootScope.toggleFilter = function(filter, e) {
		// console.log(filter);
		// console.log($rootScope[filter]);
		$rootScope[filter] = !$rootScope[filter];
		var thisElement = $(e.currentTarget);
		if ($rootScope[filter]) {
			thisElement.addClass('selected');
			thisElement.find('.after').addClass('selected');
		}
		else {
			thisElement.removeClass('selected');
			thisElement.find('.after').removeClass('selected');
		}
	}

	$rootScope.toggleMoreFilter = function() {
		if( !$rootScope.showMoreFiltersOn ) {
			var filters = $('#filter-image-wrapper .filter');
			var numFilters = filters.length;
			var i = 0;
			$('#toggle-more-filter').text('expand_less');
			$("#filter-image-wrapper").animate({
		        height: "250px"
		    }, 500, function() {
		    	$('#filter-image-wrapper .filter').fadeIn('fast');

		    });
		}
		else {
			var filters = $('#filter-image-wrapper .filter');
			var numFilters = filters.length;
			var i = 0;

			$('#toggle-more-filter').text('expand_more');
			filters.fadeOut('fast', function() {
				i++;
				if(i == numFilters) {
					$("#filter-image-wrapper").animate({
				        height: "100px"
				    }, 500);
				}
			});
		}

		$rootScope.showMoreFiltersOn = !$rootScope.showMoreFiltersOn;
	}

	function initializeFilters() {
		$rootScope.filters = [
			{ name: 'Ammunition', img: 'Simple Shotgun Ammo', filter: 'ammoFilterOn' },
			{ name: 'Saddles', img: 'Parasaur Saddle', filter: 'saddleFilterOn' },
			{ name: 'Farm', img: 'Large Crop Plot', filter: 'farmFilterOn' },
			{ name: 'Recipes', img: 'Rockwell Recipes- Battle Tartare', filter: 'recipeFilterOn' },
			{ name: 'Attachments', img: 'Flashlight Attachment', filter: 'attachmentFilterOn' },
			{ name: 'Tools', img: 'GPS', filter: 'toolFilterOn' },
			{ name: 'Dyes', img: 'Red Coloring', filter: 'dyeFilterOn' },
			{ name: 'Quests', img: 'Summon Broodmother', filter: 'questFilterOn' }
		];

		$rootScope.nonResourceFilterOn = false;
		$rootScope.structureFilterOn = false;
		$rootScope.equipmentFilterOn = false;
		$rootScope.weaponFilterOn = false;
		$rootScope.armorFilterOn = false;

		$rootScope.ammoFilterOn = false;
		$rootScope.saddleFilterOn = false;
		$rootScope.farmFilterOn = false;
		$rootScope.recipeFilterOn = false;
		$rootScope.attachmentFilterOn = false;
		$rootScope.toolFilterOn = false;
		$rootScope.dyeFilterOn = false;
		$rootScope.questFilterOn = false;

		// $rootScope.armorFilterOn = false;
		// $rootScope.structureFilter = false;
	}

	$rootScope.sendMail = function() {
		// console.log('Sending mail');
		$.ajax({
			type: 'post',
			url: '/mailer/sendMail',
			success: function(results) {
				// console.log('Mail sent');
				// console.log(results);
			},
			error: function(err) {
				// console.log('There was an error');
				// console.log(err);
			}
		});
	}

	$scope.showAdvanced = function(ev) {
		var useFullScreen = ($mdMedia('sm') || $mdMedia('xs'))  && $scope.customFullscreen;
		$mdDialog.show({
			controller: DialogController,
			templateUrl: 'views/contact.dialog.html',
			parent: angular.element(document.body),
			targetEvent: ev,
			clickOutsideToClose:true,
			fullscreen: useFullScreen
		})
		.then(function(answer) {
			$scope.status = 'You said the information was "' + answer + '".';
		}, function() {
			$scope.status = 'You cancelled the dialog.';
		});
		$scope.$watch(function() {
			return $mdMedia('xs') || $mdMedia('sm');
		}, function(wantsFullScreen) {
			$scope.customFullscreen = (wantsFullScreen === true);
		});
	};

	$rootScope.log = {};

	$rootScope.startLogging = function() {
		// console.log('Logging');
		$rootScope.logTimer = setTimeout(function() {
			var ChildHeads = [$scope.$$childHead];
			var currentScope;
			var itemExists = false;
			var logs = [];

			if (ChildHeads.length) {
				currentScope = ChildHeads.shift();

				while (currentScope) {
					var nextScope = currentScope.$$nextSibling;

					if (currentScope.type == 'LineItem') {
						if(currentScope.selectedItem) {
							logs.push({
								item: currentScope.selectedItem,
								itemName: currentScope.selectedItem.name,
								amount: currentScope.amount
							});
						}
					}

					currentScope = nextScope;
				}
			}

			$.ajax({
				type: 'post',
				url: '/log',
				data: {
					lineItems: logs,
					_id: $rootScope.log._id
				},
				success: function(results) {
					if(results) {
						$rootScope.log = results;
					}
				},
				error: function(err) {
					console.log(err);
				}
			});
		}, 2000);
	}

	$rootScope.restartLogging = function() {
		clearTimeout($rootScope.logTimer);
		$rootScope.startLogging();
	}

	$rootScope.clearLog = function() {
		clearTimeout($rootScope.logTimer);
		delete $rootScope.log;
		$rootScope.log = {};
	}
	function DialogController($scope, $mdDialog) {
	  $scope.hide = function() {
	    $mdDialog.hide();
	  };
	  $scope.cancel = function() {
	  	// console.log('huh');
	    $mdDialog.cancel();
	  };

	  $scope.send = function() {

	  	if($scope.user != undefined && $scope.user.email != undefined && $scope.user.email.length > 0
	  		&& $scope.user.subject != undefined && $scope.user.subject.length > 0) {
	  		$.ajax({
				type: 'post',
				url: '/mailer/sendMail',
				data: $scope.user,
				success: function(results) {
					$scope.hide();
					$scope.showSimpleToast('Mail sent', $(document.body));
				},
				error: function(err) {
					$scope.hide();
					$scope.showSimpleToast('There was an error sending the mail', $(document.body));
				}
			});
	  	}
	  	else {
	  		$scope.showSimpleToast('Please fill in required fields', $('#dialog-content-contact'));
	  	}
	  }

	  $scope.answer = function(answer) {
	    $mdDialog.hide(answer);
	  };

	  var pos = {
	      bottom: true,
	      top: false,
	      left: true,
	      right: false
	    };
	  $scope.toastPosition = angular.extend({},pos);
	  $scope.getToastPosition = function() {
	    sanitizePosition();
	    return Object.keys($scope.toastPosition)
	      .filter(function(pos) { return $scope.toastPosition[pos]; })
	      .join(' ');
	  };
	  function sanitizePosition() {
	    var current = $scope.toastPosition;
	    if ( current.bottom && pos.top ) current.top = false;
	    if ( current.top && pos.bottom ) current.bottom = false;
	    if ( current.right && pos.left ) current.left = false;
	    if ( current.left && pos.right ) current.right = false;
	    pos = angular.extend({}, current);
	  }
	  $scope.showSimpleToast = function(message, parent) {
	    var pinTo = $scope.getToastPosition();
	    $mdToast.show(
	      $mdToast.simple()
	        .textContent(message)
	        .position(pinTo )
	        .hideDelay(3000)
	        .highlightAction(true)
	        .parent(parent)
	    );
	  };
	}
}])