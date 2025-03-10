<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\RequestMatcher;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcher\SchemeRequestMatcher;

class SchemeRequestMatcherTest extends TestCase
{
    /**
     * @dataProvider getData
     */
    public function test(string $requestScheme, array|string $matcherScheme, bool $isMatch)
    {
        $httpRequest = Request::create('');
        $httpsRequest = Request::create('', 'get', [], [], [], ['HTTPS' => 'on']);

        $matcher = new SchemeRequestMatcher($matcherScheme);
        if ($isMatch) {
            if ('https' === $requestScheme) {
                $this->assertFalse($matcher->matches($httpRequest));
                $this->assertTrue($matcher->matches($httpsRequest));
            } else {
                $this->assertFalse($matcher->matches($httpsRequest));
                $this->assertTrue($matcher->matches($httpRequest));
            }
        } else {
            $this->assertFalse($matcher->matches($httpRequest));
            $this->assertFalse($matcher->matches($httpsRequest));
        }
    }

    public function testAlwaysMatchesOnParamsHeaders()
    {
        $matcher = new SchemeRequestMatcher([]);
        $request = Request::create('sftp://example.com');
        $this->assertTrue($matcher->matches($request));
    }

    public static function getData()
    {
        return [
            ['http', 'http', true],
            ['http', 'HTTP', true],
            ['https', 'https', true],
            ['http', 'ftp', false],
            ['http', 'ftp, http', true],
            ['http', 'FTP, HTTP', true],
            ['http', ['http', 'ftp'], true],
            ['http', ['http,ftp'], true],
        ];
    }
}
