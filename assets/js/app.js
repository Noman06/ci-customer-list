var app = angular.module('app', []);

// Pagination filter
app.filter('startFrom', function() {
    return function(input, start) {
        input = input || [];
        start = +start;
        return input.slice(start);
    };
});

// Generic success
var showSuccess = function(message){
  $('#success_content').html(message);
  $('#success').show();
  setTimeout(function(){
    $('#success').fadeOut('slow');
  }, 1000 * 5);
};

function alphaOnly(e) {
    var k;
    document.all ? k = e.keyCode : k = e.which;
    return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
}

// Prospects controller
app.controller('prospectsController', ['$scope', '$rootScope', function($scope, $rootScope){
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

  $scope.selectedToCustomer = function(){
      var to_convert = 0, converted = 0;
      $('#loader').show();
      var selected = _.filter($scope.prospects, function(prospect){
        return prospect.selected;
      });
      _.each(selected, function(prospect){
        prospect.selected = false;
        $scope.convert(prospect, true, function(){
          converted++;
          $('#indicator').css('width', (converted / selected.length * 100) + '%');
          if(selected.length === converted){
            $('#loader').hide();
            $('#indicator').css('width', 0);
            showSuccess('Selected prospects has been converted to Customers successfully');
          }
        });
      });

    $scope.selectedAll = false;
  };

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

  $scope.convert = function(prospect, skip_notification, callback){
    $.post('customer/create', {
      name        : prospect.name,
      state       : prospect.state,
      prospect_id : prospect.id
    }, function(result){
      $rootScope.$emit('created_customer');

      if(callback){
        callback();
      }
    });

    if(!skip_notification){
      showSuccess('A new customer named ' + prospect.name + ' has been created successfully.');
    }
  };

}]);

// Customers controller
app.controller('customersController', ['$scope', '$rootScope', function($scope, $rootScope){
  $scope.typeFilter = '';
  $scope.customers = [];
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

  $scope.getAll = function(){
    $.getJSON('customer/get_all', function(data){
      $scope.customers = data || [];

      if(!$scope.$$phase){
        $scope.$apply();
      }
    });
  };

  $scope.getAll();

  $rootScope.$on('created_customer', function(){
    $scope.getAll();
  });

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
      if($scope.typeFilter){
        items = _.filter(items, function(item){
          return item.type === $scope.typeFilter;
        });
      }
      if($scope.stateFilter){
        items = _.filter(items, function(item){
          return item.state === $scope.stateFilter;
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
    $scope.currentCustomer = _.clone(customer);
    $('#form_title').html('Modifying ' + customer.name);
    $('#modal_form').modal('show');
  };

  $scope.update = function(){

    $('#modal_form').modal('hide');

    $.post('customer/update', {
      id    : $scope.currentCustomer.id,
      name  : $scope.currentCustomer.name,
      state : $scope.currentCustomer.state,
      type  : $scope.currentCustomer.type
    }, function(response){

      showSuccess('Customer updated successfully');

      $scope.currentCustomer = null;
      $scope.getAll();
      if(!$scope.$$phase){
        $scope.$apply();
      }
    });
  };

  $scope.closeModal = function(){
    $('#modal_form').modal('hide');
    $scope.currentCustomer = null;
  };

  $scope.selectedItems = function(){
    var selected = false;
    _.each($scope.customers, function(item){
      if(item.selected){
        selected = true;
      }
    });
    return selected;
  };

  $scope.removeSelected = function(){
    if( confirm('Are you sure?') ){
      var to_remove = 0, removed = 0;
      $('#loader').show();
      var selected = _.filter($scope.customers, function(customer){
        return customer.selected;
      });
      _.each(selected, function(customer){
        $scope.deleteCustomer(customer, true, function(){
          removed++;
          $('#indicator').css('width', (removed / selected.length * 100) + '%');
          if(selected.length === removed){
            $('#loader').hide();
            $('#indicator').css('width', 0);
            showSuccess('Selected customers removed successfully');
            $scope.getAll();
          }
        });
      });
    }
  };

  $scope.remove = function(item) {
    if( confirm('Are you sure?') ){
      $scope.deleteCustomer(item);
    }
  };

  $scope.deleteCustomer = function(customer, skip_notification, callback){
    $.post('customer/remove', { id: customer.id }, function(){
      if(!skip_notification){
        showSuccess('Customer has been removed successfully');
      }
      if(callback){
        callback();
      }
    });
    $scope.getAll();
  };

}]);