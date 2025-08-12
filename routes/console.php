<?php

use Illuminate\Support\Facades\Schedule;

// Schedule::command('app:check-pending-requests-for-bank')->everyTwoHours();
Schedule::command('app:order-status-command')->everyMinute()->onOneServer();

