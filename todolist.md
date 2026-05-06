# Régime alimentaire

## I-Création des tables SQL
- Table statut_user:
    - id_statut
    - libelle

- Table user:
    - id_user
    - nom
    - email
    - password
    - id_statut

- Table info_user:
    - id_info
    - id_user
    - genre
    - taille
    - poids
    - IMC

- Table code:
    - id_code
    - libelle
    - montant
    - date_expiration

- Table code_user:
    - id_code_user
    - id_code
    - id_user
    - date

- Table objectif:
    - id_objectif
    - libelle (perte de poids, maintien, prise de poids)

- Table norme_imc:
    - id_norme
    - libelle
    - v_min (valeur minimum)
    - v_maximum (valeur maximum)

- Table regime:
    - id_regime
    - nom
    - description
    - id_objectif
    - duree_jours
    - variation_poids
    - prix

- Table sport:
    - id_sport
    - libelle

- Table niveau_intensite:
    - id_niveau
    - libelle

- Table activite_sportive:
    - id_activite
    - id_sport
    - id_objectif
    - description
    - variation_poids
    - id_niveau

## II-Page PHP:
### 1-layout.php:
- base: none

- fonction: none

- design: 
    - Header:
        - logo: texte:"Nutri-Plaisir"