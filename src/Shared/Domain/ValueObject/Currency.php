<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

use Utils\Enum\EnumTrait;

enum Currency: string
{
    use EnumTrait;

    case AED = 'UAE Dirham';
    case AFN = 'Afghani';
    case ALL = 'Lek';
    case AMD = 'Armenian Dram';
    case ANG = 'Netherlands Antillean Guilder';
    case AOA = 'Kwanza';
    case ARS = 'Argentine Peso';
    case AUD = 'Australian Dollar';
    case AWG = 'Aruban Florin';
    case AZN = 'Azerbaijan Manat';
    case BAM = 'Convertible Mark';
    case BBD = 'Barbados Dollar';
    case BDT = 'Taka';
    case BGN = 'Bulgarian Lev';
    case BHD = 'Bahraini Dinar';
    case BIF = 'Burundi Franc';
    case BMD = 'Bermudian Dollar';
    case BND = 'BruneisDollar';
    case BOB = 'Boliviano';
    case BOV = 'Mvdol';
    case BRL = 'Brazilian Real';
    case BSD = 'Bahamian Dollar';
    case BTN = 'Ngultrum';
    case BWP = 'Pula';
    case BYN = 'Belarusian Ruble';
    case BZD = 'Belize Dollar';
    case CAD = 'Canadian Dollar';
    case CDF = 'Congolese Franc';
    case CHE = 'WIR Euro';
    case CHF = 'Swiss Franc';
    case CHW = 'WIR Franc';
    case CLF = 'Unidad de Fomento';
    case CLP = 'Chilean Peso';
    case CNY = 'Yuan Renminbi';
    case COP = 'Colombian Peso';
    case COU = 'Unidad de Valor Real';
    case CRC = 'Costa Rican Colon';
    case CUC = 'Peso Convertible';
    case CUP = 'Cuban Peso';
    case CVE = 'Cabo Verde Escudo';
    case CZK = 'Czech Koruna';
    case DJF = 'Djibouti Franc';
    case DKK = 'Danish Krone';
    case DOP = 'Dominican Peso';
    case DZD = 'Algerian Dinar';
    case EGP = 'Egyptian Pound';
    case ERN = 'Nakfa';
    case ETB = 'Ethiopian Birr';
    case EUR = 'Euro';
    case FJD = 'Fiji Dollar';
    case FKP = 'Falkland Islands Pound';
    case GBP = 'Pound Sterling';
    case GEL = 'Lari';
    case GHS = 'Ghana Cedi';
    case GIP = 'Gibraltar Pound';
    case GMD = 'Dalasi';
    case GNF = 'Guinean Franc';
    case GTQ = 'Quetzal';
    case GYD = 'Guyana Dollar';
    case HKD = 'Hong Kong Dollar';
    case HNL = 'Lempira';
    case HTG = 'Gourde';
    case HUF = 'Forint';
    case IDR = 'Rupiah';
    case ILS = 'New Israeli Sheqel';
    case INR = 'Indian Rupee';
    case IQD = 'Iraqi Dinar';
    case IRR = 'Iranian Rial';
    case ISK = 'Iceland Krona';
    case JMD = 'Jamaican Dollar';
    case JOD = 'Jordanian Dinar';
    case JPY = 'Yen';
    case KES = 'Kenyan Shilling';
    case KGS = 'Som';
    case KHR = 'Riel';
    case KMF = 'Comorian Franc';
    case KPW = 'North Korean Won';
    case KRW = 'Won';
    case KWD = 'Kuwaiti Dinar';
    case KYD = 'Cayman Islands Dollar';
    case KZT = 'Tenge';
    case LAK = 'Lao Kip';
    case LBP = 'Lebanese Pound';
    case LKR = 'Sri Lanka Rupee';
    case LRD = 'Liberian Dollar';
    case LSL = 'Loti';
    case LYD = 'Libyan Dinar';
    case MAD = 'Moroccan Dirham';
    case MDL = 'Moldovan Leu';
    case MGA = 'Malagasy Ariary';
    case MKD = 'Denar';
    case MMK = 'Kyat';
    case MNT = 'Tugrik';
    case MOP = 'Pataca';
    case MRU = 'Ouguiya';
    case MUR = 'Mauritius Rupee';
    case MVR = 'Rufiyaa';
    case MWK = 'Malawi Kwacha';
    case MXN = 'Mexican Peso';
    case MXV = 'Mexican Unidad de Inversion UDI';
    case MYR = 'Malaysian Ringgit';
    case MZN = 'Mozambique Metical';
    case NAD = 'Namibia Dollar';
    case NGN = 'Naira';
    case NIO = 'Cordoba Oro';
    case NOK = 'Norwegian Krone';
    case NPR = 'Nepalese Rupee';
    case NZD = 'New Zealand Dollar';
    case OMR = 'Rial Omani';
    case PAB = 'Balboa';
    case PEN = 'Sol';
    case PGK = 'Kina';
    case PHP = 'Philippine Peso';
    case PKR = 'Pakistan Rupee';
    case PLN = 'Zloty';
    case PYG = 'Guarani';
    case QAR = 'Qatari Rial';
    case RON = 'Romanian Leu';
    case RSD = 'Serbian Dinar';
    case RUB = 'Russian Ruble';
    case RWF = 'Rwanda Franc';
    case SAR = 'Saudi Riyal';
    case SBD = 'Solomon Islands Dollar';
    case SCR = 'Seychelles Rupee';
    case SDG = 'Sudanese Pound';
    case SEK = 'Swedish Krona';
    case SGD = 'Singapore Dollar';
    case SHP = 'Saint Helena Pound';
    case SLE = 'Leone';
    case SOS = 'Somali Shilling';
    case SRD = 'Surinam Dollar';
    case SSP = 'South Sudanese Pound';
    case STN = 'Dobra';
    case SVC = 'El Salvador Colon';
    case SYP = 'Syrian Pound';
    case SZL = 'Lilangeni';
    case TGP = 'Pa anga';
    case THB = 'Baht';
    case TJS = 'Somoni';
    case TMT = 'Turkmenistan New Manat';
    case TND = 'Tunisian Dinar';
    case TRY = 'Turkish Lira';
    case TTD = 'Trinidad and Tobago Dollar';
    case TWD = 'New Taiwan Dollar';
    case TZS = 'Tanzanian Shilling';
    case UAH = 'Hryvnia';
    case UGX = 'Uganda Shilling';
    case USD = 'US Dollar';
    case UYI = 'Uruguay Peso en Unidades Indexadas UI';
    case UYU = 'Peso Uruguayo';
    case UYW = 'Unidad Previsional';
    case UZS = 'Uzbekistan Sum';
    case VED = 'Bolivar Soberano';
    case VES = 'Bolivar Soberano Old';
    case VND = 'Dong';
    case VUV = 'Vatu';
    case WST = 'Tala';
    case XAF = 'CFA Franc BEAC';
    case XCD = 'East Caribbean Dollar';
    case XOF = 'CFA Franc BCEAO';
    case XPF = 'CFP Franc';
    case XSU = 'Sucre';
    case YER = 'Yemeni Rial';
    case ZAR = 'Rand';
    case ZMW = 'Zambian Kwacha';
    case ZWL = 'Zimbabwe Dollar';

    public function fraction(): int
    {
        return match ($this) {
            self::BIF,
            self::CLP,
            self::DJF,
            self::GNF,
            self::ISK,
            self::JPY,
            self::KMF,
            self::KRW,
            self::PYG,
            self::RWF,
            self::UGX,
            self::VUV,
            self::VND,
            self::XAF,
            self::XOF,
            self::XPF => 0,
            self::BHD,
            self::TND,
            self::LYD,
            self::OMR,
            self::KWD,
            self::JOD,
            self::IQD => 3,
            self::CLF,
            self::UYW => 4,
            default => 2,
        };
    }
}
