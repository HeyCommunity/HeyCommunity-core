<?php

namespace App\Models;

use App\Models\Common\Comment;
use App\Models\Common\Thumb;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Model
 *
 * @property-read \App\Models\User|null $author
 * @property-read mixed $created_at_for_humans
 * @property-read mixed $has_thumb_up
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Model createdAtInToday()
 * @method static \Illuminate\Database\Eloquent\Builder|Model mine()
 * @method static \Illuminate\Database\Eloquent\Builder|Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model newQuery()
 * @method static \Illuminate\Database\Query\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model sortOrder()
 * @method static \Illuminate\Database\Query\Builder|Model withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Model withoutTrashed()
 * @mixin \Eloquent
 */
class Model extends EloquentModel
{
    use HasFactory;
    use SoftDeletes;

    protected $perPage = 10;

    // guarded
    protected $guarded = [];

    /**
     * 状态
     *
     * @var array
     */
    public static $statuses = [
    ];

    /**
     * 格式化时间
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        if (version_compare(app()->version(), '7.0.0') < 0) {
            return parent::serializeDate($date);
        }

        return $date->format(Carbon::DEFAULT_TO_STRING_FORMAT);
    }

    /**
     * Relation User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relation User
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getEntityTextForAdmin()
    {
        return class_basename($this->entity) . '(' . $this->id . ')';
    }

    /**
     * 关联 ThumbUp
     */
    public function upThumbs()
    {
        return $this->morphMany(Thumb::class, 'thumbable', 'entity_class', 'entity_id')->where('type', 'thumb_up');
    }

    /**
     * 关联 ThumbDown
     */
    public function downThumbs()
    {
        return $this->morphMany(Thumb::class, 'thumbable', 'entity_class', 'entity_id')->where('type', 'thumb_down');
    }

    /**
     * 关联 Thumb
     */
    public function thumbs()
    {
        return $this->morphMany(Thumb::class, 'thumbable', 'entity_class', 'entity_id');
    }

    /**
     * Related Comment
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable', 'entity_class', 'entity_id')->latest();
    }

    /**
     * Sort Order
     */
    public function scopeSortOrder($query)
    {
        return $query->orderBy('sort', 'asc')->oldest();
    }

    /**
     * Mine Scope
     */
    public function scopeMine($query)
    {
        return $query->where(['user_id' => Auth::id()]);
    }

    /**
     * CreatedAt In Today Scope
     */
    public function scopeCreatedAtInToday($query)
    {
        return $query->whereDate('created_at', '>=', Carbon::today()->startOfDay())
            ->whereDate('created_at', '<=', Carbon::today()->endOfDay());
    }

    /**
     * Get has thumb up
     */
    public function getHasThumbUpAttribute()
    {
        if (Auth::check()) {
            return Thumb::where([
                'user_id'       =>  Auth::id(),
                'entity_class'  =>  get_class($this),
                'entity_id'     =>  $this->id,
                'type'          =>  'thumb_up',
            ])->exists() ? 1 : 0;
        }

        return 0;
    }

    /**
     * 状态名称 Attr
     */
    public function getStatusNameAttribute()
    {
        return $this::$statuses[$this->getAttribute('status')] ?? '未知';
    }

    /**
     * Get created_at_for_humans attr
     */
    public function getCreatedAtForHumansAttribute()
    {
        if (now()->diffInDays($this->created_at) <= 3) {
            return $this->created_at->diffForHumans();
        }

        if ($this->created_at->isCurrentYear()) {
            return $this->created_at->format('m/d H:s');
        } else {
            return $this->created_at->format('Y/m/d');
        }
    }
}
