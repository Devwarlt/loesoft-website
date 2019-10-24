<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 23/10/2019
 * Time: 22:28
 */

namespace php\utilities;

final class ChangeLog
{
    const clientType = 0;
    const serverType = 1;
    const websiteType = 2;

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
     * Gets type of change log entry.
     * @return mixed
     */
    public function getCreation()
    {
        return $this->creation;
    }

    /**
     * Gets creation date of change log entry.
     * @return mixed
     */
    public function getType()
    {
        switch ($this->type) {
            case self::clientType:
                return "client";
            case self::serverType:
                return "server";
            case self::websiteType:
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
        return $this->creation !== $this->edited;
    }
}