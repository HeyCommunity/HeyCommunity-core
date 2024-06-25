<?php

namespace Modules\Activity\Entities;

use App\Casts\Assert;
use App\Models\Model;
use App\Models\User;
use Modules\Activity\Database\factories\ActivityFactory;

class Activity extends Model
{
    /**
     * Statuses
     */
    public static $statuses = [
        0       =>  '待审核',
        1       =>  '已发布',
        2       =>  '已下架',
    ];

    /**
     * casts
     */
    protected $casts = [
        'cover'         =>  Assert::class,
        'started_at'    =>  'datetime',
        'ended_at'      =>  'datetime',
    ];

    /**
     * newFactory
     */
    protected static function newFactory()
    {
        return ActivityFactory::new();
    }

    /**
     * 关联 ActivityMember
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'activity_members')->where('activity_members.status', 1);
    }

    /**
     * 已报名人数 Attr
     */
    public function getMemberNumAttribute()
    {
        return $this->members()->count();
    }
}
