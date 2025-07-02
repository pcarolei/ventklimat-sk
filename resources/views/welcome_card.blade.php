<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'CRM') }} - ВЕНТКЛИМАТ-СК</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8; /* Светло-серый фон */
        }
        .card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 800px;
            margin: 50px auto;
            text-align: center;
        }
        .title {
            color: #2c3e50; /* Темно-синий */
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .subtitle {
            color: #34495e; /* Средне-синий */
            font-size: 1.25rem;
            margin-bottom: 30px;
        }
        .service-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
            margin-bottom: 40px;
            text-align: left;
        }
        .service-item {
            background-color: #ecf0f1; /* Очень светло-серый */
            border-radius: 8px;
            padding: 20px;
            transition: transform 0.2s ease-in-out;
        }
        .service-item:hover {
            transform: translateY(-5px);
        }
        .service-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 1.1rem;
            margin-bottom: 8px;
        }
        .service-price {
            font-weight: 500;
            color: #27ae60; /* Зеленый */
            font-size: 1rem;
        }
        .register-button { /* Изменено название класса */
            display: inline-block;
            background-color: #3498db; /* Синий */
            color: white;
            padding: 15px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 600;
            transition: background-color 0.3s ease-in-out, transform 0.1s ease-in-out;
        }
        .register-button:hover { /* Изменено название класса */
            background-color: #2980b9; /* Темно-синий при наведении */
            transform: translateY(-2px);
        }
        .footer-text {
            margin-top: 30px;
            color: #7f8c8d; /* Серый */
            font-size: 0.9rem;
        }
    </style>
</head>
<body class="antialiased">
    <div class="card">
        <h1 class="title">ВЕНТКЛИМАТ-СК</h1>
        <p class="subtitle">Ваш надежный партнер в сфере климатического оборудования и услуг.</p>

        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Наши услуги:</h2>

        @if($services->isEmpty())
            <p class="text-gray-600">В настоящее время доступных услуг нет. Пожалуйста, свяжитесь с нами для получения дополнительной информации.</p>
        @else
            <div class="service-list">
                @foreach($services as $service)
                    <div class="service-item">
                        <div class="service-name">{{ $service->name }}</div>
                        <div class="service-price">{{ number_format($service->price, 2, ',', ' ') }} ₽</div>
                        @if($service->description)
                            <p class="text-gray-600 text-sm mt-2">{{ Str::limit($service->description, 100) }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <a href="{{ route('register') }}" class="register-button">Зарегистрироваться</a> {{-- Изменено: ссылка на регистрацию --}}

        <p class="footer-text">Для оформления заказов и отслеживания статуса, пожалуйста, зарегистрируйтесь или войдите в систему.</p>
        <p class="footer-text mt-2">Уже зарегистрированы? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Войти</a></p> {{-- Добавлена ссылка на вход --}}
    </div>
</body>
</html>