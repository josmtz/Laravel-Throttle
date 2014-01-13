<?php

/**
 * This file is part of Laravel Throttle by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\Tests\Throttle\Classes;

use Mockery;
use GrahamCampbell\Throttle\Classes\Throttle;
use GrahamCampbell\TestBench\Classes\AbstractTestCase;

/**
 * This is the throttle test class.
 *
 * @package    Laravel-Throttle
 * @author     Graham Campbell
 * @copyright  Copyright 2013-2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-Throttle/blob/develop/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-Throttle
 */
class ThrottleTest extends AbstractTestCase
{
    public function testGet()
    {
        $throttle = $this->getThrottle();

        $request = Mockery::mock('Illuminate\Http\Request');

        $request->shouldReceive('getClientIp')->once()->andReturn('127.0.0.1');
        $request->shouldReceive('path')->once()->andReturn('http://laravel.com/');

        $return = $throttle->get($request, 10, 60);

        $this->assertInstanceOf('GrahamCampbell\Throttle\Throttlers\CacheThrottler', $return);
    }

    protected function getThrottle()
    {
        $cache = Mockery::mock('Illuminate\Cache\CacheManager');
        $throttler = 'GrahamCampbell\Throttle\Throttlers\CacheThrottler';

        return new Throttle($cache, $throttler);
    }
}
