document.getElementById('mpesaPaymentForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const phoneNumber = document.getElementById('phoneNumber').value;
    const amount = document.getElementById('amount').value;
    const campaignId = document.getElementById('campaign_id').value; // Ensure you have this hidden input in your form

    fetch('/mpesa/donate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ phone: phoneNumber, amount: amount, campaign_id: campaignId }),
    })
    .then(response => response.json())
    .then(data => {
        console.log('Payment initiated:', data);
        // Handle success or failure
        if (data.success) {
            alert('Check your phone to complete the payment.');
        } else {
            alert('Payment initiation failed: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Something went wrong: ' + error.message);
    });
});
