<?php


namespace AtlasDB\PixalsLibs\queries;

use AtlasDB\PixalsLibs\ConnectionManager;
use AtlasDB\PixalsLibs\managers\WorkersManager;
use AtlasDB\PixalsLibs\threads\AtlasQuery;
use AtlasDB\PixalsLibs\threads\AtlasWorker;
use Closure;

class QueriesManager {

    protected static array $callbacks = [];

    public static function registerCallback(string $id, callable $success, ?callable $fail): void {
        self::$callbacks[$id] = [$success, $fail];
    }

    public function executeQuery(AtlasQuery $atlasQuery, ?Closure $onSuccess, ?Closure $onFail) : void {
        $queue = WorkersManager::getQueue();
        $queue[] = $atlasQuery; 
        
    }

    public static function handleQueryCompletion(AtlasQuery $query): void {
        $id = $query->getId();
        $result = $query->getResult();
        var_dump(array_keys(self::$callbacks));

        var_dump("Query $id completed");

        if (isset(self::$callbacks[$id])) {
            [$onSuccess, $onFail] = self::$callbacks[$id];
            
            if ($onSuccess !== null) {
                $onSuccess($result);
            }

            unset(self::$callbacks[$id]);
        } else {
            var_dump("No callback registered for $id");
        }
    }

}