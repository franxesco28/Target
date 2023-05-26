<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Contracts\Redis\Factory as Redis;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequestsWithRedis;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ThrottleRequestAndCacheContentWithRedis extends ThrottleRequestsWithRedis
{
    private $redisClient;

    public function __construct(RateLimiter $limiter, Redis $redis) {

        parent::__construct($limiter, $redis);

        $this->redisClient = $redis->connection()->client();
    }

    /**
     * @inheritDoc
     */
    protected function handleRequest($request, Closure $next, array $limits)
    {
        foreach ($limits as $limit) {

            if ($this->tooManyAttempts($limit->key, $limit->maxAttempts, $limit->decayMinutes)) {

                $response = $this->tryGetContentFromCache($limit->key );

                if (is_null($response)){
                    throw $this->buildException($request, $limit->key, $limit->maxAttempts, $limit->responseCallback);
                }

                return $response;
            }

        }

        $response = $next($request);

        $this->handeResponse($limits, $response);

        return $response;
    }

    private function handeResponse(array $limits, Response $response): void {

        foreach ($limits as $limit) {

            $remainingAttempts = $this->calculateRemainingAttempts($limit->key, $limit->maxAttempts);


            if ($remainingAttempts === 0 ){

                $this->trySetContentIntoCache($response,$limit->key,$limit->decayMinutes );

            }

            parent::addHeaders($response, $limit->maxAttempts, $remainingAttempts);
        }
    }

    private  function trySetContentIntoCache (Response $response, string $key, int $decay ): void {

        $expire = $decay * 60;

        try {
            $this->redisClient->setex($this->getKeyContent($key),$expire, serialize($response));
        }catch (\Exception $e){
            Log::error($e->getMessage() );
        }

    }

    private function getKeyContent (string $key ): string {

        return "{$key}_content";

    }

    private function tryGetContentFromCache(string $key ): Response |null{

        try {
            $value =  $this->redisClient->get($this->getKeyContent($key));

            if ($value ===  false)
                return null;

            $response =  unserialize($value);

            $this->enrichResponse($response);

            return $response;

        } catch (\Exception $e ) {

            Log::error($e->getMessage());

            return null;
        }
    }

    private function enrichResponse(Response $response): void
    {
        $response->headers->add([
            'X-Cache-Content' => 1
        ]);

        $response->setStatusCode(429);
    }
}
