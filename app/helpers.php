<?php
 function reverseCalculation($totalBill,$TaxRate){
    return $totalBill/(1+intval($TaxRate[0]->rate)/100);
}
?>
