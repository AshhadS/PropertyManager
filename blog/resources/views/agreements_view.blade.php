<title>IDSS | Agreement</title>
<div class="modal fade" id="agreement-viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog " role="document">

    <div class="modal-content">

        <div class="modal-header">

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        
                  <h4 class="modal-title" id="myModalLabel">{{$agreement->pPropertyName}} - {{$agreement->unitNumber}} </h4>
          </div>
     
      <div class="">
        <div class="row">
          <div class="col-md-12">
              <div class="box box-info">
                  <!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal agreement-edit" action="" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="agreementID">
                  <div class="box-body">
                  
                  <div class="form-group">

                      <label class="col-sm-2 control-label">Tenant Name</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control" disabled="" placeholder="{{$agreement->tenantsfirstName}}"></input>
                      </div>

                  </div>


                  <div class="form-group">

                      <label class="col-sm-2 control-label">Tenant Contact No</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control" disabled="" placeholder="{{$agreement->tenantsphoneNumber}}"></input>
                      </div>

                  </div>

                   <div class="form-group">

                      <label class="col-sm-2 control-label">Agreement Start Date</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control" disabled="" placeholder="{{$agreement->dateFrom}}"></input>
                      </div>

                  </div>

                  <div class="form-group">

                      <label class="col-sm-2 control-label">Agreement End Date</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control" disabled="" placeholder="{{$agreement->dateTo}}"></input>
                      </div>

                  </div>

                  <div class="form-group">

                      <label class="col-sm-2 control-label">Current Rent</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control" disabled="" placeholder="{{$agreement->actualRent}}"></input>
                      </div>

                  </div>

                  <div class="form-group">

                      <label class="col-sm-2 control-label">Payment Method</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control" disabled="" placeholder="{{$agreement->paymentDescription}}"></input>
                      </div>

                  </div>

              
                    <div class="form-group">
                      <label name="unit" class="col-sm-2 control-label"> PDCYN</label>
                      <div class="col-sm-10">
                        <div class="checkbox"> <label> <input type="checkbox" name="pdcyn" value="{{$agreement->isPDCYN}}" disabled=""> Available </label> 
                        </div>
                      </div>
                    </div>

                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    
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
