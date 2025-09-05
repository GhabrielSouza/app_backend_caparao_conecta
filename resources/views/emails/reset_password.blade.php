<!DOCTYPE html>
<html>

<head>
    <title>Redefinição de Senha - Caparaó Conecta</title>
    <style>
        /* Adicione seu CSS customizado aqui */
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }

        .header {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .container {
            padding: 30px;
            max-width: 600px;
            margin: 20px auto;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .button {
            background-color: #28a745;
            color: white !important;
            padding: 15px 25px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- <div class="header">
        <img src="{{ env('APP_URL') }}/img/logo.svg" alt="Caparaó Conecta"
            style="max-width: 200px; display: block; margin: 0 auto 20px;">
    </div> -->
    <div class="container">
        <h1>Olá!</h1>
        <p>Você está recebendo este e-mail porque recebemos um pedido de redefinição de senha para sua conta.</p>
        <p>Este link de redefinição de senha irá expirar em 60 minutos.</p>
        <p style="text-align: center; margin: 30px 0;">
            <a href="{{ $resetUrl }}" class="button">Redefinir Senha</a>
        </p>
        <p>Se você não solicitou uma redefinição de senha, nenhuma ação adicional é necessária.</p>
        <div class="footer">
            <p>Atenciosamente,<br>{{ env('MAIL_FROM_NAME') }}</p>
        </div>
    </div>
</body>

</html>
