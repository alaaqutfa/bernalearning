<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Expense;
use App\Models\Order;
use Illuminate\Http\Request;

// optional

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'level']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function addPaymentLink(Request $request, Order $order)
    {
        // فقط للطلبات pending
        if ($order->status !== 'pending') {
            return back()->with('error', 'لا يمكن إضافة رابط دفع لهذا الطلب.');
        }

        $request->validate([
            'payment_link' => 'required|url',
        ]);

        $order->update([
            'payment_link'            => $request->payment_link,
            'payment_link_created_at' => now(),
            'status'                  => 'payment_link_added',
            'notes'                   => $request->notes,
        ]);

        // يمكن إرسال إشعار للمستخدم (اختياري)
        // Mail::to($order->user->email)->send(new PaymentLinkCreated($order));

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'تم إضافة رابط الدفع وتحديث الحالة.');
    }

    public function confirmPayment(Request $request, Order $order)
    {
        if ($order->status !== 'pending_review') {
            return back()->with('error', 'الطلب ليس بانتظار المراجعة.');
        }

        $whishFee = $order->amount * 0.04;
        $netPrice = $order->amount - $whishFee;

        // إنشاء كوبون للمستخدم
        $coupon = Coupon::create([
            'code'             => strtoupper(uniqid('BL-')),
            'user_id'          => $order->user_id,
            'level_id'         => $order->level_id,
            'price'            => $order->amount,
            'profit_owner'     => $order->amount * 0.75,
            'profit_developer' => $order->amount * 0.25,
            'is_active'        => true,
        ]);

        Expense::create([
            'title'        => 'عمولة دفع Whish للطلب #' . $order->id,
            'amount'       => $whishFee,
            'type'         => 'other', // أو 'payment_gateway'
            'expense_date' => now(),
            'description'  => 'عمولة 4% على عملية الدفع عبر Whish',
        ]);

        $order->update([
            'status' => 'paid',
            'notes'  => $request->notes,
        ]);

        // يمكن إرسال إشعار للمستخدم
        // Mail::to($order->user->email)->send(new PaymentConfirmed($order, $coupon));

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'تم تأكيد الدفع وإنشاء الكوبون للمستخدم.');
    }

    public function cancel(Request $request, Order $order)
    {
        $order->update([
            'status' => 'cancelled',
            'notes'  => $request->notes,
        ]);

        return back()->with('success', 'تم إلغاء الطلب.');
    }
}
