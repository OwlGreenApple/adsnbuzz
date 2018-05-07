
<style type="text/css">
	@font-face { 
		font-family: FiraSansMedium; 
		src: url("{{ asset('fonts/fira-sans.semibold.ttf') }}");
	} 

	@font-face { 
		font-family: FiraSansRegular; 
		src: url("{{ asset('fonts/fira-sans.regular.ttf') }}");
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
	  padding: 10px 0px 0px 40px;
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
		<?php if(url()->current() == url('/')) { ?>
			<a href="{{ url('/') }}"><img src="{{ asset('design/home-button.png') }}" class="tombolmenu"></a>
		<?php } else { ?>
			<a href="{{ url('/') }}"><img src="{{ asset('design/home-button-hover.png') }}" class="tombolmenu"></a> 
		<?php } ?>
		<p class="menu font">Home</p>

		<?php if(url()->current() == url('/order')) { ?>
			<a href="{{ url('/order') }}"><img src="{{ asset('design/deposit.png') }}" class="tombolmenu"></a>
		<?php } else { ?>
			<a href="{{ url('/order') }}"><img src="{{ asset('design/deposit-hover.png') }}" class="tombolmenu"></a>
		<?php } ?>
		<p class="menu font">Deposit</p>	
	</div>

	<div class="column">
		<?php if(url()->current() == url('/maxspend')) { ?>
			<a href="{{ url('/maxspend') }}"><img src="{{ asset('design/home-button.png') }}" class="tombolmenu"></a>
		<?php } else { ?>
			<a href="{{ url('/maxspend') }}"><img src="{{ asset('design/home-button-hover.png') }}" class="tombolmenu"></a> 
		<?php } ?>
		<p class="menu font">Max Spend</p>

		<?php if((url()->current() == url('/confirm-user')) or (url()->current() == url('/confirm-user/{id}'))) { ?>
			<a href="{{ url('/confirm-user') }}"><img src="{{ asset('design/confirm-payment.png') }}" class="tombolmenu"></a>
		<?php } else { ?>
			<a href="{{ url('/confirm-user') }}"><img src="{{ asset('design/confirm-payment-hover.png') }}" class="tombolmenu"></a> 
		<?php } ?>
		<p class="menu font">Confirm Payment</p>
	</div>
	
	<div class="column">
		<?php if(url()->current() == url('/report-user')) { ?>
			<a href="{{ url('/report-user') }}"><img src="{{ asset('design/report.png') }}" class="tombolmenu"></a>
		<?php } else { ?>
			<a href="{{ url('/report-user') }}"><img src="{{ asset('design/report-hover.png') }}" class="tombolmenu"></a> 
		<?php } ?>
		<p class="menu font">Report</p>

		<a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
        	<img src="{{ asset('design/logout-button-hover.png') }}" class="tombolmenu">
        </a>
		<p class="menu font">Logout</p>		
	</div>
</div>
