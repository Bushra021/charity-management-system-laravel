<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;

class AreaController extends Controller
{


    public function areas()
    {
        return view('area.area', ['areas' => Area::all()]);
    }

    public function delete($id)
    {
        Area::find($id)->delete();
        return "تم الحذف بنجاح! ";/*غيرتها للعربي*/
    }

    public function add(Request $request)
    {
        $Data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);
        $area = Area::create($Data);
        return $area;

    }

    public function edit(Request $request, $id)
    {
        $Data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        $area = Area::find($id);
        $area->update($Data);

        return $area;
    }
}
