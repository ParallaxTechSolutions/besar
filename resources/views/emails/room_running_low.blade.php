<div style="padding:0px; margin:0px;">
    <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" style="padding:10px; background:#fff;">
        <tr>
            <td width="550" align="left" valign="top" style="border-bottom:1px solid #ccc;"><img src="{{ asset('/public/front/images/index/logo.png') }}" /></td>
        </tr>
	</table>
</div>

<h3 style="padding:0px; margin:0px; color:#444645; font-size:32px;">Following rooms are running low:</h3>

<div style="padding:0px; margin:0px;">
<?php
foreach ($productArr as $date => $roomsArr) {
?>
<h1><?php echo date('Y-m-d', strtotime($date));?></h1>
  <table class="table checkout-table" style='border: 1px solid #e0e0e0;margin-bottom: 0;width: 100%;max-width: 100%;margin: 0 0 1.5em;background-color: transparent;border-spacing: 0;border-collapse: collapse;display: table;background-color: white; font-family: "Poppins", sans-serif;font-size: 15px;font-weight: 400;line-height: 1.45em;color: #787878;-webkit-font-smoothing: antialiased;'>
      <thead>
          <tr>
              <th class="table-title" style='font: 700 16px/22px "Montserrat", sans-serif;color: #4d4d4d;font-weight: 700;text-transform: uppercase;padding: 15px;border-color: transparent;border-right: 1px solid #e0e0e0;background: #fafafa; border-bottom: 1px solid #e0e0e0;text-align: center;vertical-align: bottom;border-collapse: collapse;'>Types</th>
              <th class="table-title" style='font: 700 16px/22px "Montserrat", sans-serif;color: #4d4d4d;font-weight: 700;text-transform: uppercase;padding: 15px;border-color: transparent;border-right: 1px solid #e0e0e0;background: #fafafa; border-bottom: 1px solid #e0e0e0;text-align: center;vertical-align: bottom;border-collapse: collapse;'>Room Code</th>
              <th class="table-title" style='font: 700 16px/22px "Montserrat", sans-serif;color: #4d4d4d;font-weight: 700;text-transform: uppercase;padding: 15px;border-color: transparent;border-right: 1px solid #e0e0e0;background: #fafafa; border-bottom: 1px solid #e0e0e0;text-align: center;vertical-align: bottom;border-collapse: collapse;'>Booked stock quantity</th>
			  <th class="table-title" style='font: 700 16px/22px "Montserrat", sans-serif;color: #4d4d4d;font-weight: 700;text-transform: uppercase;padding: 15px;border-color: transparent;border-right: 1px solid #e0e0e0;background: #fafafa; border-bottom: 1px solid #e0e0e0;text-align: center;vertical-align: bottom;border-collapse: collapse;'>Low level in stock</th>
          </tr>
      </thead>
      <tbody>
        <?php
         // cart info
         $total_amount = 0;
         foreach ($roomsArr as $room_id => $value) {
             $img = asset('/public/admin/products/medium/'.$value['thumbnail_image_1']);
             ?> 
             <tr>
                 <td class="item-name-col" style='text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;width: 390px;'>
                  <div style="float:left">
                     <figure>
                         <a href="#room-details"><img src="{{ $img }}" alt="Deluxe Room" class="img-responsive" style="display: inline-block; max-width: 100%; height: auto; width: 100px;height:87px; margin: auto; vertical-align: middle; border: 0;"></a>
                     </figure>
                   </div>
                     <div style="float:left; margin-left: 10px; margin-top: -5px;">
                     <header style='font-size: 18px;color: #333;line-height: 18px;font-weight: 600;margin-bottom: 15px;text-align: left;'>
                         <a href="{{url('rooms-suites/show')}}/<?= $value['id'] ?>" target="_blank" style="color: #78A994;"><?= $value['type'] ?></a>
                     </header>
                     <ul style="font-size:15px; margin-top:0px;  margin-left:-20px;">
                         <li><b>BED:</b> <span style="text-transform: lowercase;"><?= $value['bed'] ?> </span></li>
                         <li><b>GUEST:</b> <span style="text-transform: lowercase;"><?= $value['guest'] ?></span></li>
                         <li><b>MEAL:</b> <span style="text-transform: lowercase;"><?= $value['meal'] ?></span></li>
                     </ul>
                    </div>
                 </td>
                 <td class="item-price-col" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; font-size:15px; text-align:center;'><?= $value['room_code'] ?></td>
					<td style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; font-size:15px; text-align:center;'><?= $value['booked_stock_quantity'] ?></td>
					<td style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; font-size:15px; text-align:center;'><?= $value['low_level'] ?></td>
             </tr>
         <?php } ?>
      </tbody>
  </table>
  <?php } ?>
</div>