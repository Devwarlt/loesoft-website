<?php
/**
 * Created by PhpStorm.
 * User: devwarlt
 * Date: 25/10/2019
 * Time: 19:38
 */

namespace php\packet\handlers;

use php\packet\AccessLevel as al;
use php\packet\ChangeLogAction as cla;
use php\packet\ChangeLogType as clt;
use php\packet\Debug;
use php\packet\results\PacketResult as pr;
use php\packet\handlers\LoginHandler as login;
use php\utilities\Utils as utils;
use php\utilities\DatabaseUtils as dutils;

final class ChangeLogHandler extends Debug implements IHandler
{
    const publishAccessLevel = al::admin;
    const editAccessLevel = al::admin;
    const deleteAccessLevel = al::admin;
    private static $singleton;

    public function __construct()
    {
        $this->configureDebug(true);
    }

    /**
     * Gets a singleton-like instance of class that implements **IHandler**.
     * @return ChangeLogHandler
     */
    public static function getSingleton()
    {
        if (self::$singleton === null)
            self::$singleton = new ChangeLogHandler();

        return self::$singleton;
    }

    /**
     * Handle a change log message.
     * @param array $params
     * @return string
     */
    public function handle(array $params)
    {
        $this->title("Change Log Handler");

        if (!login::isLoggedIn()) return pr::onInvalid();

        $action = utils::tryGetValue($params, "action");

        if (utils::isNullOrEmpty($action)) {
            $this->debug("Action is empty!");
            return pr::onInvalid();
        }

        $action = (int)$action;

        if (!array_key_exists($action, cla::$actions)) {
            $this->debug("Action <strong>" . $action . "</strong> isn't registered!");
            return pr::onInvalid();
        }

        $username = utils::tryGetValue($params, "username");
        $password = utils::tryGetValue($params, "password");

        if (utils::isNullOrEmpty($username) || utils::isNullOrEmpty($password)) {
            $this->debug("Credentials are empty!");
            return pr::onInvalid();
        }

        $dbu = dutils::getSingleton();

        if ($dbu->isAccountExist($username, $password, false)) {
            $accessLevel = $dbu->getAccessLevelFromAccount($username, $password, false);
            $credentials = array(
                "username" => $username,
                "password" => $password,
                "accessLevel" => $accessLevel
            );
            $result = pr::onInvalid();

            switch ($action) {
                case cla::publish:
                    $result = $this->handlePublish($credentials, $params);
                    break;
                case cla::edit:
                    $result = $this->handleEdit($credentials, $params);
                    break;
                case cla::delete:
                    $result = $this->handleDelete($credentials, $params);
                    break;
            }

            return $result;
        } else $this->debug("Account doesn't exist!");

        return pr::onError();
    }

    /**
     * Handle a publish change log action.
     * @param array $credentials
     * @param array $params
     * @return string
     */
    private function handlePublish(array $credentials, array $params)
    {
        $this->debug("Resolving 'Publish' action request...");
        $accessLevel = $credentials["accessLevel"];

        if ($accessLevel < self::publishAccessLevel) {
            $this->debug("Access level <strong>" . $accessLevel . "</strong> isn't enough to perform this action, required access level <strong>" . self::publishAccessLevel . "</strong>");
            return pr::onInvalid();
        }

        $version = utils::tryGetValue($params, "version");
        $type = utils::tryGetValue($params, "type");
        $content = utils::tryGetValue($params, "content");

        if (utils::isNullOrEmpty($version) || utils::isNullOrEmpty($type) || utils::isNullOrEmpty($content)) {
            $this->debug("Required data to publish a new change log entry are missing!");
            return pr::onInvalid();
        }

        $type = (int)$type;

        if (!array_key_exists($type, clt::$types)) {
            $this->debug("Type <strong>" . $type . "</strong> isn't registered!");
            return pr::onInvalid();
        }

        $dbu = dutils::getSingleton();
        $id = $dbu->getIdFromAccount($credentials["username"], $credentials["password"], false);

        if ($dbu->publishChangeLog($version, $type, $id, $content)) {
            $this->debug("Successfully published a new change log entry!");
            return pr::onSuccess();
        } else $this->debug("It wasn't possible to create a new change log entry on database!");

        return pr::onError();
    }

    /**
     * Handle a edit change log action.
     * @param array $credentials
     * @param array $params
     * @return string
     */
    private function handleEdit(array $credentials, array $params)
    {
        $this->debug("Resolving 'Edit' action request...");
        $accessLevel = $credentials["accessLevel"];

        if ($accessLevel < self::editAccessLevel) {
            $this->debug("Access level <strong>" . $accessLevel . "</strong> isn't enough to perform this action, required access level <strong>" . self::editAccessLevel . "</strong>");
            return pr::onInvalid();
        }

        $id = utils::tryGetValue($params, "id");
        $version = utils::tryGetValue($params, "version");
        $type = utils::tryGetValue($params, "type");
        $content = utils::tryGetValue($params, "content");

        if (utils::isNullOrEmpty($id) || utils::isNullOrEmpty($version) || utils::isNullOrEmpty($type) || utils::isNullOrEmpty($content)) {
            $this->debug("Required data to edit a new change log entry are missing!");
            return pr::onInvalid();
        }

        $id = (int)$id;
        $type = (int)$type;

        if (!array_key_exists($type, clt::$types)) {
            $this->debug("Type <strong>" . $type . "</strong> isn't registered!");
            return pr::onInvalid();
        }

        $dbu = dutils::getSingleton();
        $reviwerId = $dbu->getIdFromAccount($credentials["username"], $credentials["password"], false);

        if ($dbu->editChangeLog($id, $version, $type, $reviwerId, $content)) {
            $this->debug("Successfully edited this change log entry!");
            return pr::onSuccess();
        } else $this->debug("It wasn't possible to edit this change log entry on database!");

        return pr::onError();
    }

    /**
     * Handle a delete change log action.
     * @param array $credentials
     * @param array $params
     */
    private function handleDelete(array $credentials, array $params)
    {
        $this->debug("Resolving 'Delete' action request...");
        $accessLevel = $credentials["accessLevel"];

        if ($accessLevel < self::deleteAccessLevel) {
            $this->debug("Access level <strong>" . $accessLevel . "</strong> isn't enough to perform this action, required access level <strong>" . self::deleteAccessLevel . "</strong>");
            return pr::onInvalid();
        }

        $id = utils::tryGetValue($params, "id");

        if (utils::isNullOrEmpty($id)) {
            $this->debug("Required data to edit a new change log entry are missing!");
            return pr::onInvalid();
        }

        $id = (int)$id;
        $dbu = dutils::getSingleton();

        if ($dbu->deleteChangeLog($id)) {
            $this->debug("Successfully deleted this change log entry!");
            return pr::onSuccess();
        } else $this->debug("It wasn't possible to delete this change log entry on database!");

        return pr::onError();
    }
}