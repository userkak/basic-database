<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Carbon\carbon;

class ServiceController extends Controller
{
    //
    public function index(){

        
        $services=Service::paginate(5);
      

        return view('admin.service.index',compact('services'));
    }
    public function edit($id){
        //dd($id);
        $service = Service::find($id);
        return view('admin.service.edit',compact('service'));
        //dd($department->department_name);
    }


    public function update(Request $request,$id){
        $request->validate([
            'service_name'=>'required|max:255',
            //'service_image'=>'mimes:jpg,jpeg,png'
        ],
        [
            'service_name.required'=>"กรุณาป้อนชื่อบริการด้วย",
            'service_name.max'=>"ห้ามป้อนเกิน 255 ตัวอักษร",
        ]
        );
         

        //การเข้ารหัสรูปภาพ
         $service_image = $request->file('service_image');

         //อัพเดตภาพและชื่อ

         if($service_image){
                //generate picture
                $name_gen=hexdec(uniqid());

                //ดึงนามสกุลไฟล์ภาพ
                $img_ext = strtolower($service_image->getClientOriginalExtension());
                
                $img_name = $name_gen.'.'.$img_ext;
                
                
                //อัพโหลดและอัพเดตข้อมูล
                $upload_location = 'image/services/';
                $full_path = $upload_location.$img_name;
                //dd($full_path);

               
                //อัพเดตข้อมูล
                Service::find($id)->update([
                    'service_name'=>$request->service_name,
                    'service_image'=>$full_path,
                    
                ]);

                 //ลบภาพเก่าและอัพภาพใหม่แทนที่
                 $old_image = $request->old_image;
                 unlink($old_image);
                 $service_image->move($upload_location,$img_name);

                
                return redirect()->route('services')->with('success','อัพเดตภาพเรียบร้อย');
         }else{
             //อัพเดตชื่ออย่างเดียว
             Service::find($id)->update([
                'service_name'=>$request->service_name,
               
                
            ]);
            return redirect()->route('services')->with('success','อัพเดตชื่อบริการเรียบร้อย');
         }
         

         
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


    //การเข้ารหัสรูปภาพ
    $service_image = $request->file('service_image');

    //generate picture
    $name_gen=hexdec(uniqid());

    //ดึงนามสกุลไฟล์ภาพ
    $img_ext = strtolower($service_image->getClientOriginalExtension());
    
    $img_name = $name_gen.'.'.$img_ext;
    
    
    //อัพโหลดและบันทึกข้อมูล
    $upload_location = 'image/services/';
    $full_path = $upload_location.$img_name;
    //dd($full_path);

    //ทดลองอัพโหลด
    Service::insert([
        'service_name'=>$request->service_name,
        'service_image'=>$full_path,
        'created_at'=>Carbon::now()
    ]);
    $service_image->move($upload_location,$img_name);

    return redirect()->back()->with('success','บันทึกข้อมูลเรียบร้อย');
    }
}
