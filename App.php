<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 19/12/16
 * Time: 10:34
 */

namespace OneSignal;

use OneSignal\Notification;

class App {

    private $client;

    private $id;
    private $name;
    private $players;
    private $messageable_players;

    function __construct() {
        // Default constructor, called by static helper constructors
        $this->id = '';
        $this->name = '';
        $this->players = 0;
        $this->messageable_players = 0;
    }

    /******************************
     * Static helper constructors *
     ******************************/

    /**
     * @param $json
     */

    public static function fromJSON($json) {
        $instance = new App();

        $instance->setId($json->id);
        $instance->setName($json->name);
        $instance->setPlayers($json->players);
        $instance->setMessageablePlayers($json->messageable_players);
        return $instance;
    }

    public static function withID($id) {
        $instance = new App();
        $instance->setId($id);
        return $instance;
    }

    /********************
     * Public functions *
     ********************/

    public function sendNotification(Notification $notification) {


        $fields = array(
            OneSignal::KEY_APP_ID => $this->getId(),
            OneSignal::KEY_CONTENTS => $notification->getContent(),
            OneSignal::KEY_DATA => $notification->getAdditionalData(),
            OneSignal::KEY_HEADINGS => $notification->getTitle(),
            OneSignal::KEY_SUBTITLE => $notification->getSubtitleForIos10(),
            OneSignal::KEY_INCLUDED_SEGMENTS => $notification->getIncludedSegments(),
            OneSignal::KEY_BADGECOUNT_IOS => $notification->getBadgeCountIos(),
            OneSignal::KEY_BADGETYPE_IOS => $notification->getBadgeTypeIos()
        );

        $response = $this->client->callEndpoint(OneSignal::NOTIFICATION_URL, OneSignal::REQUEST_POST, $fields);
        return $response;
    }

    /***********************
     * Getters and setters *
     ***********************/

    public function setClient(OneSignal $client) {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @param int $players
     */
    public function setPlayers($players)
    {
        $this->players = $players;
    }

    /**
     * @return int
     */
    public function getMessageablePlayers()
    {
        return $this->messageable_players;
    }

    /**
     * @param int $messageable_players
     */
    public function setMessageablePlayers($messageable_players)
    {
        $this->messageable_players = $messageable_players;
    }





}