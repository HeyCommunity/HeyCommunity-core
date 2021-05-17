<?php

namespace App\Models\Common;

use App\Models\Model;

class Read extends Model
{
    /**
     * Related EntityModel
     */
    public function entity()
    {
        return $this->belongsTo($this->entity_class, 'entity_id')->withTrashed();
    }
}
