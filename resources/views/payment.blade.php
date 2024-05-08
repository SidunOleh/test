<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <div class="invoice d-flex align-items-center justify-content-center vh-100 flex-column">
        <div class="invoice__body text-center bg-light p-5">
            <div class="status mb-3">
            </div>
            <img src="{{ $payment->qr_code }}" class="mb-2" alt="">
            <div class="address mb-4">
                {{ $payment->qr_url }}
            </div>
            <div class="amount text-center mb-3">
                Invoice amount: {{ $payment->invoice_sum . ' ' . $payment->currency }}
                <br>
                Invoice commission: {{ $payment->invoice_commission . ' ' . $payment->currency }}
                <br>
                Total: {{ $payment->invoice_total_sum . ' ' . $payment->currency }}
            </div>
            <div class="countdown">
            </div>
        </div>
    </div>
    <script>
        const payment_id = <?php echo $payment->id ?>;
        const expire_at = <?php echo $payment->expire_at_utc ?>;

        countdown()
        setInterval(countdown, 1000)

        check_status()
        setInterval(check_status, 1000)

        async function check_status() {
            const response = await fetch(`/payment/${payment_id}/status`)
            const data = await response.json()
            
            document.querySelector('.status').innerHTML = `Status - ${data.status}`
        }

        function countdown() {
            const remaining_secs = expire_at - new Date().getTime() / 1000
            const countdown_el = document.querySelector('.countdown')

            if (remaining_secs > 0) {
                const mins = String(Math.floor(remaining_secs / 60)).padStart(2, '0')
                const secs = String(Math.floor(remaining_secs % 60)).padStart(2, '0')
                countdown_el.innerHTML = `Remaining time - ${mins}:${secs}`
            } else {
                countdown_el.innerHTML = 'Time was run out'
            }
        }
    </script>
</body>
</html>