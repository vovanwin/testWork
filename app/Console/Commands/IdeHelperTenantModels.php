<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Tenant;
use DB;
use Illuminate\Console\Command;
use Str;

class IdeHelperTenantModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ide-helper:tenant-models';

    protected $description = 'Команда для ide хелпера внутри тенантов';

    public function handle(): int
    {
        $ulid = Str::ulid();
        $dbname = 'tenant'.$ulid;
        tenancy()->initialize(
            $tenant = Tenant::create(
                [
                    'id' => $ulid,
                    'data' => ["tenancy_db_name" => $ulid]
                ]
            )
        );
        $this->call(
            'ide-helper:models',
            [
                '--write' => true,
                '--reset' => true
            ],
        );
        $this->call('ide-helper:generate');
        $this->call('ide-helper:meta');

        tenancy()->end();
        DB::statement('DROP DATABASE'.' "'.$dbname.'" '.'WITH (FORCE)');
        DB::table('tenants')->where('id', $ulid)->delete();
        return Command::SUCCESS;
    }
}
