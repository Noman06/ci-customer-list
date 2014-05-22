<div class="page-header">
	<div class="row">
		<div class="col-lg-6">
			<h1>Coding Excersice</h1>
			<p class="lead">This is an example project to demonstrate my skills of HTML, CSS, PHP and JavaScript.</p>
		</div>
	</div>

	<div>

		<!-- Tabs -->
		<ul class="nav nav-tabs" style="margin-bottom: 15px;">
			<li class="active">
				<a href="#prospects" data-toggle="tab">Prospects</a>
			</li>
			<li>
				<a href="#customers" data-toggle="tab">Customers</a>
			</li>
		</ul>

		<!-- Tab content -->
		<div class="tab-content">

			<div id="loader">
			  <h4>Applying actions, please wait...</h4>
			  <div class="bs-component">
          <div class="progress">
            <div class="progress-bar" style="width: 0%;" id="indicator"></div>
          </div>
        </div>
			</div>

			<div class="alert alert-success" id="success">
        <button type="button" class="close" onclick="$('#success').hide()">×</button>
        <span id="success_content"></span>
      </div>

			<!-- Prospects -->
			<div class="tab-pane fade active in" id="prospects" ng-controller="prospectsController">
				<div>
					<div class="input-group" style="width: 79%; float:left;">
	          <span class="input-group-addon">
	          	<i class="glyphicon glyphicon-search"></i>
	          </span>
	          <input type="search" class="form-control" ng-model="search">
	        </div>
	        <div class="input-group" style="width: 20%; float:right">
	        	<button class="btn btn-default" style="width:100%;" ng-click="selectedToCustomer()">
	        		<span class="hidden-sm">Selected</span> to Customer
	        	</button>
	        </div>
	        <div class="clearfix"></div>
	      </div>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th width="5%">
								<input type="checkbox" ng-click="selectAll()" ng-checked="selectedAll"/>
							</th>
							<th># ID</th>
							<th>Name</th>
							<th>State</th>
							<th width="10%">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="prospect in items() | startFrom:currentPage*pageSize | limitTo:pageSize">
							<td>
								<input type="checkbox" ng-click="selectItem(prospect)" ng-checked="prospect.selected"/>
							</td>
							<td>{{ prospect.id }}</td>
							<td>{{ prospect.name }}</td>
							<td>{{ prospect.state }}</td>
							<td>
								<button type="button" ng-click="convert(prospect)" class="btn btn-default btn-sm">Convert to Customer</button>
							</td>
						</tr>
					</tbody>
				</table>

				<!-- Pagination -->
				<ul class="pagination pagination-lg">
          <li ng-class="{ disabled: !currentPage }">
          	<a href="javascript:void(0)" ng-click="goBack()">«</a>
          </li>
          <li class="disabled">
          	<a href="javascript:void(0)">Page {{currentPage+1}} of {{ numberOfPages() || 1 }}</a>
          </li>
          <li ng-class="{ disabled: (currentPage == numberOfPages()-1) || !numberOfPages() }">
          	<a href="javascript:void(0)" ng-click="goNext()">»</a>
          </li>
        </ul>
			</div>

			<!-- Customers -->
			<div class="tab-pane fade" id="customers" ng-controller="customersController">
				<div>
					<div class="input-group" style="width:47%; float:left;">
	          <span class="input-group-addon">
	          	<i class="glyphicon glyphicon-search"></i>
	          </span>
	          <input type="search" class="form-control" ng-model="search">
	        </div>
	         <div class="input-group" style="width:20%; float:left;">
	        	<select class="form-control" ng-model="stateFilter">
	        		<option value="">All States</option>
	        		<option value="{{state}}" ng-repeat="state in states">{{ state }}</option>
	        	</select>
	        </div>
	        <div class="input-group" style="width:20%; float:left;">
	        	<select class="form-control" ng-model="typeFilter">
	        		<option value="">All Types</option>
	        		<option value="{{type}}" ng-repeat="type in types">{{ type }}</option>
	        	</select>
	        </div>
	        <div class="input-group" style="width:9%; float:right;">
	        	<button class="btn btn-danger" ng-click="removeSelected()" ng-disabled="!selectedItems()">
	        		<i class="glyphicon glyphicon-trash"></i> Remove <span class="hidden-sm">Selected</span>
	        	</button>
	        </div>
	        <div class="clearfix"></div>
	       </div>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th width="5%">
								<input type="checkbox" ng-click="selectAll()" ng-checked="selectedAll"/>
							</th>
							<th># ID</th>
							<th>Name</th>
							<th>State</th>
							<th>Type</th>
							<th width="10%">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="customer in items() | startFrom:currentPage*pageSize | limitTo:pageSize">
							<td>
								<input type="checkbox" ng-click="selectItem(customer)" ng-checked="customer.selected"/>
							</td>
							<td>{{ customer.id }}</td>
							<td>{{ customer.name }}</td>
							<td>{{ customer.state }}</td>
							<td>{{ customer.type }}</td>
							<td>
								<Button class="btn btn-default" ng-click="edit(customer)">
									<i class="glyphicon glyphicon-edit"></i>
								</Button>
								<Button class="btn btn-danger" ng-click="remove(customer)">
									<i class="glyphicon glyphicon-trash"></i>
								</Button>
							</td>
						</tr>
					</tbody>
				</table>

				<!-- Pagination -->
				<ul class="pagination pagination-lg">
          <li ng-class="{ disabled: !currentPage }">
          	<a href="javascript:void(0)" ng-click="goBack()">«</a>
          </li>
          <li class="disabled">
          	<a href="javascript:void(0)">Page {{currentPage+1}} of {{ numberOfPages() || 1 }}</a>
          </li>
          <li ng-class="{ disabled: (currentPage == numberOfPages()-1) || !numberOfPages() }">
          	<a href="javascript:void(0)" ng-click="goNext()">»</a>
          </li>
        </ul>

        <!-- Modal Form -->
        <div class="modal" id="modal_form">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				        <h4 class="modal-title" id="form_title"></h4>
				      </div>
				      <div class="modal-body">
				        <div class="form-horizontal">
								  <fieldset>
								    <div class="form-group" ng-class="{ 'has-success': currentCustomer.name && currentCustomer.name.length >= 3 && currentCustomer.name.length <= 32, 'has-error': currentCustomer.name && currentCustomer.name.length < 3 || currentCustomer.name.length > 32 }">
								      <label for="inputEmail" class="col-lg-2 control-label">Name</label>
								      <div class="col-lg-10">
								        <input onkeypress="return alphaOnly(event)" type="text" maxlength="32" class="form-control" ng-model="currentCustomer.name" placeholder="Name">
								        <p class="text-danger" ng-show="currentCustomer.name && currentCustomer.name.length < 3 || currentCustomer.name.length > 32">Name must contains between 3 and 32 characters.</p>
								      </div>
								    </div>
								    <div class="form-group">
								      <label for="select" class="col-lg-2 control-label">State</label>
								      <div class="col-lg-10">
								        <select class="form-control" ng-model="currentCustomer.state" placeholder="Select type">
								          <option ng-repeat="state in states">{{ state }}</option>
								        </select>
								      </div>
								    </div>
								    <div class="form-group">
								      <label for="select" class="col-lg-2 control-label">Type</label>
								      <div class="col-lg-10">
								        <select class="form-control" ng-model="currentCustomer.type">
								          <option ng-repeat="type in types">{{ type }}</option>
								        </select>
								      </div>
								    </div>
								  </fieldset>
								</div>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="closeModal()">Close</button>
				        <button type="button" class="btn btn-primary" ng-click="update()" ng-disabled="!currentCustomer.name || currentCustomer.name.length < 3 || currentCustomer.name.length > 32">Save changes</button>
				      </div>
				    </div>
				  </div>
				</div>

			</div>

		</div>
	</div>
</div>