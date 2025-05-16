#!/bin/bash

# Couleurs pour les messages
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${YELLOW}Passage à l'environnement local...${NC}"

# Vérifier que le fichier .env.local existe
if [ ! -f "ima/.env.local" ]; then
    echo -e "${RED}Fichier .env.local introuvable!${NC}"
    exit 1
fi

# Copier .env.local vers .env
cp ima/.env.local ima/.env

echo -e "${GREEN}Configuration locale activée!${NC}"
echo -e "${YELLOW}Vous pouvez maintenant exécuter votre application en local.${NC}"