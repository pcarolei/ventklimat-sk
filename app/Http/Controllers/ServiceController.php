<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Отображает список всех услуг.
     */
    public function index()
    {
        $services = Service::latest()->get(); // Получаем все услуги, отсортированные по дате создания
        return view('services.index', compact('services'));
    }

    /**
     * Показывает форму для создания новой услуги.
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Сохраняет новую услугу в базе данных.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
        ]);

        Service::create($request->all());

        return redirect()->route('services.index')->with('success', 'Услуга успешно создана!');
    }

    /**
     * Отображает детали конкретной услуги (опционально, но полезно).
     */
    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    /**
     * Показывает форму для редактирования существующей услуги.
     */
    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Обновляет существующую услугу в базе данных.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
        ]);

        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Услуга успешно обновлена!');
    }

    /**
     * Удаляет услугу из базы данных.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Услуга успешно удалена!');
    }
}