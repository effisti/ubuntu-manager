#!/bin/bash

# Ubuntu Manager Installer

echo "Ubuntu Manager wordt geïnstalleerd..."

# Stap 1: Vereisten controleren en installeren
echo "Controleer en installeer vereisten..."

# Installeer Git indien nog niet geïnstalleerd
if ! [ -x "$(command -v git)" ]; then
    echo "Git is niet geïnstalleerd. Git wordt geïnstalleerd..."
    sudo apt update && sudo apt install -y git
fi

# Installeer Apache2 en PHP (indien nog niet geïnstalleerd)
if ! [ -x "$(command -v apache2)" ]; then
    echo "Apache2 wordt geïnstalleerd..."
    sudo apt install -y apache2
fi

if ! [ -x "$(command -v php)" ]; then
    echo "PHP wordt geïnstalleerd..."
    sudo apt install -y php libapache2-mod-php php-cli php-mbstring php-xml php-curl
fi

# Stap 2: Repository klonen of bijwerken
echo "Het Ubuntu Manager-project wordt gedownload..."
if [ ! -d "/var/www/ubuntu-manager" ]; then
    git clone https://github.com/effisti/ubuntu-manager.git /var/www/ubuntu-manager
else
    echo "Project al gedownload. Updaten..."
    cd /var/www/ubuntu-manager && git pull
fi

# Stap 3: Bestanden en mappen de juiste permissies geven
echo "Bestanden en mappen krijgen de juiste permissies..."
sudo chown -R www-data:www-data /var/www/ubuntu-manager
sudo chmod -R 755 /var/www/ubuntu-manager

# Stap 4: Apache configureren (indien nodig)
echo "Apache configureren..."

# Zorg ervoor dat de Apache configuratie correct is
echo "
<VirtualHost *:80>
    DocumentRoot /var/www/ubuntu-manager
    ServerName ubuntu-manager.local
    <Directory /var/www/ubuntu-manager>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
" | sudo tee /etc/apache2/sites-available/ubuntu-manager.conf

# Zet de nieuwe site in Apache en herstart de server
sudo a2ensite ubuntu-manager.conf
sudo systemctl reload apache2

# Stap 5: Installatie voltooid
echo "De installatie is voltooid!"
echo "Bezoek http://localhost om Ubuntu Manager te gebruiken."