<?php

namespace App\Jobs;

use App\Models\sites;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp;

class ValidateDomain implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->validatedomain = '';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $que = sites::select('*')->orderBy('id', 'DESC')->where('status', 0)->get();
        foreach ($que as $k => $val) {
            if (filter_var($val->domain, FILTER_VALIDATE_URL)) {
                $res = \Http::get($val->domain);
                if ($res->getStatusCode() == 200) // 200
                {
                    sites::where('id', $val->id)->update(['status' => 1]);
                } else {
                    sites::where('id', $val->id)->update(['status' => 0]);
                }

            }
        }

    }
}
