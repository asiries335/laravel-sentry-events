<?php
namespace Asisries335\Integrations;

use Asisries335\Events\SentryEvent;
use Illuminate\Contracts\Events\Dispatcher;
use Sentry\Event;
use Sentry\Integration\IntegrationInterface;
use Sentry\State\Scope;

class ListenerEventIntegration implements IntegrationInterface
{
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function setupOnce(): void
    {
        Scope::addGlobalEventProcessor(function (Event $event){
            $this->dispatcher->dispatch(new SentryEvent($event));

            return $event;
        });
    }
}