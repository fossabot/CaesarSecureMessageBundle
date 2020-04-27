<?

namespace Caesar\SecurityMessageBundle\DependencyInjection;

use Exception;
use Caesar\SecurityMessageBundle\Service\SecureMessageManager;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SecurityMessageExtension extends Extension
{
    const KEY_SECURE_MESSAGE_MANAGER = '$client';

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $managerDefinition = $container->findDefinition(SecureMessageManager::class);
        $managerDefinition->setArgument(self::KEY_SECURE_MESSAGE_MANAGER, new Reference($configs[0]['client']));
    }
}
