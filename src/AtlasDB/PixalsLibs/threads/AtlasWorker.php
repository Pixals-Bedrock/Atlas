<?php

namespace AtlasDB\PixalsLibs\threads;

use AtlasDB\PixalsLibs\Connection;
use AtlasDB\PixalsLibs\ConnectionManager;
use AtlasDB\PixalsLibs\queries\QueriesManager;
use mysqli;
use pocketmine\thread\NonThreadSafeValue;
use pocketmine\thread\Thread;
use pocketmine\thread\Worker;
use pmmp\thread\ThreadSafeArray;
use pocketmine\scheduler\ClosureTask;
use Throwable;

class AtlasWorker extends Thread {

    private static ?mysqli $db_connection = null;
    private $connection;
    private ThreadSafeArray $queue;

    public function __construct(Connection $connection, ThreadSafeArray $queue)
    {
        $this->connection = new NonThreadSafeValue($connection);
        $this->queue = $queue;
    }    

    public function onRun() : void {
        $connection_data = $this->connection->deserialize();

        while(true) {

            
            if(self::$db_connection == null) {
                self::$db_connection = new mysqli($connection_data->getIP(), $connection_data->getUsername(), $connection_data->getPassword(), $connection_data->getDatabase(), $connection_data->getPort());
            }

            if(count($this->queue) > 0) {
                $query = $this->queue->shift();
                if(self::$db_connection->connect_errno) {
                    self::$db_connection = new mysqli($connection_data->getIP(), $connection_data->getUsername(), $connection_data->getPassword(), $connection_data->getDatabase(), $connection_data->getPort());
                }
                if($query instanceof AtlasQuery) {
                    $query->doQuery(self::$db_connection);   
                }
            }



        }
    }

    public static function getConnection() : mysqli {
        return self::$db_connection;
    }


}