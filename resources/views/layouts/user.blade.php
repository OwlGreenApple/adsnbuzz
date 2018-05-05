
<style type="text/css">
	.tombolmenu{
	  position:relative; 
	  max-width: 100%;
	}

	.menu{
	  position: relative;
	  text-align: center;
	}

	.youraction{
	  color: white;
	  font-family: Arial;
	  font-weight: bold;
	  margin-left: 40px;
	}

	* {
    	box-sizing: border-box;
	}

	.column {
	    float: left;
	    width: 25%;
	    padding: 10px;
	}

	/* Clearfix (clear floats) */
	.row::after {
	    content: "";
	    clear: both;
	    display: table;
	}

</style>
<div style="background-color: dodgerblue;">
	<h2 class="youraction">Your Action</h2>	
</div>
<div class="row justify-content-center">
	<div class="column">
		<a href="{{ url('/report-user') }}"><img src="design/report-hover.png" class="tombolmenu"></a>
		<p class="menu">Report</p>	
	</div>
	
	<div class="column">
		<a href="{{ url('/order') }}"><img src="design/deposit-hover.png" class="tombolmenu"></a>
		<p class="menu">Deposit</p>	
	</div>
	
	<div class="column">
		<a href="{{ url('/confirm-user') }}"><img src="design/confirm-payment-hover.png" class="tombolmenu"></a>
		<p class="menu">Confirm Payment</p>		
	</div>
</div>