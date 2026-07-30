<?php

namespace App\Architecture\Repositories\Classes;

use App\Architecture\Repositories\Interfaces\IUserRepository;
use App\Enum\UserType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserRepository extends AbstractRepository implements IUserRepository
{
    public function filter()
    {
        $query = $this->prepareQuery()
            ->when(request()->filled('id'), function ($q) {
                $ids = explode(',', request()->input('id'));
                $q->whereIn('id', $ids);
            })
            ->when(request()->filled('role_id'), function ($q) {
                $role_ids = explode(',', request()->input('role_id'));
                $q->whereIn('role_id', $role_ids);
            })

            ->when(request()->filled('email'), function ($q) {
                $q->where('email', 'like', '%' . request()->input('email') . '%');
            })
            ->when(request()->filled('mobile_number'), function ($q) {
                $q->where('phone', 'like', '%' . request()->input('mobile_number') . '%');
            })

            ->when(request()->filled('created_on_from'), function ($q) {
                $q->where('created_at', '>=', Carbon::parse(request()->input('created_on_from'))->startOfDay());
            })
            ->when(request()->filled('created_on_to'), function ($q) {
                $q->where('created_at', '<=', Carbon::parse(request()->input('created_on_to'))->endOfDay());
            })
            ->when(request()->filled('last_update_from'), function ($q) {
                $q->where('updated_at', '>=', Carbon::parse(request()->input('last_update_from'))->startOfDay());
            })
            ->when(request()->filled('last_update_to'), function ($q) {
                $q->where('updated_at', '<=', Carbon::parse(request()->input('last_update_to'))->endOfDay());
            })

            ->when(request()->filled('search'), function ($q) {
                $search = request()->input('search');
                $q->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                        ->orWhere('email', $search)
                        ->orWhere('phone', $search)
                        ->orWhere('id', $search);
                });
            })
            ->with(['role']);

        return $query
            ->orderByDesc('id')
            ->paginate($this->perPage());
    }

    public function getByMobileNumber($mobile)
    {
        return $this->prepareQuery()->whereIn('mobile', $this->mobileVariations($mobile))->first();
    }

    private function mobileVariations($mobile)
    {
        return [
            str($mobile)->start('0')->toString(),
            str_starts_with($mobile, '0') ? substr($mobile, 1) : $mobile
        ];
    }
}
