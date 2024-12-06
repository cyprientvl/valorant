-- Users

-- A faire à la main
INSERT INTO
    user (id, username, roles, password)
VALUES (
        1,
        'JettMain',
        '["ROLE_USER"]',
        '$2y$13$A8.jzjoZIFZ6oKs8Az8Xt.Ns0xJ0Gg0jo3kH0K8r4BBQbcVPTnR8O'
    ),
    (
        2,
        'PhoenixPro',
        '["ROLE_USER"]',
        '$2y$13$A8.jzjoZIFZ6oKs8Az8Xt.Ns0xJ0Gg0jo3kH0K8r4BBQbcVPTnR8O'
    ),
    (
        3,
        'ValorantKing',
        '["ROLE_USER"]',
        '$2y$13$A8.jzjoZIFZ6oKs8Az8Xt.Ns0xJ0Gg0jo3kH0K8r4BBQbcVPTnR8O'
    ),
    (
        4,
        'SageHealer',
        '["ROLE_USER"]',
        '$2y$13$A8.jzjoZIFZ6oKs8Az8Xt.Ns0xJ0Gg0jo3kH0K8r4BBQbcVPTnR8O'
    ),
    (
        5,
        'RazeMaster',
        '["ROLE_USER"]',
        '$2y$13$A8.jzjoZIFZ6oKs8Az8Xt.Ns0xJ0Gg0jo3kH0K8r4BBQbcVPTnR8O'
    );

-- Items (avec itemType = 'skin' pour les skins d'armes)
INSERT INTO
    item (
        id,
        display_name,
        display_icon,
        item_type
    )
VALUES (
        '1fb8b5d3-44b5-4a3c-a19d-52b456e6d9c8',
        'Prime Vandal',
        'https://media.valorant-api.com/weaponskinchromas/1fb8b5d3/displayicon.png',
        'skin'
    ),
    (
        '2f83f634-47b3-44b5-9e27-4b3e6a56863a',
        'Reaver Operator',
        'https://media.valorant-api.com/weaponskinchromas/2f83f634/displayicon.png',
        'skin'
    ),
    (
        '892ecb9b-4727-4fe6-8e43-de842a6c336d',
        'Ion Phantom',
        'https://media.valorant-api.com/weaponskinchromas/892ecb9b/displayicon.png',
        'skin'
    ),
    (
        '7da96a2a-43ce-699c-0c34-7d8565cd3f9c',
        'Oni Phantom',
        'https://media.valorant-api.com/weaponskinchromas/7da96a2a/displayicon.png',
        'skin'
    ),
    (
        'ae8f3378-4091-4c2b-9518-396e3c9092f1',
        'Glitchpop Vandal',
        'https://media.valorant-api.com/weaponskinchromas/ae8f3378/displayicon.png',
        'skin'
    ),
    (
        '0a6d22c8-9f55-4c5a-a7e0-6c56a2b51ca5',
        'Protocol Spectre',
        'https://media.valorant-api.com/weaponskinchromas/0a6d22c8/displayicon.png',
        'skin'
    ),
    (
        '1c2e08a3-4c4b-85c9-6c4c-77b9da718dc5',
        'RGX Vandal',
        'https://media.valorant-api.com/weaponskinchromas/1c2e08a3/displayicon.png',
        'skin'
    );

-- Chromas
INSERT INTO
    chroma (
        id,
        display_name,
        display_icon,
        item_id
    )
VALUES (
        '1fb8b5d3-blue',
        'Prime Vandal Blue',
        'https://media.valorant-api.com/weaponskinchromas/1fb8b5d3-blue/displayicon.png',
        '1fb8b5d3-44b5-4a3c-a19d-52b456e6d9c8'
    ),
    (
        '1fb8b5d3-orange',
        'Prime Vandal Orange',
        'https://media.valorant-api.com/weaponskinchromas/1fb8b5d3-orange/displayicon.png',
        '1fb8b5d3-44b5-4a3c-a19d-52b456e6d9c8'
    ),
    (
        '2f83f634-red',
        'Reaver Operator Red',
        'https://media.valorant-api.com/weaponskinchromas/2f83f634-red/displayicon.png',
        '2f83f634-47b3-44b5-9e27-4b3e6a56863a'
    ),
    (
        '892ecb9b-green',
        'Ion Phantom Green',
        'https://media.valorant-api.com/weaponskinchromas/892ecb9b-green/displayicon.png',
        '892ecb9b-4727-4fe6-8e43-de842a6c336d'
    ),
    (
        '7da96a2a-black',
        'Oni Phantom Black',
        'https://media.valorant-api.com/weaponskinchromas/7da96a2a-black/displayicon.png',
        '7da96a2a-43ce-699c-0c34-7d8565cd3f9c'
    ),
    (
        'ae8f3378-blue',
        'Glitchpop Vandal Blue',
        'https://media.valorant-api.com/weaponskinchromas/ae8f3378-blue/displayicon.png',
        'ae8f3378-4091-4c2b-9518-396e3c9092f1'
    ),
    (
        '0a6d22c8-white',
        'Protocol Spectre White',
        'https://media.valorant-api.com/weaponskinchromas/0a6d22c8-white/displayicon.png',
        '0a6d22c8-9f55-4c5a-a7e0-6c56a2b51ca5'
    ),
    (
        '1c2e08a3-red',
        'RGX Vandal Red',
        'https://media.valorant-api.com/weaponskinchromas/1c2e08a3-red/displayicon.png',
        '1c2e08a3-4c4b-85c9-6c4c-77b9da718dc5'
    );

-- Lockers (un seul locker par utilisateur)
INSERT INTO
    locker (id, name, is_public, user_id)
VALUES (
        1,
        'JettMain Loadout',
        true,
        1
    ),
    (2, 'Pro Setup', true, 2),
    (
        3,
        'Dream Collection',
        true,
        3
    ),
    (4, 'Ranked Loadout', true, 4),
    (5, 'Expensive Stuff', true, 5);

-- Table de liaison pour les likes des casiers
INSERT INTO
    locker_user_likes (locker_id, user_id)
VALUES (1, 2),
    (1, 3),
    (1, 4), -- JettMain Loadout a 3 likes
    (2, 1),
    (2, 3),
    (2, 4),
    (2, 5), -- Pro Setup a 4 likes
    (3, 1),
    (3, 2), -- Dream Collection a 2 likes
    (4, 1),
    (4, 2),
    (4, 3), -- Ranked Loadout a 3 likes
    (5, 1),
    (5, 2),
    (5, 3),
    (5, 4);
-- Expensive Stuff a 4 likes
-- LockerItems (avec isMainItemType)
INSERT INTO
    locker_item (
        id,
        locker_id,
        item_id,
        chroma_id,
        is_main_item_type
    )
VALUES
    -- JettMain's loadout
    (
        1,
        1,
        '1fb8b5d3-44b5-4a3c-a19d-52b456e6d9c8',
        '1fb8b5d3-blue',
        true
    ),
    (
        2,
        1,
        '2f83f634-47b3-44b5-9e27-4b3e6a56863a',
        '2f83f634-red',
        true
    ),
    (
        3,
        1,
        '892ecb9b-4727-4fe6-8e43-de842a6c336d',
        '892ecb9b-green',
        true
    ),
    -- PhoenixPro's loadout
    (
        4,
        2,
        '1fb8b5d3-44b5-4a3c-a19d-52b456e6d9c8',
        '1fb8b5d3-orange',
        true
    ),
    (
        5,
        2,
        '892ecb9b-4727-4fe6-8e43-de842a6c336d',
        '892ecb9b-green',
        true
    ),
    (
        6,
        2,
        '1c2e08a3-4c4b-85c9-6c4c-77b9da718dc5',
        '1c2e08a3-red',
        true
    ),
    -- ValorantKing's loadout
    (
        7,
        3,
        'ae8f3378-4091-4c2b-9518-396e3c9092f1',
        'ae8f3378-blue',
        true
    ),
    (
        8,
        3,
        '7da96a2a-43ce-699c-0c34-7d8565cd3f9c',
        '7da96a2a-black',
        true
    ),
    -- SageHealer's loadout
    (
        9,
        4,
        '1fb8b5d3-44b5-4a3c-a19d-52b456e6d9c8',
        '1fb8b5d3-blue',
        true
    ),
    (
        10,
        4,
        '2f83f634-47b3-44b5-9e27-4b3e6a56863a',
        '2f83f634-red',
        true
    ),
    -- RazeMaster's loadout
    (
        11,
        5,
        '1c2e08a3-4c4b-85c9-6c4c-77b9da718dc5',
        '1c2e08a3-red',
        true
    ),
    (
        12,
        5,
        '0a6d22c8-9f55-4c5a-a7e0-6c56a2b51ca5',
        '0a6d22c8-white',
        true
    ),
    (
        13,
        5,
        'ae8f3378-4091-4c2b-9518-396e3c9092f1',
        'ae8f3378-blue',
        true
    );