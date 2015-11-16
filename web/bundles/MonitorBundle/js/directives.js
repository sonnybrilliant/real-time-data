'use strict'

angular.module('prasaMonitor.directives',[]);

angular.module('prasaMonitor.directives').directive('appVersion',function(version){
	return {
		restrict: 'AE',
		link: function(scope,elem,attrs){
			elem.html(version);
		}
	}	
});