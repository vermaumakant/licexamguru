<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Field;
use App\Models\Level;
use App\Models\UserFieldMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use File;
class FieldController extends Controller
{
    public function index() {
        $fields = Field::leftJoin('admins', 'fields.created_by', 'admins.id')
            ->select(
                "fields.*",
                "admins.name"
            )
            ->get()->toArray();
        foreach ($fields as $key => $field) {
            $fields[$key]['levels'] = Level::where('field_id', $field['id'])->pluck('level_name');
            $fields[$key]['categories'] = Category::where('field_id', $field['id'])->pluck('category_name');
            $fields[$key]['add_level'] = false;
            $fields[$key]['add_category'] = false;
        }
        return response()->json(['fields' => $fields]);
    }

    public function saveField(Request $request) {
        $data = [
            "field_name" => $request->get('field_name'),
            "description" => $request->get('description'),
            'created_by' => auth()->user()->id
        ];
        $id = $request->get('id');
        $icon = $request->get('icon');
        if($icon) {
            $data['icon'] = $icon;
        }
        // if($request->get('icon')) {
        //     $origin_path = storage_path('app/'.$icon);
        //     if(file_exists($origin_path)) {
        //         $ext = pathinfo(storage_path('app/'.$icon), PATHINFO_EXTENSION);
        //         $icon = 'field-images/'.str_replace(" ", "_", $data['field_name']).'-'.auth()->user()->id.time().".".$ext;
        //         $destination_path = public_path($icon);
        //         File::move($origin_path, $destination_path);
        //         $data['icon'] = $icon;
        //     }
        // }
        if(!$id) {
            $field = Field::create($data);
            Level::createDefault($field->id);
        }
        if($id) {
            Field::where('id', $id)->update($data);
        }
        return response()->json(['message' => 'success']);
    }

    public function addlevel(Request $request) {
        $data = $request->all();
        Level::insert($data);
        return response()->json(['message' => 'success']);
    }

    public function addCategoty(Request $request) {
        $data = $request->all();
        Category::insert($data);
        return response()->json(['message' => 'success']);
    }
    public function lebels($field_id) {
        $lebels = Level::where('field_id', $field_id)->get();
        $categories = Category::where('field_id', $field_id)->get();
        return response()->json(['lebels' => $lebels, 'categories' =>$categories]);
    }

    public function categories($field_id) {
        $categories = Category::where('field_id', $field_id)->get();
        return response()->json(['categories' => $categories]);
    }

    public function getFields() {
        $fields = Field::select('id','field_name', 'icon')->get()->toArray();
        $user = auth()->user();
        foreach ($fields as $key => $field) {
            $is_user_selected=  UserFieldMapping::where('user_id', $user->id)->count();
            $fields[$key]['selected'] = $is_user_selected > 0;
        }
        //$user_field = UserFieldMapping::where('user_id', $user->id)->get();
        return response()->json(['fields' => $fields], 200);
    }

    public function saveUserField(Request $request) {
        $field_id = $request->get('field_id');
        $selected = $request->get('selected');
        $user = auth()->user();
        $mapping= UserFieldMapping::where('user_id', $user->id)->where('field_id', $field_id)->withTrashed()->first();
        if ($mapping) {
            if($selected == 'true' || $selected == true) {
                $mapping->restore();
            }
            if($selected == 'false' || $selected == false) {
                $mapping->delete();
            }
        }
        if (!$mapping ) {
            $mapping = UserFieldMapping::create(['user_id' => $user->id, 'field_id' => $field_id]);
            $mapping->save();
        }
        return response()->json(['msg' =>"Saved"], 200);
    }
}
