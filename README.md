# Inicial tunnel Cloudflare
cloudflared tunnel run elicast-tunnel
url: eccdiocesedeiguatu.elicast.app

# Criando novo tunnel

cloudflared tunnel route dns elicast-tunnel eccdiocesedeiguatu

Registra dados no tunel: (está dentro de /home/helio/.cloudflared/)

- hostname: eccdiocesedeiguatu.elicast.app
service: http://localhost