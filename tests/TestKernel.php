<?php //declare(strict_types=1);
//
//use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
//use Incompass\SharedBundle\SharedBundle;
//use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
//use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
//use Symfony\Bundle\SecurityBundle\SecurityBundle;
//use Symfony\Component\Config\Loader\LoaderInterface;
//use Symfony\Component\DependencyInjection\ContainerBuilder;
//use Symfony\Component\HttpKernel\Bundle\BundleInterface;
//use Symfony\Component\Routing\RouteCollectionBuilder;
//
///**
// * Class Kernel
// * @package Tests\Incompass\SoftDeleteableBundle
// */
//class TestKernel extends \Symfony\Component\HttpKernel\Kernel
//{
//    use MicroKernelTrait;
//
//    /**
//     * Returns an array of bundles to register.
//     *
//     * @return iterable|BundleInterface[] An iterable of bundle instances
//     */
//    public function registerBundles()
//    {
//        return [
//            new FrameworkBundle(),
//            new SecurityBundle(),
//            new SharedBundle(),
//            new DoctrineBundle()
//        ];
//    }
//
//    /**
//     * Add or import routes into your application.
//     *
//     *     $routes->import('config/routing.yml');
//     *     $routes->add('/admin', 'AppBundle:Admin:dashboard', 'admin_dashboard');
//     *
//     * @param RouteCollectionBuilder $routes
//     */
//    protected function configureRoutes(RouteCollectionBuilder $routes): void
//    {
//
//    }
//
//    /**
//     * Configures the container.
//     *
//     * You can register extensions:
//     *
//     * $c->loadFromExtension('framework', array(
//     *     'secret' => '%secret%'
//     * ));
//     *
//     * Or services:
//     *
//     * $c->register('halloween', 'FooBundle\HalloweenProvider');
//     *
//     * Or parameters:
//     *
//     * $c->setParameter('halloween', 'lot of fun');
//     *
//     * @param ContainerBuilder $c
//     * @param LoaderInterface $loader
//     */
//    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader): void
//    {
//        $c->setParameter('sqs_queue_region', 'region');
//        $c->setParameter('sqs_version', 'latest');
//        $c->setParameter('aws_access_key_id', 'key');
//        $c->setParameter('aws_secret_key', 'key');
//        $c->setParameter('sqs_queue_url', null);
//        $c->setParameter('api2_sqs_proxy_url', 'proxy_url');
//        $c->setParameter('api2_sqs_proxy_username', 'proxy_username');
//        $c->setParameter('api2_sqs_proxy_password', 'proxy_password');
//        $c->setParameter('kernel.secret', 'secret');
//        $c->loadFromExtension('security', [
//            'hide_user_not_found' => true,
//            'providers' => [
//                'in_memory_provider' => [
//                    'memory' => [
//                        'users' => [
//                            'foo' => [
//                                'password' => 'foo',
//                                'roles' => 'ROLE_USER'
//                            ]
//                        ]
//                    ]
//                ]
//            ],
//            'firewalls' => [
//                'default' => [
//                    'security' => false,
//                    'stateless' => true
//                ]
//            ]
//        ]);
//        $c->loadFromExtension('doctrine', [
//            'dbal' => [
//                'driver' => 'pdo_sqlite',
//                'memory' => true
//            ],
//            'orm' => [
//                'default_entity_manager' => 'default',
//            ]
//        ]);
//    }
//
//    /**
//     * @return string
//     */
//    public function getCacheDir(): string
//    {
//        return __DIR__.'/../var/cache/';
//    }
//
//    /**
//     * @return string
//     */
//    public function getLogDir(): string
//    {
//        return __DIR__.'/../var/log';
//    }
//}