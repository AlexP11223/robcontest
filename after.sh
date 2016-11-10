#!/bin/sh

# If you would like to do some extra provisioning of Homestead you may
# add any commands you wish to this file and they will
# be run after the Homestead machine is provisioned.

# install yarn
sudo apt-key adv --fetch-keys http://dl.yarnpkg.com/debian/pubkey.gpg
echo "deb http://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
sudo apt-get update && sudo apt-get install -y --allow-unauthenticated yarn
