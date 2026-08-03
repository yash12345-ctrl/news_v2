<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ env('APP_NAME') }}</title>
</head>
<body>
	<p>Hi Admin,</p>
	<p>
		A visitor has contacted, here is the full body of the form.
	</p>
	<pre>
		@foreach ($data as $k => $d)
			{{ $k }}: {{ $d }}
		@endforeach
	</pre>
</body>
</html>