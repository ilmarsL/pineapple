<?php
//model

class Subs extends Dbh {

    /**
     * Counts and returns all email providers in an array
     */
    private function countProviders($subscriptions){
        $uniqueProviders = [];
        foreach ($subscriptions as $sub){
            $domain = explode('@', $sub['email']);
            $domain = explode('.', $domain[1]);
            $domain = $domain[0];
            
            if (!in_array($domain, $uniqueProviders)){
                array_push($uniqueProviders,$domain);
            }
        }
        return $uniqueProviders;
    }

    /**
     * Returns all subscriptions from the database
     */
    protected function getAllSubscriptions($sortBy = 'date') {
        if ($sortBy === 'name'){
            $sql = "SELECT * FROM subscriptions ORDER BY email";
        }
        else {
            $sql = "SELECT * FROM subscriptions ORDER BY subscribe_date DESC";
        }
        
        $stmt = $this->connect()->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $providers = $this->countProviders($result);
        $arr = array(
            'subscriptions' => $result,
            'providers' => $providers
        );
        return $arr;
    }

    /**
     * Get selected subscriptions (used for search)
     */
    protected function getSelectedSubscriptions($sortBy = 'date', $searchTerm = '') {
        if ($sortBy === 'name'){
            $sth = $this->connect()->prepare('SELECT * FROM subscriptions WHERE email = ? ORDER BY email');
        }
        else {
            $sth = $this->connect()->prepare('SELECT * FROM subscriptions WHERE email = ? ORDER BY subscribe_date DESC');
        }
        $sth->execute(array($searchTerm));
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $providers = $this->countProviders($result);
        $arr = array(
            'subscriptions' => $result,
            'providers' => $providers
        );
        return $arr;
    }  
    
    /**
     * Save subscription to database
     */
    protected function setSubscription($email, $tosAccepted, $subDate) {
        //validate data
        if ($email == ''){
            return "Email address is required.";
        }
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Please provide a valid e-mail address.";
        }
        else if(!$tosAccepted){
            return "You must accept the terms and conditions.";
        }
        else if(substr($email, -strlen('.co'))==='.co'){
            return "We are not accepting subscriptions from Colombia emails.";
        }

        $sql = "INSERT INTO subscriptions(email, subscribe_date) VALUES (?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $result = $stmt->execute([$email, $subDate]);
        return $result;
    }
    
    protected function deleteSubscriptionFromDB($id) {
        $sql = "DELETE FROM subscriptions WHERE id = :id";
        $sth = $this->connect()->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
    }
}