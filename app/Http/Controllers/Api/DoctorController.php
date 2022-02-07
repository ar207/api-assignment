<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDoctorRequest;
use App\Http\Requests\DoctorRequest;
use App\Models\BookingSlot;
use App\Models\DoctorSpeciality;
use App\Models\DoctorTimeSlot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use function PHPSTORM_META\elementType;

class DoctorController extends Controller
{
    private $success = false;
    private $message = '';
    private $data = [];

    /**
     * This function is used to get doctor speciality
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDoctorSpeciality()
    {
        $doctorSpeciality = DoctorSpeciality::get()->toArray();
        if (empty($doctorSpeciality)) {
            $doctorSpeciality = [];
        }

        return response()->json(['doctorSpeciality' => $doctorSpeciality]);
    }

    /**
     * This is used to create doctor profile
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateDoctorRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['name'] = $input['first_name'] . ' ' . $input['last_name'];
        $input['user_type'] = 1;
        $input['created_at'] = currentDateTime();
        $input['updated_at'] = currentDateTime();
        $user = User::create($input);
        $token = $user->createToken('MyApp')->accessToken;
        $this->data['token'] = $token;
        $this->data['user_id'] = $user->id;
        $this->data['name'] = $user->name;
        $this->data['email'] = $user->email;
        $this->data['phone'] = $user->phone;
        $this->data['user_type'] = $user->user_type;
        $this->success = true;
        $this->message = 'Doctor created successfully';

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message]);
    }

    /**
     * This is used to get doctor details
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request)
    {
        $userId = loginId();
        $imagePath = asset(MobileUserImagePath);
        if (!empty($userId)) {
            $user = User::find($userId);
            if (!empty($user)) {
                $user->profile_image = !empty($this->data['user']->profile_image) ? $imagePath . '/' . $this->data['user']->profile_image : '';
                $this->data['user'] = $user->toArray();
                $speciality = DoctorSpeciality::find($this->data['user']['speciality_id']);
                if (!empty($speciality)) {
                    $this->data['speciality'] = $speciality->toArray();
                }
                $this->data['timeSlot'] = DoctorTimeSlot::where('user_id', $userId)->get()->toArray();
            }
        }

        return response()->json(['data' => $this->data]);
    }

    /**
     * This is used to update doctor details
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DoctorRequest $request)
    {
        $input = $request->all();
            $userId = loginId();
            if (!empty($userId)) {
                $user = User::find($userId);
                if (!empty($user)) {
                    if (!empty($request->input('image'))) {
                        $image = preg_replace('/^data:image\/\w+;base64,/i', '', $request->input('image'));
                        $image = str_replace(' ', '+', $image);
                        $fileName = createImageUniqueName('jpg');
                        $destinationPath = public_path(MobileUserImagePath);
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0777, true);
                        }
                        $tempFile = $destinationPath . '/' . $fileName;
                        file_put_contents($tempFile, base64_decode($image));
                    }
                    $firstName = $request->input('first_name');
                    $lastName = $request->input('last_name');
                    $name = $firstName . ' ' . $lastName;
                    $user->first_name = (!empty($firstName) ? $firstName : $user->first_name);
                    $user->last_name = (!empty($lastName) ? $lastName : $user->first_name);
                    $user->name = (!empty($name) ? $name : $user->name);
                    $user->password = (!empty($request->input('password')) ? Hash::make($request->input('password')) : $user->password);
                    $user->speciality_id = (!empty($request->input('speciality_id')) ? $request->input('speciality_id') : $user->speciality_id);
                    $user->profile_image = (!empty($fileName) ? $fileName : $user->profile_image);
                    $user->save();

                    DoctorTimeSlot::where('user_id', $userId)->delete();
                    $data = json_decode($request->input('data'),true);
                    foreach ($data['data'] as $key => $row){
                        $timeSlot = new DoctorTimeSlot();
                        $timeSlot->user_id = $userId;
                        $timeSlot->from = !empty($row['from']) ? $row['from'] : '';
                        $timeSlot->to = !empty($row['to']) ? $row['to'] : '';
                        $date = databaseDateFormat($row['date']);
                        $timeSlot->date = !empty($date) ? $date : '';
                        $timeSlot->save();
                        $this->success = true;
                        $this->message = 'Profile updated successfully';
                    }
                }
            }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }

    /**
     * This is used to get doctors by name or speciality
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDoctors(Request $request)
    {
        $specialityName = $request->input('speciality');
        $name = $request->input('name');
        $imagePath = asset(MobileUserImagePath);
        $this->message = 'No doctor found by this name';
        if (!empty($specialityName)) {
            $this->message = 'No doctor found on this speciality';
            $search = '%' . $specialityName . '%';
            $speciality = DoctorSpeciality::where('name', 'like', $search)->first();
            if (!empty($speciality)) {
                $doctor = User::select('id', 'first_name', 'last_name', DB::raw("CONCAT('$imagePath','/',profile_image) as image"))
                    ->where(['user_type' => 1, 'speciality_id' => $speciality->id])
                    ->get()->toArray();
            }
        }
        if (!empty($name)) {
            $search = '%' . $specialityName . '%';
            $doctor = User::select('id', 'first_name', 'last_name', DB::raw("CONCAT('$imagePath','/',profile_image) as image"))
                ->where('user_type', 1)
                ->where('name', 'like', $search)
                ->get()->toArray();
        }
        $timeSlot = DoctorTimeSlot::select('user_id', 'from', 'to', 'date')->get()->toArray();
        $arr = [];
        if (!empty($doctor)) {
            foreach ($doctor as $key => $row) {
                $arr[$key] = $row;
                foreach ($timeSlot as $ind => $item) {
                    if ($item['user_id'] == $row['id']) {
                        $arr[$key]['available_time'][] = $item;
                    }
                }
            }
            $this->success = true;
            $this->message = '';
        }

        return response()->json(['success' => $this->success, 'message' => $this->message, 'data' => $arr]);
    }
}
