# 1. Assurez-vous d'être sur la branche principale pour le développement
git checkout main  # ou master selon votre configuration

# 2. Développez vos fonctionnalités, puis committez vos changements
git add .
git commit -m "Description des changements"

# 3. Poussez les changements vers la branche principale
git push origin main

# 4. Quand vous êtes prêt à déployer en production
git checkout production
git merge main    # Fusionner les changements de main vers production

# 5. Compiler les assets pour la production
npm run build

# 6. Ajouter les fichiers compilés au commit
git add public/build
git commit -m "Compilation des assets pour la production"

# 7. Pousser vers la branche de production
git push origin production