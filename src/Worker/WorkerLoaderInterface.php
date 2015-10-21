<?php
/**
 * Created by PhpStorm.
 * User: weaverryan
 * Date: 10/21/15
 * Time: 2:38 PM
 */

namespace KnpU\Gladiator\Worker;

interface WorkerLoaderInterface
{
    /**
     * Returns an array of worker configuration at the given location
     *
     * @param string $path
     * @return array
     */
    public function load($path);
}
