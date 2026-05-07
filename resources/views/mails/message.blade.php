<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Transaction Approved</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f7f9fc; padding: 30px;">
    <div style="background: #fff; padding: 25px; border-radius: 10px; max-width: 600px; margin: auto; box-shadow: 0 3px 8px rgba(0,0,0,0.1);">
        <h2 style="color: #305C89;">NGM Trading</h2>

        <p>Hello {{ $user->name }},</p>

        <p>
            We are pleased to inform you that your transaction has been <strong>approved</strong>
            and successfully processed on your account.
        </p>

        <p>
            If you have any questions or did not authorise this transaction, please contact
            our support team immediately.
        </p>

        <p style="margin-top: 30px; color: #555;">
            Regards,<br>
            <strong>NGM Trading Support Team</strong>
        </p>

        <p style="font-size: 12px; color: #999; margin-top: 20px;">
            This is an automated notification. Please do not reply directly to this email.
        </p>
    </div>
</body>
</html>
