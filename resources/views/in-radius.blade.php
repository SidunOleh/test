<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In radius</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body class="p-3">

    <div class="h4 mb-3">
        Your location: {{ $geo['lat'] . ', ' . $geo['lon'] }}({{ $geo['city'] . ', ' . $geo['country'] }})
    </div>

    <form method="GET" class="mb-3">
        <input class="form-control-sm mb-2" min="1" type="number" name="radius" placeholder="Enter radius" value="{{ $radius }}">
        <br>
        <button class="btn btn-primary">
            Apply 
        </button>
    </form>

    <table class="table table-dark">
        <thead>
            <tr>
                <th scope="col">Latitude</th>
                <th scope="col">Longitude</th>
                <th scope="col">Distance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($addresses as $addresse)
            <tr>
                <td>{{ $addresse->latitude }}</td>
                <td>{{ $addresse->longitude }}</td>
                <td>{{ round($addresse->distance) }}mi</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>