<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserCourseMapping;
use App\Models\UserFieldMapping;
use App\Models\UserStudyDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;


class UserController extends Controller
{

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->guard('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    public function info(Request $request) {
        return response()->json(auth()->user());
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $data = $request->all();
        Log::info($data);
        $data['mobile_no'] = data_get($data, 'mobile');
        unset($data['mobile']);
        $validator = Validator::make($data, [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'mobile_no' => 'required|min:10|max:15|unique:users'
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            $errors = arrayToString($errors);
            return response()->json(['errors' => $errors], 400);
        }
        $user = User::create(array_merge(
            $data,
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 200);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ], 200);
    }

    public function checkMobile(Request $request) {
        $mobile_no = $request->get('mobile');
        if($mobile_no) {
            $user = User::where('mobile_no', $mobile_no)->first();
            $user->mobile_otp = 123456;
            $user->save();
            return response()->json([
                'mobile_otp' => $user->mobile_otp
            ], 200);
        }
        return response()->json(['errors' => "Given mobile not registerd please signup first.", 'req' => $request->all(), 'mobile_no' =>$mobile_no], 400);
    }

    public function verifyMobileOtp(Request $request) {
        $mobile_no = $request->get('mobile');
        $mobile_otp = $request->get('mobile_otp');
        $user = User::where('mobile_no', $mobile_no)->first();
        if($user && $user->mobile_otp == $mobile_otp) {
            $token = auth()->guard('api')->fromUser($user);
            return $this->createNewToken($token);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function userDetails() {
        $user = auth()->user();
        $user_field_mappings = UserFieldMapping::where('user_id', $user->id)->get();
        $user_study_details = UserStudyDetails::where('user_id', $user->id)->first();
        $user_course_details = UserCourseMapping::where('user_id', $user->id)->count();
        return response()->json([
            'user' => $user,
            'user_field_mappings' => count($user_field_mappings) ? $user_field_mappings : null,
            'user_study_details' => $user_study_details,
            'user_course_details' => $user_course_details
        ], 200);
    }

    public function saveStudyDetails(Request $request) {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        UserStudyDetails::create($data);
        return response()->json(['msg' => 'saved'], 200);
    }

}