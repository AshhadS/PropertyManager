
<!-- form start -->
<h3 class="center-element">Company Details</h3>
<form class="form-horizontal ajax-process " action="/company" method="POST">
  {{ csrf_field() }}
  <input type="hidden" name="id" value="{{$company->companyID}}">
<div class="box-body">
  <div class="form-group">
    <label class="col-sm-2 control-label">Company Name</label>
    <div class="col-sm-10">
      <input type="text" name="companyName" value="{{$company->companyName}}" class="form-control input-req" required >
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Company Code</label>
    <div class="col-sm-10">
      <input type="text" name="companyCode" value="{{$company->companyCode}}" class="form-control" >
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Address</label>
    <div class="col-sm-10">
      <textarea class="form-control" name="address" rows="2" >{{$company->address}}</textarea>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">City</label>
    <div class="col-sm-10">
      <input type="text" name="city" value="{{$company->city}}" class="form-control" >
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Telephone</label>
    <div class="col-sm-10">
      <input type="text" name="telephoneNumber" value="{{$company->telephoneNumber}}" class="form-control" >
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Fax</label>
    <div class="col-sm-10">
      <input type="text" name="faxNumber" value="{{$company->faxNumber}}" class="form-control" >
    </div>
  </div>
  
  <div class="form-group">
    <label class="col-sm-2 control-label">Country</label>
    <div class="col-sm-10">
      <select name="country" class='form-control'>
        @foreach ($countries as $country)
            @if($company->countryID == $country->id)
              <option value="{{$country->id}}" selected="selected">{{ $country->countryName }}</option>
            @else
              <option value="{{$country->id}}">{{ $country->countryName }}</option>
            @endif
        @endforeach
      </select>
    </div>
  </div> 
</div>
<!-- /.box-body -->
<div class="box-footer">
  <div class="form-buttons">
    <input type="reset" class="btn btn-default" value="Reset" />
    <button type="submit" class="btn btn-info pull-right " data-section="company">Save</button>
  </div>
</div>
<!-- /.box-footer -->
</form>
