Vagrant.configure("2") do |config|
  config.vm.define 'lamp', primary: true do |lamp|
    lamp.vm.box      = 'pnx/lamp'
    lamp.vm.hostname = 'thelargeformatblog.dev'

    lamp.vm.provision :shell, path: "provision.sh"
  end

end
