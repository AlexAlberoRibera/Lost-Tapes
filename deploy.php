<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'https://github.com/AlexAlberoRibera/Lost-Tapes.git');

add('shared_files', ['.env']);
add('shared_dirs', ['bootstrap/cache', 'storage']);
add('writable_dirs', ['bootstrap/cache', 'storage']);

// Hosts

host('34.204.192.17')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '~/Lost-Tapes-develop');

// Hooks

task('build', function () {
 run('cd {{release_path}} && build');
});
after('deploy:failed', 'deploy:unlock');
before('deploy:symlink', 'artisan:migrate');
