
<style type="text/css">
	@font-face { 
		font-family: FiraSansMedium; 
		src: url('fonts/fira-sans.semibold.ttf'); 
	} 

	@font-face { 
		font-family: FiraSansRegular; 
		src: url('fonts/fira-sans.regular.ttf'); 
	} 

	.tombolmenu{
	  position:relative; 
	  max-width: 95%;
	}

	.menu{
	  position: relative;
	  text-align: center;
	  font-family: 'FiraSansRegular';
	}

	.youraction{
	  color: white;
	  font-family: 'FiraSansMedium';
	  font-size: 25px;
	  margin-left: 40px;
	}

	* {
    	box-sizing: border-box;
	}

	.column {
	    float: left;
	    width: 30%;
	    padding: 10px 15px 0px 15px;
	}

	/* Clearfix (clear floats) */
	.row::after {
	    content: "";
	    clear: both;
	    display: table;
	}
</style>
<div class="row" style="background-color: #10a0db">
	<p class="youraction">Your Action</p>	
</div>
<div class="row justify-content-center">
	<div class="column">
		<a href="{{ url('/report-user') }}"><img src="design/report-hover.png" class="tombolmenu"></a>
		<p class="menu font">Max Spend</p>
		<a href="{{ url('/confirm-user') }}"><img src="design/confirm-payment-hover.png" class="tombolmenu"></a>
		<p class="menu font">Confirm Payment</p>	
	</div>

	<div class="column">
		<a href="{{ url('/report-user') }}"><img src="design/report-hover.png" class="tombolmenu"></a>
		<p class="menu font">Report</p>
		<a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
        	<img src="design/deposit-hover.png" class="tombolmenu">
        </a>
		<p class="menu font">Logout</p>		
	</div>
	
	<div class="column">
		<a href="{{ url('/order') }}"><img src="design/deposit-hover.png" class="tombolmenu"></a>
		<p class="menu font">Deposit</p>	
	</div>
</div>
