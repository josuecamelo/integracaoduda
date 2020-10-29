<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait DudaApi{
    /*
     * Provision a new Duda site
     * */
    public function createSite($template_id = "20077")
    {
        $url = env("DUDA_BASE_URL").'sites/multiscreen/create';
        $data = [
            "template_id" => $template_id,
            'site_data' => [
                'external_uid' => Auth::user()->email
            ]
        ];

        $data = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, env('DUDA_USER').':'.env('DUDA_SECRET'));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        $output = curl_exec($ch);

        if(curl_errno($ch)) {
            die('Curl error: ' . curl_error($ch));
        }

        $output = json_decode($output);

        return $output->site_name;
    }

    /*
     * Create Account
     * */
    public function createCustomerAccount()
    {
        $url = env("DUDA_BASE_URL").'accounts/create';
        $name = explode(' ', Auth::user()->name);
        $lastName = "";

        foreach($name as $key => $item){
            if($key > 0){
                $lastName .= $item. " ";
            }
        }

        $data = [
            "account_name" => Auth::user()->email,
            "first_name" => $name[0],
            "last_name" => rtrim($lastName),
            "account_type" => "CUSTOMER"
        ];

        $data = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, env('DUDA_USER').':'.env('DUDA_SECRET'));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        $output = curl_exec($ch);

        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 204) {
            curl_close($ch);
            return Auth::user()->uuid;
        } else {
            curl_close($ch);
            die('Account creation failed, error: ' . $output . '');
        }
    }

    /*
     * Grant Access/Permissions to Site
     * */
    public function grantAccountAccess($siteName) {
        $url = env("DUDA_BASE_URL").'accounts/'.Auth::user()->email.'/sites/'.$siteName.'/permissions';

        $permissions = '{"permissions":["PUSH_NOTIFICATIONS","REPUBLISH","EDIT","INSITE","PUBLISH","CUSTOM_DOMAIN","RESET","SEO","STATS_TAB","BLOG"]}';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, env('DUDA_USER').':'.env('DUDA_SECRET'));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $permissions);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        $output = curl_exec($ch);

        if(curl_getinfo($ch,CURLINFO_HTTP_CODE) == 204) {
            curl_close($ch);
            return $output;
        } else {
            curl_close($ch);
            die('Granting access failed, error: '. $output . '<br/>');
        }
    }

    /*
     * Generate SSO Link
     * */
    public function getSSOLink($account,$siteName,$target) {
        $SSOAPIURL = 'https://api.duda.co/api/accounts/sso/' . $account . '/link';

        if($target) {
            $SSOAPIURL .= '?target=' . $target . '&site_name=' . $siteName;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($ch, CURLOPT_URL, $SSOAPIURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, env('DUDA_USER').':'.env('DUDA_SECRET'));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $output = curl_exec($ch);

        if(curl_getinfo($ch,CURLINFO_HTTP_CODE) == 200) {
            curl_close($ch);
            $output = json_decode($output);
            return $output->url . '&asNew=true';
        } else {
            curl_close($ch);
            die('Error getting SSO link: '. $output . '<br/>');
        }
    }

    /*
     * Get Sites By External ID - ID Empresa
     *https://api.duda.co/api/external_uid
     * */
    public function getSitesByExternalId() {
        $url = env("DUDA_BASE_URL").'sites/multiscreen/byexternalid/'.Auth::user()->email;
        $authorization = "Authorization: Basic ". base64_encode(env('DUDA_USER').':'.env('DUDA_SECRET'));

        $ch = curl_init(); // Initialise cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8' , $authorization ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $result = curl_exec($ch);

        curl_close($ch);
        $json = json_decode($result);

        return $json;
    }

    public function getSites(){
        $siteNames = $this->getSitesByExternalId(Auth::user()->email);
        $list = [];

        foreach($siteNames as $siteName){
            $list[] = $this->getSiteInfo($siteName);
        }

        return $list;
    }

    protected function getSiteInfo($siteName){
        $url = env("DUDA_BASE_URL").'sites/multiscreen/'.$siteName;
        $authorization = "Authorization: Basic ". base64_encode(env('DUDA_USER').':'.env('DUDA_SECRET'));

        $ch = curl_init(); // Initialise cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8' , $authorization ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $result = curl_exec($ch);

        curl_close($ch);
        $json = json_decode($result);

        return $json;
    }

    /*
     * Get All Templates
     * */

    public function getAllTemplates() {
        $url = env("DUDA_BASE_URL").'sites/multiscreen/templates';
        $authorization = env('DUDA_USER').':'.env('DUDA_SECRET');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $authorization);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        //execute cURL call
        $output = curl_exec($ch);

        //check result for correct HTTP code
        if(curl_getinfo($ch,CURLINFO_HTTP_CODE) == 200) {
            curl_close($ch);
            return $output;
        } else {
            curl_close($ch);
            http_response_code(400);
            die('Error getting templates details: '. $output . '<br/>');
        }
    }
}
