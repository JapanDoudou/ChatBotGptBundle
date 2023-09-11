<?php

namespace JapanDoudou\ChatGptBundle\DependencyInjection;

use Exception;
use JapanDoudou\ChatGptBundle\Services\ChatGptService;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class JapanDoudouChatGptBundleExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        if (!isset($configs[0]['openai_key'])) {
            throw new InvalidConfigurationException('The child node "openai_key" at path "japandoudou_chat_gpt" must be configured.');
        }
        if (!isset($configs[0]['is_debug'])) {
            $configs[0]['is_debug'] = true;
        }

        $definition = $container->getDefinition(ChatGptService::class);
        $definition->replaceArgument(0, $configs[0]['openai_key'])
            ->replaceArgument(2, $configs[0]['is_debug']);
    }
}
