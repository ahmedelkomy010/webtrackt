export const baseContact = {
    phone: '0502943846',
    phoneIntl: '+966 50 294 3846',
    whatsapp: '966502943846',
    email: 'info@trakkt.com',
};

export const countries = {
    sa: {
        code: 'sa',
        flag: '🇸🇦',
        currency: { code: 'SAR', symbol: 'ر.س' },
        location: { ar: 'المملكة العربية السعودية', en: 'Saudi Arabia', ur: 'سعودی عرب' },
        phone: baseContact.phoneIntl,
        whatsapp: baseContact.whatsapp,
        email: baseContact.email,
        phonePlaceholder: { ar: '05xxxxxxxx', en: '05xxxxxxxx', ur: '05xxxxxxxx' },
    },
    ae: {
        code: 'ae',
        flag: '🇦🇪',
        currency: { code: 'AED', symbol: 'د.إ' },
        location: { ar: 'الإمارات العربية المتحدة', en: 'United Arab Emirates', ur: 'متحدہ عرب امارات' },
        phone: baseContact.phoneIntl,
        whatsapp: baseContact.whatsapp,
        email: baseContact.email,
        phonePlaceholder: { ar: '05xxxxxxxx', en: '05xxxxxxxx', ur: '05xxxxxxxx' },
    },
    kw: {
        code: 'kw',
        flag: '🇰🇼',
        currency: { code: 'KWD', symbol: 'د.ك' },
        location: { ar: 'دولة الكويت', en: 'Kuwait', ur: 'کویت' },
        phone: baseContact.phoneIntl,
        whatsapp: baseContact.whatsapp,
        email: baseContact.email,
        phonePlaceholder: { ar: '9xxxxxxx', en: '9xxxxxxx', ur: '9xxxxxxx' },
    },
    bh: {
        code: 'bh',
        flag: '🇧🇭',
        currency: { code: 'BHD', symbol: 'د.ب' },
        location: { ar: 'مملكة البحرين', en: 'Bahrain', ur: 'بحرین' },
        phone: baseContact.phoneIntl,
        whatsapp: baseContact.whatsapp,
        email: baseContact.email,
        phonePlaceholder: { ar: '3xxxxxxx', en: '3xxxxxxx', ur: '3xxxxxxx' },
    },
    om: {
        code: 'om',
        flag: '🇴🇲',
        currency: { code: 'OMR', symbol: 'ر.ع' },
        location: { ar: 'سلطنة عُمان', en: 'Oman', ur: 'عمان' },
        phone: baseContact.phoneIntl,
        whatsapp: baseContact.whatsapp,
        email: baseContact.email,
        phonePlaceholder: { ar: '9xxxxxxx', en: '9xxxxxxx', ur: '9xxxxxxx' },
    },
    qa: {
        code: 'qa',
        flag: '🇶🇦',
        currency: { code: 'QAR', symbol: 'ر.ق' },
        location: { ar: 'دولة قطر', en: 'Qatar', ur: 'قطر' },
        phone: baseContact.phoneIntl,
        whatsapp: baseContact.whatsapp,
        email: baseContact.email,
        phonePlaceholder: { ar: '3xxxxxxx', en: '3xxxxxxx', ur: '3xxxxxxx' },
    },
    eg: {
        code: 'eg',
        flag: '🇪🇬',
        currency: { code: 'EGP', symbol: 'ج.م' },
        location: { ar: 'جمهورية مصر العربية', en: 'Egypt', ur: 'مصر' },
        phone: baseContact.phoneIntl,
        whatsapp: baseContact.whatsapp,
        email: baseContact.email,
        phonePlaceholder: { ar: '01xxxxxxxxx', en: '01xxxxxxxxx', ur: '01xxxxxxxxx' },
    },
};

export const countryList = Object.values(countries);

export const defaultCountry = 'sa';
