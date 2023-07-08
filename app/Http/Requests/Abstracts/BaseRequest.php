<?php

namespace App\Http\Requests\Abstracts;

use App\Exceptions\LogicException;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class BaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        // Allow admin roles access to all routes
        if ($user) {
            $autoAccessRoles = Config::get('permission.requests.allow-roles-to-access-all-routes');
            $autoAccessRoles = explode(',', $autoAccessRoles);
            if (!empty($autoAccessRoles)) {
                $hasAutoAccessByRole = $user->hasAnyRole($autoAccessRoles);
                if ($hasAutoAccessByRole) {
                    return true;
                }
            }
        }

        $hasAccess = array_merge(
            $this->hasAnyPermissionAccess($user),
            $this->hasAnyRoleAccess($user)
        );

        return empty($hasAccess) || in_array(true, $hasAccess);
    }

    private function hasAnyPermissionAccess(User $user): array
    {
        if (!array_key_exists('permissions', $this->access) || !$this->access['permissions']) {
            return [];
        }

        $permissions = is_array($this->access['permissions']) ? $this->access['permissions'] :
            explode('|', $this->access['permissions']);

        return array_map(function ($permission) use ($user) {
            // Note: internal return
            return $user->hasPermissionTo($permission);
        }, $permissions);
    }

    private function hasAnyRoleAccess(User $user): array
    {
        if (!array_key_exists('roles', $this->access) || !$this->access['roles']) {
            return [];
        }

        $roles = is_array($this->access['roles']) ? $this->access['roles'] :
            explode('|', $this->access['roles']);

        return array_map(function ($role) use ($user) {
            return $user->hasRole($role);
        }, $roles);
    }

    protected function failedAuthorization()
    {
        throw new LogicException(Response::HTTP_FORBIDDEN, "This action is unauthorized.");
    }
}
