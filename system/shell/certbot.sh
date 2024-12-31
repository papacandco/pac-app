sudo snap install core; sudo snap refresh core
sudo snap install --classic certbot
sudo ln -s /snap/bin/certbot /usr/bin/certbot

# STAGING
certbot certonly -d staging.papac.dev -w /papac-and-co/app-production/public
certbot certonly -d console-staging.papac.dev -w /papac-and-co/console-production/public

# PRODUCTION
certbot certonly -d www.papac.dev -w /papac-and-co/app-production/public
certbot certonly -d console.papac.dev -w /papac-and-co/console-production/public
