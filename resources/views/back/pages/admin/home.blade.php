@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')
@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Dashboard</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Dashboard
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <div class="dropdown">
                <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                    January 2018
                </a>
                <div class="dropdown-menu dropdown-menu-right" style="">
                    <a class="dropdown-item" href="#">Export List</a>
                    <a class="dropdown-item" href="#">Policies</a>
                    <a class="dropdown-item" href="#">View Assets</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row pb-10">
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <div class="card-box height-100-p widget-style3">
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark">75</div>
                    <div class="font-14 text-secondary weight-500">
                        Total revenue
                    </div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#00eccf" style="color: rgb(0, 236, 207);">
                        <i class="icon-copy fa fa-line-chart"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <div class="card-box height-100-p widget-style3">
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark">124,551</div>
                    <div class="font-14 text-secondary weight-500">
                        Total expected revenue
                    </div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#ff5b5b" style="color: rgb(255, 91, 91);">
                        <span class="icon-copy fa fa-bar-chart"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <div class="card-box height-100-p widget-style3">
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark">400+</div>
                    <div class="font-14 text-secondary weight-500">
                        Total expenses
                    </div>
                </div>
                <div class="widget-icon">
                    <div class="icon">
                        <i class="icon-copy fa fa-credit-card" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <div class="card-box height-100-p widget-style3">
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark">$50,000</div>
                    <div class="font-14 text-secondary weight-500">Total commission fee</div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#09cc06" style="color: rgb(9, 204, 6);">
                        <i class="icon-copy fa fa-money" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="card-box mb-30">
    <h2 class="h4 pd-20">Best Selling Products</h2>
    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="row"><div class="col-sm-12 col-md-6"></div><div class="col-sm-12 col-md-6"></div></div><div class="row"><div class="col-sm-12"><table class="data-table table nowrap dataTable no-footer dtr-inline collapsed" id="DataTables_Table_0" role="grid" style="width: 1084px;">
        <thead>
            <tr role="row"><th class="table-plus datatable-nosort sorting_asc" rowspan="1" colspan="1" style="width: 124px;" aria-label="Product">Product</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 219px;" aria-label="Name: activate to sort column ascending">Name</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 95px; display: none;" aria-label="Color: activate to sort column ascending">Color</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 81px; display: none;" aria-label="Size: activate to sort column ascending">Size</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 92px; display: none;" aria-label="Price: activate to sort column ascending">Price</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 73px; display: none;" aria-label="Oty: activate to sort column ascending">Oty</th><th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" style="width: 96px; display: none;" aria-label="Action">Action</th></tr>
        </thead>
        <tbody>





        <tr role="row" class="odd">
                <td class="table-plus sorting_1" tabindex="0">
                    <img src="vendors/images/product-1.jpg" width="70" height="70" alt="">
                </td>
                <td>
                    <h5 class="font-16">Shirt</h5>
                    by John Doe
                </td>
                <td style="display: none;">Black</td>
                <td style="display: none;">M</td>
                <td style="display: none;">$1000</td>
                <td style="display: none;">1</td>
                <td style="display: none;">
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href="#"><i class="dw dw-eye"></i> View</a>
                            <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                            <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                        </div>
                    </div>
                </td>
            </tr><tr role="row" class="even">
                <td class="table-plus sorting_1" tabindex="0">
                    <img src="vendors/images/product-2.jpg" width="70" height="70" alt="">
                </td>
                <td>
                    <h5 class="font-16">Boots</h5>
                    by Lea R. Frith
                </td>
                <td style="display: none;">brown</td>
                <td style="display: none;">9UK</td>
                <td style="display: none;">$900</td>
                <td style="display: none;">1</td>
                <td style="display: none;">
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href="#"><i class="dw dw-eye"></i> View</a>
                            <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                            <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                        </div>
                    </div>
                </td>
            </tr><tr role="row" class="odd">
                <td class="table-plus sorting_1" tabindex="0">
                    <img src="vendors/images/product-3.jpg" width="70" height="70" alt="">
                </td>
                <td>
                    <h5 class="font-16">Hat</h5>
                    by Erik L. Richards
                </td>
                <td style="display: none;">Orange</td>
                <td style="display: none;">M</td>
                <td style="display: none;">$100</td>
                <td style="display: none;">4</td>
                <td style="display: none;">
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href="#"><i class="dw dw-eye"></i> View</a>
                            <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                            <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                        </div>
                    </div>
                </td>
            </tr><tr role="row" class="even">
                <td class="table-plus sorting_1" tabindex="0">
                    <img src="vendors/images/product-4.jpg" width="70" height="70" alt="">
                </td>
                <td>
                    <h5 class="font-16">Long Dress</h5>
                    by Renee I. Hansen
                </td>
                <td style="display: none;">Gray</td>
                <td style="display: none;">L</td>
                <td style="display: none;">$1000</td>
                <td style="display: none;">1</td>
                <td style="display: none;">
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href="#"><i class="dw dw-eye"></i> View</a>
                            <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                            <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                        </div>
                    </div>
                </td>
            </tr><tr role="row" class="odd">
                <td class="table-plus sorting_1" tabindex="0">
                    <img src="vendors/images/product-5.jpg" width="70" height="70" alt="">
                </td>
                <td>
                    <h5 class="font-16">Blazer</h5>
                    by Vicki M. Coleman
                </td>
                <td style="display: none;">Blue</td>
                <td style="display: none;">M</td>
                <td style="display: none;">$1000</td>
                <td style="display: none;">1</td>
                <td style="display: none;">
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href="#"><i class="dw dw-eye"></i> View</a>
                            <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                            <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                        </div>
                    </div>
                </td>
            </tr></tbody>
    </table></div></div><div class="row"><div class="col-sm-12 col-md-5"></div><div class="col-sm-12 col-md-7"></div></div></div>
</div>
@endsection
