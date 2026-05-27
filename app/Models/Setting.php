<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'label', 'description'];

    private static array $cache = [];

    public static function get(string $key, mixed $default = null): mixed
    {
        if (!isset(static::$cache[$key])) {
            static::$cache[$key] = static::where('key', $key)->value('value');
        }
        return static::$cache[$key] ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        static::$cache[$key] = $value; 
    }

    public static function clearCache(): void
    {
        static::$cache = [];
    }

    public static function thresholdDue(): \Carbon\Carbon
    {
        return now()->subHours((int) static::get('threshold_due_hours', 24));
    }

    public static function thresholdOverdue(): \Carbon\Carbon
    {
        return now()->subHours((int) static::get('threshold_overdue_hours', 72));
    }

    public static function dueHours(): int
    {
        return (int) static::get('threshold_due_hours', 24);
    }

 
    public static function overdueHours(): int
    {
        return (int) static::get('threshold_overdue_hours', 72);
    }
    public static function colorDue(): string
{
    return static::get('color_due', '#f97316');
}

public static function colorOverdue(): string
{
    return static::get('color_overdue', '#ef4444'); 
}
}