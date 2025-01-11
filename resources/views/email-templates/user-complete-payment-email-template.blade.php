<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f9f9f9; font-family: Arial, Helvetica, sans-serif; color: #333;">
    <div
        style="width: 100%; max-width: 600px; margin: 20px auto; background-color: #ffffff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
        <!-- Header -->
        <div style="background-color: #4CAF50; color: #ffffff; text-align: center; padding: 20px;">
            <h1 style="margin: 0; font-size: 24px;">Payment Confirmation</h1>
        </div>

        <!-- Content -->
        <div style="padding: 20px; line-height: 1.6;">
            <h2 style="color: #4CAF50;">Hello, {{ $consignor_name }}</h2>
            <p>We are pleased to inform you that your payment has been successfully processed. Thank you for partnering
                with us!</p>
            <p><strong>Payment Details:</strong></p>
            <ul style="padding-left: 20px;">
                <li><strong>Payment Code:</strong> {{ $payment_id }}</li>
                <li><strong>Amount:</strong> {{ $payment_amount }}</li>
                <li><strong>Date:</strong> {{ $payment_date }}</li>
            </ul>
            <p>If you have any questions or concerns, feel free to contact us at
                <a href="mailto:{{ get_settings()->site_email }}"
                    style="color: #4CAF50; text-decoration: none;">{{ get_settings()->site_email }}</a>.
            </p>
        </div>

        <!-- Footer -->
        <div style="text-align: center; padding: 10px; background-color: #f1f1f1; color: #666; font-size: 14px;">
            <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
