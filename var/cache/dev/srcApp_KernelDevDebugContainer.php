<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerJreIXa4\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerJreIXa4/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerJreIXa4.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerJreIXa4\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerJreIXa4\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'JreIXa4',
    'container.build_id' => '72812c9a',
    'container.build_time' => 1623747298,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerJreIXa4');
