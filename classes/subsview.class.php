<?php
class SubsView extends Subs {
    /**
     * Prints selected (or all) subscriptions
     */
    public function showSubscriptions($sortBy, $provider, $searchTerm) {
        if ($searchTerm !== ''){
            //returns only exact mach
            $results = $this->getSelectedSubscriptions($sortBy, $searchTerm);
        }
        else {
            $results = $this->getAllSubscriptions($sortBy);
        }
        foreach ($results['subscriptions'] as $row){
            if ($provider === ''){
                //no provider selected,
                print('<tr><td>' . $row['email'] . '</td><td>' . $row['subscribe_date'] . '</td><td><a href="/subscriptions.php?delete='. $row['id'] . '"><button>Delete</button></a></td></tr>'); 
            }
            else{
                //get domain
                $domain = explode('@', $row['email']);
                $domain = explode('.', $domain[1]);
                $domain = $domain[0];
                if ($provider === $domain){
                    //print only selected
                    print('<tr><td>' . $row['email'] . '</td><td>' . $row['subscribe_date'] . '</td><td><a href="/subscriptions.php?delete='. $row['id'] . '"><button>Delete</button></a></td></tr>');
                }
            }
        }
    }

    /**
     * Prints unique provider buttons
     */
    public function showUniqueProviders(){
        $results = $this->getAllSubscriptions($sortBy);
        foreach ($results['providers'] as $row){
            print('<a href="/subscriptions.php?filter=' . $row . ' " style="margin-right: 1rem;"><button>' . $row . '</button></a>');
        }
    }
}