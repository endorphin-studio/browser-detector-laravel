## Laravel Package for Browser Detector
Laravel package for browser-detector

### Code Status
[![Latest Stable Version](https://poser.pugx.org/endorphin-studio/browser-detector-laravel/v/stable)](https://packagist.org/packages/endorphin-studio/browser-detector-laravel)
[![Total Downloads](https://poser.pugx.org/endorphin-studio/browser-detector-laravel/downloads)](https://packagist.org/packages/endorphin-studio/browser-detector-laravel)
[![License](https://poser.pugx.org/endorphin-studio/browser-detector-laravel/license)](https://packagist.org/packages/endorphin-studio/browser-detector-laravel)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/endorphin-studio/browser-detector-laravel/badges/quality-score.png)](https://scrutinizer-ci.com/g/endorphin-studio/browser-laravel/)

### About
	Author: Serhii Nekhaienko
	Email: sergey.nekhaenko@gmail.com
	Stable Version: 1.0.0
	License: MIT

### Requirements
	PHP >=7.4
	Laravel ^8
    endorphin-studio/browser-detector ^6.0

### Install via Composer
    composer require endorphin-studio/browser-detector-laravel

### Usage example
```php
use EndorphinStudio\Laravel\BrowserDetector\BrowserDetector;

/**
* @var BrowserDetector $detector
**/
$detector = app()->make(BrowserDetector::class);
echo '<pre>'.$detector.'</pre>';
```

You will see result like this one:
```json
{
  "version": "1.1.0",
  "userAgent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.77 Safari/537.36",
  "os": {
    "family": "mac",
    "type": "desktop",
    "version": "10.15.7",
    "name": "Mac OS X"
  },
  "browser": {
    "type": "desktop",
    "version": "91.0.4472.77",
    "name": "Chrome"
  },
  "device": {
    "model": null,
    "hasModel": false,
    "version": null,
    "name": "PC",
    "type": "desktop"
  },
  "isTouch": false,
  "isMobile": false,
  "isTablet": false,
  "coreVersion": "5.0.0",
  "modules": {
    "endorphin-studio/browser-detector-data": "1.1.0"
  }
}
```
