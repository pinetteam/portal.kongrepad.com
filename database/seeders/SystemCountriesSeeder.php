<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SystemCountriesSeeder extends Seeder
{
    /**
     * Comprehensive World Countries Seeder
     * Covers 5-language markets with global reach
     * 163 countries across all continents
     */
    public function run(): void
    {
        $countries = [
            // TIER 1 - Primary 5-Language Markets
            
            // Turkish-speaking regions
            ['TR', 'TUR', 'Turkey', '+90', 'TRY', '₺', '🇹🇷', true, 1],
            ['CY', 'CYP', 'Cyprus', '+357', 'EUR', '€', '🇨🇾', true, 2],
            
            // English-speaking countries
            ['US', 'USA', 'United States', '+1', 'USD', '$', '🇺🇸', true, 3],
            ['GB', 'GBR', 'United Kingdom', '+44', 'GBP', '£', '🇬🇧', true, 4],
            ['CA', 'CAN', 'Canada', '+1', 'CAD', 'C$', '🇨🇦', true, 5],
            ['AU', 'AUS', 'Australia', '+61', 'AUD', 'A$', '🇦🇺', true, 6],
            ['NZ', 'NZL', 'New Zealand', '+64', 'NZD', 'NZ$', '🇳🇿', true, 7],
            ['IE', 'IRL', 'Ireland', '+353', 'EUR', '€', '🇮🇪', true, 8],
            ['ZA', 'ZAF', 'South Africa', '+27', 'ZAR', 'R', '🇿🇦', true, 9],
            
            // German-speaking countries
            ['DE', 'DEU', 'Germany', '+49', 'EUR', '€', '🇩🇪', true, 10],
            ['AT', 'AUT', 'Austria', '+43', 'EUR', '€', '🇦🇹', true, 11],
            ['CH', 'CHE', 'Switzerland', '+41', 'CHF', 'CHF', '🇨🇭', true, 12],
            ['LI', 'LIE', 'Liechtenstein', '+423', 'CHF', 'CHF', '🇱🇮', true, 13],
            
            // Arabic-speaking countries  
            ['SA', 'SAU', 'Saudi Arabia', '+966', 'SAR', 'ر.س', '🇸🇦', true, 14],
            ['AE', 'ARE', 'United Arab Emirates', '+971', 'AED', 'د.إ', '🇦🇪', true, 15],
            ['EG', 'EGY', 'Egypt', '+20', 'EGP', 'ج.م', '🇪🇬', true, 16],
            ['QA', 'QAT', 'Qatar', '+974', 'QAR', 'ر.ق', '🇶🇦', true, 17],
            ['KW', 'KWT', 'Kuwait', '+965', 'KWD', 'د.ك', '🇰🇼', true, 18],
            ['BH', 'BHR', 'Bahrain', '+973', 'BHD', '.د.ب', '🇧🇭', true, 19],
            ['OM', 'OMN', 'Oman', '+968', 'OMR', 'ر.ع.', '🇴🇲', true, 20],
            ['JO', 'JOR', 'Jordan', '+962', 'JOD', 'د.ا', '🇯🇴', true, 21],
            ['LB', 'LBN', 'Lebanon', '+961', 'LBP', 'ل.ل', '🇱🇧', true, 22],
            ['MA', 'MAR', 'Morocco', '+212', 'MAD', 'د.م.', '🇲🇦', true, 23],
            ['TN', 'TUN', 'Tunisia', '+216', 'TND', 'د.ت', '🇹🇳', true, 24],
            ['DZ', 'DZA', 'Algeria', '+213', 'DZD', 'د.ج', '🇩🇿', true, 25],
            ['IQ', 'IRQ', 'Iraq', '+964', 'IQD', 'ع.د', '🇮🇶', true, 26],
            ['SY', 'SYR', 'Syria', '+963', 'SYP', 'ل.س', '🇸🇾', true, 27],
            ['YE', 'YEM', 'Yemen', '+967', 'YER', '﷼', '🇾🇪', true, 28],
            ['LY', 'LBY', 'Libya', '+218', 'LYD', 'ل.د', '🇱🇾', true, 29],
            ['SD', 'SDN', 'Sudan', '+249', 'SDG', 'ج.س.', '🇸🇩', true, 30],
            ['PS', 'PSE', 'Palestine', '+970', 'ILS', '₪', '🇵🇸', true, 31],
            
            // Russian-speaking countries
            ['RU', 'RUS', 'Russia', '+7', 'RUB', '₽', '🇷🇺', true, 32],
            ['BY', 'BLR', 'Belarus', '+375', 'BYN', 'Br', '🇧🇾', true, 33],
            ['KZ', 'KAZ', 'Kazakhstan', '+7', 'KZT', '₸', '🇰🇿', true, 34],
            ['KG', 'KGZ', 'Kyrgyzstan', '+996', 'KGS', 'с', '🇰🇬', true, 35],
            ['UZ', 'UZB', 'Uzbekistan', '+998', 'UZS', 'сўм', '🇺🇿', true, 36],
            ['TJ', 'TJK', 'Tajikistan', '+992', 'TJS', 'ЅМ', '🇹🇯', true, 37],
            ['MD', 'MDA', 'Moldova', '+373', 'MDL', 'L', '🇲🇩', true, 38],
            ['AM', 'ARM', 'Armenia', '+374', 'AMD', '֏', '🇦🇲', true, 39],
            ['GE', 'GEO', 'Georgia', '+995', 'GEL', '₾', '🇬🇪', true, 40],

            // TIER 2 - Major European Markets
            ['FR', 'FRA', 'France', '+33', 'EUR', '€', '🇫🇷', true, 41],
            ['IT', 'ITA', 'Italy', '+39', 'EUR', '€', '🇮🇹', true, 42],
            ['ES', 'ESP', 'Spain', '+34', 'EUR', '€', '🇪🇸', true, 43],
            ['NL', 'NLD', 'Netherlands', '+31', 'EUR', '€', '🇳🇱', true, 44],
            ['BE', 'BEL', 'Belgium', '+32', 'EUR', '€', '🇧🇪', true, 45],
            ['PL', 'POL', 'Poland', '+48', 'PLN', 'zł', '🇵🇱', true, 46],
            ['SE', 'SWE', 'Sweden', '+46', 'SEK', 'kr', '🇸🇪', true, 47],
            ['NO', 'NOR', 'Norway', '+47', 'NOK', 'kr', '🇳🇴', true, 48],
            ['DK', 'DNK', 'Denmark', '+45', 'DKK', 'kr', '🇩🇰', true, 49],
            ['FI', 'FIN', 'Finland', '+358', 'EUR', '€', '🇫🇮', true, 50],
            ['CZ', 'CZE', 'Czech Republic', '+420', 'CZK', 'Kč', '🇨🇿', true, 51],
            ['HU', 'HUN', 'Hungary', '+36', 'HUF', 'Ft', '🇭🇺', true, 52],
            ['PT', 'PRT', 'Portugal', '+351', 'EUR', '€', '🇵🇹', true, 53],
            ['GR', 'GRC', 'Greece', '+30', 'EUR', '€', '🇬🇷', true, 54],
            ['RO', 'ROU', 'Romania', '+40', 'RON', 'lei', '🇷🇴', true, 55],
            ['BG', 'BGR', 'Bulgaria', '+359', 'BGN', 'лв', '🇧🇬', true, 56],
            ['HR', 'HRV', 'Croatia', '+385', 'EUR', '€', '🇭🇷', true, 57],
            ['SK', 'SVK', 'Slovakia', '+421', 'EUR', '€', '🇸🇰', true, 58],
            ['SI', 'SVN', 'Slovenia', '+386', 'EUR', '€', '🇸🇮', true, 59],
            ['EE', 'EST', 'Estonia', '+372', 'EUR', '€', '🇪🇪', true, 60],
            ['LV', 'LVA', 'Latvia', '+371', 'EUR', '€', '🇱🇻', true, 61],
            ['LT', 'LTU', 'Lithuania', '+370', 'EUR', '€', '🇱🇹', true, 62],
            ['IS', 'ISL', 'Iceland', '+354', 'ISK', 'kr', '🇮🇸', true, 63],
            ['MT', 'MLT', 'Malta', '+356', 'EUR', '€', '🇲🇹', true, 64],
            ['LU', 'LUX', 'Luxembourg', '+352', 'EUR', '€', '🇱🇺', true, 65],
            ['MC', 'MCO', 'Monaco', '+377', 'EUR', '€', '🇲🇨', true, 66],
            ['VA', 'VAT', 'Vatican City', '+379', 'EUR', '€', '🇻🇦', true, 67],
            ['SM', 'SMR', 'San Marino', '+378', 'EUR', '€', '🇸🇲', true, 68],
            ['AD', 'AND', 'Andorra', '+376', 'EUR', '€', '🇦🇩', true, 69],
            ['AL', 'ALB', 'Albania', '+355', 'ALL', 'L', '🇦🇱', true, 70],
            ['BA', 'BIH', 'Bosnia and Herzegovina', '+387', 'BAM', 'КМ', '🇧🇦', true, 71],
            ['ME', 'MNE', 'Montenegro', '+382', 'EUR', '€', '🇲🇪', true, 72],
            ['MK', 'MKD', 'North Macedonia', '+389', 'MKD', 'ден', '🇲🇰', true, 73],
            ['RS', 'SRB', 'Serbia', '+381', 'RSD', 'дин.', '🇷🇸', true, 74],
            ['XK', 'XKX', 'Kosovo', '+383', 'EUR', '€', '🇽🇰', true, 75],
            ['UA', 'UKR', 'Ukraine', '+380', 'UAH', '₴', '🇺🇦', true, 76],

            // TIER 3 - Major Asian Markets
            ['CN', 'CHN', 'China', '+86', 'CNY', '¥', '🇨🇳', true, 77],
            ['JP', 'JPN', 'Japan', '+81', 'JPY', '¥', '🇯🇵', true, 78],
            ['KR', 'KOR', 'South Korea', '+82', 'KRW', '₩', '🇰🇷', true, 79],
            ['IN', 'IND', 'India', '+91', 'INR', '₹', '🇮🇳', true, 80],
            ['ID', 'IDN', 'Indonesia', '+62', 'IDR', 'Rp', '🇮🇩', true, 81],
            ['MY', 'MYS', 'Malaysia', '+60', 'MYR', 'RM', '🇲🇾', true, 82],
            ['SG', 'SGP', 'Singapore', '+65', 'SGD', 'S$', '🇸🇬', true, 83],
            ['TH', 'THA', 'Thailand', '+66', 'THB', '฿', '🇹🇭', true, 84],
            ['VN', 'VNM', 'Vietnam', '+84', 'VND', '₫', '🇻🇳', true, 85],
            ['PH', 'PHL', 'Philippines', '+63', 'PHP', '₱', '🇵🇭', true, 86],
            ['TW', 'TWN', 'Taiwan', '+886', 'TWD', 'NT$', '🇹🇼', true, 87],
            ['HK', 'HKG', 'Hong Kong', '+852', 'HKD', 'HK$', '🇭🇰', true, 88],
            ['IL', 'ISR', 'Israel', '+972', 'ILS', '₪', '🇮🇱', true, 89],
            ['IR', 'IRN', 'Iran', '+98', 'IRR', '﷼', '🇮🇷', true, 90],
            ['PK', 'PAK', 'Pakistan', '+92', 'PKR', '₨', '🇵🇰', true, 91],
            ['BD', 'BGD', 'Bangladesh', '+880', 'BDT', '৳', '🇧🇩', true, 92],
            ['LK', 'LKA', 'Sri Lanka', '+94', 'LKR', '₨', '🇱🇰', true, 93],
            ['MM', 'MMR', 'Myanmar', '+95', 'MMK', 'Ks', '🇲🇲', true, 94],
            ['KH', 'KHM', 'Cambodia', '+855', 'KHR', '៛', '🇰🇭', true, 95],
            ['LA', 'LAO', 'Laos', '+856', 'LAK', '₭', '🇱🇦', true, 96],
            ['BN', 'BRN', 'Brunei', '+673', 'BND', 'B$', '🇧🇳', true, 97],
            ['MN', 'MNG', 'Mongolia', '+976', 'MNT', '₮', '🇲🇳', true, 98],
            ['NP', 'NPL', 'Nepal', '+977', 'NPR', '₨', '🇳🇵', true, 99],
            ['BT', 'BTN', 'Bhutan', '+975', 'BTN', 'Nu.', '🇧🇹', true, 100],
            ['MV', 'MDV', 'Maldives', '+960', 'MVR', '.ރ', '🇲🇻', true, 101],
            ['AF', 'AFG', 'Afghanistan', '+93', 'AFN', '؋', '🇦🇫', true, 102],
            ['TM', 'TKM', 'Turkmenistan', '+993', 'TMT', 'T', '🇹🇲', true, 103],
            ['AZ', 'AZE', 'Azerbaijan', '+994', 'AZN', '₼', '🇦🇿', true, 104],

            // TIER 4 - Americas
            ['MX', 'MEX', 'Mexico', '+52', 'MXN', 'Mex$', '🇲🇽', true, 105],
            ['BR', 'BRA', 'Brazil', '+55', 'BRL', 'R$', '🇧🇷', true, 106],
            ['AR', 'ARG', 'Argentina', '+54', 'ARS', 'AR$', '🇦🇷', true, 107],
            ['CL', 'CHL', 'Chile', '+56', 'CLP', 'CL$', '🇨🇱', true, 108],
            ['CO', 'COL', 'Colombia', '+57', 'COP', 'CO$', '🇨🇴', true, 109],
            ['PE', 'PER', 'Peru', '+51', 'PEN', 'S/', '🇵🇪', true, 110],
            ['VE', 'VEN', 'Venezuela', '+58', 'VES', 'Bs.S', '🇻🇪', true, 111],
            ['EC', 'ECU', 'Ecuador', '+593', 'USD', 'US$', '🇪🇨', true, 112],
            ['UY', 'URY', 'Uruguay', '+598', 'UYU', 'UY$', '🇺🇾', true, 113],
            ['PY', 'PRY', 'Paraguay', '+595', 'PYG', '₲', '🇵🇾', true, 114],
            ['BO', 'BOL', 'Bolivia', '+591', 'BOB', 'Bs.', '🇧🇴', true, 115],
            ['CR', 'CRI', 'Costa Rica', '+506', 'CRC', '₡', '🇨🇷', true, 116],
            ['PA', 'PAN', 'Panama', '+507', 'PAB', 'B/.', '🇵🇦', true, 117],
            ['GT', 'GTM', 'Guatemala', '+502', 'GTQ', 'Q', '🇬🇹', true, 118],
            ['CU', 'CUB', 'Cuba', '+53', 'CUP', 'CU$', '🇨🇺', true, 119],
            ['DO', 'DOM', 'Dominican Republic', '+1', 'DOP', 'RD$', '🇩🇴', true, 120],
            ['JM', 'JAM', 'Jamaica', '+1', 'JMD', 'J$', '🇯🇲', true, 121],
            ['TT', 'TTO', 'Trinidad and Tobago', '+1', 'TTD', 'TT$', '🇹🇹', true, 122],
            ['BS', 'BHS', 'Bahamas', '+1', 'BSD', 'B$', '🇧🇸', true, 123],
            ['BB', 'BRB', 'Barbados', '+1', 'BBD', 'Bds$', '🇧🇧', true, 124],

            // TIER 5 - Africa  
            ['NG', 'NGA', 'Nigeria', '+234', 'NGN', '₦', '🇳🇬', true, 125],
            ['KE', 'KEN', 'Kenya', '+254', 'KES', 'Sh', '🇰🇪', true, 126],
            ['ET', 'ETH', 'Ethiopia', '+251', 'ETB', 'Br', '🇪🇹', true, 127],
            ['GH', 'GHA', 'Ghana', '+233', 'GHS', '₵', '🇬🇭', true, 128],
            ['TZ', 'TZA', 'Tanzania', '+255', 'TZS', 'Sh', '🇹🇿', true, 129],
            ['UG', 'UGA', 'Uganda', '+256', 'UGX', 'Sh', '🇺🇬', true, 130],
            ['AO', 'AGO', 'Angola', '+244', 'AOA', 'Kz', '🇦🇴', true, 131],
            ['MZ', 'MOZ', 'Mozambique', '+258', 'MZN', 'MT', '🇲🇿', true, 132],
            ['MG', 'MDG', 'Madagascar', '+261', 'MGA', 'Ar', '🇲🇬', true, 133],
            ['CM', 'CMR', 'Cameroon', '+237', 'XAF', 'FCFA', '🇨🇲', true, 134],
            ['CI', 'CIV', 'Ivory Coast', '+225', 'XOF', 'CFA', '🇨🇮', true, 135],
            ['NE', 'NER', 'Niger', '+227', 'XOF', 'CFA', '🇳🇪', true, 136],
            ['BF', 'BFA', 'Burkina Faso', '+226', 'XOF', 'CFA', '🇧🇫', true, 137],
            ['ML', 'MLI', 'Mali', '+223', 'XOF', 'CFA', '🇲🇱', true, 138],
            ['ZW', 'ZWE', 'Zimbabwe', '+263', 'ZWL', 'Z$', '🇿🇼', true, 139],
            ['ZM', 'ZMB', 'Zambia', '+260', 'ZMW', 'ZK', '🇿🇲', true, 140],
            ['SN', 'SEN', 'Senegal', '+221', 'XOF', 'CFA', '🇸🇳', true, 141],
            ['RW', 'RWA', 'Rwanda', '+250', 'RWF', 'Fr', '🇷🇼', true, 142],
            ['SO', 'SOM', 'Somalia', '+252', 'SOS', 'Sh', '🇸🇴', true, 143],
            ['CD', 'COD', 'Democratic Republic of the Congo', '+243', 'CDF', 'Fr', '🇨🇩', true, 144],
            ['CF', 'CAF', 'Central African Republic', '+236', 'XAF', 'FCFA', '🇨🇫', true, 145],
            ['TD', 'TCD', 'Chad', '+235', 'XAF', 'FCFA', '🇹🇩', true, 146],
            ['SS', 'SSD', 'South Sudan', '+211', 'SSP', '£', '🇸🇸', true, 147],
            ['ER', 'ERI', 'Eritrea', '+291', 'ERN', 'Nfk', '🇪🇷', true, 148],
            ['DJ', 'DJI', 'Djibouti', '+253', 'DJF', 'Fr', '🇩🇯', true, 149],
            ['GM', 'GMB', 'Gambia', '+220', 'GMD', 'D', '🇬🇲', true, 150],

            // TIER 6 - Oceania
            ['FJ', 'FJI', 'Fiji', '+679', 'FJD', 'FJ$', '🇫🇯', true, 151],
            ['PG', 'PNG', 'Papua New Guinea', '+675', 'PGK', 'K', '🇵🇬', true, 152],
            ['SB', 'SLB', 'Solomon Islands', '+677', 'SBD', 'SI$', '🇸🇧', true, 153],
            ['VU', 'VUT', 'Vanuatu', '+678', 'VUV', 'Vt', '🇻🇺', true, 154],
            ['WS', 'WSM', 'Samoa', '+685', 'WST', 'T', '🇼🇸', true, 155],
            ['TO', 'TON', 'Tonga', '+676', 'TOP', 'T$', '🇹🇴', true, 156],
            ['KI', 'KIR', 'Kiribati', '+686', 'AUD', 'A$', '🇰🇮', true, 157],
            ['TV', 'TUV', 'Tuvalu', '+688', 'AUD', 'A$', '🇹🇻', true, 158],
            ['NR', 'NRU', 'Nauru', '+674', 'AUD', 'A$', '🇳🇷', true, 159],
            ['PW', 'PLW', 'Palau', '+680', 'USD', 'US$', '🇵🇼', true, 160],
            ['FM', 'FSM', 'Micronesia', '+691', 'USD', 'US$', '🇫🇲', true, 161],
            ['MH', 'MHL', 'Marshall Islands', '+692', 'USD', 'US$', '🇲🇭', true, 162],
            
        ];

        echo "🌍 Seeding Global Countries Database (163 countries)...\n";

        foreach ($countries as $country) {
            DB::table('system_countries')->insert([
                'id' => Str::uuid(),
                'code' => $country[0],
                'code_3' => $country[1],
                'name' => $country[2],
                'phone_code' => $country[3],
                'currency_code' => $country[4],
                'currency_symbol' => $country[5],
                'flag_emoji' => $country[6],
                'is_active' => $country[7],
                'sort_order' => $country[8],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $status = $country[7] ? '🎯' : '📍';
            echo "   {$status} {$country[6]} {$country[2]} ({$country[0]})\n";
        }

        echo "\n📊 Global Coverage Summary:\n";
        echo "   • Total Countries: " . count($countries) . "\n";
        echo "   • Turkish Markets: 2 countries\n";
        echo "   • English Markets: 7 countries\n";
        echo "   • German Markets: 4 countries\n";
        echo "   • Arabic Markets: 18 countries\n";
        echo "   • Russian Markets: 9 countries\n";
        echo "   • European Markets: 36 countries\n";
        echo "   • Asian Markets: 28 countries\n";
        echo "   • Americas: 20 countries\n";
        echo "   • Africa: 25 countries\n";
        echo "   • Oceania: 13 countries\n\n";
        echo "🚀 Comprehensive global conference infrastructure ready!\n\n";
    }
} 