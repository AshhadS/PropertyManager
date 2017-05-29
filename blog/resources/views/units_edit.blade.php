@extends('admin_template')

@section('content')
   
        <div class="panel panel-default">
            <div class="panel-heading">
                Units
            </div>

            <div class="panel-body"> 

               
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                              <h3 class="box-title">Edit Units</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <form class="form-horizontal" action="/units/update" method="POST">
                                {{ csrf_field() }}
                              <div class="box-body">
                              <input type="text" name="unitID" value="{{ $unit->unitID}}">
                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-2 control-label">Unit Number</label>
                                  <div class="col-sm-10">
                                    <input type="text" name="unitNumber" value="{{ $unit->unitNumber}}" class="form-control input-req" id="inputEmail3" placeholder="Unit Number">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-2 control-label">Description</label>
                                  <div class="col-sm-10">
                                    <textarea class="form-control" name="description" rows="2" placeholder="Description">{{ $unit->description}}</textarea>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-2 control-label">Size</label>
                                  <div class="col-sm-10">
                                    <input type="text" name="size" value="{{ $unit->size}}" class="form-control" id="inputEmail3" placeholder="Size">
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-2 control-label">Market Rent</label>
                                  <div class="col-sm-10">
                                    <input type="text" name="marketRent" value="{{ $unit->marketRent}}" class="form-control" id="inputEmail3" placeholder="Market Rent">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label for="inputEmail3" name="propertyType" value="{{ $unit->PropertiesID}}" class="col-sm-2 control-label">Property Name</label>
                                  <div class="col-sm-10">
                                    <select class="form-control" name="propertyType">
                                    </select>
                                  </div>
                                </div>                                
                                
                              </div>
                              <!-- /.box-body -->
                              <div class="box-footer">
                                <input type="reset" class="btn btn-default" value="Reset" />
                                <button type="submit" class="btn btn-info pull-right">Save</button>
                              </div>
                              <!-- /.box-footer -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
@endsection