<?php
/**
 * This file is part of the Ray.DoctrineOrmModule package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\DoctrineOrmModule;

use Ray\Di\AbstractModule;

class DoctrineOrmModule extends AbstractModule
{
    /**
     * @var array
     */
    private $params;

    /**
     * @var array
     */
    private $paths;

    /**
     * Constructor.
     *
     * @param array $params
     * @param array $paths
     */
    public function __construct(array $params, array $paths)
    {
        $this->params = $params;
        $this->paths = $paths;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->install(new EntityManagerModule($this->params, $this->paths));
        $this->install(new TransactionalModule);
    }
}
