var app = angular.module('app', []);

// Pagination filter
app.filter('startFrom', function() {
    return function(input, start) {
        input = input || [];
        start = +start;
        return input.slice(start);
    };
});

// Prospects controller
app.controller('prospectsController', ['$scope', function($scope){
  $scope.search = '';

  $scope.selectedAll = false;
  $scope.selectAll = function(){
    $scope.selectedAll = !$scope.selectedAll;

    _.each($scope.prospects, function(item){
      item.selected = $scope.selectedAll;
    });
  };

  $scope.selectItem = function(item){
    item.selected = !item.selected;
    $scope.selectedAll = false;
  };

  // To generate unique ids.
  function s4() {
    return Math.floor((1 + Math.random()) * 0x10000)
               .toString(16)
               .substring(1);
  }
  var guid = (function() {
    return function() {
      return s4() + s4() + s4();
    };
  })();

  $scope.prospects = [];

  // Just to assign a random string
  $scope.states    = ['NV', 'AA', 'BB', 'CC', 'DD', 'EE', 'EF', 'EG', 'EH', 'FF'];

  // Generate prospects
  for (var i = 0; i < 150; i++){
    $scope.prospects.push({
      id    : guid(),
      name  : 'Prospect ' + s4(),
      state : $scope.states[ Math.round( Math.random() * ($scope.states.length-1) ) ]
    });
  }

  $scope.items = function(){
      var items = $scope.prospects || [];
      if($scope.search){
          items = _.filter(items, function(item){
              var regex        = new RegExp($scope.search, 'gi');
              return regex.test(item.name) || regex.test(item.id) || regex.test(item.state);
          });
      }
      return items;
  };

  $scope.currentPage = 0;
  $scope.pageSize    = 10;

  $scope.numberOfPages = function(){
      return Math.ceil($scope.items().length/$scope.pageSize);
  };

  $scope.goBack = function(){
      if($scope.currentPage === 0) return;
      $scope.currentPage = $scope.currentPage-1;
  };

  $scope.goNext = function(){
      if($scope.currentPage >= $scope.items().length/$scope.pageSize - 1 || $scope.numberOfPages() == 1) return;
      $scope.currentPage = $scope.currentPage+1;
  };

  $scope.convert = function(prospect){
    $('#success_content').html('A new customer named ' + prospect.name + ' has been created successfully.');
    $('#success').show();
    setTimeout(function(){
      $('#success').fadeOut('slow');
    }, 1000 * 5);
  };

}]);

// Customers controller
app.controller('customersController', ['$scope', function($scope){
  $scope.customers = [{ id: 123, name:'asdssd' }];
  $scope.search    = '';
  $scope.states    = [
    'NV',
    'AA',
    'BB',
    'CC',
    'DD',
    'EE',
    'EF',
    'EG',
    'EH',
    'FF'
  ];
  $scope.types     = [
    'Type A',
    'Type B',
    'Type C'
  ];

  $scope.selectedAll = false;
  $scope.selectAll = function(){
    $scope.selectedAll = !$scope.selectedAll;

    _.each($scope.customers, function(item){
      item.selected = $scope.selectedAll;
    });
  };

  $scope.selectItem = function(item){
    item.selected = !item.selected;
    $scope.selectedAll = false;
  };

  $scope.items = function(){
      var items = $scope.customers || [];
      if($scope.search){
          items = _.filter(items, function(item){
              var regex        = new RegExp($scope.search, 'gi');
              return regex.test(item.name) || regex.test(item.id) || regex.test(item.state) || regex.test(item.type);
          });
      }
      return items;
  };

  $scope.currentPage = 0;
  $scope.pageSize    = 10;

  $scope.numberOfPages = function(){
      return Math.ceil($scope.items().length/$scope.pageSize);
  };

  $scope.goBack = function(){
      if($scope.currentPage === 0) return;
      $scope.currentPage = $scope.currentPage-1;
  };

  $scope.goNext = function(){
      if($scope.currentPage >= $scope.items().length/$scope.pageSize - 1 || $scope.numberOfPages() == 1) return;
      $scope.currentPage = $scope.currentPage+1;
  };

  $scope.edit = function(customer){
    $scope.currentCustomer = customer;
    $('#form_title').html('Modifying ' + customer.name);
    $('#modal_form').modal('show');
  };

  $scope.update = function(){
    $scope.currentCustomer = null;
  };

  $scope.closeModal = function(){
    $('#modal_form').modal('hide');
    $scope.currentCustomer = null;
  };

}]);