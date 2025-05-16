<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nouvelle demande de contact - ICORP</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4CA3DD;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .value {
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>Nouvelle demande de contact</h1>
</div>

<div class="content">
    <p>Une nouvelle demande de contact a été soumise via le site web. Voici les détails :</p>

    <div class="field">
        <span class="label">Nom :</span>
        <div class="value">{{ $contact->name }}</div>
    </div>

    <div class="field">
        <span class="label">Email :</span>
        <div class="value">{{ $contact->email }}</div>
    </div>

    @if($contact->phone)
        <div class="field">
            <span class="label">Téléphone :</span>
            <div class="value">{{ $contact->phone }}</div>
        </div>
    @endif

    @if($contact->formation)
        <div class="field">
            <span class="label">Formation souhaitée :</span>
            <div class="value">{{ $contact->formation }}</div>
        </div>
    @endif

    <div class="field">
        <span class="label">Message :</span>
        <div class="value">{{ $contact->message }}</div>
    </div>

    <div class="field">
        <span class="label">Date de soumission :</span>
        <div class="value">{{ $contact->created_at->format('d/m/Y H:i') }}</div>
    </div>
</div>

<div class="footer">
    <p>Ce message a été envoyé automatiquement depuis le site web ICORP.</p>
</div>
</body>
</html>
