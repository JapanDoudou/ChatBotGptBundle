<?php

namespace JapanDoudou\ChatGptBundle;

use JapanDoudou\ChatGptBundle\DependencyInjection\JapanDoudouChatGptBundleExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class JapanDoudouChatGptBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new JapanDoudouChatGptBundleExtension();
        }
        return $this->extension;
    }
}
