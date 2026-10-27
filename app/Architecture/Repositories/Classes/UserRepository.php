<?php

namespace App\Architecture\Repositories\Classes;

use App\Architecture\Repositories\Interfaces\IUserRepository;
use Carbon\Carbon;

class UserRepository extends AbstractRepository implements IUserRepository
{
    public function filter()
    {
            $query = $this->prepareQuery();
            $query->when(request()->filled('id'), function ($q) {
                $ids = explode(',', request()->input('id'));
                $q->whereIn('id', $ids);
            });
            $query->when(request()->filled('role_id'), function ($q) {
                $role_ids = explode(',', request()->input('role_id'));
                $q->whereIn('role_id', $role_ids);
            });

            $query->when(request()->filled('email'), function ($q) {
                $email = trim(request()->input('email'));

                // لو المستخدم كاتب إيميل كامل فيه علامة @ ابحث بالتطابق التام فوراً (0.001 ثانية)
                if (str_contains($email, '@')) {
                    $q->where('email', $email);
                } else {
                    // لو كاتب أول الإيميل بس، ابحث من البداية بدون % في الأول (0.01 ثانية بالـ Index)
                    $q->where('email', 'like', $email . '%');
                }
            });


            $query->when(request()->filled('phone'), function ($q) {
                    $q->where('phone', '=', request()->input('phone'));
                });


            $query->when(request()->filled('created_on_from'), function ($q) {
                $q->where('created_at', '>=', Carbon::parse(request()->input('created_on_from'))->startOfDay());
            });
            $query->when(request()->filled('created_on_to'), function ($q) {
                $q->where('created_at', '<=', Carbon::parse(request()->input('created_on_to'))->endOfDay());
            });
            $query->when(request()->filled('last_update_from'), function ($q) {
                $q->where('updated_at', '>=', Carbon::parse(request()->input('last_update_from'))->startOfDay());
            });
            $query->when(request()->filled('last_update_to'), function ($q) {
                $q->where('updated_at', '<=', Carbon::parse(request()->input('last_update_to'))->endOfDay());
            });
            return $query
                ->select('id', 'first_name', 'last_name', 'email', 'phone', 'role_id', 'image', 'national_id', 'created_at', 'updated_at')
                ->with(['role:id,name'])
                ->orderByDesc('id')
                ->paginate($this->perPage());

    }


    public function getByMobileNumber($mobile)
    {
        return $this->prepareQuery()->where('phone','=',$mobile)->first();
    }

}
