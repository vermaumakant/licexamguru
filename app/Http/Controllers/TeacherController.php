<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class TeacherController extends Controller
{
    public function search(Request $request) {
        $q = $request->get('q');
        $teacher = Admin::where('admin_type', 'teacher')
        ->where('name', 'like', "%$q%")
        ->select('name', 'id')
        ->get();
        return response()->json(['teachers' => $teacher]);
    }

    public function index(Request $request) {
        $q = $request->get('q');
        $query = Admin::where('admin_type', 'teacher');
        if($q) {
            $query->where(function ($query) use ($q){
                $query->where('name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('mobile', 'like', "%$q%");
            });
        }
        $request_data = $request->all();
        $teachers = $query->paginate(data_get($request_data, 'per_page', 20));
        return response()->json(['teachers' => $teachers]);
    }

    public function saveTeacher(Request $request) {
        $request_data = $request->all();
        $data = [
            'name' => data_get($request_data, 'name'),
            'email' => data_get($request_data, 'email'),
            'mobile_no' => data_get($request_data, 'mobile_no'),
        ];
        if(data_get($request_data, 'password')) {
            $data['password'] = Hash::make($request_data['password']);
        }
        $id = data_get($request_data, 'id');
        if($id) {
            if(!data_get($request_data, 'password')) {
                unset($data['password']);
            }
            Admin::where('id', $id)->update($data);
        }
        if(!$id) {
            Admin::insert($data);
        }
        return $this->index($request);
    }
}
