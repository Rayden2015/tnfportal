Test Email Features


nurudin@Nurudins-MacBook-Pro-3 tnfportal % php artisan tinker
Psy Shell v0.12.10 (PHP 8.1.32 — cli) by Justin Hileman
> Mail::raw('Test', function($m){ $m->to('nurundin2010@gmail.com')->subject('Test'); });