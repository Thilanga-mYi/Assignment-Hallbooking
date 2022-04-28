<?php

namespace App\Console\Commands;

use App\Models\License;
use App\Models\SMSModel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class LicenseExpire extends Command
{
    protected $smsModel;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'license:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind license expiring before two days';

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
        foreach (License::whereDate('expire', Carbon::now()->addDays(2))->with('userdatavianic')->get() as $key => $value) {
            error_log('Licence');
            if ($value['userdatavianic'] && $value['userdatavianic']->mobile) {
                $this->smsModel->send('Your license will expiring on ' . $value->expire, $value['userdatavianic']->mobile);
            }
        }

        return 0;
    }
}
