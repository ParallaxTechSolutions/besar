@extends('front/templateFront')

@section('content')
    <div class="room-single-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-full-width">
                    <div class="section-title-area text-center">
                        <h2 class="section-title">Login</h2>
                        <p class="section-title-dec">View your bookings and manage your details.</p>
                    </div><!--/.section-title-area-->
                </div><!--/.col-md-8-->
            </div><!--/.row-->
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="room-comments-area">
                        <div id="respond" class="comment-respond box-radius">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="comment-reply-title">Returning Partners</h4><!--/.comment-reply-title-->
                                </div><!--/.col-md-12-->
                            </div><!--/.row-->
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="partnerlogin" id="login-form" method="post" name="login-form" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <input type="hidden" name="redirect" value="dashboard" />
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if(Session::has('error'))
                                                    <div class="alert alert-danger">
                                                        <i class="fa fa-exclamation-triangle"></i> &nbsp; {{ Session::get('error') }}
                                                    </div>
                                                @endif
                                                @if(Session::has('success'))
                                                    <div class="alert alert-danger">
                                                        <i class="fa fa-exclamation-triangle"></i> &nbsp;{{ Session::get('success') }}
                                                    </div>
                                                @endif
                                                <p>If you have an account with us, please log in.</p>
                                            </div><!--/.col-md-12-->

                                            <div class="col-md-6 col-sm-6 padding-right">
                                                <p>
                                                    <input type="text" name="email" id="email" aria-required="true" placeholder="Email *" class="form-controllar">

                                                </p>
                                            </div><!--/.col-md-6-->
                                            <div class="col-md-6 col-sm-6 padding-right">
                                                <p>
                                                    <input type="password" name="password" id="email" aria-required="true" placeholder="Password *" class="form-controllar">

                                                </p>
                                            </div><!--/.col-md-6-->


                                            <div class="pull-left">
                                                <input type="submit" name="submit" value="Login"class="btn btn-default" />
                                            </div>
                                        </div><!--/.row-->
                                    </form><!--/#comment_form-->
                                </div><!--/.col-md-12-->
                            </div><!--/.row-->
                        </div><!--/.comment-respond-->
                    </div>
                </div><!--/.col-md-6-->

            </div><!--/.row-->

            <br/>

        </div><!--/.container-->
    </div><!--/.room-grid-area-->

@endsection
