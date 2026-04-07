<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $authUser): bool
    {
        // hanya user bukan operator atau leader bisa lihat index
        return !in_array($authUser->role, ['operator', 'leader']);
    }

    public function view(User $authUser, User $user): bool
    {
        return !in_array($authUser->role, ['operator', 'leader']);
    }

    public function create(User $authUser): bool
    {
        return !in_array($authUser->role, ['operator', 'leader']);
    }

    public function update(User $authUser, User $user): bool
    {
        return !in_array($authUser->role, ['operator', 'leader']);
    }

    public function delete(User $authUser, User $user): bool
    {
        return !in_array($authUser->role, ['operator', 'leader', 'foreman']);
    }
}
