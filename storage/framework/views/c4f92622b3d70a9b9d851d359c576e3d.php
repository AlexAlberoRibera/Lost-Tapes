<?php $__env->startSection('title', "Lost Tapes"); ?>

<?php $__env->startSection('content'); ?>
<h1 class="text-3xl font-bold text-blue-800 mb-6">Guia de Productos</h1>

<?php if(session('success')): ?>
  <div class="bg-green-100 text-green-700 p-2 mb-4"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', Product::class)): ?>
<p class="mb-4">
  <a href="<?php echo e(route('admin.products.create')); ?>" class="bg-blue-600 text-white px-3 py-2 rounded">Nuevo Producto</a>
</p>
<?php endif; ?>

<table class="w-full border-collapse border border-gray-300">
  <thead class="bg-gray-200">
  <tr>
    <th class="border border-gray-300 p-2"><?php echo e(__('Nombre')); ?></th>
    <th class="border border-gray-300 p-2"><?php echo e(__('Descripcion')); ?></th>
    <th class="border border-gray-300 p-2"><?php echo e(__('Acciones')); ?> </th>
  </tr>
  </thead>
  <tbody>
  <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr class="hover:bg-gray-100">
      <td class="border border-gray-300 p-2">
        <a href="<?php echo e(route('admin.products.show',  $product->id)); ?>" class="text-blue-700 hover:underline"><?php echo e($product->name); ?></a>
      </td>
      <td class="border border-gray-300 p-2"><?php echo e($product->description); ?></td>
      <td class="border border-gray-300 p-2 flex space-x-2">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $product)): ?>
            <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>"
              class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 flex items-center space-x-1">
                <span>✏️</span>
            </a>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete',$product)): ?>
            <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST"
              onsubmit="return confirm('Segur que vols eliminar?')">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit"
                        class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700 flex items-center space-x-1">
                    <span>🗑️</span>
                </button>
            </form>
        <?php endif; ?>
    </td>
    </tr>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.products', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/products/index.blade.php ENDPATH**/ ?>