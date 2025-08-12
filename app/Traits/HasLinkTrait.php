<?php

namespace App\Traits;

trait HasLinkTrait
{
    public function getLink(): string
    {
        return $this->getTranslationOne('link') != '' ? $this->getTranslationOne('link') : route('client.menu.main', ['lang' => locale(), 'slug' => $this->slug]);
    }

    public function getPostLink(): string
    {
        return $this->getTranslationOne('link') != '' ? $this->getTranslationOne('link') : route('client.post.single', ['lang' => locale(), 'slug' => $this->slug]);
    }

    public function getPostButtonName()
    {
        return $this->getTranslationOne('link_name') != '' ? $this->getTranslationOne('link_name') : getTranslation('See details');
    }
}
