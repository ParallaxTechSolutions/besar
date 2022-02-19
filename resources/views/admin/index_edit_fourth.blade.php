@extends('adminLayout')



@section('content')
<div id="page-wrapper"><!--BEGIN PAGE HEADER & BREADCRUMB-->
    <div class="page-header-breadcrumb">
        <div class="page-heading hidden-xs">
            <h1 class="page-title">CMS Pages</h1>
        </div>

        <!-- InstanceBeginEditable name="EditRegion1" -->
        <ol class="breadcrumb page-breadcrumb">
            <li><i class="fa fa-home"></i>&nbsp;<a href="dashboard.html">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
            <li>CMS Pages &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
            <li class="active">Index - Edit</li>
        </ol>
      </div>
    <div class="page-content">
        <div class="row">
            <div class="col-lg-12">
                <h2>Home Promtion Section <i class="fa fa-angle-right"></i> Edit</h2>
                <div class="clearfix"></div>
                <div class="alert alert-success alert-dismissable"
                     @if( Session::has('success') ) style="display: block;">
                      <script>setTimeout(function () {
                        $("body").animate({"scrollTop": 0}, 100);
                    }, 3000);</script>
                    <?php Session::forget('success'); ?>
                    @else
                      style="display: none;">
                    @endif
                    <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                    <i class="fa fa-check-circle"></i> <strong>Success!</strong>
                    <p>The information has been saved/updated successfully.</p>
                </div>
                <div class="alert alert-danger alert-dismissable" @if( Session::has('fail') ) style="display: block;">
                      <script>
                        setTimeout(function () {
                          $("body").animate({"scrollTop": 0}, 100);
                        }, 3000);</script>
                    <?php Session::forget('fail'); ?>
                    @else
                      style="display: none;">
                    @endif
                    <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                    <i class="fa fa-times-circle"></i> <strong>Error!</strong>
                    <p>The information has not been saved/updated. Please correct the errors.</p>
                </div>

                 <div id="saved" style="display:none;" class="alert alert-success alert-dismissable">
                    <button type="button" onclick="document.getElementById('saved').style.display='none'" class="close">&times;</button>
                    <i class="fa fa-check-circle"></i> <strong>Success!</strong>
                    <p>The information has been saved/updated successfully.</p>
                </div>

                    

                @if(null!==$updated)
                <div class="pull-left"> Last updated: <span class="text-blue">{{ $updated }}</span> </div>
                @endif
                <div class="clearfix"></div>
                <p></p>

                <div class="row">
                    <div class="col-md-12">
                    <div class="portlet">
                        <div class="portlet-header">
                            <div class="caption" style="float:none">Section Heading</div>
                            <br/>
                            <span class="text-blue text-12px">You can edit the content by clicking the text section below.</span>
                            <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
                        </div>
                        <div class="portlet-body">
                            <div id="textToBeSavedcontent1" contenteditable="true"> 
                                <?= !empty($header)? $header[0]->content:''; ?>
                            </div>
                        </div>
                    </div>
                    <!-- save button start -->
                    <div class="form-actions none-bg"> 
                        <a href="#" onclick="ClickToSave()" class="btn btn-red">Save &amp; Preview &nbsp;<i class="fa fa-search"></i></a>&nbsp; 
                        <a href="#"  onclick="ClickToSave()" class="btn btn-blue">Save &amp; Publish &nbsp;<i class="fa fa-globe"></i></a>&nbsp; 
                        <a href="#" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                    <!-- save button end -->
                   
                    </div>
                </div>
            
                <div class="clearfix"></div>
                <div class="portlet">
                    <div class="portlet-header">
                        <div class="caption">Section Left Content</div>
                        <div class="clearfix"></div>
                        <span class="text-blue text-12px">You can edit the content by clicking the text section below.</span>
                        <div class="tools"><i class="fa fa-chevron-up"></i></div>
                    </div>
                    <div class="portlet-body">
                        <section class="best-place-section best-place-style-two">
                            <div class="wbx_info" name="index[first]" contenteditable="true">
                                {!! html_entity_decode($data[0]) !!}
                            </div>
                        </section><!--/.best-place-section-->
                        <form method="post" action="{{URL('/web88cms/index_editor_fourth')}}" id="wbx_change_info">
                          <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                        </form>
                       
                    </div>
                    <!-- End portlet body -->
                    <!-- save button start -->
                    <div class="form-actions none-bg"> 
                      <a href="#preview in browser/not yet published" target="_blank" class="wbx_submit_preview btn btn-red">Save &amp; Preview &nbsp;<i class="fa fa-search"></i></a>&nbsp; 
                      <a href="#publish online" class="btn btn-blue wbx_submit_publish">Save &amp; Publish &nbsp;<i class="fa fa-globe"></i></a>&nbsp; 
                      <a href="#" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> 
                    </div>
                    <!-- save button end -->
                </div>
                <!-- End portlet -->
            </div>
        </div>
    </div>
    <!-- InstanceEndEditable -->
    <!--END CONTENT-->

    <!--BEGIN FOOTER-->
    <div class="page-footer">
        <div class="copyright"><span class="text-15px">2015 © <a href="http://www.webqom.com" target="_blank">Webqom Technologies Sdn Bhd.</a> Any queries, please contact <a href="mailto:support@webqom.com">Webqom Support</a>.</span>
            <div class="pull-right"><img src="{{ asset('/public/admin/images/logo_webqom.png') }}" alt="Webqom Technologies"></div>
        </div>
    </div>
    
</div>

<script src="{{ asset('/public/admin/vendors/jquery-maskedinput/jquery-maskedinput.js')}}"></script>
<script src="{{ asset('/public/admin/js/form-components.js')}}"></script>
<script src="{{ asset('/public/admin/vendors/tinymce/js/tinymce/tinymce.min.js')}}"></script>
<script src="{{ asset('/public/admin/vendors/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('/public/admin/js/ui-tabs-accordions-navs.js')}}"></script>

<script src="{{ asset('/public/admin/js/main.js') }}"></script>
<script src="{{ asset('/public/admin/js/holder.js') }}"></script>
<script src="{{ asset('/public/admin/js/functions.js') }}"></script>
<script>
    $('.wbx_submit_preview').click(function (e) {
        e.preventDefault();
        $('.wbx_info').each(function (i, e) {
            // var value = addslashes($(e).html());
            var value = $(e).html();
            var name = $(e).attr('name');
            $check = 1;
            // $('#wbx_change_info').append("<input type='hidden' name='" + name + "' value='" + value + "' />");
            $('#wbx_change_info').append('<textarea style="display: none" name="' + name + '">' + value + '</textarea>');
            $('#wbx_change_info').append('<input type=hidden value="' + $check + '" name="wbx_preview">');

        });
        $('#wbx_change_info').submit();
    });

    $('.wbx_submit_publish').click(function (e) {
        e.preventDefault();
        $('.wbx_info').each(function (i, e) {
            // var value = addslashes($(e).html());
            var value = $(e).html();
            var name = $(e).attr('name');
            $check = 1;
            // $('#wbx_change_info').append("<input type='hidden' name='" + name + "' value='" + value + "' />");
            $('#wbx_change_info').append('<textarea style="display: none" name="' + name + '">' + value + '</textarea>');
            $('#wbx_change_info').append('<input type=hidden value="' + $check + '" name="wbx_publish">');
        });
        $('#wbx_change_info').submit();
    });
    // for promotions header.
    function ClickToSave () {
            // alert('hello');
            // console.log(document.getElementById('textToBeSavedcontent1').innerHTML);
            $.post("headerUpdate",{
                _token :    '{{{ csrf_token() }}}',
                content : document.getElementById('textToBeSavedcontent1').innerHTML,
                page : 'home_promotions'
            },
            function(data,status){
                // alert("Status: " + status);
                document.getElementById('saved').style.display='block';
            });
    }
</script>
@endsection
