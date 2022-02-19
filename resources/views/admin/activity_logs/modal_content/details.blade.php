<form action="#" class="form-horizontal">

    <h3 class="block-heading">General</h3>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="inputFirstName" class="col-md-4 control-label">Date &amp; Time:</label>
                <div class="col-md-8">
                    <p class="form-control-static">{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}<br>{{ \Carbon\Carbon::parse($activity->created_at)->format('dS M, Y H:i') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="inputPhone" class="col-md-4 control-label">IP:</label>
                <div class="col-md-8">
                    <p class="form-control-static">{{ $activity->ip }}</p>
                </div>
            </div>
        </div>

    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="inputLastName" class="col-md-4 control-label">Name:</label>
                <div class="col-md-8">
                    <p class="form-control-static">{{ isset($activity->user['first_name']) ? $activity->user['first_name'].' '.$activity->user['last_name'] :  $activity->client['first_name'].' '.$activity->client['last_name'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="inputLastName" class="col-md-4 control-label">Type:</label>
                <div class="col-md-8">
                    <p class="form-control-static">{{ ($activity->user['role'][0]['role'] == 'admin') ? ucfirst($activity->user['role'][0]['role']) : 'Client' }}</p>
                </div>
            </div>
        </div>



    </div>
    <!-- end row -->

    <h3 class="block-heading">Action &amp; Activities</h3>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="inputAddress1" class="col-md-4 control-label">Action:</label>
                <div class="col-md-8">
                    <p class="form-control-static">{{ $activity->action }}</p>
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2 control-label">Activity Details:</label>
                <div class="col-md-10">

                    <table class="table table-border-dashed margin-top-10px">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Description</th>
                            <th>Details</th>
                            <th>Date / Time</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td>1</td>
                            <td>{{ $activity->activity }}</td>
                            <td>{{ $activity->details }}</td>
                            <td>{{ \Carbon\Carbon::parse($activity->created_at)->format('dS M, Y') }} <br>{{ \Carbon\Carbon::parse($activity->created_at)->format('H:i A') }}</td>
                        </tr>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <!-- End action/activities -->

    <div class="form-actions">
        <div class="col-md-offset-5 col-md-8"> <a href="#" data-dismiss="modal" class="btn btn-green">Close &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
    </div>
</form>