<?php

namespace App\Events;

use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('thread.' . $this->post->thread_id);
    }

    public function broadcastWith(): array
    {
        return [
            'id'         => $this->post->id,
            'author'     => [
                'name'   => $this->post->author->name,
            ],
            'body'       => $this->post->content,
            'created_at' => $this->post->created_at->format('H:i A'),
        ];
    }
}
