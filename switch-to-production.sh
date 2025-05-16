#!/bin/bash

# Couleurs pour les messages
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${YELLOW}Passage à l'environnement de production...${NC}"

# Vérifier que le fichier .env.production existe
if [ ! -f "ima/.env.production" ]; then
    echo -e "${RED}Fichier .env.production introuvable!${NC}"
    exit 1
fi

# Copier .env.production vers .env
cp ima/.env.production ima/.env

echo -e "${GREEN}Configuration de production activée!${NC}"
echo -e "${YELLOW}Attention: Assurez-vous de tester en local avant de déployer.${NC}"