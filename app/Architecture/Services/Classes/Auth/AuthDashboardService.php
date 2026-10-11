<?php

namespace App\Architecture\Services\Classes\Auth;

class AuthDashboardService extends AuthService
{
    public function login(array $data)
    {
        try {
            $user = $this->userRepository->getData(
                conditions: ['email' => $data['email']],
                isFirst: true
            );

            if (!$user?->active) {
                return back()->with(
                    'active_user',
                    'يرجى التواصل مع المشرف الخاص بك لتفعيل الحساب.'
                );
            }

            if (!auth()->attempt([
                'email' => $data['email'],
                'password' => $data['password'],
            ])) {
                return back()->with(
                    'login_failed',
                    'بيانات الدخول غير صحيحة، برجاء إدخال البيانات الصحيحة والمحاولة مرة أخرى.'
                );
            }

            request()->session()->regenerate();

            return redirect()
                ->route('dashboard.home')
                ->with('login', 'أهلاً بك من جديد.');

        } catch (\Exception $e) {
            report($e);

            return back()->with(
                'login_error',
                'حدث خطأ أثناء معالجة الطلب، يرجى المحاولة مرة أخرى.'
            );
        }
    }

    public function logout(array $data)
    {
        try {
            auth()->logout();

            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with('logout', 'تم تسجيل الخروج بنجاح.');

        } catch (\Exception $e) {
            report($e);

            return back()->with(
                'logout_error',
                'حدث خطأ أثناء تسجيل الخروج، يرجى المحاولة مرة أخرى.'
            );
        }
    }
}
