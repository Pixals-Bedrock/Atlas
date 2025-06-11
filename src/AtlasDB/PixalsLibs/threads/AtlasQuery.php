<?php


namespace AtlasDB\PixalsLibs\threads;

use AtlasDB\PixalsLibs\queries\QueriesManager;
use Closure;
use mysqli;
use pocketmine\scheduler\AsyncTask;
use pmmp\thread\ThreadSafe;
use pocketmine\thread\NonThreadSafeValue;
use Throwable;

class AtlasQuery extends ThreadSafe {

    private $result;
    private $error;

    private string $id;

    public function __construct() {
        $this->id = "query_" . uniqid();
    }

    public function getId(): string {
        return $this->id;
    }

    public function doQuery(mysqli $connection) : void {

    }


    public function setResult(mixed $var) : void {
        $this->result = serialize($var);
        (new QueriesManager)::handleQueryCompletion($this);
    }
    
    public function getResult() : mixed {
        return unserialize($this->result);
    }

    public function setError(?NonThreadSafeValue $e) : void {
        $this->error = $e;
    }

    public function getError() : ?String {
        return $this->error->deserialize();
    }

    public function execute(?Closure $onSuccess, ?Closure $onFail) {
        QueriesManager::registerCallback($this->getId(), $onSuccess, $onFail);
        (new QueriesManager)->executeQuery($this, $onSuccess, $onFail);
    }

}