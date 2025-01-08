<?php

namespace App\Custom\Chatify;

use Chatify\ChatifyMessenger;
use App\Models\ChMessage as Message;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CustomChatify extends ChatifyMessenger
{
    public function newMessage($data)
    {
        $message = new Message();
        $message->from_id = $data['from_id'];
        $message->to_id = $data['to_id'];
        $message->body = $data['body'];
        $message->attachment = $data['attachment'];

        if (isset($data['product_id'])) {
            $message->product_id = $data['product_id'];
        }
        if (isset($data['order_id'])) {
            $message->order_id = $data['order_id'];
        }

        $message->save();
        return $message;
    }


    public function parseMessage($prefetchedMessage = null, $id = null, $context_id = null)
    {
        $msg = null;
        $attachment = null;
        $attachment_type = null;
        $attachment_title = null;

        if (!!$prefetchedMessage) {
            $msg = $prefetchedMessage;
        } else {
            $msg = Message::where('id', $id)->first();
            if (!$msg) {
                return [];
            }
        }

        if (isset($msg->attachment)) {
            $attachmentOBJ = json_decode($msg->attachment);
            $attachment = $attachmentOBJ->new_name;
            $attachment_title = htmlentities(trim($attachmentOBJ->old_name), ENT_QUOTES, 'UTF-8');
            $ext = pathinfo($attachment, PATHINFO_EXTENSION);
            $attachment_type = in_array($ext, $this->getAllowedImages()) ? 'image' : 'file';
        }

        // added attribute
        $product_id = $msg->product_id ?? null;
        $order_id = $msg->order_id ?? null;

        $product = null;
        if ($msg->product_id) {
            $product = Product::select('id', 'name', 'slug', 'image', 'description')->where("id", $product_id)->first();
        }

        $order = null;
        if ($order_id) {
            $order = Order::select('id', 'status', 'total_order_price')
                ->with(['shipping:id,order_id,tracking_number,estimate_day'])
                ->where("id", $order_id)
                ->first();
        }

        return [
            'id' => $msg->id,
            'from_id' => $msg->from_id,
            'to_id' => $msg->to_id,
            'message' => $msg->body,
            'attachment' => (object) [
                'file' => $attachment,
                'title' => $attachment_title,
                'type' => $attachment_type
            ],
            'timeAgo' => $msg->created_at->diffForHumans(),
            'created_at' => $msg->created_at->toIso8601String(),
            'isSender' => ($msg->from_id == Auth::user()->id),
            'seen' => $msg->seen,

            'product_id' => $product_id,
            'order_id' => $order_id,
            'product' => $product ?? null,
            'order' => $order ?? null,
        ];
    }

    // public function fetchMessagesQuery($user_id)
    // {
    //     return Message::with('product', 'order')->where('from_id', Auth::user()->id)->where('to_id', $user_id)
    //         ->orWhere('from_id', $user_id)->where('to_id', Auth::user()->id);
    // }
}
