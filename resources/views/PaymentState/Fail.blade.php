<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="_token" content="{!! csrf_token() !!}" />
    <title>Document</title>
</head>
<body>
	
<h5 style="text-align:center">Ödeme İşlemlerinde hata oluştu lütfen bu sekmeleri kapatarak tekrar deneyiniz :  {{$errors['oid']}}</h5>
	<h6 style="text-align:center; text-weight:700"> Hata Mesajı: {{$errors['mdErrorMsg']}} / {{$errors['oid']}}</h6>
	<b id="removeMsg"></b>
</body>
</html>

<script>
	
	setTimeout(() => {
		removeTransaction()
	},2000)
function removeTransaction() {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("removeMsg").innerHTML = this.responseText;
    }
  xhttp.open("GET", "/pay-failed/{{$errors['oid']}}", true);
  xhttp.send();
}
</script>
