<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="cache-control" content="private , max-age=0, no-cache">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="expires" content="0">
	<meta name="csrf-token" content="{{csrf_token()}}">
	<title>Online Portfolio's</title>
	<link rel="stylesheet" type="text/css" href="{{asset('public/css/style.css')}}">
	<script  src="{{asset('public/javascript/jquery-3.3.1.js')}}"></script>


</head>
<body>

	@yield('content')
	@yield('footer')

</body>
</html>