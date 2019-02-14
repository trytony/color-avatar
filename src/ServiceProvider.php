<?php

namespace Tony\ColorAvatar;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(ColorAvatar::class, function(){
            return new ColorAvatar();
        });

        $this->app->alias(ColorAvatar::class, 'ColorAvatar');
    }

    public function provides()
    {
        return [ColorAvatar::class, 'ColorAvatar'];
    }
}