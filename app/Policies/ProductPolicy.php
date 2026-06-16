<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

// Solo se comprueban los roles admin y vendedor; el ProductController aplica
// este policy mediante RoleMiddleware en las rutas protegidas.
class ProductPolicy
{
    private function canManage(User $user): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    public function viewAny(User $user): bool
    {
        return $this->canManage($user);
    }

    public function view(User $user, Product $product): bool
    {
        return $this->canManage($user);
    }

    public function create(User $user): bool
    {
        return $this->canManage($user);
    }

    public function update(User $user, Product $product): bool
    {
        return $this->canManage($user);
    }

    public function delete(User $user, Product $product): bool
    {
        return $this->canManage($user);
    }
}
