<?php

namespace EndorphinStudio\Laravel\BrowserDetector;

use EndorphinStudio\Detector\Data\Browser;
use EndorphinStudio\Detector\Data\Device;
use EndorphinStudio\Detector\Data\Os;
use EndorphinStudio\Detector\Data\Result;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class BrowserDetector
 * @package EndorphinStudio\Laravel\BrowserDetector
 * @author Serhii Nekhaienko <serhii.nekhaienko@gmail.com>
 * @method Browser getBrowser() return browser result
 * @method Os getOs() return os result
 * @method Device getDevice() return device result
 * @method string getBrowserName() return browser name
 * @method string getBrowserFamily() return browser family
 * @method string getBrowserType() return browser type
 * @method string getBrowserVersion() return browser version
 * @method string getOsName() return os name
 * @method string getOsType() return os type
 * @method string getOsFamily() return os family
 * @method string getOsVersion() return os version
 * @method string getDeviceName() return device name
 * @method string getDeviceVersion() return device version
 * @method string getDeviceType() return device type
 * @method string getCoreVersion() return detector version
 * @method string getUserAgent() return user agent
 * @method boolean isTouch() return true if device is touch
 * @method boolean isMobile() return true if device is mobile
 * @method boolean isTablet() return true if device is tablet
 */
class BrowserDetector implements \JsonSerializable, \Stringable, Arrayable
{
    private Result $result;
    private array $resultBags = ['Os', 'Device', 'Browser'];

    public function __construct(Result $result)
    {
        $this->result = $result;
    }

    /**
     * Proxy get|is calls to result object
     * @param $name
     * @param $arguments
     * @return string|Os|Device|Browser
     */
    public function __call($name, $arguments)
    {
        $words = preg_split('/(?=[A-Z])/',$name);
        $methodType = $words[0];
        switch ($methodType) {
            case 'get':
                // get
                return $this->get($words, $arguments);
                break;
            case 'is':
                // is
                if(method_exists($this->result, $name)) {
                    return call_user_func([$this->result, $name], $arguments);
                }
                break;
        }
        return '';
    }


    /**
     * Return result of get call
     * @param array $words
     * @param array $arguments
     * @return string|Os|Browser|Device
     */
    private function get(array $words, array $arguments)
    {
        $words = array_splice($words, 1);
        $getObjectFunction = 'get' . ucfirst($words[0]);

        if (!in_array($words[0], $this->resultBags, true)) {
            $function = 'get' . ucfirst(implode('', $words));
            if (method_exists($this->result, $function)) {
                return call_user_func([$this->result, $function], $arguments);
            }
        }
        if (method_exists($this->result, $getObjectFunction)) {
            $object = call_user_func([$this->result, $getObjectFunction]);
            if (count($words) === 1) {
                return $object;
            }
            $words = array_splice($words, 1);
            $function = 'get' . implode('', $words);

            if (method_exists($object, $function)) {
                return call_user_func([$object, $function], $arguments);
            }
        }
        return '';
    }

    /**
     * Convert result to string
     * @return string
     */
    public function __toString(): string
    {
        $result = json_encode($this, JSON_PRETTY_PRINT);
        return (!$result) ? '' : $result;
    }

    /**
     * Return array
     */
    public function toArray(): array
    {
        $vars = $this->result->jsonSerialize();
        $clear = ['detector', 'robot', 'isRobot'];
        foreach ($clear as $key)
        {
            unset($vars[$key]);
        }
        $vars['coreVersion'] = $this->getCoreVersion();
        $vars['modules'] = $this->result->getModulesVersions();
        return $vars;
    }

    /**
     * Return array for convert to json object
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
