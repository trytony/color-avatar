<?php

namespace Tony\ColorAvatar\Tests;

use PHPUnit\Framework\TestCase;
use Tony\ColorAvatar\ColorAvatar;
use Tony\ColorAvatar\Exceptions\InvalidArgumentException;

class ColorAvatarTest extends TestCase
{

    public function testCreateColorAvatarWithInvalidText()
    {
        $c = new ColorAvatar();

        $this->expectException(InvalidArgumentException::class);

        $this->expectExceptionMessage('Invalid text.');

        $c->create('TONY', '/usr/local/var/www/tony/color-avatar/src/uploads/', 'test.jpg');

        $this->fail('Failed to assert create color avatar throw exception with invalid argument.');
    }

    public function testCreateColorAvatarWithInvalidSaveDir()
    {
        $c = new ColorAvatar();

        $this->expectException(InvalidArgumentException::class);

        $this->expectExceptionMessage('Invalid directory.');

        $c->create('TO', '/usr/local/var/www/tony/color-avatar/src/uploads1/', 'test.jpg');

        $this->fail('Failed to assert create color avatar throw exception with invalid argument.');
    }

    public function testCreateColorAvatarWithInvalidFileName()
    {
        $c = new ColorAvatar();

        $this->expectException(InvalidArgumentException::class);

        $this->expectExceptionMessage('Illegal file name.');

        $c->create('TO', '/usr/local/var/www/tony/color-avatar/src/uploads/', 'test.jpg1');

        $this->fail('Failed to assert create color avatar throw exception with invalid argument.');
    }

    public function testCreateColorAvatar()
    {
        $c = new ColorAvatar();

        $this->assertEquals('/usr/local/var/www/tony/color-avatar/src/uploads/' . date('Y/m/d', time()) . '/test.jpg', $c->create(
            'ZB',
            '/usr/local/var/www/tony/color-avatar/src/uploads',
            'test.jpg'
        ));
    }
}