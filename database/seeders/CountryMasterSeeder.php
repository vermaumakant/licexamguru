<?php

namespace Database\Seeders;

use App\Models\CountryMaster;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $check = CountryMaster::count();
        if($check) {
            return;
        }
        DB::statement("
        INSERT INTO `country_masters` (`id`, `name`, `isd_code`, `two_digit_code`, `three_digit_code`, `created_at`, `updated_at`) VALUES
        (1,	'Afghanistan',	'93',	'AF',	'AFG',	NULL,	NULL),
        (2,	'Albania',	'355',	'AL',	'ALB',	NULL,	NULL),
        (3,	'Algeria',	'213',	'DZ',	'DZA',	NULL,	NULL),
        (4,	'American Samoa',	'1-684',	'AS',	'ASM',	NULL,	NULL),
        (5,	'Andorra',	'376',	'AD',	'AND',	NULL,	NULL),
        (6,	'Angola',	'244',	'AO',	'AGO',	NULL,	NULL),
        (7,	'Anguilla',	'1-264',	'AI',	'AIA',	NULL,	NULL),
        (8,	'Antarctica',	'672',	'AQ',	'ATA',	NULL,	NULL),
        (9,	'Antigua and Barbuda',	'1-268',	'AG',	'ATG',	NULL,	NULL),
        (10,	'Argentina',	'54',	'AR',	'ARG',	NULL,	NULL),
        (11,	'Armenia',	'374',	'AM',	'ARM',	NULL,	NULL),
        (12,	'Aruba',	'297',	'AW',	'ABW',	NULL,	NULL),
        (13,	'Australia',	'61',	'AU',	'AUS',	NULL,	NULL),
        (14,	'Austria',	'43',	'AT',	'AUT',	NULL,	NULL),
        (15,	'Azerbaijan',	'994',	'AZ',	'AZE',	NULL,	NULL),
        (16,	'Bahamas',	'1-242',	'BS',	'BHS',	NULL,	NULL),
        (17,	'Bahrain',	'973',	'BH',	'BHR',	NULL,	NULL),
        (18,	'Bangladesh',	'880',	'BD',	'BGD',	NULL,	NULL),
        (19,	'Barbados',	'1-246',	'BB',	'BRB',	NULL,	NULL),
        (20,	'Belarus',	'375',	'BY',	'BLR',	NULL,	NULL),
        (21,	'Belgium',	'32',	'BE',	'BEL',	NULL,	NULL),
        (22,	'Belize',	'501',	'BZ',	'BLZ',	NULL,	NULL),
        (23,	'Benin',	'229',	'BJ',	'BEN',	NULL,	NULL),
        (24,	'Bermuda',	'1-441',	'BM',	'BMU',	NULL,	NULL),
        (25,	'Bhutan',	'975',	'BT',	'BTN',	NULL,	NULL),
        (26,	'Bolivia',	'591',	'BO',	'BOL',	NULL,	NULL),
        (27,	'Bosnia and Herzegovina',	'387',	'BA',	'BIH',	NULL,	NULL),
        (28,	'Botswana',	'267',	'BW',	'BWA',	NULL,	NULL),
        (29,	'Brazil',	'55',	'BR',	'BRA',	NULL,	NULL),
        (30,	'British Indian Ocean Territory',	'246',	'IO',	'IOT',	NULL,	NULL),
        (31,	'British Virgin Islands',	'1-284',	'VG',	'VGB',	NULL,	NULL),
        (32,	'Brunei',	'673',	'BN',	'BRN',	NULL,	NULL),
        (33,	'Bulgaria',	'359',	'BG',	'BGR',	NULL,	NULL),
        (34,	'Burkina Faso',	'226',	'BF',	'BFA',	NULL,	NULL),
        (35,	'Burundi',	'257',	'BI',	'BDI',	NULL,	NULL),
        (36,	'Cambodia',	'855',	'KH',	'KHM',	NULL,	NULL),
        (37,	'Cameroon',	'237',	'CM',	'CMR',	NULL,	NULL),
        (38,	'Canada',	'1',	'CA',	'CAN',	NULL,	NULL),
        (39,	'Cape Verde',	'238',	'CV',	'CPV',	NULL,	NULL),
        (40,	'Cayman Islands',	'1-345',	'KY',	'CYM',	NULL,	NULL),
        (41,	'Central African Republic',	'236',	'CF',	'CAF',	NULL,	NULL),
        (42,	'Chad',	'235',	'TD',	'TCD',	NULL,	NULL),
        (43,	'Chile',	'56',	'CL',	'CHL',	NULL,	NULL),
        (44,	'China',	'86',	'CN',	'CHN',	NULL,	NULL),
        (45,	'Christmas Island',	'61',	'CX',	'CXR',	NULL,	NULL),
        (46,	'Cocos Islands',	'61',	'CC',	'CCK',	NULL,	NULL),
        (47,	'Colombia',	'57',	'CO',	'COL',	NULL,	NULL),
        (48,	'Comoros',	'269',	'KM',	'COM',	NULL,	NULL),
        (49,	'Cook Islands',	'682',	'CK',	'COK',	NULL,	NULL),
        (50,	'Costa Rica',	'506',	'CR',	'CRI',	NULL,	NULL),
        (51,	'Croatia',	'385',	'HR',	'HRV',	NULL,	NULL),
        (52,	'Cuba',	'53',	'CU',	'CUB',	NULL,	NULL),
        (53,	'Curacao',	'599',	'CW',	'CUW',	NULL,	NULL),
        (54,	'Cyprus',	'357',	'CY',	'CYP',	NULL,	NULL),
        (55,	'Czech Republic',	'420',	'CZ',	'CZE',	NULL,	NULL),
        (56,	'Democratic Republic of the Congo',	'243',	'CD',	'COD',	NULL,	NULL),
        (57,	'Denmark',	'45',	'DK',	'DNK',	NULL,	NULL),
        (58,	'Djibouti',	'253',	'DJ',	'DJI',	NULL,	NULL),
        (59,	'Dominica',	'1-767',	'DM',	'DMA',	NULL,	NULL),
        (60,	'Dominican Republic',	'1-809',	'DO',	'DOM',	NULL,	NULL),
        (61,	'East Timor',	'670',	'TL',	'TLS',	NULL,	NULL),
        (62,	'Ecuador',	'593',	'EC',	'ECU',	NULL,	NULL),
        (63,	'Egypt',	'20',	'EG',	'EGY',	NULL,	NULL),
        (64,	'El Salvador',	'503',	'SV',	'SLV',	NULL,	NULL),
        (65,	'Equatorial Guinea',	'240',	'GQ',	'GNQ',	NULL,	NULL),
        (66,	'Eritrea',	'291',	'ER',	'ERI',	NULL,	NULL),
        (67,	'Estonia',	'372',	'EE',	'EST',	NULL,	NULL),
        (68,	'Ethiopia',	'251',	'ET',	'ETH',	NULL,	NULL),
        (69,	'Falkland Islands',	'500',	'FK',	'FLK',	NULL,	NULL),
        (70,	'Faroe Islands',	'298',	'FO',	'FRO',	NULL,	NULL),
        (71,	'Fiji',	'679',	'FJ',	'FJI',	NULL,	NULL),
        (72,	'Finland',	'358',	'FI',	'FIN',	NULL,	NULL),
        (73,	'France',	'33',	'FR',	'FRA',	NULL,	NULL),
        (74,	'French Polynesia',	'689',	'PF',	'PYF',	NULL,	NULL),
        (75,	'Gabon',	'241',	'GA',	'GAB',	NULL,	NULL),
        (76,	'Gambia',	'220',	'GM',	'GMB',	NULL,	NULL),
        (77,	'Georgia',	'995',	'GE',	'GEO',	NULL,	NULL),
        (78,	'Germany',	'49',	'DE',	'DEU',	NULL,	NULL),
        (79,	'Ghana',	'233',	'GH',	'GHA',	NULL,	NULL),
        (80,	'Gibraltar',	'350',	'GI',	'GIB',	NULL,	NULL),
        (81,	'Greece',	'30',	'GR',	'GRC',	NULL,	NULL),
        (82,	'Greenland',	'299',	'GL',	'GRL',	NULL,	NULL),
        (83,	'Grenada',	'1-473',	'GD',	'GRD',	NULL,	NULL),
        (84,	'Guam',	'1-671',	'GU',	'GUM',	NULL,	NULL),
        (85,	'Guatemala',	'502',	'GT',	'GTM',	NULL,	NULL),
        (86,	'Guernsey',	'44-1481',	'GG',	'GGY',	NULL,	NULL),
        (87,	'Guinea',	'224',	'GN',	'GIN',	NULL,	NULL),
        (88,	'Guinea-Bissau',	'245',	'GW',	'GNB',	NULL,	NULL),
        (89,	'Guyana',	'592',	'GY',	'GUY',	NULL,	NULL),
        (90,	'Haiti',	'509',	'HT',	'HTI',	NULL,	NULL),
        (91,	'Honduras',	'504',	'HN',	'HND',	NULL,	NULL),
        (92,	'Hong Kong',	'852',	'HK',	'HKG',	NULL,	NULL),
        (93,	'Hungary',	'36',	'HU',	'HUN',	NULL,	NULL),
        (94,	'Iceland',	'354',	'IS',	'ISL',	NULL,	NULL),
        (95,	'India',	'91',	'IN',	'IND',	NULL,	NULL),
        (96,	'Indonesia',	'62',	'ID',	'IDN',	NULL,	NULL),
        (97,	'Iran',	'98',	'IR',	'IRN',	NULL,	NULL),
        (98,	'Iraq',	'964',	'IQ',	'IRQ',	NULL,	NULL),
        (99,	'Ireland',	'353',	'IE',	'IRL',	NULL,	NULL),
        (100,	'Isle of Man',	'44-1624',	'IM',	'IMN',	NULL,	NULL),
        (101,	'Israel',	'972',	'IL',	'ISR',	NULL,	NULL),
        (102,	'Italy',	'39',	'IT',	'ITA',	NULL,	NULL),
        (103,	'Ivory Coast',	'225',	'CI',	'CIV',	NULL,	NULL),
        (104,	'Jamaica',	'1-876',	'JM',	'JAM',	NULL,	NULL),
        (105,	'Japan',	'81',	'JP',	'JPN',	NULL,	NULL),
        (106,	'Jersey',	'44-1534',	'JE',	'JEY',	NULL,	NULL),
        (107,	'Jordan',	'962',	'JO',	'JOR',	NULL,	NULL),
        (108,	'Kazakhstan',	'7',	'KZ',	'KAZ',	NULL,	NULL),
        (109,	'Kenya',	'254',	'KE',	'KEN',	NULL,	NULL),
        (110,	'Kiribati',	'686',	'KI',	'KIR',	NULL,	NULL),
        (111,	'Kosovo',	'383',	'XK',	'XKX',	NULL,	NULL),
        (112,	'Kuwait',	'965',	'KW',	'KWT',	NULL,	NULL),
        (113,	'Kyrgyzstan',	'996',	'KG',	'KGZ',	NULL,	NULL),
        (114,	'Laos',	'856',	'LA',	'LAO',	NULL,	NULL),
        (115,	'Latvia',	'371',	'LV',	'LVA',	NULL,	NULL),
        (116,	'Lebanon',	'961',	'LB',	'LBN',	NULL,	NULL),
        (117,	'Lesotho',	'266',	'LS',	'LSO',	NULL,	NULL),
        (118,	'Liberia',	'231',	'LR',	'LBR',	NULL,	NULL),
        (119,	'Libya',	'218',	'LY',	'LBY',	NULL,	NULL),
        (120,	'Liechtenstein',	'423',	'LI',	'LIE',	NULL,	NULL),
        (121,	'Lithuania',	'370',	'LT',	'LTU',	NULL,	NULL),
        (122,	'Luxembourg',	'352',	'LU',	'LUX',	NULL,	NULL),
        (123,	'Macau',	'853',	'MO',	'MAC',	NULL,	NULL),
        (124,	'Macedonia',	'389',	'MK',	'MKD',	NULL,	NULL),
        (125,	'Madagascar',	'261',	'MG',	'MDG',	NULL,	NULL),
        (126,	'Malawi',	'265',	'MW',	'MWI',	NULL,	NULL),
        (127,	'Malaysia',	'60',	'MY',	'MYS',	NULL,	NULL),
        (128,	'Maldives',	'960',	'MV',	'MDV',	NULL,	NULL),
        (129,	'Mali',	'223',	'ML',	'MLI',	NULL,	NULL),
        (130,	'Malta',	'356',	'MT',	'MLT',	NULL,	NULL),
        (131,	'Marshall Islands',	'692',	'MH',	'MHL',	NULL,	NULL),
        (132,	'Mauritania',	'222',	'MR',	'MRT',	NULL,	NULL),
        (133,	'Mauritius',	'230',	'MU',	'MUS',	NULL,	NULL),
        (134,	'Mayotte',	'262',	'YT',	'MYT',	NULL,	NULL),
        (135,	'Mexico',	'52',	'MX',	'MEX',	NULL,	NULL),
        (136,	'Micronesia',	'691',	'FM',	'FSM',	NULL,	NULL),
        (137,	'Moldova',	'373',	'MD',	'MDA',	NULL,	NULL),
        (138,	'Monaco',	'377',	'MC',	'MCO',	NULL,	NULL),
        (139,	'Mongolia',	'976',	'MN',	'MNG',	NULL,	NULL),
        (140,	'Montenegro',	'382',	'ME',	'MNE',	NULL,	NULL),
        (141,	'Montserrat',	'1-664',	'MS',	'MSR',	NULL,	NULL),
        (142,	'Morocco',	'212',	'MA',	'MAR',	NULL,	NULL),
        (143,	'Mozambique',	'258',	'MZ',	'MOZ',	NULL,	NULL),
        (144,	'Myanmar',	'95',	'MM',	'MMR',	NULL,	NULL),
        (145,	'Namibia',	'264',	'NA',	'NAM',	NULL,	NULL),
        (146,	'Nauru',	'674',	'NR',	'NRU',	NULL,	NULL),
        (147,	'Nepal',	'977',	'NP',	'NPL',	NULL,	NULL),
        (148,	'Netherlands',	'31',	'NL',	'NLD',	NULL,	NULL),
        (149,	'Netherlands Antilles',	'599',	'AN',	'ANT',	NULL,	NULL),
        (150,	'New Caledonia',	'687',	'NC',	'NCL',	NULL,	NULL),
        (151,	'New Zealand',	'64',	'NZ',	'NZL',	NULL,	NULL),
        (152,	'Nicaragua',	'505',	'NI',	'NIC',	NULL,	NULL),
        (153,	'Niger',	'227',	'NE',	'NER',	NULL,	NULL),
        (154,	'Nigeria',	'234',	'NG',	'NGA',	NULL,	NULL),
        (155,	'Niue',	'683',	'NU',	'NIU',	NULL,	NULL),
        (156,	'North Korea',	'850',	'KP',	'PRK',	NULL,	NULL),
        (157,	'Northern Mariana Islands',	'1-670',	'MP',	'MNP',	NULL,	NULL),
        (158,	'Norway',	'47',	'NO',	'NOR',	NULL,	NULL),
        (159,	'Oman',	'968',	'OM',	'OMN',	NULL,	NULL),
        (160,	'Pakistan',	'92',	'PK',	'PAK',	NULL,	NULL),
        (161,	'Palau',	'680',	'PW',	'PLW',	NULL,	NULL),
        (162,	'Palestine',	'970',	'PS',	'PSE',	NULL,	NULL),
        (163,	'Panama',	'507',	'PA',	'PAN',	NULL,	NULL),
        (164,	'Papua New Guinea',	'675',	'PG',	'PNG',	NULL,	NULL),
        (165,	'Paraguay',	'595',	'PY',	'PRY',	NULL,	NULL),
        (166,	'Peru',	'51',	'PE',	'PER',	NULL,	NULL),
        (167,	'Philippines',	'63',	'PH',	'PHL',	NULL,	NULL),
        (168,	'Pitcairn',	'64',	'PN',	'PCN',	NULL,	NULL),
        (169,	'Poland',	'48',	'PL',	'POL',	NULL,	NULL),
        (170,	'Portugal',	'351',	'PT',	'PRT',	NULL,	NULL),
        (171,	'Puerto Rico',	'1-787',	'PR',	'PRI',	NULL,	NULL),
        (172,	'Qatar',	'974',	'QA',	'QAT',	NULL,	NULL),
        (173,	'Republic of the Congo',	'242',	'CG',	'COG',	NULL,	NULL),
        (174,	'Reunion',	'262',	'RE',	'REU',	NULL,	NULL),
        (175,	'Romania',	'40',	'RO',	'ROU',	NULL,	NULL),
        (176,	'Russia',	'7',	'RU',	'RUS',	NULL,	NULL),
        (177,	'Rwanda',	'250',	'RW',	'RWA',	NULL,	NULL),
        (178,	'Saint Barthelemy',	'590',	'BL',	'BLM',	NULL,	NULL),
        (179,	'Saint Helena',	'290',	'SH',	'SHN',	NULL,	NULL),
        (180,	'Saint Kitts and Nevis',	'1-869',	'KN',	'KNA',	NULL,	NULL),
        (181,	'Saint Lucia',	'1-758',	'LC',	'LCA',	NULL,	NULL),
        (182,	'Saint Martin',	'590',	'MF',	'MAF',	NULL,	NULL),
        (183,	'Saint Pierre and Miquelon',	'508',	'PM',	'SPM',	NULL,	NULL),
        (184,	'Saint Vincent and the Grenadines',	'1-784',	'VC',	'VCT',	NULL,	NULL),
        (185,	'Samoa',	'685',	'WS',	'WSM',	NULL,	NULL),
        (186,	'San Marino',	'378',	'SM',	'SMR',	NULL,	NULL),
        (187,	'Sao Tome and Principe',	'239',	'ST',	'STP',	NULL,	NULL),
        (188,	'Saudi Arabia',	'966',	'SA',	'SAU',	NULL,	NULL),
        (189,	'Senegal',	'221',	'SN',	'SEN',	NULL,	NULL),
        (190,	'Serbia',	'381',	'RS',	'SRB',	NULL,	NULL),
        (191,	'Seychelles',	'248',	'SC',	'SYC',	NULL,	NULL),
        (192,	'Sierra Leone',	'232',	'SL',	'SLE',	NULL,	NULL),
        (193,	'Singapore',	'65',	'SG',	'SGP',	NULL,	NULL),
        (194,	'Sint Maarten',	'1-721',	'SX',	'SXM',	NULL,	NULL),
        (195,	'Slovakia',	'421',	'SK',	'SVK',	NULL,	NULL),
        (196,	'Slovenia',	'386',	'SI',	'SVN',	NULL,	NULL),
        (197,	'Solomon Islands',	'677',	'SB',	'SLB',	NULL,	NULL),
        (198,	'Somalia',	'252',	'SO',	'SOM',	NULL,	NULL),
        (199,	'South Africa',	'27',	'ZA',	'ZAF',	NULL,	NULL),
        (200,	'South Korea',	'82',	'KR',	'KOR',	NULL,	NULL),
        (201,	'South Sudan',	'211',	'SS',	'SSD',	NULL,	NULL),
        (202,	'Spain',	'34',	'ES',	'ESP',	NULL,	NULL),
        (203,	'Sri Lanka',	'94',	'LK',	'LKA',	NULL,	NULL),
        (204,	'Sudan',	'249',	'SD',	'SDN',	NULL,	NULL),
        (205,	'Suriname',	'597',	'SR',	'SUR',	NULL,	NULL),
        (206,	'Svalbard and Jan Mayen',	'47',	'SJ',	'SJM',	NULL,	NULL),
        (207,	'Swaziland',	'268',	'SZ',	'SWZ',	NULL,	NULL),
        (208,	'Sweden',	'46',	'SE',	'SWE',	NULL,	NULL),
        (209,	'Switzerland',	'41',	'CH',	'CHE',	NULL,	NULL),
        (210,	'Syria',	'963',	'SY',	'SYR',	NULL,	NULL),
        (211,	'Taiwan',	'886',	'TW',	'TWN',	NULL,	NULL),
        (212,	'Tajikistan',	'992',	'TJ',	'TJK',	NULL,	NULL),
        (213,	'Tanzania',	'255',	'TZ',	'TZA',	NULL,	NULL),
        (214,	'Thailand',	'66',	'TH',	'THA',	NULL,	NULL),
        (215,	'Togo',	'228',	'TG',	'TGO',	NULL,	NULL),
        (216,	'Tokelau',	'690',	'TK',	'TKL',	NULL,	NULL),
        (217,	'Tonga',	'676',	'TO',	'TON',	NULL,	NULL),
        (218,	'Trinidad and Tobago',	'1-868',	'TT',	'TTO',	NULL,	NULL),
        (219,	'Tunisia',	'216',	'TN',	'TUN',	NULL,	NULL),
        (220,	'Turkey',	'90',	'TR',	'TUR',	NULL,	NULL),
        (221,	'Turkmenistan',	'993',	'TM',	'TKM',	NULL,	NULL),
        (222,	'Turks and Caicos Islands',	'1-649',	'TC',	'TCA',	NULL,	NULL),
        (223,	'Tuvalu',	'688',	'TV',	'TUV',	NULL,	NULL),
        (224,	'U.S. Virgin Islands',	'1-340',	'VI',	'VIR',	NULL,	NULL),
        (225,	'Uganda',	'256',	'UG',	'UGA',	NULL,	NULL),
        (226,	'Ukraine',	'380',	'UA',	'UKR',	NULL,	NULL),
        (227,	'United Arab Emirates',	'971',	'AE',	'ARE',	NULL,	NULL),
        (228,	'United Kingdom',	'44',	'GB',	'GBR',	NULL,	NULL),
        (229,	'United States',	'1',	'US',	'USA',	NULL,	NULL),
        (230,	'Uruguay',	'598',	'UY',	'URY',	NULL,	NULL),
        (231,	'Uzbekistan',	'998',	'UZ',	'UZB',	NULL,	NULL),
        (232,	'Vanuatu',	'678',	'VU',	'VUT',	NULL,	NULL),
        (233,	'Vatican',	'379',	'VA',	'VAT',	NULL,	NULL),
        (234,	'Venezuela',	'58',	'VE',	'VEN',	NULL,	NULL),
        (235,	'Vietnam',	'84',	'VN',	'VNM',	NULL,	NULL),
        (236,	'Wallis and Futuna',	'681',	'WF',	'WLF',	NULL,	NULL),
        (237,	'Western Sahara',	'212',	'EH',	'ESH',	NULL,	NULL),
        (238,	'Yemen',	'967',	'YE',	'YEM',	NULL,	NULL),
        (239,	'Zambia',	'260',	'ZM',	'ZMB',	NULL,	NULL),
        (240,	'Zimbabwe',	'263',	'ZW',	'ZWE',	NULL,	NULL);
        ");
    }
}