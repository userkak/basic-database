<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    //
    public function index(){

        
        $services=Service::paginate(5);
      

        return view('admin.service.index',compact('services'));
    }
    public function store(Request $request){
        $request->validate([
            'service_name'=>'required|unique:services|max:255',
            'service_image'=>'required|mimes:jpg,jpeg,png'
        ],
        ['service_name.required'=>"กรุณาป้อนชื่อบริการด้วย",
        'service_name.max'=>"ห้ามป้อนเกิน 255 ตัวอักษร",
        'service_name.unique'=>"มีข้อมูลชื่อบริการในฐานข้อมูลแล้ว",
        'service_image.required'=>"กรุณาใส่ภาพประกอบบริการ",
        ]
    );


    
/*
        $data = array();
        $data["department_name"] = $request->department_name;
        $data["user_id"] = Auth::user()->id;


        DB::table('departments')->insert($data);

        return redirect()->back()->with('success','บันทึกข้อมูลเรียบร้อย');*/
    }
}
