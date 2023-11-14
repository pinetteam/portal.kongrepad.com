<?php

namespace App\Models\Meeting\ScoreGame\Point;

use App\Models\Customer\Customer;
use App\Models\Meeting\ScoreGame\QRCode\QRCode;
use App\Models\System\Setting\Variable\Variable;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Point extends Model
{
    protected $table = 'meeting_score_game_points';
    protected $fillable = [
        'qr_code_id',
        'participant_id',
        'point',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected function createdAt(): Attribute
    {
        $date_time_format = Variable::where('variable', 'date_time_format')->first()->settings()->where('customer_id', Auth::user()->customer->id ?? Customer::first()->id)->first()->value;

        return Attribute::make(
            get: fn (string $createdAt) => Carbon::createFromFormat('Y-m-d H:i:s', $createdAt)->format($date_time_format),
            );
    }
    public function qrCode()
    {
        return $this->belongsTo(QRCode::class, 'qr_code_id', 'id');
    }
}
