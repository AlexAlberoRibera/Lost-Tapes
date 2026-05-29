<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config
set('application', 'Lost-Tapes');
set('repository', 'https://github.com/AlexAlberoRibera/Lost-Tapes.git');
set('git_tty', true);
set('branch', 'documentacionApi');

set('writable_dirs', [
    'storage',
    'bootstrap/cache',
]);

set('shared_files', [
    '.env',
]);

set('shared_dirs', [
    'storage',
]);

// Hosts

host('44.193.254.173')  //ip de la maquina
    ->set('remote_user', 'deploy')
    //->set('identity_file’, ‘~/.ssh/id_rsa')
    ->set('deploy_path', '/var/www/Lost-Tapes');


    task('reload:php-fpm', function () {
        run('sudo /etc/init.d/php8.3-fpm restart');
       });

task('npm:build', function () {
            run('cd {{release_path}} && npm ci');
            run('cd {{release_path}} && npm run build');
            //run('cd /var/www/Lost-Tapes/current/api && npm run dev');
       });
// Hooks

after('deploy:vendors', 'npm:build');
after('deploy', 'reload:php-fpm');


before('deploy:symlink', 'artisan:migrate');






