<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Patient;
use App\Models\Tool;
use Illuminate\Http\Request;

class PatientAssistiveToolController extends Controller
{
    public function create()
    {
        $patient=Patient::where('user_id', auth()->id())->first();
        $attachment=Attachment::where('patient_id', $patient->id)
            ->where('needed', 1)
            ->whereNull('source')
            ->join('tools', 'attachments.tool_id', '=', 'tools.id')
            ->select(
                'attachments.id',
                'tools.price as price',
                'attachments.tool_id',
                'tools.name as tool_name',
            )->get();

        $excludedIds = $attachment->pluck('tool_id')->toArray();
        $attachmentreqsted = Tool::whereNotIn('id', $excludedIds)->get();


        $attachmentpaid=Attachment::where('patient_id', $patient->id)
            ->join('tools', 'attachments.tool_id', '=', 'tools.id')
            ->whereNotNull('source')
            ->select(
                'attachments.id',
                'attachments.price as attachments_price',
                'attachments.source as source',
                'tools.price as price',
                'tools.name as tool_name',
            )
            ->get();
        return view('assistive tool.tool', compact('attachment','attachmentpaid','attachmentreqsted'))->with('tools', Tool::all());

    }

    public function store(Request $request)
    {
        //dd($request->all());
        // تحقق من صحة البيانات
        $request->validate([
            'tools' => 'required|array',
            'tools.*.received' => 'nullable|boolean',
            'tools.*.needed' => 'nullable|boolean',

        ]);

        $patientId = Patient::where('user_id', auth()->id())->value('id');
        foreach ($request->tools as $toolId => $data) {
            // Laravel يرسل القيمة الأخيرة لو فيه hidden + checkbox بنفس الاسم، فيصير الناتج "1" فقط لو كان محدد
            $received = !empty($data['received']) ? 1 : 0;
            $needed = !empty($data['needed']) ? 1 : 0;

            Attachment::create([
                'patient_id' => $patientId,
                'tool_id' => $toolId,
                'received' => $received,
                'needed' => $needed,
            ]);

        }

        return redirect()->route('assistive tool.create');
    }

    public function destroy($id)
    {
        $attachment = Attachment::findOrFail($id);
        $attachment->delete();

        return redirect()->back()->with('success', 'تم حذف طلب الاداة بنجاح.');

    }



    public function exemption(){

        $data = Attachment::where('needed', 1)
            ->join('tools', 'attachments.tool_id', '=', 'tools.id')
            ->join('patients', 'attachments.patient_id', '=', 'patients.id')
            ->whereNull('source')
            ->select(
                'attachments.id',
                'attachments.price as attachments_price',
                'attachments.source as source',
                'attachments.exemption_value as exemption_value',
                'tools.price as price',
                'tools.name as tool_name',
                'patients.name as patient_name'
            )
            ->get();


        return view('tool.exemption2',compact('data'));
    }
    public function exemption2(){

        $data = Attachment::where('needed', 1)
            ->join('tools', 'attachments.tool_id', '=', 'tools.id')
            ->join('patients', 'attachments.patient_id', '=', 'patients.id')
            ->whereNotNull('source')
            ->select(
                'attachments.id',
                'attachments.price as attachments_price',
                'attachments.source as source',
                'attachments.exemption_value as exemption_value',
                'tools.price as price',
                'tools.name as tool_name',
                'patients.name as patient_name'
            )
            ->get();


        return view('tool.exemption',compact('data'));
    }

    public function source(Request $request,$id){

        $validatedData = $request->validate([
            'source' => 'required|in:مساهمة,اعفاء,مجانا',
            'price' => 'nullable|numeric|min:0',

        ],[
            'price'
        ]);

        $attachments = Attachment::findOrFail($id);

        $attachments->update($validatedData);

        return redirect()->route('employee');
    }


}
