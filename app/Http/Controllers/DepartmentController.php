<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    //
    public function index(){

        
        $departments=Department::paginate(5);

        return view('admin.department.index',compact('departments'));
    }

    public function store(Request $request){
        $request->validate([
            'department_name'=>'required|unique:departments|max:255'
        ],
        ['department_name.required'=>"กรุณาป้อนชื่อแผนกด้วย",
        'department_name.max'=>"ห้ามป้อนเกิน 255 ตัวอักษร",
        'department_name.unique'=>"มีข้อมูลชื่อแผนกในฐานข้อมูลแล้ว"
        ]);
        //dd($request->department_name);


        /*
        $department = new Department;
        $department->department_name = $request->department_name;
        $department->user_id = Auth::user()->id;
        $department->save();
        */

        $data = array();
        $data["department_name"] = $request->department_name;
        $data["user_id"] = Auth::user()->id;


        //query builder
        DB::table('departments')->insert($data);

        return redirect()->back()->with('success','บันทึกข้อมูลเรียบร้อย');
    }
    public function edit($id){
        //dd($id);
        $department = Department::find($id);
        return view('admin.department.edit',compact('department'));
        //dd($department->department_name);
    }
    public function update(Request $request,$id){
        //dd($id,$request->department_name);
        $request->validate([
            'department_name'=>'required|unique:departments|max:255'
        ],
        ['department_name.required'=>"กรุณาป้อนชื่อแผนกด้วย",
        'department_name.max'=>"ห้ามป้อนเกิน 255 ตัวอักษร",
        'department_name.unique'=>"มีข้อมูลชื่อแผนกในฐานข้อมูลแล้ว"
        ]);

        $update = Department::find($id)->update([
            'department_name'=>$request->department_name,
            'user_id'=>Auth::user()->id
        ]);

        return redirect()->route('department')->with('success','บันทึกข้อมูลเรียบร้อย');
    }
    public function softdelete($id){
        //dd($id);
        $delete = Department::find($id)->delete();

        return redirect()->back()->with('success','ลบข้อมูลเรียบร้อย');
    }
}
