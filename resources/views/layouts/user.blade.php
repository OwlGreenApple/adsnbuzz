<script type="text/javascript">
  //Fungsi logout untuk user
	function logout(){
		if(confirm("Are you sure want to logout?")) {
      event.preventDefault();
      document.getElementById('logout-form').submit();
    }
	}
</script>

<div class="row" style="background-color: #10a0db">
	<p class="youraction">Your Action</p>	
</div>
<div class="row justify-content-center">
	<div class="column">
    <!-- Menu Home -->
		<?php if(url()->current() == url('/')) { ?>
			<a href="{{ url('/') }}"><img src="{{ asset('design/home-button.png') }}" class="tombolmenu"></a>
		<?php } else { ?>
			<a href="{{ url('/') }}"><img src="{{ asset('design/home-button-hover.png') }}" class="tombolmenu"></a> 
		<?php } ?>
		<p class="menu">Home</p>	
	</div>

	<div class="column">
    <!-- Menu Max Spend -->
		<?php if(url()->current() == url('/maxspend')) { ?>
			<a href="{{ url('/maxspend') }}"><img src="{{ asset('design/max-spend.png') }}" class="tombolmenu"></a>
		<?php } else { ?>
			<a href="{{ url('/maxspend') }}"><img src="{{ asset('design/max-spend-hover.png') }}" class="tombolmenu"></a> 
		<?php } ?>

		@if($user->spend_month==0)
			<p class="menu">Setup Max Spend</p>
		@else
			<p class="menu">Edit Max Spend</p> 
		@endif
	</div>
	
	<div class="column">
    <!-- Menu Report -->
		<?php if(url()->current() == url('/report-user')) { ?>
			<a href="{{ url('/report-user') }}"><img src="{{ asset('design/report.png') }}" class="tombolmenu"></a>
		<?php } else { ?>
			<a href="{{ url('/report-user') }}"><img src="{{ asset('design/report-hover.png') }}" class="tombolmenu"></a> 
		<?php } ?>
		<p class="menu">Report</p>		
	</div>
</div>

<div class="row justify-content-center">
	<div class="column">
    <!-- Menu Deposit -->
		<?php if(url()->current() == url('/order')) { ?>
			<a href="{{ url('/order') }}"><img src="{{ asset('design/deposit.png') }}" class="tombolmenu"></a>
		<?php } else { ?>
			<a href="{{ url('/order') }}"><img src="{{ asset('design/deposit-hover.png') }}" class="tombolmenu"></a>
		<?php } ?>
		<p class="menu">Deposit</p>
	</div>

	<div class="column">
    <!-- Menu Confirm Payment -->
		<?php if(strpos(url()->current(),'confirm-user')) { ?>
			<a href="{{ url('/confirm-user') }}"><img src="{{ asset('design/confirm-payment.png') }}" class="tombolmenu"></a>
		<?php } else { ?>
			<a href="{{ url('/confirm-user') }}"><img src="{{ asset('design/confirm-payment-hover.png') }}" class="tombolmenu"></a> 
		<?php } ?>
		<p class="menu">Confirm Payment</p>
	</div>

	<div class="column">
    <!-- Menu Logout -->
		@if (Session::has('hasClonedUser'))
      <a href="#" onclick="event.preventDefault(); document.getElementById('cloneuser-form').submit();">
        <img src="{{ asset('design/logout-button-hover.png') }}" class="tombolmenu">
      </a>
    @else 
			<a href="{{ route('logout') }}" onclick="logout()">
	      <img src="{{ asset('design/logout-button-hover.png') }}" class="tombolmenu">
	    </a>
	  @endif
		<p class="menu">Logout</p>
	</div>

	<form id="cloneuser-form" action="{{ url('manage-user/login/'.$user->id) }}" method="post">
    @csrf
  </form>
</div>