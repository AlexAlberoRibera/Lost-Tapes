<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Solo administradores pueden ver el listado completo
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        // Solo administradores pueden ver detalles de productos
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Solo administradores pueden crear productos
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        // Solo administradores pueden actualizar productos
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        // Solo administradores pueden eliminar productos
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can import products.
     */
    public function import(User $user): bool
    {
        // Solo administradores pueden importar productos
        return $user->role === 'admin';
    }
}