<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action_type',
        'entity_type',
        'entity_id',
        'description',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Get the user that performed the action
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Create a log entry
     */
    public static function log(
        int $userId,
        string $actionType,
        string $entityType,
        ?int $entityId,
        string $description,
        ?array $data = null
    ): void {
        self::create([
            'user_id' => $userId,
            'action_type' => $actionType,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'description' => $description,
            'data' => $data,
        ]);
    }

    /**
     * Get a formatted action type label
     */
    public function getActionLabel(): string
    {
        return match($this->action_type) {
            'create' => 'Kreirao',
            'update' => 'Ažurirao',
            'delete' => 'Obrisao',
            'replenish' => 'Dopunio',
            'set' => 'Postavio',
            default => ucfirst($this->action_type),
        };
    }

    /**
     * Get a formatted entity type label
     */
    public function getEntityLabel(): string
    {
        return match($this->entity_type) {
            'product' => 'Materijal',
            'work_order' => 'Radni Nalog',
            'invoice' => 'Fakturu',
            'inventory' => 'Zalihe',
            default => ucfirst($this->entity_type),
        };
    }
}
