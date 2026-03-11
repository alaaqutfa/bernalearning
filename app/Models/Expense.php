<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'title', 'description', 'amount', 'currency', 'type',
        'expense_date', 'receipt_path', 'is_recurring', 'recurring_months'
    ];

    protected $casts = [
        'expense_date' => 'date',
        'is_recurring' => 'boolean',
        'amount' => 'decimal:2',
    ];

    public static function getMonthlyExpenses($year, $month)
    {
        return self::whereYear('expense_date', $year)
            ->whereMonth('expense_date', $month)
            ->sum('amount');
    }

    public static function getYearlyExpenses($year)
    {
        return self::whereYear('expense_date', $year)->sum('amount');
    }
}
