<div id="room-amenities" class="tab-pane fade {{ (($tab) && ($tab=='room-amenities'))?'in active':'' }}">

    <form action="#" method="post" onsubmit="return gliss.rooms.saveAmenities(this, event, '{{$productDetails->id}}')">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    
        <div class="portlet">

            <div class="portlet-header">
                <div class="alert alert-success alert-dismissable amenities" style="display:none">
                    <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
                    <i class="fa fa-check-circle"></i> <strong>Success!</strong>
                    <p>The parameters have been successfully saved</p>
                </div>
                <div class="caption">Room Amenities</div>
                <div class="clearfix"></div>
                <p class="margin-top-10px"></p>
            </div>

            <div class="portlet-body">
                <div class="room-service-area clearfix">
					
                    <div class="col-md-6">

                    <!--<div class="form-group">
                        <input type="checkbox" name="r_size" id="r-size" @if(isset($amenities->r_size)) checked @endif>
                        <label for="r-size" class="control-label"><i class="fa fa-home"></i>Room Size
                            <input type="number" name="r_size_ft" value="{{$amenities->r_size_ft or ''}}" style="width: 50px;"> FT<sup>2</sup></label>
                    </div>-->
                    <div class="form-group">
                        <input type="checkbox" name="fridge" id="fridge" @if(isset($amenities->fridge)) checked @endif>
                        <label for="fridge" class="control-label"><i class="fa fa-angle-double-right"></i> Mini fridge</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="singledoorfridge" id="singledoorfridge" @if(isset($amenities->singledoorfridge)) checked @endif>
                        <label for="singledoorfridge" class="control-label"><i class="fa fa-angle-double-right"></i> Single door fridge</label>
                    </div> 
                    <div class="form-group">
                        <input type="checkbox" name="twodoorfridge" id="twodoorfridge" @if(isset($amenities->twodoorfridge)) checked @endif>
                        <label for="twodoorfridge" class="control-label"><i class="fa fa-angle-double-right"></i> 2 door fridge</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="minibar" id="minibar" @if(isset($amenities->minibar)) checked @endif>
                        <label for="minibar" class="control-label"><i class="fa fa-glass"></i> Mini-bar</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="wifi" id="wifi" @if(isset($amenities->wifi)) checked @endif>
                        <label for="wifi" class="control-label"><i class="fa fa-wifi"></i> Free wifi</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="tv" id="tv" @if(isset($amenities->tv)) checked @endif>
                        <label for="tv" class="control-label"><i class="fa fa-television"></i> 32" Flat screen TV</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="inchtv" id="inchtv" @if(isset($amenities->inchtv)) checked @endif>
                        <label for="inchtv" class="control-label"><i class="fa fa-television"></i> 42" Flat screen TV</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="selectedastro" id="selectedastro" @if(isset($amenities->selectedastro)) checked @endif>
                        <label for="selectedastro" class="control-label"><i class="fa fa-list-ul"></i> Selected Astro channels</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="astro" id="astro" @if(isset($amenities->astro)) checked @endif>
                        <label for="astro" class="control-label"><i class="fa fa-list-ul"></i> Astro channels</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="coffee" id="coffee" @if(isset($amenities->coffee)) checked @endif>
                        <label for="coffee" class="control-label"><i class="fa fa-coffee"></i> Coffee making facilities</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="coffeetable" id="coffeetable" @if(isset($amenities->coffeetable)) checked @endif>
                        <label for="coffeetable" class="control-label"><i class="fa fa-angle-double-right"></i> Coffee table</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="diningtable" id="diningtable" @if(isset($amenities->diningtable)) checked @endif>
                        <label for="diningtable" class="control-label"><i class="fa fa-angle-double-right"></i> Dining table for 6</label>
                    </div>
                    
                    <hr>
                    
                    <!-- ritz garden original amenities -->
                    <div class="form-group">
                        <input type="checkbox" name="aircon" id="aircon" @if(isset($amenities->aircon)) checked @endif>
                        <label for="aircon" class="control-label"><i class="fa fa-thermometer"></i> Individually controllable Air-conditioning</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="water" id="water" @if(isset($amenities->water)) checked @endif>
                        <label for="water" class="control-label"><i class="fa fa-check-circle-o"></i> Bottled drinking water</label>
                    </div>

                    <div class="form-group">
                        <input type="checkbox" name="safe" id="safe" @if(isset($amenities->safe)) checked @endif>
                        <label for="safe" class="control-label"><i class="fa fa-lock"></i> In room electronic safe</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="hairdryer" id="hairdryer" @if(isset($amenities->hairdryer)) checked @endif>
                        <label for="hairdryer" class="control-label"><i class="fa fa-check-circle-o"></i> Built-in hairdryer</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="phone" id="phone" @if(isset($amenities->phone)) checked @endif>
                        <label for="phone" class="control-label"><i class="fa fa-fax"></i> IDD phone</label>
                    </div>
                    
                    <div class="form-group">
                        <input type="checkbox" name="kiblat" id="kiblat" @if(isset($amenities->kiblat)) checked @endif>
                        <label for="kiblat" class="control-label"><i class="fa fa-arrows"></i> Kiblat directional sign</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="laundry" id="laundry" @if(isset($amenities->laundry)) checked @endif>
                        <label for="laundry" class="control-label"><i class="fa fa-check-circle-o"></i> Laundry service</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="ironboard" id="ironboard" @if(isset($amenities->ironboard)) checked @endif>
                        <label for="ironboard" class="control-label"><i class="fa fa-check-circle-o"></i> Ironing board</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="pool" id="pool" @if(isset($amenities->pool)) checked @endif>
                        <label for="pool" class="control-label"><i class="fa fa-check-circle-o"></i> Private swimming pool</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="sauna" id="sauna" @if(isset($amenities->sauna)) checked @endif>
                        <label for="sauna" class="control-label"><i class="fa fa-check-circle-o"></i> Steam/sauna bath</label>
                    </div>
                    <!-- end ritz garden original amenities -->
                    
				</div><!-- end col-md-6-->
                
                <div class="col-md-6">

                	<div class="form-group">
                        <input type="checkbox" name="shower" id="shower" @if(isset($amenities->shower)) checked @endif>
                        <label for="shower" class="control-label"><i class="fa fa-shower"></i> Standing shower</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="bathroom" id="bathroom" @if(isset($amenities->bathroom)) checked @endif>
                        <label for="bathroom" class="control-label"><i class="fa fa-bath"></i> Bathroom (2 units)</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="bathtub" id="bathtub" @if(isset($amenities->bathtub)) checked @endif>
                        <label for="bathtub" class="control-label"><i class="fa fa-bath"></i> Bathtub</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="jacuzzi" id="jacuzzi" @if(isset($amenities->jacuzzi)) checked @endif>
                        <label for="jacuzzi" class="control-label"><i class="fa fa-angle-double-right"></i> Jacuzzi</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="pantry" id="pantry" @if(isset($amenities->pantry)) checked @endif>
                        <label for="pantry" class="control-label"><i class="fa fa-angle-double-right"></i> Pantry area</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="livingroom" id="livingroom" @if(isset($amenities->livingroom)) checked @endif>
                        <label for="livingroom" class="control-label"><i class="fa fa-angle-double-right"></i> Living room with 2 seater sofa</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="twosinglesofa" id="twosinglesofa" @if(isset($amenities->twosinglesofa)) checked @endif>
                        <label for="twosinglesofa" class="control-label"><i class="fa fa-angle-double-right"></i> 2 single sofa</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="largesofa" id="largesofa" @if(isset($amenities->largesofa)) checked @endif>
                        <label for="largesofa" class="control-label"><i class="fa fa-angle-double-right"></i> Large sofa</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="woodenfloor" id="woodenfloor" @if(isset($amenities->woodenfloor)) checked @endif>
                        <label for="woodenfloor" class="control-label"><i class="fa fa-angle-double-right"></i> Wooden floor</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="carpetedfloor" id="carpetedfloor" @if(isset($amenities->carpetedfloor)) checked @endif>
                        <label for="carpetedfloor" class="control-label"><i class="fa fa-angle-double-right"></i> Carpeted floor</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="balcony" id="balcony" @if(isset($amenities->balcony)) checked @endif>
                        <label for="balcony" class="control-label"><i class="fa fa-angle-double-right"></i> Spacious balcony</label>
                    </div>
                    
                    <hr>
                    <!-- ritz garden original amenities -->
                    <div class="form-group">
                        <input type="checkbox" name="kitchen" id="kitchen" @if(isset($amenities->kitchen)) checked @endif>
                        <label for="kitchen" class="control-label"><i class="fa fa-free-code-camp"></i> Kitchen facilities</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="sitting" id="sitting" @if(isset($amenities->sitting)) checked @endif>
                        <label for="sitting" class="control-label"><i class="fa fa-check-circle-o"></i> Comfortable sitting room with sofa &amp; dining table</label>
                    </div>
                    <!-- end ritz garden original amenities -->
                    
                	
                </div><!-- end col-md-6-->
                
                </div>

            </div>
            <!-- end portlet body -->

        </div>
        <!-- end portlet -->

        <div class="form-group">
            <button type="submit" class="btn btn-success">Save</button>&nbsp;
        </div>

    </form>

</div>