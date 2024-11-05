<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            color: #4CAF50;
            font-size: 24px;
        }
        .content {
            line-height: 1.6;
        }
        .content p {
            margin: 10px 0;
        }
        .highlight {
            font-weight: bold;
            color: #ff5722;
        }
        .section-title {
            font-weight: bold;
            color: #333;
            margin-top: 20px;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Your Consigned Item Has Been Sold!</h2>
        </div>

        <div class="content">
            <p>Dear {{ $consignor_name }},</p>
            <p>Congratulations! Your consigned item has been sold, and your payment is now ready for collection at our store. Below are the transaction details for your reference:</p>

            <p class="section-title">Item Details:</p>
            <p><strong>Item Name:</strong> {{ $item_name }}</p>
            <p><strong>Brand:</strong> {{ $item_brand }}</p>
            <p><strong>SKU:</strong> {{ $item_sku }}</p>
            <p><strong>Color:</strong> {{ $item_color }}</p>
            <p><strong>Quantity Sold:</strong> {{ $item_qty }}</p>
            <p><strong>Selling Price:</strong> ₱ {{ number_format($item_price, 0) }}</p>
            <p><strong>Subtotal:</strong> ₱ {{ number_format($sub_total, 0) }}</p>
            <p><strong>Tax:</strong> ₱ {{ number_format($total_tax, 0) }}</p>
            <p><strong>Total Amount:</strong> ₱ {{ number_format($total, 0) }}</p>

            <p class="section-title">Consignment Details:</p>
            <p><strong>Commission Rate:</strong> {{ $consignment_commission_percentage }}%</p>
            <p><strong>Start Date:</strong> {{ $consignment_start_date }}</p>
            <p><strong>Expiry Date:</strong> {{ $consignment_expiry_date }}</p>

            <p class="section-title">Payment Collection:</p>
            <p>Please present the following <span class="highlight">Payment Code: {{ $payment_code }}</span> when you visit our store to claim your payment. You may show this email or take a screenshot for verification. **Do not share this code with anyone.**</p>

            <p class="section-title">Claiming Schedule:</p>
            <p>You can claim your payment at the following times:</p>
            <p><strong>Date:</strong> {{ $claim_date }}</p>
            <p><strong>Time:</strong> {{ $claim_time }}</p>

            <p>We appreciate your trust in our consignment services and look forward to working with you again in the future!</p>

            <div class="footer">
                <p>This email was automatically sent by {{ get_settings()->site_name }}. Please do not reply to this email.</p>
            </div>
        </div>
    </div>
</body>
</html>
