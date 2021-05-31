<?php

namespace EndorphinStudio\Laravel\BrowserDetector\Providers;

use EndorphinStudio\Detector\Detector;
use EndorphinStudio\Laravel\BrowserDetector\BrowserDetector;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

/**
 * Class BrowserDetectorProvider
 * @package EndorphinStudio\Laravel\BrowserDetector
 * @author Serhii Nekhaienko <serhii.nekhaienko@gmail.com>
 */
class BrowserDetectorProvider extends ServiceProvider
{
    public function register(): void
    {
        $request = $this->app->make(Request::class);
        if($request) {
            $detector = $this->app->make(Detector::class);
            $this->app->singleton(Detector::class, fn() => $detector);
            $result = $detector->analyse($request->userAgent());
            $this->app->singleton(BrowserDetector::class, fn() => new BrowserDetector($result));
        }
    }
}
