@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>إنشاء مستخدم جديد</h2>
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="form-group">
            <label>الاسم</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <label>البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
        </div>
        <div class="form-group">
            <label>رقم الهاتف</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>
        <div class="form-group">
            <label>كلمة المرور</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">حفظ</button>
    </form>
</div>
@endsection
