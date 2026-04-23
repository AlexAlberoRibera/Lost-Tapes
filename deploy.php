<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config
set('application', 'Lost-Tapes');
set('repository', 'https://github.com/AlexAlberoRibera/Lost-Tapes.git');
set('git_tty', true);

add('shared_files', []);
add('shared_dirs', []);
//add('writable_dirs', []);

// Hosts

host('100.30.196.101')
    ->set('remote_user', 'deploy')
    //->set('identity_file’, ‘~/.ssh/id_rsa')
    ->set('deploy_path', '/var/www/Lost-Tapes');


task('build', function () {
    run('cd {{release_path}} && build');
    });
// Hooks

after('deploy:failed', 'deploy:unlock');

before('deploy:symlink', 'artisan:migrate');






