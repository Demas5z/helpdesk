<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'company_email',
        'company_name',
        'asset_name',
        'asset_series',
        'description',
        'priority',
        'ticket_duration',
        'status',
        'start_date',
        'end_date',
        'due_date',
        'resolved_date'
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'due_date',
        'resolved_date'
    ];

    /**
     * Generate unique ticket number
     */
    public static function generateTicketNumber()
    {
        $prefix = '';
        switch (request()->input('priority')) {
            case 'low':
                $prefix = 'L';
                break;
            case 'medium':
                $prefix = 'M';
                break;
            case 'high':
                $prefix = 'H';
                break;
            case 'critical':
                $prefix = 'C';
                break;
        }

        $lastTicket = self::orderBy('id', 'desc')->first();
        $lastNumber = $lastTicket ? intval(substr($lastTicket->ticket_number, -3)) : 0;
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        
        return $prefix . $newNumber;
    }

    /**
     * Scope queries for different ticket statuses
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSolved($query)
    {
        return $query->where('status', 'solved');
    }

    public function scopeLate($query)
    {
        return $query->where('status', 'late');
    }

    /**
     * Check and update ticket status
     */
    public function checkAndUpdateStatus()
    {
        $now = Carbon::now();
        $dueDate = Carbon::parse($this->due_date);

        // Jika tiket sudah melebihi batas waktu
        if (($this->status === 'pending' || $this->status === 'open') && $now->greaterThan($dueDate)) {
            $this->status = 'late';
            $this->save();
        }

        // Jika tiket diselesaikan
        if ($this->status === 'solved') {
            $this->resolved_date = $now;
            $this->save();
        }
    }

    /**
     * Calculate ticket lifecycle statistics
     */
    public static function getTicketStatistics()
    {
        return [
            'total_tickets' => self::count(),
            'open_tickets' => self::open()->count(),
            'pending_tickets' => self::pending()->count(),
            'solved_tickets' => self::solved()->count(),
            'late_tickets' => self::late()->count(),
            'tickets_by_priority' => [
                'low' => self::where('priority', 'low')->count(),
                'medium' => self::where('priority', 'medium')->count(),
                'high' => self::where('priority', 'high')->count(),
                'critical' => self::where('priority', 'critical')->count(),
            ],
            'weekly_trend' => self::getWeeklyTicketTrend()
        ];
    }

    /**
     * Get weekly ticket trend
     */
    private static function getWeeklyTicketTrend()
    {
        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subDays(6);

        $trend = [];
        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            $trend[$date->format('Y-m-d')] = [
                'open' => self::whereDate('created_at', $date->format('Y-m-d'))->open()->count(),
                'solved' => self::whereDate('resolved_date', $date->format('Y-m-d'))->solved()->count()
            ];
        }

        return $trend;
    }
}