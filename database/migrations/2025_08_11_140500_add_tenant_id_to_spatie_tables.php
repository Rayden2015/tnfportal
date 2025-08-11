<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tableNames = config('permission.table_names');
        $teamFk = config('permission.column_names.team_foreign_key');

        Schema::table($tableNames['roles'], function (Blueprint $table) use ($teamFk) {
            if (!Schema::hasColumn($table->getTable(), $teamFk)) {
                $table->unsignedBigInteger($teamFk)->nullable()->after('id');
                $table->index($teamFk, 'roles_tenant_foreign_key_index');
            }
        });

        Schema::table($tableNames['model_has_roles'], function (Blueprint $table) use ($teamFk) {
            if (!Schema::hasColumn($table->getTable(), $teamFk)) {
                $table->unsignedBigInteger($teamFk)->nullable()->after('model_id');
                $table->index($teamFk, 'model_has_roles_tenant_foreign_key_index');
            }
        });

        Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) use ($teamFk) {
            if (!Schema::hasColumn($table->getTable(), $teamFk)) {
                $table->unsignedBigInteger($teamFk)->nullable()->after('model_id');
                $table->index($teamFk, 'model_has_permissions_tenant_foreign_key_index');
            }
        });
    }

    public function down(): void
    {
        $tableNames = config('permission.table_names');
        $teamFk = config('permission.column_names.team_foreign_key');

        Schema::table($tableNames['roles'], function (Blueprint $table) use ($teamFk) {
            if (Schema::hasColumn($table->getTable(), $teamFk)) {
                $table->dropIndex('roles_tenant_foreign_key_index');
                $table->dropColumn($teamFk);
            }
        });

        Schema::table($tableNames['model_has_roles'], function (Blueprint $table) use ($teamFk) {
            if (Schema::hasColumn($table->getTable(), $teamFk)) {
                $table->dropIndex('model_has_roles_tenant_foreign_key_index');
                $table->dropColumn($teamFk);
            }
        });

        Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) use ($teamFk) {
            if (Schema::hasColumn($table->getTable(), $teamFk)) {
                $table->dropIndex('model_has_permissions_tenant_foreign_key_index');
                $table->dropColumn($teamFk);
            }
        });
    }
};


