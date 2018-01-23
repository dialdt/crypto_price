A simple PHP class to grab cryptocurrency information using the <a href="https://www.cryptocompare.com/api/#">CryptoCompare API</a>.  The class can be uses "as is" to grab current price, market capitalization and other market information in real time, or can be modified to grab more information.

<h1>Usage</h1>
Instantiate the <code>cryptoAll</code> class using:
</br>
</br>
<code>$crypto = new cryptoAll($fromccy, $currency);</code> where <code>$fromccy</code> and <code>$currency</code> are user-defined variables for currency from and currency to (e.g. XRP to GBP).

The following code creates a table showing the selected cryptocurrency price and market cap against the fiat currency:
</br>
</br>

```php
<div class="wrapper">

	<div class="container">
	
		<div class="row lead">
		
			<div class="col-md-12 text-center">

				<form method="GET">
	
				<span class="col-md-3 offset-md-1 text-center less-padding">

					<select class = "input" name="currencyto">
						<option value="GBP">GBP</option>
						<option value="USD">USD</option>
						<option value="EUR">EUR</option>
					</select>
				
				</span>
				
				<span class="col-md-3 text-center less-padding">
				
					<select class = "input" name="currencyfrom">
					
						<?php foreach($list->coins as $coin) : ?>
					
							<option value="<?php echo $coin->symbol?>"><?php echo '(' . $coin->symbol . ') ' . $coin->name ?></option>
					
						<?php endforeach; ?>
					
					</select>
				
				</span>
				
				<span class="col-md-3">

					<input type="submit" value="submit" class="btn btn-primary btn"/>
					
				</span>

				</form>
			
			</div>
		
		</div>
	
	

<?php

if(isset($_GET['currencyfrom']) && isset($_GET['currencyto'])) {

	//$currencies = implode(",",$_GET['currency']);
	$fromccy[] = $_GET['currencyfrom'];
	$currency = $_GET['currencyto'];
	

}

$crypto = new cryptoAll($fromccy, $currency); 

foreach($crypto->items as $item) : ?>

	<div class="row">

	<div class="col-md-7 offset-md-3 text-center">
	
		<table>
			<tr><th>Currency</th><th><?php echo $item->tosymbol; ?></th><th>Market Cap</th></tr>
			<tr><td><?php echo $item->fromsymbol; ?></td><td><?php echo $item->price; ?></td><td><?php echo $item->cap; ?></td></tr>
			<tr></tr>
			
		</table>
	
	</div>
	
	</div>	
	
		</div>
	
</div>


<?php endforeach; ?>
```

See example <a href="http://www.ishamjassat.com/projects/cryptoprice/index.php?currencyto=GBP&currencyfrom=BTC">HERE</a>

