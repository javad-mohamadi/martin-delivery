<?php

namespace App\Http\Requests\Abstracts;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class BaseRequest extends FormRequest
{
    /**
     *
     * @var string
     */
    protected string $forbidFunction = '';

    /**
     * check if a user has permission to perform an action.
     * User can set multiple permissions (separated with "|") and if the user has
     * any of the permissions, he will be authorized to proceed with this action.
     *
     * @param User|null $user
     *
     * @return  bool
     */
    public function hasAccess(User $user = null): bool
    {
        // if not in parameters, take from the request object {$this}
        $user = $user ?: $this->user();

        if ($user) {
            $autoAccessRoles = Config::get('permission.requests.allow-roles-to-access-all-routes');
            // there are some roles defined that will automatically grant access
            if (!empty($autoAccessRoles)) {
                $hasAutoAccessByRole = $user->hasAnyRole($autoAccessRoles);
                if ($hasAutoAccessByRole) {
                    return true;
                }
            }
        }

        // check if the user has any role / permission to access the route
        $hasAccess = array_merge(
            $this->hasAnyPermissionAccess($user),
            $this->hasAnyRoleAccess($user)
        );

        // allow access if user has access to any of the defined roles or permissions.
        return empty($hasAccess) || in_array(true, $hasAccess);
    }

    /**
     * @param $user
     *
     * @return  array
     */
    private function hasAnyPermissionAccess($user): array
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

    /**
     * @param $user
     *
     * @return  array
     */
    private function hasAnyRoleAccess($user): array
    {
        if (!array_key_exists('roles', $this->access) || !$this->access['roles']) {
            return [];
        }

        $roles = is_array($this->access['roles']) ? $this->access['roles'] :
            explode('|', $this->access['roles']);

        return array_map(function ($role) use ($user) {
            // Note: internal return
            return $user->hasRole($role);
        }, $roles);
    }

    protected function check(array $functions, bool $returnReason = false)
    {
        $this->getValidatorInstance()->validate();

        $orIndicator = '|';
        $returns     = [];

        // iterate all functions in the array
        foreach ($functions as $function) {

            // in case the value doesn't contain a separator (single function per key)
            if (!strpos($function, $orIndicator)) {
                // simply call the single function and store the response.
                $returns[$function] = $this->{$function}();
                if (!$returns[$function]) {
                    break;
                }
            } else {
                // in case the value contains a separator (multiple functions per key)
                $orReturns = [];

                // iterate over each function in the key
                foreach (explode($orIndicator, $function) as $orFunction) {
                    // dynamically call each function
                    $orReturns[$orFunction] = $this->{$orFunction}();
                }

                // if in_array returned `true` means at least one function returned `true` thus return `true` to allow access.
                // if in_array returned `false` means no function returned `true` thus return `false` to prevent access.
                // return single boolean for all the functions found inside the same key.
                if (in_array(true, $orReturns)) {
                    $returns[] = true;
                } else {
                    foreach ($orReturns as $f => $r) {
                        if ($r == false) {
                            $returns[$f] = false;
                            break;
                        }
                    }
                }

            }
        }
        unset($r, $f);
        // if in_array returned `true` means a function returned `false` thus return `false` to prevent access.
        // if in_array returned `false` means all functions returned `true` thus return `true` to allow access.
        // return the final boolean
        if ($returnReason == false) {
            foreach ($returns as $f => $r) {
                if ($r == false) {
                    $this->forbidFunction = $f;
                    break;
                }
            }
            return !in_array(false, $returns);
        } else {
            foreach ($returns as $f => $r) {
                if ($r == false) {
                    return [$f];
                }
            }
        }
    }

    /**
     * @throws AuthorizationException
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException();
    }
}
