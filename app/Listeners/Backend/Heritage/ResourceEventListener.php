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
        dd($event);
        history()->withType($this->history_slug)
            ->withEntity($event->user->id)
            ->withText('trans("history.backend.resource.created") <strong>{resource}</strong>')
            ->withIcon('plus')
            ->withClass('bg-green')
            ->withAssets([
                'user_link' => ['admin.access.user.show', $event->user->name, $event->user->id],
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
    }
}
