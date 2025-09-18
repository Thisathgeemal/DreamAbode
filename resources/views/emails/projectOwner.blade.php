<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DreamAbode</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Instrument Sans', Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            margin: 0;
        }

        .container {
            max-width: 480px;
            width: 100%;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .header {
            text-align: center;
            margin-bottom: 32px;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #dc2626;
            margin: 0;
        }

        .header h2 {
            font-size: 22px;
            font-weight: 600;
            color: #1f2937;
            margin-top: 12px;
        }

        .content {
            background-color: #fef2f2;
            border-radius: 8px;
            padding: 28px;
            margin-bottom: 28px;
        }

        .content p {
            font-size: 16px;
            color: #4b5563;
            margin: 0 0 20px;
            line-height: 1.6;
        }

        .content strong {
            color: #dc2626;
        }

        .highlight {
            font-weight: 500;
            color: #16a34a;
        }

        .credentials {
            background-color: #f9fafb;
            padding: 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px dashed #d1d5db;
        }

        .credentials p {
            margin: 0;
            font-size: 15px;
            color: #1f2937;
        }

        .credentials .label {
            font-weight: 600;
            color: #dc2626;
        }

        .footer {
            margin-top: 32px;
            text-align: center;
        }

        .footer p {
            font-size: 14px;
            color: #6b7280;
            margin: 0;
        }

        .footer span {
            font-weight: 600;
            color: #dc2626;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Project Purchase Notification</h1>
            <h2>Hi {{ $member->name }},</h2>
        </div>

        <div class="content">
            <p>Your project has been successfully purchased via <strong>DreamAbode</strong>.
                Here are the details of the buyer and the transaction:</p>

            <!-- Buyer Details -->
            <div class="credentials">
                <p><span class="label">Buyer Name:</span> {{ $buyer->name }}</p>
                <p><span class="label">Buyer Email:</span> {{ $buyer->email }}</p>
                <p><span class="label">Buyer Mobile:</span> {{ $buyer->mobile_number }}</p>
                <p><span class="label">Buyer Address:</span> {{ $buyer->address }}</p>
            </div>

            <!-- Agent Details -->
            @if ($agent)
                <div class="credentials">
                    <p><span class="label">Agent Name:</span> {{ $agent->name }}</p>
                    <p><span class="label">Agent Email:</span> {{ $agent->email }}</p>
                    <p><span class="label">Agent Mobile:</span> {{ $agent->mobile_number }}</p>
                </div>
            @endif

            <!-- Project Details -->
            <div class="credentials">
                <p><span class="label">Project Name:</span> {{ $project->project_name }}</p>
                <p><span class="label">Property Type:</span> {{ $project->property_type }}</p>
                <p><span class="label">Location:</span> {{ $project->location }}</p>
                <p><span class="label">Price:</span> {{ $project->price }}</p>
                <p><span class="label">Available Units Left:</span> {{ $project->available_units }}</p>
            </div>

            <p class="highlight">Please get in touch with the buyer or agent to proceed with the next steps.</p>
        </div>

        <div class="footer">
            <p>Best regards,<br><span>DreamAbode Team</span></p>
        </div>
    </div>
</body>

</html>
