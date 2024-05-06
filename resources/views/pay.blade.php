<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body class="vh-100 d-flex align-items-center justify-content-center">

    <div class="pay bg-light p-5 text-center">
        @if($errors->any())
            <div class="text-danger mb-4">
                {{ $errors->first() }}
            </div>
        @endif
        <div class="h5 mb-4">
            3 USD
        </div>
        <form method="POST" action="/pay">
            @csrf
            <select name="currency" class="form-control form-control mb-4">
                <option value="USDT_TRX">
                    USDT TRC20
                </option>
            </select>

            <button class="btn btn-primary">
                Pay
            </button>
        </form>
    </div>

</body>

</html>