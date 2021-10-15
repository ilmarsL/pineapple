<?php
class SubsController extends Subs {
    public function addSubscription($email, $tosAccepted, $subsDate) {
        $result = $this->setSubscription($email, $tosAccepted, $subsDate);
        if($result === TRUE){
            return 'save_success';
        }
        else{
            return $result;
        }        
    }

    public function deleteSubscription($id){
        $this->deleteSubscriptionFromDB($id);
    }
}