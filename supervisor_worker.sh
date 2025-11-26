#!/bin/bash

# Nome do programa no Supervisor
PROGRAM_NAME="cliente-revivendo-ecc"
SUPERVISOR_CONF="/etc/supervisor/conf.d/${PROGRAM_NAME}.conf"
PHP_PATH="/usr/bin/php"
APP_PATH="/home/eccformacao/htdocs/formacao.eccdiocesedeiguatu.com/ecc-formacao"

# Verifica se está rodando como root
if [ "$EUID" -ne 0 ]; then
  echo "❌ Execute como root."
  exit 1
fi

echo "➡️ Verificando instalação do Supervisor..."

# Instala supervisor se não existir
if ! command -v supervisorctl >/dev/null 2>&1; then
  echo "📦 Supervisor não encontrado. Instalando..."
  apt update -y && apt install -y supervisor
  systemctl enable supervisor
  systemctl start supervisor
else
  echo "✔️ Supervisor já está instalado."
fi

echo "➡️ Verificando se o worker já existe..."

# Cria o worker somente se não existir
if [ -f "$SUPERVISOR_CONF" ]; then
  echo "✔️ Worker já existe em: $SUPERVISOR_CONF"
else
  echo "📝 Criando worker..."

  cat <<EOF > "$SUPERVISOR_CONF"
[program:${PROGRAM_NAME}]
process_name=%(program_name)s_%(process_num)02d
command=${PHP_PATH} ${APP_PATH}/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
numprocs=2
startsecs=0
stopwaitsecs=3600
stdout_logfile=/var/log/%(program_name)s.log
stderr_logfile=/var/log/%(program_name)s_error.log
EOF

  echo "✔️ Worker criado."
fi

echo "🔄 Recarregando Supervisor..."
supervisorctl reread
supervisorctl update

echo "▶️ Iniciando o worker..."
supervisorctl start "${PROGRAM_NAME}:*"

echo "🎉 Tudo pronto!"
