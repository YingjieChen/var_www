
	<head>
		<meta http-equiv="Content-type" content="text/html;charset=utf-8"/>
		<script src="//cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
		<script src="//cdn.bootcss.com/react/15.4.2/react.min.js"></script>
		<script src="//cdn.bootcss.com/react/15.4.2/react-dom.min.js"></script>
		<script>
			console.log("Abandoned Orders ");	
			$(function(){
				$.ajax({
					url:"//u7-jewelry.myshopify.com/admin/orders.json",
					dataType:"json",
					success:function(data)
					{
						console.log(data);
					}
				});
			})
		</script>
	</head>
	<body>
		<?php
			require 'shopify.php';
			/* Define your APP`s key and secret*/
			$hmac		=	$_GET["hmac"];
			define('SHOPIFY_API_KEY','209dc5082b89bfcf56f27765113aa68c');
			define('SHOPIFY_SECRET',"e050b23ad3272922b5ef993f37644bec");
			$api_key	=	"209dc5082b89bfcf56f27765113aa68c";
			$shop		=	"u7-jewelry.myshopify.com";
			$sc = new ShopifyClient($shop, $_SESSION['token'], $api_key, $hmac);
			// Get all products
			$orders = $sc->call('GET', '/admin/orders.json', array());
			print_r($orders);
		?>
		<!--<?php
			$shop		=	$_GET["shop"];
			$api_key	=	"209dc5082b89bfcf56f27765113aa68c";
			$scope		=	"read_orders,write_orders";
		?>
		<a href="http://<?=$shop?>/admin/oauth/authorize?client_id=<?=$api_key?>&scope=<?=$scope?>&redirect_uri=https://api.u7jewelry.com/shopify/Abandoned_Orders/auth">
			Install the code
		</a>-->
	</body>
