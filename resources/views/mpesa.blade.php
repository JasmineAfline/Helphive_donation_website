<!DOCTYPE html>
<html>
<head>
    <title>M-Pesa Payment</title>
    <script src="{{ asset('js/mpesa.js') }}"></script>
</head>
<body>
    <h1>M-Pesa Payment</h1>
    <form id="mpesaPaymentForm">
        <label for="phoneNumber">Phone Number:</label>
        <input type="text" id="phoneNumber" name="phoneNumber" required>

        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" required>

        <button type="submit">Pay</button>
    </form>
</body>
</html>
