<?php
require(ROOT . 'Config/firebase.php');

class FirebaseAdmin
{

    public function checkUserValidity($token)
    {
        try {
            $verifiedIdToken = Firebase::getAuth()->verifyIdToken($token);
            $uid = $verifiedIdToken->claims()->get('sub');
            return $uid;
        } catch (Exception $e) {
            return false;
        }
    }

    public function sendNotifications($token)
    {
        try {
            $verifiedIdToken = Firebase::getAuth()->verifyIdToken($token);
            $uid = $verifiedIdToken->claims()->get('sub');
            return $uid;
        } catch (Exception $e) {
            return false;
        }
    }
}
