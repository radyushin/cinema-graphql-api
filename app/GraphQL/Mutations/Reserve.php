<?php

namespace App\GraphQL\Mutations;

use GraphQL\Error\Error;
use GraphQL\Type\Definition\ResolveInfo;
use App\Order;
use App\Session;
use App\Seat;

/**
 * Class Reserve
 * @package App\GraphQL\Mutations
 */
class Reserve
{
    public function resolve($rootValue, array $args, $context, ResolveInfo $resolveInfo)
    {
        $session = $args['session'];
        $seat = $args['seat'];

        try {
            $session = Session::findOrFail($session);
        } catch (\Exception $e) {
            throw new Error("No session with ID {$args['session']}");
        }

        try {
            $seat = Seat::findOrFail($seat);
        } catch (\Exception $e) {
            throw new Error("No seat with ID {$args['seat']}");
        }

        $orderExists = Order::where('session_id', $session->id)->where('seat_id', $seat->id)->exists();

        if ($orderExists) {
            throw new Error('The seat is already accupied');
        }

        $order = Order::create([
            'session_id' => $session->getKey(),
            'seat_id' => $seat->getKey(),
        ]);

        return Order::with(['session', 'seat'])->find($order->id);
    }
}
