<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

</head>
<body>
<form id="transactionForm" action="https://sanalpos.card-plus.net/fim/est3Dgate" method="post" target="transaction_frame">
    
    @foreach(json_decode($transactions->params) as $key => $value)
        <input type="hidden" name="{{$key}}" value="{{$value}}"> 
    @endforeach
</form>
 
</body>
</html>
<script>
    document.getElementById('transactionForm').submit()
</script>
