<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FakeStoreSync;

class SyncFakeStore extends Command
{
    protected $signature = 'app:sync-fakestore {--limit=} {--sort=}';
    protected $description = 'Sincroniza categorías y productos desde Fake Store API';

    public function handle(FakeStoreSync $sync): int
    {
        try {
            $limit = $this->option('limit') ? (int)$this->option('limit') : null;
            $sort  = $this->option('sort')  ?: null; // asc|desc
            $sync->run($limit, $sort);
            $this->info('Sincronización OK');
            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            return self::FAILURE;
        }
    }
}
