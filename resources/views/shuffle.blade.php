<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shuffle</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

<ul class="list-group">
    @foreach($list as $item)
    <li class="list-group-item {{ $item == 'advertisement' ? 'list-group-item-primary': '' }} {{ $item == 'roulette' ? 'list-group-item-success' : '' }}">
        {{ $item }}
    </li>
    @endforeach
</ul>

</body>
</html>