<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $datos['asunto'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .header {
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px;
            font-size: 16px;
            color: #333333;
        }
        .code {
            font-size: 24px;
            font-weight: bold;
            background: #f8f9fa;
            padding: 10px;
            display: inline-block;
            border-radius: 5px;
            margin: 15px 0;
            color: #007bff;
        }
        .button {
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .button:hover {
            background: #0056b3;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777777;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">{{ $datos['titulo'] }}</div>
        <div class="content">
            <p>Hemos recibido una solicitud para restablecer la contraseña de su cuenta.</p>
            <p>Utilice el siguiente código para completar el proceso de recuperación:</p>
            <div class="code">{{ $datos['codigo'] }}</div>
            <p>Si no solicitó este cambio, puede ignorar este mensaje.</p>
        </div>
        <div class="footer">
            <p>&copy; 2025 Take It. Todos los derechos reservados.</p>
        </div>
    </div>

</body>
</html>
