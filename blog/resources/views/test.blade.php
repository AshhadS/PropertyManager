@extends('admin_template')

@section('content')
<div class="row">
    <div class="col-md-6">
        <table class="table table-bordered" id="users-table">
            <thead>
                <tr>
                    <th>Unit Number</th>
                    <th>Description</th>
                    <th>Size</th>
                    <th>Market Rent</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'http://127.0.0.1:8000/test',
        columns: [
            { data: 'unitNumber', name: 'unitNumber' },
            { data: 'description', name: 'description' },
            { data: 'size', name: 'size' },
            { data: 'marketRent', name: 'marketRent' },
        ]
    });
});
</script>
@endpush