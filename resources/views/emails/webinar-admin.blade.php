<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Webinar Registration</title>
</head>

<body style="margin:0;padding:0;background:#f4f7fb;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f7fb;padding:40px 0;">
        <tr>
            <td align="center">

                <table width="650" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:10px;overflow:hidden;box-shadow:0 5px 20px rgba(0,0,0,.08);">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="background:#0d6efd;padding:30px;color:#fff;">
                            <h2 style="margin:0;font-size:28px;">
                                🎉 New Webinar Registration
                            </h2>
                            <p style="margin-top:8px;font-size:15px;">
                                A new participant has registered successfully.
                            </p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:35px;">

                            <h3 style="margin-top:0;color:#333;">
                                Registration Details
                            </h3>

                            <table width="100%" cellpadding="12" cellspacing="0"
                                style="border-collapse:collapse;border:1px solid #e5e7eb;">

                                <tr style="background:#f8fafc;">
                                    <th align="left" style="border:1px solid #e5e7eb;width:180px;">
                                        👤 Full Name
                                    </th>
                                    <td style="border:1px solid #e5e7eb;">
                                        {{ $data['name'] }}
                                    </td>
                                </tr>

                                <tr>
                                    <th align="left" style="border:1px solid #e5e7eb;">
                                        📞 Phone Number
                                    </th>
                                    <td style="border:1px solid #e5e7eb;">
                                        {{ $data['phone'] }}
                                    </td>
                                </tr>

                                <tr style="background:#f8fafc;">
                                    <th align="left" style="border:1px solid #e5e7eb;">
                                        📧 Email Address
                                    </th>
                                    <td style="border:1px solid #e5e7eb;">
                                        {{ $data['email'] }}
                                    </td>
                                </tr>

                                <tr>
                                    <th align="left" style="border:1px solid #e5e7eb;">
                                        📍 City
                                    </th>
                                    <td style="border:1px solid #e5e7eb;">
                                        {{ $data['city'] }}
                                    </td>
                                </tr>

                                <tr style="background:#f8fafc;">
                                    <th align="left" style="border:1px solid #e5e7eb;">
                                        🕒 Registered On
                                    </th>
                                    <td style="border:1px solid #e5e7eb;">
                                        {{ now()->format('d M Y h:i A') }}
                                    </td>
                                </tr>

                            </table>

                            <div
                                style="margin-top:30px;padding:18px;background:#eef7ff;border-left:4px solid #0d6efd;border-radius:6px;">
                                <strong>Note:</strong><br>
                                Please contact this participant if any additional webinar information or reminders need
                                to be shared.
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background:#f8fafc;padding:20px;border-top:1px solid #e5e7eb;">

                            <strong style="font-size:18px;color:#0d6efd;">
                                Bliss Monk Tech Solutionsz
                            </strong>

                            <br><br>

                            📧 bharath@blissmonktech.com

                            <br>

                            📞 +91 9894180719

                            <br><br>

                            <small style="color:#777;">
                                This email confirms that a new participant has successfully registered for the webinar
                                through the official registration form.
                            </small>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
