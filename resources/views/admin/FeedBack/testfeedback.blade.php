@extends('adminLayout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h2>Online Feedback <i class="fa fa-angle-right"></i> Listing</h2>

            <div class="portlet">
                <div class="portlet-header">
                    <div class="caption">Online Feedback Listing</div>
                    <br/>
                    <p class="margin-top-10px"></p>

                    <div class="btn-group">
                        <button type="button" class="btn btn-primary">Delete</button>
                        <button type="button" data-toggle="dropdown" class="btn btn-red dropdown-toggle"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="#" data-target="#confirmDeletenot" data-toggle="modal" class="deleteid" rel="{{url('web88cms/contacts/deleteallfeedback')}}" rev="confirmDelete">Delete selected item(s)</a></li>
                            <li class="divider"></li>
                            <li><a href="#" data-target="#modal-delete-all" data-toggle="modal">Delete all</a></li>
                        </ul>
                    </div>

                    <div class="tools">
                        <i class="fa fa-chevron-up"></i>
                    </div>
                    <!--Modal Add New PDF start-->

                    <!--END MODAL Add New PDF-->
                    <!--Modal delete selected items start-->
                    <div id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                    <h4 id="modal-login-label3" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete the selected item(s)? </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-actions">
                                        <div class="col-md-offset-4 col-md-8"><button type="button" class="btn btn-danger" id="confirm">Delete &nbsp;<i class="fa fa-check"></i></button>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
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
                                        <div class="col-md-offset-4 col-md-8"><form action="{{url('admin/contacts/deleteallfeedback')}}" method ="post"
                                                                                    id ="deleteallpressrelease"  class="form-horizontal" files=true>

                                                <button type="submit" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></button>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a>
                                            </form>
                                        </div>
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

                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <br/>
                    <br/>
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th width="1%"><input type="checkbox" class="wholecheck" name="pressreleasedelete[]"/></th>
                            <th>#</th>
                            <th>Name</th>
                            <th>Company Name</th>
                            <th>Email</th>
                            <th>Contact number</th>
                            <th>Country</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($feedbacks as $k => $feedback)
                            <tr>
                                <td><input type="checkbox"  class="chkNumber"  value="{{$feedback->id}}"/></td>
                                <td>{{$feedback->id}} </td>
                                <td>{{$feedback->name}} </td>
                                <td>{{$feedback->company_name}}</td>
                                <td>{{$feedback->email}}</td>
                                <td>{{$feedback->contact_number}}</td>
                                <td>{{$feedback->country}}</td>
                                <td><a href="#" data-hover="tooltip" data-placement="top" data-target="#modal-edit-pdf{{$feedback->id}}" data-toggle="modal" title="View Details"><span class="label label-sm label-yellow"><i class="fa fa-search"></i></span></a> <a href="#" data-hover="tooltip" data-placement="top" title="Delete" data-target="#modal-delete-press{{$feedback->id}}" data-toggle="modal"><span class="label label-sm label-red"><i class="fa fa-trash-o"></i></span></a>
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
                                            </div>
                                        </div>
                                    </div>
                                    <!-- modal delete end -->
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                    <div class="tool-footer text-right">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- end portlet -->

        </div>
    </div>

@endsection
