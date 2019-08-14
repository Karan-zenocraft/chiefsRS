<?php

return [
    //  'bsVersion' => '4.x',
    'bsDependencyEnabled' => 'false',
    'adminEmail' => 'testingforproject0@gmail.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'site_url' => stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' . $_SERVER['HTTP_HOST'] : 'http://' . $_SERVER['HTTP_HOST'],
    'root_url' => stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' . $_SERVER['HTTP_HOST'] : 'http://' . $_SERVER['HTTP_HOST'] . "/chiefsRS/",
    'login_url' => '/chiefsRS/backend/web/login',
    'frontend_login_url' => '/chiefsRS/frontend/web/login',
    'userroles' => [
        'super_admin' => '1',
        'admin' => '2',
        'manager' => '3',
        'supervisor' => '4',
        'customer' => '5',
        'walk_in' => '6',
    ],
    //get user rolename
    'userrole_name' => ['1' => 'Super Admin', '2' => 'Admin', '3' => 'Manager', '4' => 'SuperVisor', '5' => 'Customer', "6" => "Walk In"],
    'user_status' => array('1' => 'Active', '0' => 'In-Active'),
    'user_status_value' => array('active' => '1', 'in_active' => '0'),
    'status' => array('1' => 'Active', '0' => 'In-Active'),
    'super_admin_role_id' => '1',
    'administrator_role_id' => '2',
    'meal_times' => ['1' => 'BreakFast', '2' => "Lunch", "3" => "Dinner"],
    'week_days' => ["1" => "Sunday", "2" => "Monday", "3" => "Tuesday", "4" => "Wednesday", "5" => "Thursday", "6" => "Friday", "7" => "Saturday"],
    'restaurants_working_hours_status' => ["1" => "Open", "0" => "Closed"],

    'MonthsDropDown' => array('1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'),
    'upload_path' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '../../frontend/web/uploads/',
    'date_format' => "d/m/Y",
    'frontend_url' => "http://chiefsrs.zenocraft.com/",
    'backend_url' => "http://chiefsrs.zenocraft.com/admin/",
    'cmsAdminEmail' => 'rutusha.joshi@zenocraft.com',
    'base_path' => __DIR__,
    'reservation_status' => ["0" => "requested", "1" => "Booked", "2" => "Cancelled", "3" => "Deleted", "4" => "Completed", "5" => "Seated"],
    'reservation_status_value' => ["requested" => "0", "booked" => "1", "cancelled" => "2", "deleted" => "3", "completed" => "4", "seated" => "5"],
    'pickup_drop_status' => ['1' => 'Yes', '0' => 'No'],
    'timezone' => 'Asia/Kolkata',
    'delete_status' => ["yes" => "1", "no" => "0"],
    'delete_status_value' => ["1" => "Yes", "0" => "No"],
    'push_notification_pem_file' => 'apns-dev.pem',

    //  'pickup_drop_status_value' => ['yes'=>'1','no'=>'1'],
];
