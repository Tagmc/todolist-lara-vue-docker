<?php

namespace App\Console\Commands;

use App\Models\Todo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotifyUpComingTodos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:upcoming-todos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $todos = Todo::where('status', 'doing')
        ->whereNotNull('deadline')
        ->whereBetween('deadline', [now(), now()->addMinutes(5)])
        ->get();

    foreach ($todos as $todo) {
        Mail::to('huyqthp03@gmail.com')->send(new \App\Mail\TodoReminderMail($todo));
    }
    }
}
