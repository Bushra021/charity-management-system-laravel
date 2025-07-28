<?php
namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function services()
    {
        $services = Service::with('user')->get();
        $users = User::where('role', 'employee_services')->get();

        return view('service.service', compact('services', 'users'));
    }

    public function delete($id)
    {
        Service::findOrFail($id)->delete();
        return "done";
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $data['is_active'] = true; // افتراضيًا مفعّلة

        $service = Service::create($data);
        $service->user_name = $service->user->name ?? '---';

        return $service;
    }

    public function edit(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $service = Service::findOrFail($id);
        $service->update($data);
        $service->user_name = $service->user->name ?? '---';

        return $service;
    }

    public function toggleActive($id)
    {
        $service = Service::findOrFail($id);
        $service->is_active = !$service->is_active;
        $service->save();

        return response()->json(['active' => $service->is_active]);
    }

}
