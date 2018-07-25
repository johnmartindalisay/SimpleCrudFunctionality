@extends('master')

@section('content')
<div class="center-container">

		 <form id="login-form" action="{{URL::to('/home')}}" method="POST">
		 	<input type="hidden" name="_token" value="{{csrf_token()}}">
		  <div class="imgcontainer"><h3>Login</h3></div>

		  <div class="container">
		    <label for="uname"><b>Email</b></label>
		    <input type="text" placeholder="Enter Email" name="email_address" id="email_address"  required>

		    <label for="psw"><b>Password</b></label>
		    <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

		    <?php if (isset($error_message)){
		    	echo "<div class='alert'>".$error_message."</div>";
		    }?>
		    <br>
		   <!--  <div class="error-validation"></div> -->
		    <button type="submit">Login</button>

		    <br>
		    <span class="psw">Register? <a href="register">Register here</a></span>

		  </div>

		  <div class="container" style="background-color:#f1f1f1">
		  </div>
		</form> 
		
</div>

@stop

@section('footer')

<script>
	$(function(){
		setTimeout(function() {
						 $('div.alert').fadeOut();
		}, 10000);
	});
</script>


@stop