# config valid only for current version of Capistrano
# lock '3.4.0'

set :application, 'utang-store'
set :repo_url, 'git@github.com:simplyniceweb/utang-store.git'

# Default branch is :master
ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default value for :linked_files is []
set :linked_files, fetch(:linked_files, []).push('.env')
# Default value for linked_dirs is []
set :linked_dirs, fetch(:linked_dirs, []).push('public/upload')
# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }# Default value for keep_releases is 5
# set :keep_releases, 5
set :composer_install_flags, '--no-dev --no-interaction --optimize-autoloader --ignore-platform-reqs'
# SSHKit.config.command_map[:composer] = "php
#{shared_path.join("composer.phar")}"
SSHKit.config.command_map[:composer] = "composer"

namespace :deploy do
  desc 'Restart application'
  task :restart do
    on roles(:app), in: :sequence, wait: 5 do
    # execute "cd #{release_path} && ./vendor/bin/doctrine orm:clear-cache:query"
     # execute "cd #{release_path} && ./vendor/bin/doctrine orm:clear-cache:result"
     # execute "cd #{release_path} && ./vendor/bin/doctrine orm:clear-cache:metadata"
     #  execute "cd #{release_path} && ./vendor/bin/doctrine orm:schema-tool:update --force"
     # execute "cd #{release_path} && php bin/console doctrine:migrations:diff && php bin/console doctrine:migrations:migrate"
     execute "cd #{release_path} && php bin/console doctrine:schema:update --force"
     end
  end

  after :publishing, :restart

   after :restart, :clear_cache do
    on roles(:web), in: :groups, limit: 3, wait: 10 do
      # Here we can do anything such as:
      # within release_path do
      #   execute :rake, 'cache:clear'
      # end
      #
    end
  end
  end