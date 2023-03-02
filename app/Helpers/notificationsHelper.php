<?php
if (!function_exists('InsertNotification')) {
    function InsertNotification($message, $alert)
    {
        $notification = array(
            'message' => $message,
            'alert-type' => $alert
        );
        return $notification;
    }
}
