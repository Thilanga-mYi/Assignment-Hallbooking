<?php

namespace App\Console\Commands;

use App\Models\SMSModel;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TicketReminder extends Command
{

    protected $smsModel;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticket:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending ticket expiring before two days';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->smsModel = (new SMSModel());
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach (Ticket::whereDate('expire', Carbon::now()->addDays(2))->with('licensedata')->get() as $key => $value) {
            if ($value['licensedata'] && $value['licensedata']['userdatavianic'] && $value['licensedata']['userdatavianic']->mobile) {
                $this->smsModel->send('Your ticket number (' . str_pad($value->id, 4, '0', STR_PAD_LEFT) . ') will expiring on ' . $value->expire . ', If expires you have to pay penelty chagers of LKR 500.00', $value['licensedata']['userdatavianic']->mobile);
            }
        }
        return 0;
    }
}
