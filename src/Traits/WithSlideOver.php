<?php

namespace OmniaDigital\CatalystCore\Traits;

trait WithSlideOver
{
    public function showSlideOver()
    {
        $this->dispatch('show-slide-over');
    }

    public function hideSlideOver()
    {
        $this->dispatch('hide-slide-over');
    }
}
