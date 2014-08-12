# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "javiercaride/trusty64"

  config.vm.network "private_network", ip: "192.168.33.10"

  config.vm.synced_folder "./src/symfony2", "/var/www/phporchestra", type: "nfs"
  config.vm.synced_folder "../phporchestra-front-demo", "/var/www/front-phporchestra", type: "nfs"

# Ansible
  config.vm.provision "ansible" do |ansible|
    ansible.sudo = true
    ansible.playbook = "provisioning/site.yml"
    ansible.verbose = "v"
  end
end
