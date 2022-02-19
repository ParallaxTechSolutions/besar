@extends('adminLayout')
@section('title', 'Footer Setup')
@section('content')
      <div id="page-wrapper"><!--BEGIN PAGE HEADER & BREADCRUMB-->

        <div class="page-header-breadcrumb">
          <div class="page-heading hidden-xs">
            <h1 class="page-title">Global Settings</h1>
          </div>

          <!-- InstanceBeginEditable name="EditRegion1" -->
          <ol class="breadcrumb page-breadcrumb">
            <li><i class="fa fa-home"></i>&nbsp;<a href="dashboard.html">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
            <li>Global Settings &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
            <li class="active">Footer - Edit</li>
          </ol>
          <!-- InstanceEndEditable --></div>
        <!--END PAGE HEADER & BREADCRUMB--><!--BEGIN CONTENT-->
        <!-- InstanceBeginEditable name="EditRegion2" -->
        <div class="page-content">
          <div class="row">
            <div class="col-lg-12">
              <h2>Footer <i class="fa fa-angle-right"></i> Edit</h2>
              <div class="clearfix"></div>
              <div class="alert alert-success alert-dismissable"
        @if( Session::has('success') )
        style="display: block;">
      <script>setTimeout(function(){$("body").animate({"scrollTop":0},100);},3000);</script>
      <? Session::forget('success') ?>
      @else
        style="display: none;">
      @endif
                <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                <i class="fa fa-check-circle"></i> <strong>Success!</strong>
                <p>The information has been saved/updated/delete successfully.</p>
              </div>
              <div class="alert alert-danger alert-dismissable"
      @if( Session::has('fail') )
        style="display: block;">
      <script>setTimeout(function(){$("body").animate({"scrollTop":0},100);},3000);</script>
      <? Session::forget('fail') ?>
      @else
        style="display: none;">
      @endif
                <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                <i class="fa fa-times-circle"></i> <strong>Error!</strong>
                <p>The information has not been saved/updated. Please correct the errors.</p>
              </div>
              <div class="pull-left"> Last updated: <span class="text-blue">{{ date('d M, Y @ g.iA', strtotime($data['updated_at'])) }}</span> </div>
              <div class="clearfix"></div>
              <p></p>
              <ul id="myTab" class="nav nav-tabs">
                <li class="active"><a href="#copyrighttext" data-toggle="tab">Copyright Text</a></li>
				<li><a href="#footerimage" data-toggle="tab">Footer Image</a></li>
                <li><a href="#hotel_location" data-toggle="tab">Hotel Location</a></li>
                <li><a href="#newsletter" data-toggle="tab">NewsLetter</a></li>
                <li><a href="#about" data-toggle="tab">About</a></li>
                <li><a href="#contact-details" data-toggle="tab">Contact Details</a></li>
                <li><a href="#social-link" data-toggle="tab">Social Links</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <div id="copyrighttext" class="tab-pane fade in active">
                  <div class="portlet">
                    <div class="portlet-header">
                      <div class="caption">Copyright Text</div>
                      <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
                    </div>
                    <div class="portlet-body">
                    	<div class="table-responsive mtl">
                          <table class="table table-hover table-striped">
                            <thead>
                              <tr>
                                <th width="1%"><input type="checkbox" /></th>
                                <th>#</th>
                                <th>Title</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td><input type="checkbox"/></td>
                                <td>1</td>
                                <td>{!! $info['copyright']['copyright'] !!} </td>
                                <td><a href="#" data-hover="tooltip" data-placement="top" data-target="#modal-edit-text" data-toggle="modal" title="Edit"><span class="label label-sm label-success"><i class="fa fa-pencil"></i></span></a>
                                    <!--Modal Edit copyright start-->
                                    <div id="modal-edit-text" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                      <div class="modal-dialog modal-wide-width">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                            <h4 id="modal-login-label3" class="modal-title">Copyright Text Edit</h4>
                                          </div>
                                          <div class="modal-body">
										   <div class="form">
                                             <form method="POST" action="{{url('web88cms/footer_setup')}}" accept-charset="UTF-8"  class="form-horizontal">
											 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <div class="form-group">
                                                  <label class="col-md-3 control-label">Copyright Text</label>
                                                  <div class="col-md-9">
                                                    <div class="text-blue border-bottom">You can edit the content by clicking the text section below.</div>
                                                    <textarea name="footer[copyright]" contenteditable="true">{{ $info['copyright']['copyright'] }}</textarea>
                                                  </div>
                                                </div>
												<input name="footer[type]"  value="copyright" type="hidden"/>
                                                <div class="form-actions">
                                                  <div class="col-md-offset-5 col-md-8">
												  <button type="submit" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></button> &nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                  <!--END MODAL Edit copyright -->
                                </td>
                              </tr>
                            </tbody>
                            <tfoot>
                              <tr>
                                <td colspan="4"></td>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                        <!-- end table responsive -->
                    </div>
                    <!-- end portlet body -->
                  </div>
                  <!-- End porlet -->
                </div>
                <!-- end tab copyright text -->
				<div id="about" class="tab-pane">
                  <div class="portlet">
                    <div class="portlet-header">
                      <div class="caption">About Text</div>
                      <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
                    </div>
                    <div class="portlet-body">
                    	<div class="table-responsive mtl">
                          <table class="table table-hover table-striped">
                            <thead>
                              <tr>
                                <th width="1%"><input type="checkbox"/></th>
                                <th>#</th>
                                <th>Title</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td><input type="checkbox"/></td>
                                <td>1</td>
                                <td>{!! isset($info['about']['about'])?$info['about']['about']:'' !!} </td>
                                <td><a href="#" data-hover="tooltip" data-placement="top" data-target="#modal-edit-about-text" data-toggle="modal" title="Edit"><span class="label label-sm label-success"><i class="fa fa-pencil"></i></span></a>
                                    <!--Modal Edit about start-->
                                    <div id="modal-edit-about-text" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                      <div class="modal-dialog modal-wide-width">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                            <h4 id="modal-login-label3" class="modal-title">About Text Edit</h4>
                                          </div>
                                          <div class="modal-body">
										   <div class="form">
                                             <form method="POST" action="{{url('web88cms/footer_setup')}}" accept-charset="UTF-8"  class="form-horizontal">
											 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <div class="form-group">
                                                  <label class="col-md-3 control-label">About Text</label>
                                                  <div class="col-md-9">
                                                    <div class="text-blue border-bottom">You can edit the content by clicking the text section below.</div>
                                                    <textarea name="footer[about]" contenteditable="true">{{ isset($info['about']['about'])?$info['about']['about']:'' }}</textarea>
                                                  </div>
                                                </div>
												<input name="footer[type]"  value="about" type="hidden"/>
                                                <div class="form-actions">
                                                  <div class="col-md-offset-5 col-md-8">
												  <button type="submit" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></button> &nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                  <!--END MODAL Edit copyright -->
                                </td>
                              </tr>
                            </tbody>
                            <tfoot>
                              <tr>
                                <td colspan="4"></td>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                        <!-- end table responsive -->
                    </div>
                    <!-- end portlet body -->
                  </div>
                  <!-- End porlet -->
                </div>
                <!-- end tab about text -->
				<div id="newsletter" class="tab-pane">
                  <div class="portlet">
                    <div class="portlet-header">
                      <div class="caption">NewsLetter Text</div>
                      <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
                    </div>
                    <div class="portlet-body">
                    	<div class="table-responsive mtl">
                          <table class="table table-hover table-striped">
                            <thead>
                              <tr>
                                <th width="1%"><input type="checkbox"/></th>
                                <th>#</th>
                                <th>Title</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td><input type="checkbox"/></td>
                                <td>1</td>
                                <td>{!! isset($info['newsletter']['newsletter'])?$info['newsletter']['newsletter']:'' !!} </td>
                                <td><a href="#" data-hover="tooltip" data-placement="top" data-target="#modal-edit-newsletter-text" data-toggle="modal" title="Edit"><span class="label label-sm label-success"><i class="fa fa-pencil"></i></span></a>
                                    <!--Modal Edit about start-->
                                    <div id="modal-edit-newsletter-text" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                      <div class="modal-dialog modal-wide-width">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                            <h4 id="modal-login-label3" class="modal-title">Newsletter Text Edit</h4>
                                          </div>
                                          <div class="modal-body">
										   <div class="form">
                                             <form method="POST" action="{{url('web88cms/footer_setup')}}" accept-charset="UTF-8"  class="form-horizontal">
											 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <div class="form-group">
                                                  <label class="col-md-3 control-label">Newsletter Text</label>
                                                  <div class="col-md-9">
                                                    <div class="text-blue border-bottom">You can edit the content by clicking the text section below.</div>
                                                    <textarea name="footer[newsletter]" contenteditable="true">{{ isset($info['newsletter']['newsletter'])?$info['newsletter']['newsletter']:'' }}</textarea>
                                                  </div>
                                                </div>
												<input name="footer[type]"  value="newsletter" type="hidden"/>
                                                <div class="form-actions">
                                                  <div class="col-md-offset-5 col-md-8">
												  <button type="submit" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></button> &nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                  <!--END MODAL Edit copyright -->
                                </td>
                              </tr>
                            </tbody>
                            <tfoot>
                              <tr>
                                <td colspan="4"></td>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                        <!-- end table responsive -->
                    </div>
                    <!-- end portlet body -->
                  </div>
                  <!-- End porlet -->
                </div>
                <!-- end tab newsletter text -->
				<div id="contact-details" class="tab-pane">
                  <div class="portlet">
                    <div class="portlet-header">
                      <div class="caption">Contact Details</div>
                      <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
                    </div>
                    <div class="portlet-body">
                    	<div class="table-responsive mtl">
                          <table class="table table-hover table-striped">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td>Title</td>
                                <td>{!! isset($info['title']['title'])?$info['title']['title']:'' !!} </td>
                                <td><a href="#" data-hover="tooltip" data-placement="top" data-target="#modal-edit-title-text" data-toggle="modal" title="Edit"><span class="label label-sm label-success"><i class="fa fa-pencil"></i></span></a>
                                    <!--Modal Edit about start-->
                                    <div id="modal-edit-title-text" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                      <div class="modal-dialog modal-wide-width">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                            <h4 id="modal-login-label3" class="modal-title">Title Text Edit</h4>
                                          </div>
                                          <div class="modal-body">
										   <div class="form">
                                             <form method="POST" action="{{url('web88cms/footer_setup')}}" accept-charset="UTF-8"  class="form-horizontal">
											 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <div class="form-group">
                                                  <label class="col-md-3 control-label">Title Text</label>
                                                  <div class="col-md-9">
                                                    <div class="text-blue border-bottom">You can edit the content by clicking the text section below.</div>
                                                    <textarea name="footer[title]" contenteditable="true">{{ isset($info['title']['title'])?$info['title']['title']:'' }}</textarea>
                                                  </div>
                                                </div>
												<input name="footer[type]"  value="title" type="hidden"/>
                                                <div class="form-actions">
                                                  <div class="col-md-offset-5 col-md-8">
												  <button type="submit" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></button> &nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                  <!--END MODAL Edit copyright -->
                                </td>
                              </tr>
							  <tr>
                                <td>2</td>
                                <td>Description</td>
                                <td>{!! isset($info['description']['description'])?$info['description']['description']:'' !!} </td>
                                <td><a href="#" data-hover="tooltip" data-placement="top" data-target="#modal-edit-description-text" data-toggle="modal" title="Edit"><span class="label label-sm label-success"><i class="fa fa-pencil"></i></span></a>
                                    <!--Modal Edit about start-->
                                    <div id="modal-edit-description-text" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                      <div class="modal-dialog modal-wide-width">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                            <h4 id="modal-login-label3" class="modal-title">Description Edit</h4>
                                          </div>
                                          <div class="modal-body">
										   <div class="form">
                                             <form method="POST" action="{{url('web88cms/footer_setup')}}" accept-charset="UTF-8"  class="form-horizontal">
											 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <div class="form-group">
                                                  <label class="col-md-3 control-label">Description Text</label>
                                                  <div class="col-md-9">
                                                    <div class="text-blue border-bottom">You can edit the content by clicking the text section below.</div>
                                                    <textarea name="footer[description]" contenteditable="true">{{ isset($info['description']['description'])?$info['description']['description']:'' }}</textarea>
                                                  </div>
                                                </div>
												<input name="footer[type]"  value="description" type="hidden"/>
                                                <div class="form-actions">
                                                  <div class="col-md-offset-5 col-md-8">
												  <button type="submit" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></button> &nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                  <!--END MODAL Edit copyright -->
                                </td>
                              </tr>
							  <tr>
                                <td>3</td>
                                <td>Address</td>
                                <td>{!! isset($info['address']['address'])?$info['address']['address']:'' !!} </td>
                                <td><a href="#" data-hover="tooltip" data-placement="top" data-target="#modal-edit-address-text" data-toggle="modal" title="Edit"><span class="label label-sm label-success"><i class="fa fa-pencil"></i></span></a>
                                    <!--Modal Edit about start-->
                                    <div id="modal-edit-address-text" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                      <div class="modal-dialog modal-wide-width">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                            <h4 id="modal-login-label3" class="modal-title">Address Text Edit</h4>
                                          </div>
                                          <div class="modal-body">
										   <div class="form">
                                             <form method="POST" action="{{url('web88cms/footer_setup')}}" accept-charset="UTF-8"  class="form-horizontal">
											 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <div class="form-group">
                                                  <label class="col-md-3 control-label">Address Text</label>
                                                  <div class="col-md-9">
                                                    <div class="text-blue border-bottom">You can edit the content by clicking the text section below.</div>
                                                    <textarea name="footer[address]" contenteditable="true">{{ isset($info['address']['address'])?$info['address']['address']:'' }}</textarea>
                                                  </div>
                                                </div>
												<input name="footer[type]"  value="address" type="hidden"/>
                                                <div class="form-actions">
                                                  <div class="col-md-offset-5 col-md-8">
												  <button type="submit" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></button> &nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                  <!--END MODAL Edit copyright -->
                                </td>
                              </tr>
							  <tr>
                                <td>4</td>
                                <td>Contact No</td>
                                <td>{!! isset($info['contact_no']['contact_no'])?$info['contact_no']['contact_no']:'' !!} </td>
                                <td><a href="#" data-hover="tooltip" data-placement="top" data-target="#modal-edit-contact_no-text" data-toggle="modal" title="Edit"><span class="label label-sm label-success"><i class="fa fa-pencil"></i></span></a>
                                    <!--Modal Edit about start-->
                                    <div id="modal-edit-contact_no-text" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                      <div class="modal-dialog modal-wide-width">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                            <h4 id="modal-login-label3" class="modal-title">Contact Number Edit</h4>
                                          </div>
                                          <div class="modal-body">
										   <div class="form">
                                             <form method="POST" action="{{url('web88cms/footer_setup')}}" accept-charset="UTF-8"  class="form-horizontal">
											 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <div class="form-group">
                                                  <label class="col-md-3 control-label">Contact Number</label>
                                                  <div class="col-md-9">
                                                    <div class="text-blue border-bottom">You can edit the content by clicking the text section below.</div>
                                                    <textarea name="footer[contact_no]" contenteditable="true">{{ isset($info['contact_no']['contact_no'])?$info['contact_no']['contact_no']:'' }}</textarea>
                                                  </div>
                                                </div>
												<input name="footer[type]"  value="contact_no" type="hidden"/>
                                                <div class="form-actions">
                                                  <div class="col-md-offset-5 col-md-8">
												  <button type="submit" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></button> &nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                  <!--END MODAL Edit copyright -->
                                </td>
                              </tr>
							  <tr>
                                <td>5</td>
                                <td>Fax No</td>
                                <td>{!! isset($info['fax']['fax'])?$info['fax']['fax']:'' !!} </td>
                                <td><a href="#" data-hover="tooltip" data-placement="top" data-target="#modal-edit-fax-text" data-toggle="modal" title="Edit"><span class="label label-sm label-success"><i class="fa fa-pencil"></i></span></a>
                                    <!--Modal Edit about start-->
                                    <div id="modal-edit-fax-text" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                      <div class="modal-dialog modal-wide-width">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                            <h4 id="modal-login-label3" class="modal-title">Fax Number Edit</h4>
                                          </div>
                                          <div class="modal-body">
										   <div class="form">
                                             <form method="POST" action="{{url('web88cms/footer_setup')}}" accept-charset="UTF-8"  class="form-horizontal">
											 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <div class="form-group">
                                                  <label class="col-md-3 control-label">Fax Number</label>
                                                  <div class="col-md-9">
                                                    <div class="text-blue border-bottom">You can edit the content by clicking the text section below.</div>
                                                    <textarea name="footer[fax]" contenteditable="true">{{ isset($info['fax']['fax'])?$info['fax']['fax']:'' }}</textarea>
                                                  </div>
                                                </div>
												<input name="footer[type]"  value="fax" type="hidden"/>
                                                <div class="form-actions">
                                                  <div class="col-md-offset-5 col-md-8">
												  <button type="submit" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></button> &nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                  <!--END MODAL Edit copyright -->
                                </td>
                              </tr>
							  <tr>
                                <td>6</td>
                                <td>Email 1</td>
                                <td>{!! isset($info['email_1']['email_1'])?$info['email_1']['email_1']:'' !!} </td>
                                <td><a href="#" data-hover="tooltip" data-placement="top" data-target="#modal-edit-email_1-text" data-toggle="modal" title="Edit"><span class="label label-sm label-success"><i class="fa fa-pencil"></i></span></a>
                                    <!--Modal Edit about start-->
                                    <div id="modal-edit-email_1-text" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                      <div class="modal-dialog modal-wide-width">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                            <h4 id="modal-login-label3" class="modal-title">Email 1 Edit</h4>
                                          </div>
                                          <div class="modal-body">
										   <div class="form">
                                             <form method="POST" action="{{url('web88cms/footer_setup')}}" accept-charset="UTF-8"  class="form-horizontal">
											 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <div class="form-group">
                                                  <label class="col-md-3 control-label">Email</label>
                                                  <div class="col-md-9">
                                                    <div class="text-blue border-bottom">You can edit the content by clicking the text section below.</div>
                                                    <textarea name="footer[email_1]" contenteditable="true">{{ isset($info['email_1']['email_1'])?$info['email_1']['email_1']:'' }}</textarea>
                                                  </div>
                                                </div>
												<input name="footer[type]"  value="email_1" type="hidden"/>
                                                <div class="form-actions">
                                                  <div class="col-md-offset-5 col-md-8">
												  <button type="submit" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></button> &nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                  <!--END MODAL Edit copyright -->
                                </td>
                              </tr>
							  <tr>
                                <td>7</td>
                                <td>Email 2</td>
                                <td>{!! isset($info['email_2']['email_2'])?$info['email_2']['email_2']:'' !!} </td>
                                <td><a href="#" data-hover="tooltip" data-placement="top" data-target="#modal-edit-email_2-text" data-toggle="modal" title="Edit"><span class="label label-sm label-success"><i class="fa fa-pencil"></i></span></a>
                                    <!--Modal Edit about start-->
                                    <div id="modal-edit-email_2-text" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                      <div class="modal-dialog modal-wide-width">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                            <h4 id="modal-login-label3" class="modal-title">Email 2 Edit</h4>
                                          </div>
                                          <div class="modal-body">
										   <div class="form">
                                             <form method="POST" action="{{url('web88cms/footer_setup')}}" accept-charset="UTF-8"  class="form-horizontal">
											 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <div class="form-group">
                                                  <label class="col-md-3 control-label">Email</label>
                                                  <div class="col-md-9">
                                                    <div class="text-blue border-bottom">You can edit the content by clicking the text section below.</div>
                                                    <textarea name="footer[email_2]" contenteditable="true">{{ isset($info['email_2']['email_2'])?$info['email_2']['email_2']:'' }}</textarea>
                                                  </div>
                                                </div>
												<input name="footer[type]"  value="email_2" type="hidden"/>
                                                <div class="form-actions">
                                                  <div class="col-md-offset-5 col-md-8">
												  <button type="submit" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></button> &nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                  <!--END MODAL Edit copyright -->
                                </td>
                              </tr>
                            </tbody>
                            <tfoot>
                              <tr>
                                <td colspan="4"></td>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                        <!-- end table responsive -->
                    </div>
                    <!-- end portlet body -->
                  </div>
                  <!-- End porlet -->
                </div>
                <!-- end tab contact-details text -->
                <div id="hotel_location" class="tab-pane fade">
                  <div class="portlet">
                    <div class="portlet-header">
                      <div class="caption">Hotel Location Edit</div>
                      <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
                    </div>
                    <div class="portlet-body">
                      <div class="row">
                                <div class="col-md-12">
                                    <!-- Map
                                                  ============================================= -->
                                                  <div>
                                                    <iframe  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCuGRp7Cn9FrtJXeZ2Kp_WqqieB7P18K88&q={{ isset($info['address']['address']) ? $info['address']['address'] : '22A, Jalan Lang Jaya 1, Pusat Komersial Lang Jaya, 30010 Ipoh, Perak, Malaysia.'  }} "
                                                                                  width="100%" height="400" frameborder="0" style="border:0;"></iframe>
                                              </div>
                                    note to programmer: the "Edit Google Map" button is only appeared in admin. This is
                                    the function for admin to update the google map here. The edit google map function
                                    is to use "Geocoding". Please do not display this button in front end.
                                    <div class="clearfix"></div>
                                    <a href='javascript:void(0)' data-target="#modal-edit-map" data-toggle="modal">
                                        <button type="button" class="btn btn-yellow">Edit Google Map <i
                                                    class="fa fa-edit"></i></button>
                                    </a>
                                    <div class="clearfix"></div>
                                </div>
                                <!-- end col-md-12 -->
                                <div class="clearfix"></div>
                                <div class="height40"></div>
                            </div>
							<div id="modal-edit-map" question_quiz role="dialog" aria-labelledby="modal-login-label"
                         aria-hidden="true" class="modal fade">
                        <div class="modal-dialog modal-wide-width">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">
                                        &times;
                                    </button>
                                    <h4 id="modal-login-label3" class="modal-title">Edit Google Map</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form">
                                        <form class="form-horizontal" action="/web88cms/footer_setup" method="post">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                            <input name="footer[type]"  value="address" type="hidden"/>
                                    <input name="footer[address]"  value="address" type="hidden" id="txt-address"/>
                                            <?php $gmap = ''; ?>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Search Google Map <span
                                                            class='require'>*</span></label>
                                                <div class="col-md-9">
                                                    <input type="text" id="map_address"  class="form-control" placeholder="" value="{{ isset($info['address']['address']) ? $info['address']['address'] : '22A, Jalan Lang Jaya 1, Pusat Komersial Lang Jaya, 30010 Ipoh, Perak, Malaysia.'  }}" />
                                                    <div class="margin-top-10px">
                                                        <input type="button" onclick="updateMapAdd('map_load_dynamic1','search');" id="gmap_geocoding_btn" class="btn btn-dark" value="Search" />
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="form-group">
                                                <label class="col-md-3 control-label">Embed Google Map URL</label>
                                                <div class="col-md-9">
                                                    <textarea class="form-control"
                                                              name="line2">{{$gmap?$gmap->line2:'Enter Google Map URL'}}</textarea>

                                                </div>
                                            </div> --}}
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Preview Map</label>
                                                <div class="col-md-9"> note to programmer: after click the search button
                                                    above, please display the correct google map here for previewing.
                                                    <div class="map-wrapper map-wrapper__small">
                                                        <div id="map_canvas1" class="map-canvas">
                                                            <iframe id="map_load_dynamic1" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCuGRp7Cn9FrtJXeZ2Kp_WqqieB7P18K88&q={{ isset($info['address']['address']) ? $info['address']['address'] : '22A, Jalan Lang Jaya 1, Pusat Komersial Lang Jaya, 30010 Ipoh, Perak, Malaysia.'  }} "
                                                                    width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen></iframe>
                                                        </div>
                                                        {{-- <div id="map_canvas" class="map-canvas">
                                                            <iframe src="{{$gmap?$gmap->line2:'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d31869.680998370222!2d101.69736!3d3.17083!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x5093028faadba857!2sSentosa+Medical+Centre!5e0!3m2!1sen!2s!4v1467355139378'}}"
                                                                    width="100%" height="450" frameborder="0"
                                                                    style="border:0" allowfullscreen></iframe>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="model" value="google_map">
                                            <div class="form-actions">
                                                <div class="col-md-offset-5 col-md-8">
                                                    <button class="btn btn-red">Save &nbsp;<i
                                                                class="fa fa-floppy-o"></i></button>&nbsp; <a
                                                            href='javascript:void(0)' data-dismiss="modal"
                                                            class="btn btn-green">Cancel &nbsp;<i
                                                                class="glyphicon glyphicon-ban-circle"></i></a></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                      <div class="clearfix"></div>
                    </div>
                  </div>
                </div>

                <!-- end background image -->
                <div id="social-link" class="tab-pane fade">
                  <div class="portlet">
                    <div class="portlet-header">
                      <div class="caption">Social Links</div>
                      <br/>
                      <p class="margin-top-10px"></p>
                      <a href="#" data-target="#modal-add-social-link" data-toggle="modal" class="btn btn-success">Add New &nbsp;<i class="fa fa-plus"></i></a>&nbsp;
                      <div class="btn-group">
                        <button type="button" class="btn btn-primary">Delete</button>
                        <button type="button" data-toggle="dropdown" class="btn btn-red dropdown-toggle"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                        <ul role="menu" class="dropdown-menu">
                          <li><a href="#" id="dellselobjfoot" onclick="deleteGstrates('selected')">Delete selected item(s)</a></li>
                          <li class="divider"></li>
                          <li><a href="#" onclick="deleteGstrates('all')">Delete all</a></li>
                        </ul>
                      </div>

                      <!--Modal delete selected items start-->
                                <div id="modal-delete-selected" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                        <h4 id="modal-login-label4" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> <span id="delete_title">Are you sure you want to delete the selected item(s)? </span></h4>
                                      </div>

                                      <form method="POST" action="{{url('web88cms/footer_setup')}}" accept-charset="UTF-8"  class="form-horizontal">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <input type="hidden" id="selected_id" name="footer[all_delete-icon]" value="" />
                                        <input type="hidden" name="footer[type]" value="icon" />
                                      <div class="modal-body">

                                        <div class="form-actions">
                                          <div class="col-md-offset-4 col-md-8"> <button type="submit" class="del-one-txtobj btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></button>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                                        </div>
                                      </div>
                                    </form>

                                    </div>
                                  </div>
                                </div>
                                <!-- modal delete selected items end -->


                       
<div class="tools"> <i class="fa fa-chevron-up"></i> </div>
                      <!--Modal Add New Social Link start-->
                      <div id="modal-add-social-link" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                        <div class="modal-dialog modal-wide-width">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                              <h4 id="modal-login-label3" class="modal-title">Add New</h4>
                            </div>
                            <div class="modal-body">
                              <div class="form">
                               <form method="POST" action="{{url('web88cms/footer_setup')}}" accept-charset="UTF-8"  class="form-horizontal">
							   <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Status</label>
                                    <div class="col-md-6">
                                      <div data-on="success" data-off="primary" class="make-switch">
                                        <input type="checkbox" name="footer[active]" value="1" checked="checked"/>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Title</label>
                                    <div class="col-md-6">
                                      <input type="text" name="footer[title]" class="form-control" placeholder="Facebook">
                                    </div>
                                    <div class="col-md-3"> </div>
                                  </div>
								  <input type="hidden" value="icon" name="footer[type]"/>
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Icon <span class='require'>*</span></label>
                                    <div class="col-md-6">
                                      <input type="text" name="footer[icon]" class="form-control" id="inputContent" placeholder="icon-facebook">
                                      <div class="help-block">Please refer here for more <a href="icon" target="_blank">icon options.</a></div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-md-3 control-label">Website URL</label>
                                    <div class="col-md-6">
                                      <div class="input-icon"><i class="fa fa-link"></i>
                                          <input type="text" name="footer[link]" placeholder="http://" class="form-control"/>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-actions">
                                    <div class="col-md-offset-5 col-md-8"> <button type="submit" class="ft_save btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></button>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                  </div>
                               </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--END MODAL Add New Objective-->


					   <form method="POST" action="{{url('web88cms/footer_setup')}}" accept-charset="UTF-8"  class="form-horizontal">
					   <input type="hidden" name="page" value="footer_setup" />
					   <input type="hidden" name="index" value="" />
					   <input type="hidden" name="type" value="icon" />

						</form>
                      <!-- modal delete all items end -->
                    </div>
                    <div class="portlet-body">
                      <div class="table-responsive mtl">
                          <table id="table-title-slider" class="table table-hover table-striped">
                            <thead>
                              <tr>
                                <th width="1%"><input type="checkbox"/ id="selectall"></th>
                                <th>#</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>URL</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>



                              <?php //dd($info['icon']); ?>

							@if(isset($info['icon']) && !empty($info['icon']))
							@foreach($info['icon'] as $key => $value)
                              <?php
                                //print_r($value);
                                if(!empty($value['icon']) && !empty($value['title']) && !empty($value['link'])){
                              ?>
                              <tr>
                                <td><input data="{{ $key }}" type="checkbox" class="social_link case" name="social_link[]" value="{{ $key }}" /></td>
                                <td>{{ $key }}</td>
                                <td>{{ $value['title'] }}</td>
                                <td>
                                  {{-- {{ $value['link'] }} --}}
                                  @if(isset($value['active']) && $value['active'] == 1)
                                  <span class="btn btn-info">Active</span>
                                  @else
                                  <span class="btn btn-danger">Inactive</span>
                                  @endif
                                </td>
                                <td>{{ $value['link'] }}</td>

                                <td><a href="#" data-hover="tooltip" data-placement="top" data-target="#modal-edit-link{{ $key }}" data-toggle="modal" title="Edit"><span class="label label-sm label-success"><i class="fa fa-pencil"></i></span></a> <a href="#" data-hover="tooltip" data-placement="top" title="Delete" data-target="#modal-delete-{{ $key }}" data-toggle="modal"><span class="label label-sm label-red"><i class="fa fa-trash-o"></i></span></a>





                                  <!--Modal Edit social links start-->
                                    <div id="modal-edit-link{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                      <div class="modal-dialog modal-wide-width">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                            <h4 id="modal-login-label3" class="modal-title">Social Links Edit</h4>
                                          </div>
                                          <div class="modal-body">
                                            <div class="form">
                                               <form method="POST" action="{{url('web88cms/footer_setup')}}" accept-charset="UTF-8"  class="form-horizontal">
                         <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <div class="form-group">
                                                  <label class="col-md-3 control-label">Status</label>


                                                  <div class="col-md-6">
                                                            <div data-on="success"
                                                                 data-off="primary"
                                                                 class="make-switch">
                                                                <select name="footer[active]" class="form-control">
                                                                    <option value="1" {{ (isset($value['active']) && $value['active'] == 1)?"selected":""}}>Active</option>
                                                                    <option value="0" {{ (isset($value['active']) && $value['active'] == 0) ?"selected":""}}>Inactive</option>
                                                                </select>

                                                            </div>
                                                        </div>

                                                </div>
                                              <input type="hidden" name="footer[edit-icon]" value="{{ $key }}" />
                                                <div class="form-group">
                                                  <label class="col-md-3 control-label">Title </label>
                                                  <div class="col-md-6">
                                                    <input id="text{{ $key }}" name="footer[title]" type="text" class="form-control" placeholder="Facebook" value="{{ $value['title'] }}">
                                                  </div>
                                                </div>
                        <input type="hidden" name="footer[type]" value="icon" />
                                                <div class="form-group">
                                                  <label class="col-md-3 control-label">Icon <span class='require'>*</span></label>
                                                  <div class="col-md-6">
                                                    <input type="text" name="footer[icon]" class="form-control" id="inputContent{{ $key }}" placeholder="icon-facebook" value="{{ $value['icon'] }}">
                                                    <div class="help-block">Please refer here for more <a href="icon" target="_blank">icon options.</a></div>
                                                  </div>
                                                </div>
                                                <div class="form-group">
                                                  <label class="col-md-3 control-label">Website URL</label>
                                                  <div class="col-md-6">
                                                    <div class="input-icon"><i class="fa fa-link"></i>
                                                        <input type="text" name="footer[link]" placeholder="http://" class="form-control" value="{{ $value['link'] }}"/>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="form-actions">
                                                  <div class="col-md-offset-5 col-md-8"> <button type="submit" class="ft_save btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></button>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                  </div>





                                  <!--END MODAL Edit social links -->
                                    <!--Modal delete start-->
                                    <div id="modal-delete-{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                            <h4 id="modal-login-label4" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete this? </h4>
                                          </div>
										   <form method="POST" action="{{url('web88cms/footer_setup')}}" accept-charset="UTF-8"  class="form-horizontal">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                            <input type="hidden" name="footer[delete-icon]" value="{{ $key }}" />

                                           <input type="hidden" name="footer[active]" value="0" />
                                           <input type="hidden" name="footer[title]" value="" />
                                           <input type="hidden" name="footer[icon]" value="" />
                                           <input type="hidden" name="footer[link]" value="" />
										   <input type="hidden" name="footer[type]" value="icon" />
										   {{-- <input type="hidden" name="footer[page]" value="footer_setup" /> --}}

                                          <div class="modal-body">
                                            <p><strong>#{{ $key }}:</strong> {{ $value['title'] }}.</p>
                                            <div class="form-actions">
                                              <div class="col-md-offset-4 col-md-8"> <button type="submit" class="del-one-txtobj btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></button>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                                            </div>
                                          </div>
										</form>
                                        </div>
                                      </div>
                                  </div>
                                  <!-- modal delete end -->
                                </td>




                              </tr>
                              <?php } ?>
							 @endforeach
							 @endif





                            </tbody>
                            <tfoot>
                              <tr>
                                <td colspan="5"></td>
                              </tr>
                            </tfoot>
                          </table>
                       </div>
                       <!-- end table responsive -->
                    </div>
                    <!-- end portlet body -->
                  </div>
                  <!-- End porlet -->
                </div>
                <!-- end tab social links -->


				<div id="footerimage" class="tab-pane fade">
                  <div class="portlet">
                    <div class="portlet-header">
                      <div class="caption">Footer Image Edit</div>
                      <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
                    </div>
                    <div class="portlet-body">
                      <div class="table-responsive mtl">
                          <table class="table table-hover table-striped">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Status</th>
                                <th>Title</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td>@if(isset($info['image']['active']) && $info['image']['active'])
							<span class="label label-sm label-success">Active</span>
								@else
							<span class="label label-sm label-red">Inactive</span>
								@endif</td>
                                <td>{{ $info['image']['title'] }}</td>
                                <td><a href="#" data-hover="tooltip" data-placement="top" data-target="#modal-edit-footer-background" data-toggle="modal" title="Edit"><span class="label label-sm label-success"><i class="fa fa-pencil"></i></span></a>
                                    <!--Modal Edit footer Background image start-->
                                    <div id="modal-edit-footer-background" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                      <div class="modal-dialog modal-wide-width">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                            <h4 id="modal-login-label3" class="modal-title">Footer Background Image Edit</h4>
                                          </div>
                                          <div class="modal-body">
                                            <div class="form">
											  <form method="POST" action="{{url('web88cms/footer_setup')}}" accept-charset="UTF-8"  class="form-horizontal" enctype="multipart/form-data">
											 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <div class="form-group">
                                                  <label class="col-md-3 control-label">Status</label>
                                                  <div class="col-md-6">
                                                    <div data-on="success" data-off="primary" class="make-switch">
                                                      @if(isset($info['image']['active']) && $info['image']['active'])
                                                  <input type="checkbox" name="footer[active]" value="1" checked="checked"/>
                                               @else
                                                  <input type="checkbox" name="footer[active]" value="1" />
                                               @endif
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="form-group">
                                                  <label class="col-md-3 control-label">Title </label>
                                                  <div class="col-md-6">
                                                    <input id="text" name="footer[title]" type="text" class="form-control" placeholder="Footer Background Image" value="{{ $info['image']['title'] }}">
                                                  </div>
                                                </div>
												                        <input type="hidden" value="image" name="footer[type]"/>
                                                <div class="form-group">
                                                  <label class="col-md-3 control-label">Upload Background Image <span class='require'>*</span></label>
                                                  <div class="col-md-9">
                                                    <div class="text-15px margin-top-10px"> <img src="../images/{{ $info['image']['fg'] }}" alt="Footer" class="img-responsive"><br/>
                                                        <input id="exampleInputFile2" type="file" name="fg"/>
                                                        <br/>
                                                        <span class="help-block">(Image dimension: 1920 x 175 pixels, JPEG/GIF/PNG only, Max. 1MB) </span> </div>
                                                  </div>
                                                </div>
                                                <div class="form-actions">
                                                  <div class="col-md-offset-5 col-md-8"> <button type="submit" class="ft_save btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></button>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                  <!--END MODAL Edit footer background image -->
                                </td>
                              </tr>
                            </tbody>
                            <tfoot>
                              <tr>
                                <td colspan="4"></td>
                              </tr>
                            </tfoot>
                          </table>
                      </div>
                      <!-- end table responsive -->
                      <div class="clearfix"></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end tab content -->
              <div class="clearfix"></div>
            </div>
            <!-- end col-lg-12 -->
          </div>
          <!-- end row -->
        </div>
        <!-- InstanceEndEditable -->
        <!--END CONTENT-->

            <!--BEGIN FOOTER-->
<div class="page-footer" style="width: 100%;">
                <div class="copyright"><span class="text-15px">2015 © <a href="http://www.webqom.com" target="_blank">Webqom Technologies Sdn Bhd.</a> Any queries, please contact <a href="mailto:support@webqom.com">Webqom Support</a>.</span>
                	<div class="pull-right"><img src="images/logo_webqom.png" alt="Webqom Technologies Sdn Bhd"></div>
                </div>
        </div>
    <!--END FOOTER--></div>
  <!--END PAGE WRAPPER--></div>
</div>



<!-- Here liks is unnecessary so that i commented   -->
 <!--
<script src="{{ URL::asset('public/admin/js/jquery-1.9.1.js') }}"></script>
<script src="{{ URL::asset('public/admin/js/jquery-migrate-1.2.1.min.js') }}"></script>
<script src="{{ URL::asset('public/admin/js/jquery-ui.js') }}"></script>

<script src="{{ URL::asset('public/admin/vendors/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('public/admin/vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js') }}"></script>
<script src="{{ URL::asset('public/admin/js/html5shiv.js') }}"></script>
<script src="{{ URL::asset('public/admin/js/respond.min.js') }}"></script>
<script src="{{ URL::asset('public/admin/vendors/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ URL::asset('public/admin/vendors/slimScroll/jquery.slimscroll.js') }}"></script>
<script src="{{ URL::asset('public/admin/vendors/jquery-cookie/jquery.cookie.js') }}"></script>
<script src="{{ URL::asset('public/admin/js/jquery.menu.js') }}"></script>
<script src="{{ URL::asset('public/admin/vendors/jquery-pace/pace.min.js') }}"></script>


<script src="{{ URL::asset('public/admin/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('public/admin/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('public/admin/vendors/moment/moment.js') }}"></script>
<script src="{{ URL::asset('public/admin/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ URL::asset('public/admin/vendors/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
<script src="{{ URL::asset('public/admin/vendors/bootstrap-clockface/js/clockface.js') }}"></script>
<script src="{{ URL::asset('public/admin/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>

<script src="{{ URL::asset('public/admin/vendors/jquery-maskedinput/jquery-maskedinput.js') }}"></script>
<script src="{{ URL::asset('public/admin/js/form-components.js') }}"></script>


<script src="{{ URL::asset('public/admin/vendors/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ URL::asset('public/admin/js/ui-tabs-accordions-navs.js') }}"></script>


<script src="{{ URL::asset('public/admin/js/main.js') }}"></script>
<script src="{{ URL::asset('public/admin/js/holder.js') }}"></script>
-->

<script src="{{ URL::asset('public/admin/vendors/ckeditor/ckeditor.js') }}"></script>

<script type="text/javascript">
 // Bulk select jaquery
 // add multiple select / deselect functionality
  $("#selectall").click(function () {
      $('.case').attr('checked', this.checked);
  });

  // if all checkbox are selected, check the selectall checkbox
  // and viceversa
  $(".case").click(function(){

    if($(".case").length == $(".case:checked").length) {
      $("#selectall").attr("checked", "checked");
    } else {
      $("#selectall").removeAttr("checked");
    }

  });

</script>

<!-- InstanceEndEditable -->
<script>
function remember(item){
		var cookieName = 'tabSelected';
		var cookieOptions = {expires: 7, path: '/'};
			$.cookie(cookieName, item, cookieOptions);
	}
$('#myTab > li').click(function(){
		var tab = $('#myTab > li').index($(this));
		remember(tab);
		console.log($.cookie('tabSelected'));
	});
/*
if($.cookie('tabSelected')){
		$('#myTab > li').removeClass('active');
		$('#myTab > li:eq(' + $.cookie('tabSelected') + ')').addClass('active');
		if($.cookie('tabSelected') == '0'){
			$('#copyrighttext').attr('class', 'tab-pane fade active in');
			$('#footerimage').attr('class', 'tab-pane fade');
			$('#social-link').attr('class', 'tab-pane fade');
		}else if($.cookie('tabSelected') == '1'){
			$('#copyrighttext').attr('class', 'tab-pane fade');
			$('#footerimage').attr('class', 'tab-pane fade active in');
			$('#social-link').attr('class', 'tab-pane fade');
		}else if($.cookie('tabSelected') == '2'){
			$('#copyrighttext').attr('class', 'tab-pane fade');
			$('#footerimage').attr('class', 'tab-pane fade');
			$('#social-link').attr('class', 'tab-pane fade active in');
		}
	} */
</script>



<script type="text/javascript">
/* Fix for bootstrap modal + ckeditor + chrome */
CKEDITOR.disableAutoInline = true;

$('.modal').on('shown.bs.modal', function () {
	$(this).find('[contenteditable="true"]').each(function (i) {
		if (this.id == '') {
			this.id = 'ckedit_'+i;
		}
	//	alert(this.id);
		if(CKEDITOR.instances[this.id] === undefined) {
			CKEDITOR.inline(this.id);
		}
	});
});
</script>
<script type="text/javascript">
// del-one-txtobj
  function deleteGstrates(type) {
    var value = [];
    if (type == 'selected') {
      $(".social_link:checked").each(function() {
        value.push($(this).val());
      });
      var total = value.length;
      if (total > 0) {
        $('#delete_title').html('Are you sure you want to delete the selected item(s)');
        $('#selected_id').val(value);
        $('#modal-delete-selected').modal();
      }else{ alert('Please select at least one Item Rate before delete.'); }

    } else {
      $(".social_link").each(function() {
        value.push($(this).val());
      });
      var total = value.length;
      if (total > 0) {
        $('#delete_title').html('Are you sure you want to delete the all item(s)');
        $('#selected_id').val(value);
        $('#modal-delete-selected').modal();
      }else{ alert('No item find to delete !!.'); }


    }

  }

</script>
<script>

    function updateMapAdd(id, type)
    {
        var add = $('#map_address').val();
        var src = "https://www.google.com/maps/embed/v1/place?key=AIzaSyCuGRp7Cn9FrtJXeZ2Kp_WqqieB7P18K88&q=" + add;
        if (type == 'search')
        {
            $("#" + id).attr("src", src);
            $('#txt-address').val(add)
        }

        if (type == 'save')
        {
            $('#txt-address').val(add)
            $('#' + id).attr("src", src);
            $(document).find('#right-block1-content').val(add);
            console.log( $(document).find('#right-block1-content').val());
        }
    }

 function updateMapAddContact(addId, id, type, url)
    {
        var helper = null;
        if (typeof url === 'undefined') {

            var add = $('#' + addId).val();
            var src = "https://www.google.com/maps/embed/v1/place?key=AIzaSyCuGRp7Cn9FrtJXeZ2Kp_WqqieB7P18K88&q=" + add;
            helper = "com/maps/embed/v1/place?key=AIzaSyCuGRp7Cn9FrtJXeZ2Kp_WqqieB7P18K88&q=" + add;
            if (type == 'search')
            {


                $("#mapmodal_" + id).attr("src", src);
            }

            if (type == 'save')
            {
                $('#map_' + id).attr("src", src);
                $('#' + id).val(helper);
                $('.msuccess').removeClass(hide);
                window.scrollTo(0, 0);
            }
        } else {

            if (url != null) {

                if (url.search("google") != -1) {

                    var x = null;   /// equ = add
                    var srcc = null;

                    if (url.search("mid") == -1) { //url not contain mid


                        var arr = url.split('/');
                        var y = arr[5];

                        /*	 if url contains search country    */
                        if (y != null && y.search("@") == -1 && y.search("%") == -1 && y.search("data") == -1) {

                            x = y.replace(/\+/g, ' ').replace(/\,/g, ' ');

                        } else {
                            var subStr = url.match("@(.*)z");
                            var f = subStr[1];
                            var llz = f.split(',');
                            //longitude
                            var mlong = llz[0];
                            //latitude
                            var mlat = llz[1];
                            //zoom defult=6
                            var zo = 6;
                            if (llz[2] != null) {
                                zo = llz[2];

                            }
                            x = mlong + " " + mlat + " &zoom=" + zo;


                        }
                        srcc = "https://www.google.com/maps/embed/v1/place?key=AIzaSyC3bDbxNOKRdamYrBDlTrInjywsZUzkY44&q=" + x;
                        helper = "com/maps/embed/v1/place?key=AIzaSyC3bDbxNOKRdamYrBDlTrInjywsZUzkY44&q=" + x;
                        if (type == 'search')
                        {


                            $("#mapmodal_" + id).attr("src", srcc);
                        }

                        if (type == 'save')
                        {
                            //alert(srcc);
                            $('#map_' + id).attr("src", srcc);
                            $('#' + id).val(helper);
                            updateUrl(url);
                        }

                    } else {
                        //url contain mid

                        var subStr = url.match("mid(.*)");
                        var f = subStr[0];
                        var sr = "https://www.google.com/maps/d/embed?" + f;
                        srcc = sr;

                        var zzzo = srcc.match("google.(.*)");
                        helper = zzzo[1];
                        if (type == 'search')
                        {


                            $("#mapmodal_" + id).attr("src", srcc);
                        }

                        if (type == 'save')
                        {
                            //alert(srcc);
                            $('#map_' + id).attr("src", srcc);
                            $('#' + id).val(helper);
                            updateUrl(url);
                        }
                    }
                } else {
                    $('.mfail').removeClass('hide');
                    window.scrollTo(0, 0);
                }
            } else {
                $('.mfail').removeClass('hide');
                window.scrollTo(0, 0);
            }
        }//end else if => url defined





    }




</script>
@endsection
