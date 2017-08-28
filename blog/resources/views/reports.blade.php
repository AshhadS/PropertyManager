@extends('admin_template')

@section('content')

<div class="container-fluid">
  <section class="content-header pull-left">
      <h4><b>REPORTS</b></h4>
  </section>
   <br/>
</div>
<div class="content">
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>

            <div class="info-box-content">
              <a href="/reports_supplierstatement">
                <span class="info-box-text">Supplier Statement</span>
                <span class="info-box-number">{{number_format($supplierStatementCount,0)}}</span>
              </a>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-files-o"></i></span>

            <div class="info-box-content">
              <a href="#">
                <span class="info-box-text">Customer Statement</span>
                <span class="info-box-number">{{number_format($supplierStatementCount,0)}}</span>
              </a>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
    </div>
</div>
</div>

@endsection