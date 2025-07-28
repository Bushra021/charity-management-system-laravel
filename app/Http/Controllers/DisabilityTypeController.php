<?php

namespace App\Http\Controllers;

use App\Models\DisabilityType;
use Illuminate\Http\Request;

class DisabilityTypeController extends Controller
{

    public function disabilitytypes()
    {
        return view('disability type.disability type', ['disability_types' => DisabilityType::all()]);
    }

    public function delete($id)
    {
        DisabilityType::find($id)->delete();
        return "done ";
    }

    public function add(Request $request)
    {
        $Data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $disability_type = DisabilityType::create($Data);
        return $disability_type;

    }


    public function edit(Request $request, $id)
    {
        $Data = $request->validate([
            'name' => 'required|string|max:255',

        ]);

        $disability_type = DisabilityType::find($id);
        $disability_type->update($Data);

        return $disability_type;
    }

}
