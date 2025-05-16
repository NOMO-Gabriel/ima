#!/bin/bash

# Couleurs pour les messages
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}Démarrage du déploiement en production...${NC}"

# S'assurer que tous les changements locaux sont commités
if [[ -n $(git status -s) ]]; then
  echo -e "${YELLOW}Des changements non commités ont été détectés. Veuillez commiter ou stasher vos changements avant de déployer.${NC}"
  exit 1
fi

# Récupérer les derniers changements du dépôt distant
echo -e "${GREEN}Récupération des dernières modifications...${NC}"
git fetch origin

# Mise à jour de la branche principale
echo -e "${GREEN}Mise à jour de la branche principale...${NC}"
git checkout main
git pull origin main

# Installation/mise à jour des dépendances
echo -e "${GREEN}Mise à jour des dépendances...${NC}"
composer install --no-dev --optimize-autoloader
npm ci

# Compilation des assets
echo -e "${GREEN}Compilation des assets pour la production...${NC}"
npm run build

# Basculer vers la branche de production
echo -e "${GREEN}Basculement vers la branche de production...${NC}"
git checkout production
git pull origin production

# Fusion des changements de main vers production
echo -e "${GREEN}Fusion des changements de main vers production...${NC}"
git merge main -m "Merge main pour déploiement en production"

# Ajouter les assets compilés
echo -e "${GREEN}Ajout des assets compilés au commit...${NC}"
git add -f public/build
git commit -m "Ajout des assets compilés pour le déploiement en production"

# Pousser les changements
echo -e "${GREEN}Envoi des changements vers GitHub...${NC}"
git push origin production

echo -e "${GREEN}Préparation du déploiement sur Hostinger...${NC}"
# Créer un dossier temporaire pour les fichiers à déployer
mkdir -p deploy/ima
mkdir -p deploy/public_html/build

# Copier les fichiers nécessaires
rsync -av --exclude='node_modules' --exclude='.git' --exclude='vendor/*/tests' --exclude='vendor/*/docs' ./ deploy/ima/
cp -r public/build/* deploy/public_html/build/

echo -e "${GREEN}===== Déploiement terminé avec succès! =====${NC}"
echo -e "${YELLOW}Vous pouvez maintenant transférer le contenu du dossier 'deploy' vers votre hébergement via FTP${NC}"