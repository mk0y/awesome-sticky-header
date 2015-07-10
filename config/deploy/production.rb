role :app, %w{ubuntu@awesomeheader.com}
#role :web, %w{ubuntu@awesomeheader.com}
#role :db,  %w{ubuntu@awesomeheader.com}

#server '54.225.109.46', user: 'ubuntu', roles: %w{web app db}
set :deploy_to, '/home/ubuntu/www/asmh/wp-content/awesomeheader-repo'

set :ssh_options, {
  keys: %w(/home/marko/Amazon-Marko/bayern85.pem),
  forward_agent: false
}

set :plugin_path, "/home/ubuntu/www/asmh/wp-content/plugins/awesomeheader"

namespace :plugin do
  desc '*** *** Copy plugin files *** ***'
  task :copy do
    on roles(:app) do
      within fetch(:plugin_path) do
        execute "cp -r #{release_path}/* #{fetch(:plugin_path)}"
      end
    end
  end
end

before 'deploy:updated', 'plugin:copy'
