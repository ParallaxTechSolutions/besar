
<html>
    <head>
        <title>Please Wait...</title>
    </head>

    <body>
        Please Wait...
        <form id="ePayment" name="frmPayment" action="https://pay.e-ghl.com/IPGSG/Payment.aspx" method="post" enctype="multipart/form-data">
            {{--<input type="hidden" name="_token" value="{{ $token }}" />
			 <input type="hidden" name="MerchantCode" value="sit12345">  <!--demo_mode--> 
			 <input type="text" name="MerchantCode" value="sit12345" />   --}}<!--live_mode-->
            {{-- <input type="text" name="PaymentId" value="" />  --}}{{-- {{ $orderInfo->id }} --}}
  {{--           <input type="text" name="RefNo" value="{{ $orderInfo->order_id }}" />
            <input type="text" name="Amount" value="{{ number_format($total_amount, 2) }}" />
            <input type="text" name="Currency" value="MYR" />
            <input type="text" name="ProdDesc" value="Order ID {{ $orderInfo->order_id }}" />
            <input type="text" name="UserName" value="{{ $orderInfo->billing_first_name . ' ' . $orderInfo->billing_last_name }}" />
            <input type="text" name="UserEmail" value="{{ $orderInfo->billing_email }}" />
            <input type="text" name="UserContact" value="{{ $orderInfo->billing_telephone }}" />
            <input type="text" name="Remark" value="Order ID {{ $orderInfo->order_id }}" />
            <input type="text" name="Lang" value="UTF-8" />
            <input type="text" name="Signature" value="{{ $sign }}" />
            <input type="text" name="ResponseURL" value="{{ url('checkout/successPayment') }}" /> --}}
         {{--    <input type="text" name="TransactionType" value="SALE">
            <input type="text" name="PymtMethod" value="ANY">
            <input type="text" name="ServiceID" value="sit">
            <input type="text" name="PaymentID" value="a23A">
            <input type="text" name="OrderNumber" value="{{$orderInfo->order_id }}">
            <input type="text" name="PaymentDesc" value="Booking No: {{$orderInfo->order_id }}, Sector: KUL-BKI, First Flight Date: 26 Sep 2012">
            <input type="text" name="MerchantReturnURL" value="{{ url('checkout/successPayment') }}">
            <input type="text" name="MerchantCallbackURL" value="{{ url('checkout/successPayment') }}">
            <input type="text" name="Amount" value="228.00">
            <input type="text" name="CurrencyCode" value="MYR">
            <input type="text" name="CustIP" value="192.168.2.34">
            <input type="text" name="CustName" value="maSad">
            <input type="text" name="CustEmail" value="Jasona@gmail.com">
            <input type="text" name="CustPhone" value="60121235698">
            <input type="text" name="HashValue" value="">
            <input type="text" name="LanguageCode" value="en">
            <input type="text" name="PageTimeout" value="780"> --}}
           {{--  <input type="text" name="TransactionType" value="SALE">
            <input type="text" name="PymtMethod" value="ANY">
            <input type="text" name="ServiceID" value="sit">
            
            <input type="text" name="OrderNumber" value="{{$orderInfo->order_id }}">
            <input type="text" name="PaymentDesc" value="Booking No: {{$orderInfo->order_id }}, Sector: KUL-BKI, First Flight Date: 26 Sep 2012">
            <input type="text" name="MerchantReturnURL" value="{{ url('checkout/successPayment') }}">
            <input type="text" name="Amount" value="228.00">
            <input type="text" name="CurrencyCode" value="MYR">
            <input type="text" name="HashValue" value="{{$hashValue}}">
            <input type="text" name="CustIP" value="192.168.2.34">
            <input type="text" name="CustName" value="maSad">
            <input type="text" name="CustEmail" value="Jasona@gmail.com">
            <input type="text" name="CustPhone" value="60121235698">
            <input name="PageTimeout" value="300" type="text"> --}}
           {{--  <input type="text" name="Cardholder" value="TESTER"> --}}
            {{-- <input type="text" name="CardNo" value="4444333322221111">
            <input name="PageTimeout" value="300" type="text">
            <input type="text" name="CardExp" value="202012">
            <input type="text" name="CardCVV2" value="1234">
            <input type="text" name="ECI" value="05">
            <input type="text" name="CAVV" value="AAABA2dGFgAAAAABEUYWAAAAAAA=">
            <input type="text" name="3DXID" value="ejU4ZlB0Q2NmTUpQdndtdGxHWDA="> --}}
            <p>
                <strong>eGHL Payments </strong>
            </p>

            <input name="TransactionType" value="SALE" type="hidden">
            <input name="PymtMethod" value="ANY" type="hidden">
            <input name="ServiceID" value="<?php echo $merchantId; ?>" type="hidden">
            <input name="PaymentID" value="<?php echo $orderInfo->order_id ?>" type="hidden">
            <input name="OrderNumber" value="<?php echo $orderInfo->id?>" type="hidden">
            <input name="PaymentDesc" value="Booking No: {{$orderInfo->order_id}}" type="hidden">
            <input name="MerchantReturnURL" value="<?php echo url('/checkout/successPaymenteGHL');?>" type="hidden">
            <input name="MerchantCallbackURL" value="<?php echo url('checkout/merchantCallbackURLeGHL') ?>" type="hidden">
            <input name="Amount" value="<?php echo str_replace(',','',number_format($total_amount, 2)) ?>" type="hidden">
            <input name="CurrencyCode" value="MYR" type="hidden">
            <input name="CustIP" value="{{$orderInfo->ip_address}}" type="hidden">
            <input name="CustName" value="{{$orderInfo->billing_first_name . '_' . $orderInfo->billing_last_name}}" type="hidden">
            <input name="CustEmail" value="{{$orderInfo->billing_email}}" type="hidden">
            <input name="CustPhone" value="{{$orderInfo->billing_telephone}}" type="hidden">
            <input name="PageTimeout" value="600" type="hidden">
            <input name="HashValue" value="{{$hashValue}}" type="hidden">
        </form>
        <script>
        setTimeout(function(){
            document.getElementById('ePayment').submit();
        }, 3000);
        </script>
    </body>
</html>
