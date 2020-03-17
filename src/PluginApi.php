<?php


namespace lShamanl\ApiManager;


/**
 * @method ApiManager apiManager()
 */
abstract class PluginApi implements PluginInterface
{
    /** @var ApiManager */
    protected $apiManager;

    public function __call($name, $arguments)
    {
        if ($name === 'apiManager') {
            return $this->apiManager;
        }

        return null;
    }
}