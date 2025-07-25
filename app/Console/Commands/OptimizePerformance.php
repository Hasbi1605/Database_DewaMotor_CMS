<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class OptimizePerformance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:optimize-performance {--clear-cache : Clear all caches}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize application performance by running various optimization commands';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting performance optimization...');

        if ($this->option('clear-cache')) {
            $this->clearCaches();
        }

        // Optimize configuration
        $this->info('📝 Optimizing configuration...');
        Artisan::call('config:cache');

        // Optimize routes
        $this->info('🛣️  Optimizing routes...');
        Artisan::call('route:cache');

        // Optimize views
        $this->info('👁️  Optimizing views...');
        Artisan::call('view:cache');

        // Optimize autoloader
        $this->info('⚡ Optimizing autoloader...');
        Artisan::call('optimize');

        // Clear and warm up application cache
        $this->info('🔥 Warming up application cache...');
        $this->warmUpCache();

        $this->info('✅ Performance optimization completed!');

        $this->newLine();
        $this->info('💡 Performance Tips:');
        $this->line('- Run this command after deployment');
        $this->line('- Consider using Laravel Octane for better performance');
        $this->line('- Enable OPcache in production');
        $this->line('- Use Redis for caching and sessions');
    }

    /**
     * Clear all caches
     */
    private function clearCaches(): void
    {
        $this->info('🧹 Clearing caches...');

        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('clear-compiled');

        $this->info('✅ All caches cleared');
    }

    /**
     * Warm up application cache
     */
    private function warmUpCache(): void
    {
        // Cache categories
        Cache::remember('categories_all', 3600, function () {
            return \App\Models\Category::all();
        });

        // Cache available brands
        Cache::remember('available_brands', 1800, function () {
            return \App\Models\Kendaraan::where('status', 'tersedia')
                ->distinct()
                ->pluck('merek')
                ->sort();
        });

        // Cache price range
        Cache::remember('price_range_tersedia', 1800, function () {
            return [
                'min' => \App\Models\Kendaraan::where('status', 'tersedia')->min('harga_jual'),
                'max' => \App\Models\Kendaraan::where('status', 'tersedia')->max('harga_jual')
            ];
        });

        // Cache year range
        Cache::remember('year_range_tersedia', 1800, function () {
            return [
                'min' => \App\Models\Kendaraan::where('status', 'tersedia')->min('tahun_pembuatan'),
                'max' => \App\Models\Kendaraan::where('status', 'tersedia')->max('tahun_pembuatan')
            ];
        });

        $this->info('✅ Application cache warmed up');
    }
}
