<?php
define('MobileUserImagePath', 'user/profile');

/**
 * This is used to get current date time
 *
 * @return string
 */
function currentDateTime()
{
    $time = \Carbon\Carbon::now();

    return $time->toDateTimeString();
}

/**
 * This function returns unique image name
 *
 * @param $extension
 * @return string
 */
function createImageUniqueName($extension)
{
    $uniqueId = time() . uniqid(rand());
    $imageName = $uniqueId . '.' . $extension;

    return $imageName;
}

/**
 * This function returns login user id
 *
 * @return mixed
 */
function loginId()
{
    $id = 0;
    if (\Auth::check()) {
        $id = \Auth::user()->id;
    }

    return $id;
}

/**
 * This is used to check user is admin or not
 *
 * @param string $user
 * @return bool
 */
function isAdmin()
{
    $isAdmin = false;
    if (\Auth::check()) {
        $userType = \Auth::user()->user_type;
        if ($userType == 0) {
            $isAdmin = true;
        }
    }

    return $isAdmin;
}

/**
 * This is used to check user is admin or not
 *
 * @param string $user
 * @return bool
 */
function isDoctor()
{
    $isDoctor = false;
    if (\Auth::check()) {
        $userType = \Auth::user()->user_type;
        if ($userType == 1) {
            $isDoctor = true;
        }
    }

    return $isDoctor;
}

function databaseDateFormat($date)
{
    return date_format(new \DateTime($date), 'Y-m-d');
}

/**
 * This is used to changed date picker to date time
 *
 * @param $date
 * @return false|string
 */
function databaseDateTimeFormat($date)
{
    return date_format(new \DateTime($date), 'Y-m-d h:i');
}

/**
 * This is used to changed date picker to date time
 *
 * @param $date
 * @return false|string
 */
function timeFormat($date)
{
    return date_format(new \DateTime($date), 'h:i');
}

/**
 * This is used to format errors
 *
 * @param $data
 *     array:2 [
 * "email" => array:1 [
 * 0 => "The email has already been taken."
 * ]
 * "mobile_number" => array:1 [
 * 0 => "The mobile number has already been taken."
 * ]
 * ]
 * @return array
 *
 * array:2 [
 * 0 => "The email has already been taken."
 * 1 => "The mobile number has already been taken."
 * ]
 */
function formatErrors($data)
{
    $errors = [];
    if (!empty($data)) {
        foreach ($data as $row) {
            if ($row) {
                foreach ($row as $value) {
                    $errors[] = $value;
                }
            }
        }
    }

    return $errors;
}
