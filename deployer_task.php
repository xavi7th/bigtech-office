<?php
namespace Deployer;

// set('release_path', '{{release_path}}/main');

set('laravel_version', function () {
    $result = run('cd {{release_path}}/main && {{bin/php}} artisan --version');

    preg_match_all('/(\d+\.?)+/', $result, $matches);

    $version = $matches[0][0] ?? 5.5;

    return $version;
});

// set('shared_files', [
//     './main/.env',
// ]);

desc('cd into main folder');
task('app:custom_deploy_vendor', function () {
  run('cd {{release_path}}/main && {{bin/composer}} {{composer_options}}');
});

desc('change release path');
task('app:change_release_path', function () {
  set('release_path', '{{release_path}}/main');
});

desc('copy shared files');
task('app:shared:copy', function () {
    upload('.env.example', '{{deploy_path}}/shared/main');
    upload('.env', '{{deploy_path}}/shared/main');
    run('mv -f {{deploy_path}}/shared/main/.env.example {{deploy_path}}/shared/main/.env');
    run('unlink {{deploy_path}}/shared/public_html/mix-manifest.json');
    upload('../public_html/css/', '{{deploy_path}}/shared/public_html/css');
    upload('../public_html/js/', '{{deploy_path}}/shared/public_html/js');
    upload('../public_html/fonts/', '{{deploy_path}}/shared/public_html/fonts');
    upload('../public_html/img/', '{{deploy_path}}/shared/public_html/img');
    upload('../public_html/mix-manifest.json', '{{deploy_path}}/shared/public_html');
});


desc('Execute artisan storage:link');
task('app:artisan:storage:link', function () {
    $needsVersion = 5.3;
    $currentVersion = get('laravel_version');

    if (version_compare($currentVersion, $needsVersion, '>=')) {
        run('cd {{release_path}}/main && {{bin/php}} artisan storage:link');
    }
});


desc('Disable maintenance mode');
task('artisan:up', function () {
    $output = run('if [ -f {{deploy_path}}/current/artisan ]; then {{bin/php}} {{deploy_path}}/current/artisan up; fi');
    writeln('<info>' . $output . '</info>');
});

desc('Enable maintenance mode');
task('artisan:down', function () {
    $output = run('if [ -f {{deploy_path}}/current/artisan ]; then {{bin/php}} {{deploy_path}}/current/artisan down; fi');
    writeln('<info>' . $output . '</info>');
});

desc('Execute artisan migrate');
task('app:artisan:migrate', function () {
    run('{{bin/php}} {{release_path}}/main/artisan migrate --force');
})->once();

desc('Execute artisan migrate:fresh');
task('app:artisan:migrate:fresh', function () {
    run('{{bin/php}} {{release_path}}/main/artisan migrate:fresh --force');
});

desc('Execute artisan migrate:rollback');
task('app:artisan:migrate:rollback', function () {
    $output = run('{{bin/php}} {{release_path}}/main/artisan migrate:rollback --force');
    writeln('<info>' . $output . '</info>');
});

desc('Execute artisan migrate:status');
task('app:artisan:migrate:status', function () {
    $output = run('{{bin/php}} {{release_path}}/main/artisan migrate:status');
    writeln('<info>' . $output . '</info>');
});

desc('Execute artisan db:seed');
task('app:artisan:db:seed', function () {
    $output = run('{{bin/php}} {{release_path}}/main/artisan db:seed --force');
    writeln('<info>' . $output . '</info>');
});

desc('Execute artisan cache:clear');
task('app:artisan:cache:clear', function () {
    run('{{bin/php}} {{release_path}}/main/artisan cache:clear');
});

desc('Execute artisan config:cache');
task('app:artisan:config:cache', function () {
    run('{{bin/php}} {{release_path}}/main/artisan config:cache');
});

desc('Execute artisan route:cache');
task('app:artisan:route:cache', function () {
    run('{{bin/php}} {{release_path}}/main/artisan route:cache');
});

desc('Execute artisan view:clear');
task('app:artisan:view:clear', function () {
    run('{{bin/php}} {{release_path}}/main/artisan view:clear');
});

desc('Execute artisan view:cache');
task('app:artisan:view:cache', function () {
    $needsVersion = 5.6;
    $currentVersion = get('laravel_version');

    if (version_compare($currentVersion, $needsVersion, '>=')) {
        run('{{bin/php}} {{release_path}}/main/artisan view:cache');
    }
});

desc('Execute artisan event:cache');
task('app:artisan:event:cache', function () {
    $needsVersion = '5.8.9';
    $currentVersion = get('laravel_version');

    if (version_compare($currentVersion, $needsVersion, '>=')) {
        run('{{bin/php}} {{release_path}}/main/artisan event:cache');
    }
});

desc('Execute artisan event:clear');
task('app:artisan:event:clear', function () {
    $needsVersion = '5.8.9';
    $currentVersion = get('laravel_version');

    if (version_compare($currentVersion, $needsVersion, '>=')) {
        run('{{bin/php}} {{release_path}}/main/artisan event:clear');
    }
});

desc('Execute artisan optimize');
task('app:artisan:optimize', function () {
    $deprecatedVersion = 5.5;
    $readdedInVersion = 5.7;
    $currentVersion = get('laravel_version');

    if (
        version_compare($currentVersion, $deprecatedVersion, '<') ||
        version_compare($currentVersion, $readdedInVersion, '>=')
    ) {
       run('{{bin/php}} {{release_path}}/main/artisan optimize');
    }
});

desc('Execute artisan optimize:clear');
task('app:artisan:optimize:clear', function () {
    $needsVersion = 5.7;
    $currentVersion = get('laravel_version');

    if (version_compare($currentVersion, $needsVersion, '>=')) {
        run('{{bin/php}} {{release_path}}/main/artisan optimize:clear');
    }
});

desc('Execute artisan queue:restart');
task('app:artisan:queue:restart', function () {
    run('{{bin/php}} {{release_path}}/main/artisan queue:restart');
});
