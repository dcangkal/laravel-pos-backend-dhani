<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $type_menu = 'order';
        $orders = Order::with('kasir')->orderBy('created_at', 'desc')->paginate(10);
        return view('pages.orders.index', compact('orders', 'type_menu'));
    }

    public function show($id)
    {
        $type_menu = 'order';
        $orders = Order::with('kasir')->findOrFail($id);
        $orderItems = OrderItem::with('product')->where('order_id', $id)->get();
        return view('pages.orders.detail', compact('orders', 'orderItems', 'type_menu'));
    }
}
