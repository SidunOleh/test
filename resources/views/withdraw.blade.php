<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body class="vh-100 d-flex align-items-center justify-content-center">

    <div class="pay bg-light p-5 text-center">
        @if($errors->any())
            <div class="text-danger mb-4">
                {{ $errors->first() }}
            </div>
        @endif
        @if(session('message'))
            <div class="text-success mb-4">
                {{ session('message') }}
            </div>
        @endif
        <form method="POST" action="/withdraw">
            @csrf
            <select name="currency" class="form-control form-control mb-4">
                <option value="USDT_TRX">
                    USDT TRC20
                </option>
                <option value="TRX">
                    Tron
                </option>
            </select>

            <input class="form-control mb-4" type="number" min="0" placeholder="Amount" name="amount" value="0">

            <input class="form-control mb-4" type="text" placeholder="Wallet address" name="to">

            <button class="btn btn-primary mb-3">
                Withdraw
            </button>

            <div class="balance mb-3"></div>
            <div class="fee"></div>
        </form>
    </div>

    <script>
        const currency_select = document.querySelector('[name=currency]')
        currency_select.addEventListener('change', getInfo)
        const amount_input = document.querySelector('[name=amount]')
        amount_input.addEventListener('change', getInfo)
        const balance_el = document.querySelector('.balance')
        const fee_el = document.querySelector('.fee')

        async function getInfo() {
            const res = await fetch(`/withdraw/info?currency=${currency_select.value}&amount=${amount_input.value}`)
            const data = await res.json()
            balance_el.innerHTML = `Balance - ${data.balance} ${currency_select.value}`
            fee_el.innerHTML = `Fee - ${data.fee} ${currency_select.value}`
        }
    </script>

</body>

</html>