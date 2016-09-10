#!/bin/bash

# This script is a last chance for Developers to add more
# configuration to the Vagrant host.

# Update composer to latest version.
/usr/local/bin/composer self-update

# Ensure we have directories.
sudo mkdir -p /vagrant/app/sites/default/files/tmp /vagrant/app/sites/default/private
