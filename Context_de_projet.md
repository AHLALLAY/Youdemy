# Contexte du projet

La plateforme de cours en ligne **Youdemy** vise à révolutionner l'apprentissage en proposant un système interactif et personnalisé pour les étudiants et les enseignants.

# Fonctionnalités Requises

## Partie Front Office

### Visiteur

- <span style="color:red; font-style:italic">Accès au catalogue des cours avec pagination</span>
- <span style="color:red; font-style:italic">Recherche de cours par mots-clés</span>
- <span style="color:green; font-weight:bold">Création d'un compte avec le choix du rôle (Étudiant ou Enseignant)</span>

### Étudiant

- <span style="color:red; font-style:italic">Visualisation du catalogue des cours</span>
- <span style="color:red; font-style:italic">Recherche et consultation des détails des cours (description, contenu, enseignant, etc.)</span>
- <span style="color:green; font-weight:bold">Inscription à un cours après authentification</span>
- <span style="color:green; font-weight:bold">Accès à une section "Mes cours" regroupant les cours rejoints</span>

### Enseignant

- Ajout de nouveaux cours avec des détails tels que :
  - <span style="color:green; font-weight:bold">Titre</span>
  - <span style="color:green; font-weight:bold">Description</span>
  - <span style="color:green; font-weight:bold">Contenu (vidéo ou document)</span>
  - <span style="color:red; font-style:italic">Tags</span>
  - <span style="color:green; font-weight:bold">Catégorie</span>
- Gestion des cours :
  - <span style="color:red; font-style:italic">Modification</span>
  - <span style="color:red; font-style:italic">Suppression</span>
  - <span style="color:green; font-weight:bold">Consultation des inscriptions</span>
- Accès à une section "Statistiques" sur les cours :
  - <span style="color:green; font-weight:bold">Nombre d'étudiants inscrits</span>
  - <span style="color:red; font-style:italic">Nombre de cours, etc.</span>

## Partie Back Office

### Administrateur

- Validation des comptes enseignants
- Gestion des utilisateurs :
  - <span style="color:green; font-weight:bold">Activation</span>
  - <span style="color:green; font-weight:bold">Suspension</span>
  - <span style="color:green; font-weight:bold">Suppression</span>
- Gestion des contenus :
  - <span style="color:green; font-weight:bold">Cours</span> <span style="color:white">_suppression_</span>
  - <span style="color:green; font-weight:bold">Catégories</span> <span style="color:white">_ajoute & edite_</span>
  - <span style="color:green; font-weight:bold">Tags</span> <span style="color:white">_ajoute & edite_</span>
- <span style="color:red; font-style:italic">Insertion en masse de tags pour gagner en efficacité</span>
- Accès à des statistiques globales :
  - <span style="color:green; font-weight:bold">Nombre total de cours</span>
  - <span style="color:red; font-style:italic">Répartition par catégorie</span>
  - <span style="color:green; font-weight:bold">Le cours avec le plus d'étudiants</span>
  - <span style="color:red; font-style:italic">Les Top 3 enseignants</span>

# Statistiques

- **Fonctionnalités en vert (<span style="color:green; font-weight:bold">vert</span>) :**
    * Visiteur
        - Création de compte avec choix de rôle
    * Étudiant
        - Inscription à un cours  
        - Accès à "Mes cours"
    * Enseignant
        - Ajout de titre, description, contenu et catégorie 
        - Consultation des inscriptions
        - Nombre d'étudiants inscrits
    * Administrateur
        - Activation, suspension et suppression des utilisateurs 
        - Gestion des cours, catégories et tags
        - Nombre total de cours et cours avec le plus d'étudiants

- **Fonctionnalités en rouge (<span style="color:red; font-style:italic">rouge</span>) :**  
    * Visiteur
        - Accès au catalogue avec pagination  
        - Recherche de cours par mots-clés
    * Étudiant
        - Visualisation du catalogue  
        - Consultation des détails des cours
    * Enseignant
        - Ajout de tags
        - Modification et suppression de cours
        - Nombre de cours
    * Administrateur
        - Insertion en masse de tags  
        - Répartition des cours par catégorie
        - Top 3 enseignants