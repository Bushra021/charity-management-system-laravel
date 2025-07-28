<?php

namespace App\Http\Controllers;
use App\Models\DisabilityCause;
use Illuminate\Http\Request;

class DisabilityCauseController extends Controller
{

    public function disabilitycauses()
    {
        return view('disability cause.disability cause', ['disability_causes' => DisabilityCause::all()]);
    }

    public function delete($id)
    {
        DisabilityCause::find($id)->delete();
        return "done ";
    }

    public function add(Request $request)
    {
        $Data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $disability_cause = DisabilityCause::create($Data);
        return $disability_cause;

    }


    public function edit(Request $request, $id)
    {
        $Data = $request->validate([
            'name' => 'required|string|max:255',

        ]);

        $disability_cause = DisabilityCause::find($id);
        $disability_cause->update($Data);

        return $disability_cause;
    }

}
