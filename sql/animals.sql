-- ============================================================
-- ANIMALS
-- ============================================================

DROP TABLE IF EXISTS animals;

CREATE TABLE animals (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    common_name VARCHAR(100) NOT NULL,
    scientific_name VARCHAR(150) NOT NULL,

    kingdom VARCHAR(50),
    phylum VARCHAR(100),
    tax_class VARCHAR(100),
    tax_order VARCHAR(100),
    family VARCHAR(100),
    genus VARCHAR(100),
    species VARCHAR(150),

    weight_min DECIMAL(8,2),
    weight_max DECIMAL(8,2),

    length_min DECIMAL(8,2),
    length_max DECIMAL(8,2),

    lifespan_min DECIMAL(6,2),
    lifespan_max DECIMAL(6,2),

    max_speed DECIMAL(8,2),

    conservation_status VARCHAR(50),
    population VARCHAR(100),
    population_trend VARCHAR(100),

    biome VARCHAR(255),
    climate VARCHAR(255),
    habitat VARCHAR(255),
    geographic_range TEXT,

    diet VARCHAR(100),
    activity VARCHAR(255),
    social_structure VARCHAR(255),

    breeding VARCHAR(255),
    gestation VARCHAR(100),
    litter_size VARCHAR(100),
    young VARCHAR(255),

    description TEXT,
    behaviour_description TEXT,
    conservation_description TEXT,

    main_image VARCHAR(255)
);



INSERT INTO animals (
    common_name,
    scientific_name,
    kingdom,
    phylum,
    tax_class,
    tax_order,
    family,
    genus,
    species,
    weight_min,
    weight_max,
    length_min,
    length_max,
    lifespan_min,
    lifespan_max,
    max_speed,
    conservation_status,
    population,
    population_trend,
    biome,
    climate,
    habitat,
    geographic_range,
    diet,
    activity,
    social_structure,
    breeding,
    gestation,
    litter_size,
    young,
    description,
    behaviour_description,
    conservation_description,
    main_image
)
VALUES (
    'African Lion',
    'Panthera leo',
    'Animalia',
    'Chordata',
    'Mammalia',
    'Carnivora',
    'Felidae',
    'Panthera',
    'Panthera leo',

    150,
    250,

    2.4,
    3.3,

    10,
    14,

    80,

    'Vulnerable',
    '~20,000–25,000',
    '↓ Population declining',

    'Savanna & Grassland',
    'Tropical & Subtropical',
    'Savanna, Grassland & Woodland',
    'Primarily found in sub-Saharan Africa, with populations occurring in countries including Kenya, Tanzania, Botswana and South Africa.',

    'Carnivore',
    'Mostly nocturnal',
    'Prides',

    'Year-round',
    '~110 days',
    '1–4 cubs',
    'Raised within the pride',

    'The African lion is one of the world''s largest members of the cat family. Unlike most other big cats, lions are highly social animals that live together in groups known as prides.

        Lions are powerful predators that play an important role in their ecosystems. They primarily hunt large herbivores and often cooperate with other members of their pride when hunting.

        Although lions once occupied much of Africa, their range has declined considerably due to habitat loss, declining prey populations and conflict with humans.',

    'Lions are primarily carnivorous predators. They hunt a variety of large mammals, including zebras, wildebeest, antelope and buffalo. Hunting is often cooperative, particularly among lionesses within a pride.
    
        Lions tend to be more active during cooler periods of the day. Their social behaviour is unusual among cats, with related females often forming the stable core of a pride.',

    'African lion populations have declined significantly across much of their historical range. Conservation efforts focus on protecting remaining habitat, maintaining healthy prey populations and reducing conflict between lions and local communities.',

    'AfricanLion.jpg'
);

