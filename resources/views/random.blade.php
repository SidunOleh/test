<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random fetch</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body class="m-3">

    <div class="countdown mb-3">
        Order change in <span>{{ $time }}</span>s
    </div>

    <table class="table table-dark">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->title }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if ($items->lastPage() > 1)
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            @for($i=1; $i <= $items->lastPage(); $i++)
            <li class="page-item {{ $items->currentPage() == $i ? 'active' : '' }}">
                <a class="page-link" href="?page={{ $i }}">
                    {{ $i }}
                </a>
            </li>
            @endfor
        </ul>
    </nav>
    @endif

    <script>
        let time = <?php echo $time ?>;
        const countdown_el = document.querySelector('.countdown span')

        setInterval(() => {
            time -= 1

            if (time == 0) {
                location.reload()
            } else {
                countdown_el.innerHTML = time
            }
        }, 1000)
    </script>
</body>

</html>