<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 19/12/16
 * Time: 10:04
 */


namespace OneSignal;

// Load other classes
require_once "App.php";
require_once "Notification.php";

class OneSignal {

    const BASE_URL = "https://onesignal.com/api/v1/";
    const APP_URL = "apps/";
    const NOTIFICATION_URL = "notifications/";

    const LANG_DA = "da";
    const LANG_EN = "en";

    const REQUEST_POST = 0;
    const REQUEST_GET = 1;
    const REQUEST_UPDATE = 2;
    const REQUEST_DELETE = 3;

    const KEY_APP_ID = "app_id";
    const KEY_INCLUDED_SEGMENTS = "included_segments";
    const KEY_DATA = "data";
    const KEY_CONTENTS = "contents";
    const KEY_HEADINGS = "headings";
    const KEY_SUBTITLE = "subtitle";

    const SEGMENT_ALL = "All";
    const SEGMENT_ACTIVE = "Active Users";
    const SEGMENT_INACTIVE = "Inactive Users";

    private $app_auth_key;
    private $user_auth_key;
    private $headers;

    /********************
     * Public functions *
     ********************/

    /**
     * OneSignal constructor.
     * @param $api_key
     */

    function __construct($app_auth_key, $user_auth_key) {
        $this->app_auth_key = $app_auth_key;
        $this->user_auth_key = $user_auth_key;
        $this->setHeaders($app_auth_key);
    }

    /**
     * Retrieval of a single application
     *
     * App ID is required.
     *
     * @param $app_id - Unique identifier of an app
     *
     * @param $fetchFromServer -    If true, app data will be fetched from OneSignal's servers.
     *                              Else, a local skeleton object will be used instead.
     */
    function getApp($app_id, $fetchFromServer = false) {
        $app = App::withID($app_id);
        if ($fetchFromServer) {
            $response = $this->callEndpoint(OneSignal::APP_URL . $app_id, OneSignal::REQUEST_GET);
            $app = App::fromJSON($response);
        }
        $app->setClient($this);
        return $app;
    }



    /*********************
     * Private functions *
     *********************/

    function setHeaders($auth_key) {
        $this->headers = array(
            "Content-Type: application/json; charset=utf-8",
            "Authorization: Basic $auth_key"
        );
    }

    public function callEndpoint($url, $type, $params = array()) {
        // Set authorization header depending on the URL being called
        if (strpos($url, OneSignal::APP_URL) !== false) {
            // Endpoints for apps require user authentication
            $this->setHeaders($this->user_auth_key);
        } else {
            // Endpoints for notifications and devices just need app authentication
            $this->setHeaders($this->app_auth_key);
        }

        // Initialize new handle
        $ch = curl_init();
        // Basic configuration necessary for all requests
        curl_setopt($ch, CURLOPT_URL, OneSignal::BASE_URL . $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Specify post type and fields if necessary
        if ($type == OneSignal::REQUEST_POST) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        }

        // Execute cURL
        $response = curl_exec($ch);

        // We expect a JSON response, which we decode and return
        $response = json_decode($response);
        // Close connection when we're done using it
        curl_close($ch);

        return $response;
    }



}