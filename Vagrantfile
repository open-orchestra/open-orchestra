# -*- mode: ruby -*-
# vi: set ft=ruby :

$HOSTNAME = "openorchestra.2-0.dev"

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "bento/debian-8.4"
  config.vm.hostname = $HOSTNAME

  config.vm.network "private_network", ip: "192.168.33.13"

  config.vm.provider "virtualbox" do |v|
    v.memory = 2048
  end
  config.vm.synced_folder "./", "/var/www/openorchestra", type: "nfs"
  config.vm.synced_folder "../open-orchestra-front-demo", "/var/www/front-openorchestra", type: "nfs"
  config.vm.synced_folder "../open-orchestra-media-demo", "/var/www/media-openorchestra", type: "nfs"

# Ansible
  config.vm.provision "ansible" do |ansible|
    ansible.sudo = true
    ansible.limit = "vagrant"
    ansible.inventory_path = "provisioning/hosts/vagrant"
    ansible.playbook = "../open-orchestra-provision/site.yml"
    ansible.verbose = "v"
  end
end
