Vagrant.configure("2") do |config|
	config.vm.box = "Lant"
	config.vm.box_url = "https://cloud-images.ubuntu.com/vagrant/trusty/current/trusty-server-cloudimg-amd64-vagrant-disk1.box"
	config.vm.synced_folder "./www","/var/www/html", create:true
	config.vm.network :private_network, ip: "192.168.55.55"
	config.vm.provision :shell, :path => "setup.sh"
end
