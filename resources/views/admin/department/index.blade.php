<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            สวัสดี {{Auth::user()->name}}
           

           
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            
            <div class="row">
               <div class="col-md-8">
                   @if(session("success"))
                       
                        <div class="alert alert-success">{{session('success')}}</div>
                   @endif
                    <div class="card m-3">
                       <div class="card-header text-white bg-primary">ตารางข้อมูลแผนก</div>

                       <table class="table table-bordered ">
                        <thead>
                            <tr>
                            <th scope="col">ลำดับ</th>
                            <th scope="col">ชื่อแผนก</th>
                            <th scope="col">UserID</th>    
                            <th scope="col">Created_at</th>       
                            <th scope="col">Edit</th>              
                            <th scope="col">Delete</th>                  
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($departments as $row)
                            <tr>
                            <th>{{$departments->firstItem()+$loop->index}}</th>
                            <td>{{$row->user->name}}</td>
                            <td>{{$row->name}}</td>
                            <td>
                                @if($row->created_at == NULL)
                                    ไม่ถูกนิยาม
                                @else
                                     {{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
                                @endif                                
                            </td>
                            <td>
                                <a href="{{url('/department/edit/'.$row->id)}}" class="btn btn-primary">แก้ไข</a>
                            </td>
                            <td>
                                <a href="{{url('/department/softdelete/'.$row->id)}}" class="btn btn-warning">ลบข้อมูล</a>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>

                        {{$departments->appends(['trashDepartments' => $trashDepartments->currentPage()])->links()}}

                    </div>


                    @if(count($trashDepartments)>0)
                     <!-- table 2 -->

                     <div class="card m-3">
                       <div class="card-header text-white bg-primary">ถังขยะ</div>

                       <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">ลำดับ</th>
                            <th scope="col">ชื่อแผนก</th>
                            <th scope="col">UserID</th>    
                            <th scope="col">Created_at</th>       
                            <th scope="col">กู้คืนข้อมูล</th>              
                            <th scope="col">ลบถาวร</th>                  
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($trashDepartments as $row)
                            <tr>
                            <th>{{$trashDepartments->firstItem()+$loop->index}}</th>
                            <td>{{$row->department_name}}</td>
                            <td>{{$row->user->name}}</td>
                            <td>
                                @if($row->created_at == NULL)
                                    ไม่ถูกนิยาม
                                @else
                                     {{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
                                @endif                                
                            </td>
                            <td>
                                <a href="{{url('/department/restore/'.$row->id)}}" class="btn btn-primary">กู้คืนข้อมูล</a>
                            </td>
                            <td>
                                <a href="{{url('/department/delete/'.$row->id)}}" class="btn btn-danger">ลบข้อมูลถาวร</a>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                        {{$trashDepartments->appends(['departments' => $departments->currentPage()])->links()}}
                        
                     

                    </div>
                    <!-- table 2 -->
                    @endif
                   
                                     
               </div>
               <div class="col-md-4">
               <div class="card">
                       <div class="card-header">แบบฟอร์ม</div>
                       <div class="card-body">
                           <form action="{{route('addDepartment')}}" method="post">
                               @csrf
                               <div class="form-group">
                                <label for="department_name">ชื่อแผนก</label>
                                <input type="text" class="form-control" name="department_name" id="department_name">
                               </div>
                              
                               @error('department_name')
                                <div class="my-2">
                                    <span class="text-danger">{{$message}}</span>
                                </div>
                               @enderror
                               <br>                               
                               <input type="submit" value="บันทึก" class="btn btn-primary">
                           </form>
                       </div>
                    </div>         
                   
               </div>
            </div>
        </div>
    </div>
</x-app-layout>
