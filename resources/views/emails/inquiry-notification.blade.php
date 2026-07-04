<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="utf-8">
    <title>Novi upit sa sajta</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:Arial,sans-serif;color:#111827;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f3f4f6;padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:640px;background:#ffffff;border-radius:16px;overflow:hidden;border:1px solid #e5e7eb;">
                    <tr>
                        <td style="background:#09539a;color:#ffffff;padding:22px 26px;">
                            <h1 style="margin:0;font-size:22px;line-height:1.3;">Novi upit sa sajta</h1>
                            <p style="margin:6px 0 0;font-size:14px;opacity:.9;">Kontakt forma je upravo poslata.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:26px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                                <tr>
                                    <td style="padding:10px 0;width:130px;color:#6b7280;font-size:13px;font-weight:bold;">Ime</td>
                                    <td style="padding:10px 0;color:#111827;font-size:14px;">{{ $inquiry->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 0;width:130px;color:#6b7280;font-size:13px;font-weight:bold;">Email</td>
                                    <td style="padding:10px 0;color:#111827;font-size:14px;">
                                        <a href="mailto:{{ $inquiry->email }}" style="color:#09539a;text-decoration:none;">{{ $inquiry->email }}</a>
                                    </td>
                                </tr>
                                @if ($inquiry->phone)
                                    <tr>
                                        <td style="padding:10px 0;width:130px;color:#6b7280;font-size:13px;font-weight:bold;">Telefon</td>
                                        <td style="padding:10px 0;color:#111827;font-size:14px;">
                                            <a href="tel:{{ $inquiry->phone }}" style="color:#09539a;text-decoration:none;">{{ $inquiry->phone }}</a>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td style="padding:10px 0;width:130px;color:#6b7280;font-size:13px;font-weight:bold;">Datum</td>
                                    <td style="padding:10px 0;color:#111827;font-size:14px;">{{ $inquiry->created_at->format('d.m.Y H:i') }}</td>
                                </tr>
                            </table>

                            <div style="margin-top:22px;padding:18px;background:#f9fafb;border:1px solid #e5e7eb;border-radius:12px;">
                                <p style="margin:0 0 8px;color:#6b7280;font-size:13px;font-weight:bold;">Poruka</p>
                                <p style="margin:0;color:#111827;font-size:15px;line-height:1.6;white-space:pre-line;">{{ $inquiry->message }}</p>
                            </div>

                            <p style="margin:22px 0 0;color:#6b7280;font-size:13px;line-height:1.5;">
                                Ovaj upit je sačuvan i u admin panelu, na stranici Upiti.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
