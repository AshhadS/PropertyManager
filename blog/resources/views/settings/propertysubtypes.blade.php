<h3 class="title">Property Sub Types</h3>
<div class="col-md-6">
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th style="width: 10px">id</th>
        <th>Name</th>
        <th>PropertyType</th>
        <th>Actions</th>
      </tr>
      @foreach ($propertysubtypes as $propertysubtype)
      <tr>
        <td>{{$propertysubtype->propertySubTypeID}}</td>
        <td>{{$propertysubtype->propertySubTypeDescription}}</td>
        <td>{{App\Model\PropertyType::find($propertysubtype->propertyTypeID)->propertyDescription}}</td>
        <!-- <td>{{$propertysubtype->propertyTypeID}}</td> -->
        <td>
          <!-- <a href="#" class="edit-btn">Edit</a>  -->

          <button class="btn btn-info btn-sm edit-settings" data-id="" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </button>

          <form class="delete-form clearfix" method="POST" action="propertysubtype/{{$propertysubtype->propertySubTypeID}}">
            <a href="#" class="delete-btn btn btn-danger btn-sm button--winona">
              <span><i class="fa fa-trash" aria-hidden="true"></i> Delete</span><span class="after">Sure?</span>
            </a>
            <input type="hidden" name="_method" value="DELETE"> 
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="col-md-6">
  <h4>Add Property Sub Type</h4>
  <form class="form-horizontal pull" action="/propertysubtype" method="POST">
      {{ csrf_field() }}
      <div class="form-group">
        <input type="text" name="propertySubTypeDescription" placeholder="Property Sub Type Name" class="input-req  form-control">
      </div>  
      <div class="form-group">
        <div class="">
          <select class="form-control selection-parent-item input-req" name="propertyTypeID">
              <option value="0">Select a Property Type</option>
              @foreach ($propertytypes as $prop)
                <option value="{{$prop->propertyTypeID}}">{{ $prop->propertyDescription }}</option>
              @endforeach
          </select>
        </div>
      </div>

      <p class="text-muted">Property Sub Types Belong to Property Types</p>
      <button type="submit" class="btn btn-info"><i class="fa fa-plus"></i> Add</button>
  </form>
  
</div>
