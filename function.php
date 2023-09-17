<?php 

function getStatusMessage($statusCode=0){
    $status = [
        '0' => '',
        '1' => 'User not found',
        '2' => 'Please fill all the fields',
        '3' => 'Username Passwords didn\'t match',
        '4' => 'User already exists',
        '5' => 'User created successfully',
        '6' => 'Profile photo upload failed',
    ];
    return $status[$statusCode];

}