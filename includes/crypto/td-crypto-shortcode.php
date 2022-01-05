<?php  defined('ABSPATH') OR exit('No direct script access allowed');
ini_set('allow_url_fopen',1);
if (!function_exists('fx_long_crypto_shortcode')):
function fx_long_crypto_shortcode(){

	echo '<p style="text-align:center; font-size:16px;font-weight:400;font-family:time new roman;"><span style="font-weight:700; color:#0B2F45; font-size:18px;">Crypto Currency Portfolio</span><br> Last Update : '.(date("d-m-y")).'</p>';
?>
<div class="table-responsive wprt_style_display">
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
				<th class="fx-table-header">P/L (in USD)</th>
				<th class="fx-table-header">P/L (in %)</th>
			</tr>
		</thead>
		<?php
		global $wpdb;
		$table_name = $wpdb->prefix . 'td_helper_crypto_table';
		
		$result = $wpdb->get_results("SELECT * FROM $table_name");
		
		foreach ($result as $print) {
		$name = $print->name;
		$action = $print->action;
		$price_entry = $print->price_entry;
		$stop_loss = $print->stop_loss;
		$price_target = $print->price_target;
		$day_in_market = $print->day_in_market;
		$position_size = $print->position_size;
		// Get data from API crypro currency rate
		// set API Endpoint and API key
		$endpoint = 'live';
		$access_key = '4999bb44f97fa970e5df16c4fafc0cdf';
		// Initialize CURL:
		$ch = curl_init('http://api.coinlayer.com/api/'.$endpoint.'?access_key='.$access_key.'');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Store the data:
		$json = curl_exec($ch);
		curl_close($ch);
		// Decode JSON response:
		$exchangeRates = json_decode($json, true);
		// example get value $exchangeRates['rates']['currency_name']
		$marketprice = $exchangeRates['rates'][$name];
		$marketprice = number_format($marketprice,4, '.', '');

		if ($action=='BUY') {

		$pnld = $marketprice - $price_entry;
		$pnlp=($pnld/$price_entry)*100;
		$pnlp=number_format($pnlp, 2);
		}
		elseif ($action=='SELL') {
		$pnld = $price_entry - $marketprice;
		$pnlp=($pnld/$price_entry)*100;
			$pnlp=number_format($pnlp, 2);
		}
		else{

			return;
		}
		$price_entry=number_format($price_entry, 4);
		$stop_loss=number_format($stop_loss, 4);
		$price_target=number_format($price_target, 4);
		$pnld=number_format($pnld, 2);
		
					echo	'<tbody class="fx-table-body">
						<tr class="fx-body">
								<th class="fx-table-col">'.$name.'USD</th>
								<th class="fx-table-col">'.$action.'</th>
								<th class="fx-table-col">'.$price_entry.'</th>
								<th class="fx-table-col">'.$marketprice.'</th>
								<th class="fx-table-col">'.$stop_loss.'</th>
								<th class="fx-table-col">'.$price_target.'</th>
								<th class="fx-table-col">'.$day_in_market.'</th>
								<th class="fx-table-col">'.$position_size.' $</th>
								<th class="fx-table-col">'.$pnld.'</th>
								<th class="fx-table-col">'.$pnlp.' % </th>
								
						</tr>
				</tbody>';
		}
		?>
	</table>
</div>
<?php
	}
add_shortcode('td-crypto-table', 'fx_long_crypto_shortcode');
endif;