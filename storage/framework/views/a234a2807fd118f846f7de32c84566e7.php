<?php $__env->startSection('title', "Importar Productos"); ?>

<?php $__env->startSection('content'); ?>

<h1 class="text-3xl font-bold text-blue-800 mb-6">
    Importar Productos
</h1>


<?php if(session('success')): ?>
    <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>


<?php if($errors->any()): ?>
    <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
        <ul class="list-disc ml-5">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>


<div class="bg-white shadow p-6 rounded-lg max-w-lg">

    <form action="<?php echo e(route('products.import')); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
        <?php echo csrf_field(); ?>

        <div>
            <label class="block font-bold mb-2">
                Archivo Excel
            </label>

            <input type="file"
                   name="excel_file"
                   class="border p-2 w-full rounded"
                   required>
        </div>

        <br><button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Importar productos
        </button>
    </form>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.products', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/products/import.blade.php ENDPATH**/ ?>