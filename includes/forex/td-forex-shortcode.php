<?php  defined('ABSPATH') OR exit('No direct script access allowed');
if (!function_exists('td_helper_forex_shortcode')):
function td_helper_forex_shortcode() {
global $wpdb;
$table_name = $wpdb->prefix . 'td_helper_forex_table';
echo '<p style="text-align:center; font-size:16px;font-weight:400;font-family:time new roman;"><span style="font-weight:700; color:#0B2F45; font-size:18px;">Forex Trading Portfolio</span><br> Last Update : '.(date("d-m-y")).'</p>';
?>
<table class="table fx-table">
  <thead class="fx-table-head">
    <tr class="fx-header">
      <th class="fx-table-header">Currency</th>
      <th class="fx-table-header">Action</th>
      <th class="fx-table-header">Entry Price</th>
      <th class="fx-table-header">Market price</th>
      <th class="fx-table-header">Stop Loss</th>
      <th class="fx-table-header">Target Price</th>
      <th class="fx-table-header">Days in Market</th>
      <th class="fx-table-header">Position Size</th>
      <th class="fx-table-header">P/L (in Pips)</th>
      <th class="fx-table-header">P/L (in %)</th>
    </tr>
  </thead>
  <?php
  if (!function_exists('td_forex_convertCurrencyn')):
  function td_forex_convertCurrencyn($amount,$from_currency,$to_currency){
  $from_Currency = urlencode($from_currency);
  $to_Currency = urlencode($to_currency);
  $query =  "{$from_Currency}_{$to_Currency}";
  // change to the free/paid URL if you're using the free version
  $json = @file_get_contents("https://api.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey=94d136465ceb45abba2d8a13f7588ee3");
  if ($json==true) {
  
  $obj = json_decode($json, true);
  $val = floatval($obj["$query"]);
  $total = $val * $amount;
  return number_format($total, 4, '.', '');
  }
  else{
  $json = @file_get_contents("https://free.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey=06d3f637bb1e9a8401b9");
  $obj = json_decode($json, true);
  $val = floatval($obj["$query"]);
  $total = $val * $amount;
  return number_format($total, 4, '.', '');
  }
  }
  endif;
  $result = $wpdb->get_results("SELECT * FROM $table_name");
  
  foreach ($result as $print) {
  
  $price_entry = $print->price_entry;
  $name = $print->name;
  $action = $print->action;
  $stop_loss = $print->stop_loss;
  $price_target = $print->price_target;
  $day_in_market = $print->day_in_market;
  $position_size = $print->position_size;
  if ($name=='CADUSD') {
  
  $market_price=td_forex_convertCurrencyn(1, 'CAD','USD');
  
  }
  elseif ($name=='USDCAD') {
  $market_price=td_forex_convertCurrencyn(1, 'USD','CAD');
  }
  elseif ($name=='USDCHF') {
  $market_price=td_forex_convertCurrencyn(1, 'USD','CHF');
  }
  elseif ($name=='NZDUSD') {
  
  $market_price=td_forex_convertCurrencyn(1, 'NZD','USD');
  }
  elseif ($name=='USDJPY') {
  
  $market_price=td_forex_convertCurrencyn(1, 'USD','JPY');
  }
  elseif ($name=='EURUSD') {
  
  $market_price=td_forex_convertCurrencyn(1, 'EUR','USD');
  }
  elseif ($name=='USDEUR') {
  
  $market_price=td_forex_convertCurrencyn(1, 'USD','EUR');
  }
  elseif ($name=='USDCHF') {
  
  $market_price=td_forex_convertCurrencyn(1, 'USD','CHF');
  }
  elseif ($name=='GBPUSD') {
  
  $market_price=td_forex_convertCurrencyn(1, 'GBP','USD');
  }
  elseif ($name=='CADJPY') {
  
  $market_price=td_forex_convertCurrencyn(1, 'CAD','JPY');
  }
  elseif ($name=='AUDUSD') {
  
  $market_price=td_forex_convertCurrencyn(1, 'AUD','USD');
  }
  elseif ($name=='EURJPY') {
  
  $market_price=td_forex_convertCurrencyn(1, 'EUR','JPY');
  }
  elseif ($name=='NZDJPY') {
  
  $market_price=td_forex_convertCurrencyn(1, 'NZD','JPY');
  }
  elseif ($name=='AUDJPY') {
  
  $market_price=td_forex_convertCurrencyn(1, 'AUD','JPY');
  }
  elseif ($name=='GBPJPY') {
  
  $market_price=td_forex_convertCurrencyn(1, 'GBP','JPY');
  }
  elseif ($name=='CHFJPY') {
  
  $market_price=td_forex_convertCurrencyn(1, 'CHF','JPY');
  }
  elseif ($name=='EURGBP') {
  
  $market_price=td_forex_convertCurrencyn(1, 'EUR','GBP');
  }
  elseif ($name=='EURCHF') {
  
  $market_price=td_forex_convertCurrencyn(1, 'EUR','CHF');
  }
  elseif ($name=='GBPCHF') {
  
  $market_price=td_forex_convertCurrencyn(1, 'GBP','CHF');
  }
  elseif ($name=='AUDCAD') {
  
  $market_price=td_forex_convertCurrencyn(1, 'AUD','CAD');
  }
  elseif ($name=='NZDCAD') {
  
  $market_price=td_forex_convertCurrencyn(1, 'NZD','CAD');
  }
  elseif ($name=='CADCHF') {
  
  $market_price=td_forex_convertCurrencyn(1, 'CAD','CHF');
  }
  elseif ($name=='GBPCAD') {
  
  $market_price=td_forex_convertCurrencyn(1, 'GBP','CAD');
  }
  elseif ($name=='CADCHF') {
  
  $market_price=td_forex_convertCurrencyn(1, 'CAD','CHF');
  }
  elseif ($name=='CHFNZD') {
  
  $market_price=td_forex_convertCurrencyn(1, 'CHF','NZD');
  }
  elseif ($name=='NZDCHF') {
  
  $market_price=td_forex_convertCurrencyn(1, 'NZD','CHF');
  }
  elseif ($name=='EURCAD') {
  
  $market_price=td_forex_convertCurrencyn(1, 'EUR','CAD');
  }
  elseif ($name=='EURAUD') {
  
  $market_price=td_forex_convertCurrencyn(1, 'EUR','AUD');
  }
  elseif ($name=='EURNZD') {
  
  $market_price=td_forex_convertCurrencyn(1, 'EUR','NZD');
  }
  elseif ($name=='GBPAUD') {
  
  $market_price=td_forex_convertCurrencyn(1, 'GBP','AUD');
  }
  elseif ($name=='GBPNZD') {
  
  $market_price=td_forex_convertCurrencyn(1, 'GBP','NZD');
  }
  elseif ($name=='AUDNZD') {
  
  $market_price=td_forex_convertCurrencyn(1, 'AUD','NZD');
  }
  elseif ($name=='AUDCHF') {
  
  $market_price=td_forex_convertCurrencyn(1, 'AUD','CHF');
  }
  
  else{
  $market_price= 0.00;
  }
  $pnl=0;
  
  if ($action=='BUY') {
  
  switch($name)
  {
  case 'CADJPY';
  case 'CHFJPY';
  case 'GBPJPY';
  case 'USDJPY';
  case 'NZDJPY';
  case 'AUDJPY';
  case 'EURJPY';
  $pnld=$market_price-$price_entry;
  $pnl=$pnld*1;
  $pnlk=$pnld*100;
  $market_price= number_format((float)$market_price, 2, '.', '');
  $pnlperd=$pnlk/$price_entry;
  $price_entry= number_format((float)$price_entry, 2, '.', '');
  $price_target= number_format((float)$price_target, 2, '.', '');
  $stop_loss= number_format((float)$stop_loss, 2, '.', '');
  break;
  default;
  $pnld=$market_price-$price_entry;
  $pnl=$pnld*10000;
  $pnlk=$pnld*10000;
  $pnlperd=($pnl*$price_entry)/100;
  break;
  }
  
  }
  elseif ($action=='SELL') {
  switch($name)
  {
  case 'CADJPY';
  case 'CHFJPY';
  case 'GBPJPY';
  case 'USDJPY';
  case 'NZDJPY';
  case 'AUDJPY';
  case 'EURJPY';
  $pnld= $price_entry-$market_price;
  $pnl=$pnld*1;
  $pnlk=$pnld*100;
  $market_price= number_format((float)$market_price, 2, '.', '');
  
  $price_entry= number_format((float)$price_entry, 2, '.', '');
  $pnlperd=$pnlk/$price_entry;
  $price_target= number_format((float)$price_target, 2, '.', '');
  $stop_loss= number_format((float)$stop_loss, 2, '.', '');
  break;
  default;
  $pnld= $price_entry-$market_price;
  $pnl=$pnld*10000;
  $pnlk=$pnld*10000;
  $pnlperd=($pnl*$price_entry)/100;
  break;
  }
  
  
  }
  
  else{
  echo "Wrong Entry";
  }
  //pnl % logic
  $pnlk = round($pnlk);
  
  
  $pnlperm= number_format((float)$pnlperd, 2, '.', '');
  
  $pnlper= $pnlperm . " %";
  
  $position_sizen = $position_size . " $";
  echo '
  <tbody class="fx-table-body">
    <tr class="fx-body">
      <td class="fx-table-col">'.$name.'</td>
      <td class="fx-table-col">'.$action.'</td>
      <td class="fx-table-col">'.$price_entry.'</td>
      <td class="fx-table-col">'.$market_price.'</td>
      <td class="fx-table-col">'.$stop_loss.'</td>
      <td class="fx-table-col">'.$price_target.'</td>
      <td class="fx-table-col">'.$day_in_market.'</td>
      <td class="fx-table-col">'.$position_sizen.'</td>
      <td class="fx-table-col">'.$pnlk.'</td>
      
      <td class="fx-table-col">'.$pnlper.'</td>
      
    </tr>
    
    
  </tbody>
  ';
  }?>
</table>
<?php
}
add_shortcode('td-forex-table', 'td_helper_forex_shortcode');
endif;