<?php


namespace App\Service;



use Psr\Log\LoggerInterface;

class Greeting
{

    private $logger;
    /**
     * @var string
     */
    private $message;

    public function __construct(LoggerInterface $logger, string $message)
    {
        $this->logger =$logger;

        //$message is type-hinted "string", you should configure its value explicitly. in services.yaml file
        $this->message = $message;
    }

    public function greet(string $name): string
    {
        $this->logger->info("Hello from service logger $name");
        return "{$this->message} $name";
    }
}