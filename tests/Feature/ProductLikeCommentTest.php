<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductLikeCommentTest extends TestCase
{
    use RefreshDatabase;

    private function createProduct(): Product
    {
        return Product::create([
            'sku'         => 'TEST-001',
            'name'        => 'Película test',
            'description' => 'Descripción test',
            'price'       => 19.99,
            'stock'       => 10,
            'category'    => 'Drama',
        ]);
    }

    // ── LIKES ──────────────────────────────────────────────────

    public function test_like_requires_auth(): void
    {
        $product = $this->createProduct();
        $this->postJson("/api/products/{$product->id}/like")
             ->assertStatus(401);
    }

    public function test_user_can_like_product(): void
    {
        $user    = User::factory()->create();
        $product = $this->createProduct();

        $response = $this->actingAs($user)
                         ->postJson("/api/products/{$product->id}/like");

        $response->assertStatus(200)
                 ->assertJson(['liked' => true, 'likes_count' => 1]);

        $this->assertDatabaseHas('product_likes', [
            'product_id' => $product->id,
            'user_id'    => $user->id,
        ]);
    }

    public function test_second_like_removes_it(): void
    {
        $user    = User::factory()->create();
        $product = $this->createProduct();

        $this->actingAs($user)->postJson("/api/products/{$product->id}/like");
        $response = $this->actingAs($user)->postJson("/api/products/{$product->id}/like");

        $response->assertStatus(200)
                 ->assertJson(['liked' => false, 'likes_count' => 0]);

        $this->assertDatabaseMissing('product_likes', [
            'product_id' => $product->id,
            'user_id'    => $user->id,
        ]);
    }

    // ── COMENTARIOS ────────────────────────────────────────────

    public function test_comment_requires_auth(): void
    {
        $product = $this->createProduct();
        $this->postJson("/api/products/{$product->id}/comments", ['body' => 'Hola'])
             ->assertStatus(401);
    }

    public function test_user_can_post_comment(): void
    {
        $user    = User::factory()->create();
        $product = $this->createProduct();

        $response = $this->actingAs($user)
                         ->postJson("/api/products/{$product->id}/comments", [
                             'body' => 'Gran película',
                         ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['body' => 'Gran película']);

        $this->assertDatabaseHas('comments', [
            'product_id' => $product->id,
            'user_id'    => $user->id,
            'body'       => 'Gran película',
        ]);
    }

    public function test_empty_comment_is_rejected(): void
    {
        $user    = User::factory()->create();
        $product = $this->createProduct();

        $this->actingAs($user)
             ->postJson("/api/products/{$product->id}/comments", ['body' => ''])
             ->assertStatus(422);
    }
}
