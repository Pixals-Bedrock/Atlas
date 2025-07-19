<?php


namespace AtlasDB\PixalsLibs\result;

use Closure;
use SOFe\AwaitGenerator\Await;

class DeferredResult {


    public function resolve(mixed $result, Closure $onSuccess) : void {
        ($onSuccess)($result);
    }

}