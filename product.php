  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script>
function moneyFormat(value)
{
	return value.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}
</script>

<?php
session_start();
	global $wio_config;
	$request = new SimpleApiClient();
	$request->endpoint($wio_config["global"]["endpoint"]."equipment/".$_REQUEST["product"]);

	$request->requestTypeGet()->addHeader("X-API-Auth: ".$wio_config["global"]["apikey"]);;

	$results = $request->perform();
	//echo '<pre>';
	//var_dump($results);
	
	//echo '</pre>';
global $wio_config;
if($results['active'] != 0){

	/*echo $results["price"];
	echo '<br />';
	echo $results["price"]*0.2/100;
	echo '<br />';*/
	
$price = number_format_i18n( $results["price"], 2 );
$tax = $results["price"]*0.25;
$product_price =$results["price"]+$tax;

?>

<div class=product>
	<div class="product-img">
		<img src="<?=$results["shopImage"];?>">
	</div>

	<div class=details>
		<h2> <?=$results["equipmentName"]?> </h2>


		<div class="book">
        	<div class="product-prices">
            	Pris pr. dag : <span id="priceperday"><?php  echo number_format($product_price, 2, '.', ''); ?> kr,-</span><br/>
            </div>
        	<span class="pro-quantity" <?php if($results['type'] =='rental'){echo 'style="display:none;"';}?>>
            	Antal : <input type="number" name="product-quantity" value="1" id="pro-qty"/>
            </span> 
			<button class="btn btn-book-now" >
			<img src="<?php echo get_template_directory_uri() . '/images/cart.png';?>" />
            <?php if($results['type'] =='rental'){echo 'Book nu';}else{echo 'Køb';};?>
 			
		</button>
 		<?php if($results['type'] =='rental'){?>
		<a href="/send-proposal" class="btn btn-proposal">
			<i class="fa fa-paper-plane-o" aria-hidden="true"></i>
 			Send en forespørgsel
		</a>
        <?php };?>
        <br>

        <?php if($results['type'] == 'rental'): ?>
	       	<div class="qty-vacant alert alert-info">
	       		<span><?php echo $results['stock']; ?></span> antal tilgængelige
	       	</div>
	       	<style>
	       		.alert-info {
				    color: #31708f;
				    background-color: #d9edf7;
				    border-color: #bce8f1;
				}

				.alert {
				    padding: 5px;
				    margin: 10px 0;
				    border: 1px solid transparent;
				    border-radius: 4px;
				}

				.qty-vacant{
					display: inline-block;
				}
	       	</style>
		<?php endif; ?>

		</div>
		<br/>
		<?php
			print substr(preg_replace("/<iframe.+\/iframe>/","",nl2br($results["shopDescription"])),0,5900);
		?> 
	</div>
		<br/>	
		<br/>	

	 
	<div class="clear"></div>
	<br/><br/>
    
<div class="booking-overlay">
<div class="addto-cart">
	<div class="container">
    
		<div class="bottom">
		
		<?php if($results['type'] =='rental'){?>
			<h4>Vælg bookingperiode</h4>
		<?php } ;?>

<? 
if( $wio_config["global"]["shop_max_days"] == 1)
{
?>
<script>
$(function(){
$("#todate").hide();
$("#todatelabel").hide();
$("#totalcostspan").hide();
});
</script>
<?
}
?>
<div id="datepicker_from" style="float: left;"></div>
	
<div class="date-add">
	<?php if($results['type'] =='rental'){?>
	<span id="select-date"></span>
	<div class="date-from">
    
		<label for="from" class="date-label"> Startdato </label>
		<input type="hidden" id="fromdate" name="fromdate">
        <div id="fromdate-p"></div>
        
	</div>
	<div class="date-to">
    	
		<label for="to" id="todatelabel" class="date-label"> Slutdato</label>
		<input type="hidden" id="todate" name="todate">
        <div id="todate-p"></div>
	</div>
    <?php } ;?>
</div>
<script>
$( function() {
     $( "#fromdate-p" ).datepicker({
          dateFormat: "<?=$wio_config["global"]["date_format"]?>",
	  defaultDate: "+1w",
          changeMonth: true,
	  minDate: 0,
          numberOfMonths: 1,
        
      onSelect: function () {
			
            var dueDate= document.getElementById('fromdate');
            dueDate.value =  $(this).datepicker({ dateFormat: "yy-mm-dd" }).val();
			updateFrom();
        }
	
	});
	

     
      
	$("#fromdate").focus();
     
});

    function update()
    {

	// Calculate days
	start = $("#fromdate-p").datepicker("getDate");
	end = $("#todate-p").datepicker("getDate");
	diff = new Date(end - start);
	days = diff/1000/60/60/24;

	price = <?=$results["price"];?>;
	if (days == 1)
		var bookings = days+ " dag";
	else if (days > 1)
		var bookings = days+ " dage";


	if (days > 0)
		$("#totalprice").html(moneyFormat(price*days));

	if ($("#fromdate").val() && $("#todate").val() != "")
	{
		//alert($("#fromdate").val());
		//alert($("#todate").val());
		var period = '<div class="rental-period"> \
					  Tjekker valgte datoer...\
					  </div>';
		
		$.ajax({
			url: "/wp-content/plugins/WioShop/ajax.php?action=selectdate&from="+$("#fromdate").val()+"&to="+$("#todate").val(),
			context: document.body
		}).done(function(data) {
			if (data != "OK")
			{
				alert("Nogen gik galt:"+data);
			}
			$("#select-date").empty();
			$("#select-date").empty();
			var period = '<div class="rental-period"> \
							<b>Startdato:</b> '+ $("#fromdate").val()+'<br> \
							<b>Slutdato:</b> '+$("#todate").val()+'<br> \
							<b>Periode: </b>'+bookings+'</div>';
		
			
		
			
			$("#rental-period").html(period);
		});

	}

	console.log(days+" dage");
    }
    function updateFrom()
    {
	  var from = $("#fromdate-p").datepicker("getDate");
	  var date1 = $("#fromdate-p").datepicker("getDate");
	  var date2 = $("#fromdate-p").datepicker("getDate");

	 to = $( "#todate-p" ).datepicker({
	        defaultDate: "+1w",
	        dateFormat: "<?=$wio_config["global"]["date_format"]?>",
	        changeMonth: true,
	        numberOfMonths: 1,
			onSelect: function () {
			
				var dueDate= document.getElementById('todate');
				dueDate.value =  $(this).datepicker({ dateFormat: "yy-mm-dd" }).val();
				update();
			},
		
	      })
	      .on( "change", function() {
		   update();
	      });
      

      $("#todate").unbind("click");
	  //$("#todate").unbind("click");
	
	  date1.setDate(date1.getDate()+1);
	  date2.setDate(date2.getDate()+<?=$wio_config["global"]["shop_max_days"];?>);
	  
	  to.datepicker( "setDate", date1 )
	  to.datepicker( "option", "minDate", date1);
	  to.datepicker( "option", "maxDate", date2 );

    	update();
    }

    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( "<?=$wio_config["global"]["date_format"]?>", element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
</script>	
<div class="related-products clear">
	<div class="related-product-wrap">
    	 <?php if($results['type'] =='rental'){?>
        <h3>Vælg din lejeperiode ved at klikke på tabellerne.</h3>
        
        <div id="ajax-error"></div>
       
        <div id="rental-period"><div class="rental-period">Du har endnu ikke valgt nogen datoer</div></div>
   	    <?php };?>  
	</div>
    
    <div class="cancel-product">
    	<div class="cancel-pro">
        	<h3>Produkter: <?=$results["equipmentName"]?> </h3>
            <figure>
            <img src="<?=$results["shopImage"];?>" alt="product img" class="thumb" />
            </figure>
            <div>
            <button class="btn btn-cancel">Annuller</button>
            </div>
        </div>
    </div>
	
<div style="float: right;" class="price">
		<div class="product-price">
            Price pr. day: <span id=priceperday><script>document.write(moneyFormat(<?=$results["price"];?>));</script></span><br/>
            <span id="totalcostspan">
            Total cost, <span id=days>1 day</span>: <span id=totalprice><script>document.write(moneyFormat(<?=$results["price"];?>));</script></span><br/>
            </span>
        </div>
            <input type="hidden" value=1 name=amount id=amount style='width: 50px;'>
            <input type=submit id=addtocart value="<?php if($results['type'] =='rental'){echo 'Book nu';}else{echo 'Køb';};?>">
	</div>
			


	<div class="clear"></div>
</div>
</div>
</div><!--.addto-cart-->

</div><!--Booking overlay-->
	
<script>
	$(function(){
		$('.btn-book-now').click(function(){
			$('.booking-overlay').fadeToggle();
			var qty = $('#pro-qty').val();
			
			$('#amount').val(qty);
			
		});
		$('.btn-cancel').click(function(){
			$('.booking-overlay').fadeToggle();
		});
	});
</script>

<script>
	$("#addtocart").click(function(){
		<?php if($results['type'] =='rental'){?>
		if ($("#fromdate").val() && $("#todate").val() != ""){
		<?php } ;?>
		$.ajax({
			url: "/wp-content/plugins/WioShop/ajax.php?action=addtobasket&product=<?=$results['id'];?>&amount="+$("#amount").val(),
			context: document.body
		}).done(function(data) {
			if (data != "OK")
			{
				alert(data);
			} else {
			
				$( function() { 
				var todate = $("#todate").val();
				  <?php if($results['type'] =='rental'){?>
				  if(todate.length>0){
					window.location = "/store/?shop=cart";
				  }else{
				  	$("#select-date").html("Hov! du mangler at vælge en slutdato");
				  }
				  <?php }else{?>
					 window.location = "/store/?shop=cart";
					<?php }?>
					//$( "#dialog" ).dialog({
//						modal: true,
//						buttons: {
//						      "Keep shopping": function(){
//							$("#dialog").dialog("close");
//						      },
//						      "Go to cart": function(){
//							document.location="?shop=cart";
//						      }
//					      }
//					}); 
//				
				} );
			}
		});
		<?php if($results['type'] =='rental'){?>
		}else{
			$("#select-date").html("Hov! du mangler at vælge en slutdato");	
			}
		<?php };?>
		
	});
	<?php if($results['type'] =='rental'){?>
	$(function(){
		
	  <? if (isset($_SESSION["bookingdate"]["from"])) { ?>
	  $("#fromdate").datepicker("setDate", "<?=$_SESSION["bookingdate"]["from"]?>");
		updateFrom();
	  <?  } ?>
	  
	  <? if (isset($_SESSION["bookingdate"]["from"])) { ?>
	  $("#todate").datepicker("setDate", "<?=$_SESSION["bookingdate"]["to"]?>");
	  <?  } ?>
		update();
	});
	<?php };?>
</script>

</div>



  <script>
	    </script>
	    </head>
	    <body>
	     
	     <div id="dialog" title="Product added to cart" style="display: none">
	       <p>Produktet er blevet tilføjet til kurven..</p>
	       </div>
           
    <section id="related-products">
    	<h4 class="section-header">Andre har også kigget på: </h4>
    	<div class="related-products">
        	<?php echo  do_shortcode('[related_products catid="'.$results['categoryID'].'"]');?>
        </div>
    </section>
<?php } ?>