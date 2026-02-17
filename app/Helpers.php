<?php

if (!function_exists('translate')) {
    /**
     * Get translated value from multilingual JSON field
     * 
     * @param array|string|null $value
     * @param string|null $locale
     * @return string
     */
    function translate($value, ?string $locale = null): string
    {
        if (is_string($value)) {
            return $value;
        }
        
        if (!is_array($value)) {
            return '';
        }
        
        $locale = $locale ?? app()->getLocale();
        
        return $value[$locale] ?? $value['en'] ?? $value['sr'] ?? '';
    }
}

if (!function_exists('current_locale')) {
    /**
     * Get current locale
     * 
     * @return string
     */
    function current_locale(): string
    {
        return app()->getLocale();
    }
}

if (!function_exists('change_locale_url')) {
    /**
     * Generate URL with different locale
     * 
     * @param string $locale
     * @return string
     */
    function change_locale_url(string $locale): string
    {
        return url()->current() . '?lang=' . $locale;
    }
}

if (!function_exists('number_to_words_serbian')) {
    /**
     * Convert number to words in Serbian
     * 
     * @param float|int $number
     * @return string
     */
    function number_to_words_serbian($number): string
    {
        $number = (int) $number;
        
        if ($number == 0) return 'nula';
        
        $ones = ['', 'jedan', 'dva', 'tri', 'četiri', 'pet', 'šest', 'sedam', 'osam', 'devet'];
        $teens = ['deset', 'jedanaest', 'dvanaest', 'trinaest', 'četrnaest', 'petnaest', 'šesnaest', 'sedamnaest', 'osamnaest', 'devetnaest'];
        $tens = ['', '', 'dvadeset', 'trideset', 'četrdeset', 'pedeset', 'šezdeset', 'sedamdeset', 'osamdeset', 'devedeset'];
        $hundreds = ['', 'sto', 'dvesto', 'tristo', 'četiristo', 'petsto', 'šeststo', 'sedamsto', 'osamsto', 'devetsto'];
        
        $words = '';
        
        // Milioni
        if ($number >= 1000000) {
            $millions = (int)($number / 1000000);
            if ($millions == 1) {
                $words .= 'milion';
            } else if ($millions < 5) {
                $words .= number_to_words_serbian($millions) . 'miliona';
            } else {
                $words .= number_to_words_serbian($millions) . 'miliona';
            }
            $number %= 1000000;
        }
        
        // Hiljade
        if ($number >= 1000) {
            $thousands = (int)($number / 1000);
            if ($thousands == 1) {
                $words .= 'hiljadu';
            } else if ($thousands < 5) {
                $words .= number_to_words_serbian($thousands) . 'hiljade';
            } else {
                $words .= number_to_words_serbian($thousands) . 'hiljada';
            }
            $number %= 1000;
        }
        
        // Stotine
        if ($number >= 100) {
            $words .= $hundreds[(int)($number / 100)] . ' ';
            $number %= 100;
        }
        
        // Deseci i jedinice
        if ($number >= 20) {
            $words .= $tens[(int)($number / 10)];
            $number %= 10;
            if ($number > 0) {
                $words .= ' ' . $ones[$number];
            }
        } else if ($number >= 10) {
            $words .= $teens[$number - 10];
        } else if ($number > 0) {
            $words .= $ones[$number];
        }
        
        return trim($words);
    }
}
