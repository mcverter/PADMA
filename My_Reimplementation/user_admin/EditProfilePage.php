<?php

$countryWidget;

class EditProfilePage {

    function getMyProfile($userid) {
        selectProfileInfo($userid);
    }

    function exec_profile_update($title, $lname, $fname, $mname,
                                 $address1, $address2, $city, $state, $zip, $country,
                                 $phone, $email, $industry, $profession, $userid) {
        updateUserProfile($title, $lname, $fname, $mname,
            $address1, $address2, $city, $state, $zip, $country,
            $phone, $email, $industry, $profession, $userid);
    }
} 