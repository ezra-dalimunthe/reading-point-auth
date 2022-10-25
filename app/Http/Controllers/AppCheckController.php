<?php

namespace App\Http\Controllers;

use Cache;

class AppCheckController extends Controller
{
/**
 * @OA\Get(
 *   tags={"AppCheck"},
 *   path="/api/v1/env-check",
 *   summary="Utilities to check environment",
 *   @OA\Response(response=200, description="OK"),
 * )
 */
    public function Inspection()
    {
        $result = [];
        $result["environment"] = app()->environment();
        $result["App Name"] = $_ENV["APP_NAME"];

        $result["PHP Version"] = phpversion();
        $result["Laravel Version"] = app()->version();
        // Test database connection
        $result["database server"] = env("DB_HOST");
        try {
            \DB::connection()->getPdo();
            $result["database_connection"] = ["Test Connection" => "OK"];
        } catch (\Exception $e) {
            //report($e);
            $result["database_connection"] = ["Test Connection" => "NOT OK", "Reason: " => $e->getMessage()];
        }

        // test cache driver
        $cacheDriver = $_ENV["CACHE_DRIVER"];
        $result["Cache Driver"] = $cacheDriver;
        switch ($cacheDriver) {
            case 'memcached':
                # code...
                $memcachedLoaded = extension_loaded("Memcached");
                $result["Memcached Loaded"] = $memcachedLoaded;

                $stats = \Cache::getMemcached()->getStats();
                if ($stats == false) {
                } else {
                    $stats = true;
                }
                $result["Memcached OK"] = $stats;

                break;
            case "file":
                $result["Storage Writeable"] = is_writable(storage_path());

                $fsys = \Cache::getDirectory();
                $result["Cache Directory"] = $fsys;
                break;
            default:
                # code...
                break;
        }
        $result["Cache Prefix"] = \Cache::getPrefix();
        $result["App Debug"] = $_ENV["APP_DEBUG"];
        //$result["loaded Providers"] = app()->loadedProviders;

        return response($result, 200);
    }
    public function clearJwtCache()
    {
        Cache::clear();
        return response()->json(["succes" => true]);
    }

    /**
     * @OA\Get(
     *   tags={"AppCheck"},
     *   path="/api/v1/log-check",
     *   summary="Summary",
     *   @OA\Response(response=200, description="OK"),
     * )
     */
    public function testLog()
    {
        $msg = [
            "hello" => "wolrd",
        ];

        \Log::error("HELLO", ["WRO"]);
        return response()->json(["hello" => "world"]);
    }
}
