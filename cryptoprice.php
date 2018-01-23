<?php

	class cryptoItem {
	
		var $fromsymbol;
		var $tosymbol;
		var $price;
		
		function __construct($fromsymbol, $tosymbol, $price, $change, $open, $high, $low/*, $close*/, $cap) {
		
			$this->price = $price;
			$this->fromsymbol = $fromsymbol;
			$this->tosymbol = $tosymbol;
			$this->change = $change;
			$this->open = $open;
			$this->high = $high;
			$this->low = $low;
			$this->cap = $cap;
			
		}
	
	};
	
	//list coins for future use
	class coinList {
	
		function __construct($symbol, $name) {
		
			$this->symbol = $symbol;
			$this->name = $name;
		
		}
	
	};

	class cryptoAll {
	
		var $fromccy;
		var $toccy;
		var $items;
		var $coins;
		var $number;
		
		function __construct(Array $fromccy, $toccy) {
		
			$this->fromccy = $fromccy;
			$this->toccy = $toccy;
			$this->items = $this->get_price();
			$coins = $this->get_list();
			usort($coins, Array($this, "crypto_sort"));
			$this->coins = $coins;
				
		}
		
		function get_price() {
		
			$ret = Array();
			$url = fetch_url("https://min-api.cryptocompare.com/data/pricemultifull?fsyms=" . implode(",",$this->fromccy) . "&tsyms=" . $this->toccy);
			$item = json_decode($url);
			$toccy = $this->toccy;
						
			if(isset($item->RAW)) {
			
				foreach($item->RAW as $data) {

						$data_item = $data->$toccy;
						$price = $data_item->PRICE;
						$fromsymbol = $data_item->FROMSYMBOL;
						$tosymbol = $data_item->TOSYMBOL;
						$change = $data_item->CHANGEPCT24HOUR;
						$open = $data_item->OPEN24HOUR;
						$high = $data_item->HIGH24HOUR;
						$low = $data_item->LOW24HOUR;
						$cap = $data_item->MKTCAP;
						
						// instantiate class...
						$ret[] = new cryptoItem($fromsymbol, $tosymbol, $price, $change, $open, $high, $low/*, $close*/, $cap);
												
					}
					
				}
					
		return $ret;

				}
	
		function get_list() {
		
			$ret = Array();
			$url = fetch_url('https://www.cryptocompare.com/api/data/coinlist/');
			$item = json_decode($url);
			$i = 0;

			foreach($item->Data as $data) {
			
				$symbol = str_replace("*","",$data->Symbol);
				$name = $data->CoinName;
				$ret[] = new coinList($symbol, $name);
			
			}
			
			return $ret;
		}
		
		function crypto_sort($sort1, $sort2) {
			
			$symbol1 = str_replace("*","",$sort1->symbol);
			$symbol2 = str_replace("*","",$sort2->symbol);
			if ($symbol1 == $symbol2) return 0;
			return ($symbol1 > $symbol2) ? 1 : -1;
		
		}
		
	}
	
	function fetch_url($url) {
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$json = curl_exec($ch);
		curl_close($ch);
		return $json;
		
	}

	$list = new cryptoAll(array(null), null);

?>
