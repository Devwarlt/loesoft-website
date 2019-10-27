<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 23/10/2019
 * Time: 22:28
 */

namespace php\utilities;

use php\packet\ChangeLogType as clt;

;

final class ChangeLogEntry
{
    private $id;
    private $version;
    private $type;
    private $creation;
    private $edited;
    private $authorId;
    private $reviewerId;
    private $content;

    public function __construct($id, $version, $type, $creation, $edited, $authorId, $reviewerId, $content)
    {
        $this->id = $id;
        $this->version = $version;
        $this->type = $type;
        $this->creation = $creation;
        $this->edited = $edited;
        $this->authorId = $authorId;
        $this->reviewerId = $reviewerId;
        $this->content = $content;
    }

    /**
     * Gets id of change log entry.
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets version of change log entry.
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Gets creation date of change log entry.
     * @return mixed
     */
    public function getCreation()
    {
        return $this->creation;
    }

    /**
     * Gets type of change log entry.
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Gets icon type of change log entry.
     * @return mixed
     */
    public function getIconType()
    {
        switch ($this->type) {
            case clt::client:
                return "client";
            case clt::server:
                return "server";
            case clt::website:
                return "website";
            default:
                return null;
        }
    }

    /**
     * Gets last edited date of change log entry.
     * @return mixed
     */
    public function getEdited()
    {
        return $this->edited;
    }

    /**
     * Gets author id of change log entry.
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * Gets reviewer id of change log entry.
     * @return mixed
     */
    public function getReviewerId()
    {
        return $this->reviewerId;
    }

    /**
     * Gets content of change log entry.
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Verify if last edited and creation dates are different.
     * @return bool
     */
    public function isChangeLogEdited()
    {
        return $this->creation != $this->edited;
    }
}