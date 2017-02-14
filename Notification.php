<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 19/12/16
 * Time: 11:57
 */

namespace OneSignal;


class Notification {

    private $defaultLanguage;

    private $title;
    private $subtitle_ios10;
    private $content;
    private $additionalData;
    private $includedSegments;
    private $badgeType_ios;
    private $badgeCount_ios;

    function __construct($content, $defaultLanguage = OneSignal::LANG_EN) {
        $this->defaultLanguage = $defaultLanguage;
        $this->setContent($content);
        $this->additionalData = array();
        $this->title = array();
        $this->subtitle_ios10 = array();
        $this->includedSegments = array(OneSignal::SEGMENT_ALL);
        $this->badgeType_ios = OneSignal::BADGETYPE_NONE;
        $this->badgeCount_ios = 1;
    }

    public function addData($key, $value) {
        $this->additionalData[$key] = $value;
    }

    public function addIncludedSegment($segment) {
        // Check if 'All Users' segment is currently the only added segment.
        if (sizeof($this->getIncludedSegments()) == 1 && in_array(OneSignal::SEGMENT_ALL, $this->getIncludedSegments())) {
            // Reset included segments, before adding an included segment
            $this->includedSegments = array();
        }
        $this->includedSegments[] = $segment;
    }

    /***********************
     * Getters and setters *
     ***********************/

    /**
     * @return string
     */
    public function getBadgeTypeIos()
    {
        return $this->badgeType_ios;
    }

    /**
     * @param string $badgeType_ios
     */
    public function setBadgeTypeIos($badgeType_ios)
    {
        $this->badgeType_ios = $badgeType_ios;
    }

    /**
     * @return int
     */
    public function getBadgeCountIos()
    {
        return $this->badgeCount_ios;
    }

    /**
     * @param int $badgeCount_ios
     */
    public function setBadgeCountIos($badgeCount_ios)
    {
        $this->badgeCount_ios = $badgeCount_ios;
    }

    /**
     * @return array
     */
    public function getIncludedSegments()
    {
        return $this->includedSegments;
    }

    /**
     * @param array $includedSegments
     */
    public function setIncludedSegments($includedSegments)
    {
        $this->includedSegments = $includedSegments;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title, $language = null)
    {
        if ($language === null) {
            $language = $this->defaultLanguage;
        }
        $this->title[$language] = $title;
    }

    /**
     * @return mixed
     */
    public function getSubtitleForIos10()
    {
        return $this->subtitle_ios10;
    }

    /**
     * @param mixed $subtitle_ios10
     */
    public function setSubtitleForIos10($subtitle, $language = null)
    {
        if ($language === null) {
            $language = $this->defaultLanguage;
        }
        $this->subtitle_ios10[$language] = $subtitle;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content, $language = null)
    {
        if ($language === null) {
            $language = $this->defaultLanguage;
        }
        $this->content[$language] = $content;
    }

    /**
     * @return mixed
     */
    public function getAdditionalData()
    {
        return $this->additionalData;
    }

    /**
     * @param mixed $additionalData
     */
    public function setAdditionalData($additionalData)
    {
        $this->additionalData = $additionalData;
    }



}