-- donne pour statut
INSERT INTO statut_user (libelle) VALUES
  ('simple'),
  ('Admin');

-- donne pour user
INSERT INTO user (nom, email, password, id_statut, porte_monnaie, option_gold) VALUES
  ('Alice Dupont', 'alicedupont@example.com', 'alice', 1, 1000.00, 15.00),
  ('Bruno Martin', 'brunomartin@example.com', 'bruno', 1, 1500.00, 0.00),
  ('Caroline Bernard', 'carolinebernard@example.com', 'caroline', 1, 2000.00, 0.00),
  ('David Moreau', 'davidmoreau@example.com', 'david', 1, 2500.00, 0.00),
  ('Emma Leroy', 'emmaleroy@example.com', 'emma', 2, 3000.00, 15.00);



-- donne pour code
INSERT INTO code (libelle, montant, date_expiration) VALUES
    ('CD34', 10000, '2026-05-15'),
    ('CD36', 15000, '2026-06-30'),
    ('CD48', 20000, '2026-07-31'),
    ('CD80', 25000, '2026-08-31'),
    ('CD22', 30000, '2026-09-30'),
    ('CD55', 35000, '2026-10-31'),
    ('CD67', 40000, '2026-11-30'),
    ('CD89', 45000, '2026-12-31'),
    ('CD23', 50000, '2027-01-31'),
    ('CD99', 55000, '2027-02-28'),
    ('CD56', 60000, '2027-03-31'),
    ('CD78', 65000, '2027-04-30'),
    ('CD90', 70000, '2027-05-31'),
    ('CD12', 75000, '2027-06-30'),
    ('CD45', 80000, '2027-07-31');


--donnee objectif
INSERT INTO objectif (libelle) VALUES
    ('Perte de poids'),
    ('Prise de masse'),
    ('Maintien du poids');

-- donee pour regime
INSERT INTO regime (nom, description, viande, poisson, volaille, id_objectif, duree_jours, variation_poids, prix) VALUES
    ('Régime Keto', 'Un régime riche en graisses et pauvre en glucides pour favoriser la perte de poids.', 70.00, 20.00, 10.00, 1, 30, -5, 199.99),
    ('Régime Hyperprotéiné', 'Un régime riche en protéines pour favoriser la prise de masse musculaire.', 50.00, 20.00, 30.00, 2, 60, +3, 149.99),
    ('Régime Méditerranéen', 'Un régime équilibré basé sur les aliments traditionnels de la région méditerranéenne pour maintenir un poids santé.', 20.00, 60.00, 20.00, 3, 90, 0, 99.99),
    ('Régime Végétarien', 'Un régime qui exclut la viande et les produits d origine animale pour favoriser la santé et le bien-être.', 5.00, 40.00, 55.00, 3, 60, -2, 129.99),
    ('Régime Paléo', 'Un régime basé sur les aliments que nos ancêtres chasseurs-cueilleurs consommaient pour favoriser la perte de poids et la santé globale.', 12.00, 38.00, 50.00, 1, 45, -4, 179.99);

-- donee pour sport
INSERT INTO sport (libelle) VALUES
    ('Course à pied'),
    ('Musculation'),
    ('Natation'),
    ('Cyclisme'),
    ('Yoga');

INSERT INTO niveau_intensite (libelle) VALUES
    ('Faible'),
    ('Élevée');

-- DONNEE POUR ACTIVITE_SPORTIVE
INSERT INTO activite_sportive (id_activite, id_sport, id_objectif, description, variation_poids, id_niveau) VALUES
    (1, 1, 1, 'Course à pied de 30 minutes à une intensité modérée pour favoriser la perte de poids.', -0.5, 1),
    (2, 2, 2, 'Séance de musculation de 45 minutes axée sur les exercices de force pour favoriser la prise de masse musculaire.', +0.3, 2),
    (3, 3, 3, 'Séance de natation de 60 minutes à une intensité légère pour maintenir un poids santé.', 0, 1),
    (4, 4, 1, 'Sortie en vélo de 60 minutes à une intensité modérée pour favoriser la perte de poids.', -0.4, 2),
    (5, 5, 3, 'Séance de yoga de 30 minutes axée sur la relaxation et la méditation pour maintenir un poids santé.', -0.2, 1);





