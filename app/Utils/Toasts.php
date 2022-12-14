<?php

namespace App\Utils;

class Toasts {
    private static function create_toast(string $type, string $category, string $message) {
        $message = __($message);
        if (is_array($message)) {
            $category = $message['category'] ?? __($category);
            $message = $message['message'];
        }

        $currentToasts = session()->get('toasts');
        if (is_array($currentToasts)) {
            $currentToasts = [];
        }

        $currentToasts[] = [
            'type' => $type,
            'category' => $category,
            'message' => $message,
        ];

        session()->flash('toasts', $currentToasts);
    }

    public static function success(string $message, string $category = 'Success') {
        static::create_toast('success', $category, $message);
    }

    public static function info(string $message, string $category = 'Info') {
        static::create_toast('info', $category, $message);
    }

    public static function warning(string $message, string $category = 'Warning') {
        static::create_toast('warning', $category, $message);
    }

    public static function danger(string $message, string $category = 'Danger') {
        static::create_toast('danger', $category, $message);
    }
}