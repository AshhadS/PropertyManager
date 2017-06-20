<div class="modal fade" id="agreement-editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog wide" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
              <br>
              <section class="content-header">
                  <h1>Agreement</h1>
              </section>
              <br>
              <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title">Edit</h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal agreement-edit" action="/agreement/update" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="agreementID">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Property Name</label>
                      <div class="col-sm-10">
                        <select name="PropertiesID" class="form-control selection-parent-item" >
                                <option value="0">Select a property</option>
                            @foreach ($properties as $property)
                                <option value="{{$property->PropertiesID}}">{{ $property->pPropertyName }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div> 

                    <div class="form-group">
                      <label name="tenant" class="col-sm-2 control-label">Tenant Name</label>
                      <div class="col-sm-10">
                        <select class="form-control" name="tenantsID">
                                <option value="">Select a tenant</option>
                            @foreach ($tenants as $tenant)
                                <option value="{{$tenant->tenantsID}}">{{ $tenant->firstName }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label name="unit" class="col-sm-2 control-label">Unit</label>
                      <div class="col-sm-10">
                        <select class="form-control selection-child-item edit" name="unitID">
                                <option value="0">Select a unit</option>
                            @foreach ($units as $unit)
                                <option value="{{$unit->unitID}}">{{ $unit->unitNumber }}</option>
                            @endforeach
                        </select>
                        <p class="no-units">No units belonging to this property</p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Market Rent</label>
                      <div class="col-sm-10">
                        <input type="tel" name="marketRent" class="form-control" placeholder="Market Rent">
                      </div>
                    </div>
                     <div class="form-group">
                      <label class="col-sm-2 control-label">Actual Rent</label>
                      <div class="col-sm-10">
                        <input type="tel" name="actualRent" class="form-control"  placeholder="Actual Rent">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">From</label>
                      <div class="col-sm-10">
                        <input type="text" name="dateFrom" class="form-control datepicker" placeholder="Agreement start date">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">To</label>
                      <div class="col-sm-10">
                        <input type="text" name="dateTo" class="form-control datepicker" placeholder="Agreement end date">
                      </div>
                    </div>
                    <div class="form-group">
                      <label name="unit" class="col-sm-2 control-label">Payment Type</label>
                      <div class="col-sm-10">
                        <select class="form-control" name="paymentTypeID">
                                <option value=''>Select a payment type</option>
                            @foreach ($paymentypes as $paymenttype)
                                <option value="{{$paymenttype->paymentTypeID}}">{{ $paymenttype->paymentDescription }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label name="unit" class="col-sm-2 control-label"> PDCYN</label>
                      <div class="col-sm-10">
                        <div class="checkbox"> <label> <input type="checkbox" name="pdcyn" value="1"> Available </label> 
                        </div>
                      </div>
                    </div>

                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <div class="form-buttons">
                      <input type="reset" class="btn btn-default" value="Reset" />
                      <button type="submit" class="btn btn-info pull-right">Save</button>
                    </div>
                  </div>
                  <!-- /.box-footer -->
                </form>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
