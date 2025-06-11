<?php

namespace AtlasDB\PixalsLibs;

use AtlasDB\PixalsLibs\managers\WorkersManager;

use AtlasDB\PixalsLibs\threads\AtlasQuery;
use AtlasDB\PixalsLibs\threads\AtlasWorker;
use pocketmine\plugin\PluginBase;
use pmmp\thread\Pool;

final class ConnectionManager {

    private static array $connections = [];
    protected static array $config = [];
    private static PluginBase $plugin;

    public function createConnection(PluginBase $plugin, array $config) {
        self::$plugin = $plugin;
        self::$config = $config;
        self::$connections[self::$config["ip"]] = new Connection($config["ip"], $config["port"], $config["username"], $config["password"], $config["database"]);
        WorkersManager::init();

    }

    public function getConnection() : Connection {
        return self::$connections[self::$config["ip"]];
    }

    public static function getPlInstance() : PluginBase {
        return self::$plugin;
    }


}