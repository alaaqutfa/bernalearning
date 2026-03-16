<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Auth::user()->orders()->with('level')->latest()->get();
        return view('web.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // التأكد أن المستخدم يملك هذا الطلب
        if ($order->user_id != Auth::id()) {
            abort(403);
        }
        return view('web.orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_id' => 'required|exists:levels,id',
        ]);

        $level = Level::findOrFail($request->level_id);

        // التحقق من عدم وجود طلب Paid مسبق لهذا المستوى
        $existingPaid = Auth::user()->orders()
            ->where('level_id', $level->id)
            ->where('status', 'paid')
            ->exists();

        if ($existingPaid) {
            return redirect()->route('levels.show', $level)
                ->with('error', 'أنت مشترك بالفعل في هذا المستوى.');
        }

        // سنقوم بإنشاء طلب جديد
        $order = Order::create([
            'user_id' => Auth::id(),
            'level_id' => $level->id,
            'amount' => $level->price,
            'status' => 'pending',
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'تم إنشاء طلب الاشتراك. يرجى متابعة خطوات الدفع.');
    }

    public function uploadReceipt(Request $request, Order $order)
    {
        if ($order->user_id != Auth::id()) {
            abort(403);
        }

        if (!in_array($order->status, ['payment_link_added', 'pending'])) {
            return back()->with('error', 'لا يمكن رفع إيصال في هذه الحالة.');
        }

        $request->validate([
            'receipt' => 'required|image|max:2048',
        ]);

        $path = $request->file('receipt')->store('receipts', 'public');

        $order->update([
            'receipt_image' => $path,
            'status' => 'pending_review',
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'تم رفع الإيصال، بانتظار مراجعة الإدارة.');
    }
}
