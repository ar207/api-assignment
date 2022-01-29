<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BookingSlot;
use App\Models\DoctorTimeSlot;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private $success = false;
    private $message = '';
    private $data = [];

    /**
     * This is used to create booking
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createBooking(Request $request)
    {
        $input = $request->all();
        $validator = \Validator::make($input, [
            'booking_from' => ['required'],
            'booking_to' => ['required'],
            'booking_date' => ['required'],
            'user_id' => ['required'],
            'doctor_id' => ['required'],
        ]);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $userId = loginId();
            $arr = [];
            if ($input['user_id'] != $input['doctor_id']) {
                $isAppointment = false;
                $this->message = 'Doctor is not available';
                $timeSlots = DoctorTimeSlot::where('user_id', $input['doctor_id'])->get()->toArray();
                if (!empty($timeSlots)) {
                    $bookingDate = databaseDateFormat($input['booking_date']);
                    $objBooking = BookingSlot::where('doctor_id', $input['doctor_id'])->get()->toArray();
                    foreach ($timeSlots as $key => $row) {
                        if ($row['from'] <= $input['booking_from'] && $row['to'] >= $input['booking_to'] && $row['date'] == $bookingDate) {
                            if (!empty($objBooking)) {
                                foreach ($objBooking as $ind => $item) {
                                    $arr['booking_to'] = $item['booking_to'];
                                }
                            } else {
                                $isAppointment = true;
                            }
                        }
                    }
                    if (in_array($input['booking_from'], $arr)) {
                        $isAppointment = true;
                    }

                    if ($isAppointment == true) {
                        $obj = new BookingSlot();
                        $obj->user_id = loginId();
                        $obj->doctor_id = $input['doctor_id'];
                        $obj->booking_from = $input['booking_from'];
                        $obj->booking_to = $input['booking_to'];
                        $obj->booking_date = databaseDateFormat($input['booking_date']);
                        $obj->save();
                        $this->success = true;
                        $this->message = 'Doctor appointed successfully';
                    }
                }
            }
        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }
}
