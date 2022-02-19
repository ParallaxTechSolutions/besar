@extends('adminLayout')
@section('title', 'Feedback')
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
                <h1 class="page-title">Online Feedback Listing</h1>
            </div>

            <ol class="breadcrumb page-breadcrumb">
                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('web88cms/dashboard') }}">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
                <li class="active">Online Feedback Listing</li>
            </ol>
        </div>

        <div class="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <h2> Online Feedback Listing<i class="fa fa-angle-right"></i></h2>
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

                <div class="col-lg-12">
                    <div class="portlet">
                        <div class="portlet-header">
                           <div class="btn-group">
                                <button type="button" class="btn btn-primary">Delete</button>
                                <button type="button" data-toggle="dropdown" class="btn btn-red dropdown-toggle"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                                <ul role="menu" class="dropdown-menu">
                                    <li><a href="#" onclick="deleteSelected()">Delete selected item(s)</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#" data-target="#modal-delete-all" data-toggle="modal">Delete all</a></li>
                                </ul>
                            </div>&nbsp;

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
                                                <div class="col-md-offset-4 col-md-8"> <a href="#" onclick="deleteFeedBack($(this), 'selected')" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
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
                                            <th><a href="<?php echo $sorting_url . '&sort_by=name&sort=DESC'; ?>">Name</a></th>
                                        @else
                                            <th><a href="<?php echo $sorting_url . '&sort_by=name&sort=ASC'; ?>">Name</a></th>
                                        @endif

                                        @if ($sort_by == 'email' && $sort == 'ASC')
                                            <th><a href="<?php echo $sorting_url . '&sort_by=email&sort=DESC'; ?>">Email</a></th>
                                        @else
                                            <th><a href="<?php echo $sorting_url . '&sort_by=email&sort=ASC'; ?>">Email</a></th>
                                        @endif

                                        @if ($sort_by == 'company_name' && $sort == 'ASC')
                                            <th><a href="<?php echo $sorting_url . '&sort_by=createdate&sort=DESC'; ?>">Company Name</a></th>
                                        @else
                                            <th><a href="<?php echo $sorting_url . '&sort_by=createdate&sort=ASC'; ?>">Company Name</a></th>
                                        @endif


                                        @if ($sort_by == 'contact_number' && $sort == 'ASC')
                                            <th><a href="<?php echo $sorting_url . '&sort_by=status&sort=DESC'; ?>">Contact Number</a></th>
                                        @else
                                            <th><a href="<?php echo $sorting_url . '&sort_by=status&sort=ASC'; ?>">Contact Number</a></th>
                                        @endif

                                        <th><a href="#">Country</a></th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $count = 1; ?>
                                    @foreach ($feedbacks as $feedback)
                                        <tr>
                                            <td><input class="chk-customer" name="customers[]" value="{{ $feedback->id }}" type="checkbox"/></td>
                                            <td>{{ $count }}</td>
                                            <td>{{ $feedback->id }}</td>
                                            <td>{{ $feedback->name }}</td>
                                            <td><a href="mailto:{{ $feedback->email }}">{{ $feedback->email }}</a></td>
                                            <td>{{$feedback->company_name}}</td>
                                            <td>{{$feedback->contact_number}}</td>
                                            <td>{{$feedback->country}}</td>
                                            <td>
                                                <a href="#" data-hover="tooltip" data-placement="top" data-target="#modal-edit-pdf{{$feedback->id}}" data-toggle="modal" title="View Details"><span class="label label-sm label-yellow"><i class="fa fa-search"></i></span></a> <a href="#" data-hover="tooltip" data-placement="top" title="Delete" data-target="#modal-delete-press{{$feedback->id}}" data-toggle="modal"><span class="label label-sm label-red"><i class="fa fa-trash-o"></i></span></a>
                                                <!--Modal Edit PDF start-->
                                                <div id="modal-edit-pdf{{$feedback->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                                    <div class="modal-dialog modal-wide-width">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                                                <h4 id="modal-login-label3" class="modal-title">View Details</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="#" class="form-horizontal">
                                                                    <div class="form-body pal">
                                                                        <h3 class="block-heading">General</h3>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="inputFirstName" class="col-md-4 control-label">Name:</label>
                                                                                    <div class="col-md-8">
                                                                                        <p class="form-control-static">{{$feedback->name}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="inputEmail" class="col-md-4 control-label">Email:</label>
                                                                                    <div class="col-md-8">
                                                                                        <p class="form-control-static"><a href="mailto:{{$feedback->email}}">{{$feedback->email}}</a></p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="inputPhone" class="col-md-4 control-label">Contact Number:</label>
                                                                                    <div class="col-md-8">
                                                                                        <p class="form-control-static">{{$feedback->contact_number}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <h3 class="block-heading">Company Info</h3>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="inputLastName" class="col-md-4 control-label">Company Name:</label>
                                                                                    <div class="col-md-8">
                                                                                        <p class="form-control-static">{{$feedback->company_name}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="inputAddress1" class="col-md-4 control-label">Address:</label>
                                                                                    <div class="col-md-8">
                                                                                        <p class="form-control-static">{{$feedback->company_address}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="inputAddress2" class="col-md-4 control-label">City:</label>
                                                                                    <div class="col-md-8">
                                                                                        <p class="form-control-static">{{$feedback->city}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="inputStates" class="col-md-4 control-label">State:</label>
                                                                                    <div class="col-md-8">
                                                                                        <p class="form-control-static">{{$feedback->state}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="inputCity" class="col-md-4 control-label">Post Code:</label>
                                                                                    <div class="col-md-8">
                                                                                        <p class="form-control-static">{{$feedback->post_code}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="inputPostCode" class="col-md-4 control-label">Country:</label>
                                                                                    <div class="col-md-8">
                                                                                        <p class="form-control-static">{{$feedback->country}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- End company info -->
                                                                        <h3 class="block-heading">Feedback / Comments / Enquiries</h3>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="inputPostCode" class="col-md-2 control-label">Questions &amp; Comments :</label>
                                                                                    <div class="col-md-10">
                                                                                        <p class="form-control-static">{{$feedback->questions_comments}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-actions">
                                                                        <div class="col-md-offset-5 col-md-8"> <a href="#" data-dismiss="modal" class="btn btn-green">Close &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--END MODAL Edit PDF-->
                                                <!--Modal delete start-->
                                                <div id="modal-delete-press{{ $feedback->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                                                <h4 id="modal-login-label3" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete this item? </h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>#{{$feedback->id}}:</strong>{{$feedback->name}} </p>
                                                                <div class="form-actions">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class="col-md-offset-4 col-md-8">
                                                                    <a href="{{ url('web88cms/contacts/deletefeedback/' . $feedback->id) }}?redirect=<?php echo urlencode($curr_url); ?>" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp;
                                                                    <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a>
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
                                    <?php echo $feedbacks->appends($_GET)->render() ?>
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

        function deleteFeedBack(obj, type){
            if(type == 'selected'){
                values = $('.chk-customer:checked, #_token');
            }
            else{
                values = $('.chk-customer, #_token');
            }

            var total = values.length;
            if(total > 0){
                $.ajax({
                    url: "{{ url('web88cms/contacts/deleteallfeedback') }}",
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
                alert('Please select at least one Feedback before delete.');
            }
        }
    </script>

    <script>

        $(function(){
            $('select[name="select_per_page"]').change(function(){
                <?php if($_SERVER['QUERY_STRING']){ ?>
                    window.location = '<?= url("web88cms/contacts/feedbacks"); ?>/' + $(this).val() + "?<?= $_SERVER['QUERY_STRING']; ?>";
                <?php }else{ ?>
                    window.location = '<?= url("web88cms/contacts/feedbacks"); ?>/' + $(this).val();
                <?php } ?>
            });
        })

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
