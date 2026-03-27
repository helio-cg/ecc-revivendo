# Inicial tunnel Cloudflare
cloudflared tunnel run elicast-tunnel
url: eccdiocesedeiguatu.elicast.app

Liberar ip na api: 2a01:4f8:1c1a:3012::1 e 91.98.228.188

docker run --rm \
-u "$(id -u):$(id -g)" \
-v $(pwd):/var/www/html \
-w /var/www/html \
laravelsail/php84-composer:latest \
composer install --ignore-platform-reqs