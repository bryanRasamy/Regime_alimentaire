CREATE DATABASE regime_alimentaire;

use regime_alimentaire;

CREATE TABLE statut_user(
    id_statut INT PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(50)
);

CREATE TABLE user(
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    id_statut INT,
    FOREIGN KEY (id_statut) REFERENCES statut_user(id_statut)
);

CREATE TABLE info_user(
    id_info INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT,
    genre VARCHAR(10),
    taille NUMERIC(3,2),
    poids NUMERIC(3,2),
    IMC NUMERIC(3,2),
    FOREIGN KEY (id_user) REFERENCES user(id_user)
);

CREATE TABLE code(
    id_code INT PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(50) UNIQUE,
    montant DECIMAL(10,2),
    date_expiration DATE
);

CREATE TABLE code_user(
    id_code_user INT PRIMARY KEY AUTO_INCREMENT,
    id_code INT,
    id_user INT,
    date DATE,
    FOREIGN KEY (id_user) REFERENCES user(id_user),
    FOREIGN KEY (id_code) REFERENCES code(id_code)
);

CREATE TABLE objectif(
    id_objectif INT PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(50)
);

CREATE TABLE norme_imc(
    id_norme INT PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(50),
    v_min NUMERIC(3,2),
    v_max NUMERIC(3,2)
);

CREATE TABLE regime(
    id_regime INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50),
    description TEXT,
    id_objectif INT,
    duree_jours INT,
    variation_poids NUMERIC(3,2),
    prix NUMERIC(10,2),
    FOREIGN KEY (id_objectif) REFERENCES objectif(id_objectif)
);

CREATE TABLE sport(
    id_sport INT PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(50)
);

CREATE TABLE niveau_intensite(
    id_niveau INT PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(50)
);

CREATE TABLE activite_sportive(
    id_activite INT PRIMARY KEY AUTO_INCREMENT,
    id_sport INT,
    id_objectif INT,
    description TEXT,
    variation_poids NUMERIC(3,2),
    id_niveau INT,
    FOREIGN KEY (id_sport) REFERENCES sport(id_sport),
    FOREIGN KEY (id_objectif) REFERENCES objectif(id_objectif),
    FOREIGN KEY (id_niveau) REFERENCES niveau_intensite(id_niveau)
);
