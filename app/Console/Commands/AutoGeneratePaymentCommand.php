<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Models\Payment;
use Illuminate\Console\Command;

class AutoGeneratePaymentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $members = Member::all();

        foreach ($members as $member) {
            $checkPayment = Payment::where('year', date('Y'))->where('month', (int)date('m'))->where('member_id', $member->id)->first();

            if ($checkPayment === null) {
                Payment::create([
                    'member_id' => $member->id,
                    'year' => date('Y'),
                    'month' => (int)date('m'),
                    'amount' => config('variables.monthly_membership_price'),
                    'status' => 0
                ]);
            }
        }
        return 0;
    }
}
