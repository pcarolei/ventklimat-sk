<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth; // Auth больше не нужен здесь, так как логика перенесена в web.php

class WelcomeController extends Controller
{
    /**
     * Отображает главную страницу-визитку с доступными услугами.
     */
    public function index()
    {
        // Получаем все доступные услуги
        $services = Service::all();

        return view('welcome_card', compact('services'));
    }
}
