var app = angular.module('collabifyApp', [], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
});
 
app.controller('spotifyController', function($scope, $http) {
 
	$scope.playlists = [];
	$scope.loading = false;
 
	$scope.init = function() {
		$scope.loading = true;
		$http.get('/spotify/playlists/').
		success(function(data, status, headers, config) {
			playlists = JSON.parse(data);
			$scope.playlists = playlists;
			$scope.loading = false;
 
		});
	}
 
	$scope.addTodo = function() {
		$scope.loading = true;
 
		$http.post('/api/todos', {
			title: $scope.todo.title,
			done: $scope.todo.done
		}).success(function(data, status, headers, config) {
			$scope.todos.push(data);
			$scope.todo = '';
			$scope.loading = false;
 
		});
	};
 
	$scope.updateTodo = function(todo) {
		$scope.loading = true;
 
		$http.put('/api/todos/' + todo.id, {
			title: todo.title,
			done: todo.done
		}).success(function(data, status, headers, config) {
			todo = data;
			$scope.loading = false;
 
		});;
	};
 
	$scope.deleteTodo = function(index) {
		$scope.loading = true;
 
		var todo = $scope.todos[index];
 
		$http.delete('/api/todos/' + todo.id)
			.success(function() {
				$scope.todos.splice(index, 1);
				$scope.loading = false;
 
			});;
	};
 
 
	$scope.init();
 
});