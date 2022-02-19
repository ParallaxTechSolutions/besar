<form action="#" class="form-horizontal">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="inputLastName" class="col-md-4 control-label">Name:</label>
                <div class="col-md-8">
                    <p class="form-control-static">{{ $notifications->name }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="inputLastName" class="col-md-4 control-label">Status:</label>
                <div class="col-md-8">
                    <p class="form-control-static">
					@if($notifications->status) 
						On
					@else
						Off
					@endif
					</p>
                </div>
            </div>
        </div>
		
		<div class="col-md-6">
            <div class="form-group">
                <label for="inputLastName" class="col-md-4 control-label">Actions:</label>
                <div class="col-md-8">
                    <p class="form-control-static">
					{{ str_replace(',', ', ', $notifications->actions) }}
					</p>
                </div>
            </div>
        </div>
		
		<div class="col-md-6">
            <div class="form-group">
                <label for="inputLastName" class="col-md-4 control-label">Emails:</label>
                <div class="col-md-8">
                    <p class="form-control-static">
					{{ str_replace(',', ', ', $notifications->emails) }}
					</p>
                </div>
            </div>
        </div>
		
    </div>
    <!-- end row -->
    <!-- End action/activities -->

    <div class="form-actions">
        <div class="col-md-offset-5 col-md-8"> <a href="#" data-dismiss="modal" class="btn btn-green">Close &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
    </div>
</form>