<?php
	
	/*******************************************************************************************************************
	 * Project : shelteradmin
	 * file: I18n.php
	 *
	 * @author        : Christian Denat
	 * @email         : contact@noleam.fr
	 *
	 * --
	 *
	 * updated 'on' => 10/16/22, 8:50 AM
	 *
	 * @copyright (c) 2022 noleam.fr
	 *
	 ******************************************************************************************************************/
	
	namespace dashboard;
	
	use Locale;
	
	class I18n {
		
		
		public static function set_domain( $domain, $directory )
		: void {
			textdomain( $domain );
			bindtextdomain( $domain, $directory );
			bind_textdomain_codeset( $domain, 'UTF-8' );
		}
		
		/**
		 * Get all languages by scanning languages directory
		 *
		 * @param  string  $directory  to scan
		 *
		 * @return array List of languages
		 *
		 * @since 1.1.0
		 *
		 */
		public static function get_available_languages( string $directory )
		: array {
			$languages = [ LANG_DEFAULT ];
			foreach ( glob( $directory . '*' ) as $trad ) {
				if ( preg_match( '/([a-z]{2}_[A-Z]{2})/', $trad, $lang ) ) {
					$languages[] = $lang[1];
				}
			}
			
			return $languages;
			
		}
		
		/**
		 * Get browser language  and check if its settings are defined
		 *
		 * for a language xx_YY we return xx_YY if it exists
		 * for xx or YY we return xx_YY ir xx_YY exists
		 *
		 * else LANG_DEFAULT if nothing found.
		 *
		 * @return bool|string
		 *
		 * @since 1.1.0
		 *
		 */
		public static function validate_browser_language()
		: bool|string {
			$locale = Locale::acceptFromHttp( $_SERVER['HTTP_ACCEPT_LANGUAGE'] );
			
			// locale exists in the language list
			if ( in_array( $locale, LANG_LIST ) ) {
				return $locale;
			}
			
			// let's try if it's part of some existing keys. We return the full locale if it is ok (FIFO)
			// ie, we're looking fr or FR subdirectory if language is fr_FR
			
			foreach ( LANG_LIST as $lang ) {
				if ( in_array( $locale, explode( '_', $lang ) ) ) {
					return $lang;
				}
			}
			
			// Not found, we return Default language
			return LANG_DEFAULT;
			
		}
		
		public static function set_lang(
			$locale = null, $old = null
		)
		: string {
			$name   = C_NAME . '-lang';
			$cookie = null;
			
			$cookie = json_decode( $_COOKIE[ $name ] ?? '{}', true );
			
			if ( $locale === null ) {
				// If we do not have entry, we get locale from cookie or from browser
				$locale = $cookie['lang'] ?? self::validate_browser_language();
			}
			
			if ($old === null) {
				// Get old
				$old = $cookie['old'];
			}
			
			// If the local is not in the list of available languages, we set it to default
			$locale = in_array( $locale, LANG_LIST ) ? $locale : LANG_DEFAULT;
			
			// We set the locale
			setlocale( LC_ALL, $locale );
			setlocale( LC_MESSAGES, $locale );
			setlocale( LC_CTYPE, $locale );
			// set cookie set one year if it's not a get equiv ($old === null)
			setcookie( $name, json_encode( [
				                               'lang'   => $locale,
				                               'old'    => $old,
				                               'change' => $old !== null && $locale !== $old,
			                               ] ),
			           time() + 60 * 60 * 24 * 365, '/' );
			
			return $locale;
		}
		
		public static function get_lang()
		: bool|string {
			$cookie = json_decode( $_COOKIE[ C_NAME . '-lang' ] ?? '{}', true );
			return $cookie['lang'];
		}
		
		public static function get_country_codes( $code = null )
		: array {
			// @formatter => off
			$cc = [
				'AF' => _( 'Afghanistan' ),
				'AX' => _( 'Åland Islands' ),
				'AL' => _( 'Albania' ),
				'DZ' => _( 'Algeria' ),
				'AS' => _( 'American Samoa' ),
				'AD' => _( 'AndorrA' ),
				'AO' => _( 'Angola' ),
				'AI' => _( 'Anguilla' ),
				'AQ' => _( 'Antarctica' ),
				'AG' => _( 'Antigua and Barbuda' ),
				'AR' => _( 'Argentina' ),
				'AM' => _( 'Armenia' ),
				'AW' => _( 'Aruba' ),
				'AU' => _( 'Australia' ),
				'AT' => _( 'Austria' ),
				'AZ' => _( 'Azerbaijan' ),
				'BS' => _( 'Bahamas' ),
				'BH' => _( 'Bahrain' ),
				'BD' => _( 'Bangladesh' ),
				'BB' => _( 'Barbados' ),
				'BY' => _( 'Belarus' ),
				'BE' => _( 'Belgium' ),
				'BZ' => _( 'Belize' ),
				'BJ' => _( 'Benin' ),
				'BM' => _( 'Bermuda' ),
				'BT' => _( 'Bhutan' ),
				'BO' => _( 'Bolivia' ),
				'BA' => _( 'Bosnia and Herzegovina' ),
				'BW' => _( 'Botswana' ),
				'BV' => _( 'Bouvet Island' ),
				'BR' => _( 'Brazil' ),
				'IO' => _( 'British Indian Ocean Territory' ),
				'BN' => _( 'Brunei Darussalam' ),
				'BG' => _( 'Bulgaria' ),
				'BF' => _( 'Burkina Faso' ),
				'BI' => _( 'Burundi' ),
				'KH' => _( 'Cambodia' ),
				'CM' => _( 'Cameroon' ),
				'CA' => _( 'Canada' ),
				'CV' => _( 'Cape Verde' ),
				'KY' => _( 'Cayman Islands' ),
				'CF' => _( 'Central African Republic' ),
				'TD' => _( 'Chad' ),
				'CL' => _( 'Chile' ),
				'CN' => _( 'China' ),
				'CX' => _( 'Christmas Island' ),
				'CC' => _( 'Cocos (Keeling) Islands' ),
				'CO' => _( 'Colombia' ),
				'KM' => _( 'Comoros' ),
				'CG' => _( 'Congo' ),
				'CD' => _( 'Congo, The Democratic Republic of the' ),
				'CK' => _( 'Cook Islands' ),
				'CR' => _( 'Costa Rica' ),
				'CI' => _( 'Cote D\'Ivoire' ),
				'HR' => _( 'Croatia' ),
				'CU' => _( 'Cuba' ),
				'CY' => _( 'Cyprus' ),
				'CZ' => _( 'Czech Republic' ),
				'DK' => _( 'Denmark' ),
				'DJ' => _( 'Djibouti' ),
				'DM' => _( 'Dominica' ),
				'DO' => _( 'Dominican Republic' ),
				'EC' => _( 'Ecuador' ),
				'EG' => _( 'Egypt' ),
				'SV' => _( 'El Salvador' ),
				'GQ' => _( 'Equatorial Guinea' ),
				'ER' => _( 'Eritrea' ),
				'EE' => _( 'Estonia' ),
				'ET' => _( 'Ethiopia' ),
				'FK' => _( 'Falkland Islands (Malvinas)' ),
				'FO' => _( 'Faroe Islands' ),
				'FJ' => _( 'Fiji' ),
				'FI' => _( 'Finland' ),
				'FR' => _( 'France' ),
				'GF' => _( 'French Guiana' ),
				'PF' => _( 'French Polynesia' ),
				'TF' => _( 'French Southern Territories' ),
				'GA' => _( 'Gabon' ),
				'GM' => _( 'Gambia' ),
				'GE' => _( 'Georgia' ),
				'DE' => _( 'Germany' ),
				'GH' => _( 'Ghana' ),
				'GI' => _( 'Gibraltar' ),
				'GR' => _( 'Greece' ),
				'GL' => _( 'Greenland' ),
				'GD' => _( 'Grenada' ),
				'GP' => _( 'Guadeloupe' ),
				'GU' => _( 'Guam' ),
				'GT' => _( 'Guatemala' ),
				'GG' => _( 'Guernsey' ),
				'GN' => _( 'Guinea' ),
				'GW' => _( 'Guinea-Bissau' ),
				'GY' => _( 'Guyana' ),
				'HT' => _( 'Haiti' ),
				'HM' => _( 'Heard Island and Mcdonald Islands' ),
				'VA' => _( 'Holy See (Vatican City State)' ),
				'HN' => _( 'Honduras' ),
				'HK' => _( 'Hong Kong' ),
				'HU' => _( 'Hungary' ),
				'IS' => _( 'Iceland' ),
				'IN' => _( 'India' ),
				'ID' => _( 'Indonesia' ),
				'IR' => _( 'Iran, Islamic Republic Of' ),
				'IQ' => _( 'Iraq' ),
				'IE' => _( 'Ireland' ),
				'IM' => _( 'Isle of Man' ),
				'IL' => _( 'Israel' ),
				'IT' => _( 'Italy' ),
				'JM' => _( 'Jamaica' ),
				'JP' => _( 'Japan' ),
				'JE' => _( 'Jersey' ),
				'JO' => _( 'Jordan' ),
				'KZ' => _( 'Kazakhstan' ),
				'KE' => _( 'Kenya' ),
				'KI' => _( 'Kiribati' ),
				'KP' => _( 'Korea, Democratic People\'S Republic of' ),
				'KR' => _( 'Korea, Republic of' ),
				'KW' => _( 'Kuwait' ),
				'KG' => _( 'Kyrgyzstan' ),
				'LA' => _( 'Lao People\'S Democratic Republic' ),
				'LV' => _( 'Latvia' ),
				'LB' => _( 'Lebanon' ),
				'LS' => _( 'Lesotho' ),
				'LR' => _( 'Liberia' ),
				'LY' => _( 'Libyan Arab Jamahiriya' ),
				'LI' => _( 'Liechtenstein' ),
				'LT' => _( 'Lithuania' ),
				'LU' => _( 'Luxembourg' ),
				'MO' => _( 'Macao' ),
				'MK' => _( 'Macedonia, The Former Yugoslav Republic of' ),
				'MG' => _( 'Madagascar' ),
				'MW' => _( 'Malawi' ),
				'MY' => _( 'Malaysia' ),
				'MV' => _( 'Maldives' ),
				'ML' => _( 'Mali' ),
				'MT' => _( 'Malta' ),
				'MH' => _( 'Marshall Islands' ),
				'MQ' => _( 'Martinique' ),
				'MR' => _( 'Mauritania' ),
				'MU' => _( 'Mauritius' ),
				'YT' => _( 'Mayotte' ),
				'MX' => _( 'Mexico' ),
				'FM' => _( 'Micronesia, Federated States of' ),
				'MD' => _( 'Moldova, Republic of' ),
				'MC' => _( 'Monaco' ),
				'MN' => _( 'Mongolia' ),
				'MS' => _( 'Montserrat' ),
				'MA' => _( 'Morocco' ),
				'MZ' => _( 'Mozambique' ),
				'MM' => _( 'Myanmar' ),
				'NA' => _( 'Namibia' ),
				'NR' => _( 'Nauru' ),
				'NP' => _( 'Nepal' ),
				'NL' => _( 'Netherlands' ),
				'AN' => _( 'Netherlands Antilles' ),
				'NC' => _( 'New Caledonia' ),
				'NZ' => _( 'New Zealand' ),
				'NI' => _( 'Nicaragua' ),
				'NE' => _( 'Niger' ),
				'NG' => _( 'Nigeria' ),
				'NU' => _( 'Niue' ),
				'NF' => _( 'Norfolk Island' ),
				'MP' => _( 'Northern Mariana Islands' ),
				'NO' => _( 'Norway' ),
				'OM' => _( 'Oman' ),
				'PK' => _( 'Pakistan' ),
				'PW' => _( 'Palau' ),
				'PS' => _( 'Palestinian Territory, Occupied' ),
				'PA' => _( 'Panama' ),
				'PG' => _( 'Papua New Guinea' ),
				'PY' => _( 'Paraguay' ),
				'PE' => _( 'Peru' ),
				'PH' => _( 'Philippines' ),
				'PN' => _( 'Pitcairn' ),
				'PL' => _( 'Poland' ),
				'PT' => _( 'Portugal' ),
				'PR' => _( 'Puerto Rico' ),
				'QA' => _( 'Qatar' ),
				'RE' => _( 'Reunion' ),
				'RO' => _( 'Romania' ),
				'RU' => _( 'Russian Federation' ),
				'RW' => _( 'RWANDA' ),
				'SH' => _( 'Saint Helena' ),
				'KN' => _( 'Saint Kitts and Nevis' ),
				'LC' => _( 'Saint Lucia' ),
				'PM' => _( 'Saint Pierre and Miquelon' ),
				'VC' => _( 'Saint Vincent and the Grenadines' ),
				'WS' => _( 'Samoa' ),
				'SM' => _( 'San Marino' ),
				'ST' => _( 'Sao Tome and Principe' ),
				'SA' => _( 'Saudi Arabia' ),
				'SN' => _( 'Senegal' ),
				'CS' => _( 'Serbia and Montenegro' ),
				'SC' => _( 'Seychelles' ),
				'SL' => _( 'Sierra Leone' ),
				'SG' => _( 'Singapore' ),
				'SK' => _( 'Slovakia' ),
				'SI' => _( 'Slovenia' ),
				'SB' => _( 'Solomon Islands' ),
				'SO' => _( 'Somalia' ),
				'ZA' => _( 'South Africa' ),
				'GS' => _( 'South Georgia and the South Sandwich Islands' ),
				'ES' => _( 'Spain' ),
				'LK' => _( 'Sri Lanka' ),
				'SD' => _( 'Sudan' ),
				'SR' => _( 'Suriname' ),
				'SJ' => _( 'Svalbard and Jan Mayen' ),
				'SZ' => _( 'Swaziland' ),
				'SE' => _( 'Sweden' ),
				'CH' => _( 'Switzerland' ),
				'SY' => _( 'Syrian Arab Republic' ),
				'TW' => _( 'Taiwan, Province of China' ),
				'TJ' => _( 'Tajikistan' ),
				'TZ' => _( 'Tanzania, United Republic of' ),
				'TH' => _( 'Thailand' ),
				'TL' => _( 'Timor-Leste' ),
				'TG' => _( 'Togo' ),
				'TK' => _( 'Tokelau' ),
				'TO' => _( 'Tonga' ),
				'TT' => _( 'Trinidad and Tobago' ),
				'TN' => _( 'Tunisia' ),
				'TR' => _( 'Turkey' ),
				'TM' => _( 'Turkmenistan' ),
				'TC' => _( 'Turks and Caicos Islands' ),
				'TV' => _( 'Tuvalu' ),
				'UG' => _( 'Uganda' ),
				'UA' => _( 'Ukraine' ),
				'AE' => _( 'United Arab Emirates' ),
				'GB' => _( 'United Kingdom' ),
				'US' => _( 'United States' ),
				'UM' => _( 'United States Minor Outlying Islands' ),
				'UY' => _( 'Uruguay' ),
				'UZ' => _( 'Uzbekistan' ),
				'VU' => _( 'Vanuatu' ),
				'VE' => _( 'Venezuela' ),
				'VN' => _( 'Viet Nam' ),
				'VG' => _( 'Virgin Islands, British' ),
				'VI' => _( 'Virgin Islands, U.S.' ),
				'WF' => _( 'Wallis and Futuna' ),
				'EH' => _( 'Western Sahara' ),
				'YE' => _( 'Yemen' ),
				'ZM' => _( 'Zambia' ),
				'ZW' => _( 'Zimbabwe' ),
			];
			
			// @formatter => on
			return ( $code === null ) ? $cc : [ $cc[ strtoupper( $code ) ] ];
		}
		
		
		public static function get_locales( $locale = null, $long = true )
		: array {
			// @formatter => off
			$langs = [
				'af_NA'       => 'Afrikaans (Namibia)',
				'af_ZA'       => 'Afrikaans (South Africa)',
				'af'          => 'Afrikaans',
				'ak_GH'       => 'Akan (Ghana)',
				'ak'          => 'Akan',
				'sq_AL'       => 'Albanian (Albania)',
				'sq'          => 'Albanian',
				'am_ET'       => 'Amharic (Ethiopia)',
				'am'          => 'Amharic',
				'ar_DZ'       => 'Arabic (Algeria)',
				'ar_BH'       => 'Arabic (Bahrain)',
				'ar_EG'       => 'Arabic (Egypt)',
				'ar_IQ'       => 'Arabic (Iraq)',
				'ar_JO'       => 'Arabic (Jordan)',
				'ar_KW'       => 'Arabic (Kuwait)',
				'ar_LB'       => 'Arabic (Lebanon)',
				'ar_LY'       => 'Arabic (Libya)',
				'ar_MA'       => 'Arabic (Morocco)',
				'ar_OM'       => 'Arabic (Oman)',
				'ar_QA'       => 'Arabic (Qatar)',
				'ar_SA'       => 'Arabic (Saudi Arabia)',
				'ar_SD'       => 'Arabic (Sudan)',
				'ar_SY'       => 'Arabic (Syria)',
				'ar_TN'       => 'Arabic (Tunisia)',
				'ar_AE'       => 'Arabic (United Arab Emirates)',
				'ar_YE'       => 'Arabic (Yemen)',
				'ar'          => 'Arabic',
				'hy_AM'       => 'Armenian (Armenia)',
				'hy'          => 'Armenian',
				'as_IN'       => 'Assamese (India)',
				'as'          => 'Assamese',
				'asa_TZ'      => 'Asu (Tanzania)',
				'asa'         => 'Asu',
				'az_Cyrl'     => 'Azerbaijani (Cyrillic)',
				'az_Cyrl_AZ'  => 'Azerbaijani (Cyrillic, Azerbaijan)',
				'az_Latn'     => 'Azerbaijani (Latin)',
				'az_Latn_AZ'  => 'Azerbaijani (Latin, Azerbaijan)',
				'az'          => 'Azerbaijani',
				'bm_ML'       => 'Bambara (Mali)',
				'bm'          => 'Bambara',
				'eu_ES'       => 'Basque (Spain)',
				'eu'          => 'Basque',
				'be_BY'       => 'Belarusian (Belarus)',
				'be'          => 'Belarusian',
				'bem_ZM'      => 'Bemba (Zambia)',
				'bem'         => 'Bemba',
				'bez_TZ'      => 'Bena (Tanzania)',
				'bez'         => 'Bena',
				'bn_BD'       => 'Bengali (Bangladesh)',
				'bn_IN'       => 'Bengali (India)',
				'bn'          => 'Bengali',
				'bs_BA'       => 'Bosnian (Bosnia and Herzegovina)',
				'bs'          => 'Bosnian',
				'bg_BG'       => 'Bulgarian (Bulgaria)',
				'bg'          => 'Bulgarian',
				'my_MM'       => 'Burmese (Myanmar [Burma])',
				'my'          => 'Burmese',
				'yue_Hant_HK' => 'Cantonese (Traditional, Hong Kong SAR China)',
				'ca_ES'       => 'Catalan (Spain)',
				'ca'          => 'Catalan',
				'zm_Latn'     => 'Central Morocco Tamazight (Latin)',
				'zm_Latn_MA'  => 'Central Morocco Tamazight (Latin, Morocco)',
				'tzm'         => 'Central Morocco Tamazight',
				'chr_US'      => 'Cherokee (United States)',
				'chr'         => 'Cherokee',
				'cgg_UG'      => 'Chiga (Uganda)',
				'cgg'         => 'Chiga',
				'zh_Hans'     => 'Chinese (Simplified Han)',
				'zh_Hans_CN'  => 'Chinese (Simplified Han, China)',
				'zh_Hans_HK'  => 'Chinese (Simplified Han, Hong Kong SAR China)',
				'zh_Hans_MO'  => 'Chinese (Simplified Han, Macau SAR China)',
				'zh_Hans_SG'  => 'Chinese (Simplified Han, Singapore)',
				'zh_Hant'     => 'Chinese (Traditional Han)',
				'zh_Hant_HK'  => 'Chinese (Traditional Han, Hong Kong SAR China)',
				'zh_Hant_MO'  => 'Chinese (Traditional Han, Macau SAR China)',
				'zh_Hant_TW'  => 'Chinese (Traditional Han, Taiwan)',
				'zh'          => 'Chinese',
				'kw_GB'       => 'Cornish (United Kingdom)',
				'kw'          => 'Cornish',
				'hr_HR'       => 'Croatian (Croatia)',
				'hr'          => 'Croatian',
				'cs_CZ'       => 'Czech (Czech Republic)',
				'cs'          => 'Czech',
				'da_DK'       => 'Danish (Denmark)',
				'da'          => 'Danish',
				'nl_BE'       => 'Dutch (Belgium)',
				'nl_NL'       => 'Dutch (Netherlands)',
				'nl'          => 'Dutch',
				'ebu_KE'      => 'Embu (Kenya)',
				'ebu'         => 'Embu',
				'en_AS'       => 'English (American Samoa)',
				'en_AU'       => 'English (Australia)',
				'en_BE'       => 'English (Belgium)',
				'en_BZ'       => 'English (Belize)',
				'en_BW'       => 'English (Botswana)',
				'en_CA'       => 'English (Canada)',
				'en_GU'       => 'English (Guam)',
				'en_HK'       => 'English (Hong Kong SAR China)',
				'en_IN'       => 'English (India)',
				'en_IE'       => 'English (Ireland)',
				'en_IL'       => 'English (Israel)',
				'en_JM'       => 'English (Jamaica)',
				'en_MT'       => 'English (Malta)',
				'en_MH'       => 'English (Marshall Islands)',
				'en_MU'       => 'English (Mauritius)',
				'en_NA'       => 'English (Namibia)',
				'en_NZ'       => 'English (New Zealand)',
				'en_MP'       => 'English (Northern Mariana Islands)',
				'en_PK'       => 'English (Pakistan)',
				'en_PH'       => 'English (Philippines)',
				'en_SG'       => 'English (Singapore)',
				'en_ZA'       => 'English (South Africa)',
				'en_TT'       => 'English (Trinidad and Tobago)',
				'en_UM'       => 'English (U.S. Minor Outlying Islands)',
				'en_VI'       => 'English (U.S. Virgin Islands)',
				'en_GB'       => 'English (United Kingdom)',
				'en_US'       => 'English (United States)',
				'en_ZW'       => 'English (Zimbabwe)',
				'en'          => 'English',
				'eo'          => 'Esperanto',
				'et_EE'       => 'Estonian (Estonia)',
				'et'          => 'Estonian',
				'ee_GH'       => 'Ewe (Ghana)',
				'ee_TG'       => 'Ewe (Togo)',
				'ee'          => 'Ewe',
				'fo_FO'       => 'Faroese (Faroe Islands)',
				'fo'          => 'Faroese',
				'fil_PH'      => 'Filipino (Philippines)',
				'fil'         => 'Filipino',
				'fi_FI'       => 'Finnish (Finland)',
				'fi'          => 'Finnish',
				'fr_BE'       => 'French (Belgium)',
				'fr_BJ'       => 'French (Benin)',
				'fr_BF'       => 'French (Burkina Faso)',
				'fr_BI'       => 'French (Burundi)',
				'fr_CM'       => 'French (Cameroon)',
				'fr_CA'       => 'French (Canada)',
				'fr_CF'       => 'French (Central African Republic)',
				'fr_TD'       => 'French (Chad)',
				'fr_KM'       => 'French (Comoros)',
				'fr_CG'       => 'French (Congo - Brazzaville)',
				'fr_CD'       => 'French (Congo - Kinshasa)',
				'fr_CI'       => 'French (Côte d’Ivoire)',
				'fr_DJ'       => 'French (Djibouti)',
				'fr_GQ'       => 'French (Equatorial Guinea)',
				'fr_FR'       => 'French (France)',
				'fr_GA'       => 'French (Gabon)',
				'fr_GP'       => 'French (Guadeloupe)',
				'fr_GN'       => 'French (Guinea)',
				'fr_LU'       => 'French (Luxembourg)',
				'fr_MG'       => 'French (Madagascar)',
				'fr_ML'       => 'French (Mali)',
				'fr_MQ'       => 'French (Martinique)',
				'fr_MC'       => 'French (Monaco)',
				'fr_NE'       => 'French (Niger)',
				'fr_RW'       => 'French (Rwanda)',
				'fr_RE'       => 'French (Réunion)',
				'fr_BL'       => 'French (Saint Barthélemy)',
				'fr_MF'       => 'French (Saint Martin)',
				'fr_SN'       => 'French (Senegal)',
				'fr_CH'       => 'French (Switzerland)',
				'fr_TG'       => 'French (Togo)',
				'fr'          => 'Français',
				'ff_SN'       => 'Fulah (Senegal)',
				'ff'          => 'Fulah',
				'gl_ES'       => 'Galician (Spain)',
				'gl'          => 'Galician',
				'lg_UG'       => 'Ganda (Uganda)',
				'lg'          => 'Ganda',
				'ka_GE'       => 'Georgian (Georgia)',
				'ka'          => 'Georgian',
				'de_AT'       => 'German (Austria)',
				'de_BE'       => 'German (Belgium)',
				'de_DE'       => 'German (Germany)',
				'de_LI'       => 'German (Liechtenstein)',
				'de_LU'       => 'German (Luxembourg)',
				'de_CH'       => 'German (Switzerland)',
				'de'          => 'German',
				'el_CY'       => 'Greek (Cyprus)',
				'el_GR'       => 'Greek (Greece)',
				'el'          => 'Greek',
				'gu_IN'       => 'Gujarati (India)',
				'gu'          => 'Gujarati',
				'guz_KE'      => 'Gusii (Kenya)',
				'guz'         => 'Gusii',
				'ha_Latn'     => 'Hausa (Latin)',
				'ha_Latn_GH'  => 'Hausa (Latin, Ghana)',
				'ha_Latn_NE'  => 'Hausa (Latin, Niger)',
				'ha_Latn_NG'  => 'Hausa (Latin, Nigeria)',
				'ha'          => 'Hausa',
				'haw_US'      => 'Hawaiian (United States)',
				'haw'         => 'Hawaiian',
				'he_IL'       => 'Hebrew (Israel)',
				'he'          => 'Hebrew',
				'hi_IN'       => 'Hindi (India)',
				'hi'          => 'Hindi',
				'hu_HU'       => 'Hungarian (Hungary)',
				'hu'          => 'Hungarian',
				'is_IS'       => 'Icelandic (Iceland)',
				'is'          => 'Icelandic',
				'ig_NG'       => 'Igbo (Nigeria)',
				'ig'          => 'Igbo',
				'id_ID'       => 'Indonesian (Indonesia)',
				'id'          => 'Indonesian',
				'ga_IE'       => 'Irish (Ireland)',
				'ga'          => 'Irish',
				'it_IT'       => 'Italian (Italy)',
				'it_CH'       => 'Italian (Switzerland)',
				'it'          => 'Italian',
				'ja_JP'       => 'Japanese (Japan)',
				'ja'          => 'Japanese',
				'kea_CV'      => 'Kabuverdianu (Cape Verde)',
				'kea'         => 'Kabuverdianu',
				'kab_DZ'      => 'Kabyle (Algeria)',
				'kab'         => 'Kabyle',
				'kl_GL'       => 'Kalaallisut (Greenland)',
				'kl'          => 'Kalaallisut',
				'kln_KE'      => 'Kalenjin (Kenya)',
				'kln'         => 'Kalenjin',
				'kam_KE'      => 'Kamba (Kenya)',
				'kam'         => 'Kamba',
				'kn_IN'       => 'Kannada (India)',
				'kn'          => 'Kannada',
				'kk_Cyrl'     => 'Kazakh (Cyrillic)',
				'kk_Cyrl_KZ'  => 'Kazakh (Cyrillic, Kazakhstan)',
				'kk'          => 'Kazakh',
				'km_KH'       => 'Khmer (Cambodia)',
				'km'          => 'Khmer',
				'ki_KE'       => 'Kikuyu (Kenya)',
				'ki'          => 'Kikuyu',
				'rw_RW'       => 'Kinyarwanda (Rwanda)',
				'rw'          => 'Kinyarwanda',
				'kok_IN'      => 'Konkani (India)',
				'kok'         => 'Konkani',
				'ko_KR'       => 'Korean (South Korea)',
				'ko'          => 'Korean',
				'khq_ML'      => 'Koyra Chiini (Mali)',
				'khq'         => 'Koyra Chiini',
				'ses_ML'      => 'Koyraboro Senni (Mali)',
				'ses'         => 'Koyraboro Senni',
				'lag_TZ'      => 'Langi (Tanzania)',
				'lag'         => 'Langi',
				'lv_LV'       => 'Latvian (Latvia)',
				'lv'          => 'Latvian',
				'lt_LT'       => 'Lithuanian (Lithuania)',
				'lt'          => 'Lithuanian',
				'luo_KE'      => 'Luo (Kenya)',
				'luo'         => 'Luo',
				'luy_KE'      => 'Luyia (Kenya)',
				'luy'         => 'Luyia',
				'mk_MK'       => 'Macedonian (Macedonia)',
				'mk'          => 'Macedonian',
				'jmc_TZ'      => 'Machame (Tanzania)',
				'jmc'         => 'Machame',
				'kde_TZ'      => 'Makonde (Tanzania)',
				'kde'         => 'Makonde',
				'mg_MG'       => 'Malagasy (Madagascar)',
				'mg'          => 'Malagasy',
				'ms_BN'       => 'Malay (Brunei)',
				'ms_MY'       => 'Malay (Malaysia)',
				'ms'          => 'Malay',
				'ml_IN'       => 'Malayalam (India)',
				'ml'          => 'Malayalam',
				'mt_MT'       => 'Maltese (Malta)',
				'mt'          => 'Maltese',
				'gv_GB'       => 'Manx (United Kingdom)',
				'gv'          => 'Manx',
				'mr_IN'       => 'Marathi (India)',
				'mr'          => 'Marathi',
				'mas_KE'      => 'Masai (Kenya)',
				'mas_TZ'      => 'Masai (Tanzania)',
				'mas'         => 'Masai',
				'mer_KE'      => 'Meru (Kenya)',
				'mer'         => 'Meru',
				'mfe_MU'      => 'Morisyen (Mauritius)',
				'mfe'         => 'Morisyen',
				'naq_NA'      => 'Nama (Namibia)',
				'naq'         => 'Nama',
				'ne_IN'       => 'Nepali (India)',
				'ne_NP'       => 'Nepali (Nepal)',
				'ne'          => 'Nepali',
				'nd_ZW'       => 'North Ndebele (Zimbabwe)',
				'nd'          => 'North Ndebele',
				'nb_NO'       => 'Norwegian Bokmål (Norway)',
				'nb'          => 'Norwegian Bokmål',
				'nn_NO'       => 'Norwegian Nynorsk (Norway)',
				'nn'          => 'Norwegian Nynorsk',
				'nyn_UG'      => 'Nyankole (Uganda)',
				'nyn'         => 'Nyankole',
				'or_IN'       => 'Oriya (India)',
				'or'          => 'Oriya',
				'om_ET'       => 'Oromo (Ethiopia)',
				'om_KE'       => 'Oromo (Kenya)',
				'om'          => 'Oromo',
				'ps_AF'       => 'Pashto (Afghanistan)',
				'ps'          => 'Pashto',
				'fa_AF'       => 'Persian (Afghanistan)',
				'fa_IR'       => 'Persian (Iran)',
				'fa'          => 'Persian',
				'pl_PL'       => 'Polish (Poland)',
				'pl'          => 'Polish',
				'pt_BR'       => 'Portuguese (Brazil)',
				'pt_GW'       => 'Portuguese (Guinea-Bissau)',
				'pt_MZ'       => 'Portuguese (Mozambique)',
				'pt_PT'       => 'Portuguese (Portugal)',
				'pt'          => 'Portuguese',
				'pa_Arab'     => 'Punjabi (Arabic)',
				'pa_Arab_PK'  => 'Punjabi (Arabic, Pakistan)',
				'pa_Guru'     => 'Punjabi (Gurmukhi)',
				'pa_Guru_IN'  => 'Punjabi (Gurmukhi, India)',
				'pa'          => 'Punjabi',
				'ro_MD'       => 'Romanian (Moldova)',
				'ro_RO'       => 'Romanian (Romania)',
				'ro'          => 'Romanian',
				'rm_CH'       => 'Romansh (Switzerland)',
				'rm'          => 'Romansh',
				'rof_TZ'      => 'Rombo (Tanzania)',
				'rof'         => 'Rombo',
				'ru_MD'       => 'Russian (Moldova)',
				'ru_RU'       => 'Russian (Russia)',
				'ru_UA'       => 'Russian (Ukraine)',
				'ru'          => 'Russian',
				'rwk_TZ'      => 'Rwa (Tanzania)',
				'rwk'         => 'Rwa',
				'saq_KE'      => 'Samburu (Kenya)',
				'saq'         => 'Samburu',
				'sg_CF'       => 'Sango (Central African Republic)',
				'sg'          => 'Sango',
				'seh_MZ'      => 'Sena (Mozambique)',
				'seh'         => 'Sena',
				'sr_Cyrl'     => 'Serbian (Cyrillic)',
				'sr_Cyrl_BA'  => 'Serbian (Cyrillic, Bosnia and Herzegovina)',
				'sr_Cyrl_ME'  => 'Serbian (Cyrillic, Montenegro)',
				'sr_Cyrl_RS'  => 'Serbian (Cyrillic, Serbia)',
				'sr_Latn'     => 'Serbian (Latin)',
				'sr_Latn_BA'  => 'Serbian (Latin, Bosnia and Herzegovina)',
				'sr_Latn_ME'  => 'Serbian (Latin, Montenegro)',
				'sr_Latn_RS'  => 'Serbian (Latin, Serbia)',
				'sr'          => 'Serbian',
				'sn_ZW'       => 'Shona (Zimbabwe)',
				'sn'          => 'Shona',
				'ii_CN'       => 'Sichuan Yi (China)',
				'ii'          => 'Sichuan Yi',
				'si_LK'       => 'Sinhala (Sri Lanka)',
				'si'          => 'Sinhala',
				'sk_SK'       => 'Slovak (Slovakia)',
				'sk'          => 'Slovak',
				'sl_SI'       => 'Slovenian (Slovenia)',
				'sl'          => 'Slovenian',
				'xog_UG'      => 'Soga (Uganda)',
				'xog'         => 'Soga',
				'so_DJ'       => 'Somali (Djibouti)',
				'so_ET'       => 'Somali (Ethiopia)',
				'so_KE'       => 'Somali (Kenya)',
				'so_SO'       => 'Somali (Somalia)',
				'so'          => 'Somali',
				'es_AR'       => 'Spanish (Argentina)',
				'es_BO'       => 'Spanish (Bolivia)',
				'es_CL'       => 'Spanish (Chile)',
				'es_CO'       => 'Spanish (Colombia)',
				'es_CR'       => 'Spanish (Costa Rica)',
				'es_DO'       => 'Spanish (Dominican Republic)',
				'es_EC'       => 'Spanish (Ecuador)',
				'es_SV'       => 'Spanish (El Salvador)',
				'es_GQ'       => 'Spanish (Equatorial Guinea)',
				'es_GT'       => 'Spanish (Guatemala)',
				'es_HN'       => 'Spanish (Honduras)',
				'es_419'      => 'Spanish (Latin America)',
				'es_MX'       => 'Spanish (Mexico)',
				'es_NI'       => 'Spanish (Nicaragua)',
				'es_PA'       => 'Spanish (Panama)',
				'es_PY'       => 'Spanish (Paraguay)',
				'es_PE'       => 'Spanish (Peru)',
				'es_PR'       => 'Spanish (Puerto Rico)',
				'es_ES'       => 'Spanish (Spain)',
				'es_US'       => 'Spanish (United States)',
				'es_UY'       => 'Spanish (Uruguay)',
				'es_VE'       => 'Spanish (Venezuela)',
				'es'          => 'Spanish',
				'sw_KE'       => 'Swahili (Kenya)',
				'sw_TZ'       => 'Swahili (Tanzania)',
				'sw'          => 'Swahili',
				'sv_FI'       => 'Swedish (Finland)',
				'sv_SE'       => 'Swedish (Sweden)',
				'sv'          => 'Swedish',
				'gsw_CH'      => 'Swiss German (Switzerland)',
				'gsw'         => 'Swiss German',
				'shi_Latn'    => 'Tachelhit (Latin)',
				'shi_Latn_MA' => 'Tachelhit (Latin, Morocco)',
				'shi_Tfng'    => 'Tachelhit (Tifinagh)',
				'shi_Tfng_MA' => 'Tachelhit (Tifinagh, Morocco)',
				'shi'         => 'Tachelhit',
				'dav_KE'      => 'Taita (Kenya)',
				'dav'         => 'Taita',
				'ta_IN'       => 'Tamil (India)',
				'ta_LK'       => 'Tamil (Sri Lanka)',
				'ta'          => 'Tamil',
				'te_IN'       => 'Telugu (India)',
				'te'          => 'Telugu',
				'teo_KE'      => 'Teso (Kenya)',
				'teo_UG'      => 'Teso (Uganda)',
				'teo'         => 'Teso',
				'th_TH'       => 'Thai (Thailand)',
				'th'          => 'Thai',
				'bo_CN'       => 'Tibetan (China)',
				'bo_IN'       => 'Tibetan (India)',
				'bo'          => 'Tibetan',
				'ti_ER'       => 'Tigrinya (Eritrea)',
				'ti_ET'       => 'Tigrinya (Ethiopia)',
				'ti'          => 'Tigrinya',
				'to_TO'       => 'Tonga (Tonga)',
				'to'          => 'Tonga',
				'tr_TR'       => 'Turkish (Turkey)',
				'tr'          => 'Turkish',
				'uk_UA'       => 'Ukrainian (Ukraine)',
				'uk'          => 'Ukrainian',
				'ur_IN'       => 'Urdu (India)',
				'ur_PK'       => 'Urdu (Pakistan)',
				'ur'          => 'Urdu',
				'uz_Arab'     => 'Uzbek (Arabic)',
				'uz_Arab_AF'  => 'Uzbek (Arabic, Afghanistan)',
				'uz_Cyrl'     => 'Uzbek (Cyrillic)',
				'uz_Cyrl_UZ'  => 'Uzbek (Cyrillic, Uzbekistan)',
				'uz_Latn'     => 'Uzbek (Latin)',
				'uz_Latn_UZ'  => 'Uzbek (Latin, Uzbekistan)',
				'uz'          => 'Uzbek',
				'vi_VN'       => 'Vietnamese (Vietnam)',
				'vi'          => 'Vietnamese',
				'vun_TZ'      => 'Vunjo (Tanzania)',
				'vun'         => 'Vunjo',
				'cy_GB'       => 'Welsh (United Kingdom)',
				'cy'          => 'Welsh',
				'yo_NG'       => 'Yoruba (Nigeria)',
				'yo'          => 'Yoruba',
				'zu_ZA'       => 'Zulu (South Africa)',
				'zu'          => 'Zulu',
			];
			
			// @formatter => on
			if ($locale !== null && !$long) {
				$locale = explode('_',$locale)[0];
			}
			return ( $locale === null ) ? $langs : [ $locale => $langs[ $locale ] ?? null ];
			
		}
		
		public static function split_locale( $locale )
		: array {
			return explode( '_', $locale );
		}
	}