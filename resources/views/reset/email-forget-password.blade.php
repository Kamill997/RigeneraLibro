<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h2 style="color: #333;">Reset della Password</h2>
    <p>Hai richiesto il reset della tua password. Clicca sul bottone qui sotto per procedere:</p>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ route('reset.password', ['token' => $token, 'email' => $email]) }}"
            style="background-color: #4CAF50; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px;">
            Reset Password
        </a>
    </div>

    <p style="color: #666; font-size: 14px;">Se non hai richiesto tu il reset della password, puoi ignorare questa email.</p>
    <p style="color: #666; font-size: 14px;">Questo link scadrà tra 60 minuti.</p>

    <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
    <p style="color: #999; font-size: 12px;">Se hai problemi con il bottone, copia e incolla questo link nel tuo browser:</p>
    <p style="color: #999; font-size: 12px;">{{ route('reset.password', ['token' => $token, 'email' => $email]) }}</p>
</body>

</html>