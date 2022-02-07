<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
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
    public function createBooking(BookingRequest $request)
    {
        $input = $request->all();
            $starTime = new DateTime($input['booking_from']);
            $endTime = $starTime->diff(new DateTime($input['booking_to']));
            $this->message = 'Appointment time must be at least 15 minutes';
            if ($endTime->i >= 15 || $endTime->h >= 1) {
                if ($input['user_id'] != $input['doctor_id']) {

                    $this->message = 'Doctor is not available';
                    $timeSlots = DoctorTimeSlot::where('user_id', $input['doctor_id'])->get()->toArray();
                    if (!empty($timeSlots)) {
                        $bookingDate = databaseDateFormat($input['booking_date']);
                        foreach ($timeSlots as $key => $row) {
                            if ($row['from'] <= $input['booking_from'] && $row['to'] >= $input['booking_to'] && $row['date'] == $bookingDate) {
                                $objBooking = BookingSlot::where('doctor_id', $input['doctor_id']);
                                $startTime = $input['booking_from'];
                                $endTime = $input['booking_to'];

                                $Availability = $objBooking->where(function ($query) use ($startTime, $endTime) {
                                    $query
                                        ->where(function ($query) use ($startTime, $endTime) {
                                            $query
                                                ->where('booking_from', '<=', $startTime)
                                                ->where('booking_to', '>', $startTime);
                                        })
                                        ->orWhere(function ($query) use ($startTime, $endTime) {
                                            $query
                                                ->where('booking_from', '<', $endTime)
                                                ->where('booking_to', '>=', $endTime);
                                        });
                                })->get()->toArray();

                                if (empty($Availability)) {
                                    $obj = new BookingSlot();
                                    $obj->user_id = loginId();
                                    $obj->doctor_id = $input['doctor_id'];
                                    $obj->booking_from = $input['booking_from'];
                                    $obj->booking_to = $input['booking_to'];
                                    $obj->booking_date = databaseDateFormat($input['booking_date']);
                                    $obj->save();
                                    $this->success = true;
                                    $this->message = 'Doctor appointed successfully';
                                    break;
                                }
                            }else{
                                $this->message = 'Doctor is not available';
                            }
                        }
                    }
                }
            }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }
}
