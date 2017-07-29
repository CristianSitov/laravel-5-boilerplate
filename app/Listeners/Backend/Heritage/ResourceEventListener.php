<?php

namespace App\Listeners\Backend\Heritage;

/**
 * Class UserEventListener.
 */
class ResourceEventListener
{
    /**
     * @var string
     */
    private $history_slug = 'Resource';

    /**
     * @param $event
     */
    public function onCreated($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->resource->id)
            ->withText('trans("history.backend.resource.created") <strong>{resource}</strong>')
            ->withIcon('plus')
            ->withClass('bg-green')
            ->withAssets([
                'user_link' => ['admin.heritage.resource.show', $event->resource->name, $event->resource->id],
            ])
            ->log();
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->resource->id)
            ->withText('trans("history.backend.resource.updated") <strong>{resource}</strong>')
            ->withIcon('plus')
            ->withClass('bg-yellow')
            ->withAssets([
                'user_link' => ['admin.heritage.resource.show', $event->resource->name, $event->resource->id],
            ])
            ->log();
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Backend\Heritage\ResourceCreated::class,
            'App\Listeners\Backend\Heritage\ResourceEventListener@onCreated'
        );
        $events->listen(
            \App\Events\Backend\Heritage\ResourceUpdated::class,
            'App\Listeners\Backend\Heritage\ResourceEventListener@onUpdated'
        );
    }
}
