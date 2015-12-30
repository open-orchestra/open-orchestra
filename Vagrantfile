# -*- mode: ruby -*-
# vi: set ft=ruby :

$HOSTNAME = "libvirt.dev"

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.define :open_orchestra_vm do |open_orchestra_vm|
    open_orchestra_vm.vm.box = "bento/debian-8.2"
    open_orchestra_vm.vm.network :private_network, :ip => "192.168.33.10"
    open_orchestra_vm.vm.provider :libvirt do |domain|
      domain.memory = 1024
      domain.cpus = 2
    end
    open_orchestra_vm.vm.synced_folder "./", "/var/www/openorchestra", type: "nfs"
    open_orchestra_vm.vm.synced_folder "../open-orchestra-front-demo", "/var/www/front-openorchestra", type: "nfs"
    open_orchestra_vm.vm.synced_folder "../open-orchestra-media-demo", "/var/www/media-openorchestra", type: "nfs"

# Ansible
    open_orchestra_vm.vm.provision "ansible" do |ansible|
      ansible.sudo = true
      ansible.limit = "vagrant"
      ansible.inventory_path = "provisioning/hosts/vagrant"
      ansible.playbook = "../open-orchestra-provision/site.yml"
      ansible.verbose = "v"
    end

  end
end
