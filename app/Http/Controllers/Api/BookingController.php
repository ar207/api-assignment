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
            if ($input['user_id'] != $input['doctor_id']) {
                $isAppointment = true;
                $this->message = 'Doctor is not available';
                $timeSlot = DoctorTimeSlot::where('user_id', $input['doctor_id'])->get()->toArray();
                if (!empty($timeSlot)) {
                    $bookingDate = databaseDateFormat($input['booking_date']);
                    $objBooking = BookingSlot::where('doctor_id', $input['doctor_id'])->get()->toArray();
                    $userBooking = BookingSlot::where('doctor_id', $input['doctor_id'])->where('user_id', $userId)->orderBy('id', 'desc')->first();
                    foreach ($timeSlot as $key => $row) {
                        if ($row['from'] >= $input['booking_from'] && $row['to'] >= $input['booking_to'] && $row['date'] == $bookingDate) {
                            if (!empty($objBooking)) {
                                foreach ($objBooking as $ind => $item) {
                                    if ($item['booking_from'] >= $input['booking_from'] && $item['booking_to'] >= $input['booking_to'] && $item['booking_date'] == $bookingDate) {
                                        $this->message = 'Doctor is not available';
                                        $isAppointment = false;
                                    } else {
                                        if (!empty($userBooking)) {
                                            $startDate = new DateTime();
                                            $sinceStart = $startDate->diff(new DateTime($userBooking->created_at));
                                            if ($sinceStart->i > 15) {
                                                $isAppointment = true;
                                            }
                                        }
                                    }
                                }
                            } else {
                                $isAppointment = true;
                            }
                        } else {
                            $isAppointment = false;
                        }
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
