<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Test Email</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* Base reset */
    body, table, td, a { text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; }
    body { margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif; }
    table { border-collapse: collapse !important; }
    img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }

    /* Responsive wrapper */
    .email-container { max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; }

    .header { background-color: #882905; color: white; padding: 24px; text-align: center; }
    .content { padding: 24px; font-size: 16px; color: #333; }
    .btn {
      display: inline-block;
      padding: 12px 20px;
      margin-top: 20px;
      background-color: #28a745;
      color: white;
      text-decoration: none;
      border-radius: 4px;
    }
    .footer { background-color: #f1f1f1; text-align: center; padding: 16px; font-size: 12px; color: #888; }

    @media only screen and (max-width: 600px) {
      .content, .header, .footer { padding: 16px; }
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">
      <h1>Welcome to Academy Fence</h1>
    </div>
    <div class="content">
      <p>Hi {{ $name ?? 'Colin' }},</p>
      <p>This is a <strong>responsive HTML test email</strong> built with Stardust and sprinkles. It's mobile-friendly, easy to customize, and built with deliverability in mind.</p>
      <p>Click below to confirm:</p>
      <a href="{{ $url ?? '#' }}" class="btn">Go to Dashboard</a>
    </div>
    <div class="footer">
      &copy; {{ date('Y') }} Academy Fence. All rights reserved.
    </div>
  </div>
</body>
</html>
