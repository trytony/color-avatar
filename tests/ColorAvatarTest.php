<?php

namespace Tony\ColorAvatar\Tests;

use PHPUnit\Framework\TestCase;
use Tony\ColorAvatar\ColorAvatar;

class ColorAvatarTest extends TestCase
{

    public function testCreateColorAvatar()
    {
        $c = new ColorAvatar();

        $this->assertEquals('/usr/local/var/www/tony/color-avatar/src/uploads/2019/02/13/test.jpg', $c->create(
            'ZB',
            '/usr/local/var/www/tony/color-avatar/src/uploads',
            'test.jpg'
        ));
    }
}