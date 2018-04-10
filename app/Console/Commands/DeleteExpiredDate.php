<?php

namespace App\Console\Commands;

use App\VerifyUser;
use Illuminate\Console\Command;

class DeleteExpiredDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expiration code';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();


    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        VerifyUser::where('expired_date', '<', date('Y-m-d H:i:s'))->delete();
    }
}
