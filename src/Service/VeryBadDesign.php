<?php


namespace App\Service;


use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class VeryBadDesign implements ContainerAwareInterface
{

    /**
     * @param ContainerInterface|null $container
     * @required
     */

    /* 4. Service tags  USE
     * service or alias has been removed or inlined when the container was compiled. You should either make it public,
    or stop using the container directly and use dependency injection instead.
    */

    public function setContainer(ContainerInterface $container = null)
    {
        //using the container directly
       // $container->get('app.greeting');
       // $container->get(Greeting::class);
    }
}