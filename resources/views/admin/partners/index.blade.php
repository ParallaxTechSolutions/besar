@extends('adminLayout')
@section('title', 'Partner')
@section('content')

    <style>
        .switch-on > span {
            display: none;
        }
        .switch-on > label {
            display: none;
        }

    </style>
    <div id="page-wrapper">
        <div class="page-header-breadcrumb">
            <div class="page-heading hidden-xs">
                <h1 class="page-title">Partner</h1>
            </div>

            <ol class="breadcrumb page-breadcrumb">
                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('web88cms/dashboard') }}">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
                <li>Partner &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
                <li class="active">Partner - Listing</li>
            </ol>
        </div>

        <div class="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Partners <i class="fa fa-angle-right"></i> Listing</h2>
                    <div class="clearfix"></div>
                    @if ($success)
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                            <i class="fa fa-check-circle"></i> <strong>Success!</strong>
                            <p>{{ $success }}</p>
                        </div>
                    @endif

                    @if ($warning)
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                            <i class="fa fa-times-circle"></i> <strong>Error!</strong>
                            <p>{{ $warning }}</p>
                        </div>
                    @endif

                    @if ($last_updated)
                        <div class="pull-left"> Last updated: <span class="text-blue">{{ $last_updated }}</span> </div>
                        <div class="clearfix"></div>
                        <p></p>
                    @endif

                    <div class="clearfix"></div>
                </div>

                <div class="col-md-6">
                    <div class="portlet portlet-blue">
                        <div class="portlet-header">
                            <div class="caption text-white">Search Partners</div>
                        </div>
                        <div class="portlet-body">
                            <form class="form-horizontal" method="get">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Partner Name </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="customer_name" value="{{ Input::get('customer_name') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Email </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="email" value="{{ Input::get('email') }}">
                                    </div>
                                </div>
                                <div class="form-actions text-center">
                                    <button type="submit" class="btn btn-red">Search &nbsp;<i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="portlet">
                        <div class="portlet-header">
                            <div class="caption">Partner Listing</div><br/>
                            <p class="margin-top-10px"></p>
                            <a href="#" class="btn btn-success" data-target="#modal-add-user" data-toggle="modal">Add New Partner &nbsp;<i class="fa fa-plus"></i></a>&nbsp;
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary">Delete</button>
                                <button type="button" data-toggle="dropdown" class="btn btn-red dropdown-toggle"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                                <ul role="menu" class="dropdown-menu">
                                    <li><a href="#" onclick="deleteSelected()">Delete selected item(s)</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#" data-target="#modal-delete-all" data-toggle="modal">Delete all</a></li>
                                </ul>
                            </div>&nbsp;

                            <a href="{{ url('web88cms/partners/csv') }}" class="btn btn-blue">Export to CSV &nbsp;<i class="fa fa-share"></i></a>
                            <div class="tools"> <i class="fa fa-chevron-up"></i> </div>

                            <!--Modal add new user start-->
                            <div id="modal-add-user" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                <div class="modal-dialog modal-wide-width">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                            <h4 id="modal-login-label2" class="modal-title">Add New Partner</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form">
                                                <form class="form-horizontal">
                                                    <h5>Partner Account Information</h5>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Status <span class="text-red">*</span></label>
                                                        <div class="col-md-6">
                                                            <div data-on="success" data-off="primary" class="make-switch">
                                                                <input type="checkbox" checked="checked" name="status" value="on" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputFirstName" class="col-md-4 control-label">First Name <span class="text-red">*</span></label>
                                                        <div class="col-md-6">
                                                            <input type="text" name="first_name" class="form-control" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="form-group">
                                                        <label for="inputFirstName" class="col-md-4 control-label">Last Name <span class="text-red">*</span></label>
                                                        <div class="col-md-6">
                                                            <input type="text" name="last_name" class="form-control" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>

                                                    <div class="form-group">
                                                        <label for="inputFirstName" class="col-md-4 control-label">Email <span class="text-red">*</span></label>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="email" />
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputFirstName" class="col-md-4 control-label">Telephone <span class="text-red">*</span></label>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="telephone">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputFirstName" class="col-md-4 control-label">Birth Date <span class="text-red">*</span></label>
                                                        <div class="col-md-3">
                                                            <div class="input-group">
                                                                <input type="text" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" class="datepicker-default form-control" value="" name="birth_date" />
                                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="password" class="control-label col-md-4">Password <span class="text-red">*</span></label>
                                                        <div class="col-md-6">
                                                            <div class="input-icon">
                                                                <i class="fa fa-key"></i>
                                                                <input id="password" type="password" name="password" placeholder="Password" class="form-control"/>
                                                                <span class="text-10px">(Password length should be between 6-12 characters)</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="password" class="control-label col-md-4">Confirm Password <span class="text-red">*</span></label>
                                                        <div class="col-md-6">
                                                            <div class="input-icon">
                                                                <i class="fa fa-key"></i>
                                                                <input id="password" type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control"/>
                                                                <span class="text-10px">(Password length should be between 6-12 characters)</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <h5>Credit Management</h5>
                                                    <div class="form-group">
                                                        <label for="inputFirstName" class="col-md-4 control-label">Current Credit</label>
                                                        <div class="col-md-6">
                                                            <div class="">
                                                                <h5>
                                                                    RM 0.00
                                                                </h5>
                                                            </div>
                                                            <span class="text-10px">Last Updated: </span>

                                                        </div>
                                                    </div>
                                                    <div class="clearfix"> </div>

                                                    <div class="form-group">
                                                        <label for="inputFirstName" class="col-md-4 control-label">Add Credit</label>
                                                        <div class="col-md-6">
                                                            <input type="number" name="add_credit" class="form-control" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>

                                                    <div class="form-actions">
                                                        <div class="col-md-offset-5 col-md-8">
                                                            <a href="#" onclick="saveCustomer($(this))" class="btn btn-red">
                                                                Save &nbsp;<i class="fa fa-floppy-o"></i>
                                                            </a>&nbsp;
                                                            <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;
                                                                <i class="glyphicon glyphicon-ban-circle"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <input id="_token" type="hidden" name="_token" value="{{ csrf_token() }}">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--END MODAL add new user -->

                            <!--modal delete selected  at least one items start-->
                            <div id="modal-selected-least-one" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                            <h4 id="modal-login-label4" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete the selected item(s)? </h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-danger" role="alert">
                                                Please select at least one product before delete.
                                            </div>
                                            <div class="form-actions">
                                                <div class="col-md-offset-4 col-md-8">
                                                    <a href="javascript:void(0)" data-dismiss="modal" onclick="cancel_delete()" class="btn btn-green">OK &nbsp;<i class="fa fa-times-circle"></i>
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Modal delete selected items start-->
                            <div id="modal-delete-selected" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                            <h4 id="modal-login-label3" class="modal-title"><a href="#"><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete the selected item(s)? </h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-actions">
                                                <div class="col-md-offset-4 col-md-8"> <a href="#" onclick="deleteCustomers($(this), 'selected')" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- modal delete selected items end -->
                            <!--Modal delete all items start-->
                            <div id="modal-delete-all" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                            <h4 id="modal-login-label3" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete all items? </h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-actions">
                                                <div class="col-md-offset-4 col-md-8"> <a href="#" onclick="deleteCustomers($(this), 'all')" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- modal delete all items end -->
                        </div>

                        <div class="portlet-body">
                            <div class="form-inline pull-left">
                                <div class="form-group">
                                    <select name="select_per_page" class="form-control">
                                        <option <?= ($limit == 10 ? 'selected="selected"' : ''); ?> value="10">10</option>
                                        <option <?= ($limit == 20 ? 'selected="selected"' : ''); ?> value="20">20</option>
                                        <option <?= ($limit == 30 ? 'selected="selected"' : ''); ?> value="30">30</option>
                                        <option <?= ($limit == 50 ? 'selected="selected"' : ''); ?> value="50">50</option>
                                        <option <?= ($limit == 100 ? 'selected="selected"' : ''); ?> value="100">100</option>
                                    </select>
                                    &nbsp;
                                    <label class="control-label">Records per page</label>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <br/>
                            <br/>
                            <div class="table-responsive mtl">
                                <table id="customers" class="table table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th width="1%"><input type="checkbox" onclick="$('input[type=checkbox]').prop('checked', $(this).is(':checked'))" /></th>
                                        <th>#</th>
                                        @if ($sort_by == 'id' && $sort == 'ASC')
                                            <th><a href="<?php echo $sorting_url . '&sort_by=id&sort=DESC'; ?>">ID</a></th>
                                        @else
                                            <th><a href="<?php echo $sorting_url . '&sort_by=id&sort=ASC'; ?>">ID</a></th>
                                        @endif

                                        @if ($sort_by == 'name' && $sort == 'ASC')
                                            <th><a href="<?php echo $sorting_url . '&sort_by=name&sort=DESC'; ?>">Partner Name</a></th>
                                        @else
                                            <th><a href="<?php echo $sorting_url . '&sort_by=name&sort=ASC'; ?>">Partner Name</a></th>
                                        @endif

                                        @if ($sort_by == 'email' && $sort == 'ASC')
                                            <th><a href="<?php echo $sorting_url . '&sort_by=email&sort=DESC'; ?>">Email</a></th>
                                        @else
                                            <th><a href="<?php echo $sorting_url . '&sort_by=email&sort=ASC'; ?>">Email</a></th>
                                        @endif

                                        @if ($sort_by == 'createdate' && $sort == 'ASC')
                                            <th><a href="<?php echo $sorting_url . '&sort_by=createdate&sort=DESC'; ?>">Registered</a></th>
                                        @else
                                            <th><a href="<?php echo $sorting_url . '&sort_by=createdate&sort=ASC'; ?>">Registered</a></th>
                                        @endif

                                        <th><a href="#">Type</a></th>

                                        @if ($sort_by == 'status' && $sort == 'ASC')
                                            <th><a href="<?php echo $sorting_url . '&sort_by=status&sort=DESC'; ?>">Status</a></th>
                                        @else
                                            <th><a href="<?php echo $sorting_url . '&sort_by=status&sort=ASC'; ?>">Status</a></th>
                                        @endif

                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $count = 1; ?>
                                    @foreach ($partners as $customer)
                                        <tr>
                                            <td><input class="chk-customer" name="customers[]" value="{{ $customer->id }}" type="checkbox"/></td>
                                            <td>{{ $count }}</td>
                                            <td>{{ $customer->id }}</td>
                                            <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                                            <td><a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a></td>
                                            <td>{{ date('dS M, Y H:i', strtotime($customer->createdate)) }}</td>
                                            <td>Partner</td>
                                            @if ($customer->status == '1')
                                                <td><span class="label label-sm label-success">Active</span></td>
                                            @else
                                                <td><span class="label label-sm label-red">Inactive</span></td>
                                            @endif
                                            <td>
                                                <a href="{{ url('web88cms/partners/view/' . $customer->id) }}?tab=orders" data-hover="tooltip" data-placement="top" title="View All Orders"><span class="label label-sm label-yellow"><i class="fa fa-search"></i></span></a>
                                                <a href="{{ url('web88cms/partners/view/' . $customer->id) }}" data-hover="tooltip" data-placement="top" title="Edit"><span class="label label-sm label-success"><i class="fa fa-pencil"></i></span></a>
                                                <a href="#" data-hover="tooltip" data-placement="top" title="Delete" data-target="#modal-delete-{{ $customer->id }}" data-toggle="modal"><span class="label label-sm label-red"><i class="fa fa-trash-o"></i></span></a>

                                                <!--Modal delete start-->
                                                <div id="modal-delete-{{ $customer->id }}" tabindex="{{ $customer->id }}" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                                                <h4 id="modal-login-label3" class="modal-title"><a href="#"><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete this user? </h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>#{{ $customer->id }}:</strong> {{ $customer->first_name }} {{ $customer->last_name }}</p>
                                                                <div class="form-actions">
                                                                    <div class="col-md-offset-4 col-md-8">
                                                                        <a href="{{ url('web88cms/partners/delete/' . $customer->id) }}?redirect=<?php echo urlencode($curr_url); ?>" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp;
                                                                        <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- modal delete end -->
                                            </td>
                                        </tr>
                                        <?php $count++; ?>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="9"></td>
                                    </tr>
                                    </tfoot>
                                </table>
                                <div class="tool-footer text-right">
                                    <p class="pull-left"><?= $paginate_msg; ?></p>
                                    <?php echo $partners->appends($_GET)->render() ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>

        <div class="page-footer">
            <div class="copyright"><span class="text-15px">2015 © <a href="http://www.webqom.com" target="_blank">Webqom Technologies Sdn Bhd.</a> Any queries, please contact <a href="mailto:support@webqom.com">Webqom Support</a>.</span>
                <div class="pull-right"><img src="{{ asset('/public/admin/images/logo_webqom.png') }}" alt="Webqom Technologies Sdn Bhd"></div>
            </div>
        </div>

        <input id="_token" type="hidden" name="_token" value="{{ csrf_token() }}">
        <input id="_category_post" type="hidden" name="_category_post" value="{{ url('web88cms/categories/listAjax') }}">
    </div>

    <script src="{{ asset('/public/admin/js/jquery-1.9.1.js') }}"></script>
    <script src="{{ asset('/public/admin/js/jquery-migrate-1.2.1.min.js') }}"></script>
    <script src="{{ asset('/public/admin/js/jquery-ui.js') }}"></script>
    <!--loading bootstrap js-->
    <script src="{{ asset('/public/admin/vendors/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js') }}"></script>
    <script src="{{ asset('/public/admin/js/html5shiv.js') }}"></script>
    <script src="{{ asset('/public/admin/js/respond.min.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/slimScroll/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/jquery-cookie/jquery.cookie.js') }}"></script>
    <script src="{{ asset('/public/admin/js/jquery.menu.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/jquery-pace/pace.min.js') }}"></script>

    <!--LOADING SCRIPTS FOR PAGE-->
    <script src="{{ asset('/public/admin/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/moment/moment.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/bootstrap-clockface/js/clockface.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/jquery-maskedinput/jquery-maskedinput.js') }}"></script>
    <script src="{{ asset('/public/admin/js/form-components.js') }}"></script>
    <!--LOADING SCRIPTS FOR PAGE-->

    <script src="{{ asset('/public/admin/vendors/tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('/public/admin/js/ui-tabs-accordions-navs.js') }}"></script>


    <!--CORE JAVASCRIPT-->
    <script src="{{ asset('/public/admin/js/main.js') }}"></script>
    <script src="{{ asset('/public/admin/js/holder.js') }}"></script>



    <script>
        function saveCustomer(obj){
            $.ajax({
                url: "{{ url('web88cms/partners/new-partners') }}",
                type: 'POST',
                data: $('form.form-horizontal').serialize(),
                dataType: 'json',
                async: false,
                cache: false,
                beforeSend:function (){
                    obj.html('Saving... <i class="fa fa-floppy-o"></i>');
                },
                complete: function(){
                    obj.html('Save <i class="fa fa-floppy-o"></i>');
                },
                success: function (response) {
                    var html = '';

                    $('#warning-box').remove();
                    $('#success-box').remove();

                    if(response['error'])
                    {
                        html += '<div id="warning-box" class="alert alert-danger alert-dismissable">';
                        html += '<button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>';
                        html += '<i class="fa fa-times-circle"></i> <strong>Error!</strong>';

                        for(var i=0; i < response['error'].length; i++)
                        {
                            html += '<p>'+ response['error'][i] +'</p>';
                        }

                        html += '</div>';
                        $('form.form-horizontal').before(html);
                    }

                    if(response['success'])
                    {
                        window.location.reload();
                    }
                }
            });
        }

        function deleteCustomers(obj, type){
            if(type == 'selected'){
                values = $('.chk-customer:checked, #_token');
            }
            else{
                values = $('.chk-customer, #_token');
            }

            var total = values.length;
            if(total > 0){
                $.ajax({
                    url: "{{ url('web88cms/partners/deleteAllPartners') }}",
                    type: 'POST',
                    data: values,
                    dataType: 'json',
                    async: false,
                    cache: false,
                    beforeSend:function (){
                        obj.html('Saving... <i class="fa fa-floppy-o"></i>');
                    },
                    complete: function(){
                        obj.html('Save <i class="fa fa-floppy-o"></i>');
                    },
                    success: function (response) {
                        if(response['success'])
                        {
                            window.location.reload();
                        }
                    }
                });
            }
            else{
                alert('Please select at least one customer before delete.');
            }
        }
    </script>

    <script>
        $(function (){
            $('select[name="billing_country"]').change(function(){
                var country_id = $(this).val();
                if(country_id != ''){
                    $.ajax({
                        url: "{{ url('web88cms/partners/getStates') }}",
                        type: 'POST',
                        data: {country_id:country_id, _token: $('#_token').val()},
                        dataType: 'json',
                        async: false,
                        cache: false,
                        beforeSend:function (){
                            $('select[name="billing_state"]').html('<option value="">Loading...</option>');
                        },
                        complete: function(){

                        },
                        success: function (response) {
                            var html = '';
                            html += '<option value="">States</option>';
                            if(response['states']){
                                for(var i = 0; i < response['states'].length; i++){
                                    html += '<option value="' + response['states'][i]['zone_id'] + '">' + response['states'][i]['name'] + '</option>';
                                }
                            }

                            $('select[name="billing_state"]').html(html);
                        }
                    });
                }
                else{
                    $('select[name="billing_state"]').html('<option value="">State</option>');
                }
            });
        });

        $(function (){
            $('select[name="shipping_country"]').change(function(){
                var country_id = $(this).val();
                if(country_id != ''){
                    $.ajax({
                        url: "{{ url('web88cms/partners/getStates') }}",
                        type: 'POST',
                        data: {country_id:country_id, _token: $('#_token').val()},
                        dataType: 'json',
                        async: false,
                        cache: false,
                        beforeSend:function (){
                            $('select[name="shipping_state"]').html('<option value="">Loading...</option>');
                        },
                        complete: function(){

                        },
                        success: function (response) {
                            var html = '';
                            html += '<option value="">States</option>';
                            if(response['states']){
                                for(var i = 0; i < response['states'].length; i++){
                                    html += '<option value="' + response['states'][i]['zone_id'] + '">' + response['states'][i]['name'] + '</option>';
                                }
                            }

                            $('select[name="shipping_state"]').html(html);
                        }
                    });
                }
                else{
                    $('select[name="shipping_state"]').html('<option value="">State</option>');
                }
            });
        });

        $(function(){
            $('select[name="select_per_page"]').change(function(){
                <?php if($_SERVER['QUERY_STRING']){ ?>
                    window.location = '<?= url("web88cms/partners"); ?>/' + $(this).val() + "?<?= $_SERVER['QUERY_STRING']; ?>";
                <?php }else{ ?>
                    window.location = '<?= url("web88cms/partners"); ?>/' + $(this).val();
                <?php } ?>
            });
        })

        //Shipping address is the same as billing address
        $(function(){
            $('input[name=same_billing_address]').click(function(){
                if($(this).is(':checked')){
                    var data_target = $(this).attr('data-target');

                    $('#' + data_target + ' input[name=shipping_first_name]').val($('#' + data_target + ' input[name=billing_first_name]').val());
                    $('#' + data_target + ' input[name=shipping_last_name]').val($('#' + data_target + ' input[name=billing_last_name]').val());
                    $('#' + data_target + ' input[name=shipping_email]').val($('#' + data_target + ' input[name=billing_email]').val());
                    $('#' + data_target + ' input[name=shipping_telephone]').val($('#' + data_target + ' input[name=billing_telephone]').val());
                    $('#' + data_target + ' textarea[name=shipping_address]').val($('#' + data_target + ' textarea[name=billing_address]').val());
                    $('#' + data_target + ' input[name=shipping_city]').val($('#' + data_target + ' input[name=billing_city]').val());
                    $('#' + data_target + ' input[name=shipping_post_code]').val($('#' + data_target + ' input[name=billing_post_code]').val());

                    $('#' + data_target + ' select[name=shipping_state]').html($('#' + data_target + ' select[name=billing_state]').html());
                    $('#' + data_target + ' select[name=shipping_country]').html($('#' + data_target + ' select[name=billing_country]').html());

                    $('#' + data_target + ' select[name=shipping_state]').val($('#' + data_target + ' select[name=billing_state]').val());
                    $('#' + data_target + ' select[name=shipping_country]').val($('#' + data_target + ' select[name=billing_country]').val());
                }
            });
        });
        function deleteSelected(){
            values = $('.chk-customer:checked');
            if (values.length==0){
                $('#modal-selected-least-one').modal('show');
                return false;
            }
            $('#modal-delete-selected').modal('show');
        }
    </script>
@endsection
